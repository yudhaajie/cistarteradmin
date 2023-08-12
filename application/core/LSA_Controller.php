<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LSA_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
		$this->load->model('user_model');
        $this->checkAdminAccess();
    }

    protected function checkAdminAccess() {
        $allowed_controllers = array('Home', 'Auth');
        $allowed_methods = array('frontend', 'signin');

        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        if (!in_array($controller, $allowed_controllers) && !in_array($method, $allowed_methods)) {
            if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
                redirect('auth/login'); // Redirect to login page or access denied page
            }
        }
    }
	private function noDash($str){
		return $str = preg_replace("/[-_]/", " ", $str);
	}
	public function sidebar(){
		$pageLink = $this->uri->segment(2);
		$subPageLink = $this->uri->segment(3);
		$minorPage = $this->uri->segment(4);
		$page = '';
		$subPage = '';
		if($pageLink != Null ) $page = $this->noDash($pageLink);
		if($subPageLink != Null ) $subPage = $this->noDash($subPageLink);
		if($minorPage != Null ) $minorPage = $this->noDash($minorPage);
		return array('page' => $page, 'pageLink' => $pageLink, 'subPage' => $subPage, 'subPageLink' => $subPageLink, 'minorPage' => $minorPage);
	}
	public function breadCrumb(){
		$page = $this->uri->segment(2);
		$subPage = $this->uri->segment(3);
		$minorPage = $this->uri->segment(4);
		return array('page' => $page, 'subPage' => $subPage, 'minorPage' => $minorPage);
	}

}
