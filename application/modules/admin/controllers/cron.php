<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("calendar_model");
		$this->load->model("dashboard_model");
		$this->load->model("hospital_model");
		$this->load->model("patient_model");
		$this->load->model("medical_college_model");
		$this->load->model("manufacturing_company_model");
		$this->load->model("doctor_model");
		$this->load->model("patient_model");
		$this->load->model("prescription_model");
		$this->load->model("setting_model");
		$this->load->model("notification_model");
		$this->load->model("contact_model");
		$this->load->model("to_do_list_model");
		$this->load->model("appointment_model");
		$this->load->model("hospital_model");
		$this->load->model("medical_college_model");
		$this->load->model("schedule_model");
                $this->load->model("consultant_model");
		$this->load->model("treatment_advised_model");
                $this->load->model("sms_management_model");
	}
	
	
	function index()
        {
             $all = $this->dashboard_model->get_todays_appointments_cron();
             $consultants = array();
             $numbers = array();
             $messages=array();
			 $newMessages = array();
			 //echo '<pre>all : '; print_r($all); echo '</pre>';
			 $cnt = 1000;
             foreach($all as $single){
				 
                     $consultant= $this->consultant_model->get_consultant_by_id($single->consultant);
                     $date = strtotime($single->date);
                     $date = date("h:i a",$date);
					 $time = strtotime($single->date);
                     $patient = $single->patient_id;
                     $doctor_id = $consultant->doctor_id;
                     
                     $sms_setting = $this->sms_management_model->get_patient_by_doctor($doctor_id);
                     $val = $sms_setting[0]['status'];
					 
					 //echo '<br>Doctor : '.$doctor_id;
					 //echo ' => Val : '.$val;
                     
                     if($val=='0') 
                       continue;

                      $admin = $this->sms_management_model->get_sms_count($doctor_id);
					  
					  //echo ' => sms_limit : '.$admin->sms_limit;
                      if($admin->sms_limit==0)
					  {
                        continue;//break;
					  }
         
                      $patient = $this->patient_model->get_cont($patient);
                      $message = $single->title." at ".$date.". ";
                      $consultants[$single->consultant]=1;
                      $numbers[$single->consultant] = $consultant->mobile;
					  
                      if(isset($messages[$single->consultant]))
					  {
                      	$messages[$single->consultant].="\n".$message;
						$newMessages[$single->consultant][$time.$cnt] = $message;
					  }
                      else
					  {
                      	$messages[$single->consultant]=$message;
						$newMessages[$single->consultant][$time.$cnt] = $message;
					  }
					  $cnt++;
					  
                      if($sms_setting[0]['lang']=='english')
                      $patient_message = "You have an appointment scheduled today with ".$consultant->name." at ".$date;
                      else if ($sms_setting[0]['lang']=='hindi')
                      $patient_message = "आपके इलाज के लिए ".$consultant->name." के साथ ".$date." पर आपकी नियुक्ति की पुष्टि की गयी है । धन्यवाद";
                      else if ($sms_setting[0]['lang']=='bengali')
                      $patient_message = "আপনার চিকিৎসা এর জন্য ".$consultant->name." আপানার সঙ্গে ".$date." সময় দেখা করবে | ধন্যবাদ";
                      else if ($sms_setting[0]['lang']=='telugu')
                      $patient_message = "You have an appointment scheduled today with ".$consultant->name." at ".$date;
                      else if ($sms_setting[0]['lang']=='marathi')
                      $patient_message = "You have an appointment scheduled today with ".$consultant->name." at ".$date;
                       $authKey = "144872ArhHeSNu58c7bb84";
							$mobileNumber = $patient[0]->contact;
							//$mobileNumber = 9860130198;
							$senderId = "DCTRIP";
							$message = mb_convert_encoding($patient_message, "UTF-8");
							$route = 4;
							
							/*
							$postData = array(
								'authkey' => $authKey,
								'mobiles' => $mobileNumber,
								'message' => $message,
								'sender' => $senderId,
								'route' => $route,
                                                                'unicode' => '1'
							);
							
							$url="http://sms.globehost.in/api/sendhttp.php?";
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
                                                        $this->sms_management_model->update_sms_limit($doctor_id);
                                                        $this->sms_management_model->create_sms_history($doctor_id, $patient[0]->id, $consultant->id, 'patient');
                                                        echo $message."\n";
							if(curl_errno($ch))
							{
								echo 'error:' . curl_error($ch);
							}
							curl_close($ch);*/
							
        
							#Send sms again - starts
							$newNumber = explode('/',$mobileNumber);
							$mobileNumber = $newNumber[0];
							$encodedMessage = urlencode($message);
							$api_url = "http://sms.globehost.in/sendhttp.php?authkey=".$authKey."&mobiles=".$mobileNumber."&message=".$encodedMessage."&sender=".$senderId."&route=".$route."&unicode=1";
							//echo $api_url;die;
							//Submit to server
							$return = array();							
							//$response = file_get_contents($api_url);
							$arrContextOptions=array(
								  "ssl"=>array(
										"verify_peer"=>false,
										"verify_peer_name"=>false,
									),
								);  
							$response = file_get_contents($api_url, false, stream_context_create($arrContextOptions));
							
							/*echo '<br>Message : '.$message;
							echo '<br>mobileNumber : '.$mobileNumber;
							echo '<br>----------------<br>';*/
                            //echo '<br>$response : '.$response; 
							#Send sms again - ends                    
             }
			 /*echo '<pre>consultants : '; print_r($consultants); echo '</pre>';
			 echo '<pre>numbers : '; print_r($numbers); echo '</pre>';
			 echo '<pre>messages : '; print_r($messages); echo '</pre>';
			 echo '<pre>newMessages : '; print_r($newMessages); echo '</pre>';*/
			 
			 
             sleep(15);
             foreach($consultants as $new=>$value){
                  $consultant = $this->consultant_model->get_consultant_by_id($new);
                  $doctor_id = $consultant->doctor_id;
                  $sms_setting = $this->sms_management_model->get_doctor_by_doctor($doctor_id);
                  $val = $sms_setting[0]['status'];
                  if($val=='0') 
                    continue;
                  $admin = $this->sms_management_model->get_sms_count($doctor_id);
                  if($admin->sms_limit==0)
				  {
                     continue;//break;
				  }
				  
				  ksort($newMessages[$new]);
                  //echo '<pre>updated MSG : '; print_r($newMessages); echo '</pre>';
				  $strMsg = implode("\n", $newMessages[$new]);

				  
                  //$final = "Hello Doctor!\n These are your appointments for today! \n".$messages[$new];
				  $final = "Hello Doctor!\n These are your appointments for today! \n".$strMsg;
				  
                  $mobile = $numbers[$new];
                  $authKey = "144872ArhHeSNu58c7bb84";
							$mobileNumber = $mobile;							
							//$mobileNumber = 9860130198;
							
							$senderId = "DCTRIP";
							$message = urlencode($final);
							$route = 4;
							/*$postData = array(
								'authkey' => $authKey,
								'mobiles' => $mobileNumber,
								'message' => $message,
								'sender' => $senderId,
								'route' => $route,
                                                                'unicode' => '1'
							);
							
						$url="http://sms.globehost.in/api/sendhttp.php?";
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
                                                        $this->sms_management_model->update_sms_limit($doctor_id);
                                                        $this->sms_management_model->create_sms_history($doctor_id, $doctor_id, $consultant->id, 'doctor');
                                                        echo $final."\n";
							if(curl_errno($ch))
							{
								echo 'error:' . curl_error($ch);
							}
							curl_close($ch);*/
							
							#Send sms again - starts
							$newNumber = explode('/',$mobileNumber);
							$mobileNumber = $newNumber[0];
							//$mobileNumber = '9860130198';
							
							$encodedMessage = urlencode($message);
							$api_url = "http://sms.globehost.in/sendhttp.php?authkey=".$authKey."&mobiles=".$mobileNumber."&message=".$encodedMessage."&sender=".$senderId."&route=".$route."&unicode=1";
							//echo $api_url;die;
							//Submit to server
							$return = array();							
							//$response = file_get_contents($api_url);
							$arrContextOptions=array(
								  "ssl"=>array(
										"verify_peer"=>false,
										"verify_peer_name"=>false,
									),
								);  
							$response = file_get_contents($api_url, false, stream_context_create($arrContextOptions));
							
							/*echo '<br>Message : '.$message;
							echo '<br>mobileNumber : '.$mobileNumber;
							echo '<br>----------------<br>';*/
                            //echo '<br>$response : '.$response; 
							#Send sms again - ends             
                                                        //sleep(15);
             }
			 
        }

}