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
						<form action="<?php echo base_url('umum/ppkp_update_process');?>" method="POST">
							<div class="box">
								<div class="box-header">
									<h3>Form PPKP</h3>
								</div>
								<div class="box-body">
									<div class="form-group">
										<label>Tema</label>
										<input name="tema" type="text" class="form-control" value="<?php echo $ppkp[0]['tema']; ?>" required>
									</div>
									<div class="form-group">
										<label>Tempat</label>
										<select name="tempat" required class="form-control c-select">
											<option value="Ruang Rapat Gedung A, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta" <?php if($ppkp[0]['tempat']=="Ruang Rapat Gedung A, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta") echo "selected"; ?>>Ruang Rapat Gedung A, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta</option>
											<option value="Ruang Rapat Gedung B, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta" <?php if($ppkp[0]['tempat']=="Ruang Rapat Gedung B, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta") echo "selected"; ?>>Ruang Rapat Gedung B, Kantor Pelayanan Utama Bea dan Cukai Tipe C Soekarno Hatta</option>
										</select>
									</div>
									<div class="row m-b">
										<div class="col-sm-6 m-b">
											<label>Jum. Peserta</label>
											<input name="jum_peserta" type="text" class="form-control" value="<?php echo $ppkp[0]['jum_peserta']; ?>" required>
										</div>
										<div class="col-sm-6 m-b">
											<label>Tgl. Pelaksanaan</label>
											<div class='input-group date' id='datetimepicker3'>
												<input type='text' name="tgl_pelaksanaan" value="<?php echo date("d/m/Y", strtotime($ppkp[0]['tanggal'])); ?>" class="form-control"/>
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
												<input type='text' name="wkt1" value="<?php echo date("d/m/Y g:i A", strtotime($ppkp[0]['waktu_mulai'])); ?>" class="form-control"/>
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
										<div class="col-sm-6">
											<label>Waktu Selesai</label>
											<div class='input-group date' id='datetimepicker2'>
												<input type='text' name="wkt2" value="<?php echo date("d/m/Y g:i A", strtotime($ppkp[0]['waktu_selesai'])); ?>" class="form-control"/>
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="row m-b">
										<div class="col-sm-6 m-b">
											<label>No. S/ND/UND</label>
											<input name="no_surat" type="text" class="form-control" value="<?php echo $ppkp[0]['nomor_surat']; ?>" required>
										</div>
										<div class="col-sm-6">
											<label>Tgl. S/ND/UND</label>
											<div class='input-group date' id='datetimepicker4'>
												<input type='text' name="tgl_surat" value="<?php echo date("d/m/Y", strtotime($ppkp[0]['tanggal_surat'])); ?>" class="form-control"/>
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
												<option value="2" <?php if($ppkp[0]['penyelenggara']=="2") echo "selected"; ?>>Bagian Umum</option>
												<option value="1" <?php if($ppkp[0]['penyelenggara']=="1") echo "selected"; ?>>Lainnya</option>
											</select>
										</div>
										<div class="col-sm-6">
											<label>Status</label>
											<select required class="form-control c-select" name="status">
												<option value="Open" <?php if($ppkp[0]['status']=="Open") echo "selected"; ?>>Open</option>
												<option value="Closed" <?php if($ppkp[0]['status']=="Closed") echo "selected"; ?>>Closed</option>
											</select>
										</div>
									</div>
								</div>
								<div class="p-a text-right">
									<input type="hidden" name="pid" value="<?php echo $ppkp[0]['id']; ?>">
									<input class="pull-left btn btn-outline b-black text-black" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />
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