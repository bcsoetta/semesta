<div ui-view class="app-body" id="view">
	<!-- ############ PAGE START ############ -->
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<!-- Importir description -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header">
							<h3>Detail Importir</h3>
						</div>
						<div class="table-responsive">
							<table class="table table-striped b-t">
								</tbody>
									<tr>
										<td>Nama</td>
										<td><?php echo $description["nama"]; ?></td>
									</tr>
									<tr>
										<td>NPWP</td>
										<td><?php echo $description["npwp"]; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><?php echo $description["alamat"]; ?></td>
									</tr>
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

				<!-- Chart HS -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header pb-0">
							<h3>Komoditi</h3>
						</div>
						<div class="box-body p-0">
							<div class="col-sm-12 col-md-6">
								<div class="box-header p-0">
									<small>Proporsi nilai pabean per HS dalam miliar rupiah</small>
								</div>
								<div id="chart-pie-hs-nilai" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="box-header p-0">
									<small>Proporsi bea masuk per HS dalam miliar rupiah</small>
								</div>
								<div id="chart-pie-hs-bm" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 pt-5">
								<table id="table-data-hs" class="table table-striped row-border m-b-none">
									<thead>
										<tr>
											<th rowspan="3" class="text-center align-middle border-left">Kode HS</th>
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

				<!-- Chart jalur -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header pb-0">
							<h3>Jalur</h3>
						</div>
						<div class="box-body p-0">
							<div class="col-sm-12 col-md-5">
								<div class="box-header p-0">
									<small>Jumlah PIB per jalur</small>
								</div>
								<div id="chart-pie-jalur-dok" style="height:40vh"></div>
							</div>
							<div class="col-sm-12 col-md-7">
								<div class="box-header p-0">
									<small>Jumlah PIB per jalur per bulan</small>
								</div>
								<div id="chart-bar-jalur-dok" style="height:40vh"></div>
							</div>
							<div class="col-sm-12">
								<table id="table-data-jalur" class="table table-striped row-border m-b-none">
									<thead>
										<tr>
											<th>Grup Jalur</th>
											<th>Jalur</th>
											<th>Jml PIB</th>
											<th>Nilai Pabean (juta Rp)</th>
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

				<!-- Chart negara -->
				<div class="row-col box">
					<div class="col-sm-12">
						<div class="box-header pb-0">
							<h3>Negara Pemasok</h3>
						</div>
						<div class="box-body p-0">
							<div class="col-sm-12 col-md-8">
								<div class="box-header p-0">
									<small>Nilai pabean per negara pemasok dalam juta rupiah</small>
								</div>
								<div id="chart-map-negara-nilai" style="height:70vh"></div>
							</div>
							<div class="col-sm-12 col-md-4">
								<table id="table-data-negara" class="table table-striped padding-sm row-border m-b-none">
									<thead>
										<tr>
											<th>Negara</th>
											<th>Jml PIB</th>
											<th>Nilai Pabean<br>(juta Rp)</th>
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