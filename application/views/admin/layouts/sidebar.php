<div class="sidebar-wrapper">
	<div class="sidebar sidebar-collapse" id="sidebar">
		<div class="sidebar__menu-group">
			<ul class="sidebar_nav">
				<li <?= ($sidebar['page'] == 'dashboard') ? "class='active'" : '' ?>>
					<a href="<?= base_url('admin/dashboard') ?>"><span class="nav-icon uil uil-dashboard"></span><span class="menu-text">Dashboard</span></a>
				</li>
				<li class="has-child <?= ($sidebar['page'] == 'post') ? "open" : '' ?>">
					<a href="#" class=""><span class="nav-icon uil uil-pen"></span><span class="menu-text">Post</span><span class="toggle-icon"></span></a>
					<ul>
						<li <?= ($sidebar['subPage'] == 'all-post') ? 'class="active"' : ''; ?>><a href="<?=base_url('admin/post')?>">Semua Pos</a></li>
						<li class="l_sidebar"><a href="#" data-layout="dark">Dark Mode</a></li>
					</ul>
				</li>
				<!-- <li class="has-child"><a href="#" class=""><span class="nav-icon uil uil-window-section"></span><span class="menu-text">Themes</span><span class="toggle-icon"></span></a>
					<ul>
						<li class="l_sidebar"><a href="#" data-layout="light">Light Mode</a></li>
						<li class="l_sidebar"><a href="#" data-layout="dark">Dark Mode</a></li>
					</ul>
				</li> -->
				<!-- <li><a href="changelog.html" class=""><span class="nav-icon uil uil-arrow-growth"></span><span class="menu-text">Changelog</span><span class="badge badge-info-10 menuItem rounded-pill">1.1.6</span></a></li> -->
				<!-- <li><a href="chat.html" class=""><span class="nav-icon uil uil-chat"></span><span class="menu-text">Chat</span><span class="badge badge-success menuItem rounded-circle">3</span></a></li> -->
				<li class="has-child"><a href="#" class=""><span class="nav-icon uil uil-bag"></span><span class="menu-text text-initial">eCommerce</span><span class="toggle-icon"></span></a>
					<ul>
						<li class=""><a href="products.html">Products</a></li>
						<li class=""><a href="product-details.html">Product Details</a></li>
						<li class=""><a href="add-product.html">Product Add</a></li>
						<li class=""><a href="add-product.html">Product Edit</a></li>
						<li class=""><a href="cart.html">Cart</a></li>
						<li class=""><a href="order.html">Orders</a></li>
						<li class=""><a href="sellers.html">Sellers</a></li>
						<li class=""><a href="invoice.html">Invoices</a></li>
					</ul>
				</li>
				<li <?= ($sidebar['page'] == 'page') ? "class='active'" : '' ?>>
                     <a href="<?=base_url('admin/page')?>">
                        <span class="nav-icon uil uil-question-circle"></span>
                        <span class="menu-text">Terms & Conditions</span>
                     </a>
                  </li>
			</ul>
		</div>
	</div>
</div>
