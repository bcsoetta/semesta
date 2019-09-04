	<div ui-view class="app-body" id="view">
		<!-- ############ PAGE START-->
		<div class="row-col b-b">
			<div class="col-md">
				<div class="padding">
					<div class="row-col box">
						<div class="col-sm-12">
							<div class="box-body">
								<form action="#" id="form_filter">
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
					<div class="row">
						<div class="col-sm-6">
							<div class="box">
								<div class="box-header">
									<h3>Jenis PEB</h3>
									<!-- <small>Total jumlah PIB per bulan berdasarkan jalur</small> -->
								</div>
								<div class="box-body">
									
									<div id="chart-jenis" style="width: 100%; height: 40vh;"></div>

								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box">
								<div class="box-header">
									<h3>Kategori PEB</h3>
									<!-- <small>Total jumlah PIB per bulan berdasarkan jalur</small> -->
								</div>
								<div class="box-body">
									
									<div id="chart-kategori" style="width: 100%; height: 40vh;"></div>

								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="box">
								<div class="box-header">
									<h3>Tonase - Devisa</h3>
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
									<h3>Eksportir Terbesar</h3>
									<small>10 eksportir dengan jumlah devisa terbesar (juta USD)</small>
								</div>
								<div class="box-body">
									<div id="chart-eksportir" style="width: 100%; height:40vh"></div>
							</div>
						</div>

						</div>
						<div class="col-sm-8">
							<div class="row box">
								<div class="box-header">
									<h3>Negara Tujuan</h3>
									<small>Jumlah devisa berdasarkan negara tujuan (ribu USD)</small>
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
		<div class="modal fade inactive" id="chat" data-backdrop="false">
			<div class="right w-xxl grey lt b-l">
				<div ui-include="'../views/blocks/modal.chat.html'"></div>
			</div>
		</div>
		<!-- ############ PAGE END-->
	</div>
</div>
<!-- / content -->