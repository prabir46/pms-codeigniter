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

     
     function signup()
    {
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            
            $Data = json_decode(file_get_contents('php://input'));

            $data['username']=$Data->username;
            $data['password']=sha1($Data->password);
            $data['email_id']=$Data->email;
            $data['phone_number']=$Data->contact;
            $data['name']=$Data->full_name;
            $this->db->where('username',$data['username']);
            $result=$this->db->get('users');
            $this->db->where('email_id',$data['email_id']);
            $result1=$this->db->get('users');
            $this->db->where('phone_number',$data['phone_number']);
            $result2=$this->db->get('users');
            if($result->num_rows()==0 && $result1->num_rows()==0 && $result2->num_rows()==0){
             $authKey = "144872ArhHeSNu58c7bb84";

                    //Multiple mobiles numbers separated by comma
                    $mobileNumber = $Data->contact;


                    //Sender ID,While using route4 sender id should be 6 characters long.
                    $senderId = "DOCTRI";

                    //Your message to send, Add URL encoding here.
                    $mesg =  " Your otp for verification is " . $Data->otp . " . " ;
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

                echo json_encode(array('status'=>"success"));

           }
            else
            {
               if($result->num_rows())
              {$msg="Username already exist.";}
              else if($result1->num_rows())
             { $msg="Email already exist."; }
            else
            { $msg="Contact already exist."; }

             echo json_encode(array('message'=>$msg));
            }
            
        }
        else{
            echo json_encode(array('status'=>'fail'));}
    }
    
    function final_signup()
    {
      if ($this->input->server('REQUEST_METHOD') === 'POST') {
       $Data = json_decode(file_get_contents('php://input'));

            $data['username']=$Data->username;
            $data['password']=sha1($Data->password);
            $data['email_id']=$Data->email;
            $data['phone_number']=$Data->contact;
            $data['name']=$Data->full_name;
            
            $this->db->where('phone_number',$data['phone_number']);
            $result2=$this->db->get('users')->row(0);
            
            if($result2)
            {
                $this->db->where('phone_number',$data['phone_number']);
                $this->db->update('users',$data);
                echo json_encode(array('message'=>'Updated Successful'));
            }
            
            else
            {
                 $this->db->insert('users',$data);
                 echo json_encode(array('message'=>'Registration Successful'));
            }
            
          
      }
               else
            {
             echo json_encode(array('status'=>'fail'));
            }
               
    }
    
    function login()
    {
        $this->load->helper('form');

        $username	= $this->input->post('username');
        $password	= sha1($this->input->post('password'));
        $device_name  = $this->input->post('device_name');
        $imei_number = $this->input->post('imei_number');

        $this->db->where('username', $username);
        $this->db->where('password', $password);

        $result = $this->db->get('users');
        if ($result->num_rows() == 1)
        {

            $id=$result->row(0)->id;
            $this->db->where('id',$id);
            $user=$this->db->get('users')->result();

            $token['username'] = $this->input->post('username');
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5;
            $tokenId = JWT::encode($token, "my Secret key!"); 
         
            $data['username']=$username;
            $data['access_token']=$tokenId;
            $data['status']='1';
            $data['device']= $device_name;
            $data['IMEI_Number']=$imei_number;
            $data['user_id']=$id;
            $now = new DateTime();
            $now->setTimezone(new DateTimezone('Asia/Kolkata'));
           
            $data['login_time']= $now->format('Y-m-d H:i:s');
            $this->db->insert('login',$data);

            
            $this->db->where("IMEI_Number",$imei_number);
            $result1 = $this->db->get("firebase_data");
             if ($result1->num_rows() != 1)
                {

                $data1['device_type']= $device_name;
                $data1['IMEI_Number']=$imei_number;
                $data1['user_id']=$id;
                $data1['is_login']=1;
                $data1['timestamp']= $now->format('Y-m-d H:i:s');
                $this->db->insert('firebase_data',$data1);

                }

            $ashu=array('status'=>"success",'user'=>$user);
            echo json_encode($ashu);
        }
        else
        {
            header("HTTP/1.1 404 NotFound");
            echo json_encode(array('status'=>'fail'));
          //  $this->response(NULL, 404);
        }


    }
    
  function firebase_data()
        {
              if ($this->input->server('REQUEST_METHOD') === "POST") {
                    $Data = json_decode(file_get_contents('php://input'));

                    $user_id = $this->uri->segment(5);
                    
                    
                    $imei_number=$Data->imei_number;
                    $data['device_type']=$Data->device_type;
                    $data['firebase_token']=$Data->firebase_token;

                    $token = $this->input->get_request_header('Authorization',TRUE);

                    $this->db->where('access_token', $token);
                    $result = $this->db->get('login');

                 if ($result->num_rows() == 1)
                {
                    if($result->row(0)->status==1)
                    {
                        $this->db->where('user_id',$user_id);
                        $this->db->where('IMEI_Number',$imei_number);
                        $res = $this->db->update('firebase_data',$data);

                        if($res)
                           {
                              echo json_encode(array('status'=>'success'));
                           } 
                        else
                        {
                            echo json_encode(array('status'=>'fail'));
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
                        $this->db->where('phone_number',$number);
                        $doc_data1 = $this->db->get('users')->row(0);
                       
                         if($doc_data1!=null)
                        {
                             $email = $doc_data1->email_id;
                            $user_id = $doc_data1->id;
                        }
                     }

                     else
                     {
                        $email = $key;
                        $this->db->where('email_id',$email);
                        $doc_data2 = $this->db->get('users')->row(0);
                        if($doc_data2!=null)
                        {
                            $number = $doc_data2->phone_number;
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

                    $user_id = $this->uri->segment(5);
                    $data['password'] = sha1($Data->new_password);

                    $this->db->where('id',$user_id);
                    $update = $this->db->update('users',$data);

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

                    $user_id = $this->uri->segment(5);
                    $old_password = sha1($Data->old_password);
                    $new_password = $Data->new_password;

                    $this->db->where('id',$user_id);
                    $docdata = $this->db->get('users')->row(0);
                    $old_password_db = $docdata->password;

                    if($old_password==$old_password_db)
                    {
                        $data['password'] = sha1($new_password);

                        $this->db->where('id',$user_id);
                        $update = $this->db->update('users',$data);

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
        
         function offers()
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
                            $this->db->select('offer_id,offer_title,offer_subtitle,offer_description,offer_start_date,offer_end_date,offer_base_location_latitude,offer_base_location_longitude,offer_image_url,offer_clinic_id,offer_type');
                            $arr=$this->db->get('offers')->result();
                            $result = array("offers"=>$arr);
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

            else
            {
                header("HTTP/1.1 503 Method not allowed");
                    exit;
            }
    }

   
    
    
}