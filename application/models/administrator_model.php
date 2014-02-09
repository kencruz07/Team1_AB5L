<?php

class Administrator_model extends CI_Model{

	/* Parameters:
		a. $orderBases - Column sorting order
		Description: Returns the query result containing all users
		Return value: Array of information containing the result of the query
	*/
	public function get_all_accounts($orderBasis){
		return $this->db->query("SELECT * FROM users ORDER BY $orderBasis");
	}

	/* Parameters:
		a. $orderBases - Column sorting order
		b. $limit - Limit of the result
		c. $offset - Starting point
		Description: Returns the query result containing all users but limited for pagination
		Return value: Array of information containing the result of the query
	*/
	public function get_all_limited_accounts($orderBasis, $limit, $offset){
		// $this->db->order_by($orderBasis);
		return $this->db->query("SELECT * FROM users ORDER BY $orderBasis ASC LIMIT $limit OFFSET $offset");
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		Description: Returns all account information of the matching user/s
		Return value: Array of information containing the result of the query
	*/
	public function get_search_accounts($searchCategory, $searchText){
		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText'");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText'");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText'");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText'");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText'");
		}
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		c. $orderBasis - Column basis for sorting
		d. $limit - Result count limit
		e. $offset - Number of items to skip
		Description: Returns limited account information of the matching user/s
		Return value: Array of information containing the result of the query
	*/
	public function get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $limit, $offset){
		$this->db->query("SELECT * FROM users ORDER BY $orderBasis ASC");

		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText'");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' LIMIT $limit OFFSET $offset");
		}
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		c. $orderBasis - Column as basis for sorting
		Description: Returns all account information sorted based on category
		Return value: Array of information containing the result of the query
	*/
	public function get_sorted_search_accounts($searchCategory, $searchText, $orderBasis){
		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' ORDER BY $orderBasis ASC");
		}
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		c. $orderBasis - Column as basis for sorting
		d. $limit - Limit of the result
		e. $offset - Starting point
		Description: Returns account information based on search text, category sorted based on category but limited for pagination
		Return value: Array of information containing the result of the query
	*/
	public function get_limited_sorted_search_accounts($searchCategory, $searchText, $orderBasis, $limit, $offset){
		$this->db->query("SELECT * FROM users ORDER BY $orderBasis ASC");

		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' LIMIT $limit OFFSET $offset");
		}
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
	
	public function user_exists($username){
		$userCount = $this->db->query("SELECT * FROM users WHERE username='$username'")->num_rows();

		return ($userCount == 1 ? true : false);
	}
}

?>