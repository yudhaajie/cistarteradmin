<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_venue extends CI_Model
{

    public function districts($user_id = NULL, $role = Null)
    {
        $this->db->select('regional_district.name, regional_district.id');
        $this->db->from('regional_district');
        $this->db->join('regional_area', 'regional_area.id = regional_district.regional_area_id');
        $this->db->join('regional', 'regional.id = regional_area.regional_id');
        if($role == 'DSO'){
            $this->db->where('regional_district.user_id', $user_id);
        }
        if($role == 'RSO'){
            $this->db->where('regional.user_id', $user_id);
        }
        $this->db->order_by('regional_district.name', 'ASC');
        $query = $this->db->get();
        return $result = $query->result();
    }
    public function venues()
    {
        $this->db->select('id, name, location, district_id');
        $this->db->from('venues');
        $this->db->where('deleted_date', Null);
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result();
    }
    public function get_venue($id)
    {
        $this->db->select('name, location, district_id, id');
        $this->db->from('venues');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    public function district_venues($id)
    {
        $this->db->select('name, location, district_id, id');
        $this->db->from('venues');
        $this->db->where('district_id', $id);
        $this->db->where('deleted_date', Null);
        return $this->db->get()->result();
    }
    public function insert_venue($data)
    {
        $this->db->trans_start();
        $this->db->insert('venues', $data);
        $this->db->trans_complete();
        $this->db->cache_delete_all();
        return $this->db->trans_status();
    }
    public function update_venue($id, $data)
    {
        $this->db->trans_start();
        $condition = ['venues.id' => $id];
        $this->db->update('venues', $data, $condition);
        $this->db->trans_complete();
        $this->db->cache_delete_all();
        return $this->db->trans_status();
    }
    public function update_status($id, $data)
    {
        $this->db->trans_start();
        $condition = ['registration_payment.registration_id' => $id];
        $this->db->update('registration_payment', $data, $condition);
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
        return $this->update_venue($id, $data);
    }
}
