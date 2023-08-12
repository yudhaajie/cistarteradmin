<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Classement extends LSA_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('classement_model');
    }
//index
    public function index()
    {
        $data['sidebar'] = $this->sidebar();
		$data['bread'] = $this->breadCrumb();
        return $this->load->view('admin/elimination/clasement/index', $data);
    }
   
    public function district_team_list()
    {
        $ids = $this->input->post('district_id');
        $id = explode('-', $ids);
        $district_id = $id[0];
        $teams = $this->clasement_model->free_teams($district_id);

        $lists = "<div class='col-12 ps-5'>";

        foreach ($teams as $data) {
            $lists .= "<input type='checkbox' name='teams[]' id='tim" . $data->id . "' class='form-check-input' value='" . $data->id . "'> <label class='form-check-label' for='tim" . $data->id . "'>" . $data->name . "<br>";
        }
        $lists .= "</div>";
        $callback = array('list_kota' => $lists);
        echo json_encode($callback);
    }

   

    public function create_clasement()
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

        $data['formats'] = $this->model_match->match_formats();
        return $this->load->view('admin/elimination/clasement/create', $data);
    }
    public function store_clasement()
    {
        if ($this->input->method() == "post") {
            $date           = date('Y-m-d H:i:s');
            $userdata       = $this->session->user('admin');
            $region_ids   = $this->input->post('district');
            $title          = $this->input->post('title');
            $format_id         = $this->input->post('format');
            $region_id = explode('-', $region_ids);
            $district_id = $region_id[0];
            $regional_id = $region_id[1];
            $teams = $this->input->post('teams');

            //insert clasement

            $data['match_format_id'] = $format_id;
            $data['regional_id'] = $regional_id;
            $data['district_id'] = $district_id;
            $data['user_id'] = $userdata->user;
            $data['name'] = $title;
            $data['created_date'] = $date;
            $data['created_by'] = $userdata->user;
            $clasement_id =  $this->clasement_model->insert($data);
            //insert team
            $result = '';
            foreach ($teams as $id) {
                $data = array();
                $data['clasement_id'] = $clasement_id;
                $data['futsal_team_id'] = $id;
                $data['created_date'] = $date;
                $data['created_by'] = $userdata->user;
                $result .= $this->clasement_model->insert_team($data);
            }
            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_saved'));

            return redirect('admin/eliminations/matches/clasement_match/'.$clasement_id);
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }
    public function edit_clasement($id)
    {
        $data['clasement'] = $this->clasement_model->get_clasement($id);
        $district_id = $data['clasement']->district_id;
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

        $data['formats'] = $this->model_match->match_formats();
        $data['clasement_teams'] = $this->clasement_model->clasement_teams($id);
        $data['teams'] = $this->clasement_model->free_teams($district_id);
        $data['id']     = $id;
        $this->load->view('admin/elimination/clasement/edit', $data);
    }
    public function update_clasement($id)
    {
        if ($this->input->method() == "post") {
            $date       = date('Y-m-d H:i:s');
            $title = $this->input->post('title');
            $userdata   = $this->session->user('admin');
            $teams = $this->input->post('teams');
            $result = FALSE;

            $get    = $this->clasement_model->get_clasement($id);

            if ($get) {

                $data['name'] = $title;
                $data['user_id']   = $userdata->user;
                $data['updated_date']   = $date;
                $data['updated_by']     = $userdata->user;

                $result = $this->clasement_model->update($id, $data);
                $result = '';
                $team = $this->clasement_model->clasement_teams($id);
                foreach ($teams as $team_id) {
                    echo $team_id;
                }
                // exit();
                if($team and $teams!=[])  $delete = $this->clasement_model->delete_team($id);
               
                    foreach ($teams as $team_id) {
                        $data = array();
                        $data['clasement_id'] = $id;
                        $data['futsal_team_id'] = $team_id;
                        $data['created_date'] = $date;
                        $data['created_by'] = $userdata->user;
                        $result .= $this->clasement_model->insert_team($data);
                    }
                
            }

            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_updated'));

            return route_to();
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }
    public function delete_clasement($id)
    {
        $userdata = $this->session->user('admin');
        $result   = $this->clasement_model->delete($id, $userdata->user);
        $delete = $this->clasement_model->delete_team($id);

        if (!$result)
            $this->session->set_flashdata('notif', lang('notif_not_deleted'));

        return route_to();
    }
}
