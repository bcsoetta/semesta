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
							<h3>Setting Role</h3>
						</div>
						<div class="box-divider m-a-0"></div>
						<div class="box-body">
							<div class="row mb-3">
								<div class="col-md-4"><button id="btn-tambah-role" class="btn btn-sm info">+ Buat role baru</button></div>	
							</div>
							<div id="list-aplikasi" class="list-group m-b">
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

<!-- modal edit role -->
<div id="modal-role" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Role</h5>
			</div>
			<div class="modal-body p-lg">
				<form action="#" id="form-role" class="row mb-1 mx-2">
					<div class="form-group row">
						<label for="inpNama" class="col-sm-2 form-control-label">Nama Role</label>
						<div class="col-sm-10">
							<input id="inpRole" name="role" type="text" class="form-control" autocomplete="off">
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
			</div>
			<div class="modal-footer">
				<button id="btn-simpan" type="button" class="btn primary p-x-md">Simpan</button>
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<!-- /modal edit role -->