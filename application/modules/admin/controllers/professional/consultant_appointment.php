<?php

 require_once APPPATH . '/libraries/JWT.php';
 require_once APPPATH.'/libraries/email.php';
 require_once APPPATH.'/config/email.php';
    use \Firebase\JWT\JWT;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class consultant_appointment extends MX_Controller {

             public function get_consultant_appointment()
        {
              if ($this->input->server('REQUEST_METHOD') === 'POST') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $doctor_id = $this->uri->segment(5);

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');
                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $todays_date = $now->format('Y-m-d');
                       $query = $this->db->query("SELECT * from (SELECT * from appointments as a1 where doctor_id = $doctor_id and consultant = $Data->consultant_id and date>='$todays_date' ORDER BY date DESC LIMIT 5) a1 WHERE doctor_id = $doctor_id ORDER BY date;");

                        $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
                            if($getUser!=null)
                        {
                            $patient_name = $getUser->name;
                            $patient_image_url = $getUser->image_url;
                            $patient_gender = $getUser->gender;
                            $patient_number = $getUser->contact;
                            
                            $patient_age="";
                            if($getUser->dob!="")
                            {
                                $dob_year = $getUser->dob;
                                $now = new DateTime();
                                $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                                $todays_year = $now->format('Y');
                                $patient_age = $todays_year - $dob_year;
                            }
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
                            $consultant_data = $this->db->query("SELECT * from consultant WHERE id = $dt->consultant;")->result();
                            
                            $boolean_manually_added = strtolower($dt->is_manually_added) == '1' ? true : false;

                            $ar = array("appointment_id"=>$dt->id,"doctor_id"=>$dt->doctor_id,"patient_id"=>$dt->patient_id,"patient_name" => $patient_name,
                            "patient_gender"=>$patient_gender,"patient_age"=>$patient_age,"patient_number"=>$patient_number,"patient_image_url"=>$patient_image_url,
                            "appointment_date"=>$dt->date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"end_date"=>$dt->end_date,"purpose_of_visit"=>$dt->motive,
                            "is_manually_added"=> $boolean_manually_added,"consultation_fees"=>$dt->consultation_fees,"clinic_id"=>$dt->clinic_id,"clinic_name"=>$dt->clinic_name,"clinic_image_url"=>$clinic_image_url,
                            "entry_time"=>$entry_time,"exit_time"=>$exit_time,"created_on"=>$dt->created_on,"consultant_id"=>$dt->consultant,"consultant_name"=>$consultant_data[0]->name,"booked_by"=>$dt->booked_by,"booker_type"=>$dt->booker_type,"appointment_status"=>$dt->appointment_status);
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

    }
}   
    