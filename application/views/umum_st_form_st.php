<?php 
	// header("Content-type: application/vnd.ms-word");
	// header("Content-type: application/pdf");
	// header("Content-Disposition: inline; filename=filename.pdf");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Form ST</title>
	<style type="text/css">
		.naskah-dinas {
			font-family: "Arial", sans-serif;
			font-size: 11pt;
			font-weight: normal;
			color: black;
			width: 180mm;
			line-height: 13pt;
		}

		.naskah-dinas p {
			margin: 0;
		}

		.naskah-dinas .row {
			clear: both;
		}

		.naskah-dinas .col {
			float: left;
		}

		.naskah-dinas .col-25 {
			width: 25mm;
		}

		.naskah-dinas .center {
			text-align: center;
		}

		.naskah-dinas .kop-surat .logo-instansi {
			width: 30mm;
		}

		.naskah-dinas .kop-surat .logo-instansi img {
			width: 25mm;
		}

		.naskah-dinas .kop-surat .deskripsi-instansi {
			width: 150mm;
		}

		.naskah-dinas .kop-surat .nama-instansi {
			font-weight: bold;
			font-size: 13pt;
			padding-bottom: 7pt;
		}

		.naskah-dinas .kop-surat .alamat-instansi {
			font-size: 7pt;
			line-height: 7pt;
			padding-bottom: 3pt;
		}

		.naskah-dinas .content .judul {
			padding-top: 10pt;
		}

		.naskah-dinas .content .text {
			font-size: 11pt;
			text-align: justify;
			text-indent: 35pt;
		}

		.naskah-dinas .daftar-pegawai table {
			width: 180mm;
			border-collapse:collapse;
		}

		.naskah-dinas .daftar-pegawai table .row-name {
			width: 25mm;
		}

		.naskah-dinas .daftar-pegawai table .colon {
			margin-right: 2pt;
		}

		.naskah-dinas .daftar-pegawai table .row-text1 {
			width: 75mm;
		}

		.naskah-dinas .ttd {
			padding-left: 100mm;
		}

		.naskah-dinas .ttd .plh {
			position: absolute;
			left: 94mm;
		}

		.naskah-dinas .lampiran {
			page-break-before: always;
			margin-top: 50px;
		}

		.naskah-dinas .lampiran .header-lampiran {
			padding-left: 100mm;
			font-size: 9pt;
		}

		.naskah-dinas .lampiran .header-lampiran .head {
			font-size: 11pt;
		}

		.naskah-dinas .header-lampiran-label {
			width: 15mm;
			float: left;
		}

		.naskah-dinas .daftar-pegawai table > tr > th {
			font-weight: bold;
			text-align: center;
		}

		.naskah-dinas .lampiran .daftar-pegawai table > thead > tr > th,
		.naskah-dinas .lampiran .daftar-pegawai table > tbody > tr > td {
			border: 1px solid black;
			padding: 5px;
		}
	</style>
