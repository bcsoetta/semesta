<style type="text/css">
	.nav-sub li a, .nav-text {
		text-transform: capitalize;
	}
</style>

<body>

	<div class="app" id="app">

		<!-- aside -->

		<div id="aside" class="app-aside modal fade sm nav-dropdown">
			<div class="left navside grey dk" layout="column">
				<div class="navbar no-radius">
					<!-- brand -->
					<a class="navbar-brand" href="<?php echo base_url(); ?>">
						<img src="<?php echo base_url('assets/images/location-pin.png'); ?>">
					</a>
					<!-- / brand -->
				</div>
				<div flex class="hide-scroll">
					<nav class="scroll nav-border b-primary">
						<ul class="nav" ui-nav>
							<li style="margin-bottom: 1rem;"></li>
							<li>
								<a href="<?php echo base_url('/'); ?>"> 
									<span class="nav-icon"><i class="material-icons">layers</i></span>
									<span class="nav-text">Dashboard</span>
								</a>
							</li>

							<?php echo $menus; ?>
							
						</ul>
					</nav>
				</div>
				<div flex-no-shrink>
					<nav ui-nav>
						<ul class="nav">
							<li><div class="b-b b m-v-sm"></div></li>
							<li class="no-bg">
								<a href="<?php echo base_url('/user/logout'); ?>">
									<span class="nav-icon"><i class="material-icons">&#xe8ac;</i></span>
									<span class="nav-text">Logout</span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<!-- / aside -->