<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataTable_model extends CI_Model
{

	public function count_all_data()
	{
		return $this->db->count_all('classements');
	}

	public function count_filtered_data($search)
	{
		$this->_get_filtered_data($search);
		return $this->db->count_all_results();
	}

	private function _get_filtered_data($search)
	{
		// Apply filters, sorting, etc.
		$this->db->select('c.*, c.id as classid, d.name as district, m.name as format');
		$this->db->from('classements c');
		// Join with the other_table using INNER JOIN
		$this->db->join('regional_district d', 'c.district_id = d.id', 'inner');
		$this->db->join('match_formats m', 'c.match_format_id = m.id', 'inner');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('c.name', $search);
			$this->db->or_like('c.id', $search);
			$this->db->or_like('d.name', $search); // Search for district name
			$this->db->or_like('m.name', $search); // Search for match name
			$this->db->group_end();
		}

		// Add filters, sorting, etc. here
	}

	public function get_data($start, $length, $order, $search)
	{
		$this->_get_filtered_data($search);

		if (!empty($order)) {
			switch ($order[0]['column']) {
				case 0: // Sort by No (use database column alias)
					$this->db->order_by('id', $order[0]['dir']);
					break;
				case 1: // Sort by District (use the alias defined in the _get_filtered_data function)
					$this->db->order_by('district', $order[0]['dir']);
					break;
				case 2: // Sort by Name (use the alias defined in the _get_filtered_data function)
					$this->db->order_by('name', $order[0]['dir']);
					break;
				case 3: // Sort by Name (use the alias defined in the _get_filtered_data function)
					$this->db->order_by('format', $order[0]['dir']);
					break;

					// Add more cases for other columns as needed
			}
		}

		$this->db->limit($length, $start);
		$query = $this->db->get();
		return $query->result();
	}
}
