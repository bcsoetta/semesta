<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPPD</title>
    <style>
        .naskah-dinas {
            font-family: "Arial", sans-serif;
            font-size: 10pt;
            font-weight: normal;
            color: black;
            width: 180mm;
            line-height: 13pt;
        }

        table {
            border-collapse:collapse;
            width: 180mm;
        }

        td > table {
            margin: 0;
            padding: 0;
        }

        table > tbody > tr > td {
            margin: 0;
            padding: 0;
            border-spacing: 0;
            text-align: left;
            vertical-align: top;
        }

        table.sppd > tbody > tr > td {
            border: 1px solid black;
            padding: 3px 5px;
        }
        .center-top{
            text-align: center;
            vertical-align: text-top;
        }

        .left-top {
            text-align: left;
            vertical-align: text-top;
        }
        ol {
            margin: 0;
        }

        .naskah-dinas .header {
            width: 35%;
        }

        .naskah-dinas .header table {
            width: 100%;
        }

        .naskah-dinas .header .label {
            width: 25mm;
        }

        .naskah-dinas .ttd {
            width: 75mm;
        }

        .naskah-dinas .ttd .label {
            width: 25mm;
        }

        .naskah-dinas .ttd .ttd-img {
            width: 50mm;
        }

        .naskah-dinas .colon {
            width: 2mm;
        }

        .naskah-dinas .sppd .label {
            width: 75mm;
        }

        .naskah-dinas .sppd .numbering {
            width: 4mm;
            border-right: none;
        }

        .naskah-dinas .sppd .no-border-bottom {
            border-bottom: none;
        }

        .naskah-dinas .sppd .no-border-top {
            border-top: none;
        }

        .naskah-dinas .sppd .numbered {
            border-left: none;
        }

        .naskah-dinas .sppd .value1 {
            border-left: none;
            border-right: none;
        }

        .naskah-dinas .sppd .value2 {
            border-left: none;
        }

        .naskah-dinas .sppd .sub-label {
            border-right: none;
            width: 25mm;
        }

        .naskah-dinas .sppd .colon {
            border-right: none;
            border-left: none;
            width: 2mm;
        }

        .naskah-dinas .sppd .last-content {
            height: 25mm;
        }

        .naskah-dinas .sppd .pernyataan {
            text-align: justify;
        }

        .naskah-dinas .sppd .paraf-img {
            width: 2.5mm;
        }

    </style>
