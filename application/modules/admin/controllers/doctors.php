<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class doctors extends MX_Controller {

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
		$data['doctors'] = $this->doctor_model->get_all_doctors();
		$data['fields'] = $this->custom_field_model->get_custom_fields(1);
		$data['page_title'] = lang('doctors');
		$data['body'] = 'doctors/list';
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
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_rules('gender', 'lang:gender', 'required');
			$this->form_validation->set_rules('dob', 'age', 'numeric');
                        $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]|');
			$this->form_validation->set_rules('username', 'lang:username', 'trim|required');
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
			$this->form_validation->set_rules('contact', 'lang:phone', 'required');
                        $this->form_validation->set_rules('sms_plan', 'numeric', 'required');
			$this->form_validation->set_rules('address', 'lang:address', '');
			
			#Check if selected clinic is already assign to any other doctor or not - starts
			$sqlClinic = "SELECT clinic_id,clinic_owner_id FROM clinic WHERE clinic_id = '".$this->input->post('clinic_id')."';";
			//echo '<br>SQL : '.$sqlClinic;die;
			$clinicAlready = $this->db->query($sqlClinic)->row();	
			//echo '<pre>clinicAlready '; print_r($clinicAlready); echo '</pre>';	die;
			if($clinicAlready->clinic_owner_id > 0){
				echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b> Doctor already added for this selected clinic.
											</div>
				';die;
			}
			#Check if selected clinic is already assign to any other doctor or not - ends
			
			if ($this->form_validation->run()==true)
                        {
			
				$save['name'] = $this->input->post('name');
				$save['gender'] = $this->input->post('gender');
                                $save['dob'] = date("Y")-$this->input->post('dob');
                                $save['email'] = $this->input->post('email');
				$save['username'] = $this->input->post('username');
				$save['password'] = sha1($this->input->post('password'));
                                $save['contact'] = $this->input->post('contact');
				$save['address'] = $this->input->post('address');
				$save['user_role'] = 1;
                                $save['sms_limit'] = $this->input->post('sms_plan');
			    
				$p_key = $this->doctor_model->save($save);
				$this->doctor_model->update_clinic_id(array('clinic_owner_id'=>$p_key),$this->input->post('clinic_id'));
				
				$reply = $this->input->post('reply');
				if(!empty($reply)){
					foreach($this->input->post('reply') as $key => $val) {
						$save_fields[] = array(
							'custom_field_id'=> $key,
							'reply'=> $val,
							'table_id'=> $p_key,
							'form'=> 1,
						);	
					
					}	
					$this->custom_field_model->save_answer($save_fields);
				}	
				
				$this->session->set_flashdata('message', lang('doctor_saved'));
				$this->sms_management_model->create($p_key);
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
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
		$this->form_validation->set_rules('dob', 'age', 'numeric');
			$this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
			$this->form_validation->set_rules('username', 'lang:username', 'trim|required|');
			$this->form_validation->set_rules('contact', 'lang:phone', 'required');
			
			
        	if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id)
			{
				$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
				$this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
			}
			
			if($this->input->post('clinic_id') == ''){
				echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b> Please select clinic.
											</div>
				';die;
			}
			
			
			#Check if selected clinic is already assign to any other doctor or not - starts
			$sqlClinic = "SELECT clinic_id,clinic_name FROM clinic WHERE clinic_owner_id='".$id."' AND clinic_id != '".$this->input->post('clinic_id')."';";
			//echo '<br>SQL : '.$sqlClinic;die;			
			$clinicAlready = $this->db->query($sqlClinic)->row();	
			//echo '<pre>clinicAlready '; print_r($clinicAlready); echo '</pre>';	die;
			if($clinicAlready->clinic_name != ''){
				echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b> Selected clinic already assign to another Doctor.
											</div>
				';die;
			}
			else {
				$this->doctor_model->update_clinic_id(array('clinic_owner_id'=>$id),$this->input->post('clinic_id'));			
			}
			#Check if selected clinic is already assign to any other doctor or not - ends
			
			if ($this->form_validation->run())
            {
			
				$save['name'] = $this->input->post('name');
				$save['blood_group_id'] = $this->input->post('blood_id');
				$save['gender'] = $this->input->post('gender');
                $save['dob'] = date("Y")-$this->input->post('dob');
                $save['email'] = $this->input->post('email');
				$save['username'] = $this->input->post('username');
				$save['contact'] = $this->input->post('contact');
				$save['address'] = $this->input->post('address');
				$save['user_role'] = 1;
			   if ($this->input->post('password') != '' || !$id)
				{
					$save['password']	= sha1($this->input->post('password'));
				}
				
				
			$reply = $this->input->post('reply');
				if(!empty($reply)){
				foreach($this->input->post('reply') as $key => $val) {
					$save_fields[] = array(
						'custom_field_id'=> $key,
						'reply'=> $val,
						'table_id'=> $id,
						'form'=> 1,
					);	
				
				}	
				$this->custom_field_model->delete_answer($id,$form=1);
				$this->custom_field_model->save_answer($save_fields);	
				}	
				
				
				
				
				$this->doctor_model->update($save,$id);
                $this->session->set_flashdata('message', lang('doctor_updated'));
				
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
		
	
}