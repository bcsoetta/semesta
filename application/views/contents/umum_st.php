<div ui-view class="app-body" id="view">
	<!-- message -->
	<div class="my-message btn btn-fw primary" style="position: fixed; left: 50%; z-index: 100; display: none;">
		tes
	</div>

	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header">
							<h3>Daftar Surat Tugas</h3>
						</div>
						<div class="box-divider m-a-0"></div>

						<div class="box-body">
							<div class="row">
								<div class=" px-3 mb-2 pull-right">
									<button id="btn-modal-tambah" class="btn btn-sm primary" data-toggle="modal" data-target="#modal-tambah">+ Tambah</button>
									<button id="btn-open-adv-src" class="btn btn-sm info">Advance Search</button>
								</div>
							</div>

							<div id="adv-src" class="row light p-3" style="display: none;">
								<form id="form-adv-src" action="st_export_xlsx" target="_blank" method="POST">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="srcJenisSt" class="col-sm-2 form-control-label">Jenis ST</label>
											<div class="col-sm-9">
												<select id="srcJenisSt" name="jenis_st" class="form-control c-select">
													<option value="" selected="" disabled="" hidden="">Pilih jenis ST</option>
													<option value="1">Kepala Kantor</option>
													<option value="10">Kepala Bagian Umum</option>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Tanggal ST</label>
											<div class="col-sm-4">
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
													<input id="srcTglStSta" type='text' name="tgl_st_start" class="col-sm-10 form-control" />
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
											<div class="col-sm-1 form-control-label text-center"> s.d. </div>
											<div class="col-sm-4">
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
													<input id="srcTglStEnd" type='text' name="tgl_st_end" class="col-sm-10 form-control" />
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										
										<div class="form-group row">
											<label for="srcDipa" class="col-sm-2 form-control-label">DIPA</label>
											<div class="col-sm-9">
												<select id="srcDipa" name="dipa" class="form-control c-select">
													<option value="" selected="" disabled="" hidden="">Pilih DIPA</option>
													<option value="1">KPU BC Soekarno Hatta</option>
													<option value="2">Sekretariat DJBC</option>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Hal</label>
											<div class="col-sm-9">
												<input id="srcHal" class="form-control" type="text" name="hal">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Tanggal tugas</label>
											<div class="col-sm-4">
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
													<input id="srcTglTugasStart" type='text' name="tgl_tugas_start" class="col-sm-10 form-control" />
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
											<div class="col-sm-1 form-control-label text-center"> s.d. </div>
											<div class="col-sm-4">
												<div id="srcTglStEnd" class='input-group date' ui-jp="datetimepicker" ui-options="{
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
													<input id="srcTglTugasEnd" type='text' name="tgl_tugas_end" class="col-sm-10 form-control" />
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Lokasi tugas</label>
											<div class="col-sm-6">
												<input id="srcTempat" class="form-control" type="text" name="tempat" placeholder="tempat tugas">
											</div>
											<div class="col-sm-3">
												<input id="srcKota" class="form-control" type="text" name="kota" placeholder="kota tugas">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 form-control-label">Nama pegawai</label>
											<div class="col-sm-9">
												<input id="srcNama" class="form-control" type="text" name="nama">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-11">
												<button id="btn-dl-xls" class="btn btn-md primary pull-right ml-2">Download</button>
												<button id="btn-adv-src" class="btn btn-md info pull-right ml-2">Search</button>
												<button id="btn-clr-src" class="btn btn-md warning pull-right">Clear</button>
											</div>
										</div>
									</div>
								</form>
							</div>

							<table id="table-pfpd-data" class="table m-b-none">
								<thead>
									<tr>
										<th>Jenis ST</th>
										<th>No</th>
										<th>Tgl</th>
										<th>Hal</th>
										<th>Aksi</th>
										<th>created_at</th>
									</tr>
								</thead>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
	<!-- ############ PAGE END-->
	</div>
</div>
<!-- / content -->

