<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inventory_management extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();	
		//$this->auth->check_access('1', true);
		$this->load->model("patient_model");
		$this->load->model("notes_model");
		$this->load->model("contact_model");
		$this->load->model("prescription_model");
		$this->load->model("setting_model");
		$this->load->model("custom_field_model");
		$this->load->model("invoice_model");
		$this->load->model("medical_test_model");
		$this->load->model("notification_model");
		$this->load->model("medicine_model");
		$this->load->model("disease_model");
		$this->load->model("instruction_model");
		$this->load->model("payment_mode_model");
		$this->load->model("appointment_model");
		$this->load->model("case_history_model");
		$this->load->model("lab_management_model");
		$this->load->model("supplier_model");
$this->load->model("inventory_management_model");
		$this->load->library('form_validation');
		$this->load->library('session');
//error_reporting(0); 
	}
	
	
	function index($id=false){
	$data['p_id']= $id;
	$admin = $this->session->userdata('admin');
		
		$data['name']= $this->supplier_model->get_medicine_categoory_by_doctor();
		//echo '<pre>'; print_r($_POST);die;	
		$data['fields'] = $this->custom_field_model->get_custom_fields(6);	
if($admin['user_role']==1){
					$ad = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$ad = $admin['doctor_id'];
				   }
		$data['tests']= $this->inventory_management_model->get_medical_test_by_patient($ad);

		$data['page_title'] = lang('inventory_management');
		$data['body'] = 'inventory_management/inventory_management_list';
		$this->load->view('template/main', $data);	

	}	


function get_labcontroller(){
$data['lab']=$this->inventory_management_model->get_inventory_model();
$this->load->view('template/main',$data);
} 
	
	function add(){
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			
				$admin = $this->session->userdata('admin');
				$save['name'] = $this->input->post('name');
				$save['quantity'] = $this->input->post('quantity');
				$save['price'] = $this->input->post('price');
                $save['supplier'] = $this->input->post('supplier');
				$save['dates'] =  $this->input->post('dates');
				if($admin['user_role']==1){
					$save['admin'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['admin'] = $admin['doctor_id'];
				   }
		
		
				$inventory_management_key = $this->inventory_management_model->save($save);
				
				$reply = $this->input->post('reply');
					if(!empty($reply)){
						foreach($this->input->post('reply') as $key => $val) {
							$save_fields[] = array(
								'custom_field_id'=> $key,
								'reply'=> $val,
								'table_id'=> $inventory_management_key,
								'form'=> 6,
							);	
						
						}	
						$this->custom_field_model->save_answer($save_fields);
					}
				echo 1;
                
		}		
		
}		


function approve($id,$val){
		$this->inventory_management_model->update_status($id,$val);
		if($val==0)
			$this->session->set_flashdata('message', 'STATUS PENDING');
		else
		 	$this->session->set_flashdata('message', 'STATUS DELIVERED');
//$this->session->set_flashdata('apoin', 'ok');
		redirect('admin/inventory_management');
	}


	function delete($id=false){
		
		if($id){
			$this->inventory_management_model->delete($id);
			$this->session->set_flashdata('message',"Inventory  Deleted");
			redirect('admin/inventory_management');
		}
	}	
	
	function edit($id,$redirect=false){
		$this->auth->check_access('1', true);
		$admin = $this->session->userdata('admin');
		$data['name']= $this->supplier_model->get_medicine_categoory_by_doctor();
		$data['inventory_management'] = $this->inventory_management_model->get_payment_mode_by_id($id);	
		$data['ids']=$id;
		//echo '<pre>'; print_r($_POST);die;	
		$data['fields'] = $this->custom_field_model->get_custom_fields(6);	
		$data['tests']= $this->inventory_management_model->get_medical_test_by_patient();
		$data['page_title'] = lang('inventory_management');
		$data['fields'] = $this->custom_field_model->get_custom_fields(6);	
		$data['pateints'] = $this->patient_model->get_patients_by_doctor();
		
	$data['body'] = 'inventory_management/edit';
		$this->load->view('template/main', $data);	
  }
  function update($id){
  		                 $save['name'] = $this->input->post('name');
				 $save['quantity'] = $this->input->post('quantity');
				 $save['price'] = $this->input->post('price');
                                 $save['supplier'] = $this->input->post('supplier');
		                 $save['dates'] =  $this->input->post('dates');
				$inventory_management_key = $this->inventory_management_model->update($save,$id);
				echo 1;
				}
}
