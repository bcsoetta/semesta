<div ui-view class="app-body" id="view">
	<!-- message -->
	<div class="my-message btn btn-fw primary" style="position: fixed; left: 50%; z-index: 10000; display: none;"></div>

	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header">
							<h3>Daftar Fitur Semesta</h3>
						</div>
						<div class="box-divider m-a-0"></div>

						<div class="box-body">
							<div id="list-aplikasi" class="list-group m-b">
							</div>
							<div class="row px-3 mb-2">
								<form id="form-simpan-fitur">
									<div class="form-group row">
										<div class="col-md-1 col-sm-12">
											<label class="form-group-label">Tambah aplikasi:</label>
										</div>
										<div class="col-md-3 col-sm-12">
											<input id="inp-nm-fitur" class="form-control" type="text" name="nama-fitur" placeholder="Isikan nama fitur">
										</div>
										<button id="btn-simpan" class="btn btn-md info">Simpan</button>	
									</div>
								</form>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	<!-- ############ PAGE END-->
	</div>
</div>
<!-- / content -->

<!-- modal edit data -->
<div id="modal-edit" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Fitur</h5>
			</div>
			<div class="modal-body p-lg">
				<form action="#" id="formEdit" class="row mb-1 mx-2">
					<input id="inpId" type="hidden" name="id">
					<div class="form-group row">
						<label for="inpNama" class="col-sm-2 form-control-label">Nama Fitur</label>
						<div class="col-sm-10">
							<input id="inpNama" name="nama" type="text" class="form-control" autocomplete="off">
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
				<form action="#" id="formDetail">
					
				</form>
			</div>
			<div class="modal-footer">
				<button id="btn-simpan" type="button" class="btn primary p-x-md">Simpan</button>
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal edit data -->