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

class manufacturing_company_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('manufacturing_company',$save);
	}
	
	function get_all()
	{
			return $this->db->get('manufacturing_company')->result();
	}
	
	function get_manufacturing_company_by_doctor()
	{				
					$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
			return  $this->db->get('manufacturing_company')->result();
	}
	
	function get_manufacturing_company_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('manufacturing_company')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('manufacturing_company',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('manufacturing_company');
	}
}