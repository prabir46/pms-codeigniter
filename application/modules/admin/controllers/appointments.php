<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class appointments extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model("appointment_model");
        $this->load->model("setting_model");
        $this->load->model("patient_model");
        $this->load->model("contact_model");
        $this->load->model("custom_field_model");
        $this->load->model("consultant_model");
        $this->load->model("treatment_advised_model");
        $this->load->model("sms_management_model");
        error_reporting(0);
    }

    function add() {
        $data['contact_fields'] = $this->custom_field_model->get_custom_fields(4);
        $data['pdoctor'] = $this->patient_model->get_patients_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['contacts'] = $this->patient_model->get_patients_by_doctor();
        $data['setting'] = $this->setting_model->get_setting();
        $admin = $this->session->userdata('admin');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //echo '<pre>';print_r($_POST);die;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'lang:title', '');
            //$this->form_validation->set_rules('patient_id', 'lang:contact', 'required');
            //$this->form_validation->set_rules('motive', 'lang:motive', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));


            $starttime = $this->input->post('date_time');

            $checked = $this->appointment_model->check_tables($starttime);
            //echo $checked;die;
            if (!empty($checked)) {
                $this->session->set_flashdata('error', $checked);
                //redirect()
                echo 1;
                exit;
            } else {
                //echo '<pre>'; print_r($save);die;	
                $this->session->set_flashdata('message', "Appointment Created");
            }
            if ($this->form_validation->run() == true) {

                error_reporting(0);

                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $save['consultant'] = $this->input->post('consultant');
                $save['Color'] = $this->input->post('colorvalue');
                $save['title'] = $this->input->post('title');

                $save['whom'] = $this->input->post('whom');
                $save['patient_id'] = $this->input->post('patient_id');
                $save['contact_id'] = $this->input->post('contact_id');
                $save['other'] = $this->input->post('other');
                $save['motive'] = $this->input->post('motive');
                $save['notes'] = $this->input->post('notes');
                $save['date'] = $this->input->post('date_time');
                $save['is_paid'] = $this->input->post('is_paid');
                $save['slot_length'] = $this->input->post('slot');
                $ptnt = $this->input->post('patient_id');
                $data_patient = $this->patient_model->get_cont($ptnt);
                $gender = '';
                $patient_name = '';

                foreach ($data_patient as $newx) {
                    $gender = $newx->gender;
                    $patient_name = $newx->name;
                }
                $mr = '';
                if ($gender == 'Male') {
                    $mr = 'Mr';
                } else {
                    $mr = 'Miss';
                }
                $ad = '';
                if ($admin['user_role'] == 1) {
                    $ad = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $ad = $admin['doctor_id'];
                }
                $admin = '';
                $admin_names = $this->patient_model->get_cont($ad);
                foreach ($admin_names as $newadmin) {
                    $admin = $newadmin->name;
                    $doc_address = $newadmin->address;
                    $doc_contact = $newadmin->contact;
                }
                $cntc = $this->patient_model->get_cont($ptnt);
                $contact = '';
                foreach ($cntc as $new) {
                    $contact = $new->contact;
                }
                $dtates = $this->input->post('date_time');
                $dtate = date('d/m/Y h:i:s a', strtotime($dtates));
                $sms = $this->input->post('is_paid');
                if ($sms == 1) {
                    /* Send SMS using PHP */

                    //Your authentication key
                    $authKey = "144872ArhHeSNu58c7bb84";

                    //Multiple mobiles numbers separated by comma
                    $mobileNumber = $contact;


                    //Sender ID,While using route4 sender id should be 6 characters long.
                    $senderId = "DOCTRI";

                    //Your message to send, Add URL encoding here.
                    $mesg = "Dear " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . "  ADDRESS : " . $doc_address . " PHONE NO : " . $doc_contact . "  Thanks";
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

                    //echo $output;
                }
                $save['status'] = 1;
                //echo '<pre>';print_r($save);die;
                $p_key = $this->appointment_model->save($save);
                $this->load->library('email');
                $this->load->helper('string');
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $this->load->library('email', $config);
                $this->email->initialize($config);

                if ($save['whom'] == 1) { //patient
                    $patient = $this->patient_model->get_patient_by_id($save['patient_id']);
                    //Send to doctor
                    $message = "Hello " . $data['pdoctor']->name . ",<br />
										 New Appointment Created With Patient Detail Are:<br />
										 Title 	  : " . $save['title'] . "<br />
										 Patient  : " . $patient->name . "<br />
										 Date : " . date('d/m/Y h:i a', strtotime($save['date'])) . "							
										";
                    //Send to patient
                    $this->email->from($data['setting']->email, $data['setting']->name);
                    $this->email->to($data['pdoctor']->email);
                    $this->email->subject('New Appointment Created ' . $save['title']);
                    $this->email->message(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                    $this->email->send();

                    $message = "Hello " . $patient->name . ",<br />
										 New Appointment Created With Doctor Detail Are:<br />
										 Title 	  : " . $save['title'] . "<br />
										 Doctor  : " . $data['pdoctor']->name . "<br />
										 Date : " . date('d/m/Y h:i a', strtotime($save['date'])) . "							
										";

                    $this->email->from($data['setting']->email, $data['setting']->name);
                    $this->email->to($patient->email);
                    $this->email->subject('New Appointment Created ' . $save['title']);
                    $this->email->message(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                    $this->email->send();
                }
                if ($save['whom'] == 2) { //contact
                    //Send to doctor
                    $contact = $this->contact_model->get_contact_by_id($save['contact_id']);
                    $message = "Hello " . $data['pdoctor']->name . ",<br />
										 New Appointment Created With Contact Detail Are:<br />
										 Title 	  : " . $save['title'] . "<br />
										 Contact  : " . $contact->name . "<br />
										 Date : " . date('d/m/Y h:i a', strtotime($save['date'])) . "							
										";
                    //Send to patient
                    $this->email->from($data['setting']->email, $data['setting']->name);
                    $this->email->to($data['pdoctor']->email);
                    $this->email->subject('New Appointment Created ' . $save['title']);
                    $this->email->message(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                    $this->email->send();

                    $message = "Hello " . $contact->name . ",<br />
										 New Appointment Created With Doctor Detail Are:<br />
										 Title 	  : " . $save['title'] . "<br />
										 Doctor  : " . $data['pdoctor']->name . "<br />
										 Date : " . date('d/m/Y h:i a', strtotime($save['date'])) . "							
										";

                    $this->email->from($data['setting']->email, $data['setting']->name);
                    $this->email->to($contact->email);
                    $this->email->subject('New Appointment Created ' . $save['title']);
                    $this->email->message(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                    $this->email->send();
                }

                if ($save['whom'] == 3) { //other
                    //Send to doctor
                    $message = "Hello " . $data['pdoctor']->name . ",<br />
										 New Appointment Created  Detail Are:<br />
										 Title 	  : " . $save['title'] . "<br />
										 Contact Person  : " . $save['other'] . "<br />
										 Date : " . date('d/m/Y h:i a', strtotime($save['date'])) . "							
										";
                    //Send to patient
                    $this->email->from($data['setting']->email, $data['setting']->name);
                    $this->email->to($data['pdoctor']->email);
                    $this->email->subject('New Appointment Created ' . $save['title']);
                    $this->email->message(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                    $this->email->send();
                }

                //$this->session->set_flashdata('message', lang('appointment_created'));
                echo 1;
            } else {

                echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>' . validation_errors() . '
											</div>
				';
            }
        }
    }

    function edit_appointment($id) {
        $data['contact_fields'] = $this->custom_field_model->get_custom_fields(4);

        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['contacts'] = $this->patient_model->get_patients_by_doctor();
        $admin = $this->session->userdata('admin');


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $starttime = $this->input->post('date_time');

            $checked = $this->appointment_model->check_tables($starttime);
            //echo $checked;die;
            if (!empty($checked)) {
                $this->session->set_flashdata('error', $checked);
                //redirect()
                echo 1;
                exit;
            } else {
                //echo '<pre>'; print_r($save);die;	
                $this->session->set_flashdata('message', "Appointment Updated");
            }


            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'lang:title', '');
            $this->form_validation->set_rules('motive', 'lang:motive', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));
            //	echo '<pre>';print_r($_POST);die;



            if ($this->form_validation->run() == true) {
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $save['title'] = $this->input->post('title');
                $save['whom'] = $this->input->post('whom');
                $save['patient_id'] = $this->input->post('patient_id');
                $save['contact_id'] = $this->input->post('contact_id');
                $save['other'] = $this->input->post('other');
                $save['motive'] = $this->input->post('motive');
                $save['notes'] = $this->input->post('notes');
                $save['date'] = $this->input->post('date_time');
                $save['is_paid'] = $this->input->post('is_paid');
                $save['status'] = 1;
                $p_key = $this->appointment_model->update($save, $id);

                //$this->session->set_flashdata('message', lang('appointment_created'));
                echo 1;
            } else {

                echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>' . validation_errors() . '
											</div>
				';
            }
        }
    }

    function check_datetime() {
        $starttime = $_POST['datetime'];
        $checked = $this->appointment_model->check_tables($starttime);
        //echo $checked;die;
        if (!empty($checked)) {
            //redirect()
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }

    function set_time() {
        $data['body'] = 'appointments/list';
        $this->load->view('template/main', $data);
    }

    function index() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 3) {
            $data['times_all'] = $this->appointment_model->get_appointment_time($admin['doctor_id']);
            $data['appointments'] = $this->appointment_model->get_appointment_by_doctor($admin['doctor_id']);
        } else {
            $data['times_all'] = $this->appointment_model->get_appointment_time($admin['id']);
            $data['appointments'] = $this->appointment_model->get_appointment_by_doctor($admin['id']);
        }


        $data['groups'] = $this->patient_model->get_blood_group();
        $data['contacts'] = $this->patient_model->get_patients_by_doctor();

        $data['contact'] = $this->contact_model->get_contact_by_doctor();
        $data['sms'] = $this->sms_management_model->get_list();

        //echo '<pre>'; print_r($data['appointments']);die;
        $data['page_title'] = lang('appointments');
        $data['body'] = 'appointments/list';
        $this->load->view('template/main', $data);
    }

    function approve($id, $val) {
        $this->appointment_model->update_status($id, $val);
        if ($val == 1)
            $this->session->set_flashdata('message', lang('appointment_approved'));
        else
            $this->session->set_flashdata('message', lang('appointment_reject'));
        redirect('admin/appointments');
    }

    function approved($id, $val) {
        $this->appointment_model->update_status_flag($id, $val);
        if ($val == 1)
            $this->session->set_flashdata('message', 'Waiting');
        elseif ($val == 2)
            $this->session->set_flashdata('message', 'Engaged');
        elseif ($val == 3)
            $this->session->set_flashdata('message', 'Checked Out');

        redirect('admin/calendar');
    }

    function close_record($id, $p_id = false) {
        $this->appointment_model->close_record($id);

        if (!empty($p_id)) {
            $this->session->set_flashdata('message', "Appointment Closed");
            redirect('admin/patients/view/' . $p_id . '/appointment');
        } else {
            $this->session->set_flashdata('message', "Appointment Closed");
            redirect('admin/appointments');
        }
    }

    function set() {
        $admin = $this->session->userdata('admin');

        $data['fields'] = $this->custom_field_model->get_custom_fields(5);

        //echo '<pre>'; print_r($data['times']);die;
        if ($this->input->post('ok')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start_date', 'lang:start_date', '');

            if ($this->form_validation->run() == true) {

                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('title');
                $save['mon_start'] = $this->input->post('mon_start');
                $save['mon_end'] = $this->input->post('mon_end');

                $save['tue_start'] = $this->input->post('tue_start');
                $save['tue_end'] = $this->input->post('tue_end');

                $save['wed_start'] = $this->input->post('wed_start');
                $save['wed_end'] = $this->input->post('wed_end');

                $save['thu_start'] = $this->input->post('thu_start');
                $save['thu_end'] = $this->input->post('thu_end');

                $save['fri_start'] = $this->input->post('fri_start');
                $save['fri_end'] = $this->input->post('fri_end');

                $save['sat_start'] = $this->input->post('sat_start');
                $save['sat_end'] = $this->input->post('sat_end');

                $save['sun_start'] = $this->input->post('sun_start');
                $save['sun_end'] = $this->input->post('sun_end');
                //echo '<pre>'; print_r($save);die;	

                $this->appointment_model->save_days($save);
                $this->session->set_flashdata('message', lang('appointment_created'));
                redirect('admin/appointments');
            }
        }


        $data['page_title'] = lang('add') . lang('appointment');
        $data['body'] = 'appointments/set';

        $this->load->view('template/main', $data);
    }

    function edit($id) {
        $data['id'] = $id;
        $admin = $this->session->userdata('admin');

        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['times'] = $this->appointment_model->check_time($id);
        //echo '<pre>'; print_r($data['times']);die;
        if ($this->input->post('ok')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start_date', 'lang:start_date', '');

            if ($this->form_validation->run() == true) {
                //echo '<pre>'; print_r($this->input->post());die;

                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('title');
                $save['mon_start'] = $this->input->post('mon_start');
                $save['mon_end'] = $this->input->post('mon_end');

                $save['tue_start'] = $this->input->post('tue_start');
                $save['tue_end'] = $this->input->post('tue_end');

                $save['wed_start'] = $this->input->post('wed_start');
                $save['wed_end'] = $this->input->post('wed_end');

                $save['thu_start'] = $this->input->post('thu_start');
                $save['thu_end'] = $this->input->post('thu_end');

                $save['fri_start'] = $this->input->post('fri_start');
                $save['fri_end'] = $this->input->post('fri_end');

                $save['sat_start'] = $this->input->post('sat_start');
                $save['sat_end'] = $this->input->post('sat_end');

                $save['sun_start'] = $this->input->post('sun_start');
                $save['sun_end'] = $this->input->post('sun_end');
                //echo '<pre>'; print_r($save);die;	

                $this->appointment_model->update_days($save, $id);
                $this->session->set_flashdata('message', lang('appointment_created'));
                redirect('admin/appointments');
            }
        }


        $data['page_title'] = lang('add') . lang('appointment');
        $data['body'] = 'appointments/edit';

        $this->load->view('template/main', $data);
    }

    function view_appointment($id = false) {
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['appointment'] = $this->appointment_model->get_appointment_by_id($id);
        $data['patients'] = $this->patient_model->get_patients_by_doctor();
        $data['contacts'] = $this->contact_model->get_contact_by_doctor();
        //echo '<pre>'; print_r($data['appointment']);die;
        $data['id'] = $id;
        $this->appointment_model->appointment_view_by_admin($id);
        $data['page_title'] = lang('view') . lang('appointment');
        $data['body'] = 'appointments/view';
        $this->load->view('template/main', $data);
    }

    function view_all() {

        $data['appointments'] = $this->setting_model->get_appointment_alert();
        $ids = '';
        foreach ($data['appointments'] as $ind => $key) {

            $ids[] = $key->id;
        }
        $this->appointment_model->appointments_view_by_admin($ids);
        $data['page_title'] = lang('view_all') . ' ' . lang('appointments');
        $data['body'] = 'appointments/view_all';
        $this->load->view('template/main', $data);
    }

    function delete($id = false, $redirect = false) {

        if ($id) {
            $this->appointment_model->delete($id);
            $this->session->set_flashdata('message', lang('appointment_deleted'));

            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect . '/appointment');
            } else {
                redirect('admin/appointments');
            }
        }
    }

    function delete_days($id = false) {

        if ($id) {
            $this->appointment_model->delete_days($id);
            $this->session->set_flashdata('message', lang('appointment_deleted'));
            redirect('admin/appointments');
        }
    }

}
