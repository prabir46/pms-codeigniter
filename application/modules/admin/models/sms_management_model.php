<?php
Class sms_management_model extends CI_Model
{
	function __construct()
	{
			parent::__construct();
	}

        function create($id)
        {
             $data['doctor_id']=$id;
             $data['status']='1';
             $data['lang']='english';
             $data['type']='instant';
             $this->db->insert('sms',$data);
             $data['type']='doctor';
             $this->db->insert('sms',$data);
             $data['type']='patient';
             $this->db->insert('sms',$data);
        }
	
	
	function get_list()
	{
                $admin = $this->session->userdata('admin');
                if($admin['user_role']==1){
                   $id = $admin['id'];
                }
                else $id = $admin['doctor_id'];
                $this->db->where('doctor_id', $id);
		$res = $this->db->get('sms');
		return $res->result_array();
	}

        function get_delivery_reports()
        {
                $admin = $this->session->userdata('admin');
                if($admin['user_role']==1){
                   $id = $admin['id'];
                }
                else $id = $admin['doctor_id'];
                $this->db->where('doctor_id', $id);
		$res = $this->db->get('sms_history');
		return $res->result_array();
         }
	
	function get_instant_by_doctor($id)
	{
                $this->db->where('type','instant');
		$res = $this->db->where('doctor_id', $id)->get('sms');
		return $res->result_array();
	}

	function get_doctor_by_doctor($id)
	{
                $this->db->where('type','doctor');
		$res = $this->db->where('doctor_id', $id)->get('sms');
		return $res->result_array();
	}

	function get_patient_by_doctor($id)
	{
                $this->db->where('type','patient');
		$res = $this->db->where('doctor_id', $id)->get('sms');
		return $res->result_array();
	}
 
        function get_sms_count($doctor_id)
        {
                $this->db->where('id', $doctor_id);
                return $this->db->get('users')->row();
        }
        
        function update_sms_limit($doctor_id)
        {
                $row = $this->db->where('id', $doctor_id)->get('users')->row();
                $sms_count = $row->sms_limit;
                $sms_count = $sms_count - 1;
                $this->db->where('id', $doctor_id)->update('users', array('sms_limit' => $sms_count));
        }
	
	function save_message($data)
	{
		if($data['id'])
		{
			$this->db->where('id', $data['id'])->update('sms', $data);
			return $data['id'];
		}
		else 
		{
			$this->db->insert('sms', $data);
			return $this->db->insert_id();
		}
	}

        function create_sms_history($doctor_id, $patient_id, $consultant_id, $type)
        {
               $data['doctor_id'] = $doctor_id;
               $data['patient_id'] = $patient_id;
               $data['consultant'] = $consultant_id;
               $data['type'] = $type;
               date_default_timezone_set("Asia/Kolkata");
               $data['date'] = date("Y-m-d H:i:00",strtotime('now'));
               $this->db->insert('sms_history', $data);
        }

       function update_sms_count($doctor_id, $sms_count)
       {
            $this->db->where('id', $doctor_id)->update('users', array('sms_limit' => $sms_count));
       }

       function update($id, $data)
       {
           $this->db->where('id',$id);
           $this->db->update('sms', $data);
       }
	
	function delete_message($id)
	{
		$this->db->where('id', $id)->delete('sms');
		return $id;
	}
	
	
}