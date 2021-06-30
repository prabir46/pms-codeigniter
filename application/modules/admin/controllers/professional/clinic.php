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
                        $query = $this->db->query("SELECT * from (SELECT * FROM clinic where clinic_city='$search' OR clinic_name='%$search%' OR clinic_address_line_1 like '%$search%' OR clinic_address_line_2 like '%$search%' OR clinic_landmark like '%$search%') a1 where is_deactivated='false';");
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
    
    function send_notification()
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
                        $doctor_id = $this->uri->segment(5);
                        $data['clinic_id'] = $Data->clinic_id;
                        $data['consultation_fees'] = $Data->consultation_fees;
                        $data['doctor_id'] = $doctor_id;
                        $data['entry_time'] = $Data->entry_time;
                        $data['exit_time'] = $Data->exit_time;
                        $data['office_number'] = $Data->office_number;
                        $data['visiting_days'] = $Data->visiting_days;

                         $this->db->where('clinic_id', $data['clinic_id']);
                         $clinic = $this->db->get('clinic')->row(0);

                         $clinic_owner_id = $clinic->clinic_owner_id;

                         $this->db->where('doctor_id', $clinic_owner_id);
                         $firebase_data = $this->db->get('firebase_data')->row(0);

                         $token1 = $firebase_data->firebase_token;
                         if($token1!=null)
                         {
                             echo "acv".$token1."ax";
                                 define( 'API_ACCESS_KEY', 'AAAA83rnR7w:APA91bHYTaPyn4E2xh74oBFtVqKe_R7GH8x2_6-VIOAs1xkIOwEKxcIrOkiwOiXr15YnpmOTkaVh-tO4YNOWQ9CdPwjlFdRZtRJrIEtttSejUqUjHaPVcm472a9cQ--hCgKPelbE5gGQ' );
                        $registrationIds = array($token1);
                        // prep the add
                        $msg = array
                        (
                            'body'  => "Rohan has added a ".$clinic->clinic_name.".",
                            'title'     => "Clinic Added",
                            'vibrate'   => 1,
                            'sound'     => 1                        );

                        $fields = array
                        (
                            'registration_ids'  => $registrationIds,
                            'notification'          => $msg
                        );
                         
                        $headers = array
                        (
                            'Authorization: key=' . API_ACCESS_KEY,
                            'Content-Type: application/json'
                        );
                         
                        $ch = curl_init();
                        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                        curl_setopt( $ch,CURLOPT_POST, true );
                        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                        $result = curl_exec($ch );
                        curl_close( $ch );
                        echo $result;


                         }


                        }
                    }
                }



                }
    
         function add_doctor_schedule()
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
                        $doctor_id = $this->uri->segment(5);
                        $data['clinic_id'] = $Data->clinic_id;
                        $data['consultation_fees'] = $Data->consultation_fees;
                        $data['doctor_id'] = $doctor_id;
                        $data['entry_time'] = $Data->entry_time;
                        $data['exit_time'] = $Data->exit_time;
                        $data['slot_length'] = $Data->slot_length;
                        $data['office_number'] = $Data->office_number;
                        $data['visiting_days'] = $Data->visiting_days;

                         $this->db->where('clinic_id', $data['clinic_id']);
                         $clinic = $this->db->get('clinic')->row(0);

                         $clinic_owner_id = $clinic->clinic_owner_id;


                         if($doctor_id==$clinic_owner_id)
                         {
                            $data['is_approved'] = 1;
                         }
                         $data['is_deactivated'] = 'false';



                        $insert = $this->db->insert('doctor_schedule',$data);

                        if($insert)
                        {
                        
                            $query = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id and is_deactivated='false';");

                          $result1 = array();

                        foreach ($query->result() as $doctordata)
                        {

                            $clinic_id = $doctordata->clinic_id;
                            $this->db->where("clinic_id",$clinic_id);
                            $this->db->where("is_deactivated",'false');
                            $clinicdata = $this->db->get("clinic")->row(0);

                             $arr = array("doctor_schedule_id"=>$doctordata->doctor_schedule_id,"clinic_id" => $doctordata->clinic_id,
                                "consultation_fees" => $doctordata->consultation_fees,"doctor_id" => $doctordata->doctor_id,"entry_time" => $doctordata->entry_time,
                                "exit_time" => $doctordata->exit_time,"slot_length" => $doctordata->slot_length,"office_number" => $doctordata->office_number,
                                "visiting_days" => $doctordata->visiting_days,"clinic" => $clinicdata);

                            array_push($result1, $arr);
                           

                               
                        }

                         echo json_encode(array('doctor_schedule' => $result1));
                        }

                        else
                        {
                            header("HTTP/1.1 503 server is down");
                         exit;
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
    
        function edit_doctor_schedule()
    {
         if ($this->input->server('REQUEST_METHOD') === 'PUT') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                        $data['clinic_id'] = $Data->clinic_id;
                        $data['consultation_fees'] = $Data->consultation_fees;
                        $data['doctor_id'] = $doctor_id;
                        $data['entry_time'] = $Data->entry_time;
                        $data['exit_time'] = $Data->exit_time;
                        $data['slot_length'] = $Data->slot_length;
                        $data['office_number'] = $Data->office_number;
                        $data['visiting_days'] = $Data->visiting_days;
                        $data['doctor_schedule_id'] = $Data->doctor_schedule_id;

                         $this->db->where('clinic_id', $data['clinic_id']);
                         $clinic = $this->db->get('clinic')->row(0);

                         $clinic_owner_id = $clinic->clinic_owner_id;


                         if($doctor_id==$clinic_owner_id)
                         {
                            $data['is_approved'] = 1;
                         }



                                $this->db->where('doctor_schedule_id',$data['doctor_schedule_id']);
                        $insert = $this->db->update('doctor_schedule',$data);

                        if($insert)
                        {
                        
                            $query = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id and is_deactivated='false';");

                          $result1=array();

                        foreach ($query->result() as $doctordata)
                        {

                            $clinic_id = $doctordata->clinic_id;
                            $this->db->where("clinic_id",$clinic_id);
                            $this->db->where("is_deactivated",'false');
                            $clinicdata = $this->db->get("clinic")->row(0);

                             $arr = array("doctor_schedule_id"=>$doctordata->doctor_schedule_id,"clinic_id" => $doctordata->clinic_id,
                                "consultation_fees" => $doctordata->consultation_fees,"doctor_id" => $doctordata->doctor_id,"entry_time" => $doctordata->entry_time,
                                "exit_time" => $doctordata->exit_time,"slot_length" => $doctordata->slot_length,"office_number" => $doctordata->office_number,
                                "visiting_days" => $doctordata->visiting_days,"clinic" => $clinicdata);

                            array_push($result1, $arr);
                           

                               
                        }

                         echo json_encode(array('doctor_schedule' => $result1));
                        }

                        else
                        {
                            header("HTTP/1.1 503 server is down");
                         exit;
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
    
    
     function delete_doctor_schedule()
    {
         if ($this->input->server('REQUEST_METHOD') === 'DELETE') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                        $data['clinic_id'] = $Data->clinic_id;
                        $data['consultation_fees'] = $Data->consultation_fees;
                        $data['doctor_id'] = $doctor_id;
                        $data['entry_time'] = $Data->entry_time;
                        $data['exit_time'] = $Data->exit_time;
                        $data['office_number'] = $Data->office_number;
                        $data['visiting_days'] = $Data->visiting_days;
                        $data['doctor_schedule_id'] = $Data->doctor_schedule_id;

                         $this->db->where('clinic_id', $data['clinic_id']);
                         $clinic = $this->db->get('clinic')->row(0);

                         $clinic_owner_id = $clinic->clinic_owner_id;


                         if($doctor_id==$clinic_owner_id)
                         {
                            $data['is_approved'] = 1;
                         }


                            $data1['is_deactivated']='true';
                            $this->db->where('doctor_schedule_id',$data['doctor_schedule_id']);
                            $insert = $this->db->update('doctor_schedule',$data1);

                        if($insert)
                        {
                        
                            $query = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id and is_deactivated='false';");

                            $result1=array();

                        foreach ($query->result() as $doctordata)
                        {

                            $clinic_id = $doctordata->clinic_id;
                            $this->db->where("clinic_id",$clinic_id);
                            $this->db->where("is_deactivated",'false');
                            $clinicdata = $this->db->get("clinic")->row(0);

                             $arr = array("doctor_schedule_id"=>$doctordata->doctor_schedule_id,"clinic_id" => $doctordata->clinic_id,
                                "consultation_fees" => $doctordata->consultation_fees,"doctor_id" => $doctordata->doctor_id,"entry_time" => $doctordata->entry_time,
                                "exit_time" => $doctordata->exit_time,"slot_length" => $doctordata->slot_length,"office_number" => $doctordata->office_number,
                                "visiting_days" => $doctordata->visiting_days,"clinic" => $clinicdata);

                            array_push($result1, $arr);
                           

                               
                        }

                         echo json_encode(array('doctor_schedule' => $result1));
                        }

                        else
                        {
                            header("HTTP/1.1 503 server is down");
                         exit;
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
    
    
    
     public function doctor_schedule()
    {
           
                 if ($this->input->server('REQUEST_METHOD') === 'GET') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $doctor_id=$this->uri->segment(5);
                    
                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');
                    
                    
                 if ($result->num_rows() == 1)
                {

                    
                  if($result->row(0)->status==1)
                    {
                                      

                          $query = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id and is_deactivated='false';");

                        $result1=array();

                        foreach ($query->result() as $doctordata)
                        {

                            $clinic_id = $doctordata->clinic_id;
                            $this->db->where("clinic_id",$clinic_id);
                            $this->db->where("is_deactivated",'false');
                            $clinicdata = $this->db->get("clinic")->row(0);

                             $arr = array("doctor_schedule_id"=>$doctordata->doctor_schedule_id,"clinic_id" => $doctordata->clinic_id,
                                "consultation_fees" => $doctordata->consultation_fees,"doctor_id" => $doctordata->doctor_id,"entry_time" => $doctordata->entry_time,
                                "exit_time" => $doctordata->exit_time,"slot_length" => $doctordata->slot_length,"office_number" => $doctordata->office_number,
                                "visiting_days" => $doctordata->visiting_days,"clinic" => $clinicdata);

                            array_push($result1, $arr);
                           

                               
                        }

                         echo json_encode(array('doctor_schedule' => $result1));
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