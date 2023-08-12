<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <?= form_open(route_url('store'), ['name' => 'form-create', 'id' => 'form-create', 'class' => 'form-horizontal']) ?>
    <input type="hidden" name="clasement" value="<?=$clasement->id?>">
    <input type="hidden" name="district" value="<?=$clasement->district_id?>">
    <div class="card-header">
        <h3>Buat Pertandingan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h4>Klasemen <?= $clasement->name ?></h4>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="border-bottom py-2">Pertandingan</h4>
                    </div>
                    <div class="col-md-4">
                        <label for="match_date" class="col-form-label">Tanggal Pertandingan</label>
                        <div class="input-group">
                            <input type="text" name="match_date" id="match_date" class="form-control" imask="date" data-target="#match_date" required />
                            <button type="button" class="input-group-text" id="btn_match_date" pickers="date" pickers-target="#match_date" pickers-mindate="10/07/2023"><i class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="code" class="col-form-label">Venue</label>
                        <select name="venue" id="venue" class="form-control" required>
                            <option value="">Pilih Venue</option>
                            <?php foreach ($venues as $venue) : ?>
                                <option value="<?= $venue->id ?>"><?= $venue->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="col-form-label">Tim 1 (Home)</label>
                        <select name="home_team" id="homeTeam" class="form-control" required>
                            <option>Pilih Tim</option>
                            <?php foreach ($teams as $team) : ?>
                                <option value="<?= $team->id ?>"><?= $team->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="name" class="col-form-label">Tim 2 (Away)</label>
                        <select name="away_team" id="awayTeam" class="form-control" required>
                            <option>Pilih Tim</option>
                            <?php foreach ($teams as $team) : ?>
                                <option value="<?= $team->id ?>"><?= $team->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="<?= route_url() ?>" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-info">Save</button>
    </div>
</div>



<?= form_close() ?>
</div>
<div id="loading" style="margin-top: 15px;">
    <small>Loading...</small>
</div>
<?php $this->load->view('admin/layouts/footer'); ?>

<script src="https://cdn.dheezer.com/js/dz-form.min.js" type="text/javascript"></script>
<script src="https://cdn.dheezer.com/js/dz-validation.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() { 
        $("#loading").hide();

        $("#district").change(function() { 
            $("#loading").show(); // Tampilkan loadingnya
            $.ajax({
                type: "POST", // Method pengiriman data bisa dengan GET atau POST
                url: "<?php echo base_url('admin/eliminations/venues/list'); ?>", // Isi dengan url/path file php yang dituju
                data: {
                    district_id: $("#district").val()
                }, // data yang akan dikirim ke file yang dituju
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) { // Ketika proses pengiriman berhasil
                    $("#loading").hide(); // Sembunyikan loadingnya
                    // set isi dari combobox kota
                    // lalu munculkan kembali combobox kotanya
                    $("#venue").html(response.list_kota).show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
            $.ajax({
                type: "POST", // Method pengiriman data bisa dengan GET atau POST
                url: "<?php echo base_url('admin/eliminations/matches/teamlist'); ?>", // Isi dengan url/path file php yang dituju
                data: {
                    district_id: $("#district").val()
                }, // data yang akan dikirim ke file yang dituju
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) { // Ketika proses pengiriman berhasil
                    $("#loading").hide(); // Sembunyikan loadingnya
                    // set isi dari combobox kota
                    // lalu munculkan kembali combobox kotanya
                    $("#homeTeam").html(response.list_kota).show();
                    $("#awayTeam").html(response.list_kota).show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });
    });
</script>