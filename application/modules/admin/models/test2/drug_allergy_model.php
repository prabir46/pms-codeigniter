<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Memento admin_model model
 *
 * This class handles admin_model management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model
 * @author		propertyjar
 * @link		#
 */

class drug_allergy_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('drug_allergy',$save);
	}
	
	function save1($save)
	{
		$this->db->insert('medicine_template',$save);
	}
	
	function get_all()
	{
					
			return $this->db->get('drug_allergy')->result();
	}
	
	function get_all1()
	{
					
			return $this->db->get('medicine_template')->result();
	}
	
	function get_case_history_by_doctor()
	{
			$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   } 		
			return $this->db->get('drug_allergy')->result();
	}
	
	function get_case_history_by_doctor1()
	{
			$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   } 		
			return $this->db->get('medicine_template')->result();
	}
	
	function get_case_history_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('drug_allergy')->row();
	}
	
	function get_case_history_by_id1($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('medicine_template')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('drug_allergy',$save);
	}
	
	function update1($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('medicine_template',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('drug_allergy');
	}
	
	function delete1($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('medicine_template');
	}
}