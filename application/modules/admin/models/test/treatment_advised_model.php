<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Memento admin_model model
 *
 * This class handles admin_model management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model
 * @author		propertyjar
 * @link		#
 */
class treatment_advised_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function save($save) {
        $this->db->insert('treatment_advised', $save);
    }

    function get_all() {

        return $this->db->get('treatment_advised')->result();
    }

    function get_case_history_by_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        return $this->db->get('treatment_advised')->result();
    }

    function get_case_history_by_doctor_api() {
        $admin['id'] = $this->input->post('id');
        $admin['doctor_id'] = $this->input->post('doctor_id');
        $admin['user_role'] = $this->input->post('user_role');

        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        return $this->db->get('treatment_advised')->result();
    }

    function get_case_history_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('treatment_advised')->row();
    }

    function get_treatment_by_doctor($id) {
        $this->db->where('doctor_id', $id);
        return $this->db->get('treatment_advised')->result();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('treatment_advised', $save);
    }

    function delete($id) {//delte 
        $this->db->where('id', $id);
        $this->db->delete('treatment_advised');
    }

    function get_medical_test_by_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->order_by('name', 'ASC');
        return $this->db->get('treatment_advised')->result();
    }

}
