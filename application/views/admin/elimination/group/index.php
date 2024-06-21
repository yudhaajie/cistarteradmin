<?php $this->load->view('admin/layouts/header'); ?>
<?php $this->load->view('admin/layouts/navbar'); ?>
<?php $this->load->view('admin/layouts/sidebar'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<style>
	@media (min-width: 768px) {
		.actions-column {
			width: 100px;
			/* Set your desired width here */
		}
	}
</style>
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
							<div class="d-flex align-items-center justify-content-between w-100">
								<h4><?= $sidebar['subPage'] ?></h4>
								<div class="adv-table-table__button">
									<div class="dropdown">
										<a class="btn btn-primary dropdown-toggle dm-select" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="las la-plus"></i> Create Group
										</a>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
											<a class="dropdown-item" href="<?= base_url('admin/district-elimination/group_management/create?stage=single') ?>">Single Group</a>
											<a class="dropdown-item" href="<?= base_url('admin/district-elimination/group_management/create?stage=multiple') ?>">Multiple Group</a>
										</div>
									</div>
								</div>
								<!-- <div class="action-btn">
									<a href="<?= base_url('admin/district-elimination/group_management/create') ?>" class="btn btn-primary">
									<i class="las la-plus"></i> Create Group
										
									</a>
								</div> -->
							</div>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table4 table5 p-25">
							<div class="table-responsive">
								<table id="datatable" class="table mb-0">
									<thead>
										<tr>
											<th>No</th>
											<th>District</th>
											<th>Group Name</th>
											<th>System</th>
											<th>id</th>
											<th >Action</th>
											<!-- Add more columns as needed -->
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/layouts/footer'); ?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->


<script>
	$(document).ready(function() {
		var table = $('#datatable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo base_url('admin/district-elimination/group_management/get_data'); ?>",
				"type": "POST"
			},
			"columns": [{
					"data": null,
					"render": function(data, type, row, meta) {
						var currentPage = table.page.info().page;
						var pageLength = table.page.info().length;
						var index = currentPage * pageLength + meta.row + 1;
						return index;
					},
					"orderable": true,
					"defaultContent": ""
				},
				{
					"data": "district"
				},
				{
					"data": "name"
				},
				{
					"data": "format"
				},
				{
					"data": "classid", // Assuming the data property for IDs is "id"
					"visible": false
				},
				{
					"data": null,
					"className": "actions-column", // Add a CSS class to the action column
					"render": function(data, type, row) {
						var id = row.classid; // Assuming the row has an "id" property
						var actionsHtml = '<ul class="orderDatatable_actions mb-0 d-flex flex-wrap">' +
							'<li><a href="<?=base_url('admin/district-elimination/group_management/edit/{id}')?>" class="edit"><i class="uil uil-edit"></i></a></li>' +
							'<li><a href="#" class="remove"><i class="uil uil-trash-alt"></i></a></li>' +
							'</ul>';
						return actionsHtml.replace(/{id}/g, id);
					},
					"orderable": false,
				},

			],
			"responsive": true,
			"order": [
				[0, 'asc']
			] // Default sort by the "No" column in ascending order
		});
	});
</script>
</body>

</html>
