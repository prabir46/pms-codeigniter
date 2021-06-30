<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("patient_model");
		$this->load->model("setting_model");
		$this->load->model("doctor_model");
		$this->load->helper('language');
		$this->lang->load('admin', 'english');
	}
	

	
	function index($id = false)
	{
		/*echo 'id : '.$id;die;
		$doctor_id = $this->uri->segment(2, 0);
		echo 'doctrID : '.$doctor_id;die;*/
		
		$setting = $this->setting_model->get_default_setting();
		$data['doctors'] = $this->doctor_model->get_all_doctors();
		$data['groups'] = $this->patient_model->get_blood_group();
		$admin = $this->session->userdata('admin');
		if(!empty($admin)){
			redirect('admin/dashboard');
		}
		$data['page_title']		= "Register";
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('required', lang('custom_required'));
		$this->form_validation->set_rules('name', 'lang:name', 'required');
		$this->form_validation->set_rules('gender', 'lang:gender', 'required');
		$this->form_validation->set_rules('blood_id', 'lang:select_blood_type', '');	
		$this->form_validation->set_rules('dob', 'lang:date_of_birth', 'required');
		$this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
		
		$this->form_validation->set_rules('contact1', 'lternet no.', 'required');
		$this->form_validation->set_rules('aadhar', 'Aadhar no.', 'required');
		
		//$this->form_validation->set_rules('password', 'lang:password', '|min_length[6]');
		//$this->form_validation->set_rules('confirm', 'lang:confirm_password', 'matches[password]');
		$this->form_validation->set_rules('contact', 'lang:phone', '');
		$this->form_validation->set_rules('address', 'lang:address', 'required');
		
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('register/form', $data);
		}
		else
		{	
				//echo '<pre>'; print_r($_POST);die;
				$save['name'] = $this->input->post('name');
				$save['blood_group_id'] = $this->input->post('blood_id');
				$save['gender'] = $this->input->post('gender');
                $save['dob'] = date("Y")-$this->input->post('dob');
				$save['email'] = $this->input->post('email');
				
				$username = str_replace(" ",'',strtolower(trim($save['name'])));
				$password = $username.rand(10000,99999);
				
				$save['username'] = $username;
				$save['password'] = sha1($password);
				
				$contact = $this->input->post('contact');
				$contact1 = $this->input->post('contact1');
				if($contact1 != '')
					$contact .= '/'.$contact1;
					
                $save['contact'] = $contact;
				$save['aadhar'] = $this->input->post('aadhar');
				$save['medical_History'] = $this->input->post('medical_History');
				$save['contact_with_covid_patient'] = $this->input->post('contact_with_covid_patient');
				
				$save['address'] = $this->input->post('address');
				$save['doctor_id'] = $this->input->post('doctor_id');
				$save['user_role'] = 2;
				$p_key = $this->patient_model->save($save);
				
				$doctor = $this->doctor_model->get_doctor_by_id($save['doctor_id']);
						
						$this->load->library('email');
						$this->load->helper('string');    
						$config['mailtype'] = 'html';
						$config['charset'] = 'utf-8';
						$this->load->library('email', $config);
						$this->email->initialize($config);
						//echo '<pre>';print_r($message);exit;
						$message	=	"Hello ".$doctor->name.",<br />
										 New Patient Added & Patient Detail Are:<br />
										 Name 	  : ".$save['name']."<br />
										 Username : ".$save['username']."<br />
										 Password : ".$password."<br />
										 Login Link: ".site_url('admin/login')."							
						";
						
						$this->email->from($setting->email,$setting->name);
						$this->email->to($doctor->email);
						$this->email->subject('New Patient Details');
						$this->email->message(html_entity_decode($message,ENT_QUOTES, 'UTF-8'));
						$sent = $this->email->send();
						
						$message	=	"Hello ".$save['name'].",<br />
										 Your Registration Is Succes & Detail Are:<br />
										 Name 	  : ".$save['name']."<br />
										 Doctor   : ".$doctor->name."<br />
										 Username : ".$save['username']."<br />
										 Password : ".$password."<br />
										 Login Link: ".site_url('admin/login')."							
						";
						
						$this->email->from($setting->email,$setting->name);
						$this->email->to($save['email']);
						$this->email->subject('Registration Success');
						$this->email->message(html_entity_decode($message,ENT_QUOTES, 'UTF-8'));
						$sent = $this->email->send();
						$this->session->set_flashdata('message', "Patient is saved and username is :".$data['username']." ");
						
				$login		= $this->auth->login_admin($save['username'], $password, '');
			
				if ($login)
				{
					redirect('admin/dashboard/');
				}
				
			
			$this->session->set_flashdata('message','You Sign Up Successfully.Verify your email to login');
			
			redirect(base_url('admin/login'));
		}
	}
	
	function check_username(){
		$username	=	$_POST['username'];
		$id	=	$_POST['id'];
		$result	=	$this->patient_model->check_username($username,$id);
		if(!empty($result)){
			echo 1;
		}
	}
	
	
}