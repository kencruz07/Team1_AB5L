<?php

class Blog_model extends CI_Model{
	function get_entries($table_name){
		return $this->db->get($table_name)->result();
	}

	function insert_comment($table_name, $data){
		$this->db->insert($table_name, $data);
	}

	function get_comments($table_name, $entry_id, $segment){
		$this->db->where(array($entry_id => $segment));
		return $this->db->get($table_name);
	}
}

?>