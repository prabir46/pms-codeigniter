<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class consultant extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();
		$this->load->model("consultant_model");
                $this->load->model("appointment_model");
		$this->load->model("setting_model");
		$this->load->model("patient_model");
		$this->load->model("contact_model");
		$this->load->model("custom_field_model");
		error_reporting(0); 
	}


       function index(){
		$admin = $this->session->userdata('admin');
		$data['consultant'] = $this->consultant_model->get_consultant_by_doctor($admin['id']);
		$data['page_title'] =  lang('consultant');
		$data['body'] = 'consultant/list';
		$this->load->view('template/main', $data);	
	}	
	
	function add(){
		$data = '';	
		$this->load->view('consultant/add', $data);	
	}

	function delete($id=false){
		
		
			$this->consultant_model->delete($id);
			$this->session->set_flashdata('message','Consultant deleted');
			redirect('admin/consultant');
		
	}	
	function add_form(){


		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
                                        $admin = $this->session->userdata('admin');
				        $name=$_POST['name'];
                                        $colorvalue=$_POST['colorvalue'];
                                           if($name==""){
                                         echo  "Name is Required";
                                         }else{
                                         $save['name'] = $name; 
                                        $save['mobile']=$_POST['phone'];
                                        $save['Color'] = $colorvalue;
                                        $save['doctor_id'] = $admin['id'];
                                        $this->consultant_model->save($save);
				echo  "Consultant Succefully Added";
                                             }
                                       
						
			

        }


	}
	function edit_form(){


		if ($this->input->server('REQUEST_METHOD') === 'POST')
                                            {	
                                        $admin = $this->session->userdata('admin');
				        $name=$_POST['name'];
                                        $colorvalue=$_POST['colorvalue'];
                                         $id=$_POST['id'];
                                           if($name==""){
                                         echo  "Name is Required";
                                         }else{
                                         $save['name'] = $name; 
                                        $save['mobile']= $_POST['phone'];
                                        $save['Color'] = $colorvalue;                                        
                                        $this->consultant_model->update($save,$id);
                                        $this->appointment_model->update_color($save['Color'], $id);
				echo  "Consultant Succefully Updated";
                                             }
            				
		}	

       

	}
	
	
	
		
		
	
}