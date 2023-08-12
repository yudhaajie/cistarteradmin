<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Venues extends LSA_Controller
{
    public function __construct()
    {
        parent::__construct('admin');
        $this->load->model('model_venue');
    }

    public function index()
    {
        
		$data['pageTitle'] = "Venues";
		$data['sidebar'] = $this->sidebar();
		$data['bread'] = $this->breadCrumb('Venues');
		return $this->load->view('admin/elimination/venue/index', $data);
    }

   
    public function update_status($id){
        
        $status = $this->uri->segment(6);
       // exit();
        $data['status'] = $status;
        $result = $this->model_venue->update_status($id, $data);
        // }

        if (!$result)
            $this->session->set_flashdata('notif', lang('notif_not_updated'));
        return redirect('home');
    }
    /**
     * @abstract Serverside load table
     * @return json
     */
    public function loadTable()
    {
        $this->load->model('model_datatables');

        $table        = "venues";
        $condition    = ['venues.deleted_date IS NULL'];
        $row          = ['[number]', 'regional_district.name as district', 'venues.name', 'venues.location', 'venues.id'];
        $row_search   = ['regional_district.name as district', 'venues.name', 'venues.location'];
        $join         = ['regional_district' => 'regional_district.id = venues.district_id'];
        $order        = ['venues.name' => 'ASC'];
        $groupby      = [];
        $limit        = NULL;
        $offset       = NULL;
        $distinct     = FALSE;

        /* Get Data */
        $output = $this->model_datatables->loadTableServerSide($table, $condition, $row, $row_search, $join, $order, $groupby, $limit, $offset, $distinct);
        echo json_encode($output);
    }

    public function create()
    {
        $is_admin = $this->admin_userdata->is_superadmin > 1;
        $user_id = Null;
        $role = Null;
        $userdata = $this->session->user('admin');
        if (!$is_admin) {
            $user_id = $userdata->user;
            $user = $this->model_user->get($user_id);
            $role = $user->role;
        }
        $data['districts'] = $this->model_venue->districts($user_id, $role);

        return $this->load->view('admin/elimination/venue/create', $data);
    }

    public function store()
    {
        if ($this->input->method() == "post") {
            $date       = date('Y-m-d H:i:s');
            $userdata   = $this->session->user('admin');
            $district_id       = $this->input->post('district');
            $name       = $this->input->post('name');
            $location = $this->input->post('location');

            $data['district_id']  = $district_id;
            $data['name']         = $name;
            $data['location']   = $location;
            $data['created_date'] = $date;
            $data['created_by']   = $userdata->user;

            $result = $this->model_venue->insert_venue($data);


            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_saved'));

            return redirect();
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }

    public function edit($id)
    {
        // $venue = urldecode($id);
        $result = $this->model_venue->get_venue($id);

        if ($result) {
            $data['id']        = $id;
            $data['result']    = $result;
            $is_admin = $this->admin_userdata->is_superadmin > 1;
            $user_id = Null;
            $role = Null;
            $userdata = $this->session->user('admin');
            if (!$is_admin) {
                $user_id = $userdata->user;
                $user = $this->model_user->get($user_id);
                $role = $user->role;
            }
            $data['districts'] = $this->model_venue->districts($user_id, $role);

            return $this->load->view('admin/elimination/venue/edit', $data);
        }

        $this->session->set_flashdata('notif', lang('notif_not_found'));

        return redirect();
    }

    public function update($id)
    {
        if ($this->input->method() == "post") {
            $date           = date('Y-m-d H:i:s');
            $userdata       = $this->session->user('admin');
            $district_id    = $this->input->post('district');
            $name           = $this->input->post('name');
            $location       = $this->input->post('location');
            // $venue_id       = $this->input->post('venue_id');
            // $venue = urldecode($id);
            // $result = FALSE;
            // $get    = $this->model_venue->get_venue($venue);

            // if ( $get )
            // {

            $data['district_id']    = $district_id;
            $data['name']           = $name;
            $data['location']       = $location;
            $data['updated_date']   = $date;
            $data['updated_by']     = $userdata->user;


            $result = $this->model_venue->update_venue($id, $data);
            // }

            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_updated'));

            return redirect();
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }

    public function destroy($id)
    {

        $userdata = $this->session->user('admin');
        $result   = $this->model_venue->delete($id, $userdata->user);

        if (!$result)
            $this->session->set_flashdata('notif', lang('notif_not_deleted'));

        return redirect();
    }

    public function list()
    {
        $district_id = $this->input->post('district_id');
        $venues = $this->model_venue->district_venues($district_id);

        $lists = "<option value=''>Pilih</option>";

        foreach ($venues as $data) {
            $lists .= "<option value='" . $data->id . "'>" . $data->name . "</option>";
        }

        $callback = array('list_kota' => $lists);
        echo json_encode($callback);
    }
}
