<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller extends CI_Controller
{
	public $autoload = array();
	
	public function __construct() 
	{
		//echo "M X";
		$this->load->helper('language');
			//echo '<pre>'; print_r($this->session->all_userdata());die;
		if($this->session->userdata('lang')!="")
		{
			$this->lang->load('admin',$this->session->userdata('lang'));
		}else{
			$this->lang->load('admin', 'english');
		}
		
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		$admin	=	$this->session->userdata('admin');
		
		$setting	=	$this->get_setting();
		//echo '<pre>'; print_r($setting);die;
		if(!empty($setting->session_hours)){
			$this->session->sess_expiration = $setting->session_hours*60*60;
		}
		//$this->config->set_item('sess_expiration', 10);
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}
	
	function get_setting()
	{
		$admin = $this->session->userdata('admin');	
		if($admin['user_role']=="Admin"){
			$this->db->where('doctor_id',0); 
		return $this->db->get('settings')->row();
		}
		if($admin['user_role']==1){
			$this->db->where('doctor_id',$admin['id']); 
			return $this->db->get('settings')->row();
		}
		if($admin['user_role']==3){
			$this->db->where('doctor_id',$admin['doctor_id']); 
		return $this->db->get('settings')->row();
		}
		if($admin['user_role']==2){
			$this->db->where('doctor_id',$admin['doctor_id']); 
		return $this->db->get('settings')->row();
		}
		
	}
	
	
	public function __get($class) {
		return CI::$APP->$class;
	}
	
	function hello(){
		echo "helo";die;
	}
}