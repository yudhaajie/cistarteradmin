<?php $this->load->view('admin/layouts/header'); ?>
<?php $this->load->view('admin/layouts/navbar'); ?>
<?php $this->load->view('admin/layouts/sidebar'); ?>
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
						<div class="d-flex justify-content-between w-100">
								<div><?=$sidebar['subPage']?></div>
								<div class="action-btn">
									<a href="#" class="btn btn-primary">
										Export
										<i class="las la-angle-down"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table4 table5 p-25">
							<div class="table-responsive">
								<table class="table mb-0">
									<thead>
										<tr class="userDatatable-header">
											<th>
												<div class="userDatatable-title">
													Age
													<div class="d-flex justify-content-between align-items-center w-100">
														<span class="userDatatable-sort">
															<i class="fas fa-caret-down"></i>
														</span>
														<span class="userDatatable-filter">
															<i class="fas fa-filter"></i>
														</span>
													</div>
												</div>
											</th>
											<th>
												<div class="userDatatable-title">
													Age
													<div class="d-flex justify-content-between align-items-center w-100">
														<span class="userDatatable-sort">
															<i class="fas fa-sort-up up"></i>
															<i class="fas fa-caret-down down"></i>
														</span>
														<span class="userDatatable-filter">
															<i class="fas fa-filter"></i>
														</span>
													</div>
												</div>
											</th>
											<th>
												<div class="userDatatable-title">
													Address
													<div class="d-flex justify-content-between align-items-center w-100">
														<span class="userDatatable-sort">
															<i class="fas fa-sort-up up"></i>
															<i class="fas fa-caret-down down"></i>
														</span>
														<span class="userDatatable-filter">
															<i class="fas fa-filter"></i>
														</span>
													</div>
												</div>
											</th>
										</tr>
									</thead>
									<tbody>

										<tr>
											<td>
												<div class="userDatatable-content">
													Mike
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													32
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													10 Herry Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Jhon
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													2
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													34 Lolona Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Hulk
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													4
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													5 Rigliah Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Percy Jacksion
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													5
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													24 Downing Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Donald
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													7
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													5 Downing Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Mac Jons
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													8
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													18 Downing Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Hery
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													15
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													5 Downing Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Jhon Bush
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													18
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													85 Downing Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Rabin
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													23
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													5 Downing Street
												</div>
											</td>
										</tr>


										<tr>
											<td>
												<div class="userDatatable-content">
													Herry
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													28
												</div>
											</td>
											<td>
												<div class="userDatatable-content">
													12 Downing Street
												</div>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
							<div class="d-flex justify-content-end mt-30">
								<div class="pagination-total-text">1-3 of 8 items</div>

								<nav class="dm-page ">
									<ul class="dm-pagination d-flex">
										<li class="dm-pagination__item">
											<a href="#" class="dm-pagination__link pagination-control"><span class="la la-angle-left"></span></a>
											<a href="#" class="dm-pagination__link"><span class="page-number">1</span></a>
											<a href="#" class="dm-pagination__link active"><span class="page-number">2</span></a>
											<a href="#" class="dm-pagination__link"><span class="page-number">3</span></a>
											<a href="#" class="dm-pagination__link pagination-control"><span class="page-number">...</span></a>
											<a href="#" class="dm-pagination__link"><span class="page-number">12</span></a>
											<a href="#" class="dm-pagination__link pagination-control"><span class="la la-angle-right"></span></a>
											<a href="#" class="dm-pagination__option">
											</a>
										</li>
										<li class="dm-pagination__item">
											<div class="paging-option">
												<select name="page-number" class="page-selection">
													<option value="20">20/page</option>
													<option value="40">40/page</option>
													<option value="60">60/page</option>
												</select>
											</div>
										</li>
									</ul>
								</nav>


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
