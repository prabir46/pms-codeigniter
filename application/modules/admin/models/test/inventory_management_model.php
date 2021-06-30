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

class inventory_management_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('inventory_management',$save);
		return $this->db->insert_id();
	}
	
	function get_template_patient()
	{
		$admin = $this->session->userdata('admin');	
		$this->db->where('admin',$admin['doctor_id']); 
		return $this->db->get('inventory_management')->row();
	}
	function get_medical_test_by_patient()
	{		
		$admin = $this->session->userdata('admin');	
		//$this->db->where('admin',$admin['doctor_id']);
			return $this->db->get('inventory_management')->result();
	}
function get_medical_test_by_patient1($id)
	{		
		$admin = $this->session->userdata('admin');	
		$this->db->where('admin',$id);
			return $this->db->get('inventory_management')->result();
	}
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('inventory_management');
	}
	function get_payment_mode_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('inventory_management')->row();
	}
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('inventory_management',$save);
	}

function update_status($id,$val)
	{
		$this->db->where('id',$id);
		$this->db->set('status',$val);
		$this->db->update('inventory_management');
	}
  function get_inventory_model()
    {
        $query = $this->db->get('lab');
            if ($query->num_rows >= 1)
            {
                foreach($query->result_array() as $row)
                {
                    $data[$row['id']]=$row['name'];
                }
                return $data;
            }
    }





}	
	?>