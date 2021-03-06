<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class patient_model extends CI_Model {

    function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    function get_blood_group() {

        return $this->db->get('blood_group_type')->result();
    }

    function get_username_by_doctor_id($id) {
        $this->db->where('doctor_id', $id);
        $this->db->where('user_role', 2);
        $this->db->select_max('id');
        $patient = $this->db->get('users')->row();

        $this->db->where('id', $patient->id);
        return $this->db->get('users')->row();
    }

    function get_username() 
    {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->where('user_role', 2);
        $this->db->select_max('id');
        $patient = $this->db->get('users')->row();

        $this->db->where('id', $patient->id);
        return $this->db->get('users')->row();
    }

    function get_username_by_assistant() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['doctor_id']);
        $this->db->where('user_role', 2);
        $this->db->select_max('id');
        $patient = $this->db->get('users')->row();

        $this->db->where('id', $patient->id);
        return $this->db->get('users')->row();
    }

    function save($save) {
        $number = $save['contact'];
       // log_message('debug','Contact :'.$save['contact']);
       // log_message('debug','username :'.$save['username']);
        $this->db->where('contact',$number);
		$this->db->where('user_role',2);
        $query=$this->db->get('users')->row(0);
         if($query)
             {
                // log_message('debug','Check 1');
                $this->db->where('patient_id',$query->id);
                $this->db->where('doctor_id',$save['doctor_id']);
                $query1=$this->db->get('doc_user_relation')->row(0);
                if($query1)
                {
                    //do nothing
                }
                else {
                $data['patient_id'] = $query->id;
                $data['doctor_id'] = $save['doctor_id'];
                $now = new DateTime();
                $now->setTimezone(new DateTimezone('Asia/Kolkata'));
                $data['created_on'] = $now->format('Y-m-d H:i:s');
                $this->db->insert('doc_user_relation',$data);
                return $query->id;
            }
        }
            else {
              //  log_message('debug','Check 2');
        $this->db->insert('users', $save);
        $patient_id = $this->db->insert_id();
       // $this->db->where('contact',$number);
        //$query1=$this->db->get('users')->row(0);

              $data['patient_id'] = $patient_id;
              $data['doctor_id'] = $save['doctor_id'];
             // $patient_name = $query->name;
              $now = new DateTime();
              $now->setTimezone(new DateTimezone('Asia/Kolkata'));
              $data['created_on'] = $now->format('Y-m-d H:i:s');
              $this->db->insert('doc_user_relation',$data);
        return $patient_id;
            }
    }

    function get_all() {
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_cont($ptnt) {
        $this->db->where('id', $ptnt);
        return $this->db->get('users')->result();
    }

    function get_patients_by_doctor() {
        $admin = $this->session->userdata('admin');
        
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
             $query_Patientlist = $this->db->get('doc_user_relation')->result();
             $patient_list = array();
             foreach($query_Patientlist as $patientlist)
             {
                $patient_id = $patientlist->patient_id;
                            $this->db->where('id',$patient_id);
                            $arr=$this->db->get('users')->row(0);
                            array_push($patient_list, $arr);
                        }
        return $patient_list;
    }

    function get_patients_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('id', $admin['id']);
        } else {
            $this->db->where('id', $admin['doctor_id']);
        }
        $this->db->where('user_role', 1);
        return $this->db->get('doctor')->row();
    }

    function get_patients_by_doctor_filter($search, $filter_id) {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        if (!empty($filter_id)) {
            if ($filter_id == "dob") {
                $this->db->like($filter_id, date("Y") - $search);
            }
            if ($filter_id == "group") {
                $this->db->like($filter_id, strtolower($search));
            } else {
                $this->db->like('LOWER(' . $filter_id . ')', strtolower($search));
            }
        }
        $this->db->limit('100');
        //$this->db->order_by('id', 'ASC');
        $this->db->order_by('DATE(add_date)', 'ASC');
        $this->db->where('user_role', 2);
        $data = $this->db->get('users')->result();
        foreach ($data as $key => $value) {
            $data[$key]->name = strtoupper($value->name);
        }
        return $data;
    }

    function get_patients_by_assistant() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['doctor_id']);
             $query_Patientlist = $this->db->get('doc_user_relation')->result();
             $patient_list = array();
             foreach($query_Patientlist as $patientlist)
             {
                $patient_id = $patientlist->patient_id;
                            $this->db->where('id',$patient_id);
                            $arr=$this->db->get('users')->row(0);
                                
                            array_push($patient_list, $arr);
                        }
        
       // foreach ($patient_list as $key => $value) {
        //    $patient_list[$key]->name = strtoupper($value->name);
        //}
        return $patient_list;
    }

    function get_patients_by_doctor_ajax($id) {
        if ($id == 0) {
            $admin = $this->session->userdata('admin');
            if ($admin['user_role'] == 1) {
                $this->db->where('doctor_id', $admin['id']);
            } else {
                $this->db->where('doctor_id', $admin['doctor_id']);
            }
            $this->db->where('user_role', 2);
            $data = $this->db->get('users')->result();
            foreach ($data as $key => $value) {
                $data[$key]->name = strtoupper($value->name);
            }
            return $data;
        }

        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('id', $id);
        $this->db->where('user_role', 2);
        $data = $this->db->get('users')->result();
        foreach ($data as $key => $value) {
            $data[$key]->name = strtoupper($value->name);
        }
        return $data;
    }

  /*  function get_patients_by_doctor_search($id, $searchmob) {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        if ($searchmob == '1') {
            $this->db->where("contact LIKE  '%$id%'");
        } else {
            $this->db->where("name LIKE  '%$id%'");
        }
        $this->db->where('user_role', 2);
        $data = $this->db->get('users')->result();
        foreach ($data as $key => $value) {
            $data[$key]->name = strtoupper($value->name);
        }
        return $data;
    }
*/
function get_patients_by_doctor_search_old($id, $searchmob) {
    $admin = $this->session->userdata('admin');
    
    if ($admin['user_role'] == 1) {
        $this->db->where('doctor_id', $admin['id']);
    } else {
        $this->db->where('doctor_id', $admin['doctor_id']);
    }
        $query_Patientlist = $this->db->get('doc_user_relation')->result();

        $datalist = array();
        foreach($query_Patientlist as $patientlist)
        {
           $patient_id = $patientlist->patient_id;
                       $this->db->where('id',$patient_id);
                       if ($searchmob == '1') {
                           $this->db->where("contact LIKE  '%$id%'");
                       } else {
                           $this->db->where("name LIKE  '%$id%'");
                       }
                       $arr=$this->db->get('users')->row(0);
                       array_push($datalist, $arr);
                      
                   }
                  try {
                    foreach ($datalist as $key => $value) {
                        
                        if (!empty($value)) {
                            $datalist[$key]->name = strtoupper($value->name);
                        }
                    }
                  } catch (\Throwable $th) {
                    log_message('Error','Error ocuured in for each due to   :'.$th); 
                  }
                return $datalist;
                  // $result = json_decode($datalist, true);     
                   
}

