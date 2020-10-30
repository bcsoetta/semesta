<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START ############ -->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<!-- Date filter -->
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

				<!-- Chart nilai pabean -->
				<div class="row-col box">
					
					<!-- Chart pie -->
					<div class="col-sm-5">
						<div class="box-header">
							<h3>Nilai Pabean</h3>
							<small class="block text-muted">Nilai pabean dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-pie-nilai" style="height: 50vh;"></div>
						</div>
					</div>

					<!-- Chart stack -->
					<div class="col-sm-7">
						<div class="box-header">
							<h3>&nbsp;</h3>
							<small class="block text-muted">Nilai pabean per bulan dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-stack-nilai" style="height: 50vh;"></div>
						</div>
					</div>
				</div>

				<!-- Chart bea masuk -->
				<div class="row-col box">
					
					<!-- Chart pie -->
					<div class="col-sm-5">
						<div class="box-header">
							<h3>Bea Masuk</h3>
							<small class="block text-muted">Bea masuk dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-pie-bm" style="height: 50vh;"></div>
						</div>
					</div>

					<!-- Chart stack -->
					<div class="col-sm-7">
						<div class="box-header">
							<h3>&nbsp;</h3>
							<small class="block text-muted">Bea masuk per bulan dalam miliar rupiah</small>
						</div>
						<div class="box-body">
							<div id="chart-stack-bm" style="height: 50vh;"></div>
						</div>
					</div>
				</div>

				<div class="row-col box">
					<div class="col-sm-8">
						<div class="box-header">
							<h3>Daftar Komoditi</h3>
						</div>
						<div class="box-divider m-a-0"></div>

						<div class="box-body">
							<table id="table-data-hs" class="table table-striped row-border m-b-none">
								<thead>
									<tr>
										<th rowspan="3" class="text-center align-middle border-left">Kode HS</th>
										<th rowspan="3" class="text-center align-middle border-left">Jml PIB</th>
										<th rowspan="3" class="text-center align-middle border-left">Nilai Pabean (juta Rp)</th>
										<th colspan="16" class="text-center border-left border-right">Pungutan (juta Rp)</th>
									</tr>
									<tr>
										<th colspan="4" class="text-center border-left">Bayar</th>
										<th colspan="4" class="text-center border-left">Bebas</th>
										<th colspan="4" class="text-center border-left">Ditangguhkan</th>
										<th colspan="4" class="text-center border-right">Ditanggung Pemerintah</th>
									</tr>
									<tr>
										<th class="text-center border-left">BM</th>
										<th class="text-center">PPN</th>
										<th class="text-center">PPh</th>
										<th class="text-center">PPnBM</th>
										<th class="text-center border-left">BM</th>
										<th class="text-center">PPN</th>
										<th class="text-center">PPh</th>
										<th class="text-center">PPnBM</th>
										<th class="text-center border-left">BM</th>
										<th class="text-center">PPN</th>
										<th class="text-center">PPh</th>
										<th class="text-center">PPnBM</th>
										<th class="text-center border-left">BM</th>
										<th class="text-center">PPN</th>
										<th class="text-center">PPh</th>
										<th class="text-center border-right">PPnBM</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>