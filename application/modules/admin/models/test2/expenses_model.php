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

class expenses_model extends CI_Model 
{
   function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('expenses',$save); 
	}

        function delete($id)
        {
                $this->db->where('id',$id);
                $this->db->delete('expenses');
        }
	
	function get_all()
	{       $admin = $this->session->userdata('admin');
		$this->db->order_by('id','DESC');
                if($admin['user_role']==1){
		$this->db->where('doctor_id',$admin['id']);
                }
                else{
                $this->db->where('doctor_id',$admin['doctor_id']);
                }			
		return $this->db->get('expenses')->result();
	}
  
        function get_by_id($id)
        {
                $admin = $this->session->userdata('admin');
		$this->db->where('id',$id);
		$this->db->where('doctor_id',$admin['id']);			
		return $this->db->get('expenses')->result();
        }

        function dates($date1,$date2)
        {    
                $admin = $this->session->userdata('admin');
                if($admin['user_role']==1){
		$this->db->where('doctor_id',$admin['id']);
                }
                else{
                $this->db->where('doctor_id',$admin['id']);
                }
                $this->db->where('date >=',$date1);
                $this->db->where('date <=',$date2);
                return $this->db->get('expenses')->result();
        } 
}
?>