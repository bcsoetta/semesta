<?php

class Perbend_penerimaan_model extends CI_Model {

	public function GetBmTargetBulan()
	{
		$query = $this->db->query("
			SELECT
				c.tahun year,
				c.bulan month,
				pen.bm,
				c.bm bm_target
			FROM (
				SELECT
					b.year,
					b.month,
					SUM(a.tagihan) bm
				FROM db_semesta.fact_penerimaan a
				LEFT JOIN db_semesta.dim_date b ON a.tgl_ntpn = b.id
				WHERE 
					a.akun IN ('412111', '412114')
				GROUP BY 1,2
			) pen
			RIGHT JOIN db_semesta.ref_penerimaan_target c 
				ON pen.year = c.tahun AND pen.month = c.bulan
		");

		return $query->result();
	}

	public function DisplayBmTargetBulanTable()
	{
		$data = [];
		$bm_kumulatif = 0;
		$bm_target_kumulatif = 0;

		$query_res = $this->GetBmTargetBulan();
		for ($i=0; $i < count($query_res); $i++) { 
			$tgl = $query_res[$i]->year . '-' . $query_res[$i]->month;
			$tgl = date('M-Y',strtotime($tgl));

			$bm_target = $query_res[$i]->bm_target/1000000000;
			$bm_target_kumulatif += $bm_target;

			if ($query_res[$i]->bm != null) {
				$bm = $query_res[$i]->bm/1000000000;
				$bm_kumulatif += $bm;
			} else {
				$bm = null;
				$bm_kumulatif = null;
			}

			$data[$i] = [
				'no' => $i,
				'tgl' => $tgl,
				'bm' => round((float)$bm,2),
				'bm_target' => round((float)$bm_target,2),
				'bm_kumulatif' => round((float)$bm_kumulatif,2),
				'bm_target_kumulatif' => round((float)$bm_target_kumulatif,2)
			];
		}

		return $data;
	}

	public function DisplayBmTargetBulanChart()
	{
		$query_res = $this->GetBmTargetBulan();

		$bm_kumulatif = 0;
		$bm_target_kumulatif = 0;

		foreach ($query_res as $row) {
			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$bm_target = ($row->bm_target)/1000000000;
			$bm_target_kumulatif += $bm_target;

			if ($row->bm != null) {
				$bm = ($row->bm)/1000000000;
				$bm_kumulatif += $bm;	
				$data_bm = round((float)$bm_kumulatif,2);
			} else {
				$data_bm = null;
			}
			
			$data['bm_target'][] = round((float)$bm_target_kumulatif,2);
			$data['bm'][] = $data_bm;
		}
		$data['tgl'] = array_values(array_unique($list_tgl));

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => ['Penerimaan', 'Target']
			],
			'calculable' => false,
			'grid' => [
				'left' => 75,
				'top' => 45,
				'right' => 75,
				'bottom' => 45
			],
			'xAxis' => [
				[
					'type' => 'category',
					// 'boundaryGap' => false,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Bea Masuk (milyar Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			'color' => ['#0074D9', '#5fe86f'],
			'series' => [
				[
					'name' => 'Penerimaan',
					'type' => 'line',
					'data' => $data['bm']
				],
				[
					'name' => 'Target',
					'type' => 'bar',
					'data' => $data['bm_target']
				]
			]
		];

		return $jsonObject;
	}
}