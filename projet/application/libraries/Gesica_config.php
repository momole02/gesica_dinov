 <?php 

 /*
 	Gesica_config.php 
 */

 class Gesica_config
 {
 	public function __construct()
 	{
 		$this->CI = &get_instance();
 		$this->CI->load->library("gesica_sess_utils");

 		$this->gesica_sess_utils = $this->CI->gesica_sess_utils;

 		/* récupérer les informations sur la config */
 		$this->config = $this->gesica_sess_utils->get_current_config();

 		/* informations sur les format des pages */
 		$page_fmt_attributes=array();
 		$page_fmt_attributes["a4"] = array('name'=>'a4',  'w' => 210 , 'h'=> 287 );
 		$page_fmt_attributes["a5"] = array('name'=>'a5','w' => 148, 'h'=> 210 );
 		$page_fmt_attributes["a6"] = array('name'=>'a6','w' => 105, 'h'=> 148 );
 		$page_fmt_attributes["a7"] = array('name'=>'a7','w' => 74, 'h'=> 105 );
 		$page_fmt_attributes["a8"] = array('name'=>'a8','w' => 52, 'h'=> 74 );
 		$this->page_fmt_attributes = $page_fmt_attributes;
 	}

 	/* 
 		Modifier le format de la page(A4 ... A8)
 		(actuel)
 	*/
 	public function set_bill_page_format( $format , $update = false )
 	{
 		$this->config['page_format'] = $format;
 		/* mettre à jour la config actuelle */
 		if( $update )
 			$this->gesica_sess_utils->update_current_config( $this->config );
 	}

 	/*
 		Modifier le texte de la signature
 		(actuel)
 	*/
 	public function set_bill_mark_text( $text , $update=false )
 	{
 		if( !empty(trim($text)) ){		
	 		$this->config['mark_text'] = $text;
	 		if( $update )
	 			$this->gesica_sess_utils->update_current_config( $this->config );
 		}
 	}


 	public function update_current_config()
 	{
 		$this->gesica_sess_utils->update_current_config( $this->config );
 	}
 

 	/*
 		Recupérer les informations sur le format de la page 
 		actuel
 	*/
 	public function get_bill_page_format_attributes()
 	{
 		$page_fmt = $this->config['page_format'];
 		if( isset( $this->page_fmt_attributes[$page_fmt] ) )
 			return $this->page_fmt_attributes[$page_fmt];
 		else
 			return $this->page_fmt_attributes['a7']; /* format A7 par défaut */
 	}

 	public function paper_format_desc()
 	{


 		return "<Non implémenté>";  
 		
 	}
 	/*
 		Récupérer le texte de la signature
 	*/
 	public function get_bill_mark_text( )
 	{
 		return $this->config['mark_text'];
 	}

 }