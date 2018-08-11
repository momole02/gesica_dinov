<?php 

/* Product_model.php - modèle de gestion des articles */

class Product_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		$this->load->library("gesica_utils");
	}

	public function new_product( $data )
	{
		/* créér une librairie utilitaire pour gérer la génération du code */
		$data['code_article'] = $this->gesica_utils->gen_code( $data['nom_article'] );
		var_dump($data);
		$this->db->insert( "Article" , $data );
	}

	public function drop_product( $product_code )
	{
		$this->db->delete("Article" , array("code_article" => $product_code) );
	}

	public function load_all_products( $enterp_code )
	{
		$data = $this->db->get_where("Article" , array("code_ent" => $enterp_code));
		return $data->result();
	}

	public function set_product( $product_code , $data )
	{
		$this->db->set( $data );
		$this->db->where( array("code_article" => $product_code) );
		$this->db->update("Article");
	}

	public function sell_product( $product_code , $amount )
	{
		$data = $this->db->get_where( "Article" , array("code_article" => $product_code) );
		if( count($data->result()) > 0 ){

			$result = $data->result()[0];

			$this->db->set( array( 'qte_article'  => max( 0, $result->qte_article-$amount )) );
			$this->db->where( array("code_article" => $product_code) );
			$this->db->update("Article");
		}
	
	}

	public function get_prod_by_code( $code )
	{
		$data = $this->db->get_where("Article" , array('code_article' => $code));
		$r = $data->result();
		if( count($r) == 0 )
			return null ; 
		else 
			return $r[0];
	}
}