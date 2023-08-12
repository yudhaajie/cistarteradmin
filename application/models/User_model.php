<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database library
    }

	public function get_user_by_username($username) {
        $this->db->select('user.*, user_detail.first_name'); 
        $this->db->from('user');
        $this->db->join('user_detail', 'user_detail.user_id = user.id');
        $this->db->where('user.username', $username);

        $query = $this->db->get();
        return $query->row(); // Return a single row
    }
}
