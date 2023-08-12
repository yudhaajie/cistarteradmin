<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Tim</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-dheezer" id="datatable" datatable-ajax="<?= site_url('admin/eliminations/regional/loadTable') ?>" data-update="<?= route_url('update_status/:id') ?>">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Tim</th>
                        <th>Kategori</th>
                        <th>Regional</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
    $(function() {
        var datatable = $('#datatable'),
            opt = {
                "columnDefs": [{
                        "targets": [0], // Column Number
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "10px"
                    },
                    {
                        "targets": [4], // Column Status
                        "class": "text-md-center",
                    },
                    {
                        "targets": [5], // Column Action
                        "class": "text-md-center",
                        "orderable": false,
                        "width": "120px",
                        "render": function(data, type, row) {
                            var btn = [],
                                Ac = 6,
                                Dc = 5;

                            var url = datatable.data('update');
                                url = url.replace(':id', data);

                            if ( (row[4]).toUpperCase() === 'REGIONAL QUALIFICATION STAGE' )
                            {
                                var btnL = `<a href="${url}/${Ac}" class="btn-update" title="Lolos" data-title="${row[1]} - LOLOS">LOLOS</a>`;
                                btn.push(btnL);

                                var btnG = `<a href="${url}/${Dc}" class="btn-update" title="Gagal" data-title="${row[1]} - GAGAL">GAGAL</a>`;
                                btn.push(btnG);
                            }
                            else if ( (row[4]).toUpperCase() === 'LOLOS' )
                            {
                                var btnG = `<a href="${url}/${Dc}" class="btn-update" title="Gagal" data-title="${row[1]} - GAGAL">SET GAGAL</a>`;
                                btn.push(btnG);
                            } 
                            else if ( (row[4]).toUpperCase() === 'GAGAL' )
                            {
                                var btnL = `<a href="${url}/${Ac}" class="btn-update" title="Lolos" data-title="${row[1]} - LOLOS">SET LOLOS</a>`;
                                btn.push(btnL);
                            } 

                            return btn.join(' | ');
                        }
                    }
                ]
            };

        datatable.dataTable(opt).then(function(api) {
            api.on('click', '.btn-update', function(e) {
                e.preventDefault();

                var href = $(this).attr('href');
                var title = $(this).data('title');
                var opt = {
                    buttons: {
                        cancel: 'Batal',
                        confirm: 'OK'
                    }
                };

                $.alert('Jadikan Tim ini:', title + " ke babak selanjutnya?", opt, function(result) {
                    if (result === true)
                        window.location.href = href;
                });
            });
        });
    });
</script>
