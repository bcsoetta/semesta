<?php

class Pib_penerimaan_model extends CI_Model {

	public function prep_date($start, $end)
	{
		$date = [];

		if ($start == null) {
			$date['start'] = date('Y-m-01', strtotime('-1 year'));
		} else {
			$start = str_replace('/', '-', $start);
			$date['start'] = date('Y-m-d', strtotime($start));
		}

		if ($end == null) {
			$date['end'] = date('Y-m-d', strtotime(date('Y-m-1') . '-1 day'));
		} else {
			$end = str_replace('/', '-', $end);
			$date['end'] = date('Y-m-d', strtotime($end));
		}

		return $date;
	}

	public function penerimaan_total($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT 
				sum(a.total_bm) bm_bayar, sum(a.total_bm_dp) bm_dp, sum(a.total_bm_tangguh) bm_tangguh, sum(a.total_bm_bebas) bm_bebas,
				sum(a.total_ppn) ppn_bayar, sum(a.total_ppn_dp) ppn_dp, sum(a.total_ppn_tangguh) ppn_tangguh, sum(a.total_ppn_bebas) ppn_bebas,
				sum(a.total_pph) pph_bayar, sum(a.total_pph_dp) pph_dp, sum(a.total_pph_tangguh) pph_tangguh, sum(a.total_pph_bebas) pph_bebas,
				sum(a.total_ppnbm) ppnbm_bayar, sum(a.total_ppnbm_dp) ppnbm_dp, sum(a.total_ppnbm_tangguh) ppnbm_tangguh, sum(a.total_ppnbm_bebas) ppnbm_bebas
			from fact_pib a
			inner join dim_date b on a.tgl_pib = b.id
			where b.date between '" . $date['start'] . "' and '" . $date['end'] . "'
		");

		return $query->result();
	}

	public function penerimaan_bulan($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT 
				b.year, b.month, 
				sum(a.total_bm) bm, 
				sum(a.total_ppn) ppn, 
				sum(a.total_pph) pph, 
				sum(a.total_ppnbm) ppnbm
			from fact_pib a
			inner join dim_date b on a.tgl_pib = b.id
			where b.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by 1,2
		");

		return $query->result();
	}

	public function penerimaan_top($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT 
				c.nama, 
				sum(a.total_bm) bm, 
				sum(a.total_ppn) ppn, 
				sum(a.total_pph) pph, 
				sum(a.total_ppnbm) ppnbm, 
				(sum(a.total_bm) + sum(a.total_ppn) + sum(a.total_pph) + sum(a.total_ppnbm)) total
			from fact_pib a
			inner join dim_date b on a.tgl_pib = b.id
			inner join dim_pib_importir c on a.wp_imp = c.id
			where b.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by c.npwp
			order by total desc
			limit 10
		");

		return $query->result();
	}

	public function bm_top($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT c.nama, sum(a.total_bm) bm
			from fact_pib a
			inner join dim_date b on a.tgl_pib = b.id
			inner join dim_pib_importir c on a.wp_imp = c.id
			where b.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by c.npwp
			order by bm desc
			limit 10
		");

		return $query->result();
	}

	public function penerimaan_total_table1($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$data[$key] = round($value/1000000,2);
		}

