<?php

class Barkir_pdtt_model extends CI_Model {
	public function prep_date($start, $end)
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

	public function GetSummary($jalur, $start_date, $end_date)
	{
		switch ($jalur) {
			case 1:
				$filter_jalur = " a.jalur IN (1,2) AND ";
				break;

			case 2:
				$filter_jalur = " a.jalur = 3 AND ";
				break;
			
			default:
				$filter_jalur = "";
				break;
		}

		$date = $this->prep_date($start_date, $end_date);

		$query = $this->db->query("
				SELECT
					a.pdtt,
					b.NIP,
					b.NAMA,
					ifnull(
						sum(
							case
								when a.jenis_aju = 1
								then a.jumlah_dok
							end
						), 0
					) CN,
					ifnull(
						sum(
							case
								when a.jenis_aju = 2
								then a.jumlah_dok
							end
						), 0
					) PIBK,
					SUM(a.jumlah_dok) `TOTAL DOK`,
					SUM(a.jumlah_dok_hit) `TOTAL HIT`,
					CONCAT(ROUND((SUM(a.jumlah_dok_hit) / SUM(a.jumlah_dok)) * 100, 2), ' %') `HIT RATE`,
					SUM(a.total_bm_penetapan) `BM PENETAPAN`,
					SUM(a.total_bm_penetapan) - SUM(a.total_bm_aju) `BM HIT`
				FROM db_semesta.fact_barkir a
				INNER JOIN db_semesta.dim_pegawai b ON a.pdtt = b.id
				INNER JOIN db_semesta.dim_date c ON a.tgl_house_blawb = c.id
				WHERE 
					a.pdtt NOT IN (0,1) AND " . $filter_jalur . "
					c.date BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
				GROUP BY 1
			");

		return $query->result();
	}
}