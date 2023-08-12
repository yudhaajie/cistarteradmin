<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends LSA_Controller {
	public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

	public function index()
	{
		$data['bread'] = $this->breadCrumb('Dashboard');
		$data['sidebar'] = $this->sidebar('dashboard');
		$this->load->view('admin/dashboard/index', $data);
	}
}
