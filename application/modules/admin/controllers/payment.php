<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class payment extends MX_Controller {

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
        $this->load->model("setting_model");
        $this->load->model("invoice_model");
        $this->load->model("payment_mode_model");
        $this->load->model("treatment_advised_model");
        $this->load->library('session');
    }

    function index($id = false) {
        $data['p_id'] = $id;
        $data['payments'] = array();

        $data['payments'] = $this->prescription_model->get_payment_by_doctor();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['payment_modes'] = $this->payment_mode_model->get_payment_mode_by_doctor();
        $data['setting'] = $this->setting_model->get_setting();

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
        $data['err'] = "";
        if ($this->session->flashdata('err')) {
            $data['err'] = $this->session->flashdata('err');
        }

        $data['treatment_Advised'] = $this->treatment_advised_model->get_case_history_by_doctor();
        $data['page_title'] = lang('payment');
        $data['body'] = 'prescription/payment_list';
        $this->load->view('template/main', $data);
    }

    function checkz_payment($id = false) {
        $patient_id = $this->input->post('patient_id');
        $dat = $this->prescription_model->checkz_payment($patient_id);
        $total = '';

        foreach ($dat as $new) {

            $total = $new->amount;
        }
        echo $total;
    }

    function edit_payment($id) {
        //$this->auth->check_access('1', true);
        $data['payment'] = $this->prescription_model->get_payment_by_id($id);
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        //echo '<pre>'; print_r($data['pateints']);die;
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        //$data['fees_all']				= $this->prescription_model->get_fees_all($id);
        //echo '<pre>'; print_r($_POST);die;


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            //$this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('payment_mode_id', 'lang:payment_mode', 'required');
            $this->form_validation->set_rules('date', 'lang:date', 'required');
            $this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');

            if ($this->form_validation->run() == true) {
                $save['amount'] = $this->input->post('amount');

                $save['payment_mode_id'] = $this->input->post('payment_mode_id');
                $save['payment_for'] = $this->input->post('payment_for');
                //$save['prescription_id'] = $id;
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['balance'] = json_encode($this->input->post('balance'));
                $save['patient_id'] = $this->input->post('patient_id');
                $save['dates'] = json_encode($this->input->post('date'));
                $save['invoice'] = $data['payment']->invoice;
                //echo '<pre>'; print_r($save);die;
                $amounts = 0;

                $patnt = $this->input->post('patient_id');

                $amount = $this->input->post('balance');
                $amounts = ($amounts) + ($amount);
                //echo "ok".$amount;

                $patient_id = $this->input->post('patient_id');
                $dat = $this->prescription_model->checkz_payment($patient_id);
                $total = '';

                foreach ($dat as $new) {

                    $total = $new->amount;
                }


                $status = ($total) - ($amounts);
                if ($status == 0) {
                    $save['status'] = 0;
                    $save['total'] = $total;
                    $save['pending'] = $status;
                    $this->prescription_model->sts1($status);
//$save['status']="Pending Amount : No Pending Amount";
                } else {
                    $save['total'] = 0;
                    $save['pending'] = $status;
                    $save['status'] = $status;
                    $this->prescription_model->sts1($status);
//$save['status']="Pending Amount : ".$status." INR";
                }
                if ($total >= $amounts) {
                    $this->prescription_model->update_fees($save, $data['payment']->id);
                    $this->session->set_flashdata('message', lang('fees_updated'));
                    redirect('admin/patients/view/' . $patnt . '#tab_3');
                } else {
                    $this->session->set_flashdata('err', 'Amount limit high.');
                    redirect('admin/patients/view/' . $patnt . '#tab_3');
                }




                //echo 1;
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

//===============================================================================================================

    function edit_payment1($id) {
        //$this->auth->check_access('1', true);
        $data['payment'] = $this->prescription_model->get_payment_by_id($id);
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        //echo '<pre>'; print_r($data['pateints']);die;
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        //$data['fees_all']				= $this->prescription_model->get_fees_all($id);
        //echo '<pre>'; print_r($_POST);die;


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            //$this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('payment_mode_id', 'lang:payment_mode', 'required');
            $this->form_validation->set_rules('date', 'lang:date', 'required');
            $this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');

            if ($this->form_validation->run() == true) {
                $save['amount'] = $this->input->post('amount');

                $save['payment_mode_id'] = $this->input->post('payment_mode_id');
                $save['payment_for'] = $this->input->post('payment_for');
                //$save['prescription_id'] = $id;
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['balance'] = json_encode($this->input->post('balance'));
                $save['patient_id'] = $this->input->post('patient_id');
                $save['dates'] = json_encode($this->input->post('date'));
                $save['invoice'] = $data['payment']->invoice;
                //echo '<pre>'; print_r($save);die;
                $amounts = 0;

                $patnt = $this->input->post('patient_id');

                $amount = $this->input->post('balance');
                $amounts = ($amounts) + ($amount);
                //echo "ok".$amount;

                $patient_id = $this->input->post('patient_id');
                $dat = $this->prescription_model->checkz_payment($patient_id);
                $total = '';

                foreach ($dat as $new) {

                    $total = $new->amount;
                }


                $status = ($total) - ($amounts);
                if ($status == 0) {
                    $save['status'] = 0;
                    $save['total'] = $total;
                    $save['pending'] = $status;
                    $this->prescription_model->sts1($status);
//$save['status']="Pending Amount : No Pending Amount";
                } else {
                    $save['total'] = 0;
                    $save['pending'] = $status;
                    $save['status'] = $status;
                    $this->prescription_model->sts1($status);
//$save['status']="Pending Amount : ".$status." INR";
                }
                if ($total >= $amounts) {
                    $this->prescription_model->update_fees($save, $data['payment']->id);
                    $this->session->set_flashdata('message', lang('fees_updated'));
                    redirect('admin/payment');
                } else {
                    $this->session->set_flashdata('err', 'Amount limit high.');
                    redirect('admin/payment');
                }




                //echo 1;
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

//=================================================================================================================



    function add_payment($id = false) {
        $this->auth->check_access('1', true);
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        //$data['fees_all']				= $this->prescription_model->get_fees_all($id);
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
        //echo '<pre>'; print_r($_POST);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('treatment_Advised_id', 'lang:treatment_Advised_id', 'required');
            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $save['amount'] = $this->input->post('amount');
                $total = $this->input->post('amount');
                $save['payment_mode_id'] = $this->input->post('payment_mode_id');
                $save['payment_for'] = $this->input->post('payment_for');

                //echo $data['p_id'];die;
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['balance'] = json_encode($this->input->post('balance'));
                $save['patient_id'] = $this->input->post('patient_id');
                $save['dates'] = json_encode($this->input->post('date'));
                $save['invoice'] = $data['i_no'];
                $amounts = 0;
                $rd = $this->input->post('rd');
                $amount = $this->input->post('balance');
                $amounts = $amounts + $amount;
                $patnt = $this->input->post('patient_id');

                $status = $total - $amounts;
                if ($status == 0) {
                    $save['status'] = 0;
                    $save['total'] = $total;
                    $save['pending'] = $status;
                    $this->prescription_model->sts1($status);
//$save['status']="Pending Amount : No Pending Amount";
                } else {
                    $save['status'] = $status;
                    $save['total'] = 0;
                    $save['pending'] = $status;
                    $this->prescription_model->sts1($status);
//$save['status']="Pending Amount : ".$status." INR";
                }
                if ($total >= $amounts) {
                    $this->prescription_model->save_fees($save);
                    if ($rd == "patients") {
                        redirect('admin/patients/view/' . $patnt . '#tab_3');
                    } else {
                        redirect('admin/payment');
                    }
                } else {
                    $this->session->set_flashdata('err', 'Amount limit high.');
                    if ($rd == "patients") {
                        redirect('admin/patients/view/' . $patnt . '#tab_3');
                    } else {
                        redirect('admin/payment');
                    }
                }
                // $this->input->post('invoice_no');
                //echo '<pre>';print_r($save);die;
                //$this->prescription_model->save_fees($save);



                $this->session->set_flashdata('message', "Payment Added");
                $this->load->helper('url');
                if ($rd == "patients") {
                    redirect('admin/patients/view/' . $patnt . '#tab_3');
                } else {
                    redirect('admin/payment');
                }
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

    //=================================================================================================================



    function add_payment_new($id = false) {


        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $save['doctor_id'] = $docid;
        $save['amount'] = $this->input->post('amount');
        $payment_mode_id = $this->input->post('payment_mode_id');
        $save['payment_mode_id'] = $this->input->post('payment_mode_id');
        $save['invoice'] = $this->input->post('invoice_no');
         $wish = $this->input->post('wish');
         if($wish==1)
         {
         $save['treatment_Advised_id']= $this->input->post('treat');
         }
        ;
        if ($payment_mode_id == 1) {
            
        }
        if ($payment_mode_id == 2) {
            $save['bankname'] = $this->input->post('bankname');
            $save['cheqeno'] = $this->input->post('chequeno');
        }
        if ($payment_mode_id == 3) {
            $save['cardno'] = $this->input->post('cardno');
        }
        if ($payment_mode_id == 4) {
            $save['paymentby'] = $this->input->post('payment');
        }

        $pat = $this->input->post('patient_id');
        $save['patient_id'] = $this->input->post('patient_id');
        $save['consultant'] = $this->input->post('consultant');
        $save['dates'] = $this->input->post('date');
        $save['dates'] = str_replace('/', '-', $save['dates']);
        $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));

        $amounts = 0;
        $amount = $this->input->post('amount');
        $da = $this->prescription_model->total($docid, $pat);
        foreach ($da as $new) {
            $amounts = $new->pending;
        }
        $total = $amounts + $amount;
        $patnt = $this->input->post('patient_id');
        $save['status'] = 0;
        $save['total'] = $total;
        $save['pending'] = $total;
        $save['credit'] = $amount;
        $save['debit'] = 0;
        $this->prescription_model->payment_fees($save);

        $this->session->set_flashdata('message', "Payment Added");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $patnt . '#tab_3');
    }

    //==================================================================================================

    function add_payment_disc($id = false) {


        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $save['doctor_id'] = $docid;
        $save['amount'] = $this->input->post('amount');
        $save['invoice'] = $this->input->post('invoice_no');
        $pat = $this->input->post('patient_id');
        $save['patient_id'] = $this->input->post('patient_id');
        $save['dates'] = $this->input->post('date');
        $save['payment_mode_id'] = '-';

        $amounts = 0;
        $amount = $this->input->post('amount');
        $da = $this->prescription_model->total($docid, $pat);
        foreach ($da as $new) {
            $amounts = $new->pending;
        }
        $total = $amounts + $amount;
        $save['status'] = 0;
        $save['total'] = $total;
        $save['pending'] = $total;
        $save['credit'] = $amount;
        $save['debit'] = 0;
        $save['treatment_Advised_id'] = json_encode("Discount");
        $this->prescription_model->payment_fees($save);

        $this->session->set_flashdata('message', "Discount Added");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $id . '#tab_3');
    }

    /*function edit_payment_new($id = false) {
        $total = 0;
        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $invoice = $this->input->post('invoice');
        if ($invoice != "-") {

            $save['amount'] = $this->input->post('amount');
            $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
            $save['consultant'] = $this->input->post('consultant');
            $save['invoice'] = $this->input->post('invoice');
            $pat = $this->input->post('patient_id');
            $save['dates'] = $this->input->post('date');
            $save['dates'] = str_replace('/', '-', $save['dates']);
            $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));

            $amounts = 0;
            $amnts = 0;
            $amount = $this->input->post('amount');
            $da = $this->prescription_model->totals($docid, $pat, $id);
            foreach ($da as $new) {
                $amnts = $new->pending;
            }
            $total = $amnts - $amount;
            $patnt = $this->input->post('patient_id');
            $save['status'] = 0;
            $save['total'] = $total;
            $save['pending'] = $total;
            $save['debit'] = $amount;
            $this->prescription_model->updedit($save, $id);
            $fulldata = $this->prescription_model->fulldata($docid, $pat, $id);
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
        } else {

            //$save['amount'] = $this->input->post('amount');
            $payment_mode_id = $this->input->post('payment_mode_id');
            $save['payment_mode_id'] = $this->input->post('payment_mode_id');

            if ($payment_mode_id == 1) {
                
            }
            if ($payment_mode_id == 2) {
                $save['bankname'] = $this->input->post('bankname');
                $save['cheqeno'] = $this->input->post('chequeno');
            }
            if ($payment_mode_id == 3) {
                $save['cardno'] = $this->input->post('cardno');
            }
            if ($payment_mode_id == 4) {
                $save['paymentby'] = $this->input->post('payment');
            }

            $pat = $this->input->post('patient_id');
            $save['dates'] = $this->input->post('date');
            $save['dates'] = str_replace('/', '-', $save['dates']);
            $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));
            $amnts = 0;
            $amounts = 0;
            $amount = $this->input->post('amount');
            $da = $this->prescription_model->totals($docid, $pat, $id);
            foreach ($da as $new) {
                $amnts = $new->pending;
            }
            $total = $amnts + $amount;
            $patnt = $this->input->post('patient_id');
            $save['status'] = 0;
            $save['total'] = $total;
            $save['pending'] = $total;
            $save['credit'] = $amount;
            //$save['debit'] = 0;

            $this->prescription_model->updedit($save, $id);

            $amntsss = 0;
            $fulldata = $this->prescription_model->fulldata($docid, $pat, $id);
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
        }
        $this->session->set_flashdata('message', "Updated Successfully");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $patnt . '#tab_3');
    }*/
	function edit_payment_new($id = false) {
		//echo 'ID: '.$id;
		//echo '<pre>'; print_r($this->input->post()); echo '</pre>';die;
        $total = 0;
        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $invoice = $this->input->post('invoice');
        if ($invoice != "-") {
			
            $save['amount'] = $this->input->post('amount');
            $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
            $save['consultant'] = $this->input->post('consultant');
            $save['invoice'] = $this->input->post('invoice');
            $pat = $this->input->post('patient_id');
            $save['dates'] = $this->input->post('date');
            $save['dates'] = str_replace('/', '-', $save['dates']);
            $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));

            $amounts = 0;
            $amnts = 0;
            $amount = $this->input->post('amount');
            $da = $this->prescription_model->totals($docid, $pat, $id);
            foreach ($da as $new) {
                $amnts = $new->pending;
            }
            $total = $amnts - $amount;
            $patnt = $this->input->post('patient_id');
            $save['status'] = 0;
            $save['total'] = $total;
            $save['pending'] = $total;
            $save['debit'] = $amount;
            $this->prescription_model->updedit($save, $id);
            $fulldata = $this->prescription_model->fulldata($docid, $pat, $id);
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
        } else {

            //$save['amount'] = $this->input->post('amount');
            $payment_mode_id = $this->input->post('payment_mode_id');
            $save['payment_mode_id'] = $this->input->post('payment_mode_id');

            if ($payment_mode_id == 1) {
                
            }
            if ($payment_mode_id == 2) {
                $save['bankname'] = $this->input->post('bankname');
                $save['cheqeno'] = $this->input->post('chequeno');
            }
            if ($payment_mode_id == 3) {
                $save['cardno'] = $this->input->post('cardno');
            }
            if ($payment_mode_id == 4) {
                $save['paymentby'] = $this->input->post('payment');
            }

            $pat = $this->input->post('patient_id');
            $save['dates'] = $this->input->post('date');
            $save['dates'] = str_replace('/', '-', $save['dates']);
            $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));
            $amnts = 0;
            $amounts = 0;
            //$amount = $this->input->post('amount');
			if(isset($_POST['edit_credit_'.$id]))
				$amount = $_POST['edit_credit_'.$id];
			else
            	$amount = $this->input->post('amount');
				
            $da = $this->prescription_model->totals($docid, $pat, $id);
            foreach ($da as $new) {
                $amnts = $new->pending;
            }
            $total = $amnts + $amount;
            $patnt = $this->input->post('patient_id');
            $save['status'] = 0;
            $save['total'] = $total;
            $save['pending'] = $total;
            $save['credit'] = $amount;
			if(isset($_POST['edit_amount_'.$id]))
			{
				$save['debit'] = $_POST['edit_amount_'.$id];
				$save['amount'] = $_POST['edit_amount_'.$id];
			}
			if(isset($_POST['edit_qty_'.$id]))
				$save['qty'] = $_POST['edit_qty_'.$id];
			if(isset($_POST['edit_rate_'.$id]))
				$save['rate'] = $_POST['edit_rate_'.$id];
            //$save['debit'] = 0;
			//echo '<pre>save '; print_r($save); echo '</pre>';die;
            $this->prescription_model->updedit($save, $id);

            $amntsss = 0;
            $fulldata = $this->prescription_model->fulldata($docid, $pat, $id);
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
        }
        $this->session->set_flashdata('message', "Updated Successfully");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $patnt . '#tab_3');
    }

    function add_payment_delete($id = false, $pat = false) {
        $total = 0;
        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $amounts = 0;
        $amount = $this->input->post('amount');
        $da = $this->prescription_model->totals($docid, $pat, $id);
        foreach ($da as $new) {
            $amnts = $new->pending;
        }
        $this->prescription_model->deletenew($id);
        $fulldata = $this->prescription_model->fulldata($docid, $pat, $id);
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
        $this->session->set_flashdata('message', "Delete Successfully");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $pat . '#tab_3');
    }

    function add_payment_inv($id = false) {
		echo '<pre>'; print_r($this->input->post()); echo '</pre>';
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();

        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $save['doctor_id'] = $docid;
        $inv_count = count($this->input->post('qty'));

        $base_invoice = $this->input->post('invoice_no')[0];
$ashu=0;
		$totamount12 = $totRecived = 0;
        for ($i = 0; $i < $inv_count; $i++) {
            if ($inv_count == 1) {
                if ($this->input->post('rate')[0] == '') {
                    break;
                }
            }
            $qty = $this->input->post('qty')[$i];
            $rate = $this->input->post('rate')[$i];
            $amount12 = $this->input->post('amount12')[$i];
            $amount = $qty * $rate;
            $ashu=$ashu+$amount12;
			$totRecived = $totRecived+$amount12;
			$totamount12 = $totamount12+$amount;
			
            $save['amount'] = $amount;
            $save['qty'] = $qty;
            $save['rate'] = $rate;
            $save['credit']=$amount12;
            $save['teeth'] = $this->input->post('teeth')[$i];
            $treatment = $this->input->post('treatment_Advised_id')[$i];
            $save['treatment_Advised_id'] = $treatment;
            $consultant = $this->input->post('consultant');
            $save['consultant'] = $this->input->post('consultant');
            $pat = $this->input->post('patient_id');
            $save['patient_id'] = $this->input->post('patient_id');
            $save['invoice'] = $base_invoice;
            $save['dates'] = $this->input->post('invdate');
            $save['dates'] = str_replace('/', '-', $save['dates']);
            $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));
           // $save['payment_mode_id'] = '-';
            $payment_mode_id = $this->input->post('payment_mode_id')[0];
			if($payment_mode_id != '')
            	$save['payment_mode_id'] = $this->input->post('payment_mode_id')[0];
			else
				$save['payment_mode_id'] = 1;
           // $save['invoice'] = 'RCT0' . $i_nox;

            if ($payment_mode_id == 1) {

            }
            if ($payment_mode_id == 2) {
                $save['bankname'] = $this->input->post('bankname')[$i];
                $save['cheqeno'] = $this->input->post('chequeno')[$i];
            }
            if ($payment_mode_id == 3) {
                $save['cardno'] = $this->input->post('cardno')[$i];
            }
            if ($payment_mode_id == 4) {
                $save['paymentby'] = $this->input->post('payment')[$i];
            }

            $amounts = 0;
            $amount = $save['amount'];
            $da = $this->prescription_model->total($docid, $pat);
            foreach ($da as $new) {
                $amounts = $new->pending;
            }
            $total = $amounts - $amount;
            $patnt = $this->input->post('patient_id');
            $save['status'] = 0;
            $save['total'] = $total;
            $save['pending'] = $total;
            $save['debit'] = $amount;
            $save['credit'] = $amount12;
            //var_dump($save);
            $this->prescription_model->payment_fees($save);
            $base_invoice = "+" . $base_invoice;
            $base_invoice = explode("INV0", $base_invoice);
            $base_invoice = $base_invoice[1];
            $base_invoice++;
            $base_invoice = "INV0" . $base_invoice;
			
			$paymentMode = $this->input->post('payment')[$i];
        }
		
		#Add data in table which is used in API call - starts
		$data_inv['patient_id'] = $this->input->post('patient_id');
		$data_inv['doctor_id'] = $docid;
		$query_clinic_details = $this->db->query("SELECT clinic_id,clinic_name FROM `clinic` WHERE `clinic_owner_id` = $docid;")->result();
		$data_inv['clinic_name'] = $query_clinic_details[0]->clinic_name;
		$data_inv['clinic_id'] = $query_clinic_details[0]->clinic_id;
		$query_id = $this->db->query("SELECT id FROM invoice order by id DESC LIMIT 1;")->result();
		$id_inv = $query_id[0]->id + 1;
		$num = sprintf("%07d", $id_inv);
		$data_inv['invoice_number'] = "INV{$num}";
		$invDate = date('Y-m-d h:i:00', strtotime(str_replace('/', '-', $this->input->post('invdate'))));
		$data_inv['invoice_date'] = $invDate;
		$data_inv['treatment_advised'] = $treatment;
		$data_inv['quantity'] = count($this->input->post('qty'));
		$data_inv['rate'] = $rate;
		$data_inv['total_amount'] = $totamount12;
		$data_inv['payment_received'] = $totRecived;
		if ($totRecived >= $totamount12) {
			$data_inv['is_paid'] = 'Yes';
		}
		else
			$data_inv['is_paid'] = 'No';
		/*if ($totRecived > $totRecived) {
			$data_inv['is_paid'] = 'No';
		}*/
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Kolkata'));
		$data_inv['created_at'] = $now->format('Y-m-d H:i:s');
		$data_inv['created_by'] = $docid;
		$data_inv['description'] = 'test';
		$query_insert = $this->db->insert('invoice', $data_inv);
		//echo '<pre>Invoice Details : '; print_r($data_inv); echo '</pre>';
		$inv_id = $this->db->insert_id();
		//echo '<br>Inv ID : '.$inv_id;
		//for transaction
		
		if($paymentMode == '')
			$paymentMode = 1;
		
		$transaction_data['invoice_id'] = $inv_id;
		$transaction_data['clinic_id'] = $query_clinic_details[0]->clinic_id;
		$transaction_data['doctor_id'] = $docid;
		$transaction_data['patient_id'] = $this->input->post('patient_id');
		$transaction_data['amount'] = $totRecived;
		$transaction_data['payment_channel_id'] = $paymentMode;
		$transaction_data['is_partial_payment'] = true;
		$transaction_data['paid_by'] = 'Self - Website';
		$transaction_data['payment_date'] = $invDate;
		$transaction_data['created_by'] = $docid;
		$transaction_data['created_at'] = $now->format('Y-m-d H:i:s');;
		$tran_id = $this->db->insert('transactions', $transaction_data);
		//echo '<pre>transaction_data Details : '; print_r($transaction_data); echo '</pre>';
		//echo '<br>tran_id ID : '.$tran_id;
		#Add data in table which is used in API call - ends
		
        unset($save['treatment_Advised_id']);
        unset($save['rate']);
        unset($save['teeth']);
        unset($save['qty']);

        //*********************add payment *****************************//

       /* if (count($this->input->post('amount')) == 1) {
            if ($this->input->post('amount')[0] == '')
            {
                $this->session->set_flashdata('message', "Invoice(s) Added");
                $this->load->helper('url');
                redirect('admin/patients/view/' . $patnt . '#tab_3');
            }
        }*/

       /* for ($i = 0; $i < count($this->input->post('payment_mode_id')); $i++) {
            //get net payment invoice no
            $i_no1 = $this->patient_model->get_patients_by_invoice_payment_in($id);
            $i_no2 = 0;
            foreach ($i_no1 as $new) {
                $i_no2 = $new->invoice;
            }
            if (strpos($i_no2, 'RCT') !== false) {

                $inexport = explode('RCT0', $i_no2);
            } else {
                $inexport = explode('INV0', $i_no2);
            }
            $i_nox = $inexport['1'] + 1;
            // end of invoice number fetch


            $save['amount'] = $this->input->post('amount')[$i];
             $treatment = $this->input->post('treatment_Advised_id')[$i];
            $save['treatment_Advised_id'] = $treatment;
            $payment_mode_id = $this->input->post('payment_mode_id')[$i];
            $save['payment_mode_id'] = $this->input->post('payment_mode_id')[$i];
            $save['invoice'] = 'RCT0' . $i_nox;

            if ($payment_mode_id == 1) {

            }
            if ($payment_mode_id == 2) {
                $save['bankname'] = $this->input->post('bankname')[$i];
                $save['cheqeno'] = $this->input->post('chequeno')[$i];
            }
            if ($payment_mode_id == 3) {
                $save['cardno'] = $this->input->post('cardno')[$i];
            }
            if ($payment_mode_id == 4) {
                $save['paymentby'] = $this->input->post('payment')[$i];
            }

            $pat = $this->input->post('patient_id');
            $save['patient_id'] = $this->input->post('patient_id');
            $save['consultant'] = $this->input->post('consultant');
            $save['dates'] = $this->input->post('invdate');
            $save['dates'] = str_replace('/', '-', $save['dates']);
            $save['dates'] = date('Y-m-d h:i:00', strtotime($save['dates']));

            $amounts = 0;
            $amount = $this->input->post('amount')[$i];
            $da = $this->prescription_model->total($docid, $pat);
            foreach ($da as $new) {
                $amounts = $new->pending;
            }
            $total = $amounts + $amount;
            $patnt = $this->input->post('patient_id');
            $save['status'] = 0;
            $save['total'] = $total;
            $save['pending'] = $total;
            $save['credit'] = $ashu;
            $save['debit'] = 0;
            $this->prescription_model->payment_fees($save);
        }*/

        $this->session->set_flashdata('message', "Invoice(s) Added");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $patnt . '#tab_3');
    }

    function send_reminder($pending_amont = false, $pateint_id = false) {
        $admin = $this->session->userdata('admin');
        $ad = '';
        if ($admin['user_role'] == 1) {
            $ad = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $ad = $admin['doctor_id'];
        }
        $doctor_name = '';
        $admin_names = $this->patient_model->get_cont($ad);
        foreach ($admin_names as $newadmin) {
            $doctor_name = $newadmin->name;
        }
        $cntc = $this->patient_model->get_cont($pateint_id);
        $contact = '';
        foreach ($cntc as $new) {
            $patient_name = $new->name;
            $contact = $new->contact;
        }
        /* Send SMS using PHP */
/*
        //Your authentication key
        $authKey = "144872ArhHeSNu58c7bb84";

        //Multiple mobiles numbers separated by comma
        $mobileNumber = $contact;

        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "DOCTRI";

        //Your message to send, Add URL encoding here.
        $mesg = "Dear " . $patient_name . " ,Your Payment Is Pending Rs:" . $pending_amont . " at " . $doctor_name . " .   Thanks";
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

        curl_close($ch);*/
		
		#Send sms again - starts
		$authKey = "144872ArhHeSNu58c7bb84";
		$senderId = "DCTRIP";
		$route = 4;
		$mobileNumber = $contact;
		//$mobileNumber = 9075627173;
		$mesg = "Dear " . $patient_name . " ,Your Payment Is Pending Rs:" . $pending_amont . " at " . $doctor_name . " .   Thanks";
		$encodedMessage = urlencode($mesg);
		$api_url = "http://sms.globehost.in/sendhttp.php?authkey=".$authKey."&mobiles=".$mobileNumber."&message=".$encodedMessage."&sender=".$senderId."&route=".$route."&unicode=1";
		//echo $api_url;die;
		//Submit to server
		$return = array();							
		//$response = file_get_contents($api_url);
		$arrContextOptions=array(
			  "ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);  
		$response = file_get_contents($api_url, false, stream_context_create($arrContextOptions));
		//echo '<br>$response : '.$response; 
		#Send sms again - ends

        //echo $output;
        $this->session->set_flashdata('message', "Reminder Send Successfully");
        $this->load->helper('url');
        redirect('admin/patients/view/' . $pateint_id . '#tab_3');
    }

    //====================================================================================================================
//================================================================================================================================
    function edit_tooth($id=false){
		$data['pateints'] = $this->prescription_model->edit_tooth($id);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {        
			$post = $this->input->post();
				//echo 'ID : '.$id;
				$tooth_id = $this->input->post('tooth_id');
				//echo '<pre>post '; print_r($post); echo '</pre>';die;
				$save['tooth'] = json_encode($this->input->post('tooth'));
                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));
                $save['estimate'] = $this->input->post('consultation_charge');
                $save['quantity'] = $this->input->post('quantity');
                $this->prescription_model->update_tooth($save,$tooth_id);

                $patnt = $this->input->post('patient_id');

                $this->session->set_flashdata('message', "Treatment Plan Updated");
                $this->load->helper('url');
                if ($rd == "patients") {
                    redirect('admin/patients/view/' . $patnt . '#tab_9');
                } else {
                    redirect('admin/patients/view/' . $patnt . '#tab_9');
                }
		}
    }
    function add_tooth($id = false) {
        $this->auth->check_access('1', true);
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();



        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('tooth', 'tooth', 'required');

            if ($this->form_validation->run() == true) {
                $save['tooth'] = json_encode($this->input->post('tooth'));


                $save['treatment_Advised_id'] = json_encode($this->input->post('treatment_Advised_id'));

                $save['patient_id'] = $this->input->post('patient_id');
                
                $save['estimate'] = $this->input->post('consultation_charge');
                $save['quantity'] = $this->input->post('quantity');
                $this->prescription_model->save_tooth($save);

                $patnt = $this->input->post('patient_id');


                $this->session->set_flashdata('message', "Treatment Plan Added");
                $this->load->helper('url');
                if ($rd == "patients") {
                    redirect('admin/patients/view/' . $patnt . '#tab_9');
                } else {
                    redirect('admin/patients/view/' . $patnt . '#tab_9');
                }
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

    function delete_tooth($id = false, $redirect) {

        if ($id) {
            $this->prescription_model->delete_tooth($id);
            $this->session->set_flashdata('message', "Treatment Plan Deleted");
            redirect('admin/patients/view/' . $redirect . '/treatment_plan');
        }
    }

    function message($id,$tot_amt,$payment)
    {
        $this->db->where('id',$id);
        $data['h']=$this->db->get('users')->row();
        $this->db->where('id',$id);
        $data['k']=$this->db->get('payment_fees');
        $amt=0;
       /* foreach($data['k']->result() as $row)
        {
            $amt+=$row->amount;
        }*/
		
		#Get doctor name
        $this->db->where('id',$data['h']->doctor_id);
		$docDetail = $this->db->get('users')->row();
		//echo '<pre>Doctor : '; print_r($docDetail); echo '</pre>';die;
		
		#Get consultant name
		//echo '<pre>h : '; print_r($data['h']); echo '</pre>';die;
		//echo '<pre>h : '; print_r($data['k']); echo '</pre>';die;
        //$this->db->where('id',$data['k']->consultant);
		//$consultantDetail = $this->db->get('consultant')->row();
		//echo '<pre>consultantDetail : '; print_r($consultantDetail); echo '</pre>';die;
		
        $name=$data['h']->name;
        $contact=$data['h']->contact;
        $authKey = "144872ArhHeSNu58c7bb84";
      /*  echo $contact;
        echo $name;
        echo $tot_amt;
        echo $payment;*/

        //Multiple mobiles numbers separated by comma
        $mobileNumber = $contact;
		//$mobileNumber = 9860130198;

        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "DOCTRI";
		$route = 4;
		
        //Your message to send, Add URL encoding here.
       //$mesg = "Dear " . $name . " Your total billed amount is Rs.  " .$tot_amt. " and you have paid Rs. ".$payment." . Thank you for visiting our clinic. \n\n" ."Download Doctori8 App to secure your health records.";
	     //$mesg = "Received with Tks Rs ".$payment." for treatment at ".$consultantDetail." ".$docDetail->name.". " . $name . " Your total billed amount is Rs.  " .$tot_amt. " and you have paid Rs. ".$payment." . Thank you for visiting our clinic. \n\n" ."Download Doctori8 App to secure your health records.";
		 $mesg = "Received with Tks Rs ".$payment." for treatment at ".$docDetail->name.". Balance is  Rs. ".($tot_amt-$payment).". Tks. Stay Healthy, Stay Safe. For any other query call ".$docDetail->contact;
		 //echo $mesg;die;
	  $message = urlencode($mesg);
        /*$message = urlencode($mesg);

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

        curl_close($ch);*/
		
		#Send sms again - starts
		$api_url = "http://sms.globehost.in/sendhttp.php?authkey=".$authKey."&mobiles=".$mobileNumber."&message=".$message."&sender=".$senderId."&route=".$route."&unicode=1";
		//echo $api_url;die;
		//Submit to server
		$return = array();							
		//$response = file_get_contents($api_url);
		$arrContextOptions=array(
			  "ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);  
		$response = file_get_contents($api_url, false, stream_context_create($arrContextOptions));
		/*echo '<br>Message : '.$message;
		echo '<br>mobileNumber : '.$mobileNumber;
		echo '<br>----------------<br>';
		//echo '<br>$response : '.$response; 
		#Send sms again - ends    
		
		die;*/
        redirect(base_url().'admin/patients/view/'.$id."#tab_3");
    }

}
