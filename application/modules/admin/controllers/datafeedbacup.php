<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class datafeed extends MX_Controller {

	public function __construct()
	{
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
		
	}
	
	function index(){
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
				//echo '<pre>'; print_r($_GET);
				//echo '<pre>'; print_r($_POST);die;
				$ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
				@$type_id = $_POST['type_id'];
				
				@$id = $_POST["calendarId"];
				$st = $_POST["CalendarStartTime"];
				$et = $_POST["CalendarEndTime"];
			
				$next=1;
				if($id && $next==1){
				
					if($type_id==1){
						$save['date'] = date("Y-m-d H:i:s", strtotime($st));
						$save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
						$this->to_do_list_model->update($save,$id);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "To Do Succefully Updated",
						);
					}
					if($type_id==2){
						//echo '<pre>'; print_r($_POST);die;
						$save['date'] = date("Y-m-d H:i:s", strtotime($st));
						$save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
						$this->appointment_model->update($save,$id);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Appointment Succefully Updated",
						);
					}
					
					if($type_id==5){
						$ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
					}
					
				}
					
				break; 
			case "remove":
				$type_id = $_POST['type_id'];
				$id = $_POST['id'];	
				if($type_id==1){
					$this->to_do_list_model->delete($id);
				}
				if($type_id==2){
					$this->appointment_model->delete($id);
				
				}
				if($type_id==3){
					$this->schedule_model->delete_week_schedule($id);
				}
				if($type_id==4){
					$this->schedule_model->delete_week_schedule($id);
				}
				if($type_id==5){
					 $this->removeCalendar( $_POST["id"]);
				}
				$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Event Succefully Deleted",
						);
				break;
				
			case "add_form":
				$admin = $this->session->userdata('admin');
				$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				
				//echo '<pre>'; print_r($_POST);die;
				$checked = $this->calendar_model->check_tables($st,$et);
					if(!empty($checked)){
						
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> $checked,
						);
						$next=0;
				
					}else{
						$next=1;
					}
				$type_id = $this->input->post('schedule_category');
				
				if($type_id==1 && $next==1){
					$save['title'] = $this->input->post('Subject');
				    $save['date'] = date("Y-m-d H:i:s", strtotime($st));
					$save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
					$save['doctor_id'] = $admin['id'];
					$save['Color'] = $this->input->post('colorvalue');
					$this->to_do_list_model->save($save);
					
					$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "To Do Succefully Created",
						);
				}
				if($type_id==2 && $next==1){
				
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
if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
					
					

$ptnt= $this->input->post('patient_id');
$data_patient=$this->patient_model->get_cont($ptnt);
$gender='';
$patient_name='';
foreach($data_patient as $newx) {
$gender=$newx->gender;
$patient_name=$newx->name;
}
$mr='';
if($gender=='Male'){
$mr='Mr';
}else{
$mr='Miss';
}
$ad='';
if($admin['user_role']==1){
$ad = $admin['id'];
}
if($admin['user_role']==3){
$ad = $admin['doctor_id'];
}
$admin='';
$admin_names= $this->patient_model->get_cont($ad);
foreach($admin_names as $newadmin) {
$admin=$newadmin->name;
}
$cntc = $this->patient_model->get_cont($ptnt);
$contact='';
foreach($cntc as $newzz) {
$contact=$newzz->contact;
}
$dtate= date("Y-m-d H:i:s", strtotime($st));
$sms=$this->input->post('is_paid');
if($sms==1){
    $authKey = "144872ArhHeSNu58c7bb84";
    $mobileNumber = $contact;
    $senderId = "DOCTRI";
$mesg="Dear ".$mr." ".$patient_name." ,Your appointment is confirmed for ".$dtate." at ".$admin." Thanks";
    $message = urlencode($mesg);
    $route = 4;
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );
 $url="http://sms.globehost.com/api/sendhttp.php?";
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
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }
    curl_close($ch);
}



					$this->appointment_model->save($save);
					$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Appointment Succefully Created",
						);
				}
				if($type_id==3 && $next==1){   // Hospital
						
						$save['day'] = date('N', strtotime($st));
						$save['timing_from'] = date("H:i:s", strtotime($time1));
						$save['timing_to'] = date("H:i:s", strtotime($time2));
						$save['work'] = $this->input->post('Subject');
						
						$save['hospital'] = $this->input->post('hospital_id');
						$save['type'] = 1;
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						//echo '<pre>'; print_r($save);die;
						$this->schedule_model->save_schedule($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Hospital Schedule Succefully Updated",
						);
					}
					if($type_id==4 && $next==1){   // Medical COllege
						
						$save['day'] = date('N', strtotime($st));
						$save['timing_from'] = date("H:i:s", strtotime($time1));
						$save['timing_to'] = date("H:i:s", strtotime($time2));
						$save['work'] = $this->input->post('Subject');
						
						$save['hospital'] = $this->input->post('college_id');
						$save['type'] = 2;
						$save['doctor_id'] = $admin['id'];
						$this->schedule_model->save_schedule($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Hospital Schedule Succefully Updated",
						);
					}
				if($type_id==5 && $next==1){
				
					$save['Subject'] = $this->input->post('Subject');
					$save['IsAllDayEvent'] = isset($_POST["IsAllDayEvent"])?1:0;
					$save['Description'] = $this->input->post('Description');
					$save['Location'] = $this->input->post('Location');
					$save['Color'] = $this->input->post('colorvalue');
					$save['StartTime'] =  date("Y-m-d H:i:s", strtotime($st));
					$save['EndTime'] =  date("Y-m-d H:i:s", strtotime($et));
					if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
					$this->calendar_model->save($save);
					$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Schedule Succefully Created",
						);
					
				}
				break;	
			case "adddetails":
				//echo '<pre>'; print_r($_GET);
					//echo '<pre>'; print_r($_POST);die;
				$type_id = $this->input->post('schedule_category');
				
				@$id = $_GET["id"];
				$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				$time1 = $_POST["stparttime"];
				$time2 = $_POST["etparttime"];
				$checked = $this->calendar_model->check_tables($st,$et);
					if(!empty($checked)){
						
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> $checked,
						);
						$next=0;
				
					}else{
						$next=1;
					}
				
				//echo 'NEXT<--'.$next;die;	
				if($id && $next==1){
				
					if($type_id==1){
						$save['title'] = $this->input->post('Subject');
						$save['date'] = date("Y-m-d H:i:s", strtotime($st));
						$save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						$save['Color'] = $this->input->post('colorvalue');
						$this->to_do_list_model->update($save,$_GET["id"]);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "To Do Succefully Updated",
						);
					}
					if($type_id==2){
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
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
$ptnt= $this->input->post('patient_id');
$data_patient=$this->patient_model->get_cont($ptnt);
$gender='';
$patient_name='';
foreach($data_patient as $newx) {
$gender=$newx->gender;
$patient_name=$newx->name;
}
$mr='';
if($gender=='Male'){
$mr='Mr';
}else{
$mr='Miss';
}
$ad='';
if($admin['user_role']==1){
$ad = $admin['id'];
}
if($admin['user_role']==3){
$ad = $admin['doctor_id'];
}
$admin='';
$admin_names= $this->patient_model->get_cont($ad);
foreach($admin_names as $newadmin) {
$admin=$newadmin->name;
}
$cntc = $this->patient_model->get_cont($ptnt);
$contact='';
foreach($cntc as $newzz) {
$contact=$newzz->contact;
}
$dtate= date("Y-m-d H:i:s", strtotime($st));
$sms=$this->input->post('is_paid');
if($sms==1){
    $authKey = "144872ArhHeSNu58c7bb84";
    $mobileNumber = $contact;
    $senderId = "DOCTRI";
$mesg="Dear ".$mr." ".$patient_name." ,Your appointment is confirmed for ".$dtate." at ".$admin." Thanks";
    $message = urlencode($mesg);
    $route = 4;
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );
 $url="http://sms.globehost.com/api/sendhttp.php?";
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
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }
    curl_close($ch);
}
						$this->appointment_model->update($save,$_GET["id"]);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Appointment Succefully Updated",
						);
					}
					
					if($type_id==3){   // Hospital
						
						$save['day'] = date('N', strtotime($st));
						$save['timing_from'] = date("H:i:s", strtotime($time1));
						$save['timing_to'] = date("H:i:s", strtotime($time2));
						$save['work'] = $this->input->post('Subject');
						
						$save['hospital'] = $this->input->post('hospital_id');
						$save['type'] = 1;
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						//echo '<pre>'; print_r($save);die;
						$this->schedule_model->save_schedule($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Hospital Schedule Succefully Updated",
						);
					}
					if($type_id==4){   // Medical COllege
						
						$save['day'] = date('N', strtotime($st));
						$save['timing_from'] = date("H:i:s", strtotime($time1));
						$save['timing_to'] = date("H:i:s", strtotime($time2));
						$save['work'] = $this->input->post('Subject');
						
						$save['hospital'] = $this->input->post('college_id');
						$save['type'] = 2;
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						$this->schedule_model->save_schedule($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Hospital Schedule Succefully Updated",
						);
					}
					if($type_id==5){
						$ret = $this->updateDetailedCalendar($id, $st, $et, 
						$_POST["Subject"], @$_POST["IsAllDayEvent"]?1:0, @$_POST["Description"], 
						@$_POST["Location"], $_POST["colorvalue"], @$_POST["timezone"]);
					}
					
				}
				if(empty($id) && $next==1){   // else ID not found in GET method
								
					if($type_id==1){
						$save['title'] = $this->input->post('Subject');
						$save['date'] = date("Y-m-d H:i:s", strtotime($st));
						$save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						$save['Color'] = $this->input->post('colorvalue');
						$this->to_do_list_model->save($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "To Do Succefully Created",
						);			
					}
				
					if($type_id==2){
							$save['title'] = $this->input->post('Subject');
							$save['whom'] = $this->input->post('whom');
							$save['patient_id'] = $this->input->post('patient_id');
							$save['contact_id'] = $this->input->post('contact_id');
							$save['other'] = $this->input->post('other');
							$save['motive'] = $this->input->post('motive');
							$save['date'] = date("Y-m-d H:i:s", strtotime($st));
							$save['end_date'] = date("Y-m-d H:i:s", strtotime($et));
							$save['is_paid'] = $this->input->post('is_paid');
							$save['status'] = 1;
							$save['Color'] = $this->input->post('colorvalue');
							if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
							$save['consultant'] = $this->input->post('consultant');

$ptnt= $this->input->post('patient_id');
$data_patient=$this->patient_model->get_cont($ptnt);
$gender='';
$patient_name='';
foreach($data_patient as $newx) {
$gender=$newx->gender;
$patient_name=$newx->name;
}
$mr='';
if($gender=='Male'){
$mr='Mr';
}else{
$mr='Miss';
}
$ad='';
if($admin['user_role']==1){
$ad = $admin['id'];
}
if($admin['user_role']==3){
$ad = $admin['doctor_id'];
}
$admin='';
$admin_names= $this->patient_model->get_cont($ad);
foreach($admin_names as $newadmin) {
$admin=$newadmin->name;
}
$cntc = $this->patient_model->get_cont($ptnt);
$contact='';
foreach($cntc as $newzz) {
$contact=$newzz->contact;
}
$dtate= date("Y-m-d H:i:s", strtotime($st));
$sms=$this->input->post('is_paid');
if($sms==1){
    $authKey = "144872ArhHeSNu58c7bb84";
    $mobileNumber = $contact;
    $senderId = "DOCTRI";
$mesg="Dear ".$mr." ".$patient_name." ,Your appointment is confirmed for ".$dtate." at ".$admin." Thanks";
    $message = urlencode($mesg);
    $route = 4;
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );
 $url="http://sms.globehost.com/api/sendhttp.php?";
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
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }
    curl_close($ch);
}
							$this->appointment_model->save($save);
							$ret=array(
							'IsSuccess'=>true,
							'Msg'=> "Appointment Succefully Created",
							);
						}
						if($type_id==3){   // Hospital
						$save['day'] = date('N', strtotime($st));
						$save['timing_from'] = date("H:i:s", strtotime($time1));
						$save['timing_to'] = date("H:i:s", strtotime($time2));
						$save['work'] = $this->input->post('Subject');
						
						$save['hospital'] = $this->input->post('hospital_id');
						$save['type'] = 1;
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						//echo '<pre>'; print_r($save);die;
						$this->schedule_model->save_schedule($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Hospital Schedule Succefully Created",
						);
					}
					if($type_id==4){   // Medical COllege
						
						$save['day'] = date('N', strtotime($st));
						$save['timing_from'] = date("H:i:s", strtotime($time1));
						$save['timing_to'] = date("H:i:s", strtotime($time2));
						$save['work'] = $this->input->post('Subject');
						
						$save['hospital'] = $this->input->post('college_id');
						$save['type'] = 2;
						if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
						$this->schedule_model->save_schedule($save);
						$ret=array(
						'IsSuccess'=>true,
						'Msg'=> "Medical College Schedule Succefully Created",
						);
					}
					
						if($type_id==5){
							//$save['schedule_category_id'] = $this->input->post('schedule_category');
							$save['Subject'] = $this->input->post('Subject');
							$save['StartTime'] = date("Y-m-d H:i:s", strtotime($st));
							$save['EndTime'] =	date("Y-m-d H:i:s", strtotime($et));
							$save['IsAllDayEvent'] = $this->input->post('IsAllDayEvent');
							if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
							$save['Color'] = $this->input->post('colorvalue');
							$this->calendar_model->save($save);
							$ret=array(
							'IsSuccess'=>true,
							'Msg'=> "Schedule Succefully Created",
							);
							
						}
					
				}        
				break; 
		
		
		}
		echo json_encode($ret);

	}
	function addCalendar($st, $et, $sub, $ade){
  $ret = array();
  $admin = $this->session->userdata('admin');
  try{
  		$save['subject']		=	$sub;
		$save['starttime']		=	$this->php2MySqlTime($this->js2PhpTime($st));
		$save['endtime']		=	$this->php2MySqlTime($this->js2PhpTime($et));
		$save['isalldayevent']	=	$ade;
		$save['doctor_id']		=	$admin['id'];
		$this->db->insert('jqcalendar',$save);		
	
		  $ret['IsSuccess'] = true;
		  $ret['Msg'] = 'add success';
		  $ret['Data'] = $this->db->insert_id();
	
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}


function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $admin = $this->session->userdata('admin');
  $ret = array();
  try{
  		$save['subject']		=	$sub;
		$save['starttime']		=	$this->php2MySqlTime($this->js2PhpTime($st));
		$save['endtime']		=	$this->php2MySqlTime($this->js2PhpTime($et));
		$save['isalldayevent']	=	$ade;
		$save['description']	=	$dscr;
		$save['location']		=	$loc;
		$save['color']			=	$color;
		if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
		$this->db->insert('jqcalendar',$save);	
		
	  $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = $this->db->insert_id();
    
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function listCalendarByRange($sd, $ed){
$doct=0;
 $admin = $this->session->userdata('admin');
if($admin['user_role']==1){
					$doct = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$doct = $admin['doctor_id'];
				   }
  
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = $this->php2JsTime($sd);
  $ret["end"] = $this->php2JsTime($ed);
  $ret['error'] = null;
  try{
    $sql = "select * from `jqcalendar` where `starttime` between '"
      .$this->php2MySqlTime($sd)."' and '". $this->php2MySqlTime($ed)."' and doctor_id = '". $doct."'  ";
	$app = "select * from `appointments` where `date` between '"
      .$this->php2MySqlTime($sd)."' and '". $this->php2MySqlTime($ed)."' and doctor_id = '". $doct."'  ";
	$todo = "select * from `to_do_list` where `date` between '"
      .$this->php2MySqlTime($sd)."' and '". $this->php2MySqlTime($ed)."' and doctor_id = '". $doct."'  ";
	    
    $handle = $this->db->query($sql)->result();
	$handle1 = $this->db->query($app)->result();
	$handle3 = $this->db->query($todo)->result();
    //echo $sql;
    foreach($handle as $row){
      $ret['events'][] = array(
       	$row->Id,
        $row->Subject,
        $this->php2JsTime($this->mySql2PhpTime($row->StartTime)),
        $this->php2JsTime($this->mySql2PhpTime($row->EndTime)),
        $row->IsAllDayEvent,
        0, //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row->Color,
        1,//editable
        $row->Location, 
        5,//$attends
     	 
	  );
    }
	foreach($handle1 as $row){
$consultant = "select name from `consultant` where id='$row->consultant' ";
$handlezzz = $this->db->query($consultant)->result();
foreach($handlezzz as $rowzz){
$contactz=0;
$contact = "select contact from `users` where id='$row->patient_id' ";
$handleccc = $this->db->query($contact)->result();
foreach($handleccc as $rowcc){
$contactz=$rowcc->contact;
}
      $ret['events'][] = array(
      $row->id,
        (empty($row->title))?
        $row->motive:$row->title,
        $this->php2JsTime($this->mySql2PhpTime($row->date)),
        $this->php2JsTime($this->mySql2PhpTime($row->end_date)),
		0, 
        0, 
        0,
        $row->Color, 
        1,//editable
        0, //no location 
        '2',//$attends
      	$rowzz->name,
        $contactz,
		
	  );
}
    }
	foreach($handle3 as $row){
      $ret['events'][] = array(
      $row->id,
        $row->title,
        $this->php2JsTime($this->mySql2PhpTime($row->date)),
        $this->php2JsTime($this->mySql2PhpTime($row->end_date)),
        0, //not al day
        0, //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row->Color, //color
        1,//editable
        0, //no location 
        '1',//$attends
      	
		
	  );
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  
  	//echo '<pre>';print_r($ret);die;
  return $ret;
}

function listCalendar($day, $type){
  $phpTime = $this->js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      

	  break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return $this->listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  $ret = array();
  try{
    //echo $sql;
	$update['starttime']	=	$this->php2MySqlTime($this->js2PhpTime($st));
	$update['endtime']	=	$this->php2MySqlTime($this->js2PhpTime($et));
	
	$this->db->where('id',$id);
	$this->db->update('jqcalendar',$update);
	
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
	
	$update['starttime']	=	$this->php2MySqlTime($this->js2PhpTime($st));
	$update['endtime']		=	$this->php2MySqlTime($this->js2PhpTime($et));
	$update['subject']		=	$sub;
	$update['isalldayevent']=	$ade;
	$update['description']	=	$dscr;
	$update['location']		=	$loc;
	$update['color']		=	$color;
	
	$this->db->where('id',$id);
	$this->db->update('jqcalendar',$update);
	
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id){
  $ret = array();
  try{
 	$this->db->where('id',$id);
	$this->db->delete('jqcalendar');
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}




//function.php
	function js2PhpTime($jsdate){
		  if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
			$ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
			//echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		  }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
			$ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
			//echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		  }
		  return $ret;
		}
		
		function php2JsTime($phpDate){
			//echo $phpDate;
			//return "/Date(" . $phpDate*1000 . ")/";
			//echo '<pre>-->'; print_r($_GET);die;
			if(empty($_GET['timeformat'])){
				return date("m/d/Y H:i", $phpDate);
			}else{
				if($_GET['timeformat']==2){
					return date("m/d/Y h:i", $phpDate);
				}else{
					return date("m/d/Y H:i", $phpDate);
				}
			}
		}
		
		function php2MySqlTime($phpDate){
			return date("Y-m-d H:i:s", $phpDate);
		}
		
		function mySql2PhpTime($sqlDate){
			$arr = date_parse($sqlDate);
			return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
		
		}

}