<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group_management extends LSA_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('classement_model');
		$this->load->model('DataTable_model');
	}
	//index
	public function index()
	{
		$data['sidebar'] = $this->sidebar();
		$data['bread'] = $this->breadCrumb();
		// $data['classements'] = $this->classement_model->district_classements();
		$this->classement_model->district_classements();
		return $this->load->view('admin/elimination/group/index', $data);
	}
	public function get_data()
	{
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order');
		$search = $this->input->post('search')['value'];

		$recordsTotal = $this->DataTable_model->count_all_data();
		$recordsFiltered = $this->DataTable_model->count_filtered_data($search);
		$data = $this->DataTable_model->get_data($start, $length, $order, $search);

		$response = array(
			"draw" => intval($draw),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $data,
		);

		echo json_encode($response);
	}
	public function create()
	{
		$stage = $_GET['stage'];
		// $is_admin = $this->admin_userdata->is_superadmin > 1;
		$user_id = Null;
		$role = Null;
		// $userdata = $this->session->user('admin');
		// if (!$is_admin) {
		//     $user_id = $userdata->user;
		//     $user = $this->model_user->get($user_id);
		//     $role = $user->role;
		// }
		$data['districts'] = $this->classement_model->districts($user_id, $role);
		$data['formats'] = $this->classement_model->match_formats();
		$data['sidebar'] = $this->sidebar();
		$data['bread'] = $this->breadCrumb();
		if ($stage == 'single') {
			return $this->load->view('admin/elimination/group/create-single', $data);
		} elseif ($stage == 'multiple') {
			return $this->load->view('admin/elimination/group/create', $data);
		}
	}
	public function parentClassement()
	{
		$ids = $this->input->post('district_id');
		// $id = explode('-', $ids);
		// $district_id = $id[0];
		$parents = $this->classement_model->parent_group(9);
		$list = "";
		foreach ($parents as $data) {
			$list .= "<option value='" . $data->id . "'>" . $data->name . "</option>";
		}
		$callback = array('list_parent' => $list);
		echo json_encode($callback);
	}
	public function district_team_list()
	{
		$ids = $this->input->post_get('district_id');
		$stage = $this->input->post_get('stage');
		$id = explode('-', $ids);
		$district_id = $id[0];
		$list = null;
		if ($stage == 'multiple') {
			$parents = $this->classement_model->parent_group($district_id);
			$list = "<select class='js-example-basic-single js-states form-control' id='DistrictOption' name='parent'>";
			$list .= "<option value=''>Choose Group Parent</option>";
			if ($parents) {

				foreach ($parents as $data) {
					$list .= "<option value='" . $data->id . "'>" . $data->name . "</option>";
				}
			}
			$list .= "</select>";
		}
		$teams = $this->classement_model->free_teams($district_id);
		$lists = "";
		foreach ($teams as $data) {
			$lists .= "<div class='form-check'>
			<input class='form-check-input' type='checkbox' name='teams[]'  id='tim" . $data->id . "' value='" . $data->id . "' >
			<label class='form-check-label' for='tim" . $data->id . "'>
			" . strtoupper($data->name) . "
			</label>
		  </div>";
		}
		$parents = (($list != null) ? $list : '');
		$callback = array('list_team' => $lists, 'list_parent' => $list);
		echo json_encode($callback);
	}

	public function store()
	{
		if ($this->input->method() == "post") {
			$date           = date('Y-m-d H:i:s');
			//$userdata       = $this->session->user('admin');
			$region_ids   = $this->input->post('district');
			$title          = $this->input->post('title');
			$format_id         = $this->input->post('format');
			$region_id = explode('-', $region_ids);
			$district_id = $region_id[0];
			$area_id = $region_id[1];
			$regional_id = $region_id[2];
			$teams = $this->input->post('teams');
			//insert clasement

			$data['match_format_id'] = $format_id;
			$data['regional_id'] = $regional_id;
			$data['area_id'] = $area_id;
			$data['district_id'] = $district_id;
			// $data['user_id'] = $userdata->user;
			$data['user_id'] = 1;
			$data['name'] = $title;
			$data['created_date'] = $date;
			// $data['created_by'] = $userdata->user;
			$data['created_by'] = 1;
			$clasement_id =  $this->classement_model->insert($data);
			//insert team
			$result = '';
			foreach ($teams as $key => $id) {
				$data = array();
				$data['classement_id'] = $clasement_id;
				$data['registration_id'] = $id;
				$data['created_date'] = $date;
				// $data['created_by'] = $userdata->user;
				$data['created_by'] = 1;
				$result .= $this->classement_model->insert_team($data);
			}
			if (!$result)
				$this->session->set_flashdata('notif', lang('notif_not_saved'));

			return redirect('admin/district-elimination/group_management');
		} else {
			return show_error(lang('http_response_405'), 405);
		}
	}
	public function edit($id)
	{
		$data['sidebar'] = $this->sidebar();
		$data['bread'] = $this->breadCrumb();
		$data['districts'] = $this->classement_model->districts();
		$data['formats'] = $this->classement_model->match_formats();
		$data['classement'] = $this->classement_model->get_classement($id);
		$district_id = $data['classement']->district_id;
		$data['classement_teams'] = $this->classement_model->classement_teams($id);
		$data['teams'] = $this->classement_model->free_teams($district_id);
		$data['id']     = $id;
		$this->load->view('admin/elimination/group/edit', $data);
	}
	public function update($id)
	{
		if ($this->input->method() == "post") {
			$date       = date('Y-m-d H:i:s');
			$name = $this->input->post('title');
			$teams = $this->input->post('teams');
			$result = FALSE;

			$get    = $this->classement_model->get_classement($id);
			$userdata = '1';
			if ($get) {

				$data['name'] = $name;
				$data['user_id']   = $userdata;
				$data['updated_date']   = $date;
				$data['updated_by']     = $userdata;

				$result = $this->classement_model->update($id, $data);
				$result = '';
				$team = $this->classement_model->classement_teams($id);
				foreach ($teams as $team_id) {
					echo $team_id;
				}
				// exit();
				if ($team and $teams != [])  $delete = $this->classement_model->delete_team($id);

				foreach ($teams as $team_id) {
					$data = array();
					$data['classement_id'] = $id;
					$data['registration_id'] = $team_id;
					$data['created_date'] = $date;
					$data['created_by'] = $userdata;
					$result .= $this->classement_model->insert_team($data);
				}
			}

			if (!$result)
				$this->session->set_flashdata('notif', lang('notif_not_updated'));

			return redirect('/admin/district-elimination/group_management');
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

		return site_url();
	}
}
