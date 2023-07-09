<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends LSA_Controller {

	public function index()
	{
		$data['bread'] = $this->breadCrumb('Semua Pos');
		$data['sidebar'] = $this->sidebar('post', 'all-post');
		$this->load->view('admin/post/index', $data);
	}
}
