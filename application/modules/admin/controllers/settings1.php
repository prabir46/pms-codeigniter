<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settings extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();
		$this->load->model("setting_model");
		$this->load->model("canned_message_model");
		$this->load->model("sms_management_model");
                $this->load->model("patient_model");
                $this->load->model("consultant_model");
	}
	
	

	function index(){
		$data['settings'] = $this->setting_model->get_setting();
		$data['admin']	  =	$admin = $this->session->userdata('admin');	
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'lang:company_name', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
			if ($this->form_validation->run()==true)
            {
				$photo = array();
					if($_FILES['img'] ['name'] !='')
					{ 
						
					
						$config['upload_path'] = './assets/uploads/images/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']	= '10000';
						$config['max_width']  = '10000';
						$config['max_height']  = '6000';
				
						$this->load->library('upload', $config);
				
						if ( !$img = $this->upload->do_upload('img'))
							{
								
							}
							else
							{
								$img_data = array('upload_data' => $this->upload->data());
								$save['image'] = $img_data['upload_data']['file_name'];
							}
						
					}
					//echo '<pre>'; print_r($_FILES);die;
					if($_FILES['db'] ['name'] !='')
					{ 
						$allext	= array('sql');
						$path = $_FILES['db']['name'];    
						$ext = pathinfo($path, PATHINFO_EXTENSION);
						//echo (in_array($ext,$allext))?'yes':'No';
						//echo '<pre>'; print_r($allext);die;
						if(in_array($ext,$allext)){
							$config['upload_path'] = './assets/';
							$config['allowed_types'] = '*';
							$config['max_size']	= '1000000000';
							$config['max_width']  = '100000000';
							$config['max_height']  = '60000000';
							$config['file_name'] = 'doctor_db';
							$config['overwrite'] = TRUE;
							
							$this->load->library('upload', $config);
				
							if ( !$img = $this->upload->do_upload('db'))
							{
								$error = array('error' => $this->upload->display_errors());
								print_r($error);
								exit;
							}
							else
							{
								$img_data = array('upload_data' => $this->upload->data());
								//echo '<pre>'; print_r($img_data);die;
								$query = $this->db->query("SHOW TABLES");
								  $name = $this->db->database;
								  foreach ($query->result_array() as $row)
								  {
									$table = $row['Tables_in_' . $name];
									$this->db->query("DROP table " . $table);
								 }
								  $mysqli = new mysqli($this->db->hostname,$this->db->username,$this->db->password,$this->db->database);
									$query = file_get_contents('assets/'.$img_data['upload_data']['file_name']);
									$mysqli->multi_query($query);
							}
						}else{
							$this->session->set_flashdata('error', 'Only SQL File Allowed');
							redirect('admin/settings');
						}
					
					}
				
				$save['name'] = $this->input->post('name');
				$save['address'] = $this->input->post('address');
				$save['contact'] = $this->input->post('contact');
				$save['email'] = $this->input->post('email');
				$save['invoice'] 	= $this->input->post('invoice');
				$save['session_hours'] = $this->input->post('session_hours');
				if($admin['user_role']=="Admin"){
					$save['doctor_id'] = 0;
				}else{
					$save['doctor_id'] = $admin['id'];
					
			  	}
				$this->setting_model->update($save);
                $this->session->set_flashdata('message', lang('general_settings_updated'));
				redirect('admin/settings');
				
			}
		}		
		
		
		$data['page_title'] = lang('genral_settings');
		$data['body'] = 'setting/setting';
		$this->load->view('template/main', $data);	

	}
	function export(){
		 $this->load->dbutil();
		 $prefs = array(     
					'format'      => 'sql',             
					'filename'    => 'db_backup.sql'
		 );
	  	$backup =& $this->dbutil->backup($prefs); 
	  	$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.sql';
	  	$this->load->helper('download');
		force_download($db_name, $backup);
	}

        function sms_management()
        {
           $data['sms'] = $this->sms_management_model->get_list();
           $data['body'] = 'sms_management/sms_management';
           $data['page_title'] = 'SMS Management';
	   $this->load->view('template/main', $data);	
        }

        function delivery_reports()
        {
           $admin = $this->session->userdata('admin');
                if($admin['user_role']==1){
                   $id = $admin['id'];
                }
                else $id = $admin['doctor_id'];
           $data['sms'] = $this->sms_management_model->get_delivery_reports();
           $data['count'] = $this->sms_management_model->get_sms_count($id);
           $data['body'] = 'sms_management/delivery_reports';
           $data['page_title'] = 'Delivery Reports';
           $this->load->view('template/main', $data);
        }

        function sms_edit($id)
        {
           $save['type'] = $this->input->post('type');
           $save['status'] = $this->input->post('status');
           $save['lang'] = $this->input->post('lang');
           $this->sms_management_model->update($id, $save);
	   $this->session->set_flashdata('message', 'Setting Updated');
           redirect('admin/settings/sms_management');
        }
        
	function canned_messages()
    {
        $data['canned_messages'] = $this->canned_message_model->get_list();
        $data['body'] = 'canned_message/canned_messages';
		 $data['page_title'] = lang('canned_messages');
		$this->load->view('template/main', $data);	
    }

  
    function canned_message_form($id=false)
    {
        $data['page_title'] = lang('canned_message_form');

        $data['id']         = $id;
        $data['name']       = '';
        $data['subject']    = '';
        $data['content']    = '';
        $data['deletable']  = 1;
        
        if($id)
        {
            $message = $this->canned_message_model->get_message($id);
                        
            $data['name']       = $message['name'];
            $data['subject']    = $message['subject'];
            $data['content']    = $message['content'];
            $data['deletable']  = $message['deletable'];
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'lang:message_name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('subject', 'lang:subject', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('content', 'lang:message_content', 'trim|required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();
            
			$data['body'] = 'canned_message/canned_message_form';
			$this->load->view('template/main', $data);	
        }
        else
        {
            
            $save['id']         = $id;
            $save['name']       = $this->input->post('name');
            $save['subject']    = $this->input->post('subject');
            $save['content']    = $this->input->post('content');
            
            //all created messages are typed to order so admins can send them from the view order page.
            if($data['deletable'])
            {
                $save['type'] = 'order';
            }
            $this->canned_message_model->save_message($save);
            
            $this->session->set_flashdata('message', lang('message_saved_message'));
            redirect('admin/settings/canned_messages');
        }
    }
    
    function delete_message($id)
    {
        $this->canned_message_model->delete_message($id);
        
        $this->session->set_flashdata('message', lang('message_deleted_message'));
        redirect('admin/settings/canned_messages');
    }	
	
	
		
	
}