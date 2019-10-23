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
					<div class="col-sm-12 col-md-4">
						<div class="box-header">
							<h3>Total Penerimaan per Pungutan</h3>
							<!-- <small>Total penerimaan Terminal</small> -->
						</div>
						<div class="box-divider m-a-0"></div>
						<table id="table-penerimaan-total" class="table m-b-none">
							<thead>
								<tr>
									<th>Pungutan</th>
									<th>Nilai</th>
								</tr>
							<thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="col-sm-12 col-md-8 light lt">
						<div class="box-header">
							<h3>Penerimaan Bulanan per Pungutan</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-penerimaan" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 col-md-4">
						<div class="box-header">
							<h3>Total Bea Masuk per Dokumen</h3>
							<!-- <small>Total penerimaan Terminal</small> -->
						</div>
						<div class="box-divider m-a-0"></div>
						<table id="table-penerimaan-dokumen-total" class="table m-b-none">
							<thead>
								<tr>
									<th>Dokumen</th>
									<th>Nilai</th>
								</tr>
							<thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="col-sm-12 col-md-8 light lt">
						<div class="box-header">
							<h3>Penerimaan Bea Masuk per Dokumen</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-penerimaan-dokumen" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 col-md-4">
						<div class="box-header">
							<h3>Total Dokumen</h3>
							<!-- <small>Total penerimaan Terminal</small> -->
						</div>
						<div class="box-divider m-a-0"></div>
						<table id="table-dokumen-total" class="table m-b-none">
							<thead>
								<tr>
									<th>Dokumen</th>
									<th>Jumlah</th>
								</tr>
							<thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="col-sm-12 col-md-8 light lt">
						<div class="box-header">
							<h3>Jumlah Dokumen per Bulan</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-dokumen-bulan" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-12 light lt">
						<div class="box-header">
							<h3>Perbandingan Netto - BM</h3>
							<!-- <small>Total penerimaan terminal per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-netto-bm" style="width: 100%; height: 40vh;"></div>
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
							<table id="table-netto-bm" class="table m-b-none">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th id="tbl-last-detail" colspan="6"></th>
										<th id="tbl-curr-detail" colspan="6"></th>
									</tr>
									<tr>
										<th></th>
										<th>Bulan</th>
										<th>BM<br>(juta Rp)</th>
										<th>BM Kumulatif<br>(juta Rp)</th>
										<th>Nilai Pabean<br>(juta Rp)</th>
										<th>Nilai Pabean Kumulatif<br>(juta Rp)</th>
										<th>Berat<br>(ton)</th>
										<th>Berat Kumulatif<br>(ton)</th>
										<th>BM<br>(juta Rp)</th>
										<th>BM Kumulatif<br>(juta Rp)</th>
										<th>Nilai Pabean<br>(juta Rp)</th>
										<th>Nilai Pabean Kumulatif<br>(juta Rp)</th>
										<th>Berat<br>(ton)</th>
										<th>Berat Kumulatif<br>(ton)</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>