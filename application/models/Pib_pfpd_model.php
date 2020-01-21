<?php
class Pib_pfpd_model extends CI_Model {

	public function prep_date($start, $end)
	{
		$date = [];

		if ($start == null || $start == '') {
			$date['start'] = date('Y-01-01');
		} else {
			$start = str_replace('/', '-', $start);
			$date['start'] = date('Y-m-d', strtotime($start));
		}

		if ($end == null || $end == '') {
			$date['end'] = date('Y-m-d', strtotime(date('Y-m-1') . '-1 day'));
		} else {
			$end = str_replace('/', '-', $end);
			$date['end'] = date('Y-m-d', strtotime($end));
		}

		return $date;
	}

	public function GetHit($jalur = 0, $start_date, $end_date)
	{
		switch ($jalur) {
			case 1:
				$filter_jalur = " a.JLR IN ('HL', 'HM', 'HH') AND ";
				break;

			case 2:
				$filter_jalur = " a.JLR = 'MK' AND ";
				break;

			case 3:
				$filter_jalur = " a.JLR IN ('MA', 'MM', 'MH') AND ";
				break;
			
			default:
				$filter_jalur = "";
				break;
		}

		$date = $this->prep_date($start_date, $end_date);

		$query = $this->db->query("
			SELECT
				src.NAMA_PFPD Nama,
				COUNT(src.NO_PIB) `Jml PIB`,
				COUNT(src.NO_SPTNP) `Jml SPTNP`,
				ROUND(((COUNT(src.NO_SPTNP) / COUNT(src.NO_PIB)) * 100), 2) `Hit Rate`,
				SUM(src.bm_diff) `BM Hit`,
				SUM(src.pdri_diff) `PDRI`,
				SUM(src.nilai_denda) `Denda`
			FROM (
				SELECT
					a.CAR,
					a.NIP_PFPD,
					a.NAMA_PFPD,
					a.NO_PIB,
					b.NO_SPTNP,
					b.NILAI_AKHIR_BM - b.NILAI_AWAL_BM bm_diff,
					(
						(b.NILAI_AKHIR_PPN + b.NILAI_AKHIR_PPH + b.NILAI_AKHIR_PPNBM) -
						(b.NILAI_AWAL_PPN + b.NILAI_AWAL_PPH + b.NILAI_AWAL_PPNBM)
					) pdri_diff,
					b.NILAI_DENDA
				FROM data_dt.new_pib_header a
				LEFT JOIN data_dt.sptnp b ON a.CAR = b.CAR AND b.FL_LEBIH <> 'Y'
				WHERE 
					a.TGL_PIB between '" . $date['start'] ."' and '" . $date['end'] . "' AND " . $filter_jalur . "
					a.NIP_PFPD <> ''
				ORDER BY 1
			) src
			GROUP BY src.NIP_PFPD
		");

		return $query->result();
	}

}
?>