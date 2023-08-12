<?php $this->load->view('admin/layouts/header'); ?>
<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <div class="card-header">
        <a href="<?= route_url("create/{$clasement->id}") ?>" class="btn btn-info">Tambah Pertandingan</a>
    </div>
    <style>
        th {
            vertical-align: middle !important;
        }
    </style>
    <div class="card-body">
        <h4 class="border-bottom pb-1 mb-2">Klasemen <?=$clasement->name?></h4>
        
        <div class="row">
            <?php
            foreach ($clasements as $rows) : ?>
                <div class="col-12 col-md-4 d-flex align-items-stretch">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div><?= $rows->name ?></div>
                            <div><a href="<?=route_url("clasement_match/{$rows->id}")?>">Pertandingan</a></div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Team</th>
                                    <th>T</th>
                                    <th>M</th>
                                    <th>S</th>
                                    <th>K</th>
                                    <th>N</th>
                                    <th>Aksi</th>
                                </tr>
                           
                            <?php
                            foreach($teams as $row => $key) :
                                if($row == $rows->id):
                            ?>
                            
                                <?php 
                                foreach($key as $team):
                                    ?>
                                    <tr>
                                        <td><?=$team->name?></td>
                                        <td> - </td>
                                        <td> - </td>
                                        <td> - </td>
                                        <td> - </td>
                                        <td> - </td>
                                        <td> <a href="">LOLOS</a>/<a href="">GAGAL</a> </td>
                                    </tr>
                                <?php endforeach;?>
                           
                                </table>
                            <?php
                            
                            endif;
                            endforeach;
                            ?>
                        </div>
                        <div class="card-footer text-end">
                        <a href="<?=route_url("delete_clasement/{$rows->id}")?>" class="btn btn-danger me-3">Delete</a>    
                        <a href="<?=route_url("edit_clasement/{$rows->id}")?>" class="btn btn-danger">Edit</a>
                            
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>
</div>

<?php $this->load->view('admin/layouts/footer'); ?>

<script src="https://cdn.dheezer.com/js/dz-alert.min.js" type="text/javascript"></script>
<script src="https://cdn.dheezer.com/js/dz-datatables.min.js" type="text/javascript"></script>
