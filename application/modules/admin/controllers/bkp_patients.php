<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class patients extends MX_Controller {

    public function __construct() {
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
        $this->load->model("consultant_model");
        $this->load->model("instruction_model");
        $this->load->model("payment_mode_model");
        $this->load->model("appointment_model");
        $this->load->model("case_history_model");
        $this->load->model("treatment_advised_model");
        $this->load->model("chiff_complaint_model");
        $this->load->model("medical_history_model");
        $this->load->model("drug_allergy_model");
        $this->load->model("extra_oral_exm_model");
        //$this->load->model("treatment_advised_model");
        $this->load->model("intra_oral_exm_model");
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function index() {
        $admin = $this->session->userdata('admin');
        $username = $this->patient_model->get_username();
        //echo '<pre>'; print_r($username);die;
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Patient1";
        } else {

            $val = strlen($this->session->userdata('admin')['id']) + 7;
            $sub_str = substr($username->username, $val);
            $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
            ;
        }
        //echo '<pre>'; print_r($_POST);die;
        @$search = $_POST['search'];
        @$filter_id = $_POST['filter_id'];
        $data['patients'] = $this->patient_model->get_patients_by_doctor_filter($search, $filter_id);
        //echo '<pre>'; echo count($data['patients']);die;
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['medical_history'] = $this->medical_history_model->get_case_history_by_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['page_title'] = lang('patients');
        $data['body'] = 'patients/list';

        $this->load->view('template/main', $data);
    }

    function view($id = false, $tab = false) {
        $data['tab'] = $tab;
        $data['id'] = $id;
        $doc = 0;
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $doc = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $doc = $admin['doctor_id'];
        }
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['patients'] = $this->patient_model->get_patients_by_doctor();  //patients
        $data['contacts'] = $this->patient_model->get_patients_by_doctor(); //patients
        $data['contact'] = $this->contact_model->get_contact_by_doctor(); //contacts
        $data['payment'] = $this->prescription_model->get_payment_by_id($id);
        $data['tooth_list'] = $this->prescription_model->get_tooth_by_id($id);
        $data['appointments'] = $this->appointment_model->get_appointment_by_patient($id);
        $data['notes'] = $this->notes_model->get_notes_by_patient($id);
        $data['reports'] = $this->prescription_model->get_reports_by_id($id);
        $data['patient'] = $this->patient_model->get_patient_by_id($id);
        $data['treatment_Advised'] = $this->treatment_advised_model->get_case_history_by_doctor();
        $data['prescriptions'] = $this->patient_model->get_patients_by_medication($id);
        $data['payment_modes'] = $this->payment_mode_model->get_payment_mode_by_doctor();
        $data['images'] = $this->patient_model->get_images($id);
        $data['consultant_copy'] = $this->consultant_model->get_consultant_by_consultant();
        $data['setting'] = $this->setting_model->get_setting();
        $pre_id = $this->prescription_model->get_prescription_id();
        //echo '<pre>'; print_r($data['fields']);die;
        if (empty($pre_id) || $pre_id->prescription_id == 0) {
            $data['pre_id'] = 1001;
        } else {

            $data['pre_id'] = $pre_id->prescription_id + 1;
        }




        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }


        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['treatment_Advised_tests'] = $this->treatment_advised_model->get_medical_test_by_doctor();
        $data['treatment_Advised_ins'] = $this->instruction_model->get_instruction_by_treatment_Advised();
        $data['chiff_Complaints'] = $this->chiff_complaint_model->get_case_history_by_doctor();
        $data['medical_History'] = $this->medical_history_model->get_case_history_by_doctor();
        $data['medical_history'] = $this->medical_history_model->get_case_history_by_doctor();
        $data['drug_Allergy'] = $this->drug_allergy_model->get_case_history_by_doctor();
        $data['extra_Oral_Exm'] = $this->extra_oral_exm_model->get_case_history_by_doctor();
        $data['treatment_Advised'] = $this->treatment_advised_model->get_case_history_by_doctor();
        $data['intra_Oral_Exm'] = $this->intra_oral_exm_model->get_case_history_by_doctor();


        $data['template'] = $this->notification_model->get_invoice_header();
        $data['pres_template'] = $this->notification_model->get_template();
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();

        if ($invoice->invoice == 0) {
            $dr_invoice = $this->invoice_model->get_doctor_invoice_number();
            if (empty($dr_invoice->invoice)) {
                $data['i_no'] = 1;
            } else {
                $data['i_no'] = $dr_invoice->invoice;
            }
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }
        //echo '<pre>'; print_r($data['pres_template']);die;	

        $data['i_no1'] = $this->patient_model->get_patients_by_invoice_payment_in($id);

        $data['fees_all'] = $this->patient_model->get_patients_by_invoice_payment($id);
        $data['tooth_list'] = $this->prescription_model->get_tooth_by_id($id);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['histry'] = $this->patient_model->histry($id, $doc);
        $data['cons'] = $this->consultant_model->get_consultant_by_consultant();
        $data['body'] = 'patients/view_tabs';
        $this->load->view('template/main', $data);
    }

    function reports($pre_id) {
        $data['pre_id'] = $pre_id;
        $data['patients'] = $this->patient_model->get_patients_by_doctor();  //patients
        $data['reports'] = $this->prescription_model->get_reports_by_id($pre_id);

        $data['prescriptions'] = $this->patient_model->get_patients_by_medication($id);
        //echo '<pre>'; print_r($data['prescriptions']);die;	
        $data['body'] = 'patients/reports';
        $this->load->view('template/main', $data);
    }

    function view_report($id) {
        $data['report'] = $this->prescription_model->get_report_by_id($id);
        $data['body'] = 'patients/report';
        $this->load->view('template/main', $data);
    }

    function patient() {
        $admin = $this->session->userdata('admin');

        //echo '<pre>'; print_r($data['username']);die;	
        $data['patients'] = $this->patient_model->get_patients_by_assistant();
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['page_title'] = lang('patients');
        $data['body'] = 'patients/list';
        $this->load->view('template/main', $data);
    }

    function export() {
        $data['patients'] = $this->patient_model->get_patients_by_doctor();
        $this->load->view('patients/export', $data);
    }

    function payment_history($id) {
        $data['p_id'] = $id;
        $data['payment_modes'] = $this->payment_mode_model->get_payment_mode_by_doctor();
        $data['setting'] = $this->setting_model->get_setting();
        $data['fees_all'] = $this->patient_model->get_patients_by_invoice($id);
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();
        if ($invoice->invoice == 0) {
            $dr_invoice = $this->invoice_model->get_doctor_invoice_number();
            if (empty($dr_invoice->invoice)) {
                $data['i_no'] = 1;
            } else {
                $data['i_no'] = $dr_invoice->invoice;
            }
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }

        $data['pateints'] = $this->patient_model->get_patients_by_doctor();

        $data['id'] = $id;
        $data['page_title'] = lang('payment_history');
        $data['body'] = 'patients/payment_history';
        $this->load->view('template/main', $data);
    }

    function medication_history($id) {
        $data['prescriptions'] = $this->patient_model->get_patients_by_medication($id);
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        //echo '<pre>'; print_r($data['prescriptions']);die;
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();
        $data['page_title'] = lang('medication_history');
        $data['body'] = 'patients/medication_history';
        $this->load->view('template/main', $data);
    }

    function add() {

        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $admin = $this->session->userdata('admin');
        $data['setting'] = $this->setting_model->get_setting();
        $data['pdoctor'] = $this->patient_model->get_patients_doctor();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('blood_id', 'lang:select_blood_type', '');
            $this->form_validation->set_rules('dob', 'lang:date_of_birth', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'matches[password]');
            $this->form_validation->set_rules('contact', 'lang:phone', '');
            $this->form_validation->set_rules('address', 'lang:address', 'required');


            if ($this->form_validation->run() == true) {

                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $username = $this->patient_model->get_username();
                    if (empty($username)) {
                        $data['username'] = $admin['id'] . "Patient1";
                    } else {

                        $val = strlen($this->session->userdata('admin')['id']) + 7;

                        $sub_str = substr($username->username, $val);

                        $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
                        ;
                    }
                }
                if ($admin['user_role'] == 3) {
                    $username = $this->patient_model->get_username_by_assistant();
                    if (empty($username)) {
                        $data['username'] = $admin['doctor_id'] . "Patient1";
                    } else {

                        $val = strlen($this->session->userdata('admin')['doctor_id']) + 7;

                        $sub_str = substr($username->username, $val);

                        $data['username'] = $admin['doctor_id'] . "Patient" . ($sub_str + 1);
                        ;
                    }
                }

                $save['name'] = $this->input->post('name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = date("Y") - $this->input->post('dob');
                $save['email'] = $this->input->post('email');
                $save['username'] = $data['username'];
                $save['password'] = sha1($this->input->post('password'));
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['group'] = $this->input->post('group');

                $create = $this->input->post('date');
                if ($create == '') {
                    $create = date('Y-m-d h:i');
                }
                $save['add_date'] = $create;
                $save['medical_History'] = json_encode($this->input->post('medical_History'));
                $save['insurance'] = $this->input->post('insurance');
                $save['aadhar'] = $this->input->post('aadhar');
                $save['referredby'] = $this->input->post('referredby');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                $save['user_role'] = 2;

                //echo '<pre>'; print_r($save);die;	

                $p_key = $this->patient_model->save($save);

                $reply = $this->input->post('reply');

                $this->load->library('email');
                $this->load->helper('string');
                //$config['mailtype'] = 'html';
                //$config['charset'] = 'utf-8';
                //$this->load->library('email', $config);
                //$this->email->initialize($config);
                //echo '<pre>';print_r($message);exit;
                $message = "Hello " . $data['pdoctor']->name . ",<br />
										 New Patient Added & Patient Detail Are:<br />
										 Name 	  : " . $save['name'] . "<br />
										 Username : " . $data['username'] . "<br />
										 Password : " . $this->input->post('password') . "<br />
										 Login Link: " . site_url('admin/login');


                //$this->email->from($data['setting']->email,$data['setting']->name);
                //$this->email->to($data['pdoctor']->email);
                //$this->email->subject('New Patient Details');
                //$this->email->message(html_entity_decode($message,ENT_QUOTES, 'UTF-8'));
                //$sent = $this->email->send();
                $this->session->set_flashdata('message', "Patient is saved and username is :" . $data['username'] . " ");
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

    function search_patient() {
        $keyword = strval($_POST['query']);
        $searchmob = strval($_POST['searchmob']);

        $result = $this->patient_model->get_patients_by_doctor_search($keyword, $searchmob);
        echo "<ul>";
        foreach ($result as $resultpatient) {
            //$patientResult[] = $resultpatient->name;
            ?>
            <li><a href="<?php echo site_url('admin/patients/view/') ?>/<?php echo $resultpatient->id; ?>"><?php echo $resultpatient->name; ?></li>
            <?php
        }
        /* while($row = $result->fetch_assoc()) {
          $countryResult[] = $row["country_name"];
          } */

        echo "</ul>";
    }

    function get_patient() {
        $username = $this->patient_model->get_username();
        if (empty($username)) {
            $data['username'] = "Patient1";
        } else {
            $val = substr($username->username, 7);
            $data['username'] = "Patient" . ($val + 1);
            ;
        }
        //echo '<pre>'; print_r($data['username']);die;	
        $data['patients'] = $this->patient_model->get_patients_by_doctor_ajax($_POST['id']);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['page_title'] = lang('patients');
        //$data['body'] = 'patients/list';
        $this->load->view('patients/ajax_list', $data);
        /* 	$patients = $this->patient_model->get_patient_filter($_POST['id']);
          echo '
          <table id="example1" class="table table-bordered table-striped table-mailbox">
          <thead>
          <tr>
          <th>'.lang('serial_number').'</th>
          <th>'.lang('name').'</th>
          <th>'.lang('phone').'</th>
          <th width="20%">'.lang('action').'</th>
          </tr>
          </thead>

          ';
          if(isset($patients)):
          echo '
          <tbody>
          ';
          $i=1;foreach ($patients as $new){

          echo '
          <tr class="gc_row">
          <td>'.$i.'</td>
          <td>'.ucwords($new->name).'</td>
          <td>'.$new->contact.'</td>
          <td width="27%">
          <div class="btn-group">
          <a class="btn btn-default"  href="'.site_url('admin/patients/view_patient/'.$new->id).'"><i class="fa fa-eye"></i>'.lang('view').'</a>
          <a class="btn btn-primary"  style="margin-left:12px;" href="'.site_url('admin/patients/edit/'.$new->id).'"><i class="fa fa-edit"></i>'.lang('edit').'</a>
          <a class="btn btn-danger" style="margin-left:20px;" href="'.site_url('admin/patients/delete/'.$new->id).'" onclick="return areyousure()"><i class="fa fa-trash"></i>'.lang('delete').'</a>
          </div>
          </td>
          </tr>
          ';
          $i++;}
          echo '
          </tbody>';
          endif;

          echo '</table>';
         */
    }

    function edit($id = false) {
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['patient'] = $this->patient_model->get_patient_by_id($id);
        $data['groups'] = $this->patient_model->get_blood_group();
        $admin = $this->session->userdata('admin');

        ///echo '<pre>'; print_r($_POST);die;
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('blood_id', 'lang:select_blood_type', '');
            $this->form_validation->set_rules('dob', 'lang:date_of_birth', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'matches[password]');
            $this->form_validation->set_rules('contact', 'lang:phone', '');
            $this->form_validation->set_rules('address', 'lang:address', 'required');

            if ($this->form_validation->run()) {

                $save['name'] = $this->input->post('name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = date("Y") - $this->input->post('dob');
                $save['email'] = $this->input->post('email');
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['add_date'] = $this->input->post('date');
                $save['medical_History'] = json_encode($this->input->post('medical_History'));
                $save['insurance'] = $this->input->post('insurance');
                $save['aadhar'] = $this->input->post('aadhar');
                $save['referredby'] = $this->input->post('referredby');
                $save['group'] = $this->input->post('group');
                $save['user_role'] = 2;
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                } else {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 2,
                        );
                    }
                    //$this->custom_field_model->delete_answer($id,$form=2);
                    //$this->custom_field_model->save_answer($save_fields);	
                }


                $this->patient_model->update($save, $id);
                $this->session->set_flashdata('message', lang('patient_updated'));
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

    function add_patient() {
        $admin = $this->session->userdata('admin');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('blood_id', 'lang:select_blood_type', '');
            $this->form_validation->set_rules('dob', 'lang:date_of_birth', '');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
            $this->form_validation->set_rules('contact', 'lang:phone', 'required');
            $this->form_validation->set_rules('address', 'lang:address', '');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $username = $this->patient_model->get_username();
                    if (empty($username)) {
                        $data['username'] = $admin['id'] . "Patient1";
                    } else {

                        $val = strlen($this->session->userdata('admin')['id']) + 7;

                        $sub_str = substr($username->username, $val);

                        $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
                        ;
                    }
                }
                if ($admin['user_role'] == 3) {
                    $username = $this->patient_model->get_username_by_assistant();
                    if (empty($username)) {
                        $data['username'] = $admin['doctor_id'] . "Patient1";
                    } else {

                        $val = strlen($this->session->userdata('admin')['doctor_id']) + 7;

                        $sub_str = substr($username->username, $val);

                        $data['username'] = $admin['doctor_id'] . "Patient" . ($sub_str + 1);
                        ;
                    }
                }
                $save['name'] = $this->input->post('name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = $this->input->post('dob');
                $save['email'] = $this->input->post('email');
                $save['username'] = $data['username'];
                $save['password'] = sha1($this->input->post('password'));
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['user_role'] = 2;
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                } else {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                $p_key = $this->patient_model->save($save);
                $this->session->set_flashdata('message', "Patient is saved and username is :" . $data['username'] . " ");
                echo "Success";
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

    function view_patient($id = false) {
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['patient'] = $this->patient_model->get_patient_by_id($id);
        $data['page_title'] = lang('view') . lang('patient');
        $data['body'] = 'patients/view';
        $this->load->view('template/main', $data);
    }

    function delete($id = false) {

        if ($id) {
            $this->patient_model->delete($id);
            $this->session->set_flashdata('message', lang('patient_deleted'));
            redirect('admin/patients');
        }
    }

    function check_username() {
        $username = $_POST['username'];
        $id = $_POST['id'];
        $result = $this->patient_model->check_username($username, $id);
        if (!empty($result)) {
            echo 1;
        }
    }

    function pimages() {
        $admin = $this->session->userdata('admin');
        if ($_FILES['img'] ['name'] != '') {
            $file_name = time() . $admin['id'] . rand(1, 988) . '.' . substr(strrchr($_FILES['img']['name'], '.'), 1);

            //echo $file_name;die;
            //$config['upload_path'] = './assets/uploads/images/';
            $config['upload_path'] = 'uploads/wysiwyg/images';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['max_width'] = '10000';
            $config['max_height'] = '6000';
            $config['file_name'] = $file_name;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('img')) {
                $upload_data = $this->upload->data();

                $this->load->library('image_lib');


                //cropped thumbnail
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/wysiwyg/images/' . $upload_data['file_name'];
                $config['new_image'] = 'uploads/wysiwyg/thumbnails/' . $upload_data['file_name'];
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 268;
                $config['height'] = 249;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $data['file_name'] = $upload_data['file_name'];
            }

            if ($this->upload->display_errors() != '') {
                $data['error'] = $this->upload->display_errors();
            }

            $save['file_name'] = $data['file_name'];
        }

        $save['title'] = $this->input->post('title');
        $save['user_id'] = $this->input->post('id');
        $save['doctor_id'] = $this->input->post('doctor_id');


        $this->patient_model->save_image($save);
        $this->session->set_flashdata('message', 'Image saved');
        redirect('admin/patients/view/' . $save['user_id'] . '/images');
    }

}
