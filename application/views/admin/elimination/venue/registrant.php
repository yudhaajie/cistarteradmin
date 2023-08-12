<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <div class="card-header">

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-dheezer" id="datatable-registered" datatable-ajax="<?= site_url('admin/eliminations/venues/loadRegistrant') ?>">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Tim</th>
                        <th>DQ</th>
                        <th>Hotline</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layouts/footer'); ?>
