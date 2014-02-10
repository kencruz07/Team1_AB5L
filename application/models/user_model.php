<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Model
 *
 * @package	icsls
 * @category Model	
 * @author	CMSC 128 AB-5L Team 1
 */

class User_model extends CI_Model{

	/**
	 * Checks if the user is registered
	 *
	 * @access	public
	 * @param	string, string
	 * @return	boolean
	 */
	public function user_exists($username, $password){
		$this->db->select('username')
				 ->from('users')
				 ->where('username', $username)
				 ->where('password', $password);
		
		$userCount = $this->db->get()->num_rows();
		
		return ($userCount == 1 ? TRUE : FALSE);
	}

	/**
	 * Gets the user data
	 *
	 * @access	public
	 * @param	string, string
	 * @return	array
	 */
	public function get_user_data($username, $password){
		$this->db->select(array('id', 'user_type', 'username')
						 )
				 ->from('users')
				 ->where('username', $username)
				 ->where('password', $password);

		return $this->db->get()->result();
	}
}

?>