 <?php 

 /**
 * Operation_model.php 
 * 
 * Modèle de gestion des opérations 
 * 
 * @copyright SADII 2018
 */

class Operation_model extends CI_Model
{
	 public function __construct()
	 {
	 	$this->load->database();
	 	$this->load->library("gesica_utils");

	 }

	 /**
	 * Enregistre une opération quelconque
	 */
	 public function register_operation( $data )
	 {
	 	$data['code_op'] = $this->gesica_utils->gen_code($data['desc_op']);
	 	$this->db->insert( 'OperationEntr', $data );
	 }

	 /**
	 * Enregistre une opération de caisse
	 */
	 public function register_checkout_operation( $data )
	 {
	 	$data['code_op'] = $this->gesica_utils->gen_code($data['type_op']);
	 	$this->db->insert('Operation_Caisse' , $data);
	 }	

	 public function register_sell_operation( $data )
	 {
	 	$this->db->insert("Rel_vendre", $data);
	 }

	 /*
	 	Ajouter une opération d'approvisionnement
	 */
	 public function register_supply_operation( $data )
	 {
	 	$this->db->insert( "Rel_appro" , $data);
	 }

	 /* retourne les codes des caisses propres à une 
	 entreprise donnée */
	 private function get_checkout_codes( $code )
	 {
	 	/* récupérer les codes caisses des entreprises */
	 	$this->db->select('code_caisse');
	 	$this->db->from('Caisse');
	 	$this->db->where( array( 'code_ent' => $code ) );
	 	$data = $this->db->get();
	 	$results = $data->result();
	 	$checkout_codes = array();
	 	foreach( $results as $res ){
	 		array_push( $checkout_codes , $res->code_caisse );
	 	}
	 	return $checkout_codes;
	 }

	 public function get_enterprise_ops( $code , $base , $limit )
	 {
	 	$checkout_codes = $this->get_checkout_codes( $code );

	 	$this->db->select('*');
	 	$this->db->from('OperationEntr');
	 	$this->db->where_in('code_caisse' , $checkout_codes );
	 	$this->db->limit( $base , $limit );
	 	$data = $this->db->get();
	 	return $data->result(); 	
	 }

	 public function count_enterprise_ops( $code )
	 {
	 	$checkout_codes = $this->get_checkout_codes( $code );

	 	$this->db->select('*');
	 	$this->db->from('OperationEntr');
	 	$this->db->where_in( 'code_caisse' , $checkout_codes );

	 	return $this->db->count_all_results();
	 }

	 public function get_supplies( $code , $base , $limit )
	 {
	 	$checkout_codes = $this->get_checkout_codes( $code );

	 	$this->db->select('*');
	 	$this->db->from('Rel_appro');
	 	$this->db->where_in( 'code_caisse' , $checkout_codes );
	 	$this->db->limit( $base , $limit );

	 	$data = $this->db->get();
	 	return $data->result(); 
	 }

	 public function count_supplies( $code )
	 {

	 	$checkout_codes = $this->get_checkout_codes( $code );

	 	$this->db->select('*');
	 	$this->db->from('Rel_appro');
	 	$this->db->where_in( 'code_caisse' , $checkout_codes );


	 	return $this->db->count_all_results();
	 }

	public function get_sells( $code , $base , $limit )
	 {
	 	$checkout_codes = $this->get_checkout_codes( $code );

	 	$this->db->select('*');
	 	$this->db->from('Rel_vendre');
	 	$this->db->where_in( 'code_caisse' , $checkout_codes );
	 	$this->db->limit( $base , $limit );

	 	$data = $this->db->get();
	 	return $data->result(); 
	 }

	 public function count_sells( $code )
	 {
	 	$checkout_codes = $this->get_checkout_codes( $code );

	 	$this->db->select('*');
	 	$this->db->from('Rel_vendre');
	 	$this->db->where_in( 'code_caisse' , $checkout_codes );

	 	return $this->db->count_all_results();
	 }

}