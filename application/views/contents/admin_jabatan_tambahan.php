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
								<h3>Input Pejabat Tambahan</h3>
							</div>
							<div class="box-divider m-a-0"></div>

							<div class="box-body">
								<form id="formPejabatTambahan" role="form">
									<div class="form-group row">
										<label for="jabatan" class="col-sm-3 form-control-label">Lingkup</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="level">
										</div>
									</div>
									<div class="form-group row">
										<label for="pejabat" class="col-sm-3 form-control-label">Jabatan</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="jabatan">
										</div>
									</div>
									<div class="form-group row">
										<label for="pejabat" class="col-sm-3 form-control-label">Nama Pejabat</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="nama">
										</div>
									</div>
									<div class="form-group row">
										<label for="pejabat" class="col-sm-3 form-control-label">NIP Pejabat</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="nip">
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
								<h3>Daftar Pejabat Tambahan</h3>
							</div>
							<div class="box-divider m-a-0"></div>
							<div class="box-body">
								<div class="row px-3">
									<table id="table-pejabat-tambahan" class="table m-b-none">
										<thead>
											<tr>
												<th>Lingkup</th>
												<th>Jabatan</th>
												<th>Nama</th>
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

<!-- modal konfirmasi delete data -->
<div id="modal-konfirmasi" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hapus Pejabat Tambahan</h5>
			</div>
			<div class="modal-body p-lg">
				<p>Yakin untuk menghapus pejabat tambahan?</p>
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