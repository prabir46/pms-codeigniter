<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class datafeed extends MX_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth->check_session();
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
        $this->load->model("schedule_model");
        $this->load->model("sms_management_model");
    }

    function index() {
        $method = $_GET["method"];
        $admin = $this->session->userdata('admin');
        $type_id = $this->input->post('schedule_category');

        // switch start
        switch ($method) {
            case "add":
                $ret = $this->addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
                break;
            case "list":

                $ret = $this->listCalendar($_POST["showdate"], $_POST["viewtype"]);
                break;
            case "update":
                $ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
                @$type_id = $_POST['type_id'];
                @$id = $_POST["calendarId"];
                $st = $_POST["CalendarStartTime"];
                $et = $_POST["CalendarEndTime"];

                $next = 1;
                if ($id && $next == 1) {

                    if ($type_id == 1) {
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $this->to_do_list_model->update($save, $id);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "To Do Succefully Updated",
                        );
                    }
                    if ($type_id == 2) {
                        //echo '<pre>'; print_r($_POST);die;
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $this->appointment_model->update($save, $id);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Appointment Successfully Updated",
                        );
                    }

                    if ($type_id == 5) {
                        $ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
                    }
                }

                break;
            case "remove":
                $type_id = $_POST['type_id'];
                $id = $_POST['id'];
                if ($type_id == 1) {
                    $this->to_do_list_model->delete($id);
                }
                if ($type_id == 2) {
                    $this->appointment_model->delete($id);
                }
                if ($type_id == 3) {
                    $this->schedule_model->delete_week_schedule($id);
                }
                if ($type_id == 4) {
                    $this->schedule_model->delete_week_schedule($id);
                }
                if ($type_id == 5) {
                    $this->removeCalendar($_POST["id"]);
                }
                $ret = array(
                    'IsSuccess' => true,
                    'Msg' => "Event Succefully Deleted",
                );
                break;

            case "add_form":
                $admin = $this->session->userdata('admin');
                $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
                $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];

                //echo '<pre>'; print_r($_POST);die;
                $checked = $this->calendar_model->check_tables($st, $et);
                if (!empty($checked)) {

                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => $checked,
                    );
                    $next = 0;
                } else {
                    $next = 1;
                }
                $type_id = $this->input->post('schedule_category');

                if ($type_id == 1 && $next == 1) {
                    $save['title'] = $this->input->post('Subject');
                    $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                    $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                    $save['doctor_id'] = $admin['id'];
                    $save['Color'] = $this->input->post('colorvalue');
                    $this->to_do_list_model->save($save);

                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => "To Do Succefully Created",
                    );
                }
                if ($type_id == 2 && $next == 1) {
                    $admin = $this->session->userdata('admin');
                    $docid = '';
                    if ($admin['user_role'] == 1) {
                        $docid = $admin['doctor_id'];
                    }
                    if ($admin['user_role'] == 3) {
                        $docid = $admin['doctor_id'];
                    }
                    $save['title'] = $this->input->post('Subject');
                    $save['whom'] = $this->input->post('whom');
                    $save['patient_id'] = $this->input->post('patient_id');
                    $save['contact_id'] = $this->input->post('contact_id');
                    $save['other'] = $this->input->post('other');
                    $save['motive'] = $this->input->post('motive');
                    $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                    $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                    $save['consultant'] = $this->input->post('consultant');
                    $save['is_paid'] = $this->input->post('is_paid');
                    $save['Color'] = $this->input->post('colorvalue');
                    $save['status'] = 1;
                    $save['doctor_id'] = $docid;


                    $ptnt = $this->input->post('patient_id');
                    $data_patient = $this->patient_model->get_cont($ptnt);
                    $gender = '';
                    $patient_name = '';
                    foreach ($data_patient as $newx) {
                        $gender = $newx->gender;
                        $patient_name = $newx->name;
                    }
                    $mr = '';
                    if ($gender == 'Male') {
                        $mr = 'Mr';
                    } else {
                        $mr = 'Miss';
                    }
                    $ad = '';
                    if ($admin['user_role'] == 1) {
                        $ad = $admin['doctor_id'];
                    }
                    if ($admin['user_role'] == 3) {
                        $ad = $admin['doctor_id'];
                    }
                    $admin = '';
                    $admin_names = $this->patient_model->get_cont($ad);
                    foreach ($admin_names as $newadmin) {
                        $admin = $newadmin->name;
                    }
                    $cntc = $this->patient_model->get_cont($ptnt);
                    $contact = '';
                    foreach ($cntc as $newzz) {
                        $contact = $newzz->contact;
                    }
                    $dtate = date('d/m/Y h:i:s a', strtotime($st));
                    $sms = $this->input->post('is_paid');
                    if ($sms == 1) {
                        /*$authKey = "144872ArhHeSNu58c7bb84";
                        $mobileNumber = $contact;
                        $senderId = "DOCTRI";
                        $mesg = "Dear " . $mr . " " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . " Thanks";
                        $message = urlencode($mesg);
                        $route = 4;
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $mobileNumber,
                            'message' => $message,
                            'sender' => $senderId,
                            'route' => $route
                        );
                        $url = "https://sms.globehost.in/api/sendhttp.php?";
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
                        curl_close($ch);*/
						
						#Send sms again - starts
						$authKey = "144872ArhHeSNu58c7bb84";
						$senderId = "DCTRIP";
						$route = 4;
						$mobileNumber = $contact;
						//$mobileNumber = 9075627173;
						$mesg = "Dear " . $mr . " " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . " Thanks";
						$encodedMessage = urlencode($mesg);
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
						//echo '<br>$response : '.$response; 
						#Send sms again - ends  
                    }



                    $this->appointment_model->save($save);
                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => "Appointment Successfully Created 1",
                    );
                }
                if ($type_id == 3 && $next == 1) {   // Hospital
                    $save['day'] = date('N', strtotime($st));
                    $save['timing_from'] = date("H:i:s", strtotime($time1));
                    $save['timing_to'] = date("H:i:s", strtotime($time2));
                    $save['work'] = $this->input->post('Subject');
                    
                    $save['hospital'] = $this->input->post('hospital_id');
                    $save['type'] = 1;
                    $save['doctor_id'] = $admin['id'];
                    //echo '<pre>'; print_r($save);die;
                    $this->schedule_model->save_schedule($save);
                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => "Hospital Schedule Succefully Updated",
                    );
                }
                if ($type_id == 4 && $next == 1) {   // Medical COllege
                    $save['day'] = date('N', strtotime($st));
                    $save['timing_from'] = date("H:i:s", strtotime($time1));
                    $save['timing_to'] = date("H:i:s", strtotime($time2));
                    $save['work'] = $this->input->post('Subject');
                    
                    $save['hospital'] = $this->input->post('college_id');
                    $save['type'] = 2;
                    $save['doctor_id'] = $admin['id'];
                    $this->schedule_model->save_schedule($save);
                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => "Hospital Schedule Succefully Updated",
                    );
                }
                if ($type_id == 5 && $next == 1) {

                    $save['Subject'] = $this->input->post('Subject');
                    $save['IsAllDayEvent'] = isset($_POST["IsAllDayEvent"]) ? 1 : 0;
                    $save['Description'] = $this->input->post('Description');
                    $save['Location'] = $this->input->post('Location');
                    $save['Color'] = $this->input->post('colorvalue');
                    
                    $save['StartTime'] = date("Y-m-d H:i:s", strtotime($st));
                    $save['EndTime'] = date("Y-m-d H:i:s", strtotime($et));
                    $save['doctor_id'] = $admin['id'];
                    $this->calendar_model->save($save);
                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => "Schedule Succefully Created",
                    );
                }
                break;
            case "adddetails":
        
                $type_id = $this->input->post('schedule_category');

                @$id = $_GET["id"];
                @$add_follow = $_GET["add_follow"];
                $time1 = $_POST["stparttime"];
               
                $end_time = explode(":", $time1);
                $end_minute = $end_time[1] + ($_POST["slot"] % 60);
                $end_hour = $end_time[0] + floor(($_POST["slot"] / 60));
                if ($end_minute >= 60) {
                    $end_minute-=60;
                    $end_hour+=1;
                }

                $end_time = $end_hour . ":" . $end_minute;

                $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
                $et = $_POST['stpartdate'] . " " . $end_time;
                $checked = $this->calendar_model->check_tables($st, $et);
                if (!empty($checked)) {

                    $ret = array(
                        'IsSuccess' => true,
                        'Msg' => $checked,
                    );
                    $next = 0;
                } else {
                    $next = 1;
                }

               
                if ($id && $next == 1) {

                    if ($type_id == 1) {
                        $save['title'] = $this->input->post('Subject');
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['doctor_id'] = $admin['doctor_id'];
                        $save['Color'] = $this->input->post('colorvalue');
                       
                        $this->to_do_list_model->update($save, $_GET["id"]);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "To Do Succefully Updated",
                        );
                    }
                    if ($type_id == 2) {
                        $admin = $this->session->userdata('admin');
                        $docid = '';
                        if ($admin['user_role'] == 1) {
                            $docid = $admin['doctor_id'];
                        }
                        if ($admin['user_role'] == 3) {
                            $docid = $admin['doctor_id'];
                        }
                        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
                        //echo '<pre>'; print_r($_POST);die;
                        $save['title'] = $this->input->post('Subject');
                        $save['whom'] = $this->input->post('whom');
                        $save['patient_id'] = $this->input->post('patient_id');
                        $save['contact_id'] = $this->input->post('contact_id');
                        $save['consultant'] = $this->input->post('consultant');
                        $save['other'] = $this->input->post('other');
                        $save['Color'] = $this->input->post('colorvalue');
                        $save['motive'] = $this->input->post('motive');
                        
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['is_paid'] = $this->input->post('is_paid');
                        $save['doctor_id'] = $docid;
                        $ptnt = $this->input->post('patient_id');
                        $data_patient = $this->patient_model->get_cont($ptnt);
                        $gender = '';
                        $patient_name = '';
                        foreach ($data_patient as $newx) {
                            $gender = $newx->gender;
                            $patient_name = $newx->name;
                        }
                        $mr = '';
                        if ($gender == 'Male') {
                            $mr = 'Mr';
                        } else {
                            $mr = 'Miss';
                        }
                        $ad = '';
                        if ($admin['user_role'] == 1) {
                            $ad = $admin['doctor_id'];
                        }
                        if ($admin['user_role'] == 3) {
                            $ad = $admin['doctor_id'];
                        }
                        $admin = '';
                        $admin_names = $this->patient_model->get_cont($ad);
                        foreach ($admin_names as $newadmin) {
                            $admin = $newadmin->name;
                        }
                        $cntc = $this->patient_model->get_cont($ptnt);
                        $contact = '';
                        foreach ($cntc as $newzz) {
                            $contact = $newzz->contact;
                        }
                        $dtate = date('d/m/Y h:i:s a', strtotime($st));
                        $sms = $this->input->post('is_paid');
						//echo '<br>SMS : '.$sms;
                        $sms_setting = $this->sms_management_model->get_instant_by_doctor($ad);
                        $sms_count = $this->sms_management_model->get_sms_count($ad);
                        $sms_count = $sms_count->sms_limit;
                        //echo '<br>SMS COUNT : ';
						var_dump($sms_count);
                        $val = $sms_setting[0]['status'];
						
                        if ($sms_setting[0]['lang'] == 'english')
                            $patient_message = "Dear " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . " Thanks";
                        else if ($sms_setting[0]['lang'] == 'hindi')
                            $patient_message = "प्रिय " . $patient_name . ", " . $admin . " के साथ आपकी " . $dtate . " की नियुक्ति की पुष्टि की गयी है । धन्यवाद";
                        else if ($sms_setting[0]['lang'] == 'bengali')
                            $patient_message = "প্রিয় " . $patient_name . ", " . $admin . " এ আপনার চিকিৎসা এর জন্য " . $dtate . " এর সময় দেয়া হয়েছে  | ধন্যবাদ";
                        else if ($sms_setting[0]['lang'] == 'telugu')
                            $patient_message = "";
                        else if ($sms_setting[0]['lang'] == 'marathi')
                            $patient_message = "";
						
						//echo '<br>SMS : '.$sms;
						//echo '<br>val : '.$val;
						//echo '<br>sms_count : '.$sms_count;
                        if ($sms == 1 && $val == '1' && $sms_count!=0) {
                            /*$authKey = "144872ArhHeSNu58c7bb84";
                            $mobileNumber = $contact;
                            $senderId = "DOCTRI";
                            $message = mb_convert_encoding($patient_message, "UTF-8");
                            $route = 4;
                            $postData = array(
                                'authkey' => $authKey,
                                'mobiles' => $mobileNumber,
                                'message' => $message,
                                'sender' => $senderId,
                                'route' => $route,
                                'unicode' => '1'
                            );
                            $url = "https://sms.globehost.in/api/sendhttp.php?";
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
                            $this->sms_management_model->update_sms_limit($ad);
                            if (curl_errno($ch)) {
                                echo 'error:' . curl_error($ch);
                            }
                            curl_close($ch);*/
							
							#Send sms again - starts
							$authKey = "144872ArhHeSNu58c7bb84";
							$senderId = "DCTRIP";
							$route = 4;
							$mobileNumber = $contact;
							//$mobileNumber = 9075627173;
							$encodedMessage = urlencode($patient_message);
							//$message = mb_convert_encoding($patient_message, "UTF-8");
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
                        $this->appointment_model->update($save, $_GET["id"]);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Appointment Succefully Updated",
                        );
                    }
                    if ($type_id == 2 && $add_follow == 'add_follow_up') {
                        $admin = $this->session->userdata('admin');
                        $docid = '';
                        if ($admin['user_role'] == 1) {
                            $docid = $admin['doctor_id'];
                        }
                        if ($admin['user_role'] == 3) {
                            $docid = $admin['doctor_id'];
                        }
                        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
                        //echo '<pre>'; print_r($_POST);die;
                        $save['title'] = $this->input->post('Subject');
                        $save['whom'] = $this->input->post('whom');
                        $save['patient_id'] = $this->input->post('patient_id');
                        $save['contact_id'] = $this->input->post('contact_id');
                        $save['consultant'] = $this->input->post('consultant');
                        $save['other'] = $this->input->post('other');
                        $save['Color'] = $this->input->post('colorvalue');
                        $save['motive'] = $this->input->post('motive');
                       
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['is_paid'] = $this->input->post('is_paid');
                        $save['doctor_id'] = $docid;
                        $ptnt = $this->input->post('patient_id');
                        $data_patient = $this->patient_model->get_cont($ptnt);
                        $gender = '';
                        $patient_name = '';
                        foreach ($data_patient as $newx) {
                            $gender = $newx->gender;
                            $patient_name = $newx->name;
                        }
                        $mr = '';
                        if ($gender == 'Male') {
                            $mr = 'Mr';
                        } else {
                            $mr = 'Miss';
                        }
                        $ad = '';
                        if ($admin['user_role'] == 1) {
                            $ad = $admin['doctor_id'];
                        }
                        if ($admin['user_role'] == 3) {
                            $ad = $admin['doctor_id'];
                        }
                        $admin = '';
                        $admin_names = $this->patient_model->get_cont($ad);
                        foreach ($admin_names as $newadmin) {
                            $admin = $newadmin->name;
                        }
                        $cntc = $this->patient_model->get_cont($ptnt);
                        $contact = '';
                        foreach ($cntc as $newzz) {
                            $contact = $newzz->contact;
                        }
                        $dtate = date('d/m/Y h:i:s a', strtotime($st));
                        $sms = $this->input->post('is_paid');
                        $sms_setting = $this->sms_management_model->get_instant_by_doctor($ad);
                        $val = $sms_setting[0]['status'];
                        if ($sms_setting[0]['lang'] == 'english')
                            $patient_message = "Dear " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . " Thanks";
                        else if ($sms_setting[0]['lang'] == 'hindi')
                            $patient_message = "प्रिय " . $patient_name . ", " . $admin . " के साथ आपकी " . $dtate . " की नियुक्ति की पुष्टि की गयी है । धन्यवाद";
                        else if ($sms_setting[0]['lang'] == 'bengali')
                            $patient_message = "প্রিয় " . $patient_name . ", " . $admin . " এ আপনার চিকিৎসা এর জন্য " . $dtate . " এর সময় দেয়া হয়েছে  | ধন্যবাদ";
                        else if ($sms_setting[0]['lang'] == 'telugu')
                            $patient_message = "";
                        else if ($sms_setting[0]['lang'] == 'marathi')
                            $patient_message = "";
                        if ($sms == 1 && $val == '1') {
                            $authKey = "144872ArhHeSNu58c7bb84";
                            $mobileNumber = $contact;
                            $senderId = "DOCTRI";
                            $message = mb_convert_encoding($patient_message, "UTF-8");
                            $route = 4;
                            $postData = array(
                                'authkey' => $authKey,
                                'mobiles' => $mobileNumber,
                                'message' => $message,
                                'sender' => $senderId,
                                'route' => $route,
                                'unicode' => '1'
                            );
                            $url = "https://sms.globehost.in/api/sendhttp.php?";
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
                        $this->appointment_model->save($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Appointment Succefully Add Follow Up",
                        );
                    }

                    if ($type_id == 3) {   // Hospital
                        $save['day'] = date('N', strtotime($st));
                        $save['timing_from'] = date("H:i:s", strtotime($time1));
                        $save['timing_to'] = date("H:i:s", strtotime($time2));
                        $save['work'] = $this->input->post('Subject');

                        $save['hospital'] = $this->input->post('hospital_id');
                        $save['type'] = 1;
                        $save['doctor_id'] = $admin['id'];
                        //echo '<pre>'; print_r($save);die;
                        $this->schedule_model->save_schedule($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Hospital Schedule Succefully Updated",
                        );
                    }
                    if ($type_id == 4) {   // Medical COllege
                        $save['day'] = date('N', strtotime($st));
                        $save['timing_from'] = date("H:i:s", strtotime($time1));
                        $save['timing_to'] = date("H:i:s", strtotime($time2));
                        $save['work'] = $this->input->post('Subject');

                        $save['hospital'] = $this->input->post('college_id');
                        $save['type'] = 2;
                        $save['doctor_id'] = $admin['id'];
                        $this->schedule_model->save_schedule($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Hospital Schedule Succefully Updated",
                        );
                    }
                    if ($type_id == 5) {
                        $ret = $this->updateDetailedCalendar($id, $st, $et, $_POST["Subject"], @$_POST["IsAllDayEvent"] ? 1 : 0, @$_POST["Description"], @$_POST["Location"], $_POST["colorvalue"], @$_POST["timezone"]);
                    }
                }
                if (empty($id) && $next == 1) {   // else ID not found in GET method
                    if ($type_id == 1) {
                        $save['title'] = $this->input->post('Subject');
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['doctor_id'] = $admin['id'];
                        
                        $save['Color'] = $this->input->post('colorvalue');
                        $this->to_do_list_model->save($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "To Do Succefully Created",
                        );
                    }

                    if ($type_id == 2) {
                        $admin = $this->session->userdata('admin');
						$adminSession = $this->session->userdata('admin');
						//echo '<pre>admin : '; print_r($admin); echo '</pre>';
                        //$docid = '';
                        $booked_by = $admin['id'];
                       // if ($admin['user_role'] == 1) {
                            $docid = $admin['doctor_id'];
                      //  }
                      // if ($admin['user_role'] == 3) {
                       //     $docid = $admin['doctor_id'];
                       // }
                        $save['title'] = $this->input->post('Subject');
                        $save['whom'] = $this->input->post('whom');
                        $save['patient_id'] = $this->input->post('patient_id');
                        $save['contact_id'] = $this->input->post('contact_id');
                        $cl_id = $this->input->post('clinic_id');
                        $save['clinic_id'] = $cl_id;
                        $clinics =  $this->doctor_model->get_clinic_by_doctor();
                        foreach ($clinics as $new) {
                             if($cl_id ==$new->clinic_id)
                             { 
                                $save['clinic_name'] = $new->clinic_name;
                             }
                        }
                        
                        $save['other'] = $this->input->post('other');
                        $save['motive'] = $this->input->post('motive');
                        $t = $this->input->post('slot');
                        $h = floor($t/60) ? floor($t/60) .' hr' : '';
                           $m = $t%60 ? $t%60 .' mins' : '';
                            $val_slot =  $h && $m ? $h.' '.$m : $h.$m;
                        $save['slot_length'] = $val_slot;
                        $date_val = date_create(date("Y-m-d H:i:s", strtotime($st)));
                        $save['appointment_time'] = date_format($date_val, 'g:i A');
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['is_paid'] = $this->input->post('is_paid');
                        $save['consultation_fees'] = $this->input->post('consultation_charge');
                        $save['status'] = 1;
                        $save['appointment_status'] = 2;
                        $save['is_manually_added'] = 1;
                        $save['Color'] = $this->input->post('colorvalue');
                        $save['doctor_id'] = $docid;
                        $save['booked_by'] = $booked_by;
                        $save['booker_type'] = 'DOCTOR';
                        $consultant = $this->input->post('consultant');
                        $save['consultant'] = $this->input->post('consultant');

                        $ptnt = $this->input->post('patient_id');
                        $data_patient = $this->patient_model->get_cont($ptnt);
                        $gender = '';
                        $patient_name = '';
                        foreach ($data_patient as $newx) {
                            $gender = $newx->gender;
                            $patient_name = $newx->name;
                        }
                        $mr = '';
                        if ($gender == 'Male') {
                            $mr = 'Mr';
                        } else {
                            $mr = 'Miss';
                        }
                        $ad = '';
                        if ($admin['user_role'] == 1) {
                            $ad = $admin['doctor_id'];
                        }
                        if ($admin['user_role'] == 3) {
                            $ad = $admin['doctor_id'];
                        }
                        $admin = '';
                        $admin_names = $this->patient_model->get_cont($ad);
                        foreach ($admin_names as $newadmin) {
                            $admin = $newadmin->name;
                        }
                        $cntc = $this->patient_model->get_cont($ptnt);
                        $contact = '';
                        foreach ($cntc as $newzz) {
                            $contact = $newzz->contact;
                        }

                        $dtate = date('d/m/Y h:i:s a', strtotime($st));
                        $sms = $this->input->post('is_paid');
                        $sms_lang = $this->input->post('lang');
                        $sms_setting = $this->sms_management_model->get_instant_by_doctor($adminSession['id']);//$ad
						//echo '<pre>sms_setting : '; print_r($sms_setting); echo '</pre>';
                        $sms_count = $this->sms_management_model->get_sms_count($adminSession['id']);//$ad
                        $sms_count = @$sms_count->sms_limit;
                        $val = @$sms_setting[0]['status'];
                        if ($sms_lang == 'english')
                            $patient_message = "Dear " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . " Thanks";
                        else if ($sms_lang == 'hindi')
                            $patient_message = "प्रिय " . $patient_name . ", " . $admin . " के साथ आपकी " . $dtate . " की नियुक्ति की पुष्टि की गयी है । धन्यवाद";
                        else if ($sms_lang == 'bengali')
                            $patient_message = "প্রিয় " . $patient_name . ", " . $admin . " এ আপনার চিকিৎসা এর জন্য " . $dtate . " এর সময় দেয়া হয়েছে  | ধন্যবাদ";
                        else if ($sms_lang == 'telugu')
                            $patient_message = "";
                        else if ($sms_lang == 'marathi')
                            $patient_message = "";
						
						//echo '<br>$sms : '.$sms;
						//echo '<br>$val : '.$val;
						//echo '<br>$sms_count : '.$sms_count;
						
                        //if ($sms == 1 && $val == '1' && $sms_count!=0)
						if ($sms == 1 && $val == '1' && $sms_count!=0) {
                            /*$authKey = "144872ArhHeSNu58c7bb84";
                            $mobileNumber = $contact;
                            $senderId = "DOCTRI";
                            $message = mb_convert_encoding($patient_message."\n\nNow digitise your medical records and manage your health information on-the-go with the Doctori8 Patient App! Download now! https://bit.ly/2IoxEtl", "UTF-8");
                            $route = 4;
                            $postData = array(
                                'authkey' => $authKey,
                                'mobiles' => $mobileNumber,
                                'message' => $message,
                                'sender' => $senderId,
                                'route' => $route,
                                'unicode' => '1'
                            );
                            $url = "https://sms.globehost.in/api/sendhttp.php?";
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
                            $this->sms_management_model->update_sms_limit($ad);
                            $this->sms_management_model->create_sms_history($ad, $ptnt, $consultant, 'instant');
                            if (curl_errno($ch)) {
                                echo 'error:' . curl_error($ch);
                            }
                            curl_close($ch);*/
							
							#Send sms again - starts
							$authKey = "144872ArhHeSNu58c7bb84";
							$senderId = "DCTRIP";
							$route = 4;
							$mobileNumber = $contact;
							//$mobileNumber = 7588302668;
							$encodedMessage = urlencode($patient_message."\n\nNow digitise your medical records and manage your health information on-the-go with the Doctori8 Patient App! Download now! https://bit.ly/2IoxEtl");
							//$message = mb_convert_encoding($patient_message, "UTF-8");
							$api_url = "http://sms.globehost.in/sendhttp.php?authkey=".$authKey."&mobiles=".$mobileNumber."&message=".$encodedMessage."&sender=".$senderId."&route=".$route."&unicode=1";
							//echo $api_url;
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
							//echo '<br>$response : '.$response; 
							#Send sms again - ends  
                        }
                        $this->appointment_model->save($save);
                        $ret = array(
                            "IsSuccess" => true,
                            "Msg" => "Appointment Successfully Created 2"
                        );
                    }
                       if ($type_id == 'undefined') {
                        $admin = $this->session->userdata('admin');
                        //$docid = '';
                        $booked_by = $admin['id'];
                       // if ($admin['user_role'] == 1) {
                            $docid = $admin['doctor_id'];
                      //  }
                      // if ($admin['user_role'] == 3) {
                       //     $docid = $admin['doctor_id'];
                       // }
                        $save['title'] = $this->input->post('Subject');
                        $save['whom'] = $this->input->post('whom');
                        $save['patient_id'] = $this->input->post('patient_id');
                        $save['contact_id'] = $this->input->post('contact_id');
                        $cl_id = $this->input->post('clinic_id');
                        $save['clinic_id'] = $cl_id;
                        $clinics =  $this->doctor_model->get_clinic_by_doctor();
                        foreach ($clinics as $new) {
                             if($cl_id ==$new->clinic_id)
                             { 
                                $save['clinic_name'] = $new->clinic_name;
                             }
                        }
                        
                        $save['other'] = $this->input->post('other');
                        $save['motive'] = $this->input->post('motive');
                        $t = $this->input->post('slot');
                        $h = floor($t/60) ? floor($t/60) .' hr' : '';
                           $m = $t%60 ? $t%60 .' mins' : '';
                            $val_slot =  $h && $m ? $h.' '.$m : $h.$m;
                        $save['slot_length'] = $val_slot;
                        $date_val = date_create(date("Y-m-d H:i:s", strtotime($st)));
                        $save['appointment_time'] = date_format($date_val, 'g:i A');
                        $save['date'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['is_paid'] = $this->input->post('is_paid');
                        $save['consultation_fees'] = $this->input->post('consultation_charge');
                        $save['status'] = 1;
                        $save['appointment_status'] = 2;
                        $save['is_manually_added'] = 1;
                        $save['Color'] = $this->input->post('colorvalue');
                        $save['doctor_id'] = $docid;
                        $save['booked_by'] = $booked_by;
                        $save['booker_type'] = 'DOCTOR';
                        $consultant = $this->input->post('consultant');
                        $save['consultant'] = $this->input->post('consultant');

                        $ptnt = $this->input->post('patient_id');
                        $data_patient = $this->patient_model->get_cont($ptnt);
                        $gender = '';
                        $patient_name = '';
                        foreach ($data_patient as $newx) {
                            $gender = $newx->gender;
                            $patient_name = $newx->name;
                        }
                        $mr = '';
                        if ($gender == 'Male') {
                            $mr = 'Mr';
                        } else {
                            $mr = 'Miss';
                        }
                        $ad = '';
                        if ($admin['user_role'] == 1) {
                            $ad = $admin['doctor_id'];
                        }
                        if ($admin['user_role'] == 3) {
                            $ad = $admin['doctor_id'];
                        }
                        $admin = '';
                        $admin_names = $this->patient_model->get_cont($ad);
                        foreach ($admin_names as $newadmin) {
                            $admin = $newadmin->name;
                        }
                        $cntc = $this->patient_model->get_cont($ptnt);
                        $contact = '';
                        foreach ($cntc as $newzz) {
                            $contact = $newzz->contact;
                        }

                        $dtate = date('d/m/Y h:i:s a', strtotime($st));
                        $sms = $this->input->post('is_paid');
                        $sms_lang = $this->input->post('lang');
                        $sms_setting = $this->sms_management_model->get_instant_by_doctor($ad);
                        $sms_count = $this->sms_management_model->get_sms_count($ad);
                        $sms_count = $sms_count->sms_limit;
                        $val = $sms_setting[0]['status'];
                        if ($sms_lang == 'english')
                            $patient_message = "Dear " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . " Thanks";
                        else if ($sms_lang == 'hindi')
                            $patient_message = "प्रिय " . $patient_name . ", " . $admin . " के साथ आपकी " . $dtate . " की नियुक्ति की पुष्टि की गयी है । धन्यवाद";
                        else if ($sms_lang == 'bengali')
                            $patient_message = "প্রিয় " . $patient_name . ", " . $admin . " এ আপনার চিকিৎসা এর জন্য " . $dtate . " এর সময় দেয়া হয়েছে  | ধন্যবাদ";
                        else if ($sms_lang == 'telugu')
                            $patient_message = "";
                        else if ($sms_lang == 'marathi')
                            $patient_message = "";
                        if ($sms == 1 && $val == '1' && $sms_count!=0) {
                            /*$authKey = "144872ArhHeSNu58c7bb84";
                            $mobileNumber = $contact;
                            $senderId = "DOCTRI";
                            $message = mb_convert_encoding($patient_message."\n\nNow digitise your medical records and manage your health information on-the-go with the Doctori8 Patient App! Download now! https://bit.ly/2IoxEtl", "UTF-8");
                            $route = 4;
                            $postData = array(
                                'authkey' => $authKey,
                                'mobiles' => $mobileNumber,
                                'message' => $message,
                                'sender' => $senderId,
                                'route' => $route,
                                'unicode' => '1'
                            );
                            $url = "https://sms.globehost.in/api/sendhttp.php?";
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
                            $this->sms_management_model->update_sms_limit($ad);
                            $this->sms_management_model->create_sms_history($ad, $ptnt, $consultant, 'instant');
                            if (curl_errno($ch)) {
                                echo 'error:' . curl_error($ch);
                            }
                            curl_close($ch);*/
							
							#Send sms again - starts
							$authKey = "144872ArhHeSNu58c7bb84";
							$senderId = "DCTRIP";
							$route = 4;
							$mobileNumber = $contact;
							//$mobileNumber = 9075627173;
							$encodedMessage = urlencode($patient_message."\n\nNow digitise your medical records and manage your health information on-the-go with the Doctori8 Patient App! Download now! https://bit.ly/2IoxEtl");
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
							//echo '<br>$response : '.$response; 
							#Send sms again - ends
                        }
                        $this->appointment_model->save($save);
                        $ret = array(
                            "IsSuccess" => true,
                            "Msg" => "Appointment Successfully Created 3"
                        );
                    }
                    if ($type_id == 3) {   // Hospital
                        $save['day'] = date('N', strtotime($st));
                        $save['timing_from'] = date("H:i:s", strtotime($time1));
                        $save['timing_to'] = date("H:i:s", strtotime($time2));
                        $save['work'] = $this->input->post('Subject');

                        $save['hospital'] = $this->input->post('hospital_id');
                        $save['type'] = 1;
                        $save['doctor_id'] = $admin['id'];
                        //echo '<pre>'; print_r($save);die;
                        $this->schedule_model->save_schedule($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Hospital Schedule Succefully Created",
                        );
                    }
                    if ($type_id == 4) {   // Medical COllege
                        $save['day'] = date('N', strtotime($st));
                        $save['timing_from'] = date("H:i:s", strtotime($time1));
                        $save['timing_to'] = date("H:i:s", strtotime($time2));
                        $save['work'] = $this->input->post('Subject');

                        $save['hospital'] = $this->input->post('college_id');
                        $save['type'] = 2;
                        $save['doctor_id'] = $admin['id'];
                        $this->schedule_model->save_schedule($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Medical College Schedule Succefully Created",
                        );
                    }

                    if ($type_id == 5) {
                        //$save['schedule_category_id'] = $this->input->post('schedule_category');
                        $save['Subject'] = $this->input->post('Subject');
                        $save['StartTime'] = date("Y-m-d H:i:s", strtotime($st));
                        $save['EndTime'] = date("Y-m-d H:i:s", strtotime($et));
                        $save['IsAllDayEvent'] = $this->input->post('IsAllDayEvent');
                        $save['doctor_id'] = $admin['id'];
                        $save['Color'] = $this->input->post('colorvalue');
                        $this->calendar_model->save($save);
                        $ret = array(
                            'IsSuccess' => true,
                            'Msg' => "Schedule Succefully Created",
                        );
                    }
                }
                break;
        }
        echo json_encode($ret);
    }

    function addCalendar($st, $et, $sub, $ade) {
        $ret = array();
        $admin = $this->session->userdata('admin');
        try {
            $save['subject'] = $sub;
            $save['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
            $save['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
            $save['isalldayevent'] = $ade;
            $save['doctor_id'] = $admin['id'];
            $this->db->insert('jqcalendar', $save);

            $ret['IsSuccess'] = true;
            $ret['Msg'] = 'add success';
            $ret['Data'] = $this->db->insert_id();
        } catch (Exception $e) {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = $e->getMessage();
        }
        return $ret;
    }

    function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz) {
        $admin = $this->session->userdata('admin');
        $docid = '';
        if ($admin['user_role'] == 1) {
            $docid = $admin['doctor_id'];
        }
        if ($admin['user_role'] == 3) {
            $docid = $admin['doctor_id'];
        }
        $ret = array();
        try {
            $save['subject'] = $sub;
            $save['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
            $save['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
            $save['isalldayevent'] = $ade;
            $save['description'] = $dscr;
            $save['location'] = $loc;
            $save['color'] = $color;
            $save['doctor_id'] = $docid;
            $this->db->insert('jqcalendar', $save);

            $ret['IsSuccess'] = true;
            $ret['Msg'] = 'add success';
            $ret['Data'] = $this->db->insert_id();
        } catch (Exception $e) {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = $e->getMessage();
        }
        return $ret;
    }

    function listCalendarByRange($sd, $ed) {
        $admin = $this->session->userdata('admin');
        $doctor_idz = '';
        $doctor_idz = $admin['id'];
        $doctor_idz1 = $admin['doctor_id'];

        $ret = array();
        $ret['events'] = array();
        $ret["issort"] = true;
        $ret["start"] = $this->php2JsTime($sd);
        $ret["end"] = $this->php2JsTime($ed);
        $ret['error'] = null;
        try {
            $sql = "select * from `jqcalendar` where `starttime` between '"
                    . $this->php2MySqlTime($sd) . "' and '" . $this->php2MySqlTime($ed) . "' and (doctor_id = '" . $doctor_idz . "' or doctor_id = '" . $doctor_idz1 . "' )  ";
            $app = "select * from `appointments` where `date` between '"
                    . $this->php2MySqlTime($sd) . "' and '" . $this->php2MySqlTime($ed) . "' and (doctor_id = '" . $doctor_idz . "' or doctor_id = '" . $doctor_idz1 . "' )  ";
            $todo = "select * from `to_do_list` where `date` between '"
                    . $this->php2MySqlTime($sd) . "' and '" . $this->php2MySqlTime($ed) . "' and (doctor_id = '" . $doctor_idz . "' or doctor_id = '" . $doctor_idz1 . "' )  ";

            $handle = $this->db->query($sql)->result();
            $handle1 = $this->db->query($app)->result();
            $handle3 = $this->db->query($todo)->result();
            //echo $sql;
            foreach ($handle as $row) {
                $ret['events'][] = array(
                    $row->Id,
                    $row->Subject,
                    $this->php2JsTime($this->mySql2PhpTime($row->StartTime)),
                    $this->php2JsTime($this->mySql2PhpTime($row->EndTime)),
                    $row->IsAllDayEvent,
                    0, //more than one day event
                    //$row->InstanceType,
                    0, //Recurring event,
                    $row->Color,
                    1, //editable
                    0,
                    5, //$attends
                );
            }
			
			$pending = array();
			foreach ($handle1 as $row) {
                #Get balance of that paitent - starts					
				$total_c1 = 0;
				$total_d1 = 0;
				$total_b1 = 0;
				$fees_all = $this->patient_model->get_patients_by_invoice_payment($row->patient_id);
				//echo '<pre>--> fees_all : '; print_r($fees_all); echo '</pre>';
				if(count($fees_all) > 0){
					foreach ($fees_all as $new) {
						$total_c1 = $total_c1 + $new->credit;
						$total_d1 = $total_d1 + $new->debit;
					}
					$total_b1 = $total_c1 - $total_d1;
				}
				$pending[$row->patient_id] = $total_b1;
				#Get balance of that paitent - ends
			}
			//echo '<pre>pending '; print_r($pending); echo '</pre>';die;
				
            foreach ($handle1 as $row) {
                $consultant = "select name from `consultant` where id='$row->consultant' ";
                $handlezzz = $this->db->query($consultant)->result();
                foreach ($handlezzz as $rowzz) {
					
					#Get balance of that paitent - starts					
					/*$total_c1 = 0;
					$total_d1 = 0;
					$total_b1 = 0;
					$fees_all = $this->patient_model->get_patients_by_invoice_payment($row->patient_id);
					//echo '<pre>--> fees_all : '; print_r($fees_all); echo '</pre>';
					if(count($fees_all) > 0){
						foreach ($fees_all as $new) {
							$total_c1 = $total_c1 + $new->credit;
							$total_d1 = $total_d1 + $new->debit;
						}
						$total_b1 = $total_c1 - $total_d1;
					}*/
					#Get balance of that paitent - ends
					
                    $contactz = 0;
                    $contact = "select contact , name from `users` where id='$row->patient_id' ";
                    $handleccc = $this->db->query($contact)->result();
                    foreach ($handleccc as $rowcc) {
                        $contactz = $rowcc->contact;
                        $patientname = $rowcc->name;
                    }
                    $ret['events'][] = array(
                        $row->id,
                        (empty($patientname)) ?
                                $row->motive : $patientname,
                        $this->php2JsTime($this->mySql2PhpTime($row->date)),
                        $this->php2JsTime($this->mySql2PhpTime($row->end_date)),
                        0,
                        0,
                        0,
                        $row->Color,
                        '1',
                        $row->patient_id, //no location 
                        '2', //$attends
                        $rowzz->name,
                        $contactz . ' ' . $row->motive,
						$pending[$row->patient_id]
                    );
                }
            }
            foreach ($handle3 as $row) {
                $ret['events'][] = array(
                    $row->id,
                    $row->title,
                    $this->php2JsTime($this->mySql2PhpTime($row->date)),
                    $this->php2JsTime($this->mySql2PhpTime($row->end_date)),
                    0, //not al day
                    0, //more than one day event
                    //$row->InstanceType,
                    0, //Recurring event,
                    $row->Color, //color
                    1, //editable
                    0, //no location 
                    '1', //$attends
                );
            }
        } catch (Exception $e) {
            $ret['error'] = $e->getMessage();
        }

        //echo '<pre>';print_r($ret);die;
        return $ret;
    }

    function listCalendar($day, $type) {
        $phpTime = $this->js2PhpTime($day);
        //echo $phpTime . "+" . $type;
        switch ($type) {
            case "month":
                $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime) + 1, 1, date("Y", $phpTime));
                break;
            case "week":
                //suppose first day of a week is monday 
                $monday = date("d", $phpTime) - date('N', $phpTime) + 1;
                //echo date('N', $phpTime);
                $st = mktime(0, 0, 0, date("m", $phpTime), $monday, date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime), $monday + 7, date("Y", $phpTime));


                break;
            case "day":
                $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
                $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime) + 1, date("Y", $phpTime));
                break;
        }
        //echo $st . "--" . $et;
        return $this->listCalendarByRange($st, $et);
    }

    function updateCalendar($id, $st, $et) {
        $ret = array();
        try {
            //echo $sql;
            $update['date'] = $this->php2MySqlTime($this->js2PhpTime($st));
            $update['end_date'] = $this->php2MySqlTime($this->js2PhpTime($et));

            $this->db->where('id', $id);
            $this->db->update('appointments', $update);
            $app = $this->appointment_model->get_appointment_by_id($id);
            $pid = $app->patient_id;
            //==============================================================
            $admin = $this->session->userdata('admin');
            $data_patient = $this->patient_model->get_cont($pid);
            $gender = '';
            $patient_name = '';
            foreach ($data_patient as $newx) {
                $gender = $newx->gender;
                $patient_name = $newx->name;
            }
            $mr = '';
            if ($gender == 'Male') {
                $mr = 'Mr';
            } else {
                $mr = 'Miss';
            }
            $ad = '';
            if ($admin['user_role'] == 1) {
                $ad = $admin['doctor_id'];
            }
            if ($admin['user_role'] == 3) {
                $ad = $admin['doctor_id'];
            }
            $admin = '';
            $admin_names = $this->patient_model->get_cont($ad);
            foreach ($admin_names as $newadmin) {
                $admin = $newadmin->name;
            }
            $cntc = $this->patient_model->get_cont($pid);
            $contact = '';
            foreach ($cntc as $newzz) {
                $contact = $newzz->contact;
            }

            $dtate = date('d/m/Y h:i:s a', strtotime($st));
            $sms_setting = $this->sms_management_model->get_instant_by_doctor($ad);
            $val = $sms_setting[0]['status'];
            if ($sms_setting[0]['lang'] == 'english')
                $patient_message = "Dear " . $patient_name . " ,Your appointment is confirmed for " . $dtate . " at " . $admin . ". Thanks";
            else if ($sms_setting[0]['lang'] == 'hindi')
                $patient_message = "प्रिय " . $patient_name . ", " . $admin . " के साथ आपकी " . $dtate . " की नियुक्ति की पुष्टि की गयी है । धन्यवाद";
            else if ($sms_setting[0]['lang'] == 'bengali')
                $patient_message = "প্রিয় " . $patient_name . ", " . $admin . " এ আপনার চিকিৎসা এর জন্য " . $dtate . " এর সময় দেয়া হয়েছে  | ধন্যবাদ";
            else if ($sms_setting[0]['lang'] == 'telugu')
                $patient_message = "";
            else if ($sms_setting[0]['lang'] == 'marathi')
                $patient_message = "";
            if ($val == '1') {
                $authKey = "144872ArhHeSNu58c7bb84";
                $mobileNumber = $contact;
                $senderId = "DOCTRI";
                $message = mb_convert_encoding($patient_message, "UTF-8");
                $route = 4;
                $postData = array(
                    'authkey' => $authKey,
                    'mobiles' => $mobileNumber,
                    'message' => $message,
                    'sender' => $senderId,
                    'route' => $route,
                    'unicode' => '1'
                );
                $url = "https://sms.globehost.in/api/sendhttp.php?";
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
            $ret['IsSuccess'] = true;
            $ret['Msg'] = "Successfully Updated";
        } catch (Exception $e) {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = $e->getMessage();
        }
        return $ret;
    }

    function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz) {
        $ret = array();
        try {

            $update['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
            $update['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
            $update['subject'] = $sub;
            $update['isalldayevent'] = $ade;
            $update['description'] = $dscr;
            $update['location'] = $loc;
            $update['color'] = $color;

            $this->db->where('id', $id);
            $this->db->update('jqcalendar', $update);

            $ret['IsSuccess'] = true;
            $ret['Msg'] = 'Succefully';
        } catch (Exception $e) {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = $e->getMessage();
        }
        return $ret;
    }

    function removeCalendar($id) {
        $ret = array();
        try {
            $this->db->where('id', $id);
            $this->db->delete('jqcalendar');
            $ret['IsSuccess'] = true;
            $ret['Msg'] = 'Succefully';
        } catch (Exception $e) {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = $e->getMessage();
        }
        return $ret;
    }

//function.php
    function js2PhpTime($jsdate) {
        if (preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches) == 1) {
            $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
            //echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
        } else if (preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches) == 1) {
            $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
            //echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
        }
        return $ret;
    }

    function php2JsTime($phpDate) {
        //echo $phpDate;
        //return "/Date(" . $phpDate*1000 . ")/";
        //echo '<pre>-->'; print_r($_GET);die;
        if (empty($_GET['timeformat'])) {
            return date("m/d/Y H:i", $phpDate);
        } else {
            if ($_GET['timeformat'] == 2) {
                return date("m/d/Y h:i", $phpDate);
            } else {
                return date("m/d/Y H:i", $phpDate);
            }
        }
    }

    function php2MySqlTime($phpDate) {
        return date("Y-m-d H:i:s", $phpDate);
    }

    function mySql2PhpTime($sqlDate) {
        $arr = date_parse($sqlDate);
        return mktime($arr["hour"], $arr["minute"], $arr["second"], $arr["month"], $arr["day"], $arr["year"]);
    }

}