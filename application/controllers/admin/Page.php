<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends LSA_Controller {

	public function index()
	{
		$data['sidebar'] = $this->sidebar('page');
		$this->load->view('admin/dashboard/index', $data);
	}
}
