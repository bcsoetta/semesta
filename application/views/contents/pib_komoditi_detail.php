<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START ############ -->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<!-- HS description -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header">
							<h3>Deskripsi HS <?php echo (end($description))['kode']; ?></h3>
						</div>
						<div class="table-responsive">
							<table class="table table-striped b-t">
								<thead>
									<tr>
										<th>Pos BTKI</th>
										<th>Deskripsi Indonesia</th>
										<th>English Description</th>
									<tr>
								</thead>
								</tbody>
										<?php 
											foreach ($description as $key => $value) {
												echo "<tr><td>" . $value["kode"] . "</td><td>" . $value["uraian"] . "</td><td>" . $value["uraian_english"] . "</td></tr>";
											}
										?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!-- Chart nilai pabean dan bea masuk -->
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="box">
							<div class="box-header">
								<h3>Nilai Pabean</h3>
								<small>Total nilai pabean HS per bulan</small>
							</div>
							<div class="box-body">
								<div id="chart-bar-nilai" style="height:40vh"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="box">
							<div class="box-header">
								<h3>Bea Masuk</h3>
								<small>Total bea masuk HS per bulan</small>
							</div>
							<div class="box-body">
								<div id="chart-bar-bm" style="height:40vh"></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Chart importir -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header pb-0">
							<h3>Importir</h3>
						</div>
						<div class="box-body p-0">
							<div class="col-sm-12 col-md-6">
								<div class="box-header p-0">
									<small>Proporsi nilai pabean per importir dalam miliar rupiah</small>
								</div>
								<div id="chart-pie-importir-nilai" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="box-header p-0">
									<small>Proporsi bea masuk per importir dalam miliar rupiah</small>
								</div>
								<div id="chart-pie-importir-bm" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 pt-5">
								<table id="table-data-importir" class="table table-striped row-border m-b-none">
									<thead>
										<tr>
											<th rowspan="3" class="text-center align-middle border-left">Importir</th>
											<th rowspan="3" class="text-center align-middle border-left">Jml PIB</th>
											<th rowspan="3" class="text-center align-middle border-left">Nilai Pabean (juta Rp)</th>
											<th colspan="16" class="text-center border-left border-right">Pungutan (juta Rp)</th>
										</tr>
										<tr>
											<th colspan="4" class="text-center border-left">Bayar</th>
											<th colspan="4" class="text-center border-left">Bebas</th>
											<th colspan="4" class="text-center border-left">Ditangguhkan</th>
											<th colspan="4" class="text-center border-right">Ditanggung Pemerintah</th>
										</tr>
										<tr>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center">PPnBM</th>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center">PPnBM</th>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center">PPnBM</th>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center border-right">PPnBM</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- Chart fasilitas -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header pb-0">
							<h3>Fasilitas</h3>
						</div>
						<div class="box-body p-0">
							<div class="col-sm-12 col-md-6">
								<div class="box-header p-0">
									<small>Proporsi nilai pabean per fasilitas dalam miliar rupiah</small>
								</div>
								<div id="chart-pie-fasilitas-nilai" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="box-header p-0">
									<small>Proporsi pungutan yang mendapat fasilitas dalam miliar rupiah</small>
								</div>
								<div id="chart-pie-fasilitas-pungutan" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 pt-5">
								<table id="table-data-fasilitas" class="table table-striped row-border m-b-none">
									<thead>
										<tr>
											<th rowspan="3" class="text-center align-middle border-left">Fasilitas</th>
											<th rowspan="3" class="text-center align-middle border-left">Jml PIB</th>
											<th rowspan="3" class="text-center align-middle border-left">Nilai Pabean (juta Rp)</th>
											<th colspan="16" class="text-center border-left border-right">Pungutan (juta Rp)</th>
										</tr>
										<tr>
											<th colspan="4" class="text-center border-left">Bayar</th>
											<th colspan="4" class="text-center border-left">Bebas</th>
											<th colspan="4" class="text-center border-left">Ditangguhkan</th>
											<th colspan="4" class="text-center border-right">Ditanggung Pemerintah</th>
										</tr>
										<tr>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center">PPnBM</th>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center">PPnBM</th>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center">PPnBM</th>
											<th class="text-center border-left">BM</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PPh</th>
											<th class="text-center border-right">PPnBM</th>
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
</div>