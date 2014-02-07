<?php

class Administrator_model extends CI_Model{

	/* Parameters:
		a. $userType - User type of the account
		Description: Returns the query result containing all users with desired user type
		Return value: Array of information containing the result of the query
	*/
	public function get_all_accounts(){
		return $this->db->query("SELECT * FROM users ORDER BY last_name");
	}
	
	/*
		Changelog for delete_accounts method
		-Created delete_accounts method to be used for the Delete Users module.
		-delete_accounts method accesses the database and deletes rows depending on $users array.
		-Parameters of delete_account call is $users, the array containing the users to be deleted.
		-In the foreach loop, it checks individually (per row, or per user) if it is a student or employee.
		-It compares the value of the checkbox. If value has a '-' in $value[4] (e.g. ****-*****), it deletes a row where student_number == $value. Else if it has no '-', deletes a row where employee_number == $value
	*/
	
	public function delete_accounts($users){
		foreach($users as $value)
        {
			if($value[4] == '-'){
				$this->db->delete('users', array('student_number' => $value));
			}
			else{
				$this->db->delete('users', array('employee_number' => $value));
			}
			 
        }
	}
	
	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		Description: Returns all account information of the matching user/s
		Return value: Array of information containing the result of the query
	*/
	public function get_search_accounts($searchCategory, $searchText){
		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' ORDER BY last_name ASC");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' ORDER BY last_name ASC");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' ORDER BY last_name ASC");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText' ORDER BY last_name ASC");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' ORDER BY last_name ASC");
		}
	}

	public function get_sorted_accounts($searchCategory, $searchText, $orderBasis){
		
	}
}

?>