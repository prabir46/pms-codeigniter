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

class api extends MX_Controller {

     
     function patient()
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
                         $query_sh = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id;");
                     $results1 = array();
                     foreach ($query_sh->result() as $data)
                        {
                             $this->db->where('clinic_id', $data->clinic_id);
                     $this->db->where('is_deactivated', "false");
                    $clinic1 = $this->db->get('clinic')->row(0);
                    array_push($results1, $clinic1);
                        }
                        
                    $this->db->where('clinic_owner_id', $doctor_id );
                    $this->db->where('is_deactivated', "false");
                    $results2 = $this->db->get('clinic')->result();
                    
                    $merging_data = array_merge($results1, $results2);
                    $final_list_clinic= array_unique($merging_data,SORT_REGULAR);
                    foreach($final_list_clinic as $obj)
                    {
                        $cl_id = $obj->clinic_id;
                        $query3 = $this->db->query("SELECT * FROM doc_user_relation where clinic_id=$cl_id;");
                         $result1 = array();

                        foreach ($query3->result() as $obj_data)
                        {
                            $patient_id = $obj_data->patient_id;
                            $this->db->where('id',$patient_id)->limit(200);
                            //Edited By @runKumar
                            $this->db->select('id,name,username,gender,email_id,contact,age,dob,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row();
                            $patient['id'] = $arr->id;
                            $patient['name'] = $arr->name;
                            $patient['username'] = $arr->username;
                            $patient['gender'] = $arr->gender;
                            if($arr->dob==0){
                            $patient['age']='';
                            }
                            else{
                            $patient['age'] = date("Y") - $arr->dob;
                            }
                            $patient['email_id'] = $arr->email_id;
                            $patient['phone_number'] = $arr->contact;
                            $patient['image_url'] = $arr->image_url;
                            $patient['date_of_birth'] = $arr->date_of_birth;
                            $patient['blood_group'] = $arr->blood_group;
                            $patient['street_name'] = $arr->street_name;
                            $patient['city'] = $arr->city;
                            $patient['state'] = $arr->state;
                            $patient['latitude'] = $arr->latitude;
                            $patient['longitude'] = $arr->longitude;
                            $patient['firebase_id'] = $arr->firebase_id;
                            $patient['created_on'] = $arr->created_on;
                            $patient['last_active'] = $arr->last_active;
                            array_push($result1, (object)$patient);
                        }
                    }
                        
                        
                        
                        $query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                          $result2 = array();

                        foreach ($query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                            $this->db->where('id',$patient_id)->limit(200);
                            //Edited By @runKumar
                            $this->db->select('id,name,username,gender,email_id,contact,age,dob,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row();
                            $patient['id'] = $arr->id;
                            $patient['name'] = $arr->name;
                            $patient['username'] = $arr->username;
                            $patient['gender'] = $arr->gender;
                             if($arr->dob==0){
                            $patient['age']='';
                            }
                            else{
                            $patient['age'] = date("Y") - $arr->dob;
                            }
                            $patient['email_id'] = $arr->email_id;
                            $patient['phone_number'] = $arr->contact;
                            $patient['image_url'] = $arr->image_url;
                            $patient['date_of_birth'] = $arr->date_of_birth;
                            $patient['blood_group'] = $arr->blood_group;
                            $patient['street_name'] = $arr->street_name;
                            $patient['city'] = $arr->city;
                            $patient['state'] = $arr->state;
                            $patient['latitude'] = $arr->latitude;
                            $patient['longitude'] = $arr->longitude;
                            $patient['firebase_id'] = $arr->firebase_id;
                            $patient['created_on'] = $arr->created_on;
                            $patient['last_active'] = $arr->last_active;
							
							/*$patient->id = $arr->id;
                            $patient->name = $arr->name;
                            $patient->username = $arr->username;
                            $patient->gender = $arr->gender;
                            if($arr->dob==0){
                            $patient->age='';
                            }
                            else{
                            $patient->age = date("Y") - $arr->dob;
                            }
                            $patient->email_id = $arr->email_id;
                            $patient->phone_number = $arr->contact;
                            $patient->image_url = $arr->image_url;
                            $patient->date_of_birth = $arr->date_of_birth;
                            $patient->blood_group = $arr->blood_group;
                            $patient->street_name = $arr->street_name;
                            $patient->city = $arr->city;
                            $patient->state = $arr->state;
                            $patient->latitude = $arr->latitude;
                            $patient->longitude = $arr->longitude;
                            $patient->firebase_id = $arr->firebase_id;
                            $patient->created_on = $arr->created_on;
                            $patient->last_active = $arr->last_active;*/
							
                            array_push($result2, (object)$patient);
                        }
                        $merging = array_merge($result1, $result2);
                    	$final= array_unique($merging,SORT_REGULAR);
						//echo '<pre>final : '; print_r($final); echo '</pre>';						
                       $result = (object)array("patients"=>(array)array_values($final));
						//echo '<pre>result : '; print_r($result); echo '</pre>';
                        echo json_encode($result,JSON_UNESCAPED_SLASHES);die;
						//echo serialize($result);die;
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

            elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                        $this->db->where('id',$doctor_id);
                        $doc = $this->db->get('doctor')->row(0);
                        $doctor_name = $doc->name;



                        if($Data->patient_phone_number==NULL)
                        {
                            header("HTTP/1.1 405 Method Not Allowed");
                            exit;
                        }

                        $data['name']=$Data->patient_name;
                        $number = $Data->patient_phone_number;
                        $data['contact'] = $number;
                        $data['gender']=$Data->gender;
                        $data['user_role'] = '2';
                        if(!empty($Data->age)){
                            $data['age']=$Data->age;
                        }
                        $data['dob'] = date("Y") - $Data->age;
                          if($data['gender']=="Male")
                        {
                            $data['image_url'] = "http://dentizone.in/pms/assets/uploads/images/man.png";
                        }
                        elseif($data['gender']=="Female")
                        {
                            $data['image_url'] = "http://dentizone.in/pms/assets/uploads/images/woman.png";
                        }
                        else
                        {
                            $data['image_url'] = "http://dentizone.in/pms/assets/uploads/images/baby-boy.png";
                        }
                        
                        
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $data['created_on'] = $now->format('Y-m-d H:i:s');
                        

                        $this->db->where('contact',$number);
                        $query=$this->db->get('users')->row(0);

                       // $this->db->where('patient_id',$query->id);
                       // $this->db->where('doctor_id',$doctor_id);
                       // $queryDocUserRelation=$this->db->get('doc_user_relation')->num_rows();

                        if($query)
                        {
                               $this->db->where('patient_id',$query->id);
                               $this->db->where('doctor_id',$doctor_id);
                               $query1=$this->db->get('doc_user_relation')->row(0);
                              if($query1)
                              {
                                  //do nothing
                             }
                else {
                            $save['patient_id'] = $query->id;
                            $save['doctor_id'] = $doctor_id;
                            if(!empty($Data->clinic_id)){
                                $save['clinic_id']=$Data->clinic_id;
                            }
                            $now = new DateTime();
                            $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                            $save['created_on'] = $now->format('Y-m-d H:i:s');
                            $this->db->insert('doc_user_relation',$save);
                            
                            
                                //Send Sms
                                $authKey = "144872ArhHeSNu58c7bb84";
                                $mobileNumber = $number;
                                $senderId = "DOCTRI";
                                $mesg = "You are added as a client to ".$doctor_name.".";
                                $message = urlencode($mesg);
                                $route = 4;
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender' => $senderId,
                                    'route' => $route
                                );
                                $url = "http://sms.globehost.com/api/sendhttp.php?";
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                $output = curl_exec($ch);
                                if (curl_errno($ch)) {
                                    echo 'error:' . curl_error($ch);
                                }
                                curl_close($ch);
                            
                        }
                        }

                        else
                        {
                            $this->db->insert('users',$data);
                            
                            $this->db->where('contact',$number);
                            $query=$this->db->get('users')->row(0);

                            $this->db->where('patient_id',$query->id);
                            $this->db->where('doctor_id',$doctor_id);
                            $queryDocUserRelation=$this->db->get('doc_user_relation')->num_rows();

                            $save['patient_id'] = $query->id;
                            $save['doctor_id'] = $doctor_id;
                            if(!empty($Data->clinic_id)){
                                $save['clinic_id']=$Data->clinic_id;
                            }
                            $patient_name = $query->name;
                            
                            $now = new DateTime();
                            $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                            $save['created_on'] = $now->format('Y-m-d H:i:s');
                            if($queryDocUserRelation==0){
                                $this->db->insert('doc_user_relation',$save);
                            }
                            
                        
                                //Send Sms
                                $authKey = "144872ArhHeSNu58c7bb84";
                                $mobileNumber = $number;
                                $senderId = "DOCTRI";
                                $mesg = "Dear ".$patient_name.", Thank you for visiting ".$doctor_name.". Please install https://play.google.com/store/apps/details?id=com.zubilo.doctori8pro for making your life healthier and easier.";
                                $message = urlencode($mesg);
                                $route = 4;
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender' => $senderId,
                                    'route' => $route
                                );
                                $url = "http://sms.globehost.com/api/sendhttp.php?";
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                $output = curl_exec($ch);
                                if (curl_errno($ch)) {
                                    echo 'error:' . curl_error($ch);
                                }
                                curl_close($ch);
                            
                        }

