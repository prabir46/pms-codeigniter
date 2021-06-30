<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('join_us_model');
    }

    function index() {
        $redirect = $this->auth->is_logged_in(false, false);
        if ($redirect) {
            redirect('admin/calendar');
        }


        $this->load->helper('form');
        $data['redirect'] = $this->session->flashdata('redirect');
        $submitted = $this->input->post('submitted');
        if ($submitted) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $redirect = $this->input->post('redirect');
            $login = $this->auth->login_admin($username, $password, $remember);
            $redirect = site_url('admin/calendar');
            if ($login) {
                if ($redirect == '') {
                    $redirect = site_url('admin/calendar');
                }
                redirect($redirect);
            } else {
                //this adds the redirect back to flash data if they provide an incorrect credentials
                $this->session->set_flashdata('redirect', $redirect);
                $this->session->set_flashdata('error', lang('authenication_failed'));
                redirect('admin/login');
            }
        }
        $this->load->view('login/login', $data);
    }

    function api() {
        $this->load->helper('form');
        $submitted = $this->input->post('submitted');
        $ret = 0;
        if ($submitted) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $login = $this->auth->login_admin($username, $password, $remember);
            if ($login) {
                $ret = 1;
            }
        }
        echo $ret;
    }

    function new_api() {
        $this->load->helper('form');
        $submitted = $this->input->post('submitted');

        $ret = 1;
        if ($submitted) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $login = $this->auth->login_admin($username, $password, $remember);
            $admin = $this->session->userdata('admin');
            if ($login) {
                $ret = 0;
            }

            echo json_encode(array('status' => $ret, 'result' => $admin));
        } else {
            echo json_encode(array('status' => $ret));
        }
    }

    function get_admin() {
        $this->load->helper('cookie');
        echo $_COOKIE['Advocate'];
    }

    function joinus() {
        $this->load->view('login/join');
    }

    function api_register() {
        $this->load->helper('form');
        $name = $this->input->post('name');
        $mob = $this->input->post('mobile');
        $email = $this->input->post('email');
        $save['name'] = $name;
        $save['phone'] = $mob;
        $save['email'] = $email;
        $subject = "Someone is interested in us!";
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $message = "<h3> Hello Doctor, looks like " . $name . "is interested in us! </h3> <br> <h4> Contact : " . $mob . " Email : " . $email . "</h4>";
        $res = mail("maildoctori8@gmail.com", $subject, $message, $header);
        $this->join_us_model->save($save);
        echo '1';
    }

    function join() {
        $redirect = $this->auth->is_logged_in(false, false);
        if ($redirect) {
            redirect('admin/dashboard');
        }
        $this->load->helper('form');
        $submitted = $this->input->post('submitted');
        if ($submitted) {
            $name = $this->input->post('name');
            $mob = $this->input->post('mobile');
            $email = $this->input->post('email');
            if ($mob == '' && $email == '') {
                $this->session->set_flashdata('error', 'Either Email or Mobile must be provided');
                redirect('admin/login/joinus');
            }
            $save['name'] = $name;
            $save['phone'] = $mob;
            $save['email'] = $email;
            $subject = "Someone is interested in us!";
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            $message = "<h3> Hello Doctor, looks like " . $name . "is interested in us! </h3> <br> <h4> Contact : " . $mob . " Email : " . $email . "</h4>";
            $res = mail("maildoctori8@gmail.com", $subject, $message, $header);
            $this->join_us_model->save($save);
            $this->session->set_flashdata('message', 'Successfully saved! Someone will contact you soon!');
            redirect('admin/login/joinus');
        }
        redirect('admin/login');
    }

    function logout() {
        $this->auth->logout();

        //when someone logs out, automatically redirect them to the login page.
        $this->session->set_flashdata('message', lang('log_out'));
        redirect('admin/login');
    }

}
