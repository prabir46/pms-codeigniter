<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class prescription extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->helper('dompdf_helper');
        $this->load->model("custom_field_model");
        $this->load->model("instruction_model");
        $this->load->model("prescription_model");
        $this->load->model("notification_model");
        $this->load->model("patient_model");
        $this->load->model("medicine_model");
        $this->load->model("disease_model");
        $this->load->model("medical_test_model");
        $this->load->model('setting_model');
        $this->load->model('case_history_model');
        $this->load->model("chiff_Complaint_model");
        $this->load->model("medical_History_model");
        $this->load->model("drug_Allergy_model");
        $this->load->model("extra_Oral_Exm_model");
        $this->load->model("treatment_Advised_model");
        $this->load->model("intra_Oral_Exm_model");
    }

    function index() {
        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        $data['chiff_Complaints'] = $this->chiff_Complaint_model->get_case_history_by_doctor();
        $data['medical_History'] = $this->medical_History_model->get_case_history_by_doctor();
        //$data['drug_Allergy'] = $this->drug_Allergy_model->get_case_history_by_doctor();
        $data['extra_Oral_Exm'] = $this->extra_Oral_Exm_model->get_case_history_by_doctor();
        $data['treatment_Advised'] = $this->treatment_Advised_model->get_case_history_by_doctor();
        $data['intra_Oral_Exm'] = $this->intra_Oral_Exm_model->get_case_history_by_doctor();

        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['prescriptions'] = $this->prescription_model->get_prescription_by_doctor();

        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);


        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/list';
        $this->load->view('template/main', $data);
    }

    function assistant_prescription() {
        $this->auth->check_access('3', true);
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }


        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['prescriptions'] = $this->prescription_model->get_prescription_by_doctor();

        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);


        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/assistant_prescription';
        $this->load->view('template/main', $data);
    }

    function reports($id, $redirect = false) {
        $data['id'] = $id;
        $this->prescription_model->report_is_view_by_user($id);
        //$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['reports'] = $this->prescription_model->get_reports_by_id($id);
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        //echo '<pre>'; print_r($data['reports']);die;
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('remark', 'lang:remark', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if ($_FILES['file'] ['name'] != '') {


                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {

                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                    }
                }

                $save['prescription_id'] = $id;
                $save['from_id'] = $admin['id'];

                if ($admin['user_role'] == 2) {
                    $save['to_id'] = $data['prescription']->doctor_id;
                } else {
                    $save['to_id'] = $data['prescription']->patient_id;
                }
                $save['remark'] = $this->input->post('remark');
                $save['type_id'] = $this->input->post('type_id');
                //echo '<pre>'; print_r($save);die;
                $this->prescription_model->save_report($save);
                $this->session->set_flashdata('message', lang('report_saved'));
                if ($admin['user_role'] == 1) {
                    if (!empty($redirect)) {
                        redirect('admin/patients/view/' . $redirect . '/medication_history');
                    } else {
                        redirect('admin/prescription');
                    }
                }
                if ($admin['user_role'] == 3) {
                    redirect('admin/prescription/assistant_prescription');
                }
                if ($admin['user_role'] == 2) {
                    redirect('admin/my_prescription/');
                }
            }
        }

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/reports';
        $this->load->view('template/main', $data);
    }

    function medical_history_report($id, $redirect) {
        $data['id'] = $id;
        $this->prescription_model->report_is_view_by_user($id);
        //$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['reports'] = $this->prescription_model->get_reports_by_id($id);
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        //echo '<pre>'; print_r($data['reports']);die;
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('remark', 'lang:remark', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if ($_FILES['file'] ['name'] != '') {


                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {

                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                    }
                }

                $save['prescription_id'] = $id;
                $save['from_id'] = $admin['id'];

                if ($admin['user_role'] == 2) {
                    $save['to_id'] = $data['prescription']->doctor_id;
                } else {
                    $save['to_id'] = $data['prescription']->patient_id;
                }
                $save['remark'] = $this->input->post('remark');
                $save['type_id'] = $this->input->post('type_id');
                //echo '<pre>'; print_r($save);die;
                $this->prescription_model->save_report($save);
                $this->session->set_flashdata('message', lang('report_saved'));
                if ($admin['user_role'] == 1 || $admin['user_role'] == 3) {
                    redirect('admin/patients/medication_history/' . $redirect);
                } else {
                    redirect('admin/my_prescription/');
                }
            }
        }

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/reports';
        $this->load->view('template/main', $data);
    }

    function amout() {
        $patient_id = $this->input->post('patient_id');
        $amount = $this->input->post('amount');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $amountsid = 0;
        $amnts = 0;
        $total = 0;
        $da = $this->prescription_model->amoutlast($patient_id, $docid);
        foreach ($da as $new) {
            $amountsid = $new->id;
        }
        $das = $this->prescription_model->totals($docid, $patient_id, $amountsid);
        foreach ($das as $new) {
            $amnts = $new->pending;
        }
        $status = $amount;
        $save['debit'] = $amount;
        $total = $amnts - $amount;
        $save['total'] = $total;
        $this->prescription_model->updedit($saves, $amounts);
        $fulldata = $this->prescription_model->fulldata($docid, $pat, $amountsid);
        foreach ($fulldata as $news) {
            $idf = $news->id;
            $invchec = $news->invoice;
            $am = $news->amount;
            if ($invchec != "-") {
                $total = $total - $am;
            } else {
                $total = $total + $am;
            }

            $saves['total'] = $total;
            $saves['pending'] = $total;
            $this->prescription_model->updedit($saves, $idf);
        }
        echo 1;
    }

    function save_reports() {

        //$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        //echo '<pre>'; print_r($data['reports']);die;
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //echo '<pre>'; print_r($_POST);die;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('remark', 'lang:remark', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if ($_FILES['file'] ['name'] != '') {
                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {

                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                    }
                }
                $id = $this->input->post('p_id');
                $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
                $save['prescription_id'] = $id;
                $save['from_id'] = $admin['id'];

                if ($admin['user_role'] == 2) {
                    $save['to_id'] = $data['prescription']->doctor_id;
                } else {
                    $save['to_id'] = $data['prescription']->patient_id;
                }
                $save['remark'] = $this->input->post('remark');
                //echo '<pre>'; print_r($save);die;
                $save['type_id'] = $this->input->post('type_id');
                $this->prescription_model->save_report($save);
                $this->session->set_flashdata('message', lang('report_saved'));
                if ($admin['user_role'] == 1) {
                    redirect('admin/prescription/');
                } else {
                    redirect('admin/my_prescription/');
                }
            } else {
                //redirect('admin/prescription/');
                $this->index();
            }
        }
    }

    function view($id) {
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        //echo '<pre>'; print_r($data['prescription']);die;
        $data['body'] = 'prescription/view';
        $this->load->view('template/main', $data);
    }

    function view_all_reports() {
        $this->auth->check_access('1', true);


        $data['reports'] = $this->prescription_model->get_reports_notification();

        $data['page_title'] = lang('reports');
        $data['body'] = 'prescription/view_all_reports';
        $this->load->view('template/main', $data);
    }

    function fees_dues() {
        $this->auth->check_access('Admin', true);

        $data['prescriptions'] = $this->prescription_model->get_fees_due();

        $data['page_title'] = lang('fees_due');
        $data['body'] = 'prescription/fees_due';
        $this->load->view('template/main', $data);
    }

    function get_case_history() {
        $tests = $this->medical_test_model->get_medical_test_by_doctor();
        $prescription = $this->prescription_model->get_case_history($_POST['patient_id']);
        $medicines = $this->medicine_model->get_medicine_by_doctor();
        //echo '<pre>'; print_r($prescription);die;

        $tests1 = json_decode($prescription->tests);
        $medicine1 = json_decode($prescription->medicines);


        echo '
							
	 <div class="col-md-3">';
        if (!empty($tests1)) {
            $i = 1;
            foreach ($tests1 as $key => $val) {
                if ($i == 1) {
                    $title = "Medical Test";
                } else {
                    $title = "";
                }
                echo '<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;" >' . $title . '</label>
								</div>
								<div class="col-md-8" >
									<div>
												<select name="test_report_id[]" class="form-control chzn history_report_id">
												
												';
                foreach ($tests as $new) {
                    $sel = " ";
                    if ($new->name == $val)
                        $sel = "selected='selected'";
                    echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                }

                echo '
										</select>
									</div>	
                                </div>
                                
								
                            </div>
                        </div>';
                $i++;
            } //end test1 loop
        } //end if condition	

        echo '</div><div class="col-md-3">';
        if (!empty($medicine1)) {
            $c = 1;
            foreach ($medicine1 as $key => $val) {
                if ($c == 1) {
                    $title = "Medicine";
                } else {
                    $title = "";
                }

                echo '	<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"> ' . $title . '</label>
									
								</div>
								
								<div class="col-md-8" >
												<select name="medicine_id[]" class="form-control chzn medicine_id" style="width:100%">
												<option value="">--' . lang('select_medicine') . '--</option>
												';
                foreach ($medicines as $new) {
                    $sel = " ";
                    if ($new->name == $val)
                        $sel = "selected='selected'";
                    echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                }
                echo '
										</select>
								</div>
                                
                            </div>
                        </div>';

                $c++;
            } // end medicine loop
        } //	end if condition	
        echo '</div>';
    }

    function add($id = false) {
        $data = array();
        $data['id'] = $id;
        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $username = $this->patient_model->get_username();
        //echo '<pre>'; print_r($username);die;
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Patient1";
        } else {

            $val = strlen($admin['id']) + 7;

            $sub_str = substr($username->username, $val);

            $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
            ;
        }

        $pre_id = $this->prescription_model->get_prescription_id();
        //echo '<pre>'; print_r($pre_id);die;
        if (empty($pre_id) || $pre_id->prescription_id == 0) {
            $data['pre_id'] = 1001;
        } else {

            $data['pre_id'] = $pre_id->prescription_id + 1;
        }

        $this->auth->check_access('1', true);
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['treatment_Advised_tests'] = $this->treatment_Advised_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();
        $data['treatment_Advised_ins'] = $this->instruction_model->get_instruction_by_treatment_Advised();
        $data['chiff_Complaints'] = $this->chiff_Complaint_model->get_case_history_by_doctor();
        $data['medical_History'] = $this->medical_History_model->get_case_history_by_doctor();
        $data['drug_Allergy'] = $this->drug_Allergy_model->get_case_history_by_doctor();
        $data['extra_Oral_Exm'] = $this->extra_Oral_Exm_model->get_case_history_by_doctor();
        $data['treatment_Advised'] = $this->treatment_Advised_model->get_case_history_by_doctor();
        $data['intra_Oral_Exm'] = $this->intra_Oral_Exm_model->get_case_history_by_doctor();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {


            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');
            //$this->form_validation->set_rules('disease_id', 'lang:disease', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            //$this->form_validation->set_rules('case_history_id', 'Case History Options', '');
            //$this->form_validation->set_rules('oe_description', 'O/E Description', '');
            $this->form_validation->set_rules('remark', 'Remark', '');
            $this->form_validation->set_rules('medicine_id', 'Medicine', '');
            $this->form_validation->set_rules('instruction', 'Medicine instruction', '');
            $this->form_validation->set_rules('report_id', 'Medical Test', '');
            $this->form_validation->set_rules('test_instruction', 'Medical Test instruction', '');
            $this->form_validation->set_rules('prescription_id', 'Prescription Id', '');
            //$this->form_validation->set_rules('case_history', 'Case History', '');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {

                $save['patient_id'] = $this->input->post('patient_id');
                $save['prescription_id'] = $data['pre_id'];
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($this->input->post('medicine_id'));
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($this->input->post('report_id'));
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');

                $save['chiff_Complaint_id'] = json_encode($this->input->post('chiff_Complaint_id'));
                $save['chiff_Complaint_history'] = $this->input->post('chiff_Complaint_history');
                $save['medical_History_id'] = json_encode($this->input->post('medical_History_id'));
                $save['medical_History_history'] = $this->input->post('medical_History_history');
                $save['drug_Allergy_id'] = json_encode($this->input->post('drug_Allergy_id'));
                $save['drug_Allergy_history'] = $this->input->post('drug_Allergy_history');
                $save['extra_Oral_Exm_id'] = json_encode($this->input->post('extra_Oral_Exm_id'));
                $save['extra_Oral_Exm_history'] = $this->input->post('extra_Oral_Exm_history');
                $save['intra_Oral_Exm_id'] = json_encode($this->input->post('intra_Oral_Exm_id'));
                $save['intra_Oral_Exm_history'] = json_encode($this->input->post('intra_Oral_Exm_history'));
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['treatment_Advised_instruction'] = json_encode($this->input->post('treatment_Advised_instruction'));
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));
                //echo '<pre>'; print_r($save);die;

                $p_key = $this->prescription_model->save($save);

                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $p_key,
                            'form' => 5,
                        );
                    }
                    $this->custom_field_model->save_answer($save_fields);
                }

                $this->session->set_flashdata('message', lang('prescription_saved'));
                if (!empty($id)) {
                    redirect('admin/patients/view/' . $id);
                } else {
                    redirect('admin/prescription');
                }
            }
        }
        $data['page_title'] = lang('add') . lang('prescription');
        $data['body'] = 'prescription/add';
        $this->load->view('template/main', $data);
    }

    function edit($id, $redirect = false) {
        //$this->auth->check_access('1', true);
		$post = $this->input->post();
        //echo '<pre>'; print_r($_POST);die;
		//echo '<pre>'; print_r($post);die;
		
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        $data['id'] = $id;
        $data['redirect'] = $redirect;
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();



        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();


        $data['treatment_Advised_ins'] = $this->instruction_model->get_instruction_by_treatment_Advised();
        $data['chiff_Complaints'] = $this->chiff_Complaint_model->get_case_history_by_doctor();
        $data['medical_History'] = $this->medical_History_model->get_case_history_by_doctor();
        $data['drug_Allergy'] = $this->drug_Allergy_model->get_case_history_by_doctor();
        $data['extra_Oral_Exm'] = $this->extra_Oral_Exm_model->get_case_history_by_doctor();
        $data['treatment_Advised'] = $this->treatment_Advised_model->get_case_history_by_doctor();
        $data['intra_Oral_Exm'] = $this->intra_Oral_Exm_model->get_case_history_by_doctor();
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();


        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');

            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {


                $medicines = array();
                $medi_id = $this->input->post('medicine_id');
                if (!empty($medi_id)) {
                    foreach ($this->input->post('medicine_id') as $key => $val) {
                        if (!empty($val))
                            $medicines[] = $val;
                    }
                }
                /* $medicines_ins = array();
                  foreach($this->input->post('instruction') as $key =>$val){
                  if(!empty($val))
                  $medicines_ins[] = $val;
                  } */

                $tests = array();
                $rep_id = $this->input->post('report_id');
                if (!empty($rep_id)) {
                    foreach ($this->input->post('report_id') as $key => $val) {
                        if (!empty($val))
                            $tests[] = $val;
                    }
                }
                /* 				$tests_ins = array();
                  foreach($this->input->post('test_instruction') as $key =>$val){
                  if(!empty($val))
                  $tests_ins[] = $val;
                  } */


                $save['patient_id'] = $this->input->post('patient_id');

                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($medicines);
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($tests);
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));
                $save['chiff_Complaint_id'] = json_encode($this->input->post('chiff_Complaint_id'));
                $save['chiff_Complaint_history'] = $this->input->post('chiff_Complaint_history');
                $save['medical_History_id'] = json_encode($this->input->post('medical_History_id'));
                $save['medical_History_history'] = $this->input->post('medical_History_history');
                $save['drug_Allergy_id'] = json_encode($this->input->post('drug_Allergy_id'));
                $save['drug_Allergy_history'] = $this->input->post('drug_Allergy_history');
                $save['extra_Oral_Exm_id'] = json_encode($this->input->post('extra_Oral_Exm_id'));
                $save['extra_Oral_Exm_history'] = $this->input->post('extra_Oral_Exm_history');
                $save['intra_Oral_Exm_id'] = json_encode($this->input->post('intra_Oral_Exm_id'));
                //$save['intra_Oral_Exm_history'] =  $this->input->post('intra_Oral_Exm_history'); 
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['treatment_Advised_instruction'] = json_encode($this->input->post('treatment_Advised_instruction'));
				
				$save['medicine_template_id'] = json_encode($this->input->post('medicine_template_id'));
				
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 5,
                        );
                    }
                    $this->custom_field_model->delete_answer($id, $form = 1);
                    $this->custom_field_model->save_answer($save_fields);
                }
                //echo '<pre>'; print_r($_POST);die;
                $this->prescription_model->update($save, $id);
                $this->session->set_flashdata('message', lang('prescription_saved'));
                if (!empty($redirect)) {
                    redirect('admin/patients/view/' . $redirect);
                } else {
                    redirect('admin/prescription');
                }
            }
        }

        $data['body'] = 'prescription/edit';
        $this->load->view('template/main', $data);
    }

    function edit_prescription($id, $redirect = false) {
        $this->auth->check_access('1', true);
        //echo '<pre>'; print_r($_POST);die;

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');

            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {


                $medicines = array();
                $medi_id = $this->input->post('medicine_id');
                if (!empty($medi_id)) {
                    foreach ($this->input->post('medicine_id') as $key => $val) {
                        if (!empty($val))
                            $medicines[] = $val;
                    }
                }
                /* $medicines_ins = array();
                  foreach($this->input->post('instruction') as $key =>$val){
                  if(!empty($val))
                  $medicines_ins[] = $val;
                  } */

                $tests = array();
                $rep_id = $this->input->post('report_id');
                if (!empty($rep_id)) {
                    foreach ($this->input->post('report_id') as $key => $val) {
                        if (!empty($val))
                            $tests[] = $val;
                    }
                }
                /* 				$tests_ins = array();
                  foreach($this->input->post('test_instruction') as $key =>$val){
                  if(!empty($val))
                  $tests_ins[] = $val;
                  } */


                $save['patient_id'] = $this->input->post('patient_id');
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($medicines);
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($tests);
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));
                $save['chiff_Complaint_id'] = json_encode($this->input->post('chiff_Complaint_id'));
                $save['chiff_Complaint_history'] = $this->input->post('chiff_Complaint_history');
                $save['medical_History_id'] = json_encode($this->input->post('medical_History_id'));
                $save['medical_History_history'] = $this->input->post('medical_History_history');
                $save['drug_Allergy_id'] = json_encode($this->input->post('drug_Allergy_id'));
                $save['drug_Allergy_history'] = $this->input->post('drug_Allergy_history');
                $save['extra_Oral_Exm_id'] = json_encode($this->input->post('extra_Oral_Exm_id'));
                $save['extra_Oral_Exm_history'] = $this->input->post('extra_Oral_Exm_history');
                $save['frequency'] = json_encode($this->input->post('frequency'));
				$save['medicine_template_id'] = json_encode($this->input->post('medicine_template_id_edit'));
				
                $duration1 = $this->input->post('duration1');
                $duration2 = $this->input->post('duration2');
                $duration = array();
                foreach ($duration1 as $key => $value) {
                    array_push($duration, $value.' '.$duration2[@$key]);
                }
                $save['duration'] = json_encode($duration);
                $arr = array();
                for ($i = 1; $i < 20; $i++) {
                    if (isset($_POST['intra_Oral_Exm_' . $i])) {
                        $arr[$i - 1] = $_POST['intra_Oral_Exm_' . $i];
                    }
                }
                $save['intra_Oral_Exm_id'] = json_encode($this->input->post('intra_Oral_Exm_id'));
                $save['intra_Oral_Exm_history'] = json_encode($arr);
				
				
				$treatAdv = array();
                for ($i = 1; $i < 20; $i++) {
                    if (isset($_POST['treatment_Advised_id_' . $i])) {
                        $treatAdv[$i - 1] = $_POST['treatment_Advised_id_' . $i];
                    }
                }
				$treatAdvIns = array();
                for ($i = 1; $i < 20; $i++) {
                    if (isset($_POST['treatment_Advised_instruction_' . $i])) {
                        $treatAdvIns[$i - 1] = $_POST['treatment_Advised_instruction_' . $i];
                    }
                }
                $save['treatment_Advised_id'] = json_encode($treatAdv);
                $save['treatment_Advised_instruction'] = json_encode($treatAdvIns);
               
			    //echo '<pre>'; print_r($save);die;
				//$post = $this->input->post();
				//echo '<pre>'; print_r($post);die;
		
                $this->prescription_model->update($save, $id);
                $this->session->set_flashdata('message', lang('prescription_saved'));
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

    function add_prescription($id = false) {

        //$this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $username = $this->patient_model->get_username();
        //echo '<pre>'; print_r($username);die;
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Patient1";
        } else {

            $val = strlen($admin['id']) + 7;

            $sub_str = substr($username->username, $val);

            $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
            ;
        }

        $pre_id = $this->prescription_model->get_prescription_id();
        //echo '<pre>'; print_r($_POST);die;
        if (empty($pre_id) || $pre_id->prescription_id == 0) {
            $data['pre_id'] = 1001;
        } else {

            $data['pre_id'] = $pre_id->prescription_id + 1;
        }

        //$this->auth->check_access('1', true);
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();


        if ($this->input->server('REQUEST_METHOD') === 'POST') {


            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');
            //$this->form_validation->set_rules('disease_id', 'lang:disease', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            //$this->form_validation->set_rules('case_history_id', 'Case History Options', '');
            //$this->form_validation->set_rules('oe_description', 'O/E Description', '');
            $this->form_validation->set_rules('remark', 'Remark', '');
            $this->form_validation->set_rules('medicine_id', 'Medicine', '');
            //$this->form_validation->set_rules('instruction', 'Medicine instruction', '');
            $this->form_validation->set_rules('report_id', 'Medical Test', '');
            $this->form_validation->set_rules('test_instruction', 'Medical Test instruction', '');
            $this->form_validation->set_rules('prescription_id', 'Prescription Id', '');
            //$this->form_validation->set_rules('case_history', 'Case History', '');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {


                $save['patient_id'] = $this->input->post('patient_id');
                $save['prescription_id'] = $data['pre_id'];
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
              //  $save['medicines'] = json_encode($this->input->post('medicine_id'));
               // $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($this->input->post('report_id'));
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');

                $save['chiff_Complaint_id'] = json_encode($this->input->post('chiff_Complaint_id'));
                $save['chiff_Complaint_history'] = $this->input->post('chiff_Complaint_history');
                $save['medical_History_id'] = json_encode($this->input->post('medical_History_id'));
                $save['medical_History_history'] = $this->input->post('medical_History_history');
                $save['drug_Allergy_id'] = json_encode($this->input->post('drug_Allergy_id'));
				$save['medicine_template_id'] = json_encode($this->input->post('medicine_template_id'));
				
                $medicine = $this->input->post('medicine_template_id');
				//echo '$medicine <pre>'; print_r($medicine); echo '</pre>';die;
                $med=array();
                $ins=array();
                $fre=array();
                $dur=array();
                foreach($medicine as $new)
                {
                 $ashu=$this->drug_Allergy_model->get_case_history_by_id1($new);
                 foreach(json_decode($ashu->medicine) as $k){
                 $med[]=$k;}
                 foreach(json_decode($ashu->medicine_instruction) as $l){
               $ins[]=$l;}
                 foreach(json_decode($ashu->frequency) as $m){
                    $fre[]=$m;}
                     foreach(json_decode($ashu->duration) as $n){
                  $dur[]=$n;}
                }
                $med1 = $this->input->post('medicine_id');
                $ins1= $this->input->post('instruction');
                $fre1 = $this->input->post('frequency');
                $dur1= $this->input->post('duration');
                $save['medicines']=json_encode(array_merge($med1,$med));
                $save['medicine_instruction']=json_encode(array_merge($ins1,$ins));
                $save['frequency']=json_encode(array_merge($fre1,$fre));
                $save['duration']=json_encode(array_merge($dur1,$dur));
                $save['drug_Allergy_history'] = $this->input->post('drug_Allergy_history');
                $save['extra_Oral_Exm_id'] = json_encode($this->input->post('extra_Oral_Exm_id'));
                $save['extra_Oral_Exm_history'] = $this->input->post('extra_Oral_Exm_history');
                $save['intra_Oral_Exm_id'] = json_encode($this->input->post('intra_Oral_Exm_id'));
                $intra_oral_history = $this->input->post('intra_Oral_Exm_history');
                $arr = array();
                $intra_oral_history = explode(":", $intra_oral_history);
                for ($i = 1; $i < sizeof($intra_oral_history); $i++) {
                    $arr[$i - 1] = array();
                    array_push($arr[$i - 1], $intra_oral_history[$i]);
                }
                $save['intra_Oral_Exm_history'] = json_encode($arr);
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['treatment_Advised_instruction'] = json_encode($this->input->post('treatment_Advised_instruction'));

                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));
               // $save['frequency'] = json_encode($this->input->post('frequency'));
              //  $save['duration'] = json_encode($this->input->post('duration'));

                //echo '<pre>'; print_r($save);die;
                $p_key = $this->prescription_model->save($save);
                $this->db->where('id',$save['patient_id']);
                $dat['h']=$this->db->get('users')->row(0);
                $contact=$dat['h']->contact;
                $name=$dat['h']->name;
                $authKey = "144872ArhHeSNu58c7bb84";

                //Multiple mobiles numbers separated by comma
                $mobileNumber = $contact;


                //Sender ID,While using route4 sender id should be 6 characters long.
                $senderId = "DOCTRI";

                //Your message to send, Add URL encoding here.
                $mesg = "Prescription for " . $name. ",is:\n"."Rx\n".$save['medicines']."\n\n"."Regards\n".$admin['name']."\n\nDownload Doctori8 App to secure your health records.\n"."http://bit.ly/2IoxEtl.";
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
                $this->session->set_flashdata('message', lang('prescription_saved'));
                echo 1;
            } else {

                echo '<div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
			<b>Alert!</b>' . validation_errors() . '
                      </div>';
            }
        }
    }

    function pdf($id) {
        $data['template'] = $this->notification_model->get_template();

        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        $data['setting'] = $this->setting_model->get_setting();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $pdfFilePath = FCPATH . "/downloads/" . $data['prescription']->prescription_id . '.pdf';
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->autoLangToFont = true;
        $html = $this->load->view('prescription/pdf', $data, true);
        //$html = utf8_decode($html);
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        //pdf_create($html, 'Prescription_'.$data['prescription']->patient);
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "D");
    }

    function fees($id) {
        //$this->auth->check_access('1', true);
        $data['priscrition'] = $this->prescription_model->get_prescription_by_id($id);
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        $data['fees_all'] = $this->prescription_model->get_fees_all($id);
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();

        //echo '--->'. $invoice->invoice;die;
        if ($invoice->invoice == 0) {
            $data['i_no'] = 1;
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }
        $data['id'] = $id;


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('payment_mode_id', 'lang:payment_mode', 'required');
            $this->form_validation->set_rules('date', 'lang:date', 'required');
            $this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');
            if ($this->form_validation->run() == true) {
                $save['amount'] = $this->input->post('amount');
                $save['payment_mode_id'] = $this->input->post('payment_mode_id');
                $save['prescription_id'] = $id;
                $save['date'] = $this->input->post('date');
                $save['invoice'] = $data['i_no']; // $this->input->post('invoice_no');

                $this->prescription_model->save_fees($save);
                $this->session->set_flashdata('message', lang('fees_updated'));
                redirect('admin/prescription/fees/' . $id);
            }
        }
        $data['body'] = 'prescription/fees';
        $this->load->view('template/main', $data);
    }

    function get_prescription() {
        $data['prescriptions'] = $this->prescription_model->get_prescription_by_doctor_ajax($_POST['id']);

        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();


        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);


        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['page_title'] = lang('prescription');
        //$data['body'] = 'patients/list';
        $this->load->view('prescription/ajax_list', $data);
    }

    function delete($id = false, $redirect = false) {
        $this->auth->check_access('1', true);

        if ($id) {

            $this->prescription_model->delete($id);
            $this->session->set_flashdata('message', lang('prescription_deleted'));

            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect);
            } else {
                redirect('admin/prescription');
            }
        }
    }

    function delete_report($id, $redirect = false) {


        if ($id) {
            $this->prescription_model->delete_report($id);
            $this->session->set_flashdata('message', lang('report_deleted'));
            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect . '/medication_history');
            } else {
                redirect('admin/prescription');
            }
        }
    }

    function delete_report_history($id, $redirect) {


        if ($id) {
            $this->prescription_model->delete_report($id);
            $this->session->set_flashdata('message', lang('report_deleted'));
            redirect('admin/patients/medication_history/' . $redirect);
        }
    }

}
