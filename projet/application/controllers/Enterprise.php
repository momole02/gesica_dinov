<?php 
/*
	Enterprise.php - Controleur de gestion de l'entreprise 

	(C) SADII 2018
*/

class Enterprise extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("enterprise_model"); /* charger le modèle de gestion des entreprises */
		$this->load->model("checkout_model");	/* charger le modèle de gestion des caisses */
		$this->load->library("gesica_sess_utils"); /* charger la librairie perso de manipulation des sessions */
		$this->load->library("gesica_config"); /* configurations */
		$this->load->library("gesica_utils");
	}

	/**
		@brief Affiche le formulaire d'édition des attributs de l'entreprise
	*/
	public function edit_attributes()
	{

		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}
		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /*si on est en mode admin*/

		
			/* Afficher le formulaire */
			$this->load->view("template/edit_attributes" , 
				
				/*en y transmettant des données admin depuis les sessions*/
				array( 'admin_data' => $this->gesica_sess_utils->get_admin_data() )  );
			
		}else{
			header('Location: '.base_url().'home/'); /* si ce n'est pas le cas retourner à l'accueil */
		}
	}

	/**
		@brief Effectue la requête de changement des attributs de l'entreprise
	*/	
	public function edit_request()
	{

		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){  /* Si on est en mode admin */
		
			$this->load->helper( array("url" , "form") ); /* charger les helpers de gestion d'URL et de formulaire */

			$this->load->library("form_validation"); /* la libraire de validation de formulaire */

			/* Affecter les règles de validation */
			$this->form_validation->set_rules( 'enterp-name',"Nom de l'entreprise" , "trim|required|min_length[3]|max_length[20]" );
			$this->form_validation->set_rules( 'enterp-own-lname',"Nom du propriétaire" , "trim|required|min_length[3]|max_length[20]" );
			$this->form_validation->set_rules( 'enterp-own-fname',"Prénom du propriétaire" , "trim|required|min_length[5]|max_length[30]" );
			$this->form_validation->set_rules( 'enterp-own-sex' , "Sexe" , "trim|required|min_length[1]|max_length[1]");
			$this->form_validation->set_rules( 'enterp-own-pseudo','Pseudo' , "trim|required|min_length[3]|max_length[10]");
			$this->form_validation->set_rules( 'enterp-own-tel' , 'Telephone du propriétaire' , 'trim|required|min_length[8]|max_length[8]' );

			$this->form_validation->set_rules( 'enterp-tel' , "Téléphone de l'entreprise" , 'trim|required|min_length[8]|max_length[8]');
			$this->form_validation->set_rules( 'enterp-adress' , "Adresse de l'entreprise" , 'trim|required|min_length[8]');
			$this->form_validation->set_rules( 'enterp-open-time' , "Heure d'ouverture" , 'trim|required');
			$this->form_validation->set_rules( 'enterp-close-time' , "Heure de fermeture" , 'trim|required' );

			$admin_data = $this->gesica_sess_utils->get_admin_data();

			if( $this->form_validation->run() == FALSE ){ /* Lorsque la validation échoue */

				/* on retourne sur le formulaire et on affiche les erreurs  */
				$this->load->view('template/edit_attributes' , array( 'admin_data' => $admin_data ) );

			}else{

				/* renseigner les informations à mettre dans la base d edonnées */
				$data = array(
					'nom_ent' => trim($this->input->post("enterp-name")), 				/* nom de l'entreprise */
					'nom_pro_ent' => trim($this->input->post("enterp-own-lname")), 		/* nom du propriétaire */
					'pnom_pro_ent' => trim($this->input->post("enterp-own-fname")), 	/* prénom du propriétaire */
					'desc_ent' => $this->input->post("enterp-desc"),					/* description de l'entreprise */
					'sexe_pro_ent' => trim($this->input->post("enterp-own-sex")),		/* sexe du propriétaire */
					'pseudo_adm_ent' => trim($this->input->post("enterp-own-pseudo")), 	/* pseudo du propriétaire */
					'tel_pro_ent' => trim($this->input->post("enterp-own-tel")),		/* tel du propriétaire */
					'tel_ent' => trim($this->input->post("enterp-tel")),					/* tel de l'entreprise */
					'adresse' => $this->input->post('enterp-adress'),
					'heure_ouverture' => $this->input->post('enterp-open-time'),
					'heure_fermeture' => $this->input->post('enterp-close-time')
				);

				/*mettre à jour la base de données avec nos nouvelles données*/
				$this->enterprise_model->update( $admin_data->code_ent , $data );

				/* recharger les données de l'entreprise*/
				$conn_data = $this->enterprise_model->getbycode( $admin_data->code_ent );

				/*recharger les caisses*/
				$checkouts = $this->checkout_model->load_all_checkouts( $admin_data->code_ent );

				/*mettre à jour les données admin au niveau session */
				$this->gesica_sess_utils->connect_admin( $conn_data, $checkouts );

				/* retourner sur le panel principal */
				header('Location: '.base_url().'home/main_panel');
			}
		}else{ /* au cas ou l'on est pas en mode admin ... */
			header('Location: '.base_url().'home/'); /* retourner à  l'accueil */
		}
	}


	/**
		@brief Affiche le formulaire d'édition du mot de passe
	*/
	public function edit_password()
	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){/*le mode admin est-il activé ?*/
			
			/* afficher le formulaire d'édition du mot de passe */
			$this->load->view("template/edit_password");

		}else{
			/*si ce n'est pas le cas retourner à  l'accueil */
			header('Location: '.base_url().'home/');			
		}
	}

	/**
		@brief requête de changement de mot de passe
	*/
	public function edit_password_request()
	{
		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /*si l'on est en mode admin */
			
			$admin_data = $this->gesica_sess_utils->get_admin_data(); /* récuperer les données admin */

			/*charger librairie formulaire + helpers*/
			$this->load->helper( array("url" , "form") );
			$this->load->library( "form_validation" );

			/* renseigner les règles de validation */
			$this->form_validation->set_rules("enterp-own-ex-passwd" ,"ancien mot de passe","callback_ex_pass_check");
			$this->form_validation->set_rules("enterp-own-passwd" , "nouveau mot de passe" , "required|min_length[6]");
			$this->form_validation->set_rules("enterp-own-passwd-conf" ,"confirmation nouveau mot de passe" ,"callback_new_pass_check");

			/*Lancer la validation*/
			if( $this->form_validation->run() == FALSE ){ /* si elle echoue */

				/* retourne sur le formulaire pour afficher les erreurs */
				$this->load->view("template/edit_password");
			}else{
				/* hash du mot de passe*/
				$passwd = hash( 'sha384' , $this->input->post("enterp-own-passwd") );

				/* mise à jour */
				$this->enterprise_model->set_password( $admin_data->code_ent, $passwd );

				/* retourne au panel admin */
				header('Location: '.base_url().'home/main_panel');
			}

		}else{ /*si l'on est pas en admin*/
			
			/* retourner à l'accueil */
			header('Location: '.base_url().'home/');

		}
	}

	/**
		@brief Fonction de rappel de verification de l'ancien mot de passe

		@param passwd ancien mot de passe fourni depuis le formulaire
	*/
	public function ex_pass_check( $passwd )
	{
		$adm_data = $this->gesica_sess_utils->get_admin_data(); /* recupérer les données admin depuis les sessions */

		$hashed_ex_passwd  = hash( 'sha384' ,$passwd ); /* hash du mot de passe fourni */
		$current_hashed_passwd = $adm_data->mdp_adm_ent; /* hash du veritable ancien mot de passe */

		if( $hashed_ex_passwd != $current_hashed_passwd ){ /* si les deux ne correspondent pas */
			
			/* ... mon chèr ami retourne sur le formulaire */
			$this->form_validation->set_message("ex_pass_check" , "L'ancien mot de passe est incorrect");
			return FALSE;
		
		}

		return TRUE;
	}

	/**	
		@brief Fonction de rappel de verification du nouveau mot de passe 
	*/
	public function new_pass_check( $passwd )
	{
		/*recupérer la confirmation */
		$passwd_conf = $this->input->post("enterp-own-passwd-conf");

		if( $passwd != $passwd_conf ){ /*si le mot de passe ne correspond pas à la confirmation*/

			/* retourne sur le formulaire */
			$this->form_validation->set_message("new_pass_check" , "Les mots de passes de correspondent pas");
			return FALSE;

		}

		return TRUE;
	}


	/*
		@brief Affecte un logo 
	*/
	public function set_logo()
	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /* Lorsqu'on est en mode admin */

			/* voir la doc sur la libraire 'upload' */
			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'png|gif|jpg|jpeg';
			$config['max_size'] = 5*1024*1024; /* 5 Mo max */
			$config['max_width'] = 600;
			$config['max_height'] = 600;

			$this->load->library("upload" , $config);

			if( $this->upload->do_upload("enterp-logo") ){ /* lancer l'upload */


				$data = $this->upload->data(); 
				$admin_data = $this->gesica_sess_utils->get_admin_data(); /* les données de l'admin */
				/*demander au model d'affecter les données brutes du logo au logo de l'entreprise actuellement connectée */
				$this->enterprise_model->set_logo( $admin_data->code_ent , basename($data['full_path']) );  

				/* recharger les données de (str)'admin */
				$admin_data = $this->enterprise_model->getbycode( $admin_data->code_ent );
				$this->gesica_sess_utils->connect_admin( $admin_data , $this->gesica_sess_utils->get_all_checkouts() );

				header('Location:'.base_url().'home/');
			}else{
				/* afficher le panel avec toutes les caisses */
					$this->load->view("template/main_panel" , 
					array( 	'upload_error_logo' => $this->upload->display_errors(),
							'admin_data' => $this->gesica_sess_utils->get_admin_data(),
							'checkouts' => $this->gesica_sess_utils->get_all_checkouts(),
							'logo_image_path' => $this->gesica_sess_utils->get_logo_image_path()
							 ));
			}


		}	
		else{ /* Lorsqu'on est pas en mode admin */
			header('Location:'.base_url().'home/');
		}
	}

	function config()
	{
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}


		$this->load->view("template/config_form_view" , array(
			'paper_format' => $this->gesica_config->paper_format_desc(),
			'mark' => $this->gesica_config->get_bill_mark_text()
		));
		
	}	

	function config_setup()
	{

		if( $this->gesica_sess_utils->is_admin_mode_enabled() ) {

			$this->load->library("form_validation");

			$this->form_validation->set_rules("enterp-cf-bill-format" , "Format facture" , "required");
			$this->form_validation->set_rules("enterp-cf-mark" , "Signature" , "min_length[5]");

			if( $this->form_validation->run() == FALSE ){
				$this->load->view("template/config_form_view.php");
			}else{
				$this->gesica_config->set_bill_page_format( $this->input->post("enterp-cf-bill-format") );
				$this->gesica_config->set_bill_mark_text( $this->input->post("enterp-cf-mark") );
				$this->gesica_config->update_current_config(); 
				header('Location:'.base_url().'home/');
			}
		}else{
			header('Location:'.base_url().'home/');
		}
	}

	public function notifications( $index=-1 )
	{
		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){
		
			$cache = $this->gesica_utils->load_cache();

			if( $index==-1 || $index > count($cache)-1 ){ 	/* tout afficher */
				$this->load->view("template/notifications_view" , array( "notifs" => $cache ));
				$this->gesica_utils->clear_cache();
			}else{
				$this->load->view("template/notifications_view" , array("notifs" => array( $cache[$index] )));
				$this->gesica_utils->drop_cache_entry( $index );
			}	
		}
	} 
}

