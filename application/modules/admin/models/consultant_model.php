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

class consultant_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('consultant',$save);
		return $this->db->insert_id(); 
	}
	
	
	
	function update($save,$id)
	{
		
			   $this->db->where('id',$id);
		       $this->db->update('consultant',$save);
	}
	
	
	
	function delete($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('consultant');
	}
	
	function get_consultant_by_doctor($id)
	{
			  	
			$this->db->where('doctor_id',$id);
			return $this->db->get('consultant')->result();
	}
	
	function get_consultant_by_id($id)
	{
			  	
			$this->db->where('id',$id);
			return $this->db->get('consultant')->row();
	}

	function get_consultant_by_consultant(){
                        $admin = $this->session->userdata('admin');
$id='';
if($admin['user_role']==1){
					$id = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$id = $admin['doctor_id'];
				   }

			$this->db->where('doctor_id',$id);
			return $this->db->get('consultant')->result();
}
	
}