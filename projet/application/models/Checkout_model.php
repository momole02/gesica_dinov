<?php 

/* Checkout_model.php - Modèle rélatif aux caisses */

class Checkout_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->library("gesica_utils");
	}

	public function new_checkout( $data )
	{
		$checkout_code = $this->gesica_utils->gen_code( $data['nom_caisse'] );
		$data['code_caisse'] = $checkout_code; 
		$this->db->insert('Caisse' , $data);
	}

	public function find_checkout_by_num( $enterp_code , $num )
	{
		$data = $this->db->get_where("Caisse" , array( 'code_ent'=>$enterp_code , 'num_caisse'=>$num ));
		return $data->result();
	}

	public function find_checkout_by_pseudo( $enterp_code , $pseudo )
	{
		$data = $this->db->get_where("Caisse" , array('code_ent' => $enterp_code , 'pseudo_caisse'=>$pseudo ));
		return $data->result();
	}

	public function load_all_checkouts( $enterp_code )
	{
		/* charger toutes les caisses de l'entreprise */
		$data = $this->db->get_where("Caisse" , array('code_ent' => $enterp_code ) );
		return $data->result();
	}

	public function drop_checkout( $checkout_code )
	{
		$this->db->delete( "Caisse", array("code_caisse" => $checkout_code) );
	}

	public function set_checkout( $enterp_code , $checkout_num , $data )
	{
		$this->db->set($data);
		$this->db->where(array("code_ent" => $enterp_code , "num_caisse" => $checkout_num));
		$this->db->update("Caisse");
	}

	public function try_connection( $enterp_code , $checkout_pseudo , $checkout_password )
	{
		
		$data = $this->db->get_where("Caisse" , 
			array(	"code_ent" => $enterp_code,
					"pseudo_caisse" => $checkout_pseudo , 
					"mdp_caisse" =>  hash('sha384' ,$checkout_password )  ));


		if( count($data->result())==1 ){
			$r = $data->result();
			return $r[0];
		}

		return null;  /* non trouvé */
	}

	public function get_checkout_by_code( $code )
	{
		$data = $this->db->get_where('Caisse' , array('code_caisse' => $code));
		$r = $data->result();
		if( count($r)==0 )
			return null ; 
		else 
			return $r[0];
	}
	
}