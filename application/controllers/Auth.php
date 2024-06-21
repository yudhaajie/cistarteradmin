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
		if ($user && password_verify($password, $user->password)) {
			return true; // Authentication successful
		}
		if($this->hash_verify($password, $user->password)) {
			return true;
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
	///ambilin
	public static function encrypt( $string )
    {
        if ( ! empty($string) && (is_string($string) || is_numeric($string)) )
        {
            $salt   = 'dz_framework';
            $flow_1 = base64_encode($string . $salt);
            $flow_2 = preg_replace('/=/', '',  $flow_1);
            $result = urlencode($flow_2);

            return $result;
        }

        return $string;
    }


    /**
     * @abstract Decrypt
     * @param $string
     * @return string
     */
    public static function decrypt( $string )
    {
        $salt   = 'dz_framework';
        $flow_1 = urldecode($string);
        $flow_2 = base64_decode($flow_1);

        $check  = strrpos($flow_2, $salt);
        $result = $string;

        if ( $check !== FALSE )
            $result = substr_replace($flow_2, '', $check, strlen($salt));

        if ( $result === $string )
            return NULL;

        return $result;
    }


    /**
     * @abstract Hash
     * @param $string
     * @return string
     */
    public static function hash( $string )
    {
        $salt    = 'dz_framework';
        $driver  = 'bcrypt';
        $algo    = strtoupper("PASSWORD_{$driver}");
        $options = [];

        if ( $algo == "PASSWORD_BCRYPT" )
        {
            // $bcrypt = static::config('bcrypt');
            // if ( isset($bcrypt['rounds']) )
                $options['cost'] = 10;//$bcrypt['rounds'];
        }
        else if ( $algo == "PASSWORD_ARGON" || $algo == "PASSWORD_ARGON2ID" )
        {
            if ( $algo == "PASSWORD_ARGON" )
                $algo = "PASSWORD_ARGON2I";

            // $argon = static::config('argon');
			$argon = [
				'memory' => 1024,
				'threads' => 2,
				'time' => 2,
			];
            if ( isset($argon['memory']) )
                $options['memory_cost'] = $argon['memory'];

            if ( isset($argon['threads']) )
                $options['threads'] = $argon['threads'];

            if ( isset($argon['time']) )
                $options['time_cost'] = $argon['time'];
        }

        $result  = password_hash("{$string}{$salt}", constant($algo), $options);

        return $result;
    }


    /**
     * @abstract Hash verify
     * @param $string, $string_2
     * @return string
     */
    public static function hash_verify( $string, $string_2 )
    {
        $salt   = 'dz_framework';
        $result = password_verify("{$string}{$salt}", $string_2);

        return $result;
    }


    /**
     * @abstract Get config
     * @param $key
     * @return string
     */
    // private static function config( $key )
    // {
    //     if ( ! static::$config )
    //         static::$config = include('config.php');

    //     if ( isset(static::$config[ $key ] ) )
    //         return static::$config[ $key ];

    //     return NULL;
    // }

	

// return [

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    */

    // 'bcrypt' => [
    //     'rounds' => 10,
    // ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    */

    

    /*
    |--------------------------------------------------------------------------
    | Salt
    |--------------------------------------------------------------------------
    |
    */

    // 'salt' => 'dz_framework',

// ];

}
