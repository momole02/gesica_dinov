<?php 
/*	
	Gesica_sess_util.php - Fonctions utilitaires permettant de gérer les sessions pour GESICA

	Code : Marc-Arnaud A.

	(C) SADII 2018 
*/


class Gesica_sess_utils
{
	public function __construct()
	{
		$this->CI =&get_instance(); /* récupérer le super objet codeIgniter */

		$this->CI->load->library("session"); /* charger les sessions */
		$this->CI->load->model("product_model");
		$this->CI->load->model("enterprise_model");
	}

	/*
		détermine si le mode admin est activé
	*/
	public function is_admin_mode_enabled()
	{
		$code_igniter =& $this->CI;

		return ( 	$code_igniter->session->has_userdata("admin_data") 
				&&  $code_igniter->session->has_userdata("checkouts")
		 ); 

	}


	public function enable_checkout_mode(  )
	{
		$code_igniter = &$this->CI;

		$admin_data = $code_igniter->session->userdata("admin_data");

		/* charger que le nécéssaire */
 		$code_igniter->session->set_userdata("enterp_name" , $admin_data->nom_ent);
 		$code_igniter->session->set_userdata("enterp_code" , $admin_data->code_ent);
 		$code_igniter->session->set_userdata("hashed_admin_password" , $admin_data->mdp_adm_ent);
 		
 		/* desactiver les données disponibles en admin */
 		$code_igniter->session->unset_userdata("admin_data");
 		$code_igniter->session->unset_userdata("checkouts");
		
	}

	/*
		détermine si le mode caisse est activé
	*/
	public function is_checkout_mode_enabled()
	{
		$code_igniter =& $this->CI;

		return ( 	$code_igniter->session->has_userdata("enterp_name") &&
					$code_igniter->session->has_userdata("enterp_code")) ;
	}

	/* 
		Effectue une connexion de l'administrateur 
	*/
	public function connect_admin( $admin_data , $checkouts)
	{
		$code_igniter =& $this->CI;

		$admin_data->expiration_date = $this->last_deadline_expiration_date( $admin_data->code_ent );

		$code_igniter->session->set_userdata("admin_data" , $admin_data);
		$code_igniter->session->set_userdata("checkouts" , $checkouts);
		$code_igniter->session->set_userdata("config" , unserialize($admin_data->config_ent) );

	}

	/* retourne les données si on est en mode admin */
	public function get_admin_data(  )
	{
		$code_igniter = &$this->CI;

		if( $this->is_admin_mode_enabled() )
			return $code_igniter->session->userdata("admin_data");
		return null ; 
	}

	/*
		retourne toutes les caisses
	*/
	public function get_all_checkouts()
	{
		$code_igniter = &$this->CI;

		if( $this->is_admin_mode_enabled() )
			return $code_igniter->session->userdata("checkouts");
		return null ;

	}

	public function has_checkout_logged()
	{
		$code_igniter = &$this->CI;
		return( $code_igniter->session->has_userdata("logged_checkout")  && 
				$code_igniter->session->has_userdata("products"));
	}

	public function get_enterprise_code()
	{

		$code_igniter = &$this->CI;

		if( $this->is_checkout_mode_enabled() )
			return $code_igniter->session->userdata("enterp_code");
		elseif( $this->is_admin_mode_enabled() ){
			return $this->get_admin_data()->code_ent;
		}

		return null;
	}

	public function get_enterprise_name()
	{

		$code_igniter = &$this->CI;

		if( $this->is_checkout_mode_enabled() )
			return $code_igniter->session->userdata("enterp_name");
		
		return null;
	}

	public function get_logged_checkout()
	{
		$code_igniter = &$this->CI;
		if( $this->has_checkout_logged() )
			return $code_igniter->session->userdata("logged_checkout");

		return null; 
	}

	public function get_all_products()
	{
		$code_igniter = &$this->CI;
		if( $this->has_checkout_logged() ){
			return $code_igniter->session->userdata("products");	
		}
		return null ;
	}

	public function connect_checkout( $checkout )
	{

		$code_igniter = &$this->CI;
		$products = $code_igniter->product_model->load_all_products( $checkout->code_ent );

		/*charger les données des caisses*/
		$code_igniter->session->set_userdata("logged_checkout" , $checkout);
		
		/*charger les produits*/
		$code_igniter->session->set_userdata("products" , $products);

		/*initialiser le panier*/
		$code_igniter->session->set_userdata("cart" , array());

		/*initialiser la remise totale */
		$code_igniter->session->set_userdata("global-discount" , 0);
	}
	public function disconnect_checkout()
	{
		$code_igniter = &$this->CI;
		
		$code_igniter->session->unset_userdata("logged_checkout");
		$code_igniter->session->unset_userdata("products");
		$code_igniter->session->unset_userdata("cart");

	}

	/* rechager toutes les caisses */
	public function reload_checkouts( $enterp_code )
	{
		$code_igniter = &$this->CI;

		$code_igniter->load->model("checkout_model");
		$checkouts = $code_igniter->checkout_model->load_all_checkouts( $enterp_code );

		$code_igniter->session->set_userdata("checkouts" , $checkouts);
	}

