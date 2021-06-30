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

class prescription_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function get_prescription_id()
	{
			$admin = $this->session->userdata('admin');
			$this->db->where('U.doctor_id',$admin['id']);
			 $this->db->select_max('P.prescription_id');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->row();
	}
	
	function save($save)
	{
		$this->db->insert('prescription',$save);
		return $this->db->insert_id();
	}
	function save_report($save)
	{
		$this->db->insert('reports',$save);
	}
	
	function get_all()
	{
			 $this->db->select('P.*,U.name patient');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->result();
	}
	
	
	function get_fees_due()
	{
			
				$this->db->where('F.invoice IS NULL');
			  	$this->db->select('P.id,U.name patient');
		       $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
			   $this->db->join('fees F', 'P.id = F.prescription_id', 'LEFT');
		return $this->db->get('prescription P')->result();
	}
	function get_prescription_by_doctor()
	{
			$admin = $this->session->userdata('admin');
			if($admin['user_role']==1){
					$this->db->where('U.doctor_id',$admin['id']);	
				   }else{
					$this->db->where('U.doctor_id',$admin['doctor_id']);	
				   }
			
			$this->db->order_by('P.date_time','DESC');
			 $this->db->select('P.*,U.name patient,U.doctor_id,U.dob,U.gender,U.id patient_id');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->result();
	}
	
	
	
	
	function get_payment_by_doctor()
	{
		$admin = $this->session->userdata('admin');
		if($admin['user_role']==1){
					$this->db->where('U.doctor_id',$admin['id']);	
				   }else{
					$this->db->where('U.doctor_id',$admin['doctor_id']);	
				   }
		
		$this->db->order_by('F.invoice','DESC');
		$this->db->select('F.*,PM.name mode,U.name patient');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('fees F')->result();
	}
	
	function get_payment_by_id($id)
	{
		$this->db->where('F.id',$id);	

		$this->db->select('F.*,PM.name mode,U.name patient');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('fees F')->row();
	}
function get_payment_edit_id($id)
	{
		$this->db->where('F.id',$id);	

		$this->db->select('F.*,PM.name mode,U.name patient');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('payment_fees F')->row();
	}
function get_tooth_by_id($id)
	{
		$this->db->where('patient_id',$id);	

		return $this->db->get('tooth')->result();
	}
function total($docid,$patid)
	{
		$this->db->where('patient_id',$patid);	
                $this->db->where('doctor_id',$docid);
		return $this->db->get('payment_fees')->result();
	}
	
function fulldata($docid,$patid,$id)
	{
$where = "id>'".$id."'";
		$this->db->where('patient_id',$patid);	
                $this->db->where('doctor_id',$docid);
                $this->db->where('id >',$id);
		return $this->db->get('payment_fees')->result();
	}
function totals($docid,$patid,$id)
	{
$where = "id>'".$id."'";
		$this->db->where('patient_id',$patid);	
                $this->db->where('doctor_id',$docid);
                $this->db->where('id <',$id);
		return $this->db->get('payment_fees')->result();
	}
function totalss($docid,$patid,$id)
	{
$where = "id>'".$id."'";
		$this->db->where('patient_id',$patid);	
                $this->db->where('doctor_id',$docid);
                $this->db->where('id =',$id);
		return $this->db->get('payment_fees')->result();
	}
function amoutlast($patient_id,$docid){
$this->db->where('patient_id',$patid);	
$this->db->where('doctor_id',$docid);
$this->db->where('debit !=',0);
return $this->db->get('payment_fees')->result();

}
function deletenew($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('payment_fees');
	}
