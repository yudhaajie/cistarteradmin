<?php $this->load->view('admin/layouts/header'); ?>

<?php $this->load->view('admin/layouts/navigation'); ?>

<div class="card">
	<?= form_open(route_url("update/{$id}"), [ 'name' => 'form-edit', 'id' => 'form-edit', 'class' => 'form-horizontal' ]) ?>
	<div class="card-header">
		<h3 class="card-title">Edit Venue</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="row mb-3">
                    <label for="district" class="col-form-label col-md-4">District</label>
                    <div class="col-md-8">
                        <select name="district" id="district" class="form-control" required>
							<option value="">Pilih ...</option>
                            <?php
                            foreach ($districts as $district) : ?>
                                <option value="<?= $district->id ?>" <?=($result->district_id==$district->id) ? "selected" : ""?>><?= $district->name ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
				</div>

				<div class="row mb-3">
                    <label for="name" class="col-form-label col-md-4">Nama</label>
                    <div class="col-md-8">
						<input type="text" name="name" id="name" class="form-control" required value="<?= $result->name ?>" />
					</div>
				</div>

				<div class="row mb-3">
                    <label for="location" class="col-form-label col-md-4">Alamat</label>
                    <div class="col-md-8">
						<input type="text" name="location" id="location" class="form-control" required value="<?= $result->location ?>" />
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card-footer text-end">
		<a href="<?= route_url() ?>" class="btn btn-danger">Cancel</a>
		<button type="submit" class="btn btn-info">Update</button>
	</div>

	<?= form_close() ?>
</div>

<?php $this->load->view('admin/layouts/footer'); ?>

<script src="https://cdn.dheezer.com/js/dz-form.min.js" type="text/javascript"></script>
<script src="https://cdn.dheezer.com/js/dz-validation.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    $('#form-edit').validate({
        rules: {
            district: {
                required: true
            },
            name: {
                required: true,
                maxlength: 100
            },
            location: {
                required: true,
                maxlength: 100
            }
        }
    });
});
</script>
