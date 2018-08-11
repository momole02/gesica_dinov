<?php 

class Api961d12ae3c2b extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("product_model");
		$this->load->model("enterprise_model");
		$this->load->library("gesica_utils");
		$this->load->model("operation_model");
		$this->load->model("checkout_model");


		$this->_MAGIC = '961d12ae3c2b'; /* webminigun en sha1 */
	}



	public function list_products( $enterp_code = '' )
	{

			$products = $this->product_model->load_all_products( $enterp_code );
			$json_data = array() ; 
			for( $i=0;$i<count($products);++$i ){
				$prod['code'] = 		$products[$i]->code_article;
				$prod['name'] = 		$products[$i]->nom_article;
				$prod['category'] = 	$products[$i]->type_article;
				$prod['sell_price'] = 	$products[$i]->pv_article;
				$prod['qty'] = 			$products[$i]->qte_article;
				$prod['tax'] = 			$products[$i]->tva_article;
				$prod['discount'] = 	$products[$i]->remise_article;
				array_unshift($json_data, $prod);
			}

			$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_header('Access-Control-Allow-Origin','*')
			->set_output(json_encode($json_data));

	}

	public function connect_admin( $code ='' , $pseudo='',$password='' )
	{

		$data = $this->enterprise_model->try_connection( $code , $pseudo , $password );

		if( $data == null ){
			header('Access-Control-Allow-Origin: *');
			$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_header('Access-Control-Allow-Origin',' *')
			->set_output(json_encode(array()));

		}else{
			$d=$data[0];
			$json_data['code'] = $d->code_ent;
			$json_data['own_first_name'] = $d->pnom_pro_ent;
			$json_data['own_last_name'] = $d->nom_pro_ent;
			$json_data['enterprise_name'] = $d->nom_ent;
			$json_data['enterprise_desc'] = $d->desc_ent;
			$json_data['own_sex'] = $d->sexe_pro_ent;
			$json_data['own_tel'] = $d->tel_pro_ent;
			$json_data['enterprise_tel'] = $d->tel_ent;

			/*nouvelles data*/
			$json_data['address'] = $d->adresse;
			$json_data['open_time'] = $d->heure_ouverture;
			$json_data['close_time'] = $d->heure_fermeture;
			$json_data['expiration_date'] = $this->enterprise_model->last_deadline_expiration_date( $code );

			header('Access-Control-Allow-Origin:*');
			$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_output(json_encode($json_data));

		}
	}

	public function connect_checkout( $code='',$checkout_pseudo='' , $checkout_password='' )
	{
		$data = $this->checkout_model->try_connection($code , $checkout_pseudo , $checkout_password);

		if( $data==null ){
			$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_header('Access-Control-Allow-Origin',' *')
			->set_output(json_encode(array()));

		}else{

			$json_data=[

				'checkout_num' => $data->num_caisse,
				'checkout_code' => $data->code_caisse,
				'first_name' => $data->nom_caisse,
				'last_name' => $data->pnom_caisse,
				'pseudo' =>$data->pseudo_caisse,
				'hashed_password' => $data->mdp_caisse
			];

			$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_header('Access-Control-Allow-Origin',' *')
			->set_output(json_encode($json_data));

		}
	}

	public function notifications( $enterp_code='' )
	{
		$cache = $this->gesica_utils->load_cache_no_session( $enterp_code );
		
			$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_output(json_encode($cache));
	}

	public function clear_notifications( $enterp_code='' )
	
	{
		$this->gesica_utils->clear_cache_no_session( $enterp_code );

		$this->output->set_status_header(200)
		->set_content_type("application/json","utf-8")
		->set_output(json_encode(array( 'status' => 'succes' )));

	}


	/* récupère le nombre de ventes */
	public function sellscount( $enterp_code )
	{
		$this->output->set_status_header(200)
		->set_content_type("application/json","utf-8")
		->set_output(json_encode(array( 'count' => $this->operation_model->count_sells( $enterp_code ) )));

	}
	

	/* récupère une portions des ventes*/
	public function sells( $enterp_code='' , $base=0, $limit=10 )
	{
		$data = $this->operation_model->get_sells( $enterp_code , $base , $limit );
		$json_data = array();


		for( $i=0;$i<count( $data );++$i ){
			$d=$data[$i];
			$sell['no'] = $d->id;
			$sell['checkout_code'] = $d->code_caisse;
			$sell['time'] = $d->date_hr_vente;
			$sell['bill_link'] = $d->lien_fac_vente;

			$checkout = $this->checkout_model->get_checkout_by_code( $d->code_caisse );
			$sell['checkout_name'] =  $checkout->nom_caisse.' '.$checkout->pnom_caisse;

			array_push($json_data, $sell);
		}

		$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_output(json_encode($json_data));
	}



	/* nombre d'approvisionnements */
	public function suppliescount( $enterp_code='' )
	{
		$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_output(json_encode(array("count" => $this->operation_model->count_supplies($enterp_code) )));

	}

	/* récupère tout les approvisionnements */
	public function supplies( $enterp_code='' , $base=0, $limit=0 )
	{
		$data = $this->operation_model->get_supplies( $enterp_code , $base , $limit );
		$json_data = array();

		for( $i=0;$i<count($data);++$i ){
			$d=$data[$i];
			$sup['no']=$d->id;
			$sup['checkout_code'] = $d->code_caisse;
			$sup['product_code'] = $d->code_article;
			$sup['added_qty'] = $d->qte_ajout;
			$sup['time'] = $d->date_hr; 
			$sup['comment'] = $d->comment;
			array_push($json_data , $sup);

			$checkout = $this->checkout_model->get_checkout_by_code( $sup['checkout_code'] );
			$sup['checkout_name'] = $checkout->nom_caisse.' '.$checkout->pnom_caisse;

			$prod = $this->product_model->get_prod_by_code( $sup['product_code'] );
			$sup['product_details'] = $prod->nom_article.'('.$prod->type_article.')';
		}

		$this->output->set_status_header(200)
		->set_content_type("application/json","utf-8")
		->set_output(json_encode($json_data));
	}


	public function enterpopscount( $enterp_code )
	{
		$this->output->set_status_header(200)
			->set_content_type("application/json","utf-8")
			->set_output(array("count" => $this->operation_model->count_enterprise_ops( $enterp_code )));

	}


	/* récupère toutes les opérations de l'entreprise */
	public function enterpops( $enterp_code='' , $base=0 , $limit=0 )
	{
		$data = $this->operation_model->get_enterprise_ops( $enterp_code , $base , $limit );
		$json_data = array();

		for( $i=0;$i<count($data);++$i ){
			$d=$data[$i];
			$op['no']=$d->id;
			$op['checkout_code'] = $d->code_caisse;
			$op['time'] = $d->date_op;
			$op['desc'] = $d->desc_op;

			$checkout = $this->checkout_model->get_checkout_by_code( $op['checkout_code'] );
			$op['checkout_name'] = $checkout->nom_caisse.' '.$checkout->pnom_caisse;

			array_push( $json_data , $op );

		}
		
		$this->output->set_status_header(200)
		->set_content_type("application/json","utf-8")
		->set_output(json_encode($json_data));
	}
}