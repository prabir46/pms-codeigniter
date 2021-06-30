<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class transaction_completion extends MX_Controller
{
    function transactiom_complete()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $Data = json_decode(file_get_contents('php://input'));

            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {
                    $doctor_id = $this->uri->segment(5);
               
                    $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
                    $query1 = $this->db->query("Update doctor SET expire_on = '$oneYearOn' WHERE id = $doctor_id;");
                    $query2 = $this->db->query("Update purchase SET is_success = 'true' WHERE doctor_id = $doctor_id and transactional_id = '$Data->transactional_id';");
                    echo json_encode(array('status' =>'success'));
            
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