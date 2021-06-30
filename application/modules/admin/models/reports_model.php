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
class reports_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function save($save) {
        $this->db->insert('acts', $save);
    }

    function get_earning_by_dates($date) {
        $admin = $this->session->userdata('admin');

        $this->db->like('F.dates', $date);
        $this->db->where('U.doctor_id', $admin['id']);
        $this->db->select('dates, SUM(amount) amount');
        $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
        return $x = $this->db->get('fees F')->row();

        if (empty($x->dates)) {
            return $date;
        } else {
            return $x;
        }
    }

    function get_earning_by_month() {
        $y = date("Y");
        $m = date("m");
        $d = @cal_days_in_month(CAL_GREGORIAN, $m, $y);
        $admin = $this->session->userdata('admin');

        $this->db->where('dates >=', date("Y-m-d", strtotime("-" . $d . " days")));
        $this->db->where('U.doctor_id', $admin['id']);
        $this->db->group_by('dates', 'ASC');
        $this->db->select('DATE(dates) as date');
        $this->db->select_sum('amount');
        $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
        return $this->db->get('payment_fees F')->result();
    }

    function get_earning_by_week() {
        $admin = $this->session->userdata('admin');
        $this->db->where('dates >=', date("Y-m-d", strtotime("- 7 days")));
        $this->db->where('U.doctor_id', $admin['id']);
        $this->db->group_by('dates', 'ASC');
        $this->db->select('dates');
        $this->db->select_sum('amount');
        $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
        return $this->db->get('payment_fees F')->result();
    }

    function get_earning_by_year() {
        $current_year =  date("Y");
        $next_year =  date('Y',strtotime("+1 year"));

        $admin = $this->session->userdata('admin');
        $this->db->where('F.payment_mode_id <>','-');
        $this->db->where('U.doctor_id', $admin['id']);
        $this->db->where('DATE(dates) >=', date("Y-m-d", strtotime("01-04-".$current_year)));
        $this->db->where('DATE(dates) <=', date("Y-m-d", strtotime("31-03-".$next_year)));
        $this->db->select('YEAR(DATE(dates)) as date');
        $this->db->select_sum('amount');
        $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
        return $this->db->get('payment_fees F')->result();
    }

    function get_earning_by_patient() {
        $admin = $this->session->userdata('admin');

        $this->db->where('U.doctor_id', $admin['id']);

        $this->db->select('dates,U.name, SUM(amount) as amount');
        $this->db->group_by('U.name');
        $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
        return $this->db->get('fees F')->result();
    }

    function dates($date1, $date2, $select_consultant,$select_treatment,$select_group,$excludeDiscount='') {
        //echo $date1.":".$date2;
        $admin = $this->session->userdata('admin');
        $did = $admin['id'];
        if ($select_consultant == ''&&$select_treatment==''&&$select_group=='') {
            $query1 = "SELECT * FROM (`payment_fees` F) LEFT JOIN `users` U ON `U`.`id` = `F`.`patient_id` WHERE `U`.`doctor_id` = '$did' AND date( F.dates ) >= '$date1' AND date(F.dates) <= '$date2'  ";
        } 
        else if($select_consultant != ''&&$select_treatment=='' && $select_group=='') {
            $query1 = "SELECT * FROM (`payment_fees` F) LEFT JOIN `users` U ON `U`.`id` = `F`.`patient_id` WHERE `U`.`doctor_id` = '$did' AND date( F.dates ) >= '$date1' AND date(F.dates) <= '$date2' AND F.consultant = '$select_consultant' ";
        }
        else if($select_consultant == ''&&$select_group==''&& $select_treatment!='')
        {
            $query1 = "SELECT * FROM (`payment_fees` F) LEFT JOIN `users` U ON `U`.`id` = `F`.`patient_id` WHERE `U`.`doctor_id` = '$did' AND date( F.dates ) >= '$date1' AND date(F.dates) <= '$date2' AND  F.treatment_Advised_id = '$select_treatment'";
        }
        else if($select_consultant == ''&&$select_group!=''&& $select_treatment=='')
        {
            $query1 = "SELECT * FROM (`payment_fees` F) LEFT JOIN `users` U ON `U`.`id` = `F`.`patient_id` WHERE `U`.`doctor_id` = '$did' AND date( F.dates ) >= '$date1' AND date(F.dates) <= '$date2' AND  U.group = '$select_group'";
        }
            else if($select_consultant!= ''&&$select_group==''&& $select_treatment!='')
        {
            $query1 = "SELECT * FROM (`payment_fees` F) LEFT JOIN `users` U ON `U`.`id` = `F`.`patient_id` WHERE `U`.`doctor_id` = '$did' AND date( F.dates ) >= '$date1' AND date(F.dates) <= '$date2' AND  F.consultant = '$select_consultant' AND F.treatment_Advised_id = '$select_treatment'";
        }
        else
        {
            $query1 = "SELECT * FROM (`payment_fees` F) LEFT JOIN `users` U ON `U`.`id` = `F`.`patient_id` WHERE `U`.`doctor_id` = '$did' AND date( F.dates ) >= '$date1' AND date(F.dates) <= '$date2' AND F.treatment_Advised_id = '$select_treatment' AND F.consultant = '$select_consultant' AND  U.group = '$select_group'";
        }
		
		#Exclude discount if yes
		if($excludeDiscount != 'yes')
		{
			$query1 .= " AND F.treatment_Advised_id != '\"Discount\"' ";
		}
		
		$query1 .= " ORDER BY `F`.`id` ASC ";
		//echo $query1;die;
        $query = $this->db->query($query1);

        return $query->result();
    }

    function pending_fee($select_consultant) {
        $admin = $this->session->userdata('admin');
        $did = $admin['id'];
        if ($select_consultant == '') {
            $query2 = "SELECT `treatment_Advised_id`,`patient_id`,`doctor_id`,`total`,consultant,SUM(debit) as totaldebit,SUM(credit) as totalcredit FROM ( SELECT * FROM payment_fees WHERE doctor_id =$did  ORDER BY id DESC ) AS x GROUP BY patient_id ";
        } else {
            $query2 = "SELECT `treatment_Advised_id`, `patient_id` , `doctor_id` , `total` ,consultant,SUM(debit) as totaldebit,SUM(credit) as totalcredit FROM ( SELECT * FROM payment_fees WHERE doctor_id =$did  AND consultant = '$select_consultant' ORDER BY id DESC ) AS x GROUP BY patient_id ";
        }
        $queryp = $this->db->query($query2);

        return $queryp->result();
    }

    function p($pid) {
        $this->db->where('id', $pid);

        return $this->db->get('users')->result();
    }

    function consultantbyId($pid) {
        $this->db->where('id', $pid);

        return $this->db->get('consultant')->result();
    }

}
