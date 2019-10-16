<div ui-view class="app-body" id="view">
	<!-- message -->
	<div class="my-message btn btn-fw primary" style="position: fixed; left: 50%; z-index: 100; display: none;"></div>

	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header">
							<h3>Daftar Permohonan</h3>
						</div>
						<div class="box-divider m-a-0"></div>

						<div class="box-body">
							<!-- <div class="row px-3 mb-2 pull-right">
								<button id="btn-modal-tambah" class="btn btn-sm primary" data-toggle="modal" data-target="#modal-tambah">+ Tambah</button>
							</div> -->

							<table id="table-dok-data" class="table m-b-none">
								<thead>
									<tr>
										<th>Agenda</th>
										<th>No Surat</th>
										<!-- <th>Tgl Surat</th> -->
										<th>Hal</th>
										<th>Dari</th>
										<th>Status</th>
										<th>Aksi</th>
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
				<h5 class="modal-title">Tambah Aplikasi</h5>
			</div>
			<div class="modal-body p-lg">
				<form action="#" id="formHeader" class="row mb-1 mx-2">
					<div class="form-group row">
						<label for="inpNama" class="col-sm-2 form-control-label">Nama Aplikasi</label>
						<div class="col-sm-10">
							<input id="inpNama" name="nama" type="text" class="form-control" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpKet" class="col-sm-2 form-control-label">Keterangan</label>
						<div class="col-sm-10">
							<input id="inpKet" name="keterangan" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpTahun" class="col-sm-2 form-control-label">Tahun Pembuatan</label>
						<div class="col-sm-4">
							<input id="inpTahun" name="tahun" type="number" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpAlamat" class="col-sm-2 form-control-label">Alamat</label>
						<div class="col-sm-10">
							<input id="inpAlamat" name="alamat" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="inpStatus" class="col-sm-1 form-control-label">Status</label>
						<label class="ui-switch m-t-xs m-r">
							<input id="inpStatus" name="status" type="checkbox" value="1" checked>
							<i></i>
						</label>
					</div>
				</form>
				<form id="formDetail" class="row mb-1 mx-2">
					<h6 class="_600">Pembuat Aplikasi</h6>
					<button class="btn btn-icon add-detail"><i class="fa fa-plus"></i></button>
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
				<h5 class="modal-title">Hapus Aplikasi</h5>
			</div>
			<div id="pesan-konfirmasi" class="modal-body p-lg">
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