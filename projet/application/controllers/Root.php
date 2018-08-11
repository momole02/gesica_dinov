<?php 

class Root extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('enterprise_model');
		$this->load->model('checkout_model');
		$this->load->library("gesica_sess_utils");
		$this->load->library('session');

		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		$this->load->model('checkout_model');

		$this->one_month_price = 10000;
	}


	private function auth()
	{
		if( !isset( $_SERVER['PHP_AUTH_USER'] ) ){
			header('HTTP/1.O 401 Unauthorized');
			header('WWW-Authenticate: Basic realm="Back office GESICA"');
			print'<h1>401 Unauthorized</h1>';
			return false;
		}else{
			$user = $_SERVER['PHP_AUTH_USER'];
			$pw = $_SERVER['PHP_AUTH_PW'];
	
			if( $user!='dinov' || $pw !== 'dinov' ){
				header('HTTP/1.O 401 Unauthorized');
				header('WWW-Authenticate: Basic realm="Back office GESICA"');
				return false;
			}else{
				return true;
			}
		}
		return false;
	}

	public function index()
	{
		if( $this->auth() ){
			$this->load->view('root_views/main');
		}
	}

	public function signup()
	{
		if( $this->auth() ){
			$this->load->view('root_views/signup');
		}
	}

	public function signup_request()
	{

		if( !$this->auth() )
			return ;

		$this->load->helper( array('form' , 'url') );
		$this->load->library('form_validation');

		$this->form_validation->set_rules( 'enterp-name',"Nom de l'entreprise" , "trim|required|min_length[3]|max_length[20]" );
		$this->form_validation->set_rules( 'enterp-own-lname',"Nom du propriétaire" , "trim|required|min_length[3]|max_length[20]" );
		$this->form_validation->set_rules( 'enterp-own-fname',"Prénom du propriétaire" , "trim|required|min_length[5]|max_length[30]" );

		$this->form_validation->set_rules( 'enterp-own-sex' , "Sexe" , "trim|required|min_length[1]|max_length[1]");
		$this->form_validation->set_rules( 'enterp-own-pseudo','Pseudo' , "trim|required|min_length[3]|max_length[10]");
		$this->form_validation->set_rules( 'enterp-own-tel' , 'Telephone du propriétaire' , 'trim|required|min_length[8]|max_length[8]' );
		$this->form_validation->set_rules( 'enterp-tel' , "Téléphone de l'entreprise" , 'trim|required|min_length[8]|max_length[8]');
		$this->form_validation->set_rules( 'enterp-own-passwd' , 'Mot de passe administrateur' , 'callback_password_check' );	

		if( $this->form_validation->run() === FALSE ){
			$this->load->view('root_views/signup');
		}else{

			/* lancer l'inscription (avec les requêtes post ) */
			$enterp_code = $this->enterprise_model->signup();

			/* recharger les données admin  */
			$admin_data = $this->enterprise_model->getbycode($enterp_code);
			
			/* rechager les données des caisses */
			$checkouts = $this->checkout_model->load_all_checkouts( $enterp_code ) ;

			$this->gesica_sess_utils->connect_admin( $admin_data , $checkouts );

			$this->load->view('root_views/enterp_accepted' , array( 'enterp_code' => $enterp_code ));
		}

	}

	public function password_check( $password )
	{

		if( !$this->auth() )
			return ;

		$conf_password = $this->input->post("enterp-own-passwd-conf");

		if( strlen($password) < 6 ){
			$this->form_validation->set_message( "password_check", "Le mot de passe doit avoir au moins 6 caractères" );
			return FALSE;
		}

		if( $password != $conf_password ){
			$this->form_validation->set_message( "password_check","Les mots de passes ne correspondent pas" );
			return FALSE;
		}
		return TRUE;
	}

	public function enterp_crud()
	{

		if( !$this->auth() )
			return ;

	         try{
	             $crud = new grocery_CRUD();

	             $crud->set_theme('flexigrid');
	             $crud->set_table('entreprise');
	             $crud->set_subject('Entreprises');
	            // $crud->required_fields('city');
	             $crud->display_as('id' , '#')
	             ->display_as('code_ent' , 'Code entreprise')
	             ->display_as('nom_pro_ent' , "Nom propriétaire")
	             ->display_as('pnom_pro_ent' , 'Prenom propriétaire')
	             ->display_as('nom_ent' , "Nom de l'entreprise ")
	             ->display_as('sex_pro_ent' , "Sexe du propriétaire ")
	             ->display_as('tel_ent' , "Téléphone de l'entreprise ")
	             ->display_as('tel_pro_ent' , "Téléphone de propriétaire ")
	             ->display_as('nom_ent' , "Nom de l'entreprise ");
	             
	             $crud->columns('code_ent','nom_ent', 'tel_ent' , 'nom_pro_ent', 'pnom_pro_ent','sex_pro_ent','tel_pro_ent' );

	             $output = $crud->render();

	             $this->_example_output($output);
	             
	         }catch(Exception $e){
	             show_error($e->getMessage().' --- '.$e->getTraceAsString());
	         }
	}


	
	private function _example_output($output = null)
	{
		$output->prev_link = base_url().'root/';
		$this->load->view('sadiicrudview.php',(array)$output );
	}

	public function subscriber_status()
	{
		if( !$this->auth() )
			return ;

		$this->load->view( "root_views/subscriber_status_form" );
	}

	public function subscriber_status_res( $enterp_code='' , $new_added = false)
	{
		
		if( !$this->auth() )
			return ;

		if( !empty( $enterp_code ) ){
			$enterp_data = $this->enterprise_model->getbycode( $enterp_code );
			$paid_deadlines = $this->enterprise_model->get_enterp_deadlines( $enterp_code );
			$subscriber_info = array( 'enterp_data' => $enterp_data  , 'paid_deadlines' => $paid_deadlines );

			$this->load->view( "root_views/subscriber_status_res" , 
				array( 	'subscriber_info' =>  $subscriber_info , 
						'new_added' => $new_added) );			
		}else{
			$this->load->view( "root_views/subscriber_status_res" , 
				array( 'new_added' => $new_added ));
		}
	}

	public function subscriber_status_request( )
	{
		if( !$this->auth() )
			return ;

		$this->load->library("form_validation");

		$this->form_validation->set_rules("enterp-code" , "Code de l'entreprise" , "required|trim|min_length[3]");

		if( $this->form_validation->run() == FALSE )
			$this->load->view( "root_views/subscriber_status_form" );
		else{
			$enterp_code = $this->input->post("enterp-code");

			$enterp_data = $this->enterprise_model->getbycode( $enterp_code );
			$paid_deadlines = $this->enterprise_model->get_enterp_deadlines( $enterp_code );
			$subscriber_info = array( 'enterp_data' => $enterp_data  , 'paid_deadlines' => $paid_deadlines );

			$this->load->view( "root_views/subscriber_status_res" , array( 'subscriber_info' =>  $subscriber_info) );
		}
	}

	public function renew_agree_request( )
	{
		if( !$this->auth() )
			return ;

		$this->load->library("form_validation");

		$this->form_validation->set_rules("nb-months" , "Nombre de mois" , "required|trim|integer");
		$this->form_validation->set_rules("enterp-code" , "Code entreprise" , "required|min_length[3]");

		if( $this->form_validation->run()==FALSE ){
			$this->load->view("root_views/subscriber_status_res");
		}else{

			$nb_months = (int)$this->input->post("nb-months");
			$enterp_code = $this->input->post("enterp-code");

			if( $nb_months>0  ){

				$dl_begin_date=strftime("%Y-%m-%d"); 	/* date de début de l'échéance */
				$time = strtotime("+$nb_months months");
				$dl_end_date=strftime("%Y-%m-%d" , $time);
				$dl_price = $nb_months * $this->one_month_price;

				$this->enterprise_model->add_deadline( $enterp_code , 
					array(  
						'debut_ech'	=> $dl_begin_date,
						'fin_ech' 	=> $dl_end_date,
						'prix_ech' 	=> $dl_price
					)
				);  

				$this->subscriber_status_res( $enterp_code , true);

			}
		}
	}

	public function drop_deadline( $index=-1 )
	{
		if( !$this->auth() )
			return ;

		if( $index>0 ){

			$enterp_code = $this->enterprise_model->get_enterp_code_by_dlid( $index );

			$this->enterprise_model->drop_deadline_by_id( $index );

			$this->subscriber_status_res( $enterp_code );
		}else{
			header('Location:'.base_url().'root/');
		}
	}

	public function close()
	{
		header('HTTP/1.O 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="Back office GESICA"');		
	}
	
}
