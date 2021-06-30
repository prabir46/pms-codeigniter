<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class clinics extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_access('Admin', true);
		$this->load->model("doctor_model");
		$this->load->model("invoice_model");
		$this->load->model("setting_model");
		$this->load->model("custom_field_model");
		$this->load->library('form_validation');
        $this->load->model("sms_management_model");
		error_reporting(0); 
	}
	
	
	function index(){
		$data['clinics'] = $this->doctor_model->get_all_clinics();
		$data['fields'] = $this->custom_field_model->get_custom_fields(1);
		$data['page_title'] = 'Clinics';
		$data['body'] = 'clinics/list';
		$this->load->view('template/main', $data);	

	}	
	
	
	function export(){
		$data['doctors'] = $this->doctor_model->get_all_doctors();
		$this->load->view('doctors/export', $data);	

	}	
	
	function medication_history($id){
		$data['prescriptions'] = $this->doctor_model->get_doctors_by_medication($id);
		
		$data['page_title'] = lang('medication_history');
		$data['body'] = 'doctors/medication_history';
		$this->load->view('template/main', $data);			
	}
	
	function invoice($id){
		$data['payments'] = $this->doctor_model->get_detail($id);
		$data['setting']   = $this->setting_model->get_setting();	
		$data['page_title'] = lang('payment_history');	
		$data['body'] = 'doctors/invoice_list';
		$this->load->view('template/main', $data);	
	}
	
	
	function view_invoice($id=false){
		$data['details'] = $this->invoice_model->get_detail($id);
			
		$data['setting']   = $this->setting_model->get_setting();	
		$data['page_title'] = lang('invoice');
		$data['body'] = 'invoice/invoice';
		$this->load->view('template/main', $data);	

	}	

        function add_sms()
        {
              $doctor_id = $this->input->post('doctor_id');
              $sms_count = $this->input->post('sms_count');
              $this->sms_management_model->update_sms_count($doctor_id, $sms_count);
              redirect('/admin/doctors', 'refresh');
        }
	
	
	function add(){
		$data['fields'] = $this->custom_field_model->get_custom_fields(1);
		$data['groups'] = $this->doctor_model->get_blood_group();
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {			 
			$this->load->library('form_validation');
			//$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('clinic_name', 'Clinic Name', 'required');
			$this->form_validation->set_rules('clinic_address_line_1', 'Clinic address line 1', 'required');
			$this->form_validation->set_rules('clinic_phone_number', 'Clinic phone number', 'required');
            $this->form_validation->set_rules('clinic_owner_id', 'Clinic owner', 'required');
			$this->form_validation->set_rules('clinic_email', 'clinic email', 'required');
			$this->form_validation->set_rules('clinic_open_time', 'Clinic open time', 'required');
			$this->form_validation->set_rules('clinic_close_time', 'Clinic close time', 'required');
			
			$clinic_owner_id = $this->input->post('clinic_owner_id');
            $duplicate = $this->doctor_model->checkClinicWithOwner($clinic_owner_id);
			//echo '<pre>duplicate'; print_r($duplicate); echo '</pre>';die;
			if(count($duplicate) > 0){
				echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b> Sorry, Clinic for this owner is already created.
											</div>
				';
				die;
			}
		   
			if ($this->form_validation->run()==true)
            {
				$save['clinic_name'] = $this->input->post('clinic_name');
				$save['clinic_address_line_1'] = $this->input->post('clinic_address_line_1');
				$save['clinic_address_line_2'] = $this->input->post('clinic_address_line_2');
				$save['clinic_city'] = $this->input->post('clinic_city');
				$save['clinic_state'] = $this->input->post('clinic_state');
				$save['clinic_pincode'] = $this->input->post('clinic_pincode');
				$save['clinic_landmark'] = $this->input->post('clinic_landmark');
				$save['clinic_phone_number'] = $this->input->post('clinic_phone_number');
				$save['clinic_owner_id'] = $this->input->post('clinic_owner_id');
				$save['clinic_owner'] = $this->input->post('clinic_owner');
				$save['clinic_email'] = $this->input->post('clinic_email');
				$save['clinic_open_time'] = $this->input->post('clinic_open_time');
				$save['clinic_close_time'] = $this->input->post('clinic_close_time');
			    $save['is_deactivated'] = 'false';
				$save['clinic_timezone'] = 'GMT+05:30';
				$save['clinic_created_at'] = date('Y-m-d H:i:s');
				
				$p_key = $this->doctor_model->saveClinic($save);
					
				$this->session->set_flashdata('message', 'Clinic saved successfully.');
				//$this->sms_management_model->create($p_key);
			echo 1;
			}else{
			
			echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>'.validation_errors().'
											</div>
				';
			}
			
			
		}		

	}
	
	
	function edit($id=false){
		$data['fields'] = $this->custom_field_model->get_custom_fields(1);	
		$data['doctor'] = $this->doctor_model->get_doctor_by_id($id);
		$data['groups'] = $this->doctor_model->get_blood_group();
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			//$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('clinic_name', 'Clinic Name', 'required');
			$this->form_validation->set_rules('clinic_address_line_1', 'Clinic address line 1', 'required');
			$this->form_validation->set_rules('clinic_phone_number', 'Clinic phone number', 'required');
            $this->form_validation->set_rules('clinic_owner_id', 'Clinic owner', 'required');
			$this->form_validation->set_rules('clinic_email', 'clinic email', 'required');
			$this->form_validation->set_rules('clinic_open_time', 'Clinic open time', 'required');
			$this->form_validation->set_rules('clinic_close_time', 'Clinic close time', 'required');
        				
			if ($this->form_validation->run())
            {			
				$save['clinic_name'] = $this->input->post('clinic_name');
				$save['clinic_address_line_1'] = $this->input->post('clinic_address_line_1');
				$save['clinic_address_line_2'] = $this->input->post('clinic_address_line_2');
				$save['clinic_city'] = $this->input->post('clinic_city');
				$save['clinic_state'] = $this->input->post('clinic_state');
				$save['clinic_pincode'] = $this->input->post('clinic_pincode');
				$save['clinic_landmark'] = $this->input->post('clinic_landmark');
				$save['clinic_phone_number'] = $this->input->post('clinic_phone_number');
				$save['clinic_owner_id'] = $this->input->post('clinic_owner_id');
				$save['clinic_owner'] = $this->input->post('clinic_owner');
				$save['clinic_email'] = $this->input->post('clinic_email');
				$save['clinic_open_time'] = $this->input->post('clinic_open_time');
				$save['clinic_close_time'] = $this->input->post('clinic_close_time');
				
				$this->doctor_model->updateClinic($save,$id);
                $this->session->set_flashdata('message', 'Clinic updated successfully.');
				
			echo 1;
			}else{
			
			echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>'.validation_errors().'
											</div>
				';
			}
			
		}
	}	
	
	function view_doctor($id=false){
		$data['groups'] = $this->doctor_model->get_blood_group();
		$data['fields'] = $this->custom_field_model->get_custom_fields(1);	
		$data['doctor'] = $this->doctor_model->get_doctor_by_id($id);
		$data['page_title'] = lang('view') . lang('doctor');
		$data['body'] = 'doctors/view';
		$this->load->view('template/main', $data);	
	}	
	


	function delete($id=false){
		
		if($id){
			$this->doctor_model->delete($id);
			$this->session->set_flashdata('message',lang('doctor_deleted'));
			redirect('admin/doctors');
		}
	}	
	
	function deleteClinic($id=false){
		
		if($id){
			$this->doctor_model->deleteClinic($id);
			$this->session->set_flashdata('message','Clinic deleted successfully.');
			redirect('admin/clinics');
		}
	}
		
	
}