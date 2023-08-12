<div class="sidebar-wrapper">
	<div class="sidebar sidebar-collapse" id="sidebar">
		<div class="sidebar__menu-group">
			<ul class="sidebar_nav">
				<li <?= ($sidebar['page'] == 'dashboard') ? "class='active'" : '' ?>>
					<a href="<?= base_url('admin/dashboard') ?>"><span class="nav-icon uil uil-dashboard"></span><span class="menu-text">Dashboard</span></a>
				</li>
				<li class="has-child <?= ($sidebar['page'] == 'district elimination') ? "open" : '' ?>">
					<a href="#" class=""><span class="nav-icon uil uil-pen"></span><span class="menu-text">District Elimination</span><span class="toggle-icon"></span></a>
					<ul>
						<li <?= ($sidebar['subPage'] == 'group management' && $sidebar['page'] == 'district elimination') ? 'class="active"' : ''; ?>><a href="<?= base_url('admin/district-elimination/group_management') ?>">Manage Group</a></li>
						<li <?= ($sidebar['subPage'] == 'classement' && $sidebar['page'] == 'district elimination') ? 'class="active"' : ''; ?>><a href="<?= base_url('admin/district-elimination/classement') ?>">Classement</a></li>
						<li <?= ($sidebar['subPage'] == 'venues' && $sidebar['page'] == 'district elimination') ? 'class="active"' : ''; ?>><a href="<?= base_url('admin/district-elimination/venues') ?>">Venues</a></li>

					</ul>
				</li>
				<li class="has-child <?= ($sidebar['page'] == 'area elimination') ? "open" : '' ?>">
					<a href="#" class=""><span class="nav-icon uil uil-pen"></span><span class="menu-text">Area Elimination</span><span class="toggle-icon"></span></a>
					<ul>
						<li <?= ($sidebar['subPage'] == 'classements' && $sidebar['page'] == 'area elimination') ? 'class="active"' : ''; ?>><a href="<?= base_url('admin/districts-elimination/classement') ?>">Classements</a></li>
						<li <?= ($sidebar['subPage'] == 'venues' && $sidebar['page'] == 'area elimination') ? 'class="active"' : ''; ?>><a href="<?= base_url('admin/eliminations/venues') ?>">Venues</a></li>

					</ul>
				</li>
				<!-- <li <?= ($sidebar['page'] == 'page') ? "class='active'" : '' ?>>
                     <a href="<?= base_url('admin/page') ?>">
                        <span class="nav-icon uil uil-question-circle"></span>
                        <span class="menu-text">Terms & Conditions</span>
                     </a>
                  </li> -->
			</ul>
		</div>
	</div>
</div>
