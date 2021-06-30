
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


class assistant_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_payment_by_doctor()
	{
		$admin = $this->session->userdata('admin');
					$this->db->where('U.doctor_id',$admin['id']);	
		
		$this->db->order_by('AP.invoice','DESC');
		$this->db->select('AP.*,PM.name mode,U.name assistant');
		$this->db->join('payment_modes PM', 'PM.id = AP.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = AP.assistant_id', 'LEFT');
		return $this->db->get('assistant_payment AP')->result();
	}
	
	
	
	function get_payment_by_id($id)
	{
		$this->db->where('F.id',$id);	

		$this->db->select('F.*,PM.name mode,U.name assistant');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = F.assistant_id', 'LEFT');
		return $this->db->get('assistant_payment F')->row();
	}
	
	function get_assistants_by_invoice($id)
	{
		 $this->db->where('PT.id',$id);
		$this->db->select('F.*,PM.name mode');
		$this->db->order_by('F.invoice','DESC');
		$this->db->join('users PT', 'PT.id = F.assistant_id', 'LEFT');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		return $this->db->get('assistant_payment F')->result();		   
		
	}
	
	function update_fees($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('assistant_payment',$save);
	}
	
	
	
	function get_invoice_number()
	{
		$admin = $this->session->userdata('admin');
		$this->db->where('U.doctor_id',$admin['id']);
		$this->db->select_max('invoice');
		$this->db->join('users U', 'U.id = F.assistant_id', 'LEFT');
		return $this->db->get('assistant_payment F')->row();
	}
	
	function save_payment($save){
		$this->db->insert('assistant_payment',$save);
	}

	function get_username()
	{
	  			$admin = $this->session->userdata('admin');
				$this->db->where('doctor_id',$admin['id']);
				$this->db->where('user_role',3);
				$this->db->select_max('id');
		$assistant = $this->db->get('assistant')->row();
		
		 		$this->db->where('id',$assistant->id);
		return $this->db->get('assistant')->row();
	}
	
	
	
	function save($save)
	{
		$this->db->insert('assistant',$save);
		return $this->db->insert_id(); 
	}
	
	function get_all()
	{
				$this->db->where('user_role',3);
		return $this->db->get('assistant')->result();
	}
	
	function get_assistants_by_doctor()
	{
		$admin = $this->session->userdata('admin');
		$this->db->where('doctor_id',$admin['id']);
		$this->db->where('user_role',3);
		return $this->db->get('assistant')->result();
	}
	
	function get_assistants_by_doctor_ajax($id)
	{
		if($id==0){
			$admin = $this->session->userdata('admin');
			$this->db->where('doctor_id',$admin['id']);
			$this->db->where('user_role',3);
			return $this->db->get('assistant')->result();
		}

		$admin = $this->session->userdata('admin');
		$this->db->where('doctor_id',$admin['id']);
		$this->db->where('id',$id);
		$this->db->where('user_role',3);
		return $this->db->get('assistant')->result();
	}
	
	function get_all_assistant()
	{
		$this->db->where('user_role',3);
		return $this->db->get('assistant')->result();
	}
	
	function get_assistant_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('assistant')->row();
	}
	
	function get_assistant_filter($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('assistant')->result();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('assistant',$save);
	}
	
	
	function get_patients_by_invoice($id)
	{
		 $this->db->where('PT.id',$id);
		$this->db->select('F.*,PM.name mode');
		
		$this->db->join('users PT', 'PT.id = F.patient_id', 'LEFT');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		return $this->db->get('fees F')->result();		   
		
	}
	
	
	function delete($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('assistant_payment');
	}

	function delete_assistant($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('assistant');
	}

}
