<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class treatment extends MX_Controller
{
    function get_treatment()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $Data = json_decode(file_get_contents('php://input'));

            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $requester_id = $this->uri->segment(5);
                    $patient_id = $Data->patient_id;
                    $doctor_id = $Data->doctor_id;
                    $this->db->where('doctor_id', $requester_id);
                    // $doc = $this->db->get('payment_method')->row(0);

                    $query = $this->db->query("SELECT * from appointment WHERE doctor_id = $doctor_id and patient_id = $patient_id;");

                    $result2 = array();

                    foreach ($query->result() as $my_treatment) {
                        
                        array_push($result2, $my_treatment);
                    }

                    echo json_encode(array('appointments' => $result2), JSON_UNESCAPED_SLASHES);
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