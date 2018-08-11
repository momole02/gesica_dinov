 <?php 


 /*
 	Checkout.php - Controlleur de gestion des caisses 

 	(C) SADII 2018 
 */



 class Checkout extends CI_Controller
 {
 	public function __construct()
 	{
 		parent::__construct();

 		$this->load->helper(array("url","form"));	/*charger la prise en charge des URL + Formulaires*/
 		$this->load->library("session");			/* Charger la prise en charge des sessions */	
 		
 		$this->load->library("gesica_sess_utils");	/* Charger les fonctions utilitaires des sessions  */
 		$this->load->library("gesica_docs_utils"); 	/* Charger les fonctions de génération des états de sorties */
 		$this->load->library("gesica_utils");
 		$this->load->model("checkout_model");		/* Modèle de gestion des caisses */
 		$this->load->model("operation_model"); 		/* Charger le modèle des opérations */
 	}


 	/** 
 		@brief affiche le panel des caisses
 	*/
 	public function checkout_panel()
 	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}
 		if( $this->gesica_sess_utils->has_checkout_logged() ) /* si une caisse est connectée */
 		{
 			/* afficher le panel des caisse  */
 			$this->load->view("template/checkout_panel" , 
 				array(
 					/* transmettre les données de caisse */
 					"checkout_logged" => $this->gesica_sess_utils->get_logged_checkout() 
 				) );
 		}else{
 			/* on retourne à l'accueil*/
 			header('Location:'.base_url().'home/');
 		}
 	}

 	/**
 		@brief affiche le formulaire de nouvelle caisse
 	*/
	public function new_checkout()
	{
		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /* si on est en mode admin */

			/* afficher le formulaire */
			$this->load->view("template/new_checkout");
		}else{
			/* retourner à l'accueil */
			header('Location:'.base_url().'home/');
		}
	}

	/** 
		@brief lance la requête de création de nouvelle caisse
	*/
	public function new_checkout_request()
	{

		if( $this->gesica_sess_utils->is_admin_mode_enabled()  ){ /* si on est en mode admin */


			$this->load->library("form_validation");	/* charger la lib de validationd des formulaire */

			$admin_data =  $this->gesica_sess_utils->get_admin_data();
			
			/*Affecter les règles (voir la doc de la libraire form_utilisation pour plus de détails)*/
			$this->form_validation->set_rules("checkout-user-lname","Nom du gestionnaire","required|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("checkout-user-fname","Prénom du gestionnaire","required|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("checkout-number" , "Num de caisse" , "callback_checkout_number_check");
			$this->form_validation->set_rules("checkout-pseudo" , "Pseudo de caisse" , "callback_checkout_pseudo_check");
			$this->form_validation->set_rules("checkout-password" , "Mot de passe" , "required|min_length[6]");
			$this->form_validation->set_rules("checkout-password-conf" , "Confirmation du mdp", "callback_checkout_password_check");

			if( $this->form_validation->run() === FALSE ){ /* lorsque la validation échoue */
				$this->load->view("template/new_checkout"); /* réafficher le formulaire en précisant les erreurs */
			}else{

				/* on créer le tableau contenant les valeurs des champs de la table Caisse */
				$data = array(
					'num_caisse' 	=> $this->input->post("checkout-number"), 		/* numéro de la caisse */
					'code_ent' 		=> $admin_data->code_ent,						/* le code de l'entreprise */
					'nom_caisse' 	=> $this->input->post("checkout-user-lname"),	/* le nom du gestionnaire */
					'pnom_caisse' 	=> $this->input->post("checkout-user-fname"),	/* le prénom du gestionnaire */
					'pseudo_caisse' => trim($this->input->post("checkout-pseudo")),	/* le pseudo du gestionnaire */
					'mdp_caisse' 	=> hash( 'sha384' , $this->input->post("checkout-password") )	/* le mot de passe hashé sha384 */
				);

				/* demander au modèle de créer une caisse avec nos données */
				$this->checkout_model->new_checkout( $data );
				
				/* recharger la totalité des caisses dans les sessions puisqu'une 
				mise à jour à eu lieu */
				$this->gesica_sess_utils->reload_checkouts( $admin_data->code_ent );

				/* retourner sur le panel admin */
				header('Location:'.base_url().'home/main_panel');
			}
		}else{ /* si l'on est pas en admin on retourne à l'accueil */
			header('Location:'.base_url().'home/');
		}
	}

	/*
		@brief efface une caisse 

		@param index indice de la caisse au niveau de la session
		(tableau retourné par Gesica_sess_utils::get_all_checkouts())

	*/
	public function drop_checkout( $index )
	{
		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		if( $this->gesica_sess_utils->is_admin_mode_enabled() ) { /* si l'on est en mode admin*/

			/*recupérer toutes les caisses*/
			$checkouts = $this->gesica_sess_utils->get_all_checkouts();

			/* recupérer les données de l'admin */
			$admin_data = $this->gesica_sess_utils->get_admin_data();

			if( $index >= 0 && $index < count($checkouts) ){ /* verifier la validité de l'index */

				$checkout_code = $checkouts[$index]->code_caisse; /* chercher le code de la caisse */
				$this->checkout_model->drop_checkout( $checkout_code );  /*demander au modèle d'effacer la caisse*/

				/* recharger toutes les caisses puisqu'il y a eu mise à jour de la base de données*/
				$this->gesica_sess_utils->reload_checkouts( $admin_data->code_ent );
				
			}
		}
		/* 	retourner au panel admin 
			(si l'on est pas en admin, on sera rédirigé vers l'écran de connexion) */
		header('Location:'.base_url().'home/main_panel');

	} 

	/*
		@brief effectue une connexion de caisse
	*/
 	public function connect()
 	{

 		if( 	!$this->gesica_sess_utils->has_checkout_logged() 	/* 	si aucune caisse n'est connectée */
 			&& 	 $this->gesica_sess_utils->is_checkout_mode_enabled() ) /* mode caisse activé(admin déconnecté) */
 		{

 			/* charger la lib de validation de formulaire */
	 		$this->load->library("form_validation");

	 		/*regles de validation du formulaire (voir la doc pour plus de détails) */
	 		$this->form_validation->set_rules("checkout-user-pseudo" , "Pseudo" , "required|min_length[4]|max_length[10]");
	 		$this->form_validation->set_rules("checkout-user-passwd" , "Mot de passe" , "required|min_length[6]" );
	 		

	 		if( $this->form_validation->run() == FALSE ){ /* Si la validation échoue */

	 			/* réafficher l'écran du login avec les erreurs   */
	 			$this->load->view( "template/checkout_login",   

	 				/* transmettre le nom de l'entreprise pour qu'il puisse être affiché de nouveau */
	 				array("enterp_name" => $this->gesica_sess_utils->get_enterprise_name()
	 			) );

	 		}else{ /* la validation à reussi */


	 			$enterp_code = $this->gesica_sess_utils->get_enterprise_code(); /*récupérer le code de l'entreprise*/
	 			$user = trim( $this->input->post("checkout-user-pseudo") ); 	/*le pseudo dépuis le formulaire*/
	 			$password = trim( $this->input->post("checkout-user-passwd") ); /* le mot de passe depuis le formulaire */

	 			/*demander au modèle de nous trouver une caisse qui correspond à nos informations*/
	 			$checkout = $this->checkout_model->try_connection( $enterp_code , $user , $password );
	 			
	 			if( !is_null($checkout ) ){ /* données trouvées */

	 				$this->gesica_sess_utils->connect_checkout( $checkout ); /*connecter la caisse*/

 					/* TODO : envoyer une opération de connexion de caisse */
 					$this->gesica_utils->register_checkout_login_operation();

	 				header('Location:'.base_url().'checkout/checkout_panel'); /* aller vers le panel de caisse */
	 			}else{
	 				/* signaler un échec de connexion */
	 				header('Location:'.base_url().'checkout/login?connection_attempt=1'); 
	 			}
	 		}	
 		}else{
 			header('Location:'.base_url().'checkout/checkout_panel');
 		}
 	}

 	/*
 		@brief affiche le formulaire de login de caisse
 	*/
 	public function login()
 	{
 		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

 		if( !$this->gesica_sess_utils->has_checkout_logged() && /* si aucune caisse n'est connecté */
 			 $this->gesica_sess_utils->is_admin_mode_enabled() ){ /*premier passage en mode caisse(mode admin encore actif)*/

 			/* activer le mode caisse */
 			$this->gesica_sess_utils->enable_checkout_mode();

 		}else{ /* déja connecté */

 				if($this->gesica_sess_utils->has_checkout_logged()) /*si déja connecté*/
 					header("Location:".base_url().'checkout/checkout_panel'); /* retourner au panel */
 				else /* confus !  */
 					header('Location'.base_url().'home/'); /* retourner à l'accueil */
 				
 		}

 		/*afficher le formulaire de connexion de caisse*/
 		$this->load->view("template/checkout_login" , array(
 			
 			/* transmettre le nom de l'entreprise pour l'afficher */
 			"enterp_name" => $this->gesica_sess_utils->get_enterprise_name() ,

 			/* s'il y a une erreur il faudrait l'afficher*/
 			"connection_error" => $this->input->get("connection_attempt")==='1' ? '1' : '0'  ) ); 
 	}

 	/**
 		@brief déconnecte une caisse
 	*/
 	public function logout()
 	{

 		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* si une caisse est connectée */

 			/* TODO : envoyer une opération de ferméture de caisse */
 			$this->gesica_utils->register_checkout_loggout_operation();

 			/* déconnecter = supprimer les variables de session */
 			$this->gesica_sess_utils->disconnect_checkout(); 

 			/*retourner à l'écran de connexion*/
 			header('Location:'.base_url().'checkout/login');
 		}else{ /* si aucune caisse n'est connectée */

 			/* retourner à l'accueil*/
 			header('Location:'.base_url().'home/'); 
 		}
 	}

 	/**
 		@brief affiche le formulaire d'édition des attributs d'une caisse
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

 		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* si une caisse est connectée */

 			/* afficher le formulaire d'édition */
 			$this->load->view("template/ck_edit_attributes_form" , 

 				/* 	... et transmettre les informations sur la caisse connectée, 
 					afin de remplir les champs */
 				array("checkout" => $this->gesica_sess_utils->get_logged_checkout()));

 		}else{ /* sinon retourner à l'accueil */
 			header('Location:'.base_url().'home/'); 
 		}
 	}

 	/**
 		@brief effectue la requête d'édition des attributs de caisse(met à jour la BDD)
 	*/
 	public function edit_attributes_request()
 	{
 	
 		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* si une caisse est connectée */

 			$this->load->library("form_validation"); /* charger la lib de validation de formulaire */
 			
 			/*Renseigner les règles(voir doc)*/
			$this->form_validation->set_rules("checkout-user-lname","Nom du gestionnaire","required|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("checkout-user-fname","Prénom du gestionnaire","required|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("checkout-pseudo" , "Pseudo de caisse" , "callback_checkout_edit_pseudo_check");

			if( $this->form_validation->run()==FALSE ){  /* lorsque la validation échoue */

				/* réafficher le formulaire  avec les informations*/
				$this->load->view("template/ck_edit_attributes_form" ,
					/* et transmettre les données de la caisse actuelle */
				array("checkout"=>$this->gesica_sess_utils->get_logged_checkout() ) );

			}else{ /*... la validation a fonctionné*/
				
				/* renseigner les données des champs pour la table dans la BDD */
				$data = array(
					'nom_caisse' => $this->input->post("checkout-user-lname"), /* nom du gestionnaire */
					'pnom_caisse' => $this->input->post("checkout-user-fname"),	/* prénom du gestionnaire*/
					'pseudo_caisse' => $this->input->post("checkout-pseudo")	/* pseudo */
				);

				/* recupérer des informations sur la caisse actuelle */
				$checkout = $this->gesica_sess_utils->get_logged_checkout();

				/* 	demander au modèle de 
					mettre à jour la base de donnée */
				$this->checkout_model->set_checkout( $checkout->code_ent, $checkout->num_caisse , $data );

				/* recharger la caisse actuelle dans les sessions */
				$this->gesica_sess_utils->reload_logged_checkout();

				/* retourner sur le panel */
				header('Location:'.base_url().'checkout/checkout_panel');
			}
 		}
 	}


 	/**
 		@brief afficher le formulaire d'édition de mot de passe de connexion caisse
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
 		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* lorsqu'une caisse est connectée */
 			$this->load->view("template/ck_edit_password_form"); /* afficher le formulaire */
 		}else{
 			header('Location:'.base_url().'home/'); /* retourner à l'accueil */
 		}
 	}

 	/**
 		@brief effectue une requête de changement de mot de passe
 	*/
 	public function edit_password_request()
 	{
 		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* si une caisse est connectée */

 			/*charger la librairie validation*/
 			$this->load->library("form_validation");

 			/*renseigner les règles*/
 			$this->form_validation->set_rules("checkout-ex-password" ,"Ancien mot de passe", "callback_checkout_ex_password_check");
 			$this->form_validation->set_rules("checkout-password" , "Nouveau mot de passe" , "required|min_length[6]");
 			$this->form_validation->set_rules("checkout-password-conf", "Confirmation mot de passe" , "callback_checkout_password_check");

 			if( $this->form_validation->run() == FALSE ){ /* lorsque la validation échoue */

 				/*reafficher le formulaire avec les erreurs*/
 				$this->load->view("template/ck_edit_password_form");
 			}else{

 				/* recupérer la caisse connectée actuelle */
 				$checkout=$this->gesica_sess_utils->get_logged_checkout();

 				/* renseigner les données */
 				$data = array( /* hacher le mot de passe  */
 					'mdp_caisse' => hash( 'sha384' , $this->input->post("checkout-password"))
 				);

 				/*demander au modèle de changer le mot de passe*/
 				$this->checkout_model->set_checkout( $checkout->code_ent , $checkout->num_caisse , $data );

 				header('Location:'.base_url().'checkout/checkout_panel');

 			}
 		}
 	}

 	/**
 		@brief recupère le code de l'entreprise selon qu'on soit en admin ou pas, etc.

 		@return le code de l'entreprise ou null en cas d'erreur
 	*/
 	private function get_enterprise_code()
 	{
 		$code_ent = null;

 		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){ /* recupérer depuis l'admin */
			$admin_data = $this->gesica_sess_utils->get_admin_data();
			$code_ent = $admin_data->code_ent;
		}else{
			if( $this->gesica_sess_utils->has_checkout_logged() ){ /* ou depuis la caisse */
				$checkout = $this->gesica_sess_utils->get_logged_checkout();
				$code_ent = $checkout->code_ent;
			}
		}
		return $code_ent;
 	}

 	/*
 		@brief affiche le panel des articles
 	*/
 	public function product_panel()
	{
		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* si une caisse est connectée */

			/* recupérer la caisse actuelle */
			$logged_checkout = $this->gesica_sess_utils->get_logged_checkout();

			/* récupérer les articles*/
			$products = $this->gesica_sess_utils->get_all_products();

			/*afficher le panel avec toutes les données*/
			$this->load->view("template/ck_products_panel" , 
				array(
					"checkout_logged" => $logged_checkout,
					"products" => 	$products
				)
			);
		}else{ /* si aucune caisse n'est connectée */
			/* retourner à l'accueil */
			header('Location:'.base_url().'home/'); 
		}
	}

	/** 
		@brief affiche le panel nouvelle vente
	*/

	public function new_sell_panel()
	{
		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}
		
		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* caisse connectée */
		
			/* recupérer le panier(l'ensemble des produits prêts à être vendus) */
			$cart = $this->gesica_sess_utils->get_cart();

			/* afficher le panel de vente*/
			$this->load->view("template/ck_new_sell_panel" , array(
				"cart" => $cart, /* transmettre le panier */
				"global_total" => $this->gesica_sess_utils->compute_global_total() , /* transmettre le total */ 
				"global_discount" => $this->gesica_sess_utils->get_global_discount() ) ); /* transmettre la remise */
		}else{ /*si aucune caisse n'est connectée*/
			header('Location:'.base_url().'home/'); /* retourne à l'accuil */
		}
	}

	/**
		@brief ajoute un produit au panier
	*/
	public function add_cart_product()
	{
		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* caisse connectée */

			/* recupérer le panier(l'ensemble des produits prêts à être vendus)  */
			$cart = $this->gesica_sess_utils->get_cart();

			/*charger la lib de validation*/
			$this->load->library("form_validation");

			/* Renseigner les règles de validation des champs */
			$this->form_validation->set_rules("product-code" , "Code produit" , "callback_prod_code_check" );
			$this->form_validation->set_rules("product-amount" , "Quantité" , "callback_prod_amount_check");
			$this->form_validation->set_rules("product-discount" , "Remise" ,"required|trim|numeric");

			if( $this->form_validation->run() == FALSE){ /* si la validation échoue */

				/* réafficher le panel avec les erreurs */
				$this->load->view("template/ck_new_sell_panel" , array("cart" => $cart));
			}else{
				/* 	cette variable(found_product) à été affectée par prod_code_check() 
					lorsque le produit correspondant à été trouvé. 
				 */
				if( isset($this->found_product) ){
					

					$amount = 	(int)$this->input->post("product-amount"); /* Recupérer la quantité  */
					$discount = (float)$this->input->post("product-discout"); /* Récupérer la remise */

					/* ajouter le produit dans le panier */
					$this->gesica_sess_utils->add_cart_product( $this->found_product , $amount , $discount);

					/* retourner sur le panel de la vente */
					header('Location:'.base_url().'checkout/new_sell_panel');
				}
			}
		}else{
			/* retourner à  l'accueil */
			header('Location:'.base_url().'home');
		}
	}

	/**
		@brief efface un produit du panier

		@param index indice du produit à effacer dans le panier
	*/
	public function drop_cart_product( $index )
	{
		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* Lorsqu'une caisse est connectée */

			$cart = $this->gesica_sess_utils->get_cart();

			if( $index>=0 && $index<count($cart) ){	
				$this->gesica_sess_utils->drop_cart_product( $index );
				header('Location:'.base_url().'checkout/new_sell_panel');
			}
		}
	}

	/**
		@brief Annule la vente actuelle (reinitialise le panier)

	*/
	public function cancel_sell(  )
	{
		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* Lorsqu'une caisse est connectée */

			$this->gesica_sess_utils->clear_cart(); /* Effacer tout les éléments du panier */


			/* retourner sur le panel */
			header('Location:'.base_url().'checkout/new_sell_panel');
		} 
	}

	/**
		@brief Applique la vente actuelle

		@param print_bill (s'il vaut 1 alors on affiche la facture)
	*/
	public function apply_sell( $print_bill=0 )
	{
		if( $this->gesica_sess_utils->has_checkout_logged() ){ /* Si une caisse est connectée */
		

			$cart = $this->gesica_sess_utils->get_cart(); /*récupérer le panier*/
			
			$this->gesica_utils->register_sell_operation( $cart );

			/*Enregistrer une opération de vente*/
				$checkout = $this->gesica_sess_utils->get_logged_checkout();
			
			for( $i=0;$i<count($cart);++$i ){  /* pour chacun des éléments dans le panier */
				$ct = $cart[$i];

				/*demander au modèle d'éffectuer la vente*/
				$this->product_model->sell_product( $ct['product-code'] , $ct['product-amount'] );

			}

			$this->gesica_utils->register_operation("Nouvelle vente réalisée par le gestionnaire : ".$checkout->nom_caisse);


			if( (int)$print_bill===1 ){ /*imprimer une facture*/

				/* générer automatiquement la facture */
				$this->gesica_docs_utils->render_bill( $cart );

			}else{ /* ne pas imprimer */

				/* retourne sur le panel caisse */
				header('Location:'.base_url().'checkout/checkout_panel');
			}

			/* reinitialiser le panier */
			$this->gesica_sess_utils->clear_cart(); 
		}else{
			header('Location:'.base_url().'home/');
		}
	} 

 	////////////////////////////////CALLBACKS////////////////////////////////
 	//Fonctions de rappel de vérification des formulaires
 	////////////////////////////////CALLBACKS////////////////////////////////

	public function prod_amount_check( $amount )
	{
		$am = (int)$amount ;

		$product_code = $this->input->post("product-code");


		/* sommer les quantité des produits similaires */
		$cart = $this->gesica_sess_utils->get_cart();
		for( $i=0;$i<count($cart);++$i ){

			if( $cart[$i]['product-code'] === $product_code ){
				$am = $am + $cart[$i]['product-amount'];
			}
		}


		/* verifier le format */
		if( !$this->form_validation->numeric($amount) ){
			$this->form_validation->set_message("prod_amount_check" , "La quantité doit être au format numérique");
			return FALSE;
		}

		/* verifier les quantités */
		if(  $this->found_product->qte_article-$am>=0 ){
			return TRUE;
		}

		$this->form_validation->set_message("prod_amount_check" , 'La quantité est restante('.$this->found_product->qte_article.' insuffisante), quantité totale demandée =' .$am);

		return FALSE;
	}

	public function prod_code_check( $product_code )
	{
		$products = $this->gesica_sess_utils->get_all_products();

		/* chercher le produit ayant le bon code */
		for( $i=0;$i<count($products);++$i ){

			if( $products[$i]->code_article === $product_code ){
				$this->found_product = $products[$i];
				return TRUE; 
			}
		}

		$this->form_validation->set_message("prod_code_check" , "Le code '$product_code' ne correspond à aucun produit ");
		return FALSE;
	}

 	public function checkout_ex_password_check( $password )
 	{
 		$checkout = $this->gesica_sess_utils->get_logged_checkout();

 		if( $checkout->mdp_caisse != hash('sha384',$password) ){
 			$this->form_validation->set_message("checkout_ex_password_check" , "L'ancien mot de passe est incorrect");
 			return FALSE;
 		}
 		return TRUE;

 	}

	public function checkout_number_check( $number )
	{
		$code_ent = $this->get_enterprise_code();
		$admin_data = $this->gesica_sess_utils->get_logged_checkout();

		/* verifier si ce numéro n'existe pas déja dans cette entreprise */
		$data = $this->checkout_model->find_checkout_by_num(
				$code_ent,
		 		$number );

		if( count($data)!=0 ){ /* le numéro existe déja */
			$this->form_validation->set_message("checkout_number_check" , "Le numéro de la caisse que vous avez choisi existe déja");
			return FALSE;
		}
		return TRUE;
	}


	public function checkout_pseudo_check( $pseudo )
	{
		
		/* verifier si le pseudo n'a pas déja été choisi */
		
		$code_ent = $this->get_enterprise_code();

		$data = $this->checkout_model->find_checkout_by_pseudo( $code_ent ,$pseudo );

		if( count($data)!=0 ){ /* déja présent */
			$this->form_validation->set_message("checkout_pseudo_check" , "Le pseudo que vous avez choisi existe déja");
			return FALSE;
		}
		return TRUE;
	}

	public function checkout_edit_pseudo_check( $pseudo )
	{
		
		/* verifier si le pseudo n'a pas déja été choisi */
		
		$code_ent = $this->get_enterprise_code();

		$checkout = $this->gesica_sess_utils->get_logged_checkout();
		$data = $this->checkout_model->find_checkout_by_pseudo( $code_ent ,$pseudo );

		if( count($data)!=0  && ($checkout->pseudo_caisse != $pseudo ) ){ /* déja présent */
			$this->form_validation->set_message("checkout_pseudo_check" , "Le pseudo que vous avez choisi existe déja");
			return FALSE;
		}
		return TRUE;
	}


	public function checkout_password_check( $password )
	{
		$password_conf = $this->input->post("checkout-password-conf");
		if( $password!=$password_conf ){
			$this->form_validation->set_message("checkout_password_check" , "Les mot de passes ne correspondent pas");
			return FALSE;
		}
		return TRUE;
	}

		
 }