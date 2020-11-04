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
			</div>
		</div>
	</div>
</div>