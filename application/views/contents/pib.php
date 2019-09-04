<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-4">
						<div class="box-header">
							<h3>Jumlah PIB</h3>
						</div>
						<div class="box-body">
							<div class="text-muted">Total PIB Periode Jan s.d. Feb 2019</div>
						<div class="text-md m-b-md font-bold">234,344,450</div>
						<div>
							<div class="m-b"> 
								<i class="fa text-3x pull-left fa-circle text-success"></i>
								<div class="clear"> 
									<span>9,632,000</span>
									<div class="text-muted">Hijau</div>
								</div>
							</div>
							<div class="m-b"> 
								<i class="fa text-3x pull-left fa-circle" style="color: #d87a80;"></i>
								<div class="clear"> 
									<span>23,200,000</span>
									<div class="text-muted">Merah</div>
								</div>
							</div>
							<div class="m-b"> 
								<i class="fa text-3x pull-left fa-circle" style="color: #FFBD33;"></i>
								<div class="clear"> 
									<span>23,200,000</span>
									<div class="text-muted">Kuning</div>
								</div>
							</div>
							<div class="m-b"> 
								<i class="fa text-3x pull-left fa-circle" style="color: #BB8FCE;"></i>
								<div class="clear"> 
									<span>23,200,000</span>
									<div class="text-muted">RH</div>
								</div>
							</div>
							<div class="m-b"> 
								<i class="fa text-3x pull-left fa-circle" style="color: #3498DB;"></i>
								<div class="clear"> 
									<span>23,200,000</span>
									<div class="text-muted">MITA</div>
								</div>
							</div>
						</div>
						</div>
						
					</div>
					<div class="col-sm-8 lt light">
						<div class="box-header">
							<!-- <i class="material-icons md-18" style="float: right;">more_vert</i> -->
	<!-- 						<h3>Jumlah PIB</h3> -->
							<small>Total Jumlah PIB Per Bulan Berdasarkan Jalur</small>
						</div>
						<div ui-jp="plot" ui-refresh="app.setting.color" class="box-body">
							<div id="pibx" style="height: 350px;">
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Your Sales</h3>
								<small>A general overview of your sales</small>
							</div>
							<div class="box-tool">
								<ul class="nav">
									<li class="nav-item inline dropdown">
										<a class="nav-link" data-toggle="dropdown"> 
											<i class="material-icons md-18">&#xe5d4;</i>
										</a>
									</li>
								</ul>
							</div>
							<div class="box-body">
								<div id="dataz" style="height: 350px;"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Your projects</h3>
								<small>Calculated in last 30 days</small>
							</div>
							<div class="box-tool">
								<ul class="nav">
									<li class="nav-item inline">
										<a class="nav-link"> <i class="material-icons md-18">&#xe863;</i>
										</a>
									</li>
									<li class="nav-item inline dropdown">
										<a class="nav-link" data-toggle="dropdown"> <i class="material-icons md-18">&#xe5d4;</i>
										</a>
										<div class="dropdown-menu dropdown-menu-scale pull-right"> <a class="dropdown-item" href>This week</a>
											<a class="dropdown-item" href>This month</a>
											<a class="dropdown-item" href>This week</a>
											<div class="dropdown-divider"></div> <a class="dropdown-item">Today</a>
										</div>
									</li>
								</ul>
							</div>
							<div class="box-body">
								<div id="datax" style="height: 350px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- PAGE END-->
</div>