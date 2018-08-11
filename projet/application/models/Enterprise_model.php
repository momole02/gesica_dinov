<?php 

/* 	Enterprise_model.php - Modèle permettant de gerer 
	les entreprises 
 */

/**
* 
*/
class Enterprise_model extends CI_Model 
{

	function __construct()
	{
		/* se connecter à la base de données */
		$this->load->database();

		$this->load->library("gesica_utils");
	}

	

	public function signup()
	{
		$enterp_name = $this->input->post('enterp-name');

		$enterp_code = $this->gesica_utils->gen_code( $enterp_name );
		$sex = $this->input->post("entern-desc")==='enterp-own-sex-male' ? 'M' : 'F';

		$data = array(
			
			'code_ent' 		=> $enterp_code,
			'nom_pro_ent' 	=> $this->input->post("enterp-own-lname"),
			'pnom_pro_ent' 	=> $this->input->post('enterp-own-fname'),
			'nom_ent' 		=> $this->input->post("enterp-name"),
			'desc_ent' 		=> $this->input->post("enterp-desc"),
			'sexe_pro_ent' 	=> $this->input->post("enterp-own-sex"),
			'logo_ent' 		=> null,
			'mdp_adm_ent' 	=>  hash( 'sha384', $this->input->post('enterp-own-passwd')),
			'pseudo_adm_ent' 	=> $this->input->post('enterp-own-pseudo'),
			'tel_pro_ent' 		=> $this->input->post('enterp-own-tel'),
			'tel_ent'			=> $this->input->post('enterp-tel')

		);

		$this->db->insert('Entreprise' , $data);

		return $enterp_code;
	}

	public function update( $code , $data )
	{
		$this->db->set($data);
		$this->db->where('code_ent' , $code);
		$this->db->update('Entreprise');	
	} 

	public function getbycode( $code )
	{
		$data = $this->db->get_where( "Entreprise", array( 'code_ent' => $code ) );

		if( count($data->result())==1 ){ /* l'élément doit être unique */
			$result = $data->result();
			return $result[0];
		}
		
		return null ;
	}
	public function try_connection( $code , $pseudo , $passwd )
	{
		$data = $this->db->get_where("Entreprise" , array( 'code_ent' => $code , 'pseudo_adm_ent' => $pseudo , 
			'mdp_adm_ent' => hash("sha384" , $passwd),
			 ));
		if( count($data->result())==1 ){ /* l'élement doit être unique */
			return $data->result();
		}
		return null ;
	}

	public function try_connection_no_hash( $code , $pseudo , $hashed )
	{
		$data = $this->db->get_where("Entreprise" , array( 'code_ent' => $code , 'pseudo_adm_ent' => $pseudo , 
			'mdp_adm_ent' =>  $passwd,
			 ));
		if( count($data->result())==1 ){ /* l'élement doit être unique */
			return $data->result();
		}
		return null ;

	}

	public function set_password( $code , $password )
	{
		$this->db->set( array("mdp_adm_ent" => $password) );
		$this->db->where( 'code_ent' , $code );
		$this->db->update('Entreprise');
	}

	public function set_logo( $code , $logo_raw_data )
	{
		$this->db->set( array("logo_ent" => $logo_raw_data) );
		$this->db->where(array('code_ent' => $code) );
		$this->db->update('Entreprise');
	}

	public function get_logo( $code )
	{

		$data=$this->db->get_where( "Entreprise" , array('code_ent' => $code ) );
		$res = $data->result();
		if( count($res)!=0 ){
			return $res->logo_ent;
		}else{
			return null;
		}
	}

	public function get_all_enterprises()
	{
		$data=$this->db->get( "Entreprise" );
		return $data->result();
	}

	public function update_config( $enterp_code , $config )
	{
		$this->db->set( array("config_ent" => $config) );
		$this->db->where( array("code_ent" => $enterp_code ) );
		$this->db->update("Entreprise");
	}


	public function get_enterp_deadlines( $enterp_code )
	{
		$this->db->order_by("fin_ech" , 'DESC');
		$data=$this->db->get_where("Echeance" , array("code_ent" => $enterp_code) );
		return $data->result(); 
	}

	public function add_deadline( $enterp_code , $data )
	{
		$data['code_ent'] = $enterp_code;
		$this->db->insert( 'Echeance' , $data );
	}

	public function drop_deadline_by_id( $id )
	{
		$this->db->where( array('id' => $id) );
		$this->db->delete( 'Echeance');
	}

	public function get_enterp_code_by_dlid( $id )
	{
		$this->db->select('code_ent');
		$this->db->where( array('id' => $id) );
		$data = $this->db->get('Echeance');
		$res=$data->result();
		if( count($res)>0 )
			return $res[0]->code_ent;
		else
			return null;
	}


	public function fit_in_deadlines( $enterp_code , $date )
	{
		$this->db->select('*');
		$this->db->from('Echeance');
		$this->db->where( array( 'code_ent' => $enterp_code , 'debut_ech <= ' => $date , 'fin_ech >' =>  $date ) );
		$data = $this->db->get();
		

		return (count($data->result())>0);
	}

	public function last_deadline_expiration_date( $enterp_code  )
	{
		$this->db->select('fin_ech')->from('Echeance')->where(['code_ent'=>$enterp_code])->order_by('fin_ech' , 'DESC');
		$data = $this->db->get();
		$results = $data->result();

		if( count($results)>0 )
			return $results[0]->fin_ech; 
		return null ;
	}
}