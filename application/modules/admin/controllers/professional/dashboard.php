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

class dashboard extends MX_Controller {
    
    
    public function dashboard()
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
                    
                        $id = $this->uri->segment(5);
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $todays_date = $now->format('Y-m-d');

                         $query1 = $this->db->query("SELECT COUNT(*) FROM appointment where appointment_date=$todays_date;");
                         $today = $query1->result();

                        $query2 = $this->db->query("SELECT COUNT(*) FROM `appointment` WHERE month(appointment_date) = month(curdate())-1;");
                         $last_month = $query2->result();
                        
                        $query3 = $this->db->query("SELECT WEEK(CURRENT_DATE, 3) - WEEK(CURRENT_DATE - INTERVAL DAY(CURRENT_DATE)-1 DAY, 3) + 1;");
                         $upcoming_week = $query3->result();

                         $result1 = array('today' => $today, 'upcoming_week' => $upcoming_week,'last_month' => $last_month);

                         echo json_encode(array('appointment_count' => $result1));
                        //   $result1 = array();

                        // foreach ($query->result() as $doctordata)

                       
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

            else
            {
                  header("HTTP/1.1 405 Method Not Allowed");
                            exit;

            }
        }



    
}