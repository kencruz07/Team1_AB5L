<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Administrator Model
 *
 * @package	icsls
 * @category Model	
 * @author	CMSC 128 AB-5L Team 1
 */

class Administrator_model extends CI_Model{

	/**
	 * Counts the total number of existing accounts
	 *
	 * @access	public
	 * @param	none
	 * @return	integer
	 */
	public function get_total_accounts()
	{
		return $this->db->count_all('users');
	}

	/**
	 * Gets limited number of accounts sorted based on a specific criteria, limit and offset
	 *
	 * @access	public
	 * @param	string, integer, integer
	 * @return	array
	 */
	public function get_all_limited_accounts($orderBasis, $limit, $offset)
	{
		$this->db->select(array('employee_number', 'student_number', 'username', 'last_name', 
				 		 		'first_name', 'middle_name', 'user_type')
						 )
				 ->from('users')
				 ->order_by($orderBasis, 'asc')
				 ->limit($limit, $offset);
		
		return $this->db->get();
	}

	/**
	 * Counts the number of accounts matching the search criteria
	 *
	 * @access	public
	 * @param	string, string
	 * @return	array
	 */
	public function get_search_accounts_count($searchCategory, $searchText)
	{
		$this->db->select('username')
				 ->from('users')
				 ->where($searchCategory, $searchText);

		return $this->db->get()->num_rows();
	}

	/**
	 * Gets limited number of accounts matching the search criteria based on search criteria and offset
	 *
	 * @access	public
	 * @param	string, string, string, integer, integer
	 * @return	array
	 */
	public function get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $limit, $offset)
	{
		$this->db->select(array('employee_number', 'student_number', 'username', 'last_name', 
				 		 		'first_name', 'middle_name', 'user_type')
						 )
				 ->from('users')
				 ->where($searchCategory, $searchText)
				 ->order_by($orderBasis, 'asc')
				 ->limit($limit, $offset);
		
		return $this->db->get();
	}
	
	/*
		Changelog for delete_accounts method
		1/28
		-Created delete_accounts method to be used for the Delete Users module.
		-delete_accounts method accesses the database and deletes rows depending on $users array.
		-Parameters of delete_account call is $users, the array containing the users to be deleted.
		-In the foreach loop, it checks individually (per row, or per user) if it is a student or employee.
		-It compares the value of the checkbox. If value has a '-' in $value[4] (e.g. ****-*****), it deletes a row where student_number == $value. Else if it has no '-', deletes a row where employee_number == $value
		2/5
		-Used username column instead.
	*/
	
	public function delete_accounts($users){
		foreach($users as $value)
        {
			$this->db->delete('users', array('username' => $value));
        }
	}
	
	
	
	/* Parameters:
		a. $employee_no , $last_name , $first_name , $middle_name , $user_type , $username , $password , $college_address , $email_address , $contact -
			values of the user to be inserted in to the database	
	
		Description: Function which inserts the user details in to the database
		Return value: 1 if successfully inserted the account else 0
		Created by: Erika Kimhoko, January 29, 2014
	*/

	public function insert_account( $employee_no , $last_name, $first_name , $middle_name,
			$user_type , $username, $password, $college_address, $email_address ,$contact ){
		
			//check if there is the same username 
			//to ensure no duplicates in username to avoid problems in log in
			$name =  $this->db->query("SELECT username FROM users WHERE username='$username' ");
			
			if($name->num_rows() == 0){
				//insert
				$this->db->query("INSERT INTO users 
				(employee_number, last_name, first_name, middle_name, user_type , username, password, college_address, email_address, contact_number) 
				VALUES 
				('$employee_no' , '$last_name', '$first_name' , '$middle_name','$user_type' , '$username', '$password', '$college_address', '$email_address' ,'$contact')");
				return 1;
			}
			else{
				return 0;
			}
	}
	
	public function get_profile($username){ //returns the profile of the chosen user
		$query=$this->db->query("SELECT * FROM users WHERE username='$username'");
		return $query->result();
	}
	
	//	ZKA MALABUYOC
	public function get_existing_account($uname){ // selects and returns user info with username = $uname
		 $userInfo = $this->db->query("SELECT * FROM users WHERE username = '$uname'");

		 foreach ($userInfo->result() as $item){
		 	// store in array data all existing user info
		 	$data[] = $item;
		 }
		 return $data;
	}
	
	public function save_changes($employee_no, $stud_no, $last_name, $first_name, $middle_name, 
		$user_type, $username, $password, $college_address, $email_address, $contact, $college, $degree){

		//$username =  $this->db->query("SELECT username FROM users WHERE username='$username' ");
		//$password =  $this->db->query("SELECT password FROM users WHERE password='$password' ");
		
		//if($username->num_rows() == 0 && $password->num_rows() == 0){
				$this->db->query("UPDATE users 
				SET (last_name = '$last_name', first_name = '$first_name', 
				middle_name = '$middle_name', user_type = '$user_type', username = '$username', password = '$password', 
				college_address = '$college_address', email_address = '$email_address', contact_number = '$contact',
				college = '$college', degree = '$degree')
				WHERE username = '$username'");
				/*WHERE (last_name = '$last_name', first_name = '$first_name', 
				middle_name = '$middle_name', user_type = '$user_type', username = '$username', password = '$password', 
				college_address = '$college_address', email_address = '$email_address', contact_number = '$contact',
				college = '$college', degree = '$degree'");*/
				/*return 1;
			}
			else 	return 0;*/


	}
	
	/* Parameters:
		a. $username - value of username entered
		Description: Checks if the user is registered
		Return value: Boolean value if the user exists or not
	*/
	public function user_exists($username){
		$userCount = $this->db->query("SELECT * FROM users WHERE username='$username'")->num_rows();

		return ($userCount == 1 ? true : false);
	}
}

?>