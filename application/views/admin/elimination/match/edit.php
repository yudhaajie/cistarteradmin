<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <?= form_open(route_url("update/{$id}"), ['name' => 'form-create', 'id' => 'form-create', 'class' => 'form-horizontal']) ?>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="code" class="col-form-label col-md-4">District</label>
                        <div class="col-md-8">
                            <select name="district" id="district" class="form-control" required>
                                <option>Pilih District</option>
                                <?php
                                foreach ($districts as $district) : ?>
                                    <option value="<?= $district->id ?>" <?= ($result->district_id == $district->id) ? "selected" : "" ?>><?= $district->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="code" class="col-form-label col-md-4">Venue</label>
                        <div class="col-md-8">
                            <select name="venue" id="venue" class="form-control" required>
                                <option>Pilih District dahulu</option>
                                <?php
                                foreach ($venues as $venue) : ?>
                                    <option value="<?= $venue->id ?>" <?= ($result->venue_id == $venue->id) ? "selected" : "" ?>><?= $venue->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="col-form-label col-md-4">Tim 1</label>
                        <div class="col-md-8">
                            <select name="home_team" id="homeTeam" class="form-control" required>
                                <option>Pilih District dahulu</option>
                                <?php
                                foreach ($teams as $team) : ?>
                                    <option value="<?= $team->id ?>" <?= ($result->home_team == $team->id) ? "selected" : "" ?>><?= $team->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="col-form-label col-md-4">Tim 2</label>
                        <div class="col-md-8">
                            <select name="away_team" id="awayTeam" class="form-control" required>
                                <option>Pilih District dahulu</option>
                                <?php
                                foreach ($teams as $team) : ?>
                                    <option value="<?= $team->id ?>" <?= ($result->away_team == $team->id) ? "selected" : "" ?>><?= $team->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="match_date" class="col-form-label col-md-4">Tanggal Pertandingan</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="match_date" id="match_date" class="form-control" imask="date" data-target="#match_date" value="<?=date("d-m-Y", strtotime($result->match_date))?>" required />
                                <button type="button" class="input-group-text" id="btn_match_date" pickers="date" pickers-target="#match_date" pickers-mindate="10/07/2023"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-end">
        <a href="<?= route_url() ?>" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-info">Save</button>
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
    $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
        // Kita sembunyikan dulu untuk loadingnya
        $("#loading").hide();

        $("#district").change(function() { // Ketika user mengganti atau memilih data provinsi
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