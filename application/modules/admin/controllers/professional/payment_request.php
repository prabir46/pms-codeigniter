<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/email.php';
require_once APPPATH . '/config/email.php';

use \Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class payment_request extends MX_Controller
{
   public function getRequest()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $Data = json_decode(file_get_contents('php://input'));
            $token = $this->input->get_request_header('Authorization', TRUE);
            $this->db->where('access_token', $token);
            $result = $this->db->get('login');
            $doctor_id = $this->uri->segment(5);
            $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:ffa399a0372dc66888389b900b4a7271",
                  "X-Auth-Token:1b7c5af249aea77a8d378fae3ee206ed"));
$payload = Array(
    'purpose' => $Data->purpose,
    'amount' => $Data->amount,
    'phone' => $Data->phone,
    'buyer_name' => $Data->buyer_name,
    'redirect_url' => "http://www.example.com/redirect/",
    'send_email' => "true",
    'webhook' => "http://www.example.com/webhook/",
    'send_sms' => "true",
    'email' => $Data->email,
    'allow_repeated_payments' => "false"
);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);
curl_close($ch); 
$resp = json_decode($response,true);
$data['doctor_id']=$doctor_id;
$data['subscription_id']=$Data->subscription_id;
$data['purpose']=$resp['payment_request']['purpose'];
$data['amount']=$resp['payment_request']['amount'];
$data['phone']=$resp['payment_request']['phone'];
$data['buyer_name']=$resp['payment_request']['buyer_name'];
$data['email']=$resp['payment_request']['email'];
$data['transactional_id']=$resp['payment_request']['id'];
$data['created_at']=$resp['payment_request']['created_at'];
$data['modified_at']=$resp['payment_request']['modified_at'];

$this->db->insert('purchase',$data);

echo $response;
            //return $this->env . $json->access_token;
        } 
        //end of function
    }
}
