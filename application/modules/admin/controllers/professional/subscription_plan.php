<?php

require_once APPPATH . '/libraries/JWT.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subscription_plan extends MX_Controller
{


    public function get_subscription_plan()
    {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {

                 $query = $this->db->query("SELECT * FROM subscription_plan;");
                     $plan_list = $query->result();
                    $result = array("subscription_plans" => $plan_list);
                    echo json_encode($result, JSON_UNESCAPED_SLASHES);
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
