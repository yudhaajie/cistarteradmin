<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTable_model extends CI_Model {

	public function count_all_data() {
        return $this->db->count_all('user');
    }

    public function count_filtered_data($search) {
        $this->_get_filtered_data($search);
        return $this->db->count_all_results();
    }

    private function _get_filtered_data($search) {
        // Apply filters, sorting, etc.
        $this->db->select('*');
        $this->db->from('user');
        
        if (!empty($search)) {
            $this->db->like('username', $search);
			$this->db->or_like('id', $search);
        }
        
        // Add filters, sorting, etc. here
    }

    public function get_data($start, $length, $order, $search) {
        $this->_get_filtered_data($search);
        
        if (!empty($order)) {
			switch ($order[0]['column']) {
				case 0: // Sort by ID
					$this->db->order_by('id', $order[0]['dir']);
					break;
				case 1: // Sort by Name
					$this->db->order_by('username', $order[0]['dir']);
					break;
					
				// Add more cases for other columns as needed
			}
		}

        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
}
