<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class drug_allergy extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->auth->check_access('Admin', true);
		
		$this->auth->is_logged_in();	
		$this->load->model("instruction_model");
		$this->load->model("medicine_category_model");
		$this->load->model("manufacturing_company_model");
		$this->load->model("medicine_model");
		$this->load->model("doctor_model");
		$this->load->model("drug_allergy_model");
error_reporting(0); 
	}
	
	
	function index(){
		
		$admin = $this->session->userdata('admin');
		if($admin['user_role']=="Admin"){
			$data['case_historys'] = $this->drug_allergy_model->get_all();
		}
		if($admin['user_role']==1 || $admin['user_role']==3){
			$data['case_historys'] = $this->drug_allergy_model->get_case_history_by_doctor();
		}	
		$data['page_title'] = lang('drug_allergy');
		$data['body'] = 'drug_allergy/list';
		$this->load->view('template/main', $data);	

	}	
	
	function add(){
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			 
			if ($this->form_validation->run()==true)
            {
				$admin = $this->session->userdata('admin');	
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
			  
				$this->drug_allergy_model->save($save);
                $this->session->set_flashdata('message', "Case Drug Allergy Saved");
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
		
		$data['case_history'] = $this->drug_allergy_model->get_case_history_by_id($id);
		$admin = $this->session->userdata('admin');
		$data['id'] =$id;
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			 
			if ($this->form_validation->run()==true)
            {
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
				
				$this->drug_allergy_model->update($save,$id);
                $this->session->set_flashdata('message', "Case History Updated");
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
	
	function delete($id=false){
		
		if($id){
			$this->drug_allergy_model->delete($id);
			$this->session->set_flashdata('message',"Case History Deleted");
			redirect('admin/drug_allergy');
		}
	}	
}