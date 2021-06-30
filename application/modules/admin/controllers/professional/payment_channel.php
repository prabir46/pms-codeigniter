<?php

require_once APPPATH . '/libraries/JWT.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* require_once APPPATH . '/libraries/autoload.php';
$openapi = \OpenApi\scan('http://www.doctori8.com/doctori8_pro/admin/api/');
header('Content-Type: application/x-yaml');
echo $openapi->toYaml(); */

/**
 * @OA\Info(title="My First API", version="0.1")
 */

/**
 * @OA\Get(
 *     path="/api/resource.json",
 *     @OA\Response(response="200", description="An example resource")
 * )
 */

class payment_channel extends MX_Controller
{


    public function get_payment_channel()
    {
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $Data = json_decode(file_get_contents('php://input'));


            $token = $this->input->get_request_header('Authorization', TRUE);

            $this->db->where('access_token', $token);
            $result = $this->db->get('login');

            if ($result->num_rows() == 1) {
                if ($result->row(0)->status == 1) {

                    $query = $this->db->query("SELECT * FROM payment_channel;");

                    $result1 = array();

                    foreach ($query->result() as $payment_channel) {

                        //Edited By @runKumar

                        array_push($result1, $payment_channel);
                    }
                    $result = array("payment_channel" => $result1);
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
