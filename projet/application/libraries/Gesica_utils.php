 <?php 
 /* gesica_utils.php - fonctions utilitaires */

 class Gesica_utils
 {

 	public function __construct()
 	{
 		$this->CI = &get_instance();
 		$this->CI->load->library("gesica_sess_utils");
 		$this->CI->load->model("operation_model");
 		$this->CI->load->library("gesica_docs_utils");

 		$this->gesica_sess_utils = &$this->CI->gesica_sess_utils;
 		$this->operation_model = &$this->CI->operation_model;
 		$this->gesica_docs_utils = &$this->CI->gesica_docs_utils;

 	}

	private function dropSpaces( $str )	
	{
		return str_replace( ' ', 'X', $str);
	}

 	public function gen_code( $name )
 	{
 		/*générer un code adéquat*/
		return strftime( '%d%m%y%H%M%S_' ).substr( 
				$this->dropSpaces($name) , 
				0, 
				min( strlen( $name ) , 4 ) );
 	}

 	public function register_checkout_login_operation()
 	{
 		$data = array();
 		$logged_checkout = $this->gesica_sess_utils->get_logged_checkout();
 		$data['code_caisse'] = $logged_checkout->code_caisse;
 		$data['date_op'] = strftime("%Y-%m-%d %H:%M:%S");
 		$data['type_op'] = 'OUVERTURE';
    
    $this->write_cache_operation( $data['date_op'] , 'OUVERTURE CAISSE' , $logged_checkout->nom_caisse.' à ouvert la caisse ');

 		$this->operation_model->register_checkout_operation($data);
 	}

 	public function register_checkout_loggout_operation()
 	{
 		$data = array();
 		$logged_checkout = $this->gesica_sess_utils->get_logged_checkout();
 		$data['code_caisse'] = $logged_checkout->code_caisse;
 		$data['date_op'] = strftime("%Y-%m-%d %H:%M:%S");
 		$data['type_op'] = 'FERMETURE';
 		$this->operation_model->register_checkout_operation($data);
    $this->write_cache_operation( $data['date_op'] , 'FERMETURE CAISSE' , $logged_checkout->nom_caisse.' à fermé la caisse' );
 	}

 	public function register_operation( $desc = " " )
 	{
 		$data = array();
 		$logged_checkout = $this->gesica_sess_utils->get_logged_checkout();
 		$data['code_caisse'] = $logged_checkout->code_caisse;
 		$data['date_op'] = strftime("%Y-%m-%d %H:%M:%S");
 		$data['desc_op'] = $desc;
 		$this->operation_model->register_operation($data);
    $this->write_cache_operation( $data['date_op'] , 'OPERATION' , $logged_checkout->nom_caisse." à réalisé l'opération : ".
    $data['desc_op'] );
 	}

 	/*
 	Enregistre une nouvelle vente
 	*/
 	public function register_sell_operation( $cart )
 	{

   		$code=$this->gen_code("BILL");
   		$path = "./uploads/bills/$code.pdf";
   		
   //		$f = fopen($path , "w+");
   //		fclose($f);

   		$this->gesica_docs_utils->render_bill( $cart , $path);
   		$logged_checkout = $this->gesica_sess_utils->get_logged_checkout();
   		$data['code_caisse'] = $logged_checkout->code_caisse;
   		$data['date_hr_vente'] = strftime('%Y-%m-%d %H:%M');
   		$data['lien_fac_vente'] = base_url()."uploads/bills/$code.pdf";
      /* calculer le total */
      $tot = 0 ; 


      foreach( $cart as $pd ){
        $tot = $tot + (int)$pd['product-total'];
      }

   		$this->operation_model->register_sell_operation( $data );
      $this->write_cache_operation( $data['date_hr_vente'] , 'Vente' , 'Lien de la facture : '.$data['lien_fac_vente'].'. Total : '.$tot.' Francs' );
    	
  }

  	/*
  		Enregistre une nouvelle opération d'approvisionnement
  	*/
  	public function register_supply_operation( $added_amount , $checkout , $product )
  	{
  		$data['code_caisse'] = $checkout->code_caisse;
  		$data['code_article'] = $product->code_article;
  		$data['qte_ajout'] = $added_amount;
  		$data['date_hr'] = strftime("%Y-%m-%d %H:%M:%S");
  		$data['comment'] = "Approvisionnement de l'article [".$product->nom_article."].\n".
  							"# Catégorie = ".$product->type_article.".\n".
  							"# Quantité ajoutée= ".$added_amount.".\n".
  							"# Nouvelle quantité disponible = ".($product->qte_article+$added_amount)."."; /* le product passé est l'ancien produit */

      /* ecrire l'opération dans le fichier cache */ 
      $this->write_cache_operation( $data['date_hr'] , 'Approvisionnement' ,$data['comment'] ); 
  		$this->operation_model->register_supply_operation( $data );
  	}

    private function log_cache_filename()
    {
      $enterp_code = $this->gesica_sess_utils->get_enterprise_code();
      return './log/'.$enterp_code.'.cache.log';
    }


    /*
      Charge le cache
    */
    public function load_cache( )
    {
      if( !file_exists($this->log_cache_filename() ) )
        return array();

      $content = file_get_contents( $this->log_cache_filename() );
      
      if( $content === false )
        return array();

      $data =unserialize($content); 
      
      if( $data === false )
        return array();

      return $data;
    }

    public function load_cache_no_session( $enterp_code )
    {
      
      $file = './log/'.$enterp_code.'.cache.log';
      
      if( !file_exists($this->log_cache_filename() ) )
        return array();

      $content = file_get_contents( $this->log_cache_filename() );
      
      if( $content === false )
        return array();

      $data =unserialize($content); 
      
      if( $data === false )
        return array();

      return $data;
    }


    /* 
      Ecrit une opération dans le cache

      $datetime = date et heure de l'opération
      $type = type de l'opération
      $desc = description de l'opération
    */
    public function write_cache_operation( $datetime , $type , $desc )
    {

      $data['time'] = $datetime;
      $data['type'] = $type;
      $data['desc'] = $desc;
      $log = $this->load_cache(); /* charger les données du logging */
      array_unshift($log, $data); /* ajouter l'opération au début */
      file_put_contents($this->log_cache_filename() , serialize($log));
    }

    public function drop_cache_entry( $i ){
      
      $cache = $this->load_cache();
        if( $i>=0 && $i<count($cache) ){
          array_splice($cache, $i);
          file_put_contents($this->log_cache_filename(), serialize($cache));
        }
    }
    

    /* Efface le cache */
    public function clear_cache(  )
    {
      file_put_contents($this->log_cache_filename(), "");
    }

    public function clear_cache_no_session( $enterp_code )
    {

      $file = './log/'.$enterp_code.'.cache.log';
      file_put_contents($file, ""); 
    }

 }