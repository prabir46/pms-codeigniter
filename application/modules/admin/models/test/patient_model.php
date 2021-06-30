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

    function get_username() {
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
        $this->db->insert('users', $save);
        return $this->db->insert_id();
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
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_by_doctor_id($id) {
        $this->db->where('doctor_id', $id);
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('id', $admin['id']);
        } else {
            $this->db->where('id', $admin['doctor_id']);
        }
        $this->db->where('user_role', 1);
        return $this->db->get('users')->row();
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


        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_by_assistant() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['doctor_id']);
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
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
            return $this->db->get('users')->result();
        }

        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('id', $id);
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_by_doctor_search($id) {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where("name LIKE  '%$id%' or contact LIKE  '%$id%'");
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_all_patients() {
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patient_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
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
        $this->db->order_by('F.invoice', 'DESC');
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
        $query1 = "(SELECT id,patient_id,other,consultant,date FROM appointments where patient_id='$id' and doctor_id='$doc' ) UNION (SELECT id,patient_id,treatment_Advised_id,consultant,dates FROM payment_fees where patient_id='$id' and doctor_id='$doc' and 	invoice !='-' )  ORDER BY date desc";
        $query = $this->db->query($query1);

        return $query->result();
    }

    public function histry_api($id, $doc) {

        $this->db->where('A.patient_id', $id);
        $this->db->where('A.doctor_id', $doc);
        $this->db->select('A.id,A.patient_id,A.other,A.consultant,A.date,C.name consultant_name');
        $this->db->order_by('A.date', 'DESC');
        $this->db->join('consultant C', 'C.id = A.consultant', 'LEFT');
        $array1 = $this->db->get('appointments A')->result();

        $this->db->where('A.patient_id', $id);
        $this->db->where('A.doctor_id', $doc);
        $this->db->where('A.invoice !=', '-');
        $this->db->select('A.id,A.patient_id,A.treatment_Advised_id other,A.consultant,A.dates date,C.name consultant_name');
        $this->db->order_by('date', 'DESC');
        $this->db->join('consultant C', 'C.id = A.consultant', 'LEFT');
        $array2 = $this->db->get('payment_fees A')->result();

        $result = array_merge($array1, $array2);
        $result = json_decode(json_encode($result), true);
        foreach ($result as $key => $value) {

            if ($value['other'] == null) {
                $result[$key]['other'] = '';
            } elseif ($value['other'] == '') {
                $result[$key]['other'] = '';
            } else {
                $result[$key]['other'] = preg_replace('/[^A-Za-z0-9\-]/', '', $value['other']);
            }

            if ($value['consultant_name'] == null) {
                $result[$key]['consultant_name'] = '';
            }
        }
        array_multisort(array_column($result, "date"), SORT_DESC, $result);
        return $result;
    }

    function doc_name($doc) {
        $query1 = "SELECT name FROM users where  id='$doc'";
        $query = $this->db->query($query1);

        return $query->result();
    }

    function get_patients_by_invoice_payment($id) {
        $this->db->where('PT.id', $id);
        $this->db->select('F.*,PM.name mode');
        $this->db->order_by('F.id', 'ASC');
        $this->db->join('users PT', 'PT.id = F.patient_id', 'LEFT');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        return $this->db->get('payment_fees F')->result();
    }

    public function get_patients_by_invoice_payment_api($id) {
        $this->db->where('PT.id', $id);
        $this->db->select('F.*,PM.name mode,CM.name consultant_name');
        $this->db->order_by('F.id', 'ASC');
        $this->db->join('consultant CM', 'F.consultant = CM.id', 'LEFT');
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

    public function get_patients_by_medication_api($id) {
        $this->db->where('P.patient_id', $id);
        $this->db->order_by('P.id', 'DESC');
        $this->db->select('P.id,P.chiff_Complaint_history,P.medicines,U.name patient,U.dob,U.gender');
        $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
        $data = $this->db->get('prescription P')->result();

        $result = json_decode(json_encode($data), true);
        foreach ($result as $key => $value) {

            if (is_array(json_decode(strip_tags($value['chiff_Complaint_history']))))
                $result[$key]['chiff_Complaint_history'] = json_decode(strip_tags($value['chiff_Complaint_history']));
            else
                $result[$key]['chiff_Complaint_history'] = array(strip_tags($value['chiff_Complaint_history']));

            if ($value['chiff_Complaint_history'] === NULL)
                $result[$key]['chiff_Complaint_history'] = '';


            $result[$key]['medicines'] = explode(',', preg_replace('/[^A-Za-z0-9\-\s,]/', '', strip_tags($value['medicines'])));
        }
        return $result;
    }

    function delete($id) {//delte client
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    function check_username($username, $id) {

        if ($id) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('username', $username);
        return $this->db->get('users')->result();
    }

    function save_image($save) {
        $this->db->insert('pimages', $save);
    }

    function get_images($id) {
        $this->db->where('user_id', $id);
        return $this->db->get('pimages')->result();
    }

   public function get_patient_balance($id) {
        $this->db->where('F.patient_id', $id);
        $this->db->group_by('F.patient_id');
        $this->db->select_sum('F.credit');  
        $this->db->select_sum('F.debit');
        $this->db->select('(sum(F.credit) - sum(F.debit)) as pending');
        return $this->db->get('payment_fees F')->row();
    }

}
