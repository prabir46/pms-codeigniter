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


class doctor_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_blood_group()
	{
	  
		return $this->db->get('blood_group_type')->result();
	}
	
	function update_fees($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('doctor_payment',$save);
	}
	function delete_payment($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('doctor_payment');
	}

	
	
	function get_payment_by_doctor($id)
	{
		$this->db->where('DP.doctor_id',$id);
		$this->db->order_by('DP.invoice','DESC');
		$this->db->select('DP.*,U.name doctor');
		$this->db->join('users U', 'U.id = DP.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment DP')->result();
	}
	
	
	function get_payment_by_doctor_all()
	{
		
		$this->db->order_by('DP.invoice','DESC');
		$this->db->select('DP.*,U.name doctor');
		$this->db->join('users U', 'U.id = DP.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment DP')->result();
	}
	
	
	function get_payment_by_id($id)
	{
		$this->db->where('F.id',$id);	

		$this->db->select('F.*,U.name doctor');
		$this->db->join('users U', 'U.id = F.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment F')->row();
	}
	
	
	
	function get_invoice_number()
	{
		 
		$this->db->select_max('invoice');
		return $this->db->get('doctor_payment')->row();
	}
	
	
	function save_payment($save){
		$this->db->insert('doctor_payment',$save);
	}
	
	
	
	function get_detail($id)
	{
		
		$this->db->where('U.doctor_id',$id);	
		$this->db->order_by('F.date','DESC');
		$this->db->select('F.*,PM.name mode,U.name patient');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('fees F')->result();
	}
	
	
	
	function save($save)
	{
		$this->db->insert('users',$save);
		return $this->db->insert_id(); 
	}
	
	function get_all()
	{
				$this->db->where('user_role',1);
		return $this->db->get('users')->result();
	}
	
	function get_doctors_by_medication($id)
	{
		 $this->db->where('U.doctor_id',$id);
		$this->db->select('P.*,U.name patient');
		$this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->result();		   
		
	}
	function get_clinic_by_doctor()
	{
		$admin = $this->session->userdata('admin');
        
	$doctor_id = $admin['id'];
	$doctor_id1 = $admin['doctor_id'];
	$query_sh = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id1;");
	$results1 = array();
	foreach ($query_sh->result() as $data)
	   {
			$this->db->where('clinic_id', $data->clinic_id);
	$this->db->where('is_deactivated', "false");
   $clinic1 = $this->db->get('clinic')->row(0);
   array_push($results1, $clinic1);
	   }
	   
   $this->db->where('clinic_owner_id', $doctor_id );
   $this->db->where('is_deactivated', "false");
   $results2 = $this->db->get('clinic')->result();
   
   $merging_data = array_merge($results1, $results2);
   $final_list_clinic = array_unique($merging_data,SORT_REGULAR);
return $final_list_clinic;
		
	}
	
	function get_all_doctors()
	{
		$this->db->where('user_role',1);
		$this->db->order_by("name", "asc");
		return $this->db->get('users')->result();
	}
	
	function get_doctor_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('users')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('users',$save);
	}
	
	
	function delete($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('users');
	}
	
	function get_all_clinics()
	{
		$this->db->where('is_deactivated',false);
		return $this->db->get('clinic')->result();
	}
	
	function get_clinic_by_id($id)
	{
			   $this->db->where('clinic_id',$id);
		return $this->db->get('clinic')->row();
	}
	
	function updateClinic($save,$id)
	{
			   $this->db->where('clinic_id',$id);
		       $this->db->update('clinic',$save);
	}
	
	function saveClinic($save)
	{
		$this->db->insert('clinic',$save);
		return $this->db->insert_id(); 
	}
	
	function checkClinicWithOwner($id)
	{
	   $this->db->where('clinic_owner_id', $id );
	   $this->db->where('is_deactivated', "false");
	   $results2 = $this->db->get('clinic')->result(); 
	   return $results2;
	}
	
	function deleteClinic($id)//delte client
	{
			   $this->db->where('clinic_id',$id);
		       $this->db->delete('clinic');
	}
	
	function update_clinic_id($save,$id)
	{
			   $this->db->where('clinic_id',$id);
		       $this->db->update('clinic',$save);
	}
}
