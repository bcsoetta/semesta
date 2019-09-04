<?php

class Barkir_dwelling_time_model extends CI_Model {

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

	public function dt_total_last()
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT
				'CN/PIBK' jenis_aju,
				'TOTAL' jalur,
				ROUND(pre,2) pre, 
				ROUND(customs, 2) customs, 
				ROUND(post, 2) post,
				ROUND(pre + customs + post, 2) total
			from avg_barkir_dt a
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
				jenis_aju,
				sistem, 
				jalur, 
				ROUND(pre,2) pre, 
				ROUND(customs, 2) customs, 
				ROUND(post, 2) post,
				ROUND(pre + customs + post, 2) total
			from avg_barkir_dt_jlr a
			where a.tahun = year(now() - interval 1 month)
			and a.bulan = month(now() - interval 1 month)
		");

		return $query->result();
	}

	public function dt_total($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		// $query = $this->db->query("
		// 	SELECT tahun as year, bulan as month, pre, customs, post 
		// 	from avg_barkir_dt
		// 	where CONCAT(tahun, LPAD(bulan,2,0)) 
		// 	between EXTRACT(YEAR_MONTH FROM '" . $date['start'] . "') 
		// 	and EXTRACT(YEAR_MONTH FROM '" . $date['end'] . "')
		// 	order by year, month
		// ");

		$query = $this->db->select("
				b.year,
				b.month, 
				sum(a.sum_pre)/sum(a.count_pre) pre, 
				sum(a.sum_customs)/sum(a.count_customs) customs, 
				sum(a.sum_post)/sum(a.count_post) post
			")
			->from("db_semesta.fact_barkir_dt a")
			->join("db_semesta.dim_date b", "a.tgl_house_blawb = b.id")
			->where("b.date between '" . $date['start'] . "' and '" . $date['end'] . "'")
			->group_by("year, month")
			->get();

		return $query->result();
	}

	public function dt_jalur($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		// $query = $this->db->query("
		// 	SELECT 
		// 		tahun as year, 
		// 		bulan as month, 
		// 		b.jenis jenis_aju, 
		// 		c.ur_jalur jalur, 
		// 		sistem, 
		// 		pre, customs, post 
		// 	from avg_barkir_dt_jlr a
		// 	inner join dim_barkir_jenis_aju b on a.jenis_aju = b.id
		// 	inner join dim_barkir_jalur c on a.jalur = c.id
		// 	where CONCAT(tahun, LPAD(bulan,2,0)) 
		// 	between EXTRACT(YEAR_MONTH FROM '" . $date['start'] . "') 
		// 	and EXTRACT(YEAR_MONTH FROM '" . $date['end'] . "')
		// 	order by year, month, jenis_aju, jalur, sistem
		// ");

		$query = $this->db->select("
				b.year,
				b.month,
				c.jenis jenis_aju,
				d.ur_jalur jalur,
				sistem,
				sum(a.sum_pre)/sum(a.count_pre) pre, 
				sum(a.sum_customs)/sum(a.count_customs) customs, 
				sum(a.sum_post)/sum(a.count_post) post
			")
			->from("db_semesta.fact_barkir_dt a")
			->join("db_semesta.dim_date b", "a.tgl_house_blawb = b.id")
			->join("db_semesta.dim_barkir_jenis_aju c", "a.jenis_aju = c.id")
			->join("db_semesta.dim_barkir_jalur d", "a.jalur = d.id")
			->where("b.date between '" . $date['start'] . "' and '" . $date['end'] . "'")
			->group_by("year, month, jenis_aju, jalur, sistem")
			->get();

		return $query->result();
	}

	public function dt_last_table($query_total, $query_jalur)
	{
		$data = [];
		$data['TOTAL'] = $query_total[0];
		foreach ($query_jalur as $key => $value) {
			$data[$value->jenis_aju . '_' . $value->sistem . '_' . $value->jalur] = $value;
		}

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

	public function dt_cn_re_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'CN' && $row->sistem == 'RE' && $row->jalur== 'Hijau') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'CN') {
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

	public function dt_cn_hijau_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'CN' && $row->sistem == 'NON-RE' && $row->jalur== 'Hijau') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'CN') {
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

	public function dt_cn_merah_periksa_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'CN' && $row->sistem == 'NON-RE' && $row->jalur== 'Merah Periksa') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'CN') {
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

	public function dt_cn_merah_nonperiksa_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'CN' && $row->sistem == 'NON-RE' && $row->jalur== 'Merah Tidak Periksa') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'CN') {
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

	public function dt_pibk_hijau_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'PIBK' && $row->jalur== 'Hijau') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'PIBK') {
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

	public function dt_pibk_merah_periksa_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'PIBK' && $row->jalur== 'Merah Periksa') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'PIBK') {
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

	public function dt_pibk_merah_nonperiksa_bar($query_res)
	{
		$data = [];

		foreach ($query_res[0] as $key => $value) {
			$dwelling_time[] = $key;
			$data[$key] = [];
		}

		$dwelling_time = array_filter($dwelling_time,function($a) {return $a <> 'year' && $a <> 'month' && $a <> 'jenis_aju' && $a <> 'jalur' && $a <> 'sistem' ;});
		$dwelling_time = array_values($dwelling_time);

		foreach ($query_res as $row) {
			if ($row->jenis_aju == 'PIBK' && $row->jalur== 'Merah Tidak Periksa') {
				$tgl = $row->year . '-' . $row->month;
				$tgl = date('M-Y',strtotime($tgl));
				$data['tgl'][] = $tgl;

				$data['pre'][] = round($row->pre,2);
				$data['customs'][] = round($row->customs,2);
				$data['post'][] = round($row->post,2);
				$data['total'][] = round($row->pre + $row->customs + $row->post,2);
			}

			if ($row->jenis_aju == 'PIBK') {
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
}