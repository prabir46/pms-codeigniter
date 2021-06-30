<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class diwali extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->helper('dompdf_helper');
        $this->load->model("custom_field_model");
        $this->load->model("instruction_model");
        $this->load->model("prescription_model");
        $this->load->model("notification_model");
        $this->load->model("patient_model");
        $this->load->model("medicine_model");
        $this->load->model("disease_model");
        $this->load->model("medical_test_model");
        $this->load->model("setting_model");
        $this->load->model("invoice_model");
        $this->load->model("payment_mode_model");
        $this->load->model("treatment_advised_model");
        $this->load->library('session');
    }

    public function index()
    {
        $i=85;
        $this->db->where('doctor_id',$i);
       $con= $this->db->get('users')->result();
       // print_r($con);
      // die;
       // $con=$data['h']->contact;
       foreach($con as $c)
       {
          print_r($c);
          $fir=$c->contact;
           $authKey = "144872ArhHeSNu58c7bb84";

           //Multiple mobiles numbers separated by comma
           $mobileNumber = $fir;
            echo $fir;
            echo '\n';
           //Sender ID,While using route4 sender id should be 6 characters long.
           $senderId = "DOCTRI";

           //Your message to send, Add URL encoding here.
           $mesg = "Wish you and your family a very Happy Dipawali \n"."from\n"."Dental And Smile Care.";
           $message = urlencode($mesg);

           //Define route
           $route = 4;
           //Prepare you post parameters
           $postData = array(
               'authkey' => $authKey,
               'mobiles' => $mobileNumber,
               'message' => $message,
               'sender' => $senderId,
               'route' => $route
           );

           //API URL
           $url = "http://sms.globehost.com/api/sendhttp.php?";

           // init the resource
           $ch = curl_init();
           curl_setopt_array($ch, array(
               CURLOPT_URL => $url,
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_POST => true,
               CURLOPT_POSTFIELDS => $postData
               //,CURLOPT_FOLLOWLOCATION => true
           ));


           //Ignore SSL certificate verification
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


           //get response
           $output = curl_exec($ch);

           //Print error if any
           if (curl_errno($ch)) {
               echo 'error:' . curl_error($ch);
           }

           curl_close($ch);
       }
    }

}