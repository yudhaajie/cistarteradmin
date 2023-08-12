<?php $this->load->view('admin/layouts/header'); ?>
<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>
            <h4>Pertandingan Klasemen <?= $clasement->name ?></h4>
        </div>
        <div><a href="<?= route_url("create_match/{$clasement->id}") ?>" class="btn btn-primary">Tambah Pertandingan</a></div>
    </div>
    <style>
        th {
            vertical-align: middle !important;
        }
    </style>
    <div class="card-body">



        <div class="table-responsive">
            <table class="table table-bordered table-striped table-dheezer" id="datatable-venue" datatable-ajax="<?= site_url('admin/eliminations/matches/loadClasementTable/' . $clasement->id) ?>" data-edit="<?= route_url('edit/:id') ?>" data-delete="<?= route_url('destroy/:id') ?>">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">VENUE</th>
                        <th rowspan="2">TIM</th>
                        <th colspan="2">SKOR</th>
                        <th rowspan="2">TIM</th>
                        <th colspan="2">SKOR</th>
                        <th rowspan="2">AKSI</th>
                    </tr>
                    <tr>
                        <th>HT</th>
                        <th>FT</th>
                        <th>HT</th>
                        <th>FT</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card-footer text-end">

    </div>
</div>


<?php $this->load->view('admin/layouts/footer'); ?>

<script src="https://cdn.dheezer.com/js/dz-alert.min.js" type="text/javascript"></script>
<script src="https://cdn.dheezer.com/js/dz-datatables.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        var datatable = $('#datatable-venue'),
            opt = {
                "columnDefs": [{
                        "targets": [0], // Column Number
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "10px"
                    },
                    {
                        "targets": [4], // Column Number
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "10px"
                    },
                    {
                        "targets": [5], // Column Number
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "10px"
                    },
                    {
                        "targets": [7], // Column Number
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "10px"
                    },
                    {
                        "targets": [8], // Column Number
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "10px"
                    },
                    // {
                    //     "targets" : [4],
                    //     // "data": 'matches.hta_score',
                    //     "render"   : function( data, type, row ) {
                    //             var btn = [];

                    //             var url  = 'http://efc.as/admin/eliminations/matches/score/:id';
                    //                 url  = url.replace(':id', row[4]);
                    //             var btnE = `${row[4]}`;
                    //             btn.push(btnE);
                    //             return btn.join(' | ');
                    //         }  
                    // },
                    // {
                    //     "targets"  : [8], // Column Number
                    //     "class"    : "text-md-center",
                    //     "orderable": false,
                    //     "render"   : function( data, type, row ) {
                    //         var btn = [];

                    //         var url  = 'http://efc.as/admin/eliminations/matches/score/:id';
                    //             url  = url.replace(':id', row[8]);
                    //         var btnE = `<a href="${url}" title="Edit">Update Score</a>`;
                    //         btn.push(btnE);
                    //         return btn.join(' | ');
                    //     }
                    // },
                    {
                        "targets": [9], // Column Action
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "120px",
                        "render": function(data, type, row) {
                            var btn = [];
                            var url = 'http://efc.as/admin/eliminations/matches/score/:id';
                            url = url.replace(':id', row[9]);
                            var btnE = `<a href="${url}" title="Edit">Update Score</a>`;
                            btn.push(btnE);
                            var url = datatable.data('edit');
                            url = url.replace(':id', row[9]);
                            var btnE = `<a href="${url}" title="Edit"><i class="fa fa-edit"></i></a>`;
                            btn.push(btnE);

                            var url = datatable.data('delete');
                            url = url.replace(':id', row[9]);
                            var btnD = `<a href="${url}" class="btn-delete" title="Delete" data-title="${row[3]} vs ${row[6]}"><i class="fa fa-trash"></i></a>`;
                            btn.push(btnD);

                            return btn.join(' | ');
                        }
                    }
                ]
            };

        datatable.dataTable(opt).then(function(api) {
            api.on('click', '.btn-delete', function(e) {
                e.preventDefault();

                var href = $(this).attr('href');
                var title = $(this).data('title');

                $.alert('Are you sure delete this row ?', title, function(result) {
                    if (result === true)
                        window.location.href = href;
                });
            });
        });
    });
</script>