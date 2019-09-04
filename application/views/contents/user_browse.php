<style type="text/css">
	.list-item {
		padding-left: 0;
		padding-right: 0;
	}
	.p-edit {
		color: #1F618D !important;
	}
	.p-privil {
		color: #D60850 !important;
		margin-right: 4px;
	}
</style>

<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-4">
		                <div class="box-header">
				            <h3>Jumlah User</h3>
				            <small>Jumlah user berdasarkan otoritas</small>
				          </div>
						<div class="box-body">
							<div class="row">
								<?php foreach ($jr as $r) { if ($r['role'] == 'administrator') { ?>
								<div class="col-xs-6">
									<div class="box p-a">
										<div class="pull-left m-r">	
											<i class="fa fa-user text-2x text-success m-y-sm"></i>
										</div>
										<div class="clear">
											<div class="text-muted">Administrator</div>
											<h4 class="m-a-0 text-md _600"><span><?php echo $r['jrole'] ?></span></h4>
										</div>

									</div>
								</div>
								<?php } elseif ($r['role'] == 'kabid') { ?>
								<div class="col-xs-6">
									<div class="box p-a">
										<div class="pull-left m-r">	
											<i class="fa fa-user text-2x text-warning m-y-sm"></i>
										</div>
										<div class="clear">
											<div class="text-muted">Kabid</div>
											<h4 class="m-a-0 text-md _600"><span><?php echo $r['jrole'] ?></span></h4>
										</div>
									</div>
								</div>
								<?php } elseif ($r['role'] == 'kasi') { ?>
								<div class="col-xs-6">
									<div class="box p-a">
										<div class="pull-left m-r">	
											<i class="fa fa-user text-2x text-warn m-y-sm"></i>
										</div>
										<div class="clear">
											<div class="text-muted">Kasi</div>
											<h4 class="m-a-0 text-md _600"><span><?php echo $r['jrole'] ?></span></h4>
										</div>
									</div>
								</div>
								<?php } elseif ($r['role'] == 'default') { ?>
								<div class="col-xs-6">
									<div class="box p-a">
										<div class="pull-left m-r">	
											<i class="fa fa-user text-2x text-accent m-y-sm"></i>
										</div>
										<div class="clear">
											<div class="text-muted">Pelaksana</div>
											<h4 class="m-a-0 text-md _600"><span><?php echo $r['jrole'] ?></span></h4>
										</div>
									</div>
								</div>
								<?php } elseif ($r['role'] == 'ho') { ?>
									
								<?php } } ?>
								
								
								

								<div class="col-xs-12">
									<div class="row-col box-color text-center primary">
										<?php foreach ($js as $s) { if ($s['status'] == 100) { ?>
											<div class="row-cell p-a">Aktif
												<h4 class="m-a-0 text-md _600"><span href=""><?php echo $s['jstatus'] ?></span></h4>
											</div>
											<?php } elseif ($s['status'] == 400) { ?>
											<div class="row-cell p-a dker">Non Aktif
												<h4 class="m-a-0 text-md _600"><span href=""><?php echo $s['jstatus'] ?></span></h4>
											</div>
										<?php }} ?>
										
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-8 lt light">
						<div class="box-body">
							<div class="input-group m-b">
								<input type="text" id="myInput" class="form-control" placeholder="masukkan nama">
								<span class="input-group-btn">
									<button id="user_search_btn" class="btn white" type="button">Cari</button>
								</span>
							</div>
							<ul class="list inset m-a-0" id="myList"></ul>
							<div id="pagination"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>