<?php $this->load->view('admin/layouts/header'); ?>
<?php $this->load->view('admin/layouts/navbar'); ?>
<?php $this->load->view('admin/layouts/sidebar'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<div class="contents">
	<div class="container-fluid">
		<div class="social-dash-wrap">
			<div class="row">
				<?php $this->load->view('admin/layouts/breadcrumb'); ?>
			</div>
			<div class="row">
				<div class="col-lg-12 mb-30">
					<div class="card">
						<div class="card-header color-dark fw-500">
							<div class="d-flex align-items-center justify-content-between w-100 py-4">
								<h4><?= $sidebar['subPage'] ?></h4>
							</div>
						</div>
					</div>
					<div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
						<div class="tab-content" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
								<div class="row justify-content-center">
									<div class="col-xxl-4 col-10">
										<div class="mt-sm-40 mb-sm-50 mt-20 mb-20">
											<div class="user-tab-info-title mb-sm-40 mb-20 text-capitalize">
												<h5 class="fw-500">Match Group Information</h5>
											</div>
											<div class="edit-profile__body">
												<form method="post" action="<?= base_url('admin/district-elimination/group_management/store') ?>">
													<div class="form-group mb-25">
														<div class="DistrictOption">
															<label for="DistrictOption">District </label>
															<select class="js-example-basic-single js-states form-control" id="DistrictOption" name="district" required>
																<option value="">Choose district</option>
																<?php
																foreach ($districts as $district) : ?>
																	<option value="<?= $district->id ?>-<?= $district->area_id ?>-<?= $district->regional_id ?>">
																		<?= $district->area ?> - <?= $district->name ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="form-group mb-25">
														<label for="name1">name</label>
														<input type="text" name="title" required class="form-control" id="name1" placeholder="Group Name" />
													</div>
													<div class="form-group mb-25">
														<div class="matchTypeOption">
															<label for="matchTypeOption">Match Type </label>
															<select class="js-example-basic-single js-states form-control" id="matchTypeOption" name="format" required>
																<option value="">Choose Match Type</option>
																<?php
																foreach ($formats as $format) : ?>
																	<option value="<?= $format->id ?>"><?= $format->name ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
													<div class="form-group mb-25">
														<label for="winner">Number of Winner </label>
														<input type="text" class="form-control" id="winner" name="winner" value="1" />
													</div>
													<div class="form-group mb-25">
														<label for="winner">Select Teams </label>

														<div id="teamList"></div>
													</div>
													<div class="button-group d-flex pt-sm-25 justify-content-md-end justify-content-start">
														<a href="javascript:history.back();"><button class="btn btn-light btn-default btn-squared fw-400 text-capitalize radius-md btn-sm" type="button">
																cancel</button></a>
														<button class="btn btn-primary btn-default btn-squared text-capitalize radius-md shadow2 btn-sm">
															Save
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('admin/layouts/footer'); ?>
	<script>
		$(document).ready(function() {
			// Function to update the Number of Winner input
			function updateWinnerInput() {
				var selectedMatchType = $("#matchTypeOption").val();
				if (selectedMatchType === "4") {
					$("#winner").val(1); // Lock the input to 1 if no match type is selected
					$("#winner").prop("readonly", true); // Lock the input field
				} else {
					$("#winner").val(1); // Lock the input to 1 if no match type is selected
					$("#winner").prop("readonly", false); // Unlock the input field
				}
			}

			// Initialize the function on page load
			updateWinnerInput();

			// Listen for changes in the Match Type select
			$("#matchTypeOption").on("change", function() {
				updateWinnerInput();
			});
			// Clear the Number of Winner input value when clicked
			$("#winner").on("click", function() {
				if (!$(this).prop("readonly")) {
					$(this).val(""); // Clear the input value
				}
			});
			// Prevent non-numeric input in the Number of Winner input
			$("#winner").on("input", function() {
				var numericValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
				$(this).val(numericValue);
			});
			$("#DistrictOption").change(function() { // Ketika user mengganti atau memilih data provinsi
				$("#loading").show(); // Tampilkan loadingnya
				$.ajax({
					type: "POST", // Method pengiriman data bisa dengan GET atau POST
					url: "<?php echo base_url('admin/district-elimination/group_management/district_team_list'); ?>", // Isi dengan url/path file php yang dituju
					data: {
						district_id: $("#DistrictOption").val()
					}, // data yang akan dikirim ke file yang dituju
					dataType: "json",
					beforeSend: function(e) {
						if (e && e.overrideMimeType) {
							e.overrideMimeType("application/json;charset=UTF-8");
						}
					},
					success: function(response) { // Ketika proses pengiriman berhasil
						$("#loading").hide(); // Sembunyikan loadingnya
						//pilihan team
						$("#teamList").html(response.list_team).show();

					},
					error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
						alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
					}
				});
			});
			$("form").submit(function(event) {
        var isChecked = $("input[name='teams[]']:checked").length > 0;

        if (!isChecked) {
            event.preventDefault(); // Prevent form submission
            alert("Please select at least one team.");
        }
    });
		});
	</script>
	</body>

	</html>
