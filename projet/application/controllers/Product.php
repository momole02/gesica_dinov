<?php 

/* 	Product.php - Controlleur de gestion des articles 

	(C) SADII 2018
*/

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library("gesica_sess_utils"); /* charger les fonctions utilitaires pour les sessions */
		$this->load->model("product_model"); /* charger le modèle de gestion des articles */
		$this->load->library("gesica_utils");

	}

	/**
		@brief 	effectue une insertion d'article depuis un fichier CSV Excel
				(Experimental)
	*/
	public function magic_insert()
	{


		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}


		if( $this->gesica_sess_utils->is_admin_mode_enabled() ){  

			/* configurer le initialiser la librairie 'uploads' */
			$config["upload_path"] = './uploads/';
			$config["allowed_types"] = "csv";
			$config["max_size"] = 100;

			$this->load->library("upload" , $config);

			if( $this->upload->do_upload("products-csv-file") ){
				$data = $this->upload->data();
				$file_contents = file_get_contents($data['full_path']);
				
				/* subdiviser les entrées séparées par 'new_line' */
				$entries = explode( "\r\n" , $file_contents );
				
				/* recupérer les données admin depuis la session */
				$admin_data = $this->gesica_sess_utils->get_admin_data();
				for( $i=0;$i<count($entries);++$i ){
			

					if( !empty(trim($entries[$i])) ){
						/* subdiviser les valeurs */
						$values = explode(";", $entries[$i]);
						
						$data = array();

						$data["code_ent"]= $admin_data->code_ent;
						if( isset($values[0]) ) $data["nom_article"]=$values[0];
						if( isset($values[1]) ) $data["type_article"]=$values[1];
						if( isset($values[2]) ) $data["pv_article"] = $values[2];
						if( isset($values[3]) ) $data["qte_article"] = $values[3];

						$this->product_model->new_product( $data );
					}
					
					header('Location:'.base_url().'home/main_panel?file_uploaded=1');
				}
				
			}else{

				$this->load->view("template/main_panel.php" , array(
					"checkouts" => $this->gesica_sess_utils->get_all_checkouts(),
					"admin_data" => $this->gesica_sess_utils->get_admin_data(),
					"upload_error" => $this->upload->display_errors())
				);

			}

		}
		
	}


	public function new_product( )
	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		if( $this->gesica_sess_utils->has_checkout_logged() ){
			$this->load->view("template/new_product_form");
		}
	}

	public function new_product_request()
	{
		if( $this->gesica_sess_utils->has_checkout_logged() ){

			$checkout=$this->gesica_sess_utils->get_logged_checkout();
			$this->load->library("form_validation");

			$this->form_validation->set_rules("product-name" , "Nom du produit" , "required|trim|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("product-type" , "Type du produit" , "required|trim|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("product-price" , "Prix de vente" , "required|trim|min_length[1]|max_length[10]|numeric");
			$this->form_validation->set_rules("product-amount" , "Quantité" ,"required|min_length[1]|max_length[10]|numeric");
			$this->form_validation->set_rules("product-tax" , "TVA" , "required|numeric");
			$this->form_validation->set_rules("product-discount" , "Remise" , "required|numeric");


			if( $this->form_validation->run() == FALSE ){
				$this->load->view("template/new_product_form" );
			}else{

				$data = array(
					'code_ent' => 	$checkout->code_ent,
					'nom_article' 	=> $this->input->post("product-name"),
					'type_article' 	=> $this->input->post("product-type"),
					'pv_article' 	=> $this->input->post("product-price"),
					'qte_article' 	=> $this->input->post("product-amount"),
					"tva_article" 	=> $this->input->post("product-tax"),
					"remise_article" => $this->input->post("product-discount")
				);

				$this->product_model->new_product( $data );
				$this->gesica_sess_utils->reload_all_products();

				$this->gesica_utils->register_operation('Insertion d\'un nouvel article nom='.$data['nom_article'].
					'Par le gestionnaire '.$checkout->nom_caisse);


				header('Location:'.base_url().'checkout/product_panel');
			}
		}
	}

	public function edit_product( $index )
	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}


		if( $this->gesica_sess_utils->has_checkout_logged() ){

			$products = $this->gesica_sess_utils->get_all_products();
			
			if( $index>=0 && $index<count($products) ){
				
				$prod=$products[$index];
				$this->load->view("template/edit_product_form" , 
				array(
					"product" => $prod,
					"index" => $index
				));

			}
		}
	}

	public function edit_product_request()
	{

		if( $this->gesica_sess_utils->has_checkout_logged() ){

			$this->load->library("form_validation");

			$this->form_validation->set_rules("product-name" , "Nom du produit" , "required|trim|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("product-type" , "Type du produit" , "required|trim|min_length[3]|max_length[20]");
			$this->form_validation->set_rules("product-price" , "Prix de vente" , "required|trim|min_length[1]|max_length[10]|numeric");
			$this->form_validation->set_rules("product-amount" , "Quantité" ,"required|min_length[1]|max_length[10]|numeric");
			$this->form_validation->set_rules("product-index" , "Index" , "required|min_length[1]|numeric");
			$this->form_validation->set_rules("product-tax" , "TVA" , "required|numeric");
			$this->form_validation->set_rules("product-discount" , "Remise" , "required|numeric");

			$products = $this->gesica_sess_utils->get_all_products();
			$index = 	(int)$this->input->post("product-index");

			if( $this->form_validation->run() == FALSE ){

				if( $index>=0 && $index<count($products) ){
	
					$prod=$products[$index];
					$this->load->view("template/edit_product_form" , 
					array(
						"product" => $prod,
						"index" => $index
					));	
				}
			}else{

				if( $index>=0 && $index<count($products) ){
					$prod = $products[$index];
					$data = array(
						"nom_article"=>$this->input->post("product-name"),
						"type_article" => $this->input->post("product-type"),
						"pv_article" => $this->input->post("product-price"),
						"qte_article" => $this->input->post("product-amount"),
						"tva_article" => $this->input->post("product-tax"),
						"remise_article" => $this->input->post("product-discount")
					);

					$this->product_model->set_product( $prod->code_article , $data );
					$this->gesica_sess_utils->reload_all_products();

					header('Location:'.base_url().'checkout/product_panel');
				}

			}
		}
	}

	public function supply_product( $index )
	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}
		if( $this->gesica_sess_utils->has_checkout_logged() ){

			$this->load->view("template/supply_product_form"  ,array( 'index' => $index ));

		}
	}

	public function supply_product_request( )
	{

		if( $this->gesica_sess_utils->has_checkout_logged() ){

			$products = $this->gesica_sess_utils->get_all_products();

			$this->load->library("form_validation");

			/* regles de validation*/
			$this->form_validation->set_rules("product-supply-amount" , "Quantité à ajouter" , "trim|required|numeric");
			$this->form_validation->set_rules("product-index" , "Index" , "trim|required|numeric" );
		
			$index = (int)$this->input->post("product-index");

			if( $this->form_validation->run()==FALSE ){ /* validation du formulaire */
				$this->load->view("template/supply_product_form"  ,array( 'index' => $index ));
			}else{
				$supply_amount= (int)$this->input->post("product-supply-amount");
				if( $index>=0 && $index <count($products)){

					$prod = $products[$index];

					if( $supply_amount > 0 ){

						$data = array( "qte_article" => (int)$prod->qte_article + $supply_amount );
						$this->product_model->set_product( $prod->code_article , $data );	
						$this->gesica_sess_utils->reload_all_products();
						
						/* Enregistrer l'opération d'approvisionnement */
						$checkout = $this->gesica_sess_utils->get_logged_checkout();
						$this->gesica_utils->register_supply_operation( $supply_amount , $checkout , 
							$prod);

					}

					header('Location:'.base_url().'checkout/product_panel');
				}
			}
		}else{
			header('Location:'.base_url());	
		}
	}

	public function drop_product( $index )
	{

		
		if( $this->gesica_sess_utils->is_admin_mode_enabled() || 
			$this->gesica_sess_utils->has_checkout_logged() ){

			if( !$this->gesica_sess_utils->deadlines_ok() ){ /* à jour dans les paiements */
				header('Location:'.base_url().'roardloff/');
				return ; 
			}
		}

		if( $this->gesica_sess_utils->has_checkout_logged() ){

			$products = $this->gesica_sess_utils->get_all_products();
			
			if( $index>=0 && $index<count($products) ){
				
				$pd = $products[ $index ];
				$this->product_model->drop_product( $pd->code_article ); /* effacer l'article */
				$this->gesica_sess_utils->reload_all_products(); /* recharger tout les articles */

				header('Location:'.base_url().'checkout/product_panel');
			}
		}else{
			header('Location:'.base_url().'home/');
		}
	}
}