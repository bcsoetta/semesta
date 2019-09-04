<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START-->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row-col box">
					<div class="col-sm-8">
						<div class="box-header">
							<h3>Atensi Terbaru</h3>
						</div>
						<div class="box-divider m-a-0"></div>

						<table id="table-atensi" class="table m-b-none"></table>

					</div>
					<div class="col-sm-4 grey lt">
						<div class="box-header">
							<h3>Statistik Atensi</h3>
						</div>
						<div class="box-body">
							
							<div id="chart-jalur" style="width: 100%; height: 40vh;"></div>

						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- ############ PAGE END-->
	</div>
</div>
<!-- / content -->

<!-- .modal -->
<div id="modal-detil" class="modal" data-backdrop="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Atensi</h5>
			</div>
			<div class="modal-body text-center p-lg">
				<div class="row mb-1">
					<div class="col-md-6">
						<h6 class="text-bold-200 text-left">No Aju</h6>
						<h5 id="no_aju" class="text-left"></h5>  
					</div>
					<div class="col-md-6">
						<h6 class="text-bold-200 text-right">No Pendaftaran</h6>
						<h3 id="no_pib" class="text-right"></h3>
					</div>
				</div>

				<div id="header-pib" class="row mb-1">
					<div class="col-md-6">
						<ul class="px-0 list-unstyled">
							<div class="row">
								<li class="col-md-3 text-left">Jalur</li>
								<li id="jalur" class="col-md-9 text-left"></li>
							</div>
							<div class="row">
								<li class="col-md-3 text-left">Importir</li>
								<li id="nm_imp" class="col-md-9 text-left"></li>  
							</div>
							<div class="row">
								<li class="col-md-3 text-left">NPWP</li>
								<li id="npwp_imp" class="col-md-9 text-left"></li>
							</div>
						</ul>
					</div>
					<div class="col-md-6">
						<ul class="px-0 list-unstyled">
							<div class="row">
								<li class="col-md-3 text-left">Netto Header</li>
								<li id="netto" class="col-md-9 text-left"></li>
							</div>
							<div class="row">
								<li class="col-md-3 text-left">Bruto Header</li>
								<li id="bruto" class="col-md-9 text-left"></li>  
							</div>
							<div id="netto-dtl-li" class="row" style="display: none">
								<li class="col-md-3 text-left">Netto Detail</li>
								<li id="netto-dtl" class="col-md-9 text-left"></li>  
							</div>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="padding">
						<div class="box">
							<div class="box-header">
								<h6 class="text-muted text-left">Detail Barang</h6>
							</div>
							<table id="table-detil" class="table m-b-none"></table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn danger p-x-md" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- / .modal -->