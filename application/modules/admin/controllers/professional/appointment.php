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

class appointment extends MX_Controller {


    
       
             public function status()
        {
              if ($this->input->server('REQUEST_METHOD') === 'PUT') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $doctor_id = $this->uri->segment(5);
                    $appointment_id = $Data->appointment_id;
                    $data['appointment_status'] = $Data->appointment_status;

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        
                        $this->db->where('id', $appointment_id);
                        $update = $this->db->update('appointments',$data);

                        if($update)
                        {

                         $query = $this->db->query("SELECT * from appointments WHERE doctor_id = $doctor_id and appointment_status!=9 ORDER BY date DESC,appointment_time DESC;");                        
                         
                         $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
                            $patient_name = $getUser->name;
                            $patient_image_url = $getUser->image;
                            $patient_gender = $getUser->gender;
                            $patient_number = $getUser->contact;
                            $patient_age=0;
                            if($getUser->date_of_birth!="")
                            {
                                $dob_year = explode("/", $getUser->date_of_birth);
                                $now = new DateTime();
                                $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                                $todays_year = $now->format('Y');
                                $patient_age = $todays_year - $dob_year[2];
                            }


                             $this->db->where('clinic_id',$dt->clinic_id);
                            $clinicdt = $this->db->get('clinic')->row(0);
                            $clinic_image_url = $clinicdt->clinic_image_url;
                             $this->db->where('clinic_id',$dt->clinic_id);
                            $this->db->where('doctor_id',$dt->doctor_id);
                            $doc_sch_dt = $this->db->get('doctor_schedule')->row(0);
                            $entry_time = "";
                            $exit_time = "";
                            if($doc_sch_dt)
                            {
                                $entry_time = $doc_sch_dt->entry_time;
                                $exit_time = $doc_sch_dt->exit_time;
                            }
                            
                            $boolean_manually_added = strtolower($dt->is_manually_added) == '1' ? true : false;

                            $ar = array("appointment_id"=>$dt->id,"doctor_id"=>$dt->doctor_id,"patient_id"=>$dt->patient_id,"patient_name" => $patient_name,
                            "patient_gender"=>$patient_gender,"patient_age"=>$patient_age,"patient_number"=>$patient_number,"patient_image_url"=>$patient_image_url,
                            "appointment_date"=>$dt->date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"purpose_of_visit"=>$dt->motive,
                            "is_manually_added"=> $boolean_manually_added,"consultation_fees"=>$dt->consultation_fees,"clinic_id"=>$dt->clinic_id,"clinic_name"=>$dt->clinic_name,"clinic_image_url"=>$clinic_image_url,
                            "entry_time"=>$entry_time,"exit_time"=>$exit_time,"created_on"=>$dt->created_on,"booked_by"=>$dt->booked_by,"booker_type"=>$dt->booker_type,"appointment_status"=>$dt->appointment_status);
                            array_push($result2, $ar);
                            
                         } 

                         echo json_encode(array('appointment' => $result2));
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

                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                } 
               
                   }

        }



    public function feedback()
        {
              if ($this->input->server('REQUEST_METHOD') === 'PUT') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $doctor_id = $this->uri->segment(5);
                    $appointment_id = $Data->appointment_id;
                    $data['doctor_feedback'] = $Data->doctor_feedback;

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        
                        $this->db->where('id', $appointment_id);
                        $update = $this->db->update('appointments',$data);

                        if($update)
                        {

                         $query = $this->db->query("SELECT * from appointments WHERE doctor_id = $doctor_id and appointment_status!=9 ORDER BY date DESC,appointment_time DESC;");                        
                         
                         $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
                            $patient_name = $getUser->name;
                            $patient_image_url = $getUser->image;
                            $patient_gender = $getUser->gender;
                            $patient_number = $getUser->contact;
                           $patient_age=0;
                            if($getUser->date_of_birth!="")
                            {
                                $dob_year = explode("/", $getUser->date_of_birth);
                                $now = new DateTime();
                                $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                                $todays_year = $now->format('Y');
                                $patient_age = $todays_year - $dob_year[2];
                            }


                             $this->db->where('clinic_id',$dt->clinic_id);
                            $clinicdt = $this->db->get('clinic')->row(0);
                            $clinic_image_url = $clinicdt->clinic_image_url;
                            $this->db->where('clinic_id',$dt->clinic_id);
                            $this->db->where('doctor_id',$dt->doctor_id);
                            $doc_sch_dt = $this->db->get('doctor_schedule')->row(0);
                            $entry_time = "";
                            $exit_time = "";
                            if($doc_sch_dt)
                            {
                                $entry_time = $doc_sch_dt->entry_time;
                                $exit_time = $doc_sch_dt->exit_time;
                            }
                            
                             $boolean_manually_added = strtolower($dt->is_manually_added) == '1' ? true : false;

                            $ar = array("appointment_id"=>$dt->id,"doctor_id"=>$dt->doctor_id,"patient_id"=>$dt->patient_id,"patient_name" => $patient_name,
                            "patient_gender"=>$patient_gender,"patient_age"=>$patient_age,"patient_number"=>$patient_number,"patient_image_url"=>$patient_image_url,
                            "appointment_date"=>$dt->date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"purpose_of_visit"=>$dt->motive,
                            "is_manually_added"=>$boolean_manually_added,"consultation_fees"=>$dt->consultation_fees,"clinic_id"=>$dt->clinic_id,"clinic_name"=>$dt->clinic_name,"clinic_image_url"=>$clinic_image_url,
                            "entry_time"=>$entry_time,"exit_time"=>$exit_time,"created_on"=>$dt->created_on,"booked_by"=>$dt->booked_by,"booker_type"=>$dt->booker_type,"appointment_status"=>$dt->appointment_status);
                            array_push($result2, $ar);
                            
                         } 

                         echo json_encode(array('appointment' => $result2));
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

                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                } 
               
                   }

        }







    
}