                          $result1 = array();
                           $final_query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                        foreach ($final_query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                            $this->db->where('id',$patient_id);
                            //Edited By @runKumar
                            $this->db->select('id,name,gender,age,dob,email,contact,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row(0);

                            array_push($result1, $arr);
                        }
                            $result = array("patients"=>$result1);
                            echo json_encode($result, JSON_UNESCAPED_SLASHES);
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


            elseif ($this->input->server('REQUEST_METHOD') === 'PUT') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                        $this->db->where('id',$doctor_id);
                        $doc = $this->db->get('doctor')->row(0);
                        $doctor_name = $doc->username;



                        if($Data->id==NULL)
                        {
                            header("HTTP/1.1 405 Method Not Allowed");
                            exit;
                        }

                        $patient_id=$Data->id;
                        $data['name']=$Data->patient_name;
                        $data['gender']=$Data->gender;

                        $this->db->where('id',$patient_id);
                        $query = $this->db->update('users',$data);

                        if($query)
                        {
                                $this->db->where('id',$patient_id);
                                $query1 = $this->db->get('users')->row(0);
                                $number = $query1->contact;
                                //Send Sms
                                $authKey = "144872ArhHeSNu58c7bb84";
                                $mobileNumber = $number;
                                $senderId = "DOCTRI";
                                $mesg = "Your profile has been updated by ".$doctor_name.". Please install the Doctori8 App https://play.google.com/store/apps/details?id=com.zubilo.doctori8pro for making your life healthier and easier.";
                                $message = urlencode($mesg);
                                $route = 4;
                                $postData = array(
                                    'authkey' => $authKey,
                                    'mobiles' => $mobileNumber,
                                    'message' => $message,
                                    'sender' => $senderId,
                                    'route' => $route
                                );
                                $url = "http://sms.globehost.com/api/sendhttp.php?";
                                $ch = curl_init();
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => $url,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_POST => true,
                                    CURLOPT_POSTFIELDS => $postData
                                    //,CURLOPT_FOLLOWLOCATION => true
                                ));
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                $output = curl_exec($ch);
                                if (curl_errno($ch)) {
                                    echo 'error:' . curl_error($ch);
                                }
                                curl_close($ch);
                            
                        }

                        else
                        {
                            header("HTTP/1.1 503 Database error");
                            exit;
                            
                        }

                           $result1 = array();
                           $final_query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                        foreach ($final_query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                            $this->db->where('id',$patient_id);
                            //Edited By @runKumar
                            $this->db->select('id,name,gender,email,contact,age,dob,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row(0);

                            array_push($result1, $arr);
                        }
                            $result = array("patients"=>$result1);
                            echo json_encode($result, JSON_UNESCAPED_SLASHES);
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

             elseif ($this->input->server('REQUEST_METHOD') === 'DELETE') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                       

                        if($Data->id==NULL)
                        {
                            header("HTTP/1.1 405 Method Not Allowed");
                            exit;
                        }

                        $patient_id=$Data->id;
                        $data['name']=$Data->patient_name;
                        $data['gender']=$Data->gender;

                        $this->db->where('id',$patient_id);
                        $query1 = $this->db->delete('users');

                        $this->db->where('patient_id',$patient_id);
                        $query2 = $this->db->delete('doc_user_relation');    

                        if($query1 && $query2)
                        {
                         
                           $result1 = array();
                           $final_query = $this->db->query("SELECT * FROM doc_user_relation where doctor_id=$doctor_id;");

                        foreach ($final_query->result() as $doctordata)
                        {
                            $patient_id = $doctordata->patient_id;
                            $this->db->where('id',$patient_id);
                            //Edited By @runKumar
                            $this->db->select('id,name,gender,email,contact,image_url,date_of_birth,blood_group,street_name,city,state,latitude,longitude,firebase_id,created_on,last_active');
                            $arr=$this->db->get('users')->row(0);

                            array_push($result1, $arr);
                        }
                            $result = array("patients"=>$result1);
                            echo json_encode($result, JSON_UNESCAPED_SLASHES);
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


            //end of function
        }    
        
        
        


function appointment()
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

                         $query = $this->db->query("SELECT * from appointments WHERE doctor_id = $doctor_id and appointment_status!=9 ORDER BY date DESC,appointment_time DESC LIMIT 200;");                        
                         
                         $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                //echo '<pre>'; print_r($dt); echo '</pre>';
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
							//$getUser = $this->db->query("SELECT * from users WHERE id = $dt->patient_id;")->row();
							//echo '<pre>'; print_r($getUser); echo '</pre>';
							
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
							else{
								$patient_name = '';
								$patient_image_url = '';
								$patient_gender = '';
								$patient_number = '';					
								$patient_age = '';
								$todays_year = '';
								$patient_age = '';
							}
							
                            $this->db->where('clinic_id',$dt->clinic_id);
                            $clinicdt = $this->db->get('clinic')->row(0);
							if(isset($clinicdt->clinic_image_url))
                            	$clinic_image_url = $clinicdt->clinic_image_url;
							else
								$clinic_image_url = '';

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

            elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $doctor_id = $this->uri->segment(5);
                        $this->db->where('id',$doctor_id);
                        $doc = $this->db->get('doctor')->row(0);
                        $doctor_name = $doc->username;



                        // if($Data->appointment_id==NULL)
                        // {
                        //     header("HTTP/1.1 405 Method Not Allowed");
                        //     exit;
                        // }
                        
                        /*
                            $app_date = explode('/',$Data->appointment_date);
                            $app_date = array_reverse($app_date,true);
                            $app_date_new = implode("-", $app_date);
                        */
                        
                        $data['doctor_id']=$doctor_id;
                        $data['patient_id'] = $Data->patient_id;
                        $patient_query = $this->db->query("SELECT * from users WHERE id = $Data->patient_id;")->result();
                        $data['title'] = $patient_query[0]->name;
                        $data['appointment_time'] = $Data->appointment_time;
                        if($Data->appointment_date!=null || $Data->appointment_date!="")
                           { $app_date = explode('/',$Data->appointment_date);
                            $app_date = array_reverse($app_date,true);
                            $app_date_new = implode("-", $app_date);
                                                   }
                          
                        
                        $new_time = DateTime::createFromFormat('h:i A', $Data->appointment_time);
                        $time_24 = $new_time->format('H:i:s');
                        $date = date('Y-m-d H:i:s', strtotime("$app_date_new $time_24")); 
                        $data['date'] = $date;
                        $data['clinic_id'] = $Data->clinic_id;
                        
                        $this->db->where('clinic_id',$data['clinic_id']);
                        $clinicdt = $this->db->get('clinic')->row(0);
                        $data['clinic_name'] = $clinicdt->clinic_name;
                        $clinic_image_url = $clinicdt->clinic_image_url;
                        $data['Color'] = '0000FF';
                        $data['slot_length'] = $Data->slot_length;
                        $slot_to_add = "";
                        if($Data->slot_length =='15 mins')
                        {
                           $slot_to_add = '+15 minutes'; 
                        }
                        
                         if($Data->slot_length =='30 mins')
                        {
                           $slot_to_add = '+30 minutes'; 
                        }
                        
                         if($Data->slot_length =='45 mins')
                        {
                           $slot_to_add = '+45 minutes'; 
                        }
                         if($Data->slot_length =='1 hr')
                        {
                           $slot_to_add = '+1 hour'; 
                        }
                        
                         if($Data->slot_length =='1 h 15 mins')
                        {
                           $slot_to_add = '+1 hour 15 minutes'; 
                        }
                        
                          if($Data->slot_length =='1 h 30 mins')
                        {
                           $slot_to_add = '+1 hour 30 minutes'; 
                        }
                        $data['motive'] = $Data->purpose_of_visit;
                        $data['is_manually_added'] = $Data->is_manually_added;
                        $data['consultation_fees'] = $Data->consultation_fees;
                        $cenvertedEndTime = date('Y-m-d H:i:s',strtotime($slot_to_add,strtotime($date)));
                        $data['end_date'] = $cenvertedEndTime;
                        $data['booked_by'] = $Data->booked_by;
                        $data['booker_type'] = $Data->booker_type;
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $data['created_on'] = $now->format('Y-m-d H:i:s');
                        $data['appointment_status'] = 2;
                        $consultant_data = $this->db->query("SELECT * from consultant WHERE doctor_id = $doctor_id and id = $Data->consultant_id;")->result();
                        $data['consultant'] = $consultant_data[0]->id;
                        $data['Color'] = $consultant_data[0]->Color;
                        $query = $this->db->insert('appointments',$data);

                        $apt['patient_id'] = $data['patient_id'];
                        $apt['created_at'] = $now->format('Y-m-d H:i:s');
                        $this->db->insert('treatment',$apt);


                        if($query)
                        {
                         $query = $this->db->query("SELECT * from appointments WHERE doctor_id = $doctor_id and appointment_status!=9 ORDER BY date DESC,appointment_time DESC;");                        
                         
                         $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
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
                            "appointment_date"=>$dt->date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"purpose_of_visit"=>$dt->motive,
                            "is_manually_added"=>$boolean_manually_added,"consultation_fees"=>$dt->consultation_fees,"clinic_id"=>$dt->clinic_id,"clinic_name"=>$dt->clinic_name,"clinic_image_url"=>$clinic_image_url,
                            "entry_time"=>$entry_time,"exit_time"=>$exit_time,"created_on"=>$dt->created_on,"consultant_id"=>$dt->consultant,"consultant_name"=>$consultant_data[0]->name,"booked_by"=>$dt->booked_by,"booker_type"=>$dt->booker_type,"appointment_status"=>$dt->appointment_status);
                            array_push($result2, $ar);
                            
                         } 

                         echo json_encode(array('appointment' => $result2));
                            
                            
                                //Send Sms
                                // $authKey = "144872ArhHeSNu58c7bb84";
                                // $mobileNumber = $number;
                                // $senderId = "DOCTRI";
                                // $mesg = "You are added as a client to ".$doctor_name.".";
                                // $message = urlencode($mesg);
                                // $route = 4;
                                // $postData = array(
                                //     'authkey' => $authKey,
                                //     'mobiles' => $mobileNumber,
                                //     'message' => $message,
                                //     'sender' => $senderId,
                                //     'route' => $route
                                // );
                                // $url = "http://sms.globehost.com/api/sendhttp.php?";
                                // $ch = curl_init();
                                // curl_setopt_array($ch, array(
                                //     CURLOPT_URL => $url,
                                //     CURLOPT_RETURNTRANSFER => true,
                                //     CURLOPT_POST => true,
                                //     CURLOPT_POSTFIELDS => $postData
                                //     //,CURLOPT_FOLLOWLOCATION => true
                                // ));
                                // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                // $output = curl_exec($ch);
                                // if (curl_errno($ch)) {
                                //     echo 'error:' . curl_error($ch);
                                // }
                                // curl_close($ch);
                            
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


            elseif ($this->input->server('REQUEST_METHOD') === 'PUT') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                         $doctor_id = $this->uri->segment(5);
                        $this->db->where('id',$doctor_id);
                        $doc = $this->db->get('doctor')->row(0);
                        $doctor_name = $doc->username;


                        if($Data->appointment_id==NULL)
                        {
                            header("HTTP/1.1 405 Method Not Allowed");
                            exit;
                        }

                        $appointment_id = $Data->appointment_id;
                        $data['doctor_id']=$doctor_id;
                        $data['patient_id'] = $Data->patient_id;
                
                        $data['appointment_time'] = $Data->appointment_time;
                        if($Data->appointment_date!=null || $Data->appointment_date!="")
                           { $app_date = explode('/',$Data->appointment_date);
                            $app_date = array_reverse($app_date,true);
                            $app_date_new = implode("-", $app_date);
                                                   }
                          
                        
                        $new_time = DateTime::createFromFormat('h:i A', $Data->appointment_time);
                        $time_24 = $new_time->format('H:i:s');
                        $date = date('Y-m-d H:i:s', strtotime("$app_date_new $time_24")); 
                        $data['date'] = $date;
                        $data['clinic_id'] = $Data->clinic_id;
                        
                        $this->db->where('clinic_id',$data['clinic_id']);
                        $clinicdt = $this->db->get('clinic')->row(0);
                        $data['clinic_name'] = $clinicdt->clinic_name;
                        $clinic_image_url = $clinicdt->clinic_image_url;
                        

                        $data['slot_length'] = $Data->slot_length;
                        $data['motive'] = $Data->purpose_of_visit;
                        $data['is_manually_added'] = $Data->is_manually_added;
                        $data['consultation_fees'] = $Data->consultation_fees;
                        $data['booked_by'] = $Data->booked_by;
                        $data['booker_type'] = $Data->booker_type;
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $data['created_on'] = $now->format('Y-m-d H:i:s');

                        $this->db->where('id',$appointment_id);
                        $apt_check = $this->db->get('appointments')->row(0);

                        $old_appointment_date = $apt_check->date;
                        $old_appointment_time = $apt_check->appointment_time;

                        if($old_appointment_date!=$app_date_new || $old_appointment_time!=$data['appointment_time'])
                        {
                            $data['appointment_status'] = 8;
                        }

                        $consultant_data = $this->db->query("SELECT * from consultant WHERE doctor_id = $doctor_id and id = $Data->consultant_id;")->result();
                        $data['consultant'] = $consultant_data[0]->id;
                        $data['Color'] = $consultant_data[0]->Color;
                        $this->db->where('id',$appointment_id);
                        $query = $this->db->update('appointments',$data);

                        if($query)
                        {

                         $query = $this->db->query("SELECT * from appointments WHERE doctor_id = $doctor_id and appointment_status!=9 ORDER BY date DESC,appointment_time DESC;");                        
                         
                         $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                            
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
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
                            "appointment_date"=>$dt->date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"purpose_of_visit"=>$dt->motive,
                            "is_manually_added"=>$boolean_manually_added,"consultation_fees"=>$dt->consultation_fees,"clinic_id"=>$dt->clinic_id,"clinic_name"=>$dt->clinic_name,"clinic_image_url"=>$clinic_image_url,
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

                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                } 

            }

            elseif ($this->input->server('REQUEST_METHOD') === 'DELETE') {
                    $Data = json_decode(file_get_contents('php://input'));


                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                         $doctor_id = $this->uri->segment(5);
                        $this->db->where('id',$doctor_id);
                        $doc = $this->db->get('doctor')->row(0);
                        $doctor_name = $doc->username;



                        if($Data->appointment_id==NULL)
                        {
                            header("HTTP/1.1 405 Method Not Allowed");
                            exit;
                        }

                        $appointment_id = $Data->appointment_id;
                        $data['doctor_id']=$doctor_id;
                        $data['patient_id'] = $Data->patient_id;
                        $data['date'] = $Data->appointment_date;
                        $data['appointment_time'] = $Data->appointment_time;
                        $data['clinic_id'] = $Data->clinic_id;
                        $data['slot_length'] = $Data->slot_length;
                        $data['motive'] = $Data->purpose_of_visit;
                        $data['booked_by'] = $Data->booked_by;
                        $data['booker_type'] = $Data->booker_type;
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $data['created_on'] = $now->format('Y-m-d H:i:s');
                        
                        $data['appointment_status'] = 9;

                        $this->db->where('id',$appointment_id);
                         $query = $this->db->update('appointments',$data);

                        if($query)
                        {
                           $doctor_id = $this->uri->segment(5);

                         $query = $this->db->query("SELECT * from appointments WHERE doctor_id = $doctor_id and appointment_status!=9 ORDER BY date DESC,appointment_time DESC;");                        
                         
                         $result2 = array();
                         
                          foreach ($query->result() as $dt) {
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
                            $patient_name = $getUser->name;
                            $patient_image_url = $getUser->image_url;
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
                            $consultant_data = $this->db->query("SELECT * from consultant WHERE id = $dt->consultant;")->result();
                            $boolean_manually_added = strtolower($dt->is_manually_added) == '1' ? true : false;

                            $ar = array("appointment_id"=>$dt->id,"doctor_id"=>$dt->doctor_id,"patient_id"=>$dt->patient_id,"patient_name" => $patient_name,
                            "patient_gender"=>$patient_gender,"patient_age"=>$patient_age,"patient_number"=>$patient_number,"patient_image_url"=>$patient_image_url,
                            "appointment_date"=>$dt->date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"purpose_of_visit"=>$dt->motive,
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

                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    exit;
                } 

            }


            //end of function
        } 
   
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
                    
                        $doctor_id = $this->uri->segment(5);
                        $now = new DateTime();
                        $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                        $todays_date = $now->format('Y-m-d hh:mm:ss');

                         $query1 = $this->db->query("SELECT COUNT(*) AS today FROM appointments where date='$todays_date' and doctor_id = $doctor_id;");
                         foreach ($query1->result() as $data1) {
                             $today = $data1->today;
                         }

                        $query2 = $this->db->query("SELECT COUNT(*) AS last_month FROM `appointments` WHERE month(date) = month(curdate())-1 and doctor_id = $doctor_id;");
                         foreach ($query2->result() as $data2) {
                             $last_month = $data2->last_month;
                         }
                        
                        $query3 = $this->db->query("SELECT WEEK(CURRENT_DATE, 3) - WEEK(CURRENT_DATE - INTERVAL DAY(CURRENT_DATE)-1 DAY, 3) + 1 as current_week;");
                         foreach ($query3->result() as $data3) {
                             $current_week = $data3->current_week;
                         }
                          $month = $now->format('m');
                         $current_week = $current_week + (($month-1)*4);

                         $query4 = $this->db->query("SELECT COUNT(*) AS upcoming_week FROM appointments where WEEK(date) = $current_week + 1 and doctor_id = $doctor_id;");
                         foreach ($query4->result() as $data4) {
                             $upcoming_week = $data4->upcoming_week;
                         }

                         $result1 = array('today' => $today, 'upcoming_week' => $upcoming_week,'last_month' => $last_month);

                         $query5 = $this->db->query("SELECT * from (SELECT * from appointments as a1 where doctor_id = $doctor_id and date>='$todays_date'  ORDER BY date DESC LIMIT 5) a1 WHERE doctor_id = $doctor_id ORDER BY date;");

                         //$result2 = $query5->result();
                         
                         $result2 = array();
                         
                          foreach ($query5->result() as $dt) {
							  
							  //echo '<pre>'; print_r($dt); echo '</pre>';
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row();
							//echo '<pre>'; print_r($getUser); echo '</pre>';
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
							else{
								$patient_name = '';
								$patient_image_url = '';
								$patient_gender = '';
								$patient_number = '';
								$todays_year = '';
								$patient_age = '';
							}
                            $this->db->where('clinic_id',$dt->clinic_id);
                            $clinicdt = $this->db->get('clinic')->row(0);
                            $clinic_image_url = @$clinicdt->clinic_image_url;

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

                       /* foreach ($query5->result() as $dt) {
                                
                            $this->db->where('id',$dt->patient_id);
                            $getUser = $this->db->get('users')->row(0);
                            $patient_name = $getUser->name;
                            $patient_image_url = $getUser->image_url;

                            $ar = array("appointment_id"=>$dt->appointment_id,"doctor_id"=>$dt->doctor_id,"patient_id"=>$dt->patient_id,"patient_name" => $patient_name,
                            "patient_image_url"=>$patient_image_url,"appointment_date"=>$dt->appointment_date,"appointment_time"=>$dt->appointment_time,"slot_length"=>$dt->slot_length,"purpose_of_visit"=>$dt->purpose_of_visit,
                            "created_on"=>$dt->created_on,"booked_by"=>$dt->booked_by,"booker_type"=>$dt->booker_type,"appointment_status"=>$dt->appointment_status);
                            array_push($result2, $ar);
                            
                         } */

                        
                        

                        $result3 = array();

                        // $query6 = $this->db->query("SELECT * from clinic where clinic_owner_id = $doctor_id;");
                         $query = $this->db->query("SELECT * FROM doctor_schedule where doctor_id=$doctor_id;");
                     $results1 = array();
                     foreach ($query->result() as $data)
                        {
                             $this->db->where('clinic_id', $data->clinic_id);
                     $this->db->where('is_deactivated', "false");
                    $clinic1 = $this->db->get('clinic')->row(0);
                    array_push($results1, $clinic1);
                        }
                        
                    $this->db->where('clinic_owner_id', $doctor_id );
                    $this->db->where('is_deactivated', "false");
                    $results2 = $this->db->get('clinic')->result();
                    
                    $merging_data = array_merge($results1, $results2);
                    $final_list= array_unique($merging_data,SORT_REGULAR);
                         foreach ($final_list as $data6) {

                             $clinic_id = $data6->clinic_id;
                             $clinic_name = $data6->clinic_name;
                             
                             /*$this->db->where('clinic_id',$clinic_id)
                             $doc_data = $this->db->get('clinic')->row(0);
*/
                             $query7 = $this->db->query("SELECT doctor_id from doctor_schedule where clinic_id = $clinic_id AND doctor_id !=$doctor_id;");
                            foreach ($query7->result() as $data7) {

                                    $doc_id = $data7->doctor_id;
                                    $this->db->where('id',$doc_id);
                                    $doc_data = $this->db->get('doctor')->row(0);
                                    $display_name = @$doc_data->name;
                                    $user_url = @$doc_data->image;
                                    $query8 = $this->db->query("SELECT COUNT(*) AS today FROM appointments where date='$todays_date' and doctor_id = $doc_id;");
                                     foreach ($query8->result() as $data8) {
                                         $today_appointment = $data8->today;
                                     }

                                     $arr = array("doctor_id"=>$doc_id,"display_name"=>$display_name,"user_url"=>$user_url,"clinic_id"=>$clinic_id,"clinic_name"=>$clinic_name,"number_of_appointment_today"=>$today_appointment);

                                     array_push($result3, $arr);


                            }
                            $query9 = $this->db->query("SELECT * from consultant where doctor_id =$doctor_id;");
                            foreach ($query9->result() as $data9) {
                              $doc_id = $data9->id;  
                              $display_name = $data9->name;
                              $user_url = "http://dentizone.in/pms/assets/uploads/images/man.png";
                               $query10 = $this->db->query("SELECT COUNT(*) AS today FROM appointments where date='$todays_date' and doctor_id = $doc_id and consultant = $data9->id;");
                                     foreach ($query10->result() as $data10) {
                                         $today_appointment = $data10->today;
                                     }
                                     $arr_consultant = array("doctor_id"=>$doc_id,"display_name"=>$display_name,"user_url"=>$user_url,"clinic_id"=>"","clinic_name"=>"","number_of_appointment_today"=>$today_appointment);
                                     array_push($result3, $arr_consultant);
}

                         }


                         echo json_encode(array('appointment_count' => $result1, 'my_appointment' => $result2, 'team' => $result3));

                       
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
    
        
        
        
        public function forgot_password()
        {

             if ($this->input->server('REQUEST_METHOD') === 'POST') {
                    $Data = json_decode(file_get_contents('php://input'));

                      $key = $Data->key;
                     $doctor_id = -1;
                     $otp = 0000;
                     $number = "";
                     $email = "";

                     if(is_numeric($key))
                     {
                        $number = $key;
                        $this->db->where('contact',$number);
                        $doc_data1 = $this->db->get('doctor')->row(0);
                       
                         if($doc_data1!=null)
                        {
                             $email = $doc_data1->email;
                            $doctor_id = $doc_data1->id;
                        }
                     }

                     else
                     {
                        $email = $key;
                        $this->db->where('email',$email);
                        $doc_data2 = $this->db->get('doctor')->row(0);
                        if($doc_data2!=null)
                        {
                            $number = $doc_data2->contact;
                            $doctor_id = $doc_data2->id;
                        }
                     }
                    
                    
                    if($number!=null || $number!="")
                    {
                    
                     $otp = rand ( 1000 , 9999 );

                     //SEND OTP to NUMBER
                     $authKey = "144872ArhHeSNu58c7bb84";
                    //Multiple mobiles numbers separated by comma
                    $mobileNumber = $number;
                    
                    //Sender ID,While using route4 sender id should be 6 characters long.
                    $senderId = "DOCTRI";

                    //Your message to send, Add URL encoding here.
                    $mesg =  " Your otp for resetting password is " . $otp . " . " ;
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
                    
                    
                    if($email!=null || $email!="")
                    {
                    //SEND OTP to EMAIL
                    $this->load->library('email');
                    $this->load->helper('string');
                    $config['mailtype'] = 'html';
                    $config['charset'] = 'utf-8';
                    $this->load->library('email', $config);
                    $this->email->initialize($config);
                    $message =  "Your otp for resetting password is " . $otp . " . " ;

                    $this->email->from("infonits20@gmail.com", "Doctori8");
                    $this->email->to($email);
                    $this->email->subject(' Reset Password ');
                    $this->email->message($message);
                    $this->email->send();
                    }

                     echo json_encode(array('otp' =>$otp,'doctor_id' => $doctor_id));

            }
            
            else
            {
                 header("HTTP/1.1 405 Method Not Allowed");
                exit;
            }
        }
        
        
        public function reset_password()
        {
            if ($this->input->server('REQUEST_METHOD') === 'PUT') {
                    $Data = json_decode(file_get_contents('php://input'));

                    $doctor_id = $this->uri->segment(5);
                    $data['password'] = sha1($Data->new_password);

                    $this->db->where('id',$doctor_id);
                    $update = $this->db->update('doctor',$data);

                    if($update)
                    {
                        echo json_encode(array('status' =>'success'));
                    }

                    else
                    {
                         echo json_encode(array('status' =>'fail'));
                    }
                    
            }

            else
            {
                 header("HTTP/1.1 405 Method Not Allowed");
                 exit;
            }
        }


         public function change_password()
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
                    $old_password = sha1($Data->old_password);
                    $new_password = $Data->new_password;

                    $this->db->where('id',$doctor_id);
                    $docdata = $this->db->get('doctor')->row(0);
                    $old_password_db = $docdata->password;

                    if($old_password==$old_password_db)
                    {
                        $data['password'] = sha1($new_password);

                        $this->db->where('id',$doctor_id);
                        $update = $this->db->update('doctor',$data);

                        if($update)
                        {
                            echo json_encode(array('status' =>'success'));
                        }

                        else
                        {
                             echo json_encode(array('status' =>'fail'));
                        }

                    }

                    else
                    {
                        header("HTTP/1.1 401 Unauthorized");
                         echo json_encode(array('status' =>'fail'));
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

            else
            {
                 header("HTTP/1.1 405 Method Not Allowed");
                 exit;
            }
        
            
            
        }
    
    
    
    
}