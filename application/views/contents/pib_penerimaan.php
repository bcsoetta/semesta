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
							<small>Total penerimaan PIB (dalam jutaan Rp)</small>
						</div>
						<div class="box-divider m-a-0"></div>
						<table id="table-penerimaan-total" class="table m-b-none">
	<!-- 						<thead>
								<tr>
										<th>
											Pungutan
										</th>
										<th>Bayar</th>
										<th data-hide="phone">
											DP
										</th>
										<th data-hide="phone">
											Tangguh
										</th>
										<th data-hide="phone">
											Bebas
										</th>
									</tr>
							</thead>
							<tbody>
								<tr>
									<td style="text-align: left;">BM</td>
									<td id="bm"></td>
									<td id="bm_dp"></td>
									<td id="bm_tangguh"></td>
									<td id="bm_bebas"></td>
								</tr>
								<tr>
									<td style="text-align: left;">PPN</td>
									<td id="ppn"></td>
									<td id="ppn_dp"></td>
									<td id="ppn_tangguh"></td>
									<td id="ppn_bebas"></td>
								</tr>
								<tr>
									<td style="text-align: left;">PPh</td>
									<td id="pph"></td>
									<td id="pph_dp"></td>
									<td id="pph_tangguh"></td>
									<td id="pph_bebas"></td>
								</tr>
								<tr>
									<td style="text-align: left;">PPnBM</td>
									<td id="ppnbm"></td>
									<td id="ppnbm_dp"></td>
									<td id="ppnbm_tangguh"></td>
									<td id="ppnbm_bebas"></td>
								</tr>
							</tbody> -->
						</table>
					</div>
					<div class="col-sm-8 light lt">
						<div class="box-header">
							<h3>Penerimaan PIB per Bulan</h3>
							<small>Total penerimaan PIB per bulan</small>
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
								<h3>Importir Dengan Penerimaan Terbesar</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-imp" style="height:40vh"></div>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Importir dengan Bea Masuk Terbesar</h3>
								<!-- <small>10 importir dengan total bea masuk terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-bm" style="height:40vh"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>