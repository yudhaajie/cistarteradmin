<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>
<style>
    th{
        vertical-align: middle !important;
    }
    </style>
<div class="card">
<div class="card-header">
        <a href="<?= base_url('admin/eliminations/classement') ?>" class="btn btn-info">Klasemen</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-dheezer" id="datatable-venue" datatable-ajax="<?= site_url('admin/eliminations/matches/loadTable') ?>" data-edit="<?= route_url('edit/:id') ?>" data-delete="<?= route_url('destroy/:id') ?>">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">DISTRICT</th>
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
</div>

<?php $this->load->view('admin/layouts/footer'); ?>

<script src="https://cdn.dheezer.com/js/dz-alert.min.js" type="text/javascript"></script>
<script src="https://cdn.dheezer.com/js/dz-datatables.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
    var datatable = $('#datatable-venue'),
        opt = {
        "columnDefs": [
            {
                "targets"  : [0], // Column Number
                "class"    : "text-md-center",
                "orderable": false,
                "width"    : "10px"
            },
            {
                "targets"  : [4], // Column Number
                "class"    : "text-md-center",
                "orderable": false,
                "width"    : "10px"
            },
            {
                "targets"  : [5], // Column Number
                "class"    : "text-md-center",
                "orderable": false,
                "width"    : "10px"
            },
            {
                "targets"  : [7], // Column Number
                "class"    : "text-md-center",
                "orderable": false,
                "width"    : "10px"
            },
            {
                "targets"  : [8], // Column Number
                "class"    : "text-md-center",
                "orderable": false,
                "width"    : "10px"
            },
       
            {
                "targets"  : [9], // Column Action
                "class"    : "text-md-center",
                "orderable": false,
                "width"    : "120px",
                "render"   : function( data, type, row ) {
                    var btn = [];
                    var url  = 'http://efc.as/admin/eliminations/matches/score/:id';
                        url  = url.replace(':id', row[9]);
                    var btnE = `<a href="${url}" title="Edit">Update Score</a>`;
                    btn.push(btnE);
                    // var url  = datatable.data('edit');
                    //     url  = url.replace(':id', row[9]);
                    // var btnE = `<a href="${url}" title="Edit"><i class="fa fa-edit"></i></a>`;
                    // btn.push(btnE);

                    // var url  = datatable.data('delete');
                    //     url  = url.replace(':id', row[9]);
                    // var btnD = `<a href="${url}" class="btn-delete" title="Delete" data-title="${row[2]}"><i class="fa fa-trash"></i></a>`;
                    // btn.push(btnD);

                    return btn.join(' | ');
                }
            }
        ]
    };

    datatable.dataTable(opt).then(function ( api ) {
        api.on('click', '.btn-delete', function (e) {
            e.preventDefault();

            var href  = $(this).attr('href');
            var title = $(this).data('title');

            $.alert('Are you sure delete this row ?', title, function ( result ) {
                if ( result === true )
                    window.location.href = href;
            });
        });
    });
});

</script>