	/* recharger la caisse actuelle */
	public function reload_logged_checkout( )
	{
		if( $this->has_checkout_logged() ) {

			$code_igniter = &$this->CI;
			$code_igniter->load->model("checkout_model");
			$checkout=$this->get_logged_checkout();
			$cd = $code_igniter->checkout_model->find_checkout_by_num( $checkout->code_ent , $checkout->num_caisse );
			$code_igniter->session->set_userdata("logged_checkout" , $cd[0]);
		}
	}

	/* recharger les articles */
	public function reload_all_products()
	{
		if( $this->has_checkout_logged() ) {

			$checkout = $this->get_logged_checkout();
			$code_igniter = &$this->CI;
			$code_igniter->load->model("product_model");
			$code_igniter->session->set_userdata("products" , 
				$code_igniter->product_model->load_all_products( $checkout->code_ent ));
		}

	}

	public function clear_cart()
	{
		$code_igniter = &$this->CI;

		if( $this->has_checkout_logged() ){
			$code_igniter->session->set_userdata("cart" , array());	
		}
	}
	
	/* retourne le panier actuel */
	public function get_cart()
	{
		$code_igniter = &$this->CI;

		if( $this->has_checkout_logged() )
			return $code_igniter->session->userdata("cart");

		return null ; 
	}

	public function add_cart_product( $prod , $amount , $discount=0.0 )
	{
		$code_igniter = &$this->CI ; 
		
		if( $this->has_checkout_logged() ){
		
			/*renseigner les informations du produit*/
			$pd['product-name'] = $prod->nom_article;
			$pd['product-code'] = $prod->code_article;
			$pd['product-amount'] = $amount;
			$pd['product-price'] = $prod->pv_article;
			$tax = (float)$prod->taxe_article;
			$pd['product-tax'] = $tax;

			$disc = ( $discount === 0.0 ) ? (float)$prod->remise_article : (float)$discount;
			$pd['product-discount'] = 	(float) $disc;
			
			$raw_total = $amount * $prod->pv_article;
			$discount_pount = ($raw_total * $disc)/100;
			$tax_pount = ($raw_total * $tax) / 100; 

			$pd['product-raw-total'] = $raw_total;
			$pd['product-total'] = $raw_total - $discount_pount + $tax_pount;

			/*ajouter les infos*/
			$cart = $this->get_cart();
			array_push($cart, $pd); 
			$code_igniter->session->set_userdata("cart" , $cart);
		}
	}

	public function drop_cart_product( $product_index )
	{
		$code_igniter = &$this->CI;

		if( $this->has_checkout_logged() ){
			
			$cart = $this->get_cart();

			if( $product_index>=0 && $product_index<count($cart) ){
				array_splice($cart, $product_index);
			}

			$code_igniter->session->set_userdata("cart" , $cart);
		}
	}

	/* retourne le chemin du logo de l'entreprise */
	public function get_logo_image_path( $use_url=true )
	{
		$code_igniter = &$this->CI;

		$enterp_code = $this->get_enterprise_code();
		$admin_data = $code_igniter->enterprise_model->getbycode($enterp_code);

		if( $admin_data->logo_ent != null){
			
			if( $use_url == true ) return base_url().'uploads/'.$admin_data->logo_ent;
			else return './uploads/'.$admin_data->logo_ent;

		}else{
			if( $use_url == true) return base_url().'tmp/no_logo.png';
			else return './tmp/no_logo.png';
		}
	}

	public function compute_global_total()
	{
		if( $this->has_checkout_logged() ){
			$global_discount = $this->get_global_discount();
			$global_total = 0;
			$cart = $this->get_cart(); 

			for( $i=0;$i<count($cart);++$i ){
				$global_total += $cart[$i]['product-total'];
			}
			$glob_disc_pount = ($global_total * $global_discount)/100;
			$global_total = $global_total - $glob_disc_pount;
			return $global_total;	
		}
		return null ; 
	}

	public function get_global_discount()
	{
		if( $this->has_checkout_logged() ){
			return (int)$this->CI->session->userdata("global-discount");
		}	
		return null ;
	}

	public function get_current_config()
	{
		if( $this->CI->session->has_userdata("config") )
			return $this->CI->session->userdata("config");
		else
			return array() ;
	}

	public function update_current_config( $config )
	{
		$this->CI->session->set_userdata("config" , $config);
		$this->CI->enterprise_model->update_config( $this->get_enterprise_code(), serialize($config) ); /* mettre à jour la config dans la base de données */
	}

	/* verifie l'abonnement */
	public function deadlines_ok_no_sess( $enterp_code )
	{
		$current_date = strftime("%Y-%m-%d %H:%M:%S");
		if( $this->CI->enterprise_model->fit_in_deadlines($enterp_code, $current_date ) ){
			return true;
		}

		/* déconnecter tout le monde  */
		$this->CI->session->sess_destroy();
		return false;
	}

	public function deadlines_ok(  )
	{
		$enterp_code = $this->get_enterprise_code();

		if( $enterp_code != null){
			return $this->deadlines_ok_no_sess( $enterp_code );
		}else{
			return false;
		}
	}

	public function last_deadline_expiration_date( $enterp_code )
	{
		return $this->CI->enterprise_model->last_deadline_expiration_date( $enterp_code );
	}


}