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
					<div class="col-sm-5">
						<div class="box-header">
							<h3>Dwelling Time Bulan Lalu</h3>
							<small>(Dalam hari)</small>
						</div>
						<div class="box-divider m-a-0"></div>
						<table class="table" style="text-align: right;">
							<thead>
								<tr>
									<th>Dokumen</th>
									<th>Jalur</th>
									<th>Pre</th>
									<th>Customs</th>
									<th>Post</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="text-align: left;">CN/PIBK</td>
									<td style="text-align: left;">Semua</td>
									<td id="TOTAL_pre"></td>
									<td id="TOTAL_customs"></td>
									<td id="TOTAL_post"></td>
									<td id="TOTAL_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">CN</td>
									<td style="text-align: left;">Sistem</td>
									<td id="1_RE_3_pre"></td>
									<td id="1_RE_3_customs"></td>
									<td id="1_RE_3_post"></td>
									<td id="1_RE_3_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">CN</td>
									<td style="text-align: left;">Hijau</td>
									<td id="1_NON-RE_3_pre"></td>
									<td id="1_NON-RE_3_customs"></td>
									<td id="1_NON-RE_3_post"></td>
									<td id="1_NON-RE_3_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">CN</td>
									<td style="text-align: left;">Merah Periksa</td>
									<td id="1_NON-RE_2_pre"></td>
									<td id="1_NON-RE_2_customs"></td>
									<td id="1_NON-RE_2_post"></td>
									<td id="1_NON-RE_2_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">CN</td>
									<td style="text-align: left;">Merah Tidak Periksa</td>
									<td id="1_NON-RE_1_pre"></td>
									<td id="1_NON-RE_1_customs"></td>
									<td id="1_NON-RE_1_post"></td>
									<td id="1_NON-RE_1_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">PIBK</td>
									<td style="text-align: left;">Hijau</td>
									<td id="2_NON-RE_3_pre"></td>
									<td id="2_NON-RE_3_customs"></td>
									<td id="2_NON-RE_3_post"></td>
									<td id="2_NON-RE_3_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">PIBK</td>
									<td style="text-align: left;">Merah Periksa</td>
									<td id="2_NON-RE_2_pre"></td>
									<td id="2_NON-RE_2_customs"></td>
									<td id="2_NON-RE_2_post"></td>
									<td id="2_NON-RE_2_total"></td>
								</tr>
								<tr>
									<td style="text-align: left;">PIBK</td>
									<td style="text-align: left;">Merah Tidak Periksa</td>
									<td id="2_NON-RE_1_pre"></td>
									<td id="2_NON-RE_1_customs"></td>
									<td id="2_NON-RE_1_post"></td>
									<td id="2_NON-RE_1_total"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-7 grey lt">
						<div class="box-header">
							<h3>Rata-rata Dwelling Time</h3>
							<!-- <small>Total penerimaan PIB per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-dt-total" style="width: 100%; height: 45vh;"></div>
						</div>
					</div>
				</div>
				<h5>Dokumen CN</h5>
				<div class="row">
					<div class="col-sm-3">
						<div class="box">
							<div class="box-header">
								<h3>Sistem</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-cn-re" style="height:30vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="box">
							<div class="box-header">
								<h3>Jalur Hijau</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-cn-hijau" style="height:30vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="box">
							<div class="box-header">
								<h3>Jalur Merah Periksa</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-cn-merah-periksa" style="height:30vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="box">
							<div class="box-header">
								<h3>Jalur Merah Tidak Periksa</h3>
								<!-- <small>10 importir dengan total bea masuk terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-cn-merah-nonperiksa" style="height:30vh"></div>
							</div>
						</div>
					</div>
				</div>
				<h5>Dokumen PIBK</h5>
				<div class="row">
					<div class="col-sm-4">
						<div class="box">
							<div class="box-header">
								<h3>Jalur Hijau</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-pibk-hijau" style="height:30vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="box">
							<div class="box-header">
								<h3>Jalur Merah Periksa</h3>
								<!-- <small>10 importir dengan total penerimaan terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-pibk-merah-periksa" style="height:30vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="box">
							<div class="box-header">
								<h3>Jalur Merah Tidak Periksa</h3>
								<!-- <small>10 importir dengan total bea masuk terbesar</small> -->
							</div>
							<div class="box-body">
								<div id="chart-dt-pibk-merah-nonperiksa" style="height:30vh"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>