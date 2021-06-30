<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lab_management extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();	
		//$this->auth->check_access('1', true);
		$this->load->model("consultant_model");
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
		$this->load->library('form_validation');
                $this->load->model("treatment_advised_model");
		$this->load->library('session');
//error_reporting(0); 
	}
	
	
	function index($id=false){
	$data['p_id']= $id;
	$admin = $this->session->userdata('admin');
		$data['consultant_copy']= $this->consultant_model->get_consultant_by_consultant();
		$data['pateints']= $this->patient_model->get_patients_by_doctor();
		
		//echo '<pre>'; print_r($_POST);die;	
		$data['fields'] = $this->custom_field_model->get_custom_fields(6);	
if($admin['user_role']==1){
					$ad = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$ad = $admin['doctor_id'];
				   }
		$data['tests']= $this->lab_management_model->get_medical_test_by_patient1($ad);
                $data['lab_select_work']= $this->lab_management_model->lab_select_work($ad);
		$data['page_title'] = lang('lab_management');
		$data['body'] = 'lab_management/lab_management_list';
		$this->load->view('template/main', $data);	

	}	


function get_labcontroller(){
$data['lab']=$this->lab_management_model->get_lab_modl();
$this->load->view('template/main',$data);
} 
	
	function add(){
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
                 {	
			
				$admin = $this->session->userdata('admin');
				$save['patient_id'] = $this->input->post('patient_id');
				$save['lab_select'] = $this->input->post('lab_select');
				$save['lab_select_work'] = $this->input->post('lab_select_work');
                                $save['lab_payment'] = $this->input->post('lab_payment');
                                $save['dates'] = $this->input->post('dates');
                                $save['order_date'] = $this->input->post('dates');
                                $save['order_date']=$this->input->post('dates1');
				$save['status'] =  $this->input->post('lab_status');
				if($admin['user_role']==1){
					$save['admin'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['admin'] = $admin['doctor_id'];
				   }
		
		               $this->db->where('name',$save['lab_select']);
		               $bal=$this->db->get('lab')->row(0);
		               $mob=$bal->mobile;
		                $authKey = "144872ArhHeSNu58c7bb84";

           //Multiple mobiles numbers separated by comma
           $mobileNumber = $mob;
           // echo $fir;
           // echo '\n';
           //Sender ID,While using route4 sender id should be 6 characters long.
           $senderId = "DOCTRI";

           //Your message to send, Add URL encoding here.
           $mesg = "DEAR " .$save['lab_select'].", please collect ".$save['lab_select_work']." work from " .$admin['name']." " ;
           $message = urlencode($mesg);

           //Define route
           $route = 4;
           //Prepare you post parameters
           $postData = array(
               'authkey' => $authKey,
               'mobiles' => $mobileNumber,
               'message' => $message,
               'sender' => $senderId,
               'route' => $route
           );

           //API URL
           $url = "http://sms.globehost.com/api/sendhttp.php?";

           // init the resource
           $ch = curl_init();
           curl_setopt_array($ch, array(
               CURLOPT_URL => $url,
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_POST => true,
               CURLOPT_POSTFIELDS => $postData
               //,CURLOPT_FOLLOWLOCATION => true
           ));


           //Ignore SSL certificate verification
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


           //get response
           $output = curl_exec($ch);

           //Print error if any
           if (curl_errno($ch)) {
               echo 'error:' . curl_error($ch);
           }

           curl_close($ch);
				$lab_management_key = $this->lab_management_model->save($save);
				
				$reply = $this->input->post('reply');
					if(!empty($reply)){
						foreach($this->input->post('reply') as $key => $val) {
							$save_fields[] = array(
								'custom_field_id'=> $key,
								'reply'=> $val,
								'table_id'=> $lab_management_key,
								'form'=> 6,
							);	
						
						}	
						$this->custom_field_model->save_answer($save_fields);
					}
			//	echo 1;
                
		}		
		
}		


function approve($id,$val){
		$this->lab_management_model->update_status($id,$val);
		if($val==0)
			$this->session->set_flashdata('message', 'STATUS PENDING');
		elseif($val==1)
		 	$this->session->set_flashdata('message', 'STATUS DELIVERED');
		elseif($val==2)
                    $this->session->set_flashdata('message', 'STATUS RECEIVED');
                //$this->session->set_flashdata('apoin', 'ok');
		redirect('admin/lab_management');
	}


	function delete($id=false){
		
		if($id){
			$this->lab_management_model->delete($id);
			$this->session->set_flashdata('message',"Lab Management Deleted");
			redirect('admin/lab_management');
		}
	}	
	
	function edit($id,$redirect=false){
		$this->auth->check_access('1', true);
		$admin = $this->session->userdata('admin');
		$data['lab_management'] = $this->lab_management_model->get_payment_mode_by_id($id);	
		$data['ids']=$id;
		//echo '<pre>'; print_r($_POST);die;	
		$data['fields'] = $this->custom_field_model->get_custom_fields(6);	
		$data['tests']= $this->lab_management_model->get_medical_test_by_patient();
		$data['page_title'] = lang('lab_management');
		$data['fields'] = $this->custom_field_model->get_custom_fields(6);	
		$data['pateints'] = $this->patient_model->get_patients_by_doctor();
                 if($admin['user_role']==1){
					$ad = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$ad = $admin['doctor_id'];
				   }
		$data['lab_select_work']= $this->lab_management_model->lab_select_work($ad);
	$data['body'] = 'lab_management/edit';
		$this->load->view('template/main', $data);	
  }
  function add_appointment($id,$redirect=false){
		$this->auth->check_access('1', true);
		$admin = $this->session->userdata('admin');
		$data['lab_management'] = $this->lab_management_model->get_payment_mode_by_id($id);	
		$data['ids']=$id;
		//echo '<pre>'; print_r($_POST);die;	
		$data['consultant_copy']= $this->consultant_model->get_consultant_by_consultant();
		
		$data['page_title'] = lang('lab_management');
		
		$data['pateints'] = $this->patient_model->get_patients_by_doctor();
                 if($admin['user_role']==1){
					$ad = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$ad = $admin['doctor_id'];
				   }
		$data['lab_select_work']= $this->lab_management_model->lab_select_work($ad);
	$data['body'] = 'lab_management/add_appointment';
        $treatment_Advised = $this->treatment_advised_model->get_case_history_by_doctor();
        $data['treatment_Advised'] = $treatment_Advised;

		$this->load->view('template/main', $data);	
  }
  function update($id){
  		$save['patient_id'] = $this->input->post('patient_id');
				$save['lab_select'] = $this->input->post('lab_select');
				$save['lab_select_work'] = $this->input->post('lab_select_work');
                $save['lab_payment'] = $this->input->post('lab_payment');
 $save['dates'] = $this->input->post('dates');
				//$save['status'] =  $this->input->post('lab_status');
				$lab_management_key = $this->lab_management_model->update($save,$id);
				echo 1;
				}
}
