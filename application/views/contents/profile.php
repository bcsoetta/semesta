<div ui-view class="app-body" id="view">
  	<div class="row-col b-b">
    	<div class="col-md">
      		<div class="padding">
        		<div class="row-col box">
        			<!-- content -->
        			<div class="item">
						<div class="item-bg">
							<img src="../assets/images/c7.jpg" class="blur opacity-3">
						</div>
						<div class="p-a-md">
							<div class="row m-t">
								<div class="col-sm-7">
									<a href="" class="pull-left m-r-md"> 
										<span class="avatar w-96">
					              			<img src="../assets/images/customs.svg">
					              			<i class="on b-white"></i>
					            		</span>
									</a>
									<div class="clear m-b">
										<h3 class="m-a-0 m-b-xs"><?php echo $udata->name; ?></h3>
										<p class="text-muted">
											<span class="m-r"><?php echo $udata->role; ?></span>
											<!-- <span><i class="fa fa-map-marker m-r-xs"></i>Indonesia</span> -->
										</p> 
										<a href="upassw" class="btn btn-sm warn btn-rounded m-b">Ubah Password</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="padding">
						<div class="row">
							<div class="col-sm-8 col-lg-9">
								<div class="tab-content">
									<div class="tab-pane p-v-sm active" id="tab_4" aria-expanded="true">
										<div class="row m-b">
											<div class="col-xs-6"> <small class="text-muted">Username</small>
												<div class="_500"><?php echo $udata->username; ?></div>
											</div>
											<div class="col-xs-6"> <small class="text-muted">Nama</small>
												<div class="_500"><?php echo $udata->name; ?></div>
											</div>
										</div>
										<div class="row m-b">
											<div class="col-xs-6"> <small class="text-muted">Role</small>
												<div class="_500"><?php echo $udata->role; ?></div>
											</div>
											<div class="col-xs-6"> <small class="text-muted">NIP</small>
												<div class="_500"><?php echo $udata->nip; ?></div>
											</div>
										</div>
										<div class="row m-b">
											<div class="col-xs-6"> <small class="text-muted">Status</small>
												<div class="_500">
													<?php if ($udata->status == 100) { echo 'Aktif'; } elseif ($udata->status == 400) { echo 'Non Aktif'; } else { echo 'Error'; } ?>
												</div>
											</div>
										</div>
										<div> <small class="text-muted">Bio</small>
											<div>Pegawai aktif pada Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta.</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<!-- end content -->
        		</div>
    		</div>
		</div>
	</div>
</div>
