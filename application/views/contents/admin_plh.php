<div ui-view class="app-body" id="view">
	<div class="my-message btn btn-fw primary" style="position: fixed; left: 50%; z-index: 100; display: none;"></div>
	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row">
					<div class="col-md-4">
						<div class="box">
							<div class="box-header">
								<h3>Input Pejabat Plh</h3>
							</div>
							<div class="box-divider m-a-0"></div>

							<div class="box-body">
								<form id="formPlh" role="form">
									<div class="form-group row">
										<label for="jabatan" class="col-sm-3 form-control-label">Jabatan</label>
										<div class="col-sm-9">
											<select class="form-control c-select" name="jabatan">
												<?php foreach ($lsJabatan as $jabatan) { ?>
													<option value="<?php echo $jabatan->k_jbtn ?>"><?php echo $jabatan->nama; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="inpTanggal" class="col-sm-3 form-control-label">Tanggal</label>
										<div class="col-sm-4">
											<div class='input-group date' id="start_date" name="start_date" ui-jp="datetimepicker" ui-options="{
													format: 'DD-MM-YYYY',
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
												<input type='text' class="form-control" id="start_date" name="start_date" placeholder="Awal" />
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
										<div class="col-sm-1 text-center">
											<label class="form-control-label">s.d.</label>
										</div>
										<div class="col-sm-4">
											<div class='input-group date' id="end_date" name="end_date" ui-jp="datetimepicker" ui-options="{
													format: 'DD-MM-YYYY',
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
												<input type='text' class="form-control" id="end_date" name="end_date" placeholder="Akhir" />
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="pejabat" class="col-sm-3 form-control-label">Pejabat</label>
										<div class="col-sm-9">
											<input type="text" class="form-control src-input" id="pejabat" placeholder="Nama/NIP Pegawai" autocomplete="off">	
											<div id="src_result_pejabat" class="src-result box"></div>
											<input type="text" class="id-pejabat src-submit" name="id_pejabat" style="display: none">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<button id="btnSubmit" class="btn btn-info" style="float: right;">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="box">
							<div class="box-header">
								<h3>Daftar Pejabat Plh</h3>
							</div>
							<div class="box-divider m-a-0"></div>
							<div class="box-body">
								<div class="row">
									<form id="formFilter">
										<div class="col-sm-3">
											<div class='input-group date' ui-jp="datetimepicker" ui-options="{
													format: 'DD-MM-YYYY',
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
												<input type='text' class="form-control" id="select_date" name="select_date" placeholder="Pilih tanggal" />
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
										<div class="col-sm-2">
											<button class="btn btn-sm btn-success rounded"><i class="fa fa-search"></i></button>
										</div>
									</form>
								</div>
								<div class="row px-3">
									<table id="table-plh" class="table m-b-none">
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>Jabatan</th>
												<th>Plh</th>
												<th>NIP</th>
												<th>Aksi</th>
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
	<!-- ############ PAGE END-->
	</div>
</div>

<!-- modal edit data -->
<div id="modal-edit" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Pejabat Plh</h5>
			</div>
			<div class="modal-body p-lg">
				<form action="#" id="formEditPlh" class="row mb-1 mx-2">
					<input id="inpIdPlh" type="hidden" name="id_plh">
					<div class="form-group row">
						<label for="inpJabatan" class="col-sm-2 form-control-label">Jabatan</label>
						<div class="col-sm-10">
							<input id="inpJabatan" type="text" class="form-control" disabled="">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpPlh" class="col-sm-2 form-control-label">Pejabat</label>

						<div class="col-sm-10">
							<input id="inpPlh" type="text" class="form-control src-input" placeholder="Nama/NIP Pegawai" autocomplete="off">	
							<div id="src_result_pejabat" class="src-result box"></div>
							<input id="inpIdPejabat" type="hidden" class="id-pejabat src-submit" name="id_pejabat">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button id="btnUpdate" type="button" class="btn primary p-x-md">Update</button>
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal edit data -->

<!-- modal konfirmasi delete data -->
<div id="modal-konfirmasi" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hapus Pejabat Plh</h5>
			</div>
			<div class="modal-body p-lg">
				<p>Yakin untuk menghapus pejabat Plh?</p>
			</div>
			<div class="modal-footer">
				<button id="btnDelConfirm" type="button" class="btn primary p-x-md">Ya</button>
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal konfirmasi deleta data -->

<!-- / content -->