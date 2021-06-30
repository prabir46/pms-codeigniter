<?php

 require_once APPPATH . '/libraries/JWT.php';
 require_once APPPATH.'/libraries/email.php';
 require_once APPPATH.'/config/email.php';
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

class delete extends MX_Controller {

     
     function patient()
        {
            

            if ($this->input->server('REQUEST_METHOD') === 'DELETE') {
                   // $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);    
                           $final_query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                        foreach ($final_query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                        $this->db->where('id',$patient_id);
                        $query1 = $this->db->delete('users');

                        $this->db->where('patient_id',$patient_id);
                        $query2 = $this->db->delete('doc_user_relation'); 
                        }
                        }
                    }
                

                 else
                    {
                        header("HTTP/1.1 401 Unauthorized");
                        exit;
                    }
                }

            }


            //end of function
        }  
        
        
        
    