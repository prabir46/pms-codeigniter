<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_invoice extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_access('1', true);
		$this->auth->is_logged_in();
		$this->load->model("notification_model");		
	}
	
	

	function index(){
		
		$admin = $this->session->userdata('admin');
		$data['template'] = $this->notification_model->get_invoice_header();
		
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
                {	
				$save['doctor_id'] = $admin['id'];
                                if(empty($_FILES['header_file']['name'])){
				$save['header'] = $this->input->post('header');
                                }
                                else{
                                $info = pathinfo($_FILES['header_file']['name']);
                                $ext = $info['extension']; // get the extension of the file
                                $newname = "invoice_header".$admin['id'].".".$ext;
                                $save['header'] = base_url('assets/img/'.$newname);
                                $target ='/home/doctori8/public_html/doctor/assets/img/'.$newname;
                                move_uploaded_file($_FILES['header_file']['tmp_name'], $target);
                                }
				$save['footer'] = $this->input->post('footer');
				
			
				$this->notification_model->update_invoice_header($save);
                                $this->session->set_flashdata('message','Invoice Template Successfully Updated');
				redirect('admin/manage_invoice');
			
		
		 }
		
		$data['page_title'] = 'Manage Invoice';
		$data['body'] = 'invoice_template/template';
		$this->load->view('template/main', $data);	

			
	       }
	
		
	
}