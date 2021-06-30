<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class register extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		
	}
	
	
	
	function index()
	{	
		if ($this->db->table_exists('users'))
		{
					$this->db->where('user_role',1);
					$admin  = $this->db->get('users')->row();
					
					if(!empty($admin)){
						redirect(site_url('admin/login'));
					}
		}
	
		
	
	
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Name', 'required');
		     $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[128]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('conf', 'Confirm Password', 'required|matches[password]');
		   
			if ($this->form_validation->run()==true)
            {
				//$save['id'] = 1;
				$save['name'] = $this->input->post('name');
				$save['username'] = $this->input->post('username');
                $save['password'] = sha1($this->input->post('password'));
				$save['email'] = $this->input->post('email');
			  	$save['user_role'] = 'Admin';
             	//echo '<pre>'; print_r($save);die;
				$this->auth->save($save);
             	$this->session->set_flashdata('message', 'Registration Success');
				redirect('admin/login');
			}
		}		

		
	$this->load->view('register');	
	}
	
	
	function check_table()
	{
		
		if ($this->db->table_exists('users'))
			{
			
			echo '
			    <div class="header">Register New Admin</div>
            <form action="'.site_url("register").'" method="post" id="register_form">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Name"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="conf" class="form-control" placeholder="Confirm Password"/>
                    </div>
					<div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email"/>
                    </div>
                </div>
                <div class="footer">

                    <button type="submit" class="btn bg-olive btn-block">Register</button>

                    
                </div>
            </form>
				';
          
			}else
			{
				echo 'error';
			}
	
	}

	

}