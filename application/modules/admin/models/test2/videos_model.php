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

class videos_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('videos',$save);
	}
	
	function search_by_title($term)
	{			
		if($term!='')
		{		$this->db->select('title,link,key');
				$this->db->like('title', $term);
        		return $query = $this->db->get('videos')->result();
    	}
    	else{
    			$this->db->select('title,link,key');
    		return $query = $this->db->get('videos')->result();
    	}
	}


	function search($term)
	{			
		if($term!='')
		{		$this->db->select('title');
				$this->db->like('title', $term);
             	$this->db->or_like('key', $term);
             	$this->db->or_like('link', $term);
        return $query = $this->db->get('videos')->result();
    	}
    	else{
    			$this->db->select('title');
    		return $query = $this->db->get('videos')->result();
    	}
	}

	function get_all()
	{
			return $this->db->get('videos')->result();
	}
	
	function get_act_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('videos')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('key',$id);
		       $this->db->update('videos',$save);
	}
	
	
	function delete($id)//delte client
	{
			   $this->db->where('key',$id);
		       $this->db->delete('videos');
	}
}