		return $data;
	}

	public function penerimaan_total_table($query_res)
	{
		$data = [];

		$data = [
			'paging' => [
				'enabled' => true,
				'limit' => 5,
				'size' => 10
			],
			'sorting' => [
				'enabled' => true
			]
		];

		$data['columns'] = [
			[
				'name' => 'pungutan',
				'title' => 'Pungutan',
				'type' => 'text'
			],
			[
				'name' => 'bayar',
				'title' => 'Bayar',
				'type' => 'number'
			],
			[
				'name' => 'dp',
				'title' => 'DP',
				'type' => 'number',
				'breakpoints' => 'all'
			],
			[
				'name' => 'tangguh',
				'title' => 'Tangguh',
				'type' => 'number',
				'breakpoints' => 'all'
			],
			[
				'name' => 'bebas',
				'title' => 'Bebas',
				'type' => 'number',
				'breakpoints' => 'all'
			]
		];

		$data['rows'] = [
			['pungutan' => 'bm'],
			['pungutan' => 'ppn'],
			['pungutan' => 'pph'],
			['pungutan' => 'ppnbm']
		];

		foreach ($query_res[0] as $key => $value) {
			// foreach ($value as $key => $value) {
				if (substr($key, 0, 3) == 'bm_') {
					$data['rows'][0][substr($key, 3)] = round($value/1000000,2,PHP_ROUND_HALF_UP);
				} elseif (substr($key, 0, 4) == 'ppn_') {
					$data['rows'][1][substr($key, 4)] = round($value/1000000,2,PHP_ROUND_HALF_UP);
				} elseif (substr($key, 0, 4) == 'pph_') {
					$data['rows'][2][substr($key, 4)] = round($value/1000000,2,PHP_ROUND_HALF_UP);
				} elseif (substr($key, 0, 6) == 'ppnbm_') {
					$data['rows'][3][substr($key, 6)] = round($value/1000000,2,PHP_ROUND_HALF_UP);
				}
			// }
			
		}

		return $data;

	}

	public function penerimaan_bulan_line($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$jenis_penerimaan[] = $key;
			$data[$key] = [];
		}

		$jenis_penerimaan = array_filter($jenis_penerimaan,function($a) {return $a <> 'year' && $a <> 'month';});
		$jenis_penerimaan = array_values($jenis_penerimaan);

		foreach ($query_res as $row) {
			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$data['tgl'][] = $tgl;

			$data['bm'][] = round($row->bm/1000000,2);
			$data['ppn'][] = round($row->ppn/1000000,2);
			$data['pph'][] = round($row->pph/1000000,2);
			$data['ppnbm'][] = round($row->ppnbm/1000000,2);
		}

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
					'left' => 85,
					'right'=> 25,
					'top' => 45,
					'bottom' => 40
			],
			'legend' => [
				'data' => $jenis_penerimaan
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'category',
					'boundaryGap' => false,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'name' => 'Penerimaan (juta Rp)',
					'nameLocation' => 'center',
					'nameGap' => 70,
					'type' => 'value'
				]
			],
			'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => []
		];

		foreach ($jenis_penerimaan as $penerimaan) {
			$series = [
				'name' => $penerimaan,
				'type' => 'line',
				'smooth' => true,
				'data' => $data[$penerimaan]
			];
			$jsonObject['series'][] = $series;
		}

		return $jsonObject;
	}

	public function penerimaan_top_bar($query_res)
	{
		$query_res = array_reverse($query_res);
		$data = [];

		$rep_pattern = '^([Pp][Tt]\W\s|[Pp][Tt]\W|[Cc][Vv]\W\s|[Cc][Vv]\W)^';

		foreach ($query_res[0] as $key => $value) {
			$jenis_penerimaan[] = $key;
			$data[$key] = [];
		}

		$jenis_penerimaan = array_slice($jenis_penerimaan,1,-1);

		foreach ($query_res as $row) {
			$imp = preg_replace($rep_pattern, '', $row->nama);

			if (strlen($imp) > 15) {
				$imp = substr($imp, 0, 15);
				$data['imp'][] = $imp.'...';
			} else {
				$data['imp'][] = $imp;
			}

			$data['bm'][] = round($row->bm/1000000000,2);
			$data['ppn'][] = round($row->ppn/1000000000,2);
			$data['pph'][] = round($row->pph/1000000000,2);
			$data['ppnbm'][] = round($row->ppnbm/1000000000,2);
			$data['total'][] = round($row->total/1000000000,2);
		}

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $jenis_penerimaan
			],
			'calculable' => false,
			'grid' => [
				'left' => 150,
				'top' => 30,
				'bottom' => 45
			],
			'xAxis' => [
				[
					'name' => 'Penerimaan (miliar Rp)',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'value',
					'boundaryGap' => [0, 0.1]
				]
			],
			'yAxis' => [
				[
					'name' => 'Importir',
					'nameLocation' => 'center',
					'nameGap' => 140,
					'type' => 'category',
					'data' => $data['imp']
				]
			],
			'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => []
		];

		foreach ($jenis_penerimaan as $penerimaan) {
			$series = [
				'name' => $penerimaan,
				'type' => 'bar',
				'stack' => 'penerimaan',
				'data' => $data[$penerimaan]
			];
			$jsonObject['series'][] = $series;
		}

		$totalSeries = [
			'type' => 'scatter',
			'symbolSize' => 1,
			'label' => [
				'normal' => [
					'show' => true,
					'position' => 'right'
				]
			],
			'data' => $data['total']
		];

		$jsonObject['series'][] = $totalSeries;

		return $jsonObject;
	}

	public function bm_top_bar($query_res)
	{
		$query_res = array_reverse($query_res);
		$data_imp = [];
		$data_bm = [];

		$rep_pattern = '^([Pp][Tt]\W\s|[Pp][Tt]\W|[Cc][Vv]\W\s|[Cc][Vv]\W)^';

		foreach ($query_res as $row) {
			$imp = preg_replace($rep_pattern, '', $row->nama);
			$bm = round($row->bm/1000000000,2);

			if (strlen($imp) > 15) {
				$imp = substr($imp, 0, 15);
				$data_imp[] = $imp.'...';
			} else {
				$data_imp[] = $imp;
			}
			
			$data_bm[] = $bm;
		}

		$jsonObject = [
			'calculable' => false,
			'grid' => [
				'x' => 150,
				'top' => 30,
				'bottom' => 45
			],
			'xAxis' => [
				[
					'name' => 'Penerimaan (miliar Rp)',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'value',
					'boundaryGap' => [0, 0.1]
				]
			],
			'yAxis' => [
				[
					'name' => 'Importir',
					'nameLocation' => 'center',
					'nameGap' => 140,
					'type' => 'category',
					'data' => $data_imp
				]
			],
			'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => [
				[
					'name' => 'jumlah',
					'type' => 'bar',
					'label' => [
						'normal' => [
							'show' => true,
							'position' => 'right'
						]
					],
					'data' => $data_bm
				]
			]
		];

		return $jsonObject;
	}

}