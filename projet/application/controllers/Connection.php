 <?php 

 /* Connection.php - Controleur de gestion des connexion */

 class Connection extends CI_Controller
 {
 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model('enterprise_model');
 		$this->load->model('checkout_model');
 		$this->load->library("session");
 		$this->load->library("form_validation");
 		$this->load->helper(array("form"));

 		
 		$this->load->library("gesica_sess_utils");

 	}


 	public function connect()
 	{
 		

 		/*Est-on en mode admin ?*/
 		if( $this->gesica_sess_utils->is_admin_mode_enabled()){
 		
 			header('Location:'.base_url().'home/main_panel'); /* si oui on le redirige vers le main_panel*/
 		
 		}elseif( $this->gesica_sess_utils->is_checkout_mode_enabled() ){ /* mode caisse activé ?*/

 			/* si oui alors cela doit venir d'un formulaire minimal avec uniquement que le mot de passe 
 			pour passer en admin */

 			$this->go_to_admin_mode() ;

 		}else{	/* Il s'agit d'une nouvelle connexion */

 			$this->connect_enterprise(); 	
 		}
 	}

 
 	private function go_to_admin_mode()
 	{

		/*définir les regles de validation*/
		$this->form_validation->set_rules("enterp-own-passwd" , "Mot de passe admin","trim|required|min_length[6]");

		if( $this->form_validation->run()==FALSE ){ /* lancer le processus de validation */

			$this->load->view("template/login",array("partial_login" => "1"));

		}else{

			$hashed_admin_password = $this->session->userdata("hashed_admin_password");
			$hashed_curr_password = hash('sha384' , $this->input->post("enterp-own-passwd") );

			/* verifier le mot de passe */ 				
			if( $hashed_admin_password != $hashed_curr_password ){
					header('Location:'.base_url().'home/login?connection_attempt=1');
			}else{
				/*s'il correspond au mot de passe admin ... */
				
				 /* on recupère le code de l'entreprise */
				$enterp_code = $this->session->userdata("enterp_code") ;

				/* on charge l'entreprise de puis la BDD  */
				$admin_data = $this->enterprise_model->getbycode($enterp_code);

				/*on charge toutes les caisses*/
				$checkout_data = $this->checkout_model->load_all_checkouts($admin_data->code_ent); 

				/*et hop on le connecte*/
				$this->gesica_sess_utils->connect_admin( $admin_data , $checkout_data );

				header('Location:'.base_url().'home/main_panel');
			}

		}
 	}

 	private function connect_enterprise()
 	{
 	

 		/*définir les règles de validation du formulaire*/
 		$this->form_validation->set_rules("enterp-code" , "Code de l'entreprise" , "trim|required|min_length[10]");
	 	$this->form_validation->set_rules("enterp-own-pseudo" , "Pseudo" , "trim|required|min_length[3]|max_length[10]" );
	 	$this->form_validation->set_rules("enterp-own-passwd" , "Mot de passe admin" , "trim|required|min_length[6]"); 

	 	/*lancer la validation*/
	 	if( $this->form_validation->run() === FALSE ){ /*en cas d'erreur, retourner sur le formulaire et lui montrer les erreurs*/
	 		$this->load->view("template/login"); 
	 	}  else{

	 		list( $code , $pseudo , $passwd ) = array(
	 			trim( $this->input->post("enterp-code") ),
	 			trim( $this->input->post("enterp-own-pseudo") ),
	 			trim( $this->input->post("enterp-own-passwd") )
	 		);

	 		/*récupérer depuis la BDD une entreprise ayant ces attributs*/
	 		$conn_data =$this->enterprise_model->try_connection( $code , $pseudo , $passwd ); 

	 		if( is_array( $conn_data ) ){ /* Les données correspondeant*/

	 			/* lancer le processus de connexion */

	 			$admin_data = $conn_data[0];/* prendre juste le 1er resultat qui correspond */

				/*on charge toutes les caisses*/
				$checkout_data = $this->checkout_model->load_all_checkouts($admin_data->code_ent); 

				/*connecter l'admin*/
	 			$this->gesica_sess_utils->connect_admin( $admin_data , $checkout_data );

	 			if( isset( $_POST['enterp-stay-alive'] ) ){ /* enregistrer les cookies */

	 				setcookie("gesica-enterp-code" , $this->input->post("enterp-code") , time()+7*24*3600 , "/" , "" , false , true);
	 				setcookie("gesica-enterp-pseudo" , $this->input->post("enterp-own-pseudo") , time()+7*24*3600  , "/" , "" , false , true);
	 				setcookie("gesica-enterp-pw" , hash("sha384",$this->input->post("enterp-own-passwd")) , time()+7*24*3600 , "/" , "" , false , true);

	 			}

	 			header('Location: '.base_url().'home/main_panel');
	 		}else{
	 			header('Location: '.base_url().'home/login?connection_attempt=1');
	 		}
	 	}	
 	}

 }