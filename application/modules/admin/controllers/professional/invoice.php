<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class invoice extends MX_Controller
{
    function get_invoice()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $requestor_id = $this->uri->segment(5);
                    $patient_id = $Data->patient_id;
                    $doctor_id = $Data->doctor_id;
                    $this->db->where('doctor_id', $requestor_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $query = $this->db->query("SELECT * from invoice WHERE doctor_id = $doctor_id and patient_id = $patient_id;");

                    $result2 = array();

                    foreach ($query->result() as $invoice) {

                        $query_transaction = $this->db->query("SELECT * FROM transactions where invoice_id=$invoice->id;");

                        $result1 = array();

                        foreach ($query_transaction->result() as $transaction_data) {

                            array_push($result1, $transaction_data);
                        }
                        $arr = array(
                            "id" => $invoice->id, "patient_id" => $invoice->patient_id,
                            "doctor_id" => $invoice->doctor_id, "clinic_id" => $invoice->clinic_id, "clinic_name" => $invoice->clinic_name,
                            "invoice_number" => $invoice->invoice_number, "invoice_date" => $invoice->invoice_date, "treatment_advised" => $invoice->treatment_advised,
                            "quantity" => $invoice->quantity,"rate" => $invoice->rate, "total_amount" => $invoice->total_amount, "payment_received" => $invoice->payment_received, "is_paid" => $invoice->is_paid, "created_at" => $invoice->created_at, "created_by" => $invoice->created_by, "description" => $invoice->description, "transaction" => $result1
                        );
                        array_push($result2, $arr);
                    }

                    echo json_encode(array('invoice' => $result2), JSON_UNESCAPED_SLASHES);
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                }
            } else {
                header("HTTP/1.1 401 Unauthorized");
                exit;
            }
        }
     }
     function add_invoice()
     {
      if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $requestor_id = $this->uri->segment(5);
                    $this->db->where('doctor_id', $requestor_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $data['patient_id'] = $Data->patient_id;
                    $data['doctor_id'] = $Data->doctor_id;
                    $data['clinic_id'] = $Data->clinic_id;
                    $query_clinic_name = $this->db->query("SELECT clinic_name FROM clinic where clinic_id = $Data->clinic_id;")->result();
                    $data['clinic_name'] = $query_clinic_name[0]->clinic_name;
                    $query_id = $this->db->query("SELECT id FROM invoice order by id DESC LIMIT 1;")->result();
                    $id_inv = $query_id[0]->id + 1;
                    $num = sprintf("%07d", $id_inv);
                    $data['invoice_number'] = "INV{$num}";
                    $data['invoice_date'] = $Data->invoice_date;
                    $data['treatment_advised'] = $Data->treatment_advised;
                    $data['quantity'] = $Data->quantity;
                    $data['rate'] = $Data->rate;
                    $data['total_amount'] = $Data->total_amount;
                    $data['payment_received'] = $Data->payment_received;
                    if ($Data->payment_received >= $Data->total_amount) {
                        $data['is_paid'] = 'Yes';
                    }
                    if ($Data->total_amount > $Data->payment_received) {
                        $data['is_paid'] = 'No';
                    }
                    $now = new DateTime();
                    $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                    $data['created_at'] = $now->format('Y-m-d H:i:s');
                    $data['created_by'] = $requestor_id;
                    $data['description'] = $Data->description;
                    $query_insert = $this->db->insert('invoice', $data);
                    $inv_id = $this->db->insert_id();
                    //for transaction

                    $transaction_data['invoice_id'] = $inv_id;
                    $transaction_data['clinic_id'] = $Data->clinic_id;
                    $transaction_data['doctor_id'] = $Data->doctor_id;
                    $transaction_data['patient_id'] = $Data->patient_id;
                    $transaction_data['amount'] = $Data->payment_received;
                    $transaction_data['payment_channel_id'] = $Data->payment_channel_id;
                    $transaction_data['is_partial_payment'] = $Data->is_partial_payment;
                    $transaction_data['paid_by'] = $Data->paid_by;
                    $transaction_data['payment_date'] = $Data->payment_date;
                    $transaction_data['created_by'] = $Data->created_by;
                    $transaction_data['created_at'] = $now->format('Y-m-d H:i:s');;
                    $this->db->insert('transactions', $transaction_data);




                    if ($query_insert) {
                        $query = $this->db->query("SELECT * from invoice WHERE doctor_id = $Data->doctor_id and  patient_id=$Data->patient_id;");

                        $result2 = array();

                        foreach ($query->result() as $invoice) {

                            $query_transaction = $this->db->query("SELECT * FROM transactions where invoice_id=$invoice->id;");

                            $result1 = array();

                            foreach ($query_transaction->result() as $transaction_data) {

                                array_push($result1, $transaction_data);
                            }
                            $arr = array(
                                "id" => $invoice->id, "patient_id" => $invoice->patient_id,
                                "doctor_id" => $invoice->doctor_id, "clinic_id" => $invoice->clinic_id, "clinic_name" => $invoice->clinic_name,
                                "invoice_number" => $invoice->invoice_number, "invoice_date" => $invoice->invoice_date, "treatment_advised" => $invoice->treatment_advised,
                                "quantity" => $invoice->quantity,"rate" => $invoice->rate, "total_amount" => $invoice->total_amount, "payment_received" => $invoice->payment_received, "is_paid" => $invoice->is_paid, "created_at" => $invoice->created_at, "created_by" => $invoice->created_by, "description" => $invoice->description, "transaction" => $result1
                            );
                            array_push($result2, $arr);
                        }


                        echo json_encode(array('invoice' => $result2), JSON_UNESCAPED_SLASHES);
                    } else {
                        header("HTTP/1.1 503 server is down");
                        exit;
                    }
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                }
            } else {
                header("HTTP/1.1 401 Unauthorized");
                exit;
            }
        }
     }
     function delete_invoice()
     {
     if ($this->input->server('REQUEST_METHOD') === 'DELETE') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $doctor_id = $this->uri->segment(5);
                    $name = $Data->name;
                    $price = $Data->price;
                    $del_condition = array('doctor_id' => $doctor_id, 'name' => $name, 'price' => $price);
                    $this->db->where($del_condition);

                    // $this->db->where('doctor_id', $doctor_id); //we can use this method also
                    // $this->db->where('payment_channel_id', $payment_channel_id); //we can use this method also
                    $query = $this->db->delete('treatment_advised');

                    if ($query) {
                        $query = $this->db->query("SELECT * from treatment_advised WHERE doctor_id = $doctor_id;");

                        $result2 = array();

                        foreach ($query->result() as $treatment_advise) {

                            array_push($result2, $treatment_advise);
                        }

                        echo json_encode(array('treatment_advise' => $result2), JSON_UNESCAPED_SLASHES);
                    } else {
                        header("HTTP/1.1 503 server is down");
                        exit;
                    }
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                }
            } else {
                header("HTTP/1.1 401 Unauthorized");
                exit;
            }
        }
    }
        //end of function
    }

