<style type="text/css">
	.list-item {
		padding-left: 0;
		padding-right: 0;
	}
	.p-score {
		color: #f77a99 !important;
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
	#tglawal, #tglakhir {
		/*/font-size: 13px !important;*/
	}

</style>

<link rel="stylesheet" href="<?php echo base_url('assets/libs/jquery/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'); ?>" type="text/css" />

<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-4">
		                <div class="box-header">
		                	<div class="box-header-block">
		                		<h4 style="margin-bottom: 10px;">Tgl. S/ND/UND</h4>
				            	<div class="detx">
				            		<div class="form-group">
										<div class='input-group date' id='datetimepicker1'>
											<input type='text' id="tglawal" class="form-control"/>
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>
										</div>
										<div class='input-group date detx' id='datetimepicker2'>
											<input type='text' id="tglakhir" class="form-control"/>
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>
										</div>
									</div>
				            	</div>
				            	
		                	</div>
				            <div class="box-header-block">
					            <h4>Jumlah PPKP</h4>
					            <div class="detx"><?php echo $jum_ppkp[0]['jum_ppkp']; ?></div>
					        </div>
					        <div class="box-header-block">
					            <h4>Skor seluruh PPKP</h4>
					            <div class="detx"><?php echo round($score['jum_score'], 4); ?></div>
					        </div>
					        <div class="box-header-block">
					            <h4>Skor akhir</h4>
					            <div class="detx"><?php echo round($score['score'], 4); ?></div>
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

			</div>
		</div>
	</div>
</div>