function get_patients_by_doctor_search($id, $searchmob) {
    $admin = $this->session->userdata('admin');
    
    if ($admin['user_role'] == 1)
        $doctor_id = $admin['id'];
    else
        $doctor_id = $admin['doctor_id'];
		
	if ($searchmob == '1') {
		$sqlPatients = "SELECT b.id,b.name,b.contact FROM `doc_user_relation` AS a LEFT JOIN `users` AS b ON a.`patient_id` = b.`id` WHERE a.`doctor_id` = '".$doctor_id."' AND b.`contact` LIKE  '%$id%';";			
		$resPatients = $this->db->query($sqlPatients)->result();
		//echo $sqlPatients;
		//echo '<pre>resPatients '; print_r($resPatients); echo '</pre>';die;			
	} else {		
		$sqlPatients = "SELECT b.id,b.name,b.contact FROM `doc_user_relation` AS a LEFT JOIN `users` AS b ON a.`patient_id` = b.`id` WHERE a.`doctor_id` = '".$doctor_id."' AND b.`name` LIKE  '%$id%';";			
		$resPatients = $this->db->query($sqlPatients)->result();
		//echo $sqlPatients;
		//echo '<pre>resPatients '; print_r($resPatients); echo '</pre>';die;	
	}
	return $resPatients;              
}
    function get_all_patients() {
        $this->db->where('user_role', 2);
        $data = $this->db->get('users')->result();
        foreach ($data as $key => $value) {
            $data[$key]->name = strtoupper($value->name);
        }
        return $data;
    }

    function get_patient_by_id($id) {
        $this->db->where('id', $id);
        $data = $this->db->get('users')->row();
        $data->name = strtoupper($data->name);
        return $data;
    }
    function get_contact_by_id($id) {
        $this->db->where('id', $id);
        $data = $this->db->get('users')->row();
        $data->contact = $data->name;
        return $data;
    }

    function get_patient_filter($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->result();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $save);
    }

    function get_patients_by_invoice($id) {
        $this->db->where('PT.id', $id);
        $this->db->select('F.*,PM.name mode');
        $this->db->order_by('F.dates', 'ASC');
        $this->db->join('users PT', 'PT.id = F.patient_id', 'LEFT');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        return $this->db->get('payment_fees F')->result();
    }

    function get_patients_by_invoice_payment_in($id) {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('invoice !=', '-');
        $this->db->select('*');
        return $this->db->get('payment_fees')->result();
    }

    function histry($id, $doc) {
        $query1 = "(SELECT id,patient_id,other,consultant,date,notes FROM appointments where patient_id='$id' and doctor_id='$doc' ) UNION (SELECT id,patient_id,treatment_Advised_id,consultant,dates,notes FROM payment_fees where patient_id='$id' and doctor_id='$doc' and 	invoice !='-' )  ORDER BY date desc";
		//echo $query1;die;
        $query = $this->db->query($query1);

        return $query->result();
    }

    function doc_name($doc) {
        $query1 = "SELECT name FROM doctor where  id='$doc'";
        $query = $this->db->query($query1);

        return $query->result();
    }

    function get_patients_by_invoice_payment($id) {
        $this->db->where('PT.id', $id);
        $this->db->select('F.*,PM.name mode');
        $this->db->order_by('F.dates', 'ASC');
        $this->db->join('users PT', 'PT.id = F.patient_id', 'LEFT');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        return $this->db->get('payment_fees F')->result();
    }

    function get_patients_by_medication($id) {
        $this->db->where('P.patient_id', $id);
        $this->db->order_by('P.id', 'DESC');
        $this->db->select('P.*,U.name patient,U.dob,U.gender');
        $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
        return $this->db->get('prescription P')->result();
    }

    function delete($id) {//delte client
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->where('patient_id', $id);
        $this->db->delete('doc_user_relation');
    }

    function check_username($username, $id) {

        if ($id) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('contact', $username);
        return $this->db->get('users')->result();
    }

    function save_image($save) {
        $this->db->insert('pimages', $save);
    }

    function get_images($id) {
        $this->db->where('user_id', $id);
        return $this->db->get('pimages')->result();
    }
    function add_note($trtId, $note) {
       $query = $this->db->query("Update payment_fees SET notes ='".$note."' where id=".$trtId."");

       $this->db->query("Update appointments SET notes ='".$note."' where id=".$trtId."");
    }
    function add_payment_note($trtId, $note) {
        $this->db->query("Update payment_fees SET payment_notes ='".$note."' where id=".$trtId."");
       // $this->db->query("Update appointments SET notes ='".$note."' where id=".$trtId."");
     }
	 
	function getCancelAppointment($id) {
        $query1 = "SELECT Color,motive FROM appointments WHERE id='$id'";
        $query = $this->db->query($query1);
        return $query->result();
    }
}
