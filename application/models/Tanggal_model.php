<?php

class Tanggal_model extends CI_Model {

	public function ConvertTanggal($date='', $format='')
	{
		setlocale(LC_ALL, 'id_ID.utf-8');
		
		if ($date != '' || $date != null) {
			$tanggal = strftime($format, strtotime($date));
		} else {
			$tanggal = null;
		}
		
		return $tanggal;
	}

	public function ConvertRangeTanggal($start_date='', $end_date='')
	{

		$hari = '';
		$tanggal = '';

		setlocale(LC_ALL, 'id_ID.utf-8');

		if ($end_date == null || $end_date == '' || $start_date == $end_date) {

			$hari = strftime("%A", strtotime($start_date));
			$tanggal = strftime("%d %B %Y", strtotime($start_date));

		} else {

			$hari_start = strftime("%A", strtotime($start_date));
			$hari_end = strftime("%A", strtotime($end_date));
			$tanggal_start = strftime("%d", strtotime($start_date));
			$tanggal_end = strftime("%d", strtotime($end_date));
			$bulan_start = strftime("%B", strtotime($start_date));
			$bulan_end = strftime("%B", strtotime($end_date));
			$tahun_start = strftime("%Y", strtotime($start_date));
			$tahun_end = strftime("%Y", strtotime($end_date));

			$hari = $hari_start . ' s.d. ' . $hari_end;

			if ($tahun_start == $tahun_end) {
				if ($bulan_start == $bulan_end) {
					$tanggal = $tanggal_start . ' s.d. ' . $tanggal_end . ' ' . $bulan_start . ' ' . $tahun_start;
				} else {
					$tanggal = $tanggal_start . ' ' . $bulan_start . ' s.d. ' . $tanggal_end . ' ' . $bulan_end . ' ' . $tahun_start;
				}
			} else {
				$tanggal = $tanggal_start . ' ' . $bulan_start . ' ' . $tahun_start . ' s.d. ' . $tanggal_end . ' ' . $bulan_end . ' ' . $tahun_end;
			}

		}

		return $hari . ' / ' . $tanggal;

	}

	public function ConvertRangeWaktu($start_waktu='', $end_waktu='')
	{
		$waktu = '';

		if ($end_waktu == null || $end_waktu == '' || $start_waktu == $end_waktu) {
			$waktu = $start_waktu . ' WIB s.d. selesai';
		} else {
			$waktu = $start_waktu . ' s.d. ' . $end_waktu . ' WIB';
		}

		return $waktu;
	}

	public function PrepFilterDate($start, $end)
	{
		$date = [];

		if ($start == null) {
			$date['start'] = date('Y-01-01');
		} else {
			$start = str_replace('/', '-', $start);
			$date['start'] = date('Y-m-d', strtotime($start));
		}

		if ($end == null) {
			$date['end'] = date('Y-m-d');
		} else {
			$end = str_replace('/', '-', $end);
			$date['end'] = date('Y-m-d', strtotime($end));
		}

		return $date;
	}

}