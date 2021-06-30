<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class message extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("act_model");
		$this->load->model("patient_model");
		$this->load->model("message_model");
		$this->load->model("setting_model");
		error_reporting(0);
	}
	
	
	function index(){
	$this->auth->check_access('1', true);
		$data['clients'] = $this->patient_model-> get_patients_by_doctor();
		$data['page_title'] = lang('message');
		$data['body'] = 'message/list';
		$this->load->view('template/main', $data);	
	}	
	
	
	function send($id=false){
		
		$data['setting']   = $this->setting_model->get_setting();	
		$this->message_model->message_is_view_by_admin($id);
		$data['patient']		 = $this->message_model->get_patient_by_id($id);
		$data['messages'] 	 = $this->message_model->get_message_by_id($id);
		$data['id'] =$id;
		
        $admin = $this->session->userdata('admin');
		
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('message', 'lang:message', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
			 
			if ($this->form_validation->run()==true)
            {
				$save['from_id'] = $admin['id'];
				$save['to_id'] = $id;
				$save['message'] = $this->input->post('message');
				$save['is_view_to'] = 1;
				$this->message_model->save_message($save);
                
				$this->load->library('email');
				$this->load->helper('string');    
				/*$config = array(
						'protocol' => "smtp",
						'smtp_host' => "ssl://smtp.gmail.com",
						'smtp_port' => "465",
						'smtp_user' => "",
						'smtp_pass' => "",
						'charset' => "utf-8",
						'mailtype' => "html",
						'newline' => "\r\n"
					);*/
				$config['mailtype'] = 'html';
				$config['charset'] = 'utf-8';
				
		
				$this->load->library('email', $config);
					
				$this->email->initialize($config);
				$this->email->from($data['setting']->email,$data['setting']->name);
				$this->email->to($data['patient']->email);
				$this->email->subject('Message From Doctor');
				$this->email->message(html_entity_decode($save['message'],ENT_QUOTES, 'UTF-8'));
				$sent = $this->email->send();
				
				$this->session->set_flashdata('message', 'Message Sent');
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
	
	function send_message($id=false){
		$admin = $this->session->userdata('admin');
		$access = $admin['user_role'];
		//echo $id;	
		//echo $admin['id'];die;
		$data['patient'] = $this->message_model->get_patient_by_id($id);
		$data['messages'] = $this->message_model->get_message_by_id($id);
		$doctor = $this->message_model->get_doctor_by_patient();
		$data['count'] = $this->message_model->get_message_count_by_id();
		if($id != $admin['id']){
		 redirect('admin/dashboard');
		}
		$data['id'] = $admin['id'];
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('message', 'lang:message', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
			 
			if ($this->form_validation->run()==true)
            {
				$save['from_id'] = $admin['id'];
				$save['to_id'] = $admin['doctor_id'];
				$save['message'] = $this->input->post('message');
				$save['is_view_to'] = 1;
				
				
				$this->message_model->save_message($save);
               	
				$this->load->library('email');
				$this->load->helper('string');    
				/*$config = array(
						'protocol' => "smtp",
						'smtp_host' => "ssl://smtp.gmail.com",
						'smtp_port' => "465",
						'smtp_user' => "",
						'smtp_pass' => "",
						'charset' => "utf-8",
						'mailtype' => "html",
						'newline' => "\r\n"
					);*/
				$config['mailtype'] = 'html';
				$config['charset'] = 'utf-8';
				
		
				$this->load->library('email', $config);
					
				$this->email->initialize($config);
				$this->email->from($data['patient']->email,$data['setting']->name);
				$this->email->to($doctor->email);
				$this->email->subject('Message From Patient');
				$this->email->message(html_entity_decode($save['message'],ENT_QUOTES, 'UTF-8'));
				$sent = $this->email->send();
				
				$this->session->set_flashdata('message', lang('message_sent'));
				redirect('admin/message/send_message/'.$id);
				
			}
		}		
	
		$this->message_model->message_is_view_by_user();
		$data['page_title'] = lang('send') . lang('message');
		$data['body'] = 'message/send_message';
		$this->load->view('template/main', $data);	

	}	
	
	function delete($id=false,$redirect=false){
		
		if($id){
			$this->message_model->delete($id);
			$this->session->set_flashdata('message',lang('message_deleted'));
			if(!empty($redirect)){
					redirect('admin/patients/view/'.$redirect.'/message');
				}else{
					redirect('admin/message');
				}
			
		}
	}	
		
	
}