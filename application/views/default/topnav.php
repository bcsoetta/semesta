<div class="app-header white box-shadow">
	<div class="navbar">
		<!-- Open side - Naviation on mobile -->
		<a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up"> <i class="material-icons">&#xe5d2;</i>
		</a>
		<!-- / -->
		<!-- Page title - Bind to $state's title -->
		<div class="navbar-item pull-left h5" ng-bind="$state.current.data.title" id="pageTitle"></div>

		<!-- navbar left -->	
		<ul class="white nav navbar-nav pull-left" style="margin-bottom: 0; margin-left: -0.4rem; padding: 1.1rem 1rem .75rem 1rem;">
			<li class="breadcrumb-item">
				<span class="text-black" style="text-transform: capitalize;"><?php echo $class; ?></span>
				<span class="text-muted" style="font-size: 12px;">/</span>
				<span class="text-muted"><?php echo $hal; ?></span>
			</li>
	    </ul>

		<!-- navbar right -->
		<ul class="nav navbar-nav pull-right">
			<li class="nav-item dropdown pos-stc-xs">
				<a class="nav-link" href data-toggle="dropdown"> 
					<i class="material-icons">&#xe7f5;</i>
					<span class="label label-sm up warn">3</span>
				</a>
				<!-- dropdown -->
				<div class="dropdown-menu pull-right w-xl animated fadeInUp no-bg no-border no-shadow">
					<div class="scrollable" style="max-height: 220px">
						<ul class="list-group list-group-gap m-a-0">
							<li class="list-group-item black lt box-shadow-z0 b"> 
								<span class="clear block">
						            Update <a href class="text-primary">dokumentasi</a> semesta<br>
						            <small class="text-muted">10 minutes ago</small>
					          	</span>
							</li>
							<li class="list-group-item black lt box-shadow-z0 b">
								<span class="clear block">
									<a href class="text-primary">Setiadi</a> update kemanaan semesta<br>
									<small class="text-muted">2 hours ago</small>
								</span>
							</li>
							<li class="list-group-item dark-white text-color box-shadow-z0 b"> 
								<span class="clear block">
						            <a href class="text-primary">Doni</a> mengirim pesan penting<br>
						            <small class="text-muted">1 day ago</small>
						        </span>
							</li>
						</ul>
					</div>
				</div>
				<!-- / dropdown -->
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link clear" href data-toggle="dropdown"> 
					<span class="hidden-md-down nav-text m-l-sm text-left">
					    <span class="_500"><?php echo $_SESSION['name']; ?></span>
					    <small class="text-muted">Group: <?php echo $_SESSION['role']; ?></small>
					</span>
					&nbsp;&nbsp;
					<span class="avatar w-32">
	                   <img src="<?php echo base_url('assets/images/customs.svg'); ?>">
	                   <i class="on b-white bottom"></i>
             		</span>
				</a>
				<div class="dropdown-menu pull-right animated fadeInUp no-bg no-border no-shadow">
					<div class="scrollable" style="max-height: 220px">
						<ul class="list-group list-group-gap m-a-0">
							<li class="list-group-item dark-white text-color box-shadow-z0 b">
								<span class="clear block dropdown-x">
						            <a href="<?php echo base_url(); ?>user/info" class="text-primary">
						            	<span>Info</span>
						            	<span class="label warn m-l-xs">3</span>
						            </a><br>
						            <div style="margin-bottom: 5px;"></div>
						            <a href="<?php echo base_url(); ?>user/profile" class="text-primary">
						            	<span>Lihat Profile</span>
						            </a><br>
						            <div style="margin-bottom: 5px;"></div>
						            <a href="<?php echo base_url(); ?>user/upassw" class="text-primary">
						            	<span>Ubah Password</span>
						            </a><br>
						            <div class="dropdown-divider"></div>
						            <a href="<?php echo base_url(); ?>user/logout" class="text-warning">
						            	<span>Sign out</span>
						            </a>
						        </span>
							</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>
		<!-- / navbar right -->
	</div>
</div>