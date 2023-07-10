<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends LSA_Controller {

	public function index()
	{
		$this->load->view('frontend/comingsoon');
	}
}
