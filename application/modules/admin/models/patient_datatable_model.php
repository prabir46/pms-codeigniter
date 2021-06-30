<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_datatable_model extends CI_Model {

    var $table = 'users';
    var $relationtable = 'doc_user_relation';
    var $column_order = array(null, 'name', 'address', 'gender', 'dob', 'contact', 'email', 'username'); //set column field database for datatable orderable
    var $column_search = array('name', 'address', 'gender', 'dob', 'contact', 'email', 'username'); //set column field database for datatable searchable 
    var $order = array('DATE(add_date)' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    

    private function _get_datatables_query() {


        $this->db->from($this->relationtable);
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        
       
    }
    private function getUniqueArr($arr1,$arr2){
        $flag = 1;
        // log_message('debug','Flag value :'.$flag);
        try {
            foreach ($arr2 as $key => $value) {
                if(!empty($value) && !empty($arr1)) {
                    if($value->id == $arr1->id){
                        $flag = 0;
                    }
                }
            }
           return $flag;
        } catch (\Throwable $th) {
            log_message('ERROR','Error :'.$th);
        }
       
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
         $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $result1 = array();
                        foreach ($query->result() as $userlist)
                        {
                            $patient_id = $userlist->patient_id;
                            $this->db->where('id',$patient_id);
                            $this->db->where('user_role', 2);
                            $arr=$this->db->get('users')->row(0);
                            $is_unique_user = true;
                            // log_message('debug','Current Result :'.json_encode($arr));
                            if (count($result1) > 0) {
                                $is_unique_user = $this->getUniqueArr($arr,$result1);
                            if($is_unique_user == 1){
                                array_push($result1, $arr);
                            }else{
                                $result1 = array();     
                            }
                            }else{
                                array_push($result1, $arr);  
                            }
                            // log_message('debug','Result count :'.count($result1));
                            $i = 0;
                           if (count($result1) > 0) {
                            foreach ($this->column_search as $item) { // loop column 
                                if ($_POST['search']['value']) { // if datatable send POST for search
                                    if ($i === 0) { // first loop
                                        $this->db->like($item, $_POST['search']['value']);
                                    } else {
                                        $this->db->or_like($item, $_POST['search']['value']);
                                    }
                    
                                    if (count($this->column_search) - 1 == $i); //last loop
                                }
                                $i++;
                            }
                    
                            if (isset($_POST['order'])) { // here order processing
                                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
                            } else if (isset($this->order)) {
                                $order = $this->order;
                                $this->db->order_by(key($order), $order[key($order)]);
                            }
                           }
                            
                        }
                        log_message('debug','Result count :'.count($result1));             
        return $result1;
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('user_role', 2);
        return $this->db->count_all_results();
    }

}
