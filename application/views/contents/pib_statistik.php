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
							<h3>Jumlah Total PIB</h3>
						</div>
						<div class="box-body">
							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-12">
									<h6>Jalur Prioritas</h6>
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle purple-200 avatar" style="float: left; font-size: 12px">
											HP
										</span>
										<div id="jml_hp" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle purple-600 avatar" style="float: left; font-size: 12px">
											HT
										</span>
										<div id="jml_ht" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
							</div>
							<div class="box-divider m-a-0"></div>
							
							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-12">
									<h6>Jalur Hijau</h6>	
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle green-200 avatar" style="float: left; font-size: 12px">
											HL
										</span>
										<div id="jml_hl" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle green-500 avatar" style="float: left; font-size: 12px">
											HM
										</span>
										<div id="jml_hm" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle green-800 avatar" style="float: left; font-size: 12px">
											HH
										</span>
										<div id="jml_hh" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
							</div>
							<div class="box-divider m-a-0"></div>

							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-12">
									<h6>Jalur Kuning</h6>	
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle yellow-500 avatar" style="float: left; font-size: 12px">
											MK
										</span>
										<div id="jml_mk" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
							</div>
							<div class="box-divider m-a-0"></div>

							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-12">
									<h6>Jalur Merah</h6>	
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle red-200 avatar" style="float: left; font-size: 12px">
											MA
										</span>
										<div id="jml_ma" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle red-500 avatar" style="float: left; font-size: 12px">
											MM
										</span>
										<div id="jml_mm" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle red-800 avatar" style="float: left; font-size: 12px">
											MH
										</span>
										<div id="jml_mh" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
							</div>
							<div class="box-divider m-a-0"></div>

							<div class="row" style="padding-bottom: 10px; padding-top: 10px">
								<div class="col-sm-12">
									<h6>Rush Handling</h6>	
								</div>
								<div class="col-sm-3">
										<span class="w-24 circle grey-400 avatar" style="float: left; font-size: 12px">
											RH
										</span>
										<div id="jml_rh" style="float: left; padding-left: 5px"><a href></a></div>
								</div>
							</div>
							<div class="box-divider m-a-0"></div>
							
						</div>
					</div>
					<div class="col-sm-8 grey lt">
						<div class="box-header">
							<h3>Jumlah PIB per Bulan</h3>
							<!-- <small>Total jumlah PIB per bulan berdasarkan jalur</small> -->
						</div>
						<div class="box-body">
							
							<div id="chart-jalur" style="width: 100%; height: 40vh;"></div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Tonase - Devisa - BM</h3>
							</div>
							<div class="box-body">
								<div id="chart-tonase" style="width: 100%; height: 30vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3>Rata-rata Devisa per Netto</h3>
							</div>
							<div class="box-body">
								<div id="chart-rata-tonase" style="width: 100%; height: 30vh"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="box">
							<div class="box-header">
								<h3>Importir Terbesar</h3>
								<small>10 importir dengan jumlah PIB terbanyak</small>
							</div>
							<div class="box-body">
								<div id="chart-imp" style="width: 100%; height:40vh"></div>
						</div>
					</div>

					</div>
					<div class="col-sm-8">
						<div class="row box">
									<div class="box-header">
										<h3>Asal Negara</h3>
										<small>Jumlah PIB berdasarkan negara pemasok</small>
									</div>
									<div class="box-body clearfix">
										<div id="chart-negara" style="width: 80%; height:40vh; float: left"></div>
										<div id="chart-negara-top" style="width: 20%; height:40vh; float: left"></div>
									</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>