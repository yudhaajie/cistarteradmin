<div class="col-lg-12">
	<div class="breadcrumb-main">
		<h4 class="text-capitalize breadcrumb-title"><?= $bread['title'] ?></h4>
		<div class="breadcrumb-action justify-content-center flex-wrap">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<?php if ($sidebar['page'] == 'dashboard') { ?>
							<i class="uil uil-dashboard"></i> &nbsp;Dashboard</a>
						<?php } else { ?>
							<a href="<?= base_url('admin/dashboard') ?>"><i class="uil uil-dashboard"></i>Dashboard</a>
						<?php } ?>
					</li>
					<?php if ($sidebar['page'] != "dashboard") { ?>
						<li class="breadcrumb-item active" aria-current="page"><?= $sidebar['page'] ?> &nbsp;</li>
					<?php } ?>
				</ol>
			</nav>
		</div>
	</div>
</div>
