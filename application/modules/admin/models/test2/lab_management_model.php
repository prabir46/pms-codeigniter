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

class lab_management_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('lab_management',$save);
		return $this->db->insert_id();
	}
	
	function get_template_patient()
	{
		$admin = $this->session->userdata('admin');	
		$this->db->where('admin',$admin['doctor_id']); 
		return $this->db->get('lab_management')->row();
	}
	function get_medical_test_by_patient()
	{		
		$admin = $this->session->userdata('admin');	
		//$this->db->where('admin',$admin['doctor_id']);
			return $this->db->get('lab_management')->result();
	}
function get_medical_test_by_patient1($id)
	{		
		$admin = $this->session->userdata('admin');	
		$this->db->where('admin',$id);
                $this->db->order_by('id', 'desc');
	        return $this->db->get('lab_management')->result();
	}
function lab_select_work($id)
	{		
		$admin = $this->session->userdata('admin');	
		$this->db->where('doctor_id',$id);
			return $this->db->get('lab')->result();
	}
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('lab_management');
	}
	function get_payment_mode_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('lab_management')->row();
	}
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('lab_management',$save);
	}

function update_status($id,$val)
	{
		$this->db->where('id',$id);
		$this->db->set('status',$val);
		$this->db->update('lab_management');
	}
  function get_lab_modl()
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