<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-body">
							<form action="#" id="form_imp">
								<div class="col-sm-6 form-group">
								</div>
								<div class="col-sm-2 form-group">
									<div class='input-group date' id="start_date" name="start_date" ui-jp="datetimepicker" ui-options="{
											format: 'DD/MM/YYYY',
											icons: {
												time: 'fa fa-clock-o',
												date: 'fa fa-calendar',
												up: 'fa fa-chevron-up',
												down: 'fa fa-chevron-down',
												previous: 'fa fa-chevron-left',
												next: 'fa fa-chevron-right',
												today: 'fa fa-screenshot',
												clear: 'fa fa-trash',
												close: 'fa fa-remove'
											}
										}">
										<input type='text' class="form-control" id="start_date" name="start_date" placeholder="Tanggal Awal" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-sm-1 text-center">
									<label class="form-control-label">s.d.</label>
								</div>
								<div class="col-sm-2 form-group">
									<div class='input-group date' id="end_date" name="end_date" ui-jp="datetimepicker" ui-options="{
											format: 'DD/MM/YYYY',
											icons: {
												time: 'fa fa-clock-o',
												date: 'fa fa-calendar',
												up: 'fa fa-chevron-up',
												down: 'fa fa-chevron-down',
												previous: 'fa fa-chevron-left',
												next: 'fa fa-chevron-right',
												today: 'fa fa-screenshot',
												clear: 'fa fa-trash',
												close: 'fa fa-remove'
											}
										}">
										<input type='text' class="form-control" id="end_date" name="end_date" placeholder="Tanggal Akhir" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-sm-1">
									<button type="submit" class="btn rounded success">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header">
							<h3>Detail Perbandingan BM - Nilai Pabean - Netto</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<table id="table-komoditi" class="table m-b-none">
								<thead>
									<tr>
										<th></th>
										<th colspan="2" style="text-align: center">Importasi</th>
										<th colspan="2" style="text-align: center">Berat</th>
										<th colspan="2" style="text-align: center">Nilai Pabean</th>
										<th colspan="2" style="text-align: center">BM</th>
										<th></th>
									</tr>
									<tr>
										<th style="text-align: center">Kategori</th>
										<th class="tbl-last-detail" style="text-align: center"></th>
										<th class="tbl-this-detail" style="text-align: center"></th>
										<th class="tbl-last-detail" style="text-align: center"></th>
										<th class="tbl-this-detail" style="text-align: center"></th>
										<th class="tbl-last-detail" style="text-align: center"></th>
										<th class="tbl-this-detail" style="text-align: center"></th>
										<th class="tbl-last-detail" style="text-align: center"></th>
										<th class="tbl-this-detail" style="text-align: center"></th>
										<th style="text-align: center">Detail</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 light lt">
						<div class="box-header">
							<h3>BM Per Kategori</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-kategori-bm-bulan" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 light lt">
						<div class="box-header">
							<h3>Nilai Pabean Per Kategori</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-kategori-nilai-bulan" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 light lt">
						<div class="box-header">
							<h3>Berat Per Kategori</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-kategori-berat-bulan" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 light lt">
						<div class="box-header">
							<h3>Jumlah Dokumen Per Kategori</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-kategori-dok-bulan" style="width: 100%; height: 40vh;"></div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>

<!-- modal detail komoditi -->
<div id="modal-detail" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Komoditi</h5>
			</div>
			<div class="modal-body p-lg">
				<div class="m-b-2">
					<div id="chart-kategori-detil" style="width: 100%; height: 40vh;"></div>	
				</div>
				<h6>Uraian barang</h6>
				<table id="table-komoditi-detail" class="table m-b-none">
					<thead>
						<tr>
							<th>Dokumen</th>
							<th>Terminal</th>
							<th>No CD/PIBK</th>
							<th>Tgl Dok</th>
							<th>Uraian Barang</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal detail komoditi -->