function updedit($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('payment_fees',$save);
	}
	function get_reports()
	{		  $this->db->order_by('R.date_time','DESC');
			   $this->db->select('R.*,U.name from_user,U.image,U1.name to_user,M.name type');
		       //$this->db->join('prescription P', 'P.id = R.prescription_id', 'LEFT');
			   $this->db->join('medical_test M', 'M.id = R.type_id', 'LEFT');
			   $this->db->join('users U', 'U.id = R.from_id', 'LEFT');
			   $this->db->join('users U1', 'U1.id = R.to_id', 'LEFT');
		return $this->db->get('reports R')->result();
	}
	
	function get_reports_by_id($id)
	{
			   $this->db->where('R.prescription_id',$id);
			   $this->db->order_by('R.date_time','DESC');
			   $this->db->select('R.*,U.name from_user,U.image,U1.name to_user,M.name type');
		       //$this->db->join('prescription P', 'P.id = R.prescription_id', 'LEFT');
			   $this->db->join('medical_test M', 'M.id = R.type_id', 'LEFT');
			   $this->db->join('users U', 'U.id = R.from_id', 'LEFT');
			   $this->db->join('users U1', 'U1.id = R.to_id', 'LEFT');
		return $this->db->get('reports R')->result();
	}
	
	function get_report_by_id($id)
	{
			   $this->db->where('R.id',$id);
			   $this->db->order_by('R.date_time','DESC');
			   $this->db->select('R.*,U.name from_user,U.image,U1.name to_user,M.name type');
		       //$this->db->join('prescription P', 'P.id = R.prescription_id', 'LEFT');
			   $this->db->join('medical_test M', 'M.id = R.type_id', 'LEFT');
			   $this->db->join('users U', 'U.id = R.from_id', 'LEFT');
			   $this->db->join('users U1', 'U1.id = R.to_id', 'LEFT');
		return $this->db->get('reports R')->row();
	}
	
	
	function get_reports_notification()
	{
				$admin = $this->session->userdata('admin');
			   $this->db->where('R.to_id',$admin['id']);
			   $this->db->where('R.is_view_to',1);
			   $this->db->select('R.*,U.name from_user,U.image,U1.name to_user');
		       //$this->db->join('prescription P', 'P.id = R.prescription_id', 'LEFT');
			   $this->db->join('users U', 'U.id = R.from_id', 'LEFT');
			   $this->db->join('users U1', 'U1.id = R.to_id', 'LEFT');
		return $this->db->get('reports R')->result();
	}
	
	function report_is_view_by_user($id)
	{
	    $admin = $this->session->userdata('admin');
		$this->db->where('R.prescription_id',$id);
		$this->db->where('R.to_id',$admin['id']);
		$this->db->set('R.is_view_to',0);
		$this->db->update('reports R');
	}
	
	function amout($patient_id,$amount,$status){
$this->db->where('id',$patient_id);
$this->db->set('amount',$amount);
$this->db->set('pending',$status);
$this->db->set('status',$status);
$this->db->update('fees');
}
function sts1($status){
$ff=0;
$this->db->where('status !=',$ff);

$this->db->set('status',$status);
$this->db->update('fees');

}


	function get_template_patient()
	{
		$admin = $this->session->userdata('admin');	
		$this->db->where('doctor_id',$admin['doctor_id']); 
		return $this->db->get('prescription_template')->row();
	}
	
	
	function get_prescription_by_doctor_ajax($id)
	{
		if($id==0){
			$admin = $this->session->userdata('admin');
			$this->db->where('U.doctor_id',$admin['id']);
			 $this->db->select('P.*,U.name patient,U.doctor_id,U.dob,U.gender,U.id patient_id');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
			return $this->db->get('prescription P')->result();
		}

		
		$this->db->where('P.prescription_id',$id);
		$admin = $this->session->userdata('admin');
		$this->db->where('U.doctor_id',$admin['id']);
		$this->db->select('P.*,U.name patient,U.doctor_id,U.dob,U.gender,U.id patient_id');
		$this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->result();
	}
	
	
	
	function get_prescription_by_id($id)
	{
			   $this->db->where('P.id',$id);
			    $this->db->select('P.*,U.name patient,U.doctor_id,U.dob,U.gender,U.id patient_id');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->row();
	}
	
	function get_case_history($id)
	{
			   $this->db->where('P.patient_id',$id);
			    $this->db->select_max('P.id');
				$this->db->select('P.*,U.name patient,U.doctor_id,U.dob,U.gender,U.id patient_id');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->row();
	}
	
	function get_prescription_by_patient()
	{
			$admin = $this->session->userdata('admin');
			$this->db->where('P.patient_id',$admin['id']);
			  $this->db->select('P.*,U.name patient,U.doctor_id,U.dob,U.gender,U.id patient_id');
		     $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->result();
	}
	function checkz_payment($patient_id){

$this->db->where('patient_id',$patient_id);
$this->db->where('status !=','0');
return $this->db->get('fees')->result();
}
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('prescription',$save);
	}
	
	function update_fees($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('fees',$save);
	}
	function update_tooth($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('tooth',$save);
	}
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('prescription');
	}
	function delete_report($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('reports');
	}
	
	function get_all_payment_modes()
	{
				$admin = $this->session->userdata('admin');
			$this->db->where('doctor_id',$admin['id']);
			return $this->db->get('payment_modes')->result();
	}
	
	function get_fees_all($id)
	{
		 $this->db->where('prescription_id',$id);
		$this->db->select('F.*,(select sum(amount) from fees where prescription_id = '.$id.')as bal,PM.name mode');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		return $this->db->get('fees F')->result();
	}
	
	
	
	
	function get_invoice_number()
	{
		 $admin = $this->session->userdata('admin');
		
		if($admin['user_role']==1){
		$this->db->where('U.doctor_id',$admin['id']);
		}else{
		$this->db->where('U.doctor_id',$admin['doctor_id']);
		}
		$this->db->select_max('invoice');
		$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('fees F')->row();
	}
	
	function save_fees($save)
	{
		       $this->db->insert('fees',$save);
	}
	function payment_fees($save)
	{
		       $this->db->insert('payment_fees',$save);
	}

	function save_tooth($save)
	{
		       $this->db->insert('tooth',$save);
	}
	function delete_fees($id)//delte fees
	{
			   $this->db->where('id',$id);
		       $this->db->delete('fees');
	}
function delete_tooth($id)//delte fees
	{
			   $this->db->where('id',$id);
		       $this->db->delete('tooth');
	}
}
