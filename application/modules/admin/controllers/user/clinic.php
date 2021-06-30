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

class clinic extends MX_Controller {
    
     
    
     function search_clinic()
    {
         if ($this->input->server('REQUEST_METHOD') === 'POST') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $search= $Data->search;
                       // echo json_encode(array('clinic'=> $city));
                        $query = $this->db->query("SELECT * from (SELECT * FROM clinic where clinic_city='$search' OR clinic_name='%$search%' OR clinic_address_line_1 like '%$search%' OR clinic_address_line_2 like '%$search%' OR clinic_landmark like '%$search%') a1 where is_deactivated='false';");

                        // $this->db->where('clinic_city', $city);
                        $clinic = $query->result();
                        echo json_encode(array('clinic'=> $clinic));

                        

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
}