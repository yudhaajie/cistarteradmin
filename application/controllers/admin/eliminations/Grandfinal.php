<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grandfinal extends DZ_Controller
{
    public function __construct()
    {
        parent::__construct('admin', [ 'loadTable' ]);

        $this->load->model('model_elimination');
    }

    public function index()
    {
        return $this->load->view('admin/elimination/grandfinal_registrant');
    }

    public function loadTable()
    {
        $this->load->model('model_datatables');

        $table        = "registration";
        $condition    = [ 'registration.deleted_date IS NULL', 'registration_payment.status > 5' ];
        $row          = [
            '[number]',
            'UPPER(registration.name)',
            'UPPER(participants_category.name) as category',
            'UPPER(regional.name) as regional',
            'CASE(registration_payment.status)
                WHEN 6 THEN "GRANDFINAL QUALIFICATION STAGE"
                WHEN 7 THEN "GAGAL"
                ELSE "LOLOS"
                END as status',
            'registration.id'
        ];
        $row_search   = [
            'registration.name', 'participants_category.name as category', 'regional.name as regional',
            'CASE(registration_payment.status)
                WHEN 6 THEN "GRANDFINAL QUALIFICATION STAGE"
                WHEN 7 THEN "GAGAL"
                ELSE "LOLOS"
                END as status'
        ];
        $join         = [
            'participants_quota' => 'participants_quota.id = registration.participants_quota_id',
            'participants_category' => 'participants_category.id = participants_quota.participants_category_id',
            'regional_district' => [ 'left' => 'regional_district.id = participants_quota.regional_district_id' ],
            'regional_area' => [ 'left' => 'regional_area.id = regional_district.regional_area_id' ],
            'regional' => 'regional.id = (CASE WHEN participants_quota.regional_id IS NOT NULL THEN participants_quota.regional_id ELSE regional_area.regional_id END)',
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

        $valid  = FALSE;
        $result = FALSE;
        $notif  = "";

        if ( $status == 8 )
        {
            $regional = $this->model_elimination->regional($id);
            $region   = $this->model_elimination->quota_area($regional->regional, $status);
            $total    = $region->total;

            if ( $total >= 4 )
            {
                $notif = "Kuota sudah terpenuhi.";
            }
            else
            {
                $valid = TRUE;
            }
        }
        else
        {
            $valid = TRUE;
        }

        if ( $valid )
        {
            /* Initialize: registration_payment */
            $data['status']       = $status;
            $data['updated_date'] = $date;
            $data['updated_by']   = $userdata->user;

            $result = $this->model_elimination->update_status($id, $data);

            if ( ! $result )
                $notif = lang('notif_not_updated');
        }

        if ( ! $result )
        {
            $this->session->set_flashdata('notif', $notif);
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
            $statuss    = ($status == 7) ? "GAGAL" : "LOLOS";
            $responsnya = " {$teamName} - {$statuss} - GRAND FINAL - {$name} - {$ip_address}";
            $responLog  = date("Y-M-d H:i:s") . $responsnya . PHP_EOL;

            file_put_contents('./documents/log_eliminasi_final.txt', $responLog, FILE_APPEND);
            file_put_contents('./documents/log_eliminasi.txt', $responLog, FILE_APPEND);
        }

        return route_to();
    }
}
