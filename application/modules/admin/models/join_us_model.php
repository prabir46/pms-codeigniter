<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

class join_us_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

        function save($save)
	{
		$this->db->insert('join_us',$save);
	}
}