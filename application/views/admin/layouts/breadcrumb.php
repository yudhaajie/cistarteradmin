<div class="col-lg-12">
	<div class="breadcrumb-main">
		<h4 class="text-capitalize breadcrumb-title"><?= $sidebar['page'] ?></h4>
		<div class="breadcrumb-action justify-content-center flex-wrap d-none d-sm-block">
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
						<li class="breadcrumb-item active" aria-current="page"><?= $sidebar['page'] ?></li>
					<?php } ?>
					<?php if($sidebar['subPage'] and $sidebar['minorPage'] != Null){ ?>
						 <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('admin/'.$sidebar['pageLink'].'/'.$sidebar['subPageLink']) ?>"><?= $sidebar['subPage'] ?></a> &nbsp;</li>
					<?php }else{ ?>
						<li class="breadcrumb-item active" aria-current="page"><?= $sidebar['subPage'] ?> &nbsp;</li>
						<?php }?>
					<?php if($sidebar['minorPage']){ ?>
						<li class="breadcrumb-item active" aria-current="page"><?= $sidebar['minorPage'] ?> &nbsp;</li>
					<?php }?>
				</ol>
			</nav>
		</div>
	</div>
</div>
