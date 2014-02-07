<?php

class Administrator extends CI_Controller{
	public function Administrator(){
		parent::__construct();
		$this->load->model("administrator_model");
	}

	public function index(){
		$data["title"] = "Administrator Home - ICS Library System";
		$this->load->view("administrator_home_view", $data);
	}

	/*
		Changelog for view_accounts()
		1/27
		-Checks if the POST variable 'users' is set, if TRUE, calls delete_accounts method.
		-Parameters of delete_account call is $users, the array containing the users to be deleted.
		1/28
		-Deleted delete_accounts method in administrator controller (redundancy)
		-Action if $users is set is now the previous action of delete_accounts method
	*/
	
	public function view_accounts(){
		$data["title"] = "View Accounts - ICS Library System";
		$this->load->view("view_accounts_view", $data);
		
		$users = $this->input->post('users');
		
		if($users){			
			$this->administrator_model->delete_accounts($users);	
		}
	}

	public function search_accounts(){
		$searchText = $_POST["search_text"];
		$searchCategory = $_POST["category"];

		$accounts = $this->administrator_model->get_search_accounts($searchCategory, $searchText);
		
		if($accounts->num_rows() > 0){
			$data["accounts"] = $accounts->result();
			$data["accountCount"] = $accounts->num_rows();

			$this->load->library('pagination');
			$config['base_url'] = base_url().'administrator/search_accounts';
			$config['total_rows'] = $accounts->num_rows();
			$config['per_page'] = 10; 

			$this->pagination->initialize($config);
		}else{
			$data["accountCount"] = 0;
		}

		if($searchCategory == 'student_number'){
			$searchCategory = "student number";
		}else if($searchCategory == 'employee_number'){
			$searchCategory = "employee number";
		}else if($searchCategory == 'first_name'){
			$searchCategory = "first name";
		}else if($searchCategory == 'last_name'){
			$searchCategory = "last name";
		}

		$data["searchText"] = $searchText;
		$data["searchCategory"] = $searchCategory;
		$data["title"] = "Search Accounts Result - ICS Library System";
 
		$this->load->view("view_accounts_view", $data);
	}
}

?>