</head>
<body>
    <div class="naskah-dinas">
        <?php foreach ($st_detail as $pegawai) { ?>
            <div class="lembar-1" style="page-break-after: always;">
                <table style="width: 100%">
                    <tr>
                        <td>
                            <p style="margin: 0">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</p>
                            <p style="margin: 0">DIREKTORAT JENDERAL BEA DAN CUKAI</p>
                            <p style="margin: 0">KANTOR PELAYANAN UTAMA BEA DAN CUKAI</p>
                            <p style="margin: 0">TIPE C SOEKARNO-HATTA</p>
                        </td>
                        <td class="header">
                            <table>
                                <tr>
                                    <td class="label">LEMBAR</td>
                                    <td class="colon">:&nbsp;</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td class="label">KODE NO.</td>
                                    <td class="colon">:&nbsp;</td>
                                    <td>
                                        <?php 
                                            if ($st_header->dipa == '1') {
                                                echo('KPU.03/' . $st_header->tahun);
                                            } elseif ($st_header->dipa == '2') {
                                                echo('');
                                            } else {
                                                echo('AGENDA TIDAK DITEMUKAN');
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">NOMOR</td>
                                    <td class="colon">:&nbsp;</td>
                                    <td>
                                        <?php 
                                            if ($st_header->dipa == '1') {
                                                echo('SPD-' . $pegawai->no_spd);
                                            } elseif ($st_header->dipa == '2') {
                                                echo('SPD-');
                                            } else {
                                                echo('AGENDA TIDAK DITEMUKAN');
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>


                <p style="text-align: center; margin: 20px">SURAT PERJALANAN DINAS</p>

                <table class="sppd" style="width: 100%">
                    <tr>
                        <td class="center-top">1.</td>
                        <td class="label" colspan="2">Pejabat Pembuat Komitmen</td>
                        <td class="value" colspan="3"><?php echo $st_header->nama_ppk; ?></td>
                    </tr>
                    <tr>
                        <td class="center-top">2.</td>
                        <td class="label" colspan="2">Nama / NIP Pegawai yang diperintahkan</td>
                        <td class="value1" colspan="2"><?php echo $pegawai->nama; ?></td>
                        <td class="value2"><?php echo $pegawai->nip; ?></td>
                    </tr>
                    <tr>
                        <td class="center-top" rowspan="3">3.</td>
                        <td class="numbering center-top no-border-bottom">a.</td>
                        <td class="label numbered no-border-bottom">Pangkat dan Golongan ruang gaji menurut PP No. 11 Tahun 2011</td>
                        <td class="numbering center-top no-border-bottom">a.</td>
                        <td class="value1 numbered left-top no-border-bottom"><?php echo $pegawai->pangkat; ?></td>
                        <td class="value2 left-top no-border-bottom"><?php echo $pegawai->pangkatgolongan; ?></td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-bottom no-border-top">b.</td>
                        <td class="label numbered no-border-bottom no-border-top">Jabatan / Instansi</td>
                        <td class="numbering center-top no-border-bottom no-border-top">b.</td>
                        <td class="value numbered no-border-bottom no-border-top" colspan="2"><?php echo $pegawai->jabatan; ?></td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-top">c.</td>
                        <td class="label numbered no-border-top">Tingkat Biaya Perjalanan Dinas</td>
                        <td class="numbering center-top no-border-top">c.</td>
                        <td class="value numbered no-border-top" colspan="2">C</td>
                    </tr>
                    <tr>
                        <td class="center-top">4.</td>
                        <td class="label" colspan="2">Maksud Perjalanan Dinas</td>
                        <td class="value" colspan="3"><?php echo $st_header->hal; ?></td>
                    </tr>
                    <tr>
                        <td class="center-top">5.</td>
                        <td class="label" colspan="2">Alat angkutan yang digunakan</td>
                        <td class="value" colspan="3">Kendaraan Umum</td>
                    </tr>
                    <tr>
                        <td class="center-top no-border-bottom" rowspan="2">6.</td>
                        <td class="numbering center-top no-border-bottom">a.</td>
                        <td class="label numbered no-border-bottom">Tempat Berangkat</td>
                        <td class="numbering center-top no-border-bottom">a.</td>
                        <td class="value numbered no-border-bottom" colspan="2">Tangerang</td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-top">b.</td>
                        <td class="label numbered no-border-top">Tempat Tujuan</td>
                        <td class="numbering center-top no-border-top">b.</td>
                        <td class="value numbered no-border-top" colspan="2"><?php echo $st_header->kota_tugas; ?></td>
                    </tr>
                    <tr>
                        <td class="center-top no-border-bottom" rowspan="3">7.</td>
                        <td class="numbering center-top no-border-bottom">a.</td>
                        <td class="label numbered no-border-bottom">Lamanya Perjalanan Dinas</td>
                        <td class="numbering center-top no-border-bottom">a.</td>
                        <td class="value numbered no-border-bottom" colspan="2"><?php echo $st_header->hari . ' hari'; ?></td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-bottom no-border-top">b.</td>
                        <td class="label numbered no-border-bottom no-border-top">Tanggal Berangkat</td>
                        <td class="numbering center-top no-border-bottom no-border-top">b.</td>
                        <td class="value numbered no-border-bottom no-border-top" colspan="2"><?php echo $st_header->tgl_tugas_start; ?></td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-top">c.</td>
                        <td class="label numbered no-border-top">Tanggal Harus Kembali</td>
                        <td class="numbering center-top no-border-top">c.</td>
                        <td class="value numbered no-border-top" colspan="2"><?php echo $st_header->tgl_tugas_end; ?></td>
                    </tr>
                    <tr>
                        <td class="center-top">8.</td>
                        <td class="label" colspan="2">
                            <div style="float: left; width: 40%;">Pengikut :</div>
                            <div style="float: left; width: 30%;">Nama :</div>
                            <div style="float: left; width: 30%;">Umur :</div>
                        </td>
                        <td class="value" colspan="3">Hubungan keluarga / keterangan</td>
                    </tr>
                    <tr>
                        <td class="center-top no-border-bottom" rowspan="3">9.</td>
                        <td class="label no-border-bottom" colspan="2">Pembebanan Anggaran</td>
                        <td class="value no-border-bottom" colspan="3"></td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-bottom no-border-top">a.</td>
                        <td class="label numbered no-border-bottom no-border-top">Instansi</td>
                        <td class="numbering center-top no-border-bottom no-border-top">a.</td>
                        <td class="value numbered no-border-bottom no-border-top" colspan="3">Direktorat Jenderal Bea dan Cukai</td>
                    </tr>
                    <tr>
                        <td class="numbering center-top no-border-top">b.</td>
                        <td class="label numbered no-border-top">Mata Anggaran</td>
                        <td class="numbering center-top no-border-top">b.</td>
                        <td class="value numbered no-border-top" colspan="3">524111</td>
                    </tr>
                    <tr>
                        <td class="center-top">10.</td>
                        <td class="label" colspan="2">Keterangan lain-lain</td>
                        <td colspan="3"></td>
                    </tr>
                </table>

                <div>
                    <table class="ttd" style="margin-top: 20px; float: right">
                        <tr>
                            <td class="label">Dikeluarkan di</td>
                            <td class="colon">:&nbsp;</td>
                            <td>
                                <?php 
                                    if ($st_header->dipa == '1') {
                                        echo "Tangerang";
                                    } else {
                                        echo "";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">pada tanggal</td>
                            <td class="colon">:&nbsp;</td>
                            <td>
                                <?php 
                                    if ($st_header->dipa == '1') {
                                        echo $st_header->tgl_spd;
                                    } else {
                                        echo "";
                                    }
                                ?>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">Pejabat Pembuat Komitmen</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <?php if ($st_header->status == 50) { ?>
                                    <img class="ttd-img" src="<?php echo base_url('assets/images/my_image/ttd-ksbsdm.png'); ?>">
                                <?php } else { ?>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><?php echo $st_header->nama_ppk; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><?php echo 'NIP ' . $st_header->nip_ppk; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="lembar-2" style="page-break-after: always;">
                <table class="sppd">
                    <tbody>
                        <tr>
                            <td style="width: 50%;" colspan="4" rowspan="4"></td>
                            <td class="numbering left-top no-border-bottom" rowspan="3">I.</td>
                            <td class="sub-label numbered no-border-bottom">Berangkat dari</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom">Tangerang</td>
                        </tr>
                        <tr>
                            <td class="sub-label numbered no-border-bottom no-border-top">Ke</td>
                            <td class="colon no-border-bottom no-border-top">:</td>
                            <td class="value2 no-border-bottom no-border-top"><?php echo $st_header->kota_tugas; ?></td>
                        </tr>
                        <tr>
                            <td class="sub-label numbered no-border-bottom no-border-top">Pada Tanggal</td>
                            <td class="colon no-border-bottom no-border-top">:</td>
                            <td class="value2 no-border-bottom no-border-top"><?php echo $st_header->tgl_tugas_start; ?></td>
                        </tr>
                        <tr>
                            <td class="numbering no-border-top">
                                <br>
                                <?php if ($pegawai->plh_kbu == '1') { echo "Plh."; } ?>
                            </td>
                            <td class="numbered no-border-top" colspan="3">
                                <br>
                                <div>Kepala Bagian Umum</div>
                                <br><br><br><br>
                                <div>
                                    <?php echo $pegawai->pejabat_kbu; ?>
                                    <?php if ($st_header->status == 50) { ?>
                                        <img class="paraf-img" src="<?php echo base_url('assets/images/my_image/paraf-ksbsdm.png'); ?>">
                                    <?php } ?>
                                </div>
                                <div><?php echo 'NIP ' . $pegawai->nip_kbu; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="numbering left-top" rowspan="3">II.</td>
                            <td class="sub-label numbered no-border-bottom">Tiba di</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"><?php echo $st_header->kota_tugas; ?></td>
                            <td class="numbering" rowspan="3"></td>
                            <td class="sub-label numbered no-border-bottom">Berangkat dari</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"><?php echo $st_header->kota_tugas; ?></td>
                        </tr>
                        <tr>
                            <td class="sub-label numbered no-border-bottom no-border-top">Pada Tanggal</td>
                            <td class="colon no-border-bottom no-border-top">:</td>
                            <td class="value2 no-border-bottom no-border-top"><?php echo $st_header->tgl_tugas_start; ?></td>
                            <td class="sub-label numbered no-border-bottom no-border-top">Ke</td>
                            <td class="colon no-border-bottom no-border-top">:</td>
                            <td class="value2 no-border-bottom no-border-top">Tangerang</td>
                        </tr>
                        <tr class="last-content">
                            <td class="numbered no-border-top" colspan="3"></td>
                            <td class="sub-label numbered no-border-top">Pada Tanggal</td>
                            <td class="colon no-border-top">:</td>
                            <td class="value2 no-border-top"><?php echo $st_header->tgl_tugas_end; ?></td>
                        </tr>
                        <tr>
                            <td class="numbering left-top no-border-bottom" rowspan="3">III.</td>
                            <td class="sub-label numbered no-border-bottom">Tiba di</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"></td>
                            <td class="numbering" rowspan="3"></td>
                            <td class="sub-label numbered no-border-bottom">Berangkat dari</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"></td>
                        </tr>
                        <tr>
                            <td class="sub-label numbered no-border-bottom no-border-top">Pada Tanggal</td>
                            <td class="colon no-border-bottom no-border-top">:</td>
                            <td class="value2 no-border-bottom no-border-top"></td>
                            <td class="sub-label numbered no-border-bottom no-border-top">Ke</td>
                            <td class="colon no-border-bottom no-border-top">:</td>
                            <td class="value2 no-border-bottom no-border-top"></td>
                        </tr>
                        <tr class="last-content">
                            <td class="numbered no-border-top" colspan="3"></td>
                            <td class="sub-label numbered no-border-top">Pada Tanggal</td>
                            <td class="colon no-border-top">:</td>
                            <td class="value2 no-border-top"></td>
                        </tr>
                        <tr>
                            <td class="numbering" rowspan="3">IV.</td>
                            <td class="sub-label numbered no-border-bottom">Tiba di</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"></td>
                            <td class="numbering" rowspan="3"></td>
                            <td class="sub-label numbered no-border-bottom">Berangkat dari</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"></td>
                        </tr>
                        <tr>
                            <td class="sub-label numbered no-border-top no-border-bottom">Pada Tanggal</td>
                            <td class="colon no-border-top no-border-bottom">:</td>
                            <td class="value2 no-border-top no-border-bottom"></td>
                            <td class="sub-label numbered no-border-top no-border-bottom">Ke</td>
                            <td class="colon no-border-top no-border-bottom">:</td>
                            <td class="value2 no-border-top no-border-bottom"></td>
                        </tr>
                        <tr class="last-content">
                            <td class="numbered no-border-top" colspan="3"></td>
                            <td class="sub-label numbered no-border-top">Pada Tanggal</td>
                            <td class="colon no-border-top">:</td>
                            <td class="value2 no-border-top"></td>
                        </tr>
                        <tr>
                            <td class="numbering" rowspan="7">V.</td>
                            <td class="sub-label numbered no-border-bottom" style="height: 5mm;">Tiba di</td>
                            <td class="colon no-border-bottom">:</td>
                            <td class="value2 no-border-bottom"></td>
                            <td class="numbering" rowspan="7"></td>
                            <td class="numbered no-border-bottom" rowspan="3" colspan="3">
                                <div class="pernyataan">Telah diperiksa dengan keterangan bahwa perjalanan tersebut di atas benar dilakukan atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu sesingkat-singkatnya.</div>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td class="sub-label numbered no-border-top no-border-bottom">Pada Tanggal</td>
                            <td class="colon no-border-top no-border-bottom">:</td>
                            <td class="value2 no-border-top no-border-bottom"></td>
                        </tr>
                        <tr>
                            <td class="numbered no-border-top no-border-bottom" colspan="3"></td>
                        </tr>
                        <tr>
                            <td class="numbered no-border-top no-border-bottom" colspan="3">Pejabat Pembuat Komitmen</td>
                            <td class="numbered no-border-top no-border-bottom" colspan="3">Pejabat Pembuat Komitmen</td>
                        </tr>
                        <tr>
                            <td class="numbered no-border-top no-border-bottom" colspan="3">
                                <br><br><br>
                            </td>
                            <td class="numbered no-border-top no-border-bottom" colspan="3">
                                <br><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="numbered no-border-top no-border-bottom" colspan="3"><?php echo $st_header->nama_ppk; ?></td>
                            <td class="numbered no-border-top no-border-bottom" colspan="3"><?php echo $st_header->nama_ppk; ?></td>
                        </tr>
                        <tr>
                            <td class="numbered no-border-top no-border-bottom" colspan="3"><?php echo $st_header->nip_ppk; ?></td>
                            <td class="numbered no-border-top no-border-bottom" colspan="3"><?php echo $st_header->nip_ppk; ?></td>
                        </tr>
                        <tr>
                            <td class="numbering left-top">VI.</td>
                            <td class="sub-label numbered" colspan="3">Catatan lain-lain :</td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td class="numbering no-border-bottom">VII.</td>
                            <td class="numbered no-border-bottom" colspan="7">PERHATIAN</td>
                        </tr>
                        <tr>
                            <td class="pernyataan no-border-top" colspan="8">PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian, dan kealpaannya.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</body>
</html>