<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class transaction extends MX_Controller
{
    function my_transaction()
    {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $requester_id = $this->uri->segment(5);
                    $this->db->where('doctor_id', $requester_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $query = $this->db->query("SELECT * from payment_method WHERE doctor_id = $requester_id;");

                    $result2 = array();

                    foreach ($query->result() as $my_payment) {
                        
                        $payment_method['id'] = $my_payment->id;
                        $payment_method['doctor_id'] = $my_payment->doctor_id;
                        $payment_method['payment_channel_id'] = $my_payment->payment_channel_id;
                        $query_channel_name = $this->db->query("SELECT * from payment_channel WHERE id = $my_payment->payment_channel_id;")->result();
                        $payment_method['payment_channel'] = $query_channel_name[0]->payment_channel;
                        $payment_method['created_at'] = $my_payment->created_at;
                        $payment_method['created_by'] = $my_payment->created_by;
                        array_push($result2, $payment_method);

                    }

                    echo json_encode(array('payment_method' => $result2), JSON_UNESCAPED_SLASHES);

                } else {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                }
            } else {
                header("HTTP/1.1 401 Unauthorized");
                exit;
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $requester_id = $this->uri->segment(5);
                    $this->db->where('doctor_id', $requester_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $data['invoice_id'] = $Data->invoice_id;
                    $data['clinic_id'] = $Data->clinic_id;
                    $data['doctor_id'] = $Data->doctor_id;
                    $data['patient_id'] = $Data->patient_id;
                    $data['amount'] = $Data->amount;
                    $data['payment_channel_id'] = $Data->payment_channel_id;
                    $data['is_partial_payment'] = $Data->is_partial_payment;
                    $data['paid_by'] = $Data->paid_by;
                    $data['payment_date'] = $Data->payment_date;
                    $data['created_by'] = $Data->doctor_id;
                    $now = new DateTime();
                    $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                    $data['created_at'] = $now->format('Y-m-d H:i:s');
                    $data['created_by'] = $Data->doctor_id;
                  /*  $query_check = $this->db->query("SELECT * from payment_method WHERE doctor_id = $requester_id;");
                    $flag=0;
                    foreach ($query_check->result() as $query_check_data)
                    {
                       if($query_check_data->doctor_id == $Data->doctor_id && $query_check_data->payment_channel_id == $Data->payment_channel_id)
                       {
                        $flag=1;
                       }
                    }
                    if($flag==0)
                    {
                    $query_insert = $this->db->insert('payment_method', $data);
                    }
                    */
                    $query_insert = $this->db->insert('transactions', $data);
                    if ($query_insert) {
                        $query = $this->db->query("SELECT * from transactions WHERE doctor_id = $requester_id;");

                        $result2 = array();
                      
                       
                        foreach ($query->result() as $trans) {
                           
                            array_push($result2, $trans);
                        }

                        echo json_encode(array('transaction' => $result2), JSON_UNESCAPED_SLASHES);
                        $query_invoice = $this->db->query("SELECT payment_received FROM invoice where id = $Data->invoice_id;")->result(); 
                        $current_amount = $query_invoice[0]->payment_received;
                        $new_total_amount = $current_amount + $Data->amount;
                        $this->db->query("UPDATE invoice SET payment_received=$new_total_amount where id =$Data->invoice_id;");
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
}
