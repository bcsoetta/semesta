<style type="text/css">
	.reginfo {
		color: #d9534f;
	}
</style>

<link rel="stylesheet" href="<?php echo base_url('assets/libs/jquery/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'); ?>" type="text/css" />

<div ui-view class="app-body" id="view">
	<div class="row-col b-b">
		<div class="col-md">
			<div class="padding">
				<div class="row">
					<!-- content -->
					<div class="col-sm">
						<form action="<?php echo base_url('umum/ppkp_create_process');?>" method="POST">
							<div class="box">
								<div class="box-header">
									<h3>Form PPKP</h3>
								</div>
								<div class="box-body">
									<div class="form-group">
										<label>Tema</label>
										<input name="tema" type="text" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Tempat</label>
										<select name="tempat" required class="form-control c-select">
											<option value="Ruang Rapat Gedung A, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta">Ruang Rapat Gedung A, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta</option>
											<option value="Ruang Rapat Gedung B, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta">Ruang Rapat Gedung B, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta</option>
										</select>
									</div>
									<div class="row m-b">
										<div class="col-sm-6 m-b">
											<label>Jum. Peserta</label>
											<input name="jum_peserta" type="text" class="form-control" required>
										</div>
										<div class="col-sm-6 m-b">
											<label>Tgl. Pelaksanaan</label>
											<div class='input-group date' id='datetimepicker3'>
												<input type='text' name="tgl_pelaksanaan" class="form-control"/>
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="row m-b">
										<div class="col-sm-6 m-b">
											<label>Waktu Mulai</label>
											<div class='input-group date' id='datetimepicker1'>
												<input type='text' name="wkt1" class="form-control"/>
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
										<div class="col-sm-6">
											<label>Waktu Selesai</label>
											<div class='input-group date' id='datetimepicker2'>
												<input type='text' name="wkt2" class="form-control"/>
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="row m-b">
										<div class="col-sm-6 m-b">
											<label>Nomor Surat/UND</label>
											<input name="no_surat" type="text" class="form-control" required>
										</div>
										<div class="col-sm-6">
											<label>Tanggal Surat/UND</label>
											<div class='input-group date' id='datetimepicker4'>
												<input type='text' name="tgl_surat" class="form-control"/>
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									
									<div class="row m-b">
										<div class="col-sm-6">
											<label>Penyelenggara</label>
											<select required class="form-control c-select" name="penyelenggara">
												<option value="2">Bagian Umum</option>
												<option value="1">Lainnya</option>
											</select>
										</div>
										<div class="col-sm-6">
											<label>Status</label>
											<select required class="form-control c-select" name="status">
												<option value="Open">Open</option>
												<option value="Closed">Closed</option>
											</select>
										</div>
									</div>
								</div>
								<div class="p-a text-right">
									<button type="submit" class="btn info">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<!-- end content -->
				</div>
			</div>
		</div>
	</div>
</div>