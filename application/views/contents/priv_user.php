<style type="text/css">
	.list-item {
		padding-left: 0;
		padding-right: 0;
	}
	.p-remove {
		color: #C0392B !important;
	}
	.p-privil {
		color: #D60850 !important;
		margin-right: 4px;
	}
	.add-privil {
		color: #5D6D7E !important;
		margin-right: 4px;
	}
	.dis-privil {
		color: #C0392B !important;
		margin-right: 4px;
	}
	.ena-privil {
		color: #6cc788 !important;
		margin-right: 4px;
	}
	.nan-privil {
		color: #000 !important;
		margin-right: 4px;
	}

	/* The Modal (background) */
	.modal {
		display: none;
		/* Hidden by default */
		position: fixed;
		/* Stay in place */
		z-index: 1021;
		/* Sit on top */
		padding-top: 100px;
		/* Location of the box */
		left: 0;
		top: 0;
		width: 100%;
		/* Full width */
		height: 100%;
		/* Full height */
		/*overflow: auto;*/
		/* Enable scroll if needed */
		background-color: rgb(0, 0, 0);
		/* Fallback color */
		background-color: rgba(0, 0, 0, 0.4);
		/* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
		position: relative;
		background-color: #fefefe;
		margin: auto;
		padding: 0;
		border: 1px solid #888;
		border-radius: 0 !important;
		width: 60%;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		-webkit-animation-name: animatetop;
		-webkit-animation-duration: 0.4s;
		animation-name: animatetop;
		animation-duration: 0.4s
	}

	@media screen and (max-width: 767px) {
		.modal-content {
			width: 96%;
		}
		.prev-btn {
			margin-top: 5px;
			margin-bottom: 5px;
		}
	}

	/* Add Animation */
	@-webkit-keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}
		to {
			top: 0;
			opacity: 1
		}
	}
	@keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}
		to {
			top: 0;
			opacity: 1
		}
	}

	/* The Close Button */
	.close {
		color: #000;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	.close:hover,
	.close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}
	.modal-header {
		margin-bottom: 10px;
		padding: 6px 16px;
		background-color: #6cc788;
		color: white;
	}
	.modal-body {
		padding: 2px 16px;
	}
	.modal-footer {
		padding: 0 !important;
	}
</style>

<div ui-view class="app-body" id="view">
	<!-- message -->
	<div class="my-message btn btn-fw primary" style="position: fixed; left: 50%; z-index: 10000; display: none;"></div>

	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-4">
		                <div class="box-header">
				            <h3>User Privileges</h3>
				            <small>Tambah atau hapus otoritas</small>
				         </div>
						<div class="box-body">
							<div class="row">

								<div class="col-xs-12 m-b">
									<span class="pull-left"><img src="<?php echo base_url('assets/images/a1.jpg'); ?>" class="w-40 img-circle"></span> 
									<span class="clear hidden-folded p-x">
										<span class="block _500"><?php echo $user->name; ?></span> 
										<small class="block text-muted"><?php echo $user->nip; ?></small>
									</span>
								</div>

								<div class="col-xs-12 m-b">
										<span class="btn btn-sm success btn-rounded m-b">
											<?php if ($user->status == 100) { echo "Aktif"; } else { echo "Tidak Aktif"; } ?>
										</span>
										
									</span>
								</div>

								<!-- The Modal -->
								<div id="myModal" class="modal">
									<!-- Modal content -->
									<div class="modal-content">
										<div class="modal-header"> 
											<span class="close">&times;</span>
									        <span>ref.</span>
										</div>
										<div class="modal-body">
											<div class="input-group m-b">
												<input type="text" id="privref_search" class="form-control" placeholder="masukkan nama privilege">
												<span class="input-group-btn">
													<button id="privref_search_btn" class="btn white" type="button">Cari</button>
												</span>
											</div>
											<ul class="list inset m-a-0" id="myListRef"></ul>
											<div id="paginationz"></div>
										</div>
										<div class="modal-footer"></div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-sm-8 lt light">
						<div class="box-body">
							<form id="form-tambah-role">
								<div class="form-group row">
									<input id="inpUid" type="hidden" name="uid">
									<div class="col-md-4">
										<select id="selApp" class="form-control form-control-sm" name="app">
											<!-- options from javascript -->
										</select>
									</div>
									<div class="col-md-4">
										<select id="selRole" class="form-control form-control-sm" name="role" placeholder="pilih role" disabled="">
											<!-- options from javascript -->
										</select>
									</div>
									<span id="btn-simpan-role" class="btn btn-sm warn btn-rounded m-b">Tambah Otoritas</span>
								</div>
							</form>
							<table id="table-priv-data" class="table m-b-none">
								<thead>
									<tr>
										<th>Aplikasi</th>
										<th>Role</th>
										<th>Aksi</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="row-col">
        			<input class="pull-left btn btn-outline b-black dark prev-btn" style="padding: 4px 6px; border-radius: .1rem; font-size: 14px;" action="action" onclick="window.history.go(-1); return false;" type="button" value="Previous" />
        		</div>
			</div>
		</div>
	</div>
</div>

