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
					<div class="col-sm-4">
						<div class="box-header">
							<h3>Penerimaan Total</h3>
							<small>Total penerimaan barang kiriman (dalam rupiah)</small>
						</div>
						<div class="box-body">
							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-3">
									<div style="float: left; padding-left: 5px">Bea Masuk</div>
								</div>
								<div id="nilai_bm" style="text-align: right;" class="col-sm-4"></div>
							</div>
							<div class="box-divider m-a-0"></div>
							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-3">
									<div style="float: left; padding-left: 5px">PPN</div>
								</div>
								<div id="nilai_ppn" style="text-align: right;" class="col-sm-4"></div>
							</div>
							<div class="box-divider m-a-0"></div>
							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-3">
									<div style="float: left; padding-left: 5px">PPh</div>
								</div>
								<div id="nilai_pph" style="text-align: right;" class="col-sm-4"></div>
							</div>
							<div class="box-divider m-a-0"></div>
							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-3">
									<div style="float: left; padding-left: 5px">PPnBM</div>
								</div>
								<div id="nilai_ppnbm" style="text-align: right;" class="col-sm-4"></div>
							</div>
							<div class="box-divider m-a-0"></div>
						</div>
					</div>
					<div class="col-sm-8 grey lt">
						<div class="box-header">
							<h3>Penerimaan barang kiriman per Bulan</h3>
							<small>Total penerimaan barang kiriman per bulan</small>
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-penerimaan" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>PJT Dengan Penerimaan Terbesar</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-imp" style="height:30vh"></div>
						</div>
					</div>

					</div>
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>PJT dengan Bea Masuk Terbesar</h3>
								<!-- <small>10 importir dengan total bea masuk terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-bm" style="height:30vh"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>