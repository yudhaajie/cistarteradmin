<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
    <?= form_open(site_url("update_clasement/{$id}"), ['name' => 'form-create', 'id' => 'form-create', 'class' => 'form-horizontal']) ?>
    <div class="card-header">
        <h3>Edit Klasemen</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="code" class="col-form-label">District</label>
                        <select name="district" id="district" class="form-control" disabled>
                            <option value="">Pilih District</option>
                            <?php
                            foreach ($districts as $district) : ?>
                                <option value="<?= $district->id ?>-<?= $district->regional_id ?>" <?= ($district->id == $clasement->district_id) ? "selected" : '' ?>><?= $district->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="border-bottom py-2">Format Pertandingan</h4>
                    </div>
                    <div class="col-md-4">
                        <label for="code" class="col-form-label">Format Pertandingan</label>
                        <select name="format" class="form-control" required>
                            <option value="">Pilih Format</option>
                            <?php
                            foreach ($formats as $format) : ?>
                                <option value="<?= $format->id ?>" <?= ($format->id == $clasement->match_format_id) ? "selected" : ""; ?>><?= $format->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="title" class="col-form-label">Judul/Title Klasemen</label>
                        <div class="col-md-6 row">
                            <input type="text" name="title" value="<?= $clasement->name ?>" class="form-control" placeholder="Title Klasemen">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="border-bottom py-2">PILIH TIM</h4>
                    </div>
                    <div class="col-12 ps-6">
                        <?php
                        foreach ($clasement_teams as $data) { ?>
                            <input type='checkbox' name='teams[]' id='tim<?= $data->id; ?>' class='form-check-input' value='<?= $data->id ?>' checked> <label class='form-check-label' for='tim<?= $data->id ?>'><?= $data->name ?><br>
                            <?php } ?>
                            <?php
                            foreach ($teams as $data) { ?>
                                <input type='checkbox' name='teams[]' id='tim<?= $data->id; ?>' class='form-check-input' value='<?= $data->id ?>'> <label class='form-check-label' for='tim<?= $data->id ?>'><?= $data->name ?><br>
                                <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-footer text-end">
    <a href="<?= site_url() ?>" class="btn btn-danger">Cancel</a>
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
                url: "<?php echo base_url('admin/eliminations/matches/district_team_list'); ?>", // Isi dengan url/path file php yang dituju
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
                    $("#teamList").html(response.list_kota).show();
                    // $("#awayTeam").html(response.list_kota).show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });
    });
</script>
