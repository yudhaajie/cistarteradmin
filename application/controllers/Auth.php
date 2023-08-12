<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends LSA_Controller {

	public function index()
	{
		$data['pageTitle'] = "Login";
		$this->load->view('admin/layouts/header', $data);
		$this->load->view('admin/auth/login', $data);
	}
	public function signIn (){
		 
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			// Process the login form submission
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			 // Validate user's credentials (You should implement your own logic here)
			 if ($this->authenticate($username, $password)) {
				// User authenticated, create a session
				$user = $this->user_model->get_user_by_username($username);
				$user_data = array(
					'username' => $username,
					'logged_in' => TRUE,
					'role' => 'admin',
					'first_name' => $user->first_name,
				);
				
				$this->session->set_userdata($user_data);
				redirect('admin/dashboard'); // Redirect to the dashboard page
			} else {
				$this->session->set_flashdata('error', 'Invalid username or password');
				redirect('auth/login'); // Redirect back to the login page
			}
		} else {
			// Return a "Bad Request" response when accessed via non-POST method
			$this->output->set_status_header(400);
			echo "Bad Request";
		}
	}
	private function authenticate($username, $password) {
		$user = $this->user_model->get_user_by_username($username);
		
		if ($user && $this->verify_sha1($password, $user->password)) {
			return true; // Authentication successful
		}
		
		return false; // Authentication failed
	}
	
	private function verify_sha1($password, $hashedPassword) {
		return sha1($password) === $hashedPassword;
	}
	public function logout() {
        // Destroy the session and log the user out
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
