<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class payment_method extends MX_Controller
{
    function my_payment_method()
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
                    $data['doctor_id'] = $Data->doctor_id;
                    $data['payment_channel_id'] = $Data->payment_channel_id;
                    $now = new DateTime();
                    $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                    $data['created_at'] = $now->format('Y-m-d H:i:s');
                    $data['created_by'] = $Data->doctor_id;
                    $query_check = $this->db->query("SELECT * from payment_method WHERE doctor_id = $requester_id;");
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
                    if ($flag==0 || $flag==1) {
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
        } elseif ($this->input->server('REQUEST_METHOD') === 'DELETE') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $requester_id = $this->uri->segment(5);
                    $doctor_id = $Data->doctor_id;
                    $payment_channel_id = $Data->payment_channel_id;
                    $del_condition = array('doctor_id' => $doctor_id, 'payment_channel_id' => $payment_channel_id);
                    $this->db->where($del_condition);

                    // $this->db->where('doctor_id', $doctor_id); //we can use this method also
                    // $this->db->where('payment_channel_id', $payment_channel_id); //we can use this method also
                    $query = $this->db->delete('payment_method');

                    if ($query) {
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
        //end of function
    }
}
