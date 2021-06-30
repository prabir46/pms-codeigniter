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

class patient extends MX_Controller {
    
    
   public function index()
    {
          if ($this->input->server('REQUEST_METHOD') === 'GET') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = 19;
                        $query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                          $result1 = array();

                        foreach ($query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                            $this->db->where('id',$patient_id);
                            //Edited By @runKumar
                            $this->db->select('id,name,gender,email_id,phone_number,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row(0);

                            array_push($result1, $arr);
                        }
                            $result = array("patients"=>$result1);
                        echo json_encode($result);
                    }
                

                 else
                    {
                        header("HTTP/1.1 401 Unauthorized");
                    exit;
                    }
                }

                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                } 

            }
    }
    
     
     function get_patient()
        {
             if ($this->input->server('REQUEST_METHOD') === 'GET') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                        $query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                          $result1 = array();

                        foreach ($query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                            $this->db->where('id',$patient_id);
                            //Edited By @runKumar
                            $this->db->select('id,name,gender,email_id,phone_number,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row(0);

                            array_push($result1, $arr);
                        }
                            $result = array("patients"=>$result1);
                        echo json_encode($result);
                    }
                

                 else
                    {
                        header("HTTP/1.1 401 Unauthorized");
                    exit;
                    }
                }

                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                } 

            }

        }    

    
    
    
    
}