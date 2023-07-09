<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends LSA_Controller {

	public function index()
	{
		$data['bread'] = $this->breadCrumb('Dashboard');
		$data['sidebar'] = $this->sidebar('dashboard');
		$this->load->view('admin/dashboard/index', $data);
	}
}
