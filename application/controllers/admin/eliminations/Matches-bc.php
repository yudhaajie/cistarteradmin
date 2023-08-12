<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Matches extends DZ_Controller
{
    public function __construct()
    {
        parent::__construct('admin');

        $this->load->model('model_country');
        $this->load->model('model_venue');
        $this->load->model('model_match');
        $this->load->model('model_clasement');
    }

    public function index()
    {
        return $this->load->view('admin/elimination/match/index');
    }

    /**
     * @abstract Serverside load table
     * @return json
     */
    public function loadTable()
    {
        $this->load->model('model_datatables');

        $table        = "matches";
        $condition    = ['matches.deleted_date IS NULL'];
        $row          = ['[number]', 'matches.match_date', 'regional_district.name as district', 'a.name as home', 'matches.hth_score', 'matches.fth_score', 'b.name as away', 'matches.hta_score', 'matches.fta_score', 'matches.id'];
        $row_search   = ['a.name'];
        $join         = [
            'regional_district' => 'regional_district.id = matches.district_id',
            'futsal_teams a' => 'a.id = matches.home_team',
            'futsal_teams b' => 'b.id = matches.away_team',
        ];
        $order        = ['matches.id' => 'ASC'];
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
        $data['districts'] = $this->model_venue->districts();
        $data['venues'] = $this->model_venue->venues();
        $data['formats'] = $this->model_match->match_formats();
        return $this->load->view('admin/elimination/match/create', $data);
    }
    public function create_schedule()
    {
        $data['districts'] = $this->model_venue->districts();
        $data['venues'] = $this->model_venue->district_venues(39);
        $data['teams'] = $this->model_match->district_teams(39);
        return $this->load->view('admin/elimination/match/create_match', $data);
    }

    public function store()
    {
        if ($this->input->method() == "post") {
            $date           = date('Y-m-d H:i:s');
            $userdata       = $this->session->user('admin');
            $district_id    = $this->input->post('district');
            $venue_id       = $this->input->post('venue');
            $home_team      = $this->input->post('home_team');
            $away_team      = $this->input->post('away_team');
            $input_date     = $this->input->post('match_date');
            $clasement_id   = $this->input->post('clasement');
            $match_date = date("Y-m-d", strtotime($input_date));

            $data['clasement_id']   = $clasement_id;
            $data['district_id']    = $district_id;
            $data['venue_id']       = $venue_id;
            $data['home_team']      = $home_team;
            $data['away_team']      = $away_team;
            $data['created_date']   = $date;
            $data['user_id']        = $userdata->user;
            $data['match_date']     = $match_date;

            $result = $this->model_match->insert_match($data);


            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_saved'));

            return route_to("clasement_match/{$clasement_id}");
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }

    public function edit($id)
    {

        $result = $this->model_match->get_match($id);
        $data['districts'] = $this->model_venue->districts();
        $data['venues'] = $this->model_venue->district_venues($result->district_id);
        $data['teams'] = $this->model_match->district_teams($result->district_id);

        if ($result) {
            $data['id']     = $id;
            $data['result'] = $result;

            return $this->load->view('admin/elimination/match/edit', $data);
        }

        $this->session->set_flashdata('notif', lang('notif_not_found'));

        return route_to();
    }

    public function update($id)
    {
        if ($this->input->method() == "post") {
            $date       = date('Y-m-d H:i:s');
            $userdata   = $this->session->user('admin');
            $district_id       = $this->input->post('district');
            $venue_id       = $this->input->post('venue');
            $home_team = $this->input->post('home_team');
            $away_team = $this->input->post('away_team');
            $input_date = $this->input->post('match_date');
            $match_date = date("Y-m-d", strtotime($input_date));
            $result = FALSE;
            $get    = $this->model_match->get_match($id);


            if ($get) {

                $data['district_id']  = $district_id;
                $data['venue_id']         = $venue_id;
                $data['home_team']   = $home_team;
                $data['away_team'] = $away_team;
                $data['created_date'] = $date;
                $data['user_id']   = $userdata->user;
                $data['match_date'] = $match_date;
                $data['updated_date']   = $date;
                $data['updated_by']     = $userdata->user;


                $result = $this->model_match->update_match($id, $data);
            }

            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_updated'));

            return route_to();
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }

    public function destroy($id)
    {
        $userdata = $this->session->user('admin');
        $result   = $this->model_match->delete($id, $userdata->user);

        if (!$result)
            $this->session->set_flashdata('notif', lang('notif_not_deleted'));

        return route_to();
    }


    public function teamlist()
    {
        $district_id = $this->input->post('district_id');
        $venues = $this->model_match->district_teams($district_id);

        $lists = "<option value=''>Pilih</option>";

        foreach ($venues as $data) {
            $lists .= "<option value='" . $data->id . "'>" . $data->name . "</option>";
        }

        $callback = array('list_kota' => $lists);
        echo json_encode($callback);
    }
    public function district_team_list()
    {
        $ids = $this->input->post('district_id');
        $id = explode('-', $ids);
        $district_id = $id[0];
        $teams = $this->model_clasement->free_teams($district_id);

        $lists = "<div class='col-12 ps-5'>";

        foreach ($teams as $data) {
            $lists .= "<input type='checkbox' name='teams[]' id='tim" . $data->id . "' class='form-check-input' value='" . $data->id . "'> <label class='form-check-label' for='tim" . $data->id . "'>" . $data->name . "<br>";
        }
        $lists .= "</div>";
        $callback = array('list_kota' => $lists);
        echo json_encode($callback);
    }

  
    public function score($id)
    {
        $result = $this->model_match->join_match($id);

        if ($result) {
            $data['id']     = $id;
            $data['result'] = $result;

            return $this->load->view('admin/elimination/match/score', $data);
        }

        $this->session->set_flashdata('notif', lang('notif_not_found'));

        return route_to();
    }
    public function updatescore($id)
    {
        if ($this->input->method() == "post") {
            $date       = date('Y-m-d H:i:s');
            $userdata   = $this->session->user('admin');
            $hth_score = $this->input->post('ht_h');
            $hta_score = $this->input->post('ht_a');
            $fth_score = $this->input->post('ft_h');
            $fta_score = $this->input->post('ft_a');
            $result = FALSE;
            $get    = $this->model_match->get_match($id);


            if ($get) {

                $data['hth_score']      = $hth_score;
                $data['hta_score']      = $hta_score;
                $data['fth_score']      = $fth_score;
                $data['fta_score']      = $fta_score;
                $data['updated_date']   = $date;
                $data['updated_by']     = $userdata->user;


                $result = $this->model_match->update_match($id, $data);
            }

            if (!$result)
                $this->session->set_flashdata('notif', lang('notif_not_updated'));

            return route_to();
        } else {
            return show_error(lang('http_response_405'), 405);
        }
    }
    public function clasement_match($id)
    {
        $clasement = $this->model_clasement->get_clasement($id);
        $data['clasement'] = $clasement;
        $data['venues'] = $this->model_venue->district_venues($clasement->district_id);
        $data['teams'] = $this->model_clasement->clasement_teams($id);
        $data['matches'] = $this->model_match->get_class_matches($id);
        
        $this->load->view('admin/elimination/match/match_list', $data);
    }
     /**
     * @abstract Serverside load table
     * @return json
     */
    public function loadClasementTable($id)
    {
        $this->load->model('model_datatables');

        $table        = "matches";
        $condition    = ['matches.deleted_date IS NULL', "matches.clasement_id={$id}"];
        $row          = ['[number]', 'matches.match_date', 'v.name as venue', 'a.name as home', 'matches.hth_score', 'matches.fth_score', 'b.name as away', 'matches.hta_score', 'matches.fta_score', 'matches.id'];
        $row_search   = ['a.name'];
        $join         = [
            'regional_district' => 'regional_district.id = matches.district_id',
            'venues v' => 'v.id = matches.venue_id',
            'futsal_teams a' => 'a.id = matches.home_team',
            'futsal_teams b' => 'b.id = matches.away_team',
        ];
        $order        = ['matches.id' => 'ASC'];
        $groupby      = [];
        $limit        = NULL;
        $offset       = NULL;
        $distinct     = FALSE;

        /* Get Data */
        $output = $this->model_datatables->loadTableServerSide($table, $condition, $row, $row_search, $join, $order, $groupby, $limit, $offset, $distinct);
        echo json_encode($output);
    }

    public function create_match($id)
    {
        $clasement = $this->model_clasement->get_clasement($id);
        $data['clasement'] = $clasement;
        $data['venues'] = $this->model_venue->district_venues($clasement->district_id);
        $data['teams'] = $this->model_clasement->clasement_teams($id);
        
        $this->load->view('admin/elimination/match/create_match', $data);
    }

    /* add team */
    public function teams()
    {
        $this->db->select('registration_payment.registration_id, registration.name as tim, participants_quota.regional_team_id, regional_team.regional_district_id as district_id, regional_district.user_id, regional_district.name as district');
        $this->db->from('registration_payment');
        $this->db->join('registration', 'registration.id=registration_payment.registration_id');
        $this->db->join('participants_quota', 'participants_quota.id=registration.participants_quota_id');
        $this->db->join('regional_team', 'regional_team.id = participants_quota.regional_team_id');
        $this->db->join('regional_district', 'regional_district.id = regional_team.regional_district_id');
        $row = $this->db->get()->row();
        // echo $row->registration_id . " - ";
        // echo $row->tim . "<br>";
        $data = array(
            'registration_id' => $row->registration_id,
            'regional_id' => $row->regional_team_id,
            'district_id' => $row->district_id,
            'name' => $row->tim,
            'user_id' => $row->user_id
        );
        $this->db->insert('futsal_teams', $data);
    }
}
