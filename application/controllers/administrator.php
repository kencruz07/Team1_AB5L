<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller{
	public function Administrator(){
		parent::__construct();

		//Check if the user is logged-in and is an administrator
		if($this->session->userdata('loggedIn') && $this->session->userdata('userType') != 'A'){
			redirect('home');
		}

		$this->load->model("administrator_model");
	}

	public function index(){
		$data["title"] = "Administrator Home - ICS Library System";
		$this->load->view("administrator_home_view", $data);
	}

	public function view_accounts(){
		$data["title"] = "View Accounts - ICS Library System";
		$this->load->library('pagination');
		
		//Gets the value of the hidden input tags if not NULL
		$searchText = $this->input->post('hidden_search_text');
		$searchCategory = str_replace(" ", "_", $this->input->post('hidden_category'));
		
		//Checks if the user selected a particular sort order
		$sortCategory = $this->input->post('sort_category') ? $this->input->post('sort_category') : 'last_name';
		
		//Sets the item per page
		$itemsPerPage = 10;
		
		//Gets the offset
		$offset = $this->uri->segment(3) < 1 ? 0 : (($this->uri->segment(3)-1)*$itemsPerPage);

		//Checks if the user specified specific search text and category
		if($searchText && $searchCategory){
			$accounts = $this->administrator_model->get_limited_search_accounts($searchCategory, $searchText, $sortCategory, $itemsPerPage, $offset);
			$accountCount = $this->administrator_model->get_search_accounts_count($searchCategory, $searchText);
		}else{
			$accounts = $this->administrator_model->get_all_limited_accounts($sortCategory, $itemsPerPage, $offset);
			$accountCount = $this->administrator_model->get_total_accounts();
		}

		if($accountCount > 0) $data["accounts"] = $accounts->result();

		//Configures pagination if the output count is greater than the items per page
		if($accountCount > $itemsPerPage){
			$config['base_url'] = base_url().'index.php/administrator/view_accounts';
			$config['per_page'] = $itemsPerPage;
			
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			
			$config['prev_link'] = '&lt; &lt; Previous';
			$config['next_link'] = 'Next &gt; &gt;';

			$config['total_rows'] = $accountCount;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = ceil($accountCount/$itemsPerPage);

			$this->pagination->initialize($config);
		}

		$data["accountCount"] = $accountCount;
		$data["offset"] = $offset;
		$data["searchText"] = $searchText;
		$data["searchCategory"] = str_replace("_", " ", $searchCategory);
		$data["sortCategory"] = $sortCategory;
		
		$this->load->view("view_accounts_view", $data);		
	}
	/*
		Changelog for delete_accounts()
		1/27
		-Checks if the POST variable 'users' is set, if TRUE, calls delete_accounts method.
		-Parameters of delete_account call is $users, the array containing the users to be deleted.
		1/28
		-Deleted delete_accounts method in administrator controller (redundancy)
		-Action if $users is set is now the previous action of delete_accounts method
		2/5
		-Restored delete_accounts()
		-Instead of deleting in view_accounts(), will now call view_accounts() from delete_accounts() instead.
		-Redirected to view_accounts() first, to remove .../delete_accounts url, then calls view_accounts().
	*/
	public function delete_accounts(){
		$users = $this->input->post('users');
		
		if($users){			
			$this->administrator_model->delete_accounts($users);	
		}
		redirect('administrator/view_accounts');
		//$this->view_accounts();
	}

	public function search_accounts(){
		if( ! $this->input->post('submit')) redirect('administrator/view_accounts');
		
		$data["title"] = "Search Accounts Result - ICS Library System";
		$this->load->library('pagination');
		
		//Gets the user input from the form
		$searchText = $this->input->post('search_text');
		$searchCategory = $this->input->post('category');
		
		//Sets default sort order
		$orderBasis = 'last_name';

		//Sets the item per page
		$itemsPerPage = 10;

		//Gets the offset
		$offset = $this->uri->segment(3) < 1 ? 0 : (($this->uri->segment(3)-1)*$itemsPerPage);

		$accountCount = $this->administrator_model->get_search_accounts_count($searchCategory, $searchText);
		
		if($accountCount > 0) $data["accounts"] = $this->administrator_model->get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $itemsPerPage, $offset)->result();

		//Configures pagination if the output count is greater than the items per page
		if($accountCount > $itemsPerPage){
			$config['base_url'] = base_url().'index.php/administrator/search_accounts';
			$config['per_page'] = $itemsPerPage;
			
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			
			$config['prev_link'] = '&lt; &lt; Previous';
			$config['next_link'] = 'Next &gt; &gt;';
			
			$config['total_rows'] = $accountCount;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = ceil($accountCount/$itemsPerPage);

			$this->pagination->initialize($config);
		}

		$data["accountCount"] = $accountCount;
		$data["offset"] = $offset;
		$data["searchText"] = $searchText;
		$data["searchCategory"] = str_replace("_", " ", $searchCategory);
		$data["sortCategory"] = $orderBasis;
		
		$this->load->view("view_accounts_view", $data);
	}
	
	
	/*
		Changelog for create_accounts()
		//create_accounts function is for the admin to add account of a admin and librarian
		
		1/29
		-Deleted insert_account function merging it to create_accounts function because of redundancy 
		-isset function used to check the set fields to know which view to invoke
		
	*/
	
	//Erika Kimhoko
	public function create_account(){	
	
		if(isset($_POST['submit'])){
			$employee_no = $_POST["employee_no"];
			$last_name = $_POST["last_name"];
			$first_name = $_POST["first_name"];
			$middle_name = $_POST["middle_name"];
			$user_type = $_POST["user_type"];
			$username = $_POST["username"];
			$password = md5($_POST["password"]);
			$college_address = $_POST["college_address"];
			$email_address = $_POST["email_address"];
			$contact = $_POST["contact"];
			
			
			//call the method in the model to insert the data
			$accounts = $this->administrator_model->insert_account( $employee_no , $last_name, $first_name , $middle_name,
				$user_type , $username, $password, $college_address, $email_address ,$contact );
				
			//if database already contains the same username call the create view again
			if($accounts == 0){
				//data to fill the forms automatically except the username
				$data['employee_no'] = $employee_no;
				$data['last_name'] = $last_name;
				$data['first_name'] = $first_name;
				$data['middle_name'] = $middle_name;
				$data['user_type'] = $user_type;
				$data['college_address'] = $college_address;
				$data['contact'] = $contact;
				$data['email_address'] = $email_address;
				
				//redirect to fill out username, password, email which has the same values
				$this->load->view("create_account_view" , $data);
			}
			else{
				//load the page where the user should be redirected after creating an account
				//edit the view where to redirect to put the prompt of successfully created account
				$data['notification_message'] = "You successfully created the account";
				$data['title'] = "Administrator Home - ICS Library System";
				$this->load->view("administrator_home_view", $data);
			}
		}
		else{
			//first display of the view
			$this->load->view("create_account_view");
		}
	}
	
	//	ZKA MALABUYOC
	public function edit_account(){
		$data["title"]	= "Edit Account - ICS Library System";

		// gets username of account to be edited through the URI
		$uname = $this->uri->segment(3);

		// PARAMETER: $uname
		// array $data contains result of query from administrator_model
		$data['account'] = $this->administrator_model->get_existing_account($uname);

		$this->load->view("edit_accounts_view", $data);
		
	}
	
	public function view_user_profile($username){//function for viewing a user profile
		$this->load->model('administrator_model');	//load administrator model
		if($this->administrator_model->user_exists($username)==1){//if user exists(assuming the admin messes up with the url)
			$data['results']=$this->administrator_model->get_profile($username); //creates a data array that accepts the return value of getProfile
																				// function of administrator model
			$this->load->view('user_profile_view',$data); //load the user_profile view
		}
		else{										//if not found/does not exists
			$this->load->view('not_found_view.html');
		}
	}
	
	//	ZKA MALABUYOC
	public function save_account_changes(){
		//$id = $_POST["id"];
		//$employee_no = $_POST["employee_no"];
		//$stud_no = $_POST["stud_no"];
		$last_name = $_POST["last_name"];
		$first_name = $_POST["first_name"];
		$middle_name = $_POST["middle_name"];
		$user_type = $_POST["user_type"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$college_address = $_POST["college_address"];
		$email_address = $_POST["email_address"];
		$contact = $_POST["contact"];
		$college = $_POST["college"];
		$degree = $_POST["degree"];

		$data['account'] = $this->administrator_model->save_changes($last_name, $first_name, $middle_name,
			$user_type, $username, $password, $college_address, $email_address, $contact, $college, $degree);

		/*if($data == 0){
			echo '<script> alert("Username/password already exists!") </script>';
		}
		else{
			echo '<script> alert("Changes saved!") </script>';
	*/
			$this->load->view("redirect_edit_account_view", $data);
	//	}
	}
	
}

?>