<style type="text/css">
	.list-item {
		padding-left: 0;
		padding-right: 0;
	}
	.p-score {
		color: #1F618D !important;
	}
	.p-score-hide {
		display: none;
	}
	.p-hadir {
		color: #0f8e0f !important;
	}
	.p-thadir {
		color: red !important;
	}
	.box-header-block {
		margin-bottom: 15px;
	}
	.box-header-block h4 {
		text-decoration: underline;
	}
	.detx {
		margin-top: 5px;
		borde/*r: 1px solid #000;
		padding: 3px 5px;*/
	}
	.box {
		margin-bottom: 0.8rem;
	}

	.list-item {
		padding-left: 0;
		padding-right: 0;
	}
	.p-remove {
		color: #C0392B !important;
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
	.modal-list2 {
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
		overflow: hidden;
		/* Enable scroll if needed */
		background-color: rgb(0, 0, 0);
		/* Fallback color */
		background-color: rgba(0, 0, 0, 0.4);
		/* Black w/ opacity */
	}

	/* The Modal (background) */
	.modal-list {
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
		overflow: hidden;
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
	.efektif {
		color: green;
		font-weight: 700;
	}
	.tefektif {
		color: red;
		font-weight: 700;
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
		                	<div class="box-header-block">
		                		<h4>Tema</h4>
				            	<div class="detx"><?php echo $ppkp[0]['tema'] ?></div>
		                	</div>
				            <div class="box-header-block">
					            <h4>Tempat</h4>
					            <div class="detx"><?php echo $ppkp[0]['tempat'] ?></div>
					        </div>
					        <div class="box-header-block">
					            <h4>Tanggal / Waktu</h4>
					            <div class="detx"><?php $tanggal = date_create($ppkp[0]['tanggal']); echo date_format($tanggal, 'D, d M Y'); ?> / Pukul <?php $waktu_mulai = date_create($ppkp[0]['waktu_mulai']); echo date_format($waktu_mulai, 'h.i'); ?> s.d. <?php $waktu_selesai = date_create($ppkp[0]['waktu_selesai']); echo date_format($waktu_selesai, 'h.i'); ?> WIB</div>
					        </div>
					        <div class="box-header-block">
					            <h4>ND/UND</h4>
					            <div class="detx">
					            	<?php echo "NO. " . $ppkp[0]['nomor_surat'] ?>
					            	<?php $tanggal = date_create($ppkp[0]['tanggal_surat']); echo "Tgl. " . date_format($tanggal, 'D, d M Y'); ?>
					            </div>
					        </div>
					        <div class="box-header-block">
					            <h4>Status</h4>
					            <div class="detx"><?php echo $ppkp[0]['status'] ?></div>
					        </div>
					        <div class="box-header-block" style="margin-bottom: -20px;">
					            <h4>Peserta</h4>
					            <div class="detx">
					            	<div class="detx kehadiran">Undangan <b><span class="jum_peserta"><?php echo $ppkp[0]['jum_peserta']; ?></span></b>, hadir <b><span class="hadir"><?php echo $ppkp[0]['hadir'] ?></span></b>, tidak hadir <b><span class="tidak_hadir"><?php echo $ppkp[0]['tidak_hadir'] ?></span></b></div>
					            	<br>
					            	<button id="myBtnRef" class="md-btn md-raised m-b-sm p-x success">Tambah Peserta</button>
					            	<br>
					            	<br>
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

				<!-- The Modal -->
				<div id="myModal" class="modal-list">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="modal-header"> 
							<span class="close">&times;</span>
					        <span>List</span>
						</div>
						<div class="modal-body">
							<div class="input-group m-b">
								<input type="text" id="privref_search" class="form-control" placeholder="masukkan nama">
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

				<!-- The Modal -->
				<div id="myModal2" class="modal-list2">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="modal-header"> 
							<span class="close">&times;</span>
					        <span id="scoring-title">Score</span>
						</div>
						<div class="modal-body">
							<div>
								<p class="text-muted">Silahkan isi nilai Pre Test dan Post Test</p>
								<div class="form-group">
									<label>Pre Test</label>
									<input type="text" class="form-control" id="pre-test">
								</div>
								<div class="form-group">
									<label>Post Test</label>
									<input type="text" class="form-control" id="post-test">
								</div>
								<input type="hidden" id="tbid">
							</div>
						</div>
						<div class="modal-footer">
							<div class="dker p-a text-right">
								<button id="btn-scoring" type="submit" class="btn info">Simpan</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row-col">
        			<input class="pull-left btn btn-outline b-black dark" style="padding: 4px 6px; border-radius: .1rem; font-size: 14px;" action="action" onclick="window.history.go(-1); return false;" type="button" value="Previous" />
        		</div>
			</div>
		</div>
	</div>
</div>