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
							<h3>Total Dokumen Piutang</h3>
							<!-- <small>(Dalam hari)</small> -->
						</div>
						<div class="box-divider m-a-0"></div>
						<div class="box-body">
							<table id="table-piutang-total" class="table m-b-none"></table>	
						</div>
					</div>
					<div class="col-sm-8 grey lt">
						<div class="box-header">
							<h3>Piutang Per Bulan</h3>
							<!-- <small>Total penerimaan PIB per bulan</small> -->
						</div>
						<div class="box-body" id="ccc">
							<div id="chart-piutang-all" style="width: 100%; height: 40vh;"></div>
						</div>
					</div>
				</div>
				<div class="row-col box">
					<div class="col-sm-3">
						<div class="box-header">
							<h3>Status Piutang</h3>
						</div>
						<div class="box-divider m-a-0"></div>
						<div class="box-body">
							<div class="accordion" id="stat-piutang">
								<div class="list-group">
									<a href="" class="list-group-item b-l-primary wrap" id="stat-penetapan" data-toggle="collapse" data-target="#stat-penetapan-list" aria-expanded="true" aria-controls="stat-penetapan-list">
										<div class="col-sm-5 pl-0">
											Surat Penetapan:	
										</div>
										<div id="stat1" class="col-sm-6">0 dokumen</div>
									</a>

									<div id="stat-penetapan-list" class="collapse list-group" aria-labelledby="stat-penetapan" data-parent="#stat-piutang">
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-info"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Outstanding:	
											</div>
											<div id="stat100" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-danger"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lewat waktu:	
											</div>
											<div id="stat101" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-success"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lunas:	
											</div>
											<div id="stat190" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
									</div>

									<a href="" class="list-group-item b-l-primary wrap" id="stat-teguran" data-toggle="collapse" data-target="#stat-teguran-list" aria-expanded="true" aria-controls="stat-teguran-list">
										<div class="col-sm-5 pl-0">
											Surat Teguran:	
										</div>
										<div id="stat2" class="col-sm-6">0 dokumen</div>
									</a>

									<div id="stat-teguran-list" class="collapse" aria-labelledby="stat-teguran" data-parent="#piutang">
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-info"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Outstanding:	
											</div>
											<div id="stat200" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-danger"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lewat waktu:	
											</div>
											<div id="stat201" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-success"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lunas:	
											</div>
											<div id="stat290" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
									</div>

									<a href="" class="list-group-item b-l-primary wrap" id="stat-paksa" data-toggle="collapse" data-target="#stat-paksa-list" aria-expanded="true" aria-controls="stat-paksa-list">
										<div class="col-sm-5 pl-0">
											Surat Paksa:	
										</div>
										<div id="stat3" class="col-sm-6">0 dokumen</div>
									</a>

									<div id="stat-paksa-list" class="collapse" aria-labelledby="stat-paksa" data-parent="#piutang">
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-info"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Outstanding:	
											</div>
											<div id="stat300" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-danger"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lewat waktu:	
											</div>
											<div id="stat301" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-success"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lunas:	
											</div>
											<div id="stat390" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
									</div>

									<a href="" class="list-group-item b-l-primary wrap" id="stat-keberatan" data-toggle="collapse" data-target="#stat-keberatan-list" aria-expanded="true" aria-controls="stat-keberatan-list">
										<div class="col-sm-5 pl-0">
											Kep Keberatan:	
										</div>
										<div id="stat6" class="col-sm-6">0 dokumen</div>
									</a>

									<div id="stat-keberatan-list" class="collapse" aria-labelledby="stat-keberatan" data-parent="#piutang">
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-info"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Outstanding:	
											</div>
											<div id="stat600" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-danger"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lewat waktu:	
											</div>
											<div id="stat601" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
										<div class="list-group-item wrap">
											<span class="pull-right"><a href="#" class="fa fa-list text-info"></a></span>
											<div class="col-sm-1 p-0">
												<span class="text-success"><i class="fa fa-circle text-xs"></i></span>	
											</div>
											<div class="col-sm-5 p-0">
												Lunas:	
											</div>
											<div id="stat690" class="col-sm-5 p-0">
												0 dokumen
											</div>
										</div>
									</div>

									<div class="list-group-item b-l-primary wrap" id="stat-batal">
										<span class="pull-right">
											<a href="#" class="fa fa-list text-info"></a>
										</span>
										<div class="col-sm-5 pl-0">
											Batal:	
										</div>
										<div id="stat8" class="col-sm-5">0 dokumen</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-9">
						<div class="box-header">
							<h3>Daftar Piutang</h3>
							<!-- <small>(Dalam hari)</small> -->
						</div>
						<div class="box-divider m-a-0"></div>
						<div class="box-body">
							<table id="table-list-piutang" class="table m-b-none"></table>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ PAGE END-->
</div>
<!-- / content -->