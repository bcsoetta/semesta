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
									<input type="text" class="form-control" id="src_pdtt" name="src_pdtt" placeholder="Petugas PDTT" autocomplete="off">
									<input type="text" name="id_pdtt" id="id_pdtt" style="display: none">
									<div id="src_result" class="src-result box col-sm-10"></div>
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
				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Jumlah Penerimaan Barang Kiriman per Bulan</h3>
								<!-- <small>Total jumlah PIB per bulan berdasarkan jalur</small> -->
							</div>
							<div class="box-body">
								
								<div id="chart-penerimaan" style="width: 100%; height: 30vh;"></div>

							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Jumlah Jalur Barang Kiriman per Bulan</h3>
								<!-- <small>Total jumlah PIB per bulan berdasarkan jalur</small> -->
							</div>
							<div class="box-body">
								
								<div id="chart-jalur" style="width: 100%; height: 30vh;"></div>

							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<h3>Detil per Bulan</h3>
								<!-- <small>10 PJT dengan jumlah barang kiriman terbanyak</small> -->
							</div>
							<div class="box-divider m-a-0"></div>
							<table id="table-detil" class="table m-b-none"></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>