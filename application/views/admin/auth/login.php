<!doctype html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>HexaDash</title>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/bootstrap/bootstrap.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/daterangepicker.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/fontawesome.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/footable.standalone.min.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/fullcalendar@5.2.0.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/jquery-jvectormap-2.0.5.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/leaflet.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/line-awesome.min.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/magnific-popup.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/MarkerCluster.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/MarkerCluster.Default.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/slick.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/star-rating-svg.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/trumbowyg.min.css">
	<link rel="stylesheet" href="assets/admin/vendor_assets/css/wickedpicker.min.css">
	<link rel="stylesheet" href="assets/admin/style.css">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
</head>

<body>
	<main class="main-content">
		<div class="admin">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-xxl-3 col-xl-4 col-md-6 col-sm-8">
						<div class="edit-profile">
							<div class="edit-profile__logos"><a href="index.html"><img class="dark" src="<?= base_url('assets/admin/img/logo-dark.png') ?>" alt=""><img class="light" src="<?= base_url('assets/admin/img/logo-white.png') ?>" alt=""></a></div>
							<div class="card border-0">
								<div class="card-header">
									<div class="edit-profile__title">
										<h6>Sign in</h6>
									</div>
								</div>
								<div class="card-body">
									<form method="post" action="<?= base_url('admin/dashboard') ?>">
										<div class="edit-profile__body">
											<div class="form-group mb-25"><label for="username">Username or Email Address</label><input type="text" class="form-control" id="username" placeholder="name@example.com"></div>
											<div class="form-group mb-15"><label for="password-field">password</label>
												<div class="position-relative"><input id="password-field" type="password" class="form-control" name="password" placeholder="Password">
													<div class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></div>
												</div>
											</div>
											<div class="admin-condition">
												<div class="checkbox-theme-default custom-checkbox "><input class="checkbox" type="checkbox" id="check-1"><label for="check-1"><span class="checkbox-text">Keep me logged in</span></label></div><a href="forget-password.html">forget password?</a>
											</div>
											<div class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center"><button class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal px-50 signIn-createBtn " type="submit">sign in </button></div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<div id="overlayer">
		<div class="loader-overlay">
			<div class="dm-spin-dots spin-lg"><span class="spin-dot badge-dot dot-primary"></span><span class="spin-dot badge-dot dot-primary"></span><span class="spin-dot badge-dot dot-primary"></span><span class="spin-dot badge-dot dot-primary"></span></div>
		</div>
	</div>
	<div class="enable-dark-mode dark-trigger">
		<ul>
			<li><a href="#"><i class="uil uil-moon"></i></a></li>
		</ul>
	</div>
	<script src="assets/admin/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery/jquery-ui.js"></script>
	<script src="assets/admin/vendor_assets/js/bootstrap/popper.js"></script>
	<script src="assets/admin/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
	<script src="assets/admin/vendor_assets/js/moment/moment.min.js"></script>
	<script src="assets/admin/vendor_assets/js/accordion.js"></script>
	<script src="assets/admin/vendor_assets/js/apexcharts.min.js"></script>
	<script src="assets/admin/vendor_assets/js/autoComplete.js"></script>
	<script src="assets/admin/vendor_assets/js/Chart.min.js"></script>
	<script src="assets/admin/vendor_assets/js/daterangepicker.js"></script>
	<script src="assets/admin/vendor_assets/js/drawer.js"></script>
	<script src="assets/admin/vendor_assets/js/dynamicBadge.js"></script>
	<script src="assets/admin/vendor_assets/js/dynamicCheckbox.js"></script>
	<script src="assets/admin/vendor_assets/js/footable.min.js"></script>
	<script src="assets/admin/vendor_assets/js/fullcalendar@5.2.0.js"></script>
	<script src="assets/admin/vendor_assets/js/google-chart.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery-jvectormap-2.0.5.min.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery.countdown.min.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery.filterizr.min.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery.magnific-popup.min.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery.peity.min.js"></script>
	<script src="assets/admin/vendor_assets/js/jquery.star-rating-svg.min.js"></script>
	<script src="assets/admin/vendor_assets/js/leaflet.js"></script>
	<script src="assets/admin/vendor_assets/js/leaflet.markercluster.js"></script>
	<script src="assets/admin/vendor_assets/js/loader.js"></script>
	<script src="assets/admin/vendor_assets/js/message.js"></script>
	<script src="assets/admin/vendor_assets/js/moment.js"></script>
	<script src="assets/admin/vendor_assets/js/muuri.min.js"></script>
	<script src="assets/admin/vendor_assets/js/notification.js"></script>
	<script src="assets/admin/vendor_assets/js/popover.js"></script>
	<script src="assets/admin/vendor_assets/js/select2.full.min.js"></script>
	<script src="assets/admin/vendor_assets/js/slick.min.js"></script>
	<script src="assets/admin/vendor_assets/js/trumbowyg.min.js"></script>
	<script src="assets/admin/vendor_assets/js/wickedpicker.min.js"></script>
	<script src="assets/admin/theme_assets/js/apexmain.js"></script>
	<script src="assets/admin/theme_assets/js/charts.js"></script>
	<script src="assets/admin/theme_assets/js/drag-drop.js"></script>
	<script src="assets/admin/theme_assets/js/footable.js"></script>
	<script src="assets/admin/theme_assets/js/full-calendar.js"></script>
	<script src="assets/admin/theme_assets/js/googlemap-init.js"></script>
	<script src="assets/admin/theme_assets/js/icon-loader.js"></script>
	<script src="assets/admin/theme_assets/js/jvectormap-init.js"></script>
	<script src="assets/admin/theme_assets/js/leaflet-init.js"></script>
	<script src="assets/admin/theme_assets/js/main.js"></script>
</body>

</html>
