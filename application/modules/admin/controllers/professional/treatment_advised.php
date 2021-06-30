<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class treatment_advised extends MX_Controller
{
    function treatment_advised_method()
    {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $doctor_id = $this->uri->segment(5);
                    $this->db->where('doctor_id', $doctor_id);
                    // $doc = $this->db->get('payment_method')->row(0);
                    $query = $this->db->query("SELECT * from treatment_advised WHERE doctor_id = $doctor_id;");

                    $result2 = array();

                    foreach ($query->result() as $treatment_advise) {

                        array_push($result2, $treatment_advise);
                    }

                    echo json_encode(array('treatment_advised' => $result2), JSON_UNESCAPED_SLASHES);
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
                    $doctor_id = $this->uri->segment(5);
                    $this->db->where('doctor_id', $doctor_id);
                    // $doc = $this->db->get('payment_method')->row(0);

                    $data['name'] = $Data->name;
                    $data['doctor_id'] = $doctor_id;
                    $data['price'] = $Data->price;
                    $flag = 0;
                    $query_check = $this->db->query("SELECT * from treatment_advised WHERE doctor_id = $doctor_id;");
                    foreach ($query_check->result() as $query_check_data) {
                        if ($query_check_data->doctor_id == $doctor_id && strcasecmp($query_check_data->name, $Data->name) == 0) {
                            $flag = 1;
                        }
                    }
                    if ($flag == 0) {
                        $query_insert = $this->db->insert('treatment_advised', $data);
                    }
                    if ($flag == 0 || $flag == 1) {
                        $query = $this->db->query("SELECT * from treatment_advised WHERE doctor_id = $doctor_id;");

                        $result2 = array();

                        foreach ($query->result() as $treatment_advise) {

                            array_push($result2, $treatment_advise);
                        }

                        echo json_encode(array('treatment_advised' => $result2), JSON_UNESCAPED_SLASHES);
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
                    $doctor_id = $this->uri->segment(5);
                    $id = $Data->id;
                    $del_condition = array('doctor_id' => $doctor_id, 'id' => $id);
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

                        echo json_encode(array('treatment_advised' => $result2), JSON_UNESCAPED_SLASHES);
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
