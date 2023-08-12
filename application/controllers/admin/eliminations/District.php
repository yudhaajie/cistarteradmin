<?php
defined('BASEPATH') or exit('No direct script access allowed');

class District extends DZ_Controller
{
    public function __construct()
    {
        parent::__construct('admin', [ 'loadTable' ]);

        $this->load->model('model_elimination');
    }

    public function index()
    {
        return $this->load->view('admin/elimination/district_registrant');
    }

    public function loadTable()
    {
        $this->load->model('model_datatables');

        $table        = "registration";
        $condition    = [ 'registration.deleted_date IS NULL' ];
        $row          = [
            '[number]',
            'UPPER(registration.name)',
            'UPPER(regional_district.name) as district',
            'UPPER(regional.name) as hotline',
            'CASE(registration_payment.status)
                WHEN 0 THEN "DISTRICT QUALIFICATION STAGE"
                WHEN 1 THEN "GAGAL"
                ELSE "LOLOS"
                END as status',
            'registration.id'
        ];
        $row_search   = [
            'registration.name', 'regional_district.name as district', 'regional.name as hotline',
            'CASE(registration_payment.status)
                WHEN 0 THEN "DISTRICT QUALIFICATION STAGE"
                WHEN 1 THEN "GAGAL"
                ELSE "LOLOS"
                END as status'
        ];
        $join         = [
            'participants_quota' => 'participants_quota.id = registration.participants_quota_id',
            'participants_category' => 'participants_category.id = participants_quota.participants_category_id',
            'regional_district' => 'regional_district.id = participants_quota.regional_district_id',
            'regional_area' => 'regional_area.id = regional_district.regional_area_id',
            'regional' => 'regional.id = regional_area.regional_id',
            'registration_verification' => 'registration_verification.registration_id = registration.id',
            'registration_payment' => 'registration_payment.registration_id = registration.id'
        ];
        $order        = [ 'registration.created_date' => 'DESC' ];
        $groupby      = [];
        $limit        = NULL;
        $offset       = NULL;
        $distinct     = FALSE;

        /* Get Data */
        $output = $this->model_datatables->loadTableServerSide($table, $condition, $row, $row_search, $join, $order, $groupby, $limit, $offset, $distinct);
        echo json_encode($output);
    }

    public function update_status($id, $status)
    {
        $date     = date('Y-m-d H:i:s');
        $userdata = $this->session->user('admin');

        /* Initialize: registration_payment */
        $data['status']       = $status;
        $data['updated_date'] = $date;
        $data['updated_by']   = $userdata->user;

        $result = $this->model_elimination->update_status($id, $data);

        if ( ! $result )
        {
            $this->session->set_flashdata('notif', lang('notif_not_updated'));
        }
        else
        {
            $userdata   = $this->admin_userdata;
            $ip_address = $this->input->ip_address();
            $name       = "";

            if ( $userdata )
            {
                if ( $userdata->first_name )
                    $name .= " {$userdata->first_name}";

                if ( $userdata->middle_name )
                    $name .= " {$userdata->middle_name}";

                if ( $userdata->last_name )
                    $name .= " {$userdata->last_name}";

                if ( ! $name )
                    $name = ucwords($userdata->username); 
            }

            $team       = $this->model_elimination->team_name($id);
            $teamName   = $team->name;
            $statuss    = ($status == 1) ? "GAGAL" : "LOLOS";
            $responsnya = " {$teamName} - {$statuss} - DISTRICT - {$name} - {$ip_address}";
            $responLog  = date("Y-M-d H:i:s") . $responsnya . PHP_EOL;

            file_put_contents('./documents/log_eliminasi_district.txt', $responLog, FILE_APPEND);
            file_put_contents('./documents/log_eliminasi.txt', $responLog, FILE_APPEND);
        }

        return route_to();
    }
}
