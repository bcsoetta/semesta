<?php

class Pib_dwelling_time_model extends CI_Model {

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

	public function dt_total_last()
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT
				'TOTAL' jalur,
				ROUND(pre,2) pre, 
				ROUND(customs, 4) customs, 
				ROUND(post, 2) post,
				ROUND(pre + customs + post, 2) total
			from avg_pib_dt a
			where a.tahun = year(now() - interval 1 month)
			and a.bulan = month(now() - interval 1 month)
		");

		return $query->result();
	}

	public function dt_jalur_last()
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT  
				jalur, 
				ROUND(pre,2) pre, 
				ROUND(customs, 4) customs, 
				ROUND(post, 2) post,
				ROUND(pre + customs + post, 2) total
			from avg_pib_dt_jlr a
			where a.tahun = year(now() - interval 1 month)
			and a.bulan = month(now() - interval 1 month)
		");

		return $query->result();
	}

	public function dt_total($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT tahun as year, bulan as month, pre, customs, post 
			from avg_pib_dt
			where CONCAT(tahun, LPAD(bulan,2,0)) 
			between EXTRACT(YEAR_MONTH FROM '" . $date['start'] . "') 
			and EXTRACT(YEAR_MONTH FROM '" . $date['end'] . "')
		");

		return $query->result();
	}

	public function dt_jalur($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT tahun as year, bulan as month, jalur, pre, customs, post 
			from avg_pib_dt_jlr
			where CONCAT(tahun, LPAD(bulan,2,0)) 
			between EXTRACT(YEAR_MONTH FROM '" . $date['start'] . "') 
			and EXTRACT(YEAR_MONTH FROM '" . $date['end'] . "')
		");

		return $query->result();
	}

	// public function dt_last_table($query_total, $query_jalur)
	// {
	// 	$data = [];
	// 	$data['TOTAL'] = $query_total[0];
	// 	foreach ($query_jalur as $key => $value) {
	// 		$data[$value->jalur] = $value;
	// 	}

	// 	return $data;
	// }

	public function dt_last_table($query_total, $query_jalur)
	{
		$data = [];
		$columns = [];

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

		$rows[] = $query_total[0];
		foreach ($query_jalur as $key => $value) {
			$rows[$value->jalur] = $value;
		}

		$rows = array_values($rows);

		foreach ($rows[0] as $key => $value) {
			if (!in_array($key, array('jalur'))) {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'number'
				];
			} else {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'text'
				];
			}
		}

		$data['columns'] = $columns;
		$data['rows'] = $rows;
		return $data;
	}

	public function dt_total_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month';});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$data['tgl'][] = $tgl;

			$data['pre'][] = round($row->pre,2);
			$data['customs'][] = round($row->customs,2);
			$data['post'][] = round($row->post,2);
			$data['total'][] = round($row->pre + $row->customs + $row->post,2);
		}

		$jsonObject = [
			'legend' => [
				'data' => $dwelling_time
			],
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
				'left' => 45,
				'right' => 15,
				'top' => 45,
				'bottom' => 45
			],
			'yAxis' => [
				[
					'name' => 'Dwelling Time (dalam hari)',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'value',
					'boundaryGap' => [0, 0.1]
				]
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'category',
					'data' => $data['tgl']
				]
			],
			'color' => ['#0074D9','#FF4136','#2ECC40'],
			'series' => []
		];

		foreach ($dwelling_time as $dt) {
			$series = [
				'name' => $dt,
				'type' => 'bar',
				'stack' => 'dt',
				'data' => $data[$dt]
			];
			$jsonObject['series'][] = $series;
		}

		$totalSeries = [
			'type' => 'scatter',
			'symbolSize' => 1,
			'label' => [
				'normal' => [
					'show' => true,
					'position' => 'top'
				]
			],
			'data' => $data['total']
		];

		$jsonObject['series'][] = $totalSeries;

		return $jsonObject;
	}

	public function dt_prioritas_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jalur';});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jalur == 'PRIORITAS') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,4);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jalur == 'PRIORITAS' || $row->jalur == 'HIJAU' || $row->jalur == 'KUNING' || $row->jalur == 'MERAH') {
				$data['all'][] = $row->pre + $row->customs + $row->post;	
			}
		}

		$jsonObject = [
			'legend' => [
				'data' => $dwelling_time
			],
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
				'left' => 20,
				'right' => 15,
				'top' => 45,
				'bottom' => 35
			],
			'yAxis' => [
				[
					// 'name' => 'Dwelling Time (dalam hari)',
					// 'nameLocation' => 'center',
					// 'nameGap' => 30,
					'type' => 'value',
					'max' => round(max($data['all']) + 2)
					// 'boundaryGap' => [0, 0.1]
				]
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 25,
					'type' => 'category',
					'data' => $data['tgl']
				]
			],
			'color' => ['#0074D9','#FF4136','#2ECC40'],
			'series' => []
		];

		foreach ($dwelling_time as $dt) {
			$series = [
				'name' => $dt,
				'type' => 'bar',
				'stack' => 'dt',
				'data' => $data[$dt]
			];
			$jsonObject['series'][] = $series;
		}

		// $totalSeries = [
		// 	'type' => 'scatter',
		// 	'symbolSize' => 1,
		// 	'label' => [
		// 		'normal' => [
		// 			'show' => true,
		// 			'position' => 'top'
		// 		]
		// 	],
		// 	'data' => $data['total']
		// ];

		// $jsonObject['series'][] = $totalSeries;

		return $jsonObject;
	}

	public function dt_hijau_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jalur';});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jalur == 'HIJAU') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,4);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}
			if ($row->jalur == 'PRIORITAS' || $row->jalur == 'HIJAU' || $row->jalur == 'KUNING' || $row->jalur == 'MERAH') {
				$data['all'][] = $row->pre + $row->customs + $row->post;	
			}
		}

		$jsonObject = [
			'legend' => [
				'data' => $dwelling_time
			],
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
				'left' => 20,
				'right' => 15,
				'top' => 45,
				'bottom' => 35
			],
			'yAxis' => [
				[
					// 'name' => 'Dwelling Time (dalam hari)',
					// 'nameLocation' => 'center',
					// 'nameGap' => 30,
					'type' => 'value',
					'max' => round(max($data['all']) + 2)
					// 'boundaryGap' => [0, 0.1]
				]
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 25,
					'type' => 'category',
					'data' => $data['tgl']
				]
			],
			'color' => ['#0074D9','#FF4136','#2ECC40'],
			'series' => []
		];

		foreach ($dwelling_time as $dt) {
			$series = [
				'name' => $dt,
				'type' => 'bar',
				'stack' => 'dt',
				'data' => $data[$dt]
			];
			$jsonObject['series'][] = $series;
		}

		// $totalSeries = [
		// 	'type' => 'scatter',
		// 	'symbolSize' => 1,
		// 	'label' => [
		// 		'normal' => [
		// 			'show' => true,
		// 			'position' => 'top'
		// 		]
		// 	],
		// 	'data' => $data['total']
		// ];

		// $jsonObject['series'][] = $totalSeries;

		return $jsonObject;
	}

	public function dt_kuning_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jalur';});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jalur == 'KUNING') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}
			if ($row->jalur == 'PRIORITAS' || $row->jalur == 'HIJAU' || $row->jalur == 'KUNING' || $row->jalur == 'MERAH') {
				$data['all'][] = $row->pre + $row->customs + $row->post;	
			}
		}

		$jsonObject = [
			'legend' => [
				'data' => $dwelling_time
			],
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
				'left' => 20,
				'right' => 15,
				'top' => 45,
				'bottom' => 35
			],
			'yAxis' => [
				[
					// 'name' => 'Dwelling Time (dalam hari)',
					// 'nameLocation' => 'center',
					// 'nameGap' => 30,
					'type' => 'value',
					'max' => round(max($data['all']) + 2)
					// 'boundaryGap' => [0, 0.1]
				]
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 25,
					'type' => 'category',
					'data' => $data['tgl']
				]
			],
			'color' => ['#0074D9','#FF4136','#2ECC40'],
			'series' => []
		];

		foreach ($dwelling_time as $dt) {
			$series = [
				'name' => $dt,
				'type' => 'bar',
				'stack' => 'dt',
				'data' => $data[$dt]
			];
			$jsonObject['series'][] = $series;
		}

		// $totalSeries = [
		// 	'type' => 'scatter',
		// 	'symbolSize' => 1,
		// 	'label' => [
		// 		'normal' => [
		// 			'show' => true,
		// 			'position' => 'top'
		// 		]
		// 	],
		// 	'data' => $data['total']
		// ];

		// $jsonObject['series'][] = $totalSeries;

		return $jsonObject;
	}

	public function dt_merah_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jalur';});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jalur == 'MERAH') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}
			if ($row->jalur == 'PRIORITAS' || $row->jalur == 'HIJAU' || $row->jalur == 'KUNING' || $row->jalur == 'MERAH') {
				$data['all'][] = $row->pre + $row->customs + $row->post;	
			}
		}

		$jsonObject = [
			'legend' => [
				'data' => $dwelling_time
			],
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
				'left' => 20,
				'right' => 15,
				'top' => 45,
				'bottom' => 35
			],
			'yAxis' => [
				[
					// 'name' => 'Dwelling Time (dalam hari)',
					// 'nameLocation' => 'center',
					// 'nameGap' => 30,
					'type' => 'value',
					'max' => round(max($data['all']) + 2)
					// 'boundaryGap' => [0, 0.1]
				]
			],
			'xAxis' => [
				[
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 25,
					'type' => 'category',
					'data' => $data['tgl']
				]
			],
			'color' => ['#0074D9','#FF4136','#2ECC40'],
			'series' => []
		];

		foreach ($dwelling_time as $dt) {
			$series = [
				'name' => $dt,
				'type' => 'bar',
				'stack' => 'dt',
				'data' => $data[$dt]
			];
			$jsonObject['series'][] = $series;
		}

		// $totalSeries = [
		// 	'type' => 'scatter',
		// 	'symbolSize' => 1,
		// 	'label' => [
		// 		'normal' => [
		// 			'show' => true,
		// 			'position' => 'top'
		// 		]
		// 	],
		// 	'data' => $data['total']
		// ];

		// $jsonObject['series'][] = $totalSeries;

		return $jsonObject;
	}

}