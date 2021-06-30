<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class expenses extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();	
		$this->load->model("expenses_model");
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	
	
	function index($id=false){
	        $admin = $this->session->userdata('admin');
		$data['all_expenses']= $this->expenses_model->get_all();
		$data['page_title'] = 'Expenses';
		$data['body'] = 'expenses/list';
		$this->load->view('template/main', $data);	
	}

	function edit($id=false)
    {
        $admin = $this->session->userdata('admin');
        $this->db->where('id',$id);
        $data['new']=$this->db->get('expenses')->row();
        $data['page_title'] = 'Expenses';
        $data['body'] = 'expenses/edit';
        $this->load->view('template/main', $data);
    }

        function add(){
                $admin = $this->session->userdata('admin');
                if($admin['user_role']==1){
                $save['doctor_id'] = $admin['id'];
                }
                else{
                $save['doctor_id'] = $admin['doctor_id'];
               /* echo $save['doctor_id'];
                die;*/
                }
                if($this->input->server('REQUEST_METHOD')=='POST'){
                     $save['date'] = $this->input->post('date');
                     $save['details'] = $this->input->post('details');
                     $save['amount'] = $this->input->post('amount');
                     $this->expenses_model->save($save);
                     echo 1;
                     return;
                }
                echo 0;
        }	

        function edit_new()
        {
            $admin = $this->session->userdata('admin');
            if($admin['user_role']==1){
                $save['doctor_id'] = $admin['id'];
            }
            else{
                $save['doctor_id'] = $admin['doctor_id'];
            }
            if($this->input->server('REQUEST_METHOD')=='POST'){
                $save['date'] = $this->input->post('date');
                $save['details'] = $this->input->post('details');
                $save['amount'] = $this->input->post('amount');
                $id = $this->input->post('id');
                $this->db->where('id',$id);
              $this->db->update('expenses',$save);
                echo 1;
                return;
            }
            echo 0;
        }
        function delete($id=false){
                $this->auth->check_access('1', true);
		if($id){
			
			$this->expenses_model->delete($id);
			$this->session->set_flashdata('message','Expense Deleted');
		}
                redirect('admin/expenses');
        }

}?>