<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	public function Login(){
		parent::__construct();
	}

	public function index(){
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		//Checks if the user is registered
		if($this->user_model->user_exists($username, $password)){
			$userData = $this->user_model->get_user_data($username, $password);

			$sessionData = array(
				'loggedIn' => TRUE,
				'id' => $userData[0]->id,
				'userType' => $userData[0]->user_type,
				'username' => $userData[0]->username
				);

			$this->session->set_userdata($sessionData);

			//Loads the view depending on the user type
			if($userData[0]->user_type == 'A')
				redirect("administrator");
			else if($userData[0]->user_type == 'L')
				redirect("librarian");
			else if($userData[0]->user_type == 'F' || $userData[0]->user_type == 'S')
				redirect("home");
		}else{
			$data['title'] = 'Login Failed - ICS Library System';
			$this->load->view('login_view', $data);
		}
	}
}

?>