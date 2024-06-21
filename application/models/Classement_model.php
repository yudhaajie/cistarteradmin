<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classement_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database library
    }
	public function districts($user_id = NULL, $role = Null)
    {
        $this->db->select('rd.name, rd.id, ra.name as area, ra.id as area_id, rg.name as regional, rg.id as regional_id ');
        $this->db->from('regional_district rd');
        $this->db->join('regional_area ra', 'ra.id = rd.regional_area_id');
        $this->db->join('regional rg', 'rg.id = ra.regional_id');
        if($role == 'DSO'){
            $this->db->where('rd.user_id', $user_id);
        }
        if($role == 'RSO'){
            $this->db->where('rg.user_id', $user_id);
        }
		$this->db->order_by('ra.name', 'ASC');
        $this->db->order_by('rd.name', 'ASC');
        $query = $this->db->get();
        return $result = $query->result();
    }
	public function parent_group($district_id){
		$this->db->select('id, name');
		$this->db->from('classements');
		$this->db->where('district_id', $district_id);
		$this->db->order_by('name', 'ASC');
		$data = $this->db->get()->result();
		if($data){
			return $data;
		}else{
			return ['ada'];
		}
	}
	public function match_formats()
    {
        $this->db->select('id, name');
        $this->db->from('match_formats');
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result();
    }
	public function free_teams($district_id, $id = Null)
    {
        $this->db->select('registration_id');
        $this->db->from('classement_teams');
        if($id) $this->db->where('classement_id', $id);
        $sub_query = $this->db->get_compiled_select();

        $this->db->select('r.name, r.id');
        $this->db->from('registration r');
		$this->db->join('participants_quota p', 'p.id = r.participants_quota_id');
		// $this->db->limit(19);
        $this->db->where('p.regional_district_id', $district_id);
        $this->db->where("r.id NOT IN ($sub_query)");
        return $this->db->get()->result();
    }
	public function district_classements($id = Null)
    {
        $this->db->select('name, id');
        $this->db->from('classements');
        $this->db->where('district_id', $id);
        $this->db->where('deleted_date', NULL);
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get()->result();
        $data = array();
        foreach ($result as $row) :
            $data[$row->id] = $this->classement_teams($row->id);
        endforeach;
        return array('clasements' => $result, 'teams' => $data);
    }
    public function classement_teams($id)
    {
        $this->db->select('f.name, f.id');
        $this->db->from('classement_teams c');
        $this->db->join('registration f', 'f.id=c.registration_id');
        $this->db->where('classement_id', $id);
        return $this->db->get()->result();
    }
    public function get_classement($id)
    {
        $this->db->select('name, id, district_id, match_format_id');
        $this->db->from('classements');
        $this->db->where('classements.id', $id);
        $this->db->where('deleted_date', NULL);
        return $this->db->get()->row();
    }
    public function district_teams($district_id, $id)
    {
        $this->db->select('futsal_team_id');
        $this->db->from('classement_teams');
        $this->db->where('clasement_id', $id);
        $sub_query = $this->db->get_compiled_select();

        $this->db->select('name, id');
        $this->db->from('futsal_teams');
        $this->db->where('district_id', $district_id);
        $this->db->where("id NOT IN ($sub_query)");
        return $this->db->get()->result();
    }
    

    public function insert($data)
    {
        $this->db->trans_start();
        $this->db->insert('classements', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        $this->db->cache_delete_all();
        $this->db->trans_status();
        return $insert_id;
    }
    public function insert_team($data)
    {
        $this->db->trans_start();
        $this->db->insert('classement_teams', $data);
        $this->db->trans_complete();
        $this->db->cache_delete_all();
        return $this->db->trans_status();
    }
    public function delete_team($classement_id){
        $this->db->where('classement_id', $classement_id);
        $this->db->delete('classement_teams');
    }
    public function update($id, $data)
    {
        $this->db->trans_start();
        $condition = ['classements.id' => $id];
        $this->db->update('classements', $data, $condition);
        $this->db->trans_complete();
        $this->db->cache_delete_all();
        return $this->db->trans_status();
    }
    public function delete($id, $user)
    {
        $data = [
            'deleted_date' => date('Y-m-d H:i:s'),
            'deleted_by' => $user
        ];
        return $this->update($id, $data);
    }
}
