<?php

 require_once APPPATH . '/libraries/JWT.php';
    use \Firebase\JWT\JWT;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class consultant extends MX_Controller {

             public function get_consultant()
        {
              if ($this->input->server('REQUEST_METHOD') === 'GET') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $doctor_id = $this->uri->segment(5);

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $query = $this->db->query("SELECT * FROM consultant where doctor_id = $doctor_id;");
                        $consultant = $query->result();
                        echo json_encode(array('consultant'=> $consultant));
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
    