<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LSA_Controller extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

	public function sidebar($page = Null, $subPage = Null ){
		return array('page' => $page, 'subPage' => $subPage);
	}
	public function breadCrumb($title = Null, $link = Null ){
		return array('title' => $title, 'link' => $link);
	}
    public function coba(){
        echo "coba aja";
    }
}