<!-- modal tambah/edit data -->
<div id="modal-tambah" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Surat Tugas</h5>
			</div>
			<div class="modal-body p-lg">
				<form action="#" id="formStHeader" class="row mb-1 mx-2">
					<div id="formTglSt" class="form-group row">
						<label for="inpTanggal" class="col-sm-2 form-control-label">Tanggal ST</label>
						<div class="col-sm-4">
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
								<input id="inpTanggalSt" type='text' name="tanggal" class="col-sm-10 form-control" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="inpJenisSt" class="col-sm-2 form-control-label">Jenis ST</label>
						<div class="col-sm-10">
							<select id="inpJenisSt" name="jenis_st" class="form-control c-select">
								<option value="1">Kepala Kantor</option>
								<option value="10">Kepala Bagian Umum</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="inpPejabat" class="col-sm-2 form-control-label">Pejabat</label>

						<div class="col-sm-9">
							<input type="text" class="form-control input-pejabat" id="pejabat" placeholder="Nama/NIP Pegawai" autocomplete="off" disabled="">	
							<div id="src_result_pejabat" class="src-result box"></div>
							<input type="text" class="id-pejabat" name="id_pejabat" style="display: none">
						</div>
						<div class="col-sm-1 form-control-label">
							<input class="form-control-label" id="inpPlh" type="checkbox" disabled="">
							<input type="hidden" id="inpHidPlh" name="plh" value="0">
							<label>Plh</label>
						</div>
						<div class="confirm-pjb-st" style="display: none;">
							<div class="col-sm-2"></div>
							<div class="col-sm-10">
								<span class="label warning">
									Pejabat aktif berbeda. Apakah akan diubah?
								</span>	
								<button class="btn label primary confirm-pjb-yes">
									Ya
								</button>
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="inpHal" class="col-sm-2 form-control-label">Hal</label>
						<div class="col-sm-10">
							<input id="inpHal" name="hal" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpTanggal" class="col-sm-2 form-control-label">Tanggal</label>
						<div class="col-sm-4">
							<div id="inpTanggalSta" class='input-group date' ui-jp="datetimepicker" ui-options="{
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
								<input type='text' name="tgl_tugas_start" class="col-sm-10 form-control" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
						<div class="col-sm-1 form-control-label text-center"> s.d. </div>
						<div class="col-sm-4">
							<div id="inpTanggalEnd" class='input-group date' ui-jp="datetimepicker" ui-options="{
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
								<input type='text' name="tgl_tugas_end" class="col-sm-10 form-control" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="inpWaktu" class="col-sm-2 form-control-label">Waktu</label>
						<div class="col-sm-4">
							<div id="inpWaktuSta" class='input-group date' ui-jp="datetimepicker" ui-options="{
								format: 'HH:mm',
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
								<input type='text' name="wkt_tugas_start" class="col-sm-10 form-control" />
								<span class="input-group-addon">
									<span class="fa fa-clock-o"></span>
								</span>
							</div>
						</div>
						<div class="col-sm-1 form-control-label text-center"> s.d. </div>
						<div class="col-sm-4">
							<div id="inpWaktuEnd" class='input-group date' ui-jp="datetimepicker" ui-options="{
								format: 'HH:mm',
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
								<input type='text' name="wkt_tugas_end" class="col-sm-10 form-control" />
								<span class="input-group-addon">
									<span class="fa fa-clock-o"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="inpTempat" class="col-sm-2 form-control-label">Tempat</label>
						<div class="col-sm-7">
							<input id="inpTempat" name="tempat_tugas" type="text" class="form-control" placeholder="tempat tugas">
						</div>
						<div class="col-sm-3">
							<input id="inpKota" name="kota_tugas" type="text" class="form-control" placeholder="kota tugas">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpDipa" class="col-sm-2 form-control-label">DIPA</label>
						<div class="col-sm-10">
							<select id="inpDipa" name="dipa" class="form-control c-select">
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="inpSpd" class="col-sm-1 form-control-label">SPD</label>
						<div class="col-sm-1">
							<label class="ui-switch m-t-xs m-r">
								<input id="inpSpd" name="spd" type="checkbox" value="1" checked>
								<i></i>
							</label>	
						</div>
					</div>
					<div class="form-group row">
						<label for="inpKbu" class="col-sm-2 form-control-label">KBU</label>

						<div class="col-sm-9">
							<input type="text" class="form-control input-pejabat" id="kbu" placeholder="Nama/NIP Pegawai" autocomplete="off" disabled="">	
							<div id="src_result_pejabat" class="src-result box"></div>
							<input type="hidden" class="id-pejabat" name="id_pejabat_kbu">
						</div>
						<div class="col-sm-1 form-control-label">
							<input class="form-control-label" id="inpPlhKbu" type="checkbox" disabled="">
							<input type="hidden" id="inpHidPlhKbu" name="plh_kbu" value="0">
							<label>Plh</label>
						</div>
						<div class="confirm-pjb-kbu" style="display: none;">
							<div class="col-sm-2"></div>
							<div class="col-sm-10">
								<span class="label warning">
									Pejabat aktif berbeda. Apakah akan diubah?
								</span>	
								<button class="btn label primary confirm-kbu-yes">
									Ya
								</button>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="inpPpk" class="col-sm-2 form-control-label">PPK</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-ppk" id="ppk" disabled="">	
							<input type="hidden" class="id-pejabat" name="ppk">
						</div>
					</div>
				</form>
				<form id="formStPegawai" class="row mb-1 mx-2">
					<h6 class="_600">Daftar Pegawai</h6>
					<button class="btn btn-icon add-pegawai"><i class="fa fa-plus"></i></button>
				</form>
			</div>
			<div class="modal-footer">
				<button id="btnSimpan" type="button" class="btn primary p-x-md" style="display: none;">Simpan</button>
				<button id="btnUpdate" type="button" class="btn primary p-x-md" style="display: none;">Update</button>
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal tambah/edit data -->

<!-- modal konfirmasi delete data -->
<div id="modal-konfirmasi" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hapus Surat Tugas</h5>
			</div>
			<div class="modal-body p-lg">
				<p>Yakin untuk menghapus surat tugas?</p>
			</div>
			<div class="modal-footer">
				<button id="btnDelConfirm" type="button" class="btn primary p-x-md">Ya</button>
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal konfirmasi deleta data -->