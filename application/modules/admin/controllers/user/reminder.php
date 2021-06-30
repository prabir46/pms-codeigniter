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

class reminder extends MX_Controller {
    
    public function medicine_details()
    {
          $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');
                     if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
         if ($this->input->server('REQUEST_METHOD') === 'POST') {
            // echo $search;
            // $search=$this->get('search');
            // echo $search;
            // die;
            $search=$this->input->post('search');
            $query="select * from medicine_details where medicine_name like '%$search%'";
            $result=$this->db->query($query);
           // print_r($result->result());
            $ashu=array('status'=>"success",'medicine_list'=>$result->result());
            echo json_encode($ashu);
         }
                    }
                    else
                        {
                        header("HTTP/1.1 503 server is down");
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