</head>
<body>
	<div class="naskah-dinas">
		<div class="hal-depan">
			<div class="kop-surat" style="clear: both">
				<div class="row">
					<div class="logo-instansi col center">
						<img src="<?php echo base_url('assets/images/my_image/logo-kemenkeu.png'); ?>">
					</div>
					<div class="deskripsi-instansi col center">
						<div class="nama-instansi">
							<p>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</p>
							<p style="font-size: 11pt">DIREKTORAT JENDERAL BEA DAN CUKAI</p>
							<p>KANTOR PELAYANAN UTAMA BEA DAN CUKAI</p>
							<p>TIPE C SOEKARNO HATTA</p>
						</div>
						<div class="alamat-instansi">
							<p>DAERAH GUDANG BANDARA SOEKARNO HATTA KOTAK POS-1023, TANGERANG 19111</p>
							<p>TELEPON 1500225; FAKSIMILI 5502105; SITUS: www.bcsoekarnohatta.beacukai.go.id</p>
						</div>
					</div>
				</div>
				
				<div class="row" style="border-bottom: 1.5pt solid"></div>
			</div>
			<div class="content row">
				<div class="judul center">
					<p>SURAT TUGAS</p>
					<p><?php echo $st_header->no_st; ?></p>
				</div>
				<br>
				<div class="text">
					<?php 
						if (count($st_detail) < 4) {
							$penugasan = ' dengan ini kami menugasi:';
						} else {
							$penugasan = ' dengan ini kami menugaskan pejabat / pegawai sebagaimana terlampir untuk melaksanakan tugas tersebut pada :';
						}
					?>
					<p>Dalam rangka melaksanakan tugas <?php echo $st_header->hal; ?>,<?php echo $penugasan; ?></p>
				</div>
				<br>

				<?php if (count($st_detail) < 4) { ?>
					<!-- START Daftar Pegawai -->
					<div class="daftar-pegawai">
						<?php foreach ($st_detail as $pegawai) { ?>
							<table>
								<tr>
									<td class="row-name col col-25"><p>nama / NIP</p></td>
									<td class="colon col">:</td>
									<td class="row-text col">
										<div class="row-text1 col"><?php echo $pegawai->nama; ?></div>
										<div class="row-text2 col"><?php echo $pegawai->nip; ?></div>
									</td>
								</tr>
								<tr>
									<td class="row-name col col-25">pangkat / gol</td>
									<td class="colon col">:</td>
									<td class="row-text col">
										<div class="row-text1 col"><?php echo $pegawai->pangkat; ?></div>
										<div class="row-text2 col"><?php echo $pegawai->pangkatgolongan; ?></div>
									</td>
								</tr>
								<tr>
									<td class="row-name col col-25">jabatan</td>
									<td class="colon col">:</td>
									<td class="row-text col"><?php echo $pegawai->jabatan; ?></td>
								</tr>
							</table>
							<br>
						<?php } ?>
					</div>
					<!-- END Daftar Pegawai -->
				<?php } ?>

				<?php if (count($st_detail) < 4) { ?>
					<div>
						<p>Untuk melaksanakan tugas tersebut pada :</p>
					</div>
					<br>
				<?php } ?>
				
				<div class="waktu-tempat">
					<table>
						<tr>
							<td class="row-name col col-25"><p>hari / tanggal</p></td>
							<td class="colon col">:</td>
							<td class="row-text col"><?php echo $st_header->tgl_tugas; ?></td>
						</tr>
						<tr>
							<td class="row-name col col-25">waktu</td>
							<td class="colon col">:</td>
							<td class="row-text col"><?php echo $st_header->wkt_tugas; ?></td>
						</tr>
						<tr>
							<td class="row-name col col-25">tempat</td>
							<td class="colon col">:</td>
							<td class="row-text col"><?php echo $st_header->tempat_tugas . ', ' . $st_header->kota_tugas; ?></td>
						</tr>
					</table>
					<br>
				</div>
				<div class="text">
					<p><?php echo 'Segala biaya yang timbul sebagai akibat dilaksanakannya surat tugas ini dibebankan pada DIPA ' . $st_header->ur_dipa . ' TA ' . $st_header->tahun; ?></p>
					<br>
					<p>Surat tugas ini disusun untuk dilaksanakan dan setelah selesai dilaksanakan, Pejabat/Pegawai segera menyampaikan laporan. Kepada instansi terkait, kami mohon bantuan demi kelancaran pelaksanaan tugas tersebut.</p>
				</div>
				<br><br><br>
				<div class="ttd">
					<p>Ditetapkan di Tangerang</p>
					<p><?php echo 'Pada tanggal ' . $st_header->tgl_st; ?></p>
					<?php if ($st_header->plh == '1') { ?>
						<p class="plh">Plh.</p>
					<?php } ?>
					<p><?php echo $st_header->jabatan; ?></p>
					<br><br><br><br>
					<p><?php echo $st_header->nama; ?></p>
				</div>
			</div>
		</div>

		<?php if (count($st_detail) >= 4) { ?>
			<div class="lampiran">
				<div class="header-lampiran">
					<p class="head">LAMPIRAN</p>
					<p><?php echo 'Surat Tugas ' . $st_header->jabatan; ?></p>
					<div class="header-lampiran-label">Nomor</div><div><?php echo ': ' . $st_header->no_st; ?></div>
					<div class="header-lampiran-label">Tanggal</div><div><?php echo ': ' . $st_header->tgl_st; ?></div>
				</div>
				<div class="content">
					<h4 class="judul center">
						Daftar Pejabat/ Pegawai Berkenaan dengan Surat Tugas
					</h4>
					<div class="daftar-pegawai">
						<table>
							<thead>
								<tr>
									<th>No</th>
									<th>Nama / NIP</th>
									<th>Gol. / Pangkat</th>
									<th>Jabatan</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$no = 1;
									foreach ($st_detail as $pegawai) { 
								?>
									<tr>
										<td class="center"><?php echo $no; $no++; ?></td>
										<td><?php echo $pegawai->nama . ' / <br>' . $pegawai->nip; ?></td>
										<td class="center"><?php echo $pegawai->pangkat . ' / <br>' . $pegawai->pangkatgolongan; ?></td>
										<td><?php echo $pegawai->jabatan; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>	
					</div>
					<br><br><br>
					<div class="ttd">
						<?php if ($st_header->plh == '1') { ?>
							<p class="plh">Plh.</p>
						<?php } ?>
						<p><?php echo $st_header->jabatan; ?></p>
						<br><br><br><br>
						<p><?php echo $st_header->nama; ?></p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</body>
</html>