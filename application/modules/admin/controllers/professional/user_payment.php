<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_payment extends MX_Controller
{
    function user_payment_detail()
    {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $patient_id = $this->uri->segment(5);
                    $this->db->where('patient_id', $patient_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $query = $this->db->query("SELECT * from user_payment_detail WHERE patient_id = $patient_id;");

                    $result2 = array();

                    foreach ($query->result() as $user_payment) {

                        array_push($result2, $user_payment);
                    }

                    echo json_encode(array('user_payment_details' => $result2), JSON_UNESCAPED_SLASHES);
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
                    $patient_id = $this->uri->segment(5);
                    $this->db->where('patient_id', $patient_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $data['patient_id'] = $patient_id;
                    $data['payment_channel_id'] = $Data->payment_channel_id;
                    $data['card_number'] = $Data->card_number;
                    $data['cheque_number'] = $Data->cheque_number;
                    $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $data['created_at'] = $now->format('Y-m-d H:i:s');
                        $data['created_by'] = $patient_id;
                        $query_insert = $this->db->insert('user_payment_detail', $data);
                    
                    if ($query_insert) {
                        $query = $this->db->query("SELECT * from user_payment_detail WHERE patient_id = $patient_id;");

                        $result2 = array();

                        foreach ($query->result() as $user_payment) {

                            array_push($result2, $user_payment);
                        }

                        echo json_encode(array('user_payment_details' => $result2), JSON_UNESCAPED_SLASHES);
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
