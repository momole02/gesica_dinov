<?php

/*
	Home.php - Controlleur de gestion de l'accueil
*/
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");

		$this->load->model("enterprise_model");
		$this->load->model('checkout_model');
		$this->load->library("gesica_utils");
		$this->load->library("gesica_sess_utils");
	}

	/**
		@brief Méthode d'index appelée lors de localhost/gesica_repo/home/
	*/
	public function index()
	{
		if( !$this->gesica_sess_utils->is_admin_mode_enabled() ){ /* Si l'on est pas en mode admin */

			/* et qu'on est  passé en mode connexion caisse */
			if( $this->gesica_sess_utils->is_checkout_mode_enabled()) {

				if( $this->gesica_sess_utils->has_checkout_logged() ){ /* si une caisse est déja connectée */

					if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
						header('Location:'.base_url().'roardloff/');
						return ; 
					}

					/* Afficher le panel de gestion de caisse */
					$this->load->view("template/checkout_panel" , array( 'checkout_logged' => $this->gesica_sess_utils->get_logged_checkout() ));

				}else{ /* si aucune caisse n'est connectée */
					/* Afficher le panel de connexion de caisse */
					$this->load->view("template/checkout_login" , array( 'enterp_name'=>$this->gesica_sess_utils->get_enterprise_name() ));
				}
				
			}else{
				header('Location:'.base_url().'home/login/');
			}
		}else{
			
			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}

			/* afficher le panel administrateur */
			$this->load->view("template/main_panel" , 
					array( 	'admin_data' => $this->gesica_sess_utils->get_admin_data(),
							'checkouts' => $this->gesica_sess_utils->get_all_checkouts(),
							'logo_image_path' => $this->gesica_sess_utils->get_logo_image_path(),
							'notifs'=> $this->gesica_utils->load_cache()
							 ));
		}
	}

	
	/**
		@brief Déconnecte l'admin
	*/
	public function logout()
	{
		$this->session->sess_destroy(); /*detruit la session*/
		setcookie("gesica-enterp-code" , "", time()-7*24*3600 , "/" , "" , false , true);
	 	setcookie("gesica-enterp-pseudo","" , time()-7*24*3600  , "/" , "" , false , true);
	 	setcookie("gesica-enterp-pw" , "", time()-7*24*3600 , "/" , "" , false , true);
 		$this->load->view("template/login"); /* affiche le panel de login */
	}
	
	/**
		@brief Affiche le panel admin
	*/
	public function main_panel()
	{
		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /* Lorsqu'on est en admin */

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}

			/* afficher le panel admin */
			$this->load->view("template/main_panel" , 
			array( 	'admin_data' => $this->gesica_sess_utils->get_admin_data(), /* en renseignant les données admin(sessions) */
					'checkouts' => $this->gesica_sess_utils->get_all_checkouts(), /* en renseigneant les caisses */
					'logo_image_path' => $this->gesica_sess_utils->get_logo_image_path(), /* et biensur le logo ;) */
					'notifs' => $this->gesica_utils->load_cache()
				 ));

		}else{ /* Si l'on est pas en admin */
			if( $this->gesica_sess_utils->is_checkout_mode_enabled() ){ /* et qu'on est en mode caisse */

				$this->load->view('template/login' , array('partial_login' => 1));	 /* afficher le formulaire de connexion partiel(avec que le champ de mot de passe) */
			}else /*sinon*/
				$this->load->view('template/login'); /* login normal */
		}
	}

	/**
		@brief Affiche le formulaire du login
	*/
	public function login()
	{
		$vars = array();

		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /* mode admin ? */

			header('Location:'.base_url().'home/main_panel');

		}elseif( $this->gesica_sess_utils->has_checkout_logged() ){ /* caisse connectée ? */

			header('Location:'.base_url().'checkout/checkout_panel'); 

		}else { /*sinon*/


			if( $this->input->get("connection_attempt")==='1' ) /*s'il y a eu une erreur de connexion */
				$vars['connection_error']='1'; 
			
			if( $this->gesica_sess_utils->is_checkout_mode_enabled() ) /* mode caisse */
				$vars['partial_login']='1';
			else{
				if( isset( $_COOKIE['gesica-enterp-code'])   &&
					isset( $_COOKIE['gesica-enterp-pseudo']) && 
					isset( $_COOKIE['gesica-enterp-pw'] )   ){
					/* connexion par cookies */
					$code = 	$_COOKIE['gesica-enterp-code'];
					$pseudo = 	$_COOKIE['gesica-enterp-pseudo'];
					$pw = 		$_COOKIE['gesica-enterp-pw'];
					$conn_data =$this->enterprise_model->try_connection_no_hash( $code, $pseudo , $pw );
					
					if( $conn_data != null ){
						$admin_data = $conn_data[0];
						$checkouts = $this->checkout_model->load_all_checkouts( $code );
						$this->gesica_sess_utils->connect_admin( $admin_data , $checkouts );
						$this->gesica_sess_utils->enable_checkout_mode(  ); /* passer en mode caisse */

						header('Location:'.base_url().'home/');
						return ; 
					}
				}
			}

			$this->load->view("template/login" , $vars);
		}
	}

}

