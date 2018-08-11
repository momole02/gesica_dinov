<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sadiicrudgenerator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->library("gesica_sess_utils");

		$this->load->library('grocery_CRUD');
		$this->load->model('checkout_model');
	}

	public function _example_output($output = null)
	{
		$this->load->view('sadiicrudview.php',(array)$output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

/*	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}



	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}*/

    public function article()
    {
        /* try{
             $crud = new grocery_CRUD();

             $crud->set_theme('datatables');
             $crud->set_table('article');
             $crud->set_subject('Article');
            // $crud->required_fields('city');
             $crud->columns('code_article','nom_article','type_article','pv_article','qte_article');

             $output = $crud->render();

             $this->_example_output($output);

         }catch(Exception $e){
             show_error($e->getMessage().' --- '.$e->getTraceAsString());
         }*/

         if( $this->gesica_sess_utils->is_admin_mode_enabled() ){

         	try{
             $crud = new grocery_CRUD();

             $crud->set_theme('flexigrid');
             $crud->set_table('article');
             $crud->set_subject('article');
            // $crud->required_fields('city');
             $crud->display_as('code_article' , 'Code ')
             	->display_as('nom_article' , "Nom ")
             	->display_as('type_article' , 'Catégorie')
             	->display_as('pv_article' , 'Prix de vente')
             	->display_as('qte_article' , 'Qté disponible');

             $crud->columns('code_article','nom_article','type_article','pv_article','qte_article');

             $output = $crud->render();

             $this->_example_output($output);

         	}catch(Exception $e){
          	   show_error($e->getMessage().' --- '.$e->getTraceAsString());
         	}

         }else{
         	header("Location:".base_url().'home/');
         }
    }

    function operation_caisse()
    {
    	/* les états de sorties ne sont disponibles qu'en mode admin */
    	if( $this->gesica_sess_utils->is_admin_mode_enabled() ){

	         try{
	             $crud = new grocery_CRUD();

	             $crud->set_theme('flexigrid');
	             $crud->set_table('operation_caisse');
	             $crud->set_subject('operation_caisse');
	            // $crud->required_fields('city');
	             $crud->display_as('id' ,'#' )
	             	->display_as('date_op' , "Date et heure de l'opération")
	             	->display_as('type_op' , "Type d'opération")
	             	->display_as('code_caisse' , 'Gestionnaire');

	             $crud->callback_column('code_caisse' ,array($this,'cb_checkout_name') );

	             $crud->columns('id','code_caisse','date_op','type_op');

	             $output = $crud->render();

	             $this->_example_output($output);
	             
	         }catch(Exception $e){
	             show_error($e->getMessage().' --- '.$e->getTraceAsString());
	         }


    	}else{
    		header("Location:".base_url().'home/');
    	}

    }

    function cb_checkout_name( $value , $row )
    {
    	$data = $this->checkout_model->get_checkout_by_code( $value );
    	if( $data === null ){
    		return '[NULL]';
    	}else{
    		return $data->nom_caisse.' '.$data->pnom_caisse;
    	}
    }

    function operationentr()
    {
    	if( $this->gesica_sess_utils->is_admin_mode_enabled() ){


	         try{
	             $crud = new grocery_CRUD();

	             $crud->set_theme('flexigrid');
	             $crud->set_table('operationentr');
	             $crud->set_subject('operation_entreprise');
	            // $crud->required_fields('city');
	             $crud->display_as('id' , '#')
	             	->display_as('code_caisse' , 'Gestionnaire')
	             	->display_as('date_op' , "Date et heure de l'opération")
	             	->display_as('desc_op' , 'Description');
	             $crud->callback_column('code_caisse' , array($this , 'cb_checkout_name'));
	             $crud->columns('id','code_caisse','date_op','desc_op');

	             $output = $crud->render();

	             $this->_example_output($output);
	             
	         }catch(Exception $e){
	             show_error($e->getMessage().' --- '.$e->getTraceAsString());
	         }

    	}else{
    		header("Location:".base_url().'home/');
    	}
    }


    function rel_vendre()
    {
    	if( $this->gesica_sess_utils->is_admin_mode_enabled() ){
			try{
	             $crud = new grocery_CRUD();

	             $crud->set_theme('flexigrid');
	             $crud->set_table('rel_vendre');
	             $crud->set_subject('ventes');
	            // $crud->required_fields('city');
	             $crud->display_as('id' , '#')
	             ->display_as('code_caisse' , 'Gestionnaire')
	             ->display_as('date_hr_vente' , 'Date et heure vente')
	             ->display_as('lien_fac_vente' , 'Lien de la facture');

	             $crud->columns('id' , 'code_caisse' , 'date_hr_vente' , 'lien_fac_vente');
	             $crud->callback_column('code_caisse' , array($this , 'cb_checkout_name'));
	             $output = $crud->render();

	             $this->_example_output($output);
	             
	         }catch(Exception $e){
	             show_error($e->getMessage().' --- '.$e->getTraceAsString());
	         }

    	}else{
    		header("Location:".base_url().'home/');
    	}
    }


	function rel_appro()
    {

    	if( $this->gesica_sess_utils->is_admin_mode_enabled() ){

	         try{
	             $crud = new grocery_CRUD();

	             $crud->set_theme('flexigrid');
	             $crud->set_table('rel_appro');
	             $crud->set_subject('Approvisionnements');
	            // $crud->required_fields('city');
	             $crud->display_as('id' , '#')
	             ->display_as('code_caisse' , 'Gestionnaire')
	             ->display_as('date_hr' , "Date et heure de l'approv. ")
	             ->display_as('qte_ajout' , 'Qté ajoutée')
	             ->display_as('code_article' , 'Article')
	             ->display_as('comment' , 'Commentaires');

	             $crud->columns('id','code_caisse', 'code_article', 'date_hr','qte_ajout' , 'comment');
	             $crud->callback_column('code_caisse'  , array($this, 'cb_checkout_name'));
	             $crud->callback_column('code_article' , array($this , 'cb_product_name'));

	             $output = $crud->render();

	             $this->_example_output($output);
	             
	         }catch(Exception $e){
	             show_error($e->getMessage().' --- '.$e->getTraceAsString());
	         }

    	}else{
    		header("Location:".base_url().'home/');
    	}
    }

    function cb_product_name( $value , $row )
    {
    	$data = $this->product_model->get_prod_by_code( $value );
    	if( $data==null )
    		return '[NULL]';
    	else
    		return $data->nom_article.'('.$data->type_article.')';
    }

}
