<?php

class Terminal_model extends CI_Model {

	public function __construct()
	{
		$this->dok_penerimaan = array('CD', 'PIBK-SPP', 'PIBK-ST');
		$this->dok_jumlah = array('CD', 'SPP', 'ST');
	}

	public function PenerimaanPungutanPerBulan($date='')
	{
		$query = $this->db->select("
				b.year,
				b.month,
				SUM(a.nilai_pabean) nilai,
				SUM(a.brt_koli) berat,
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->where_in("a.dokumen", $this->dok_penerimaan)
			->group_by("b.year, b.month")
			->get();
		return $query->result_array();
	}

	public function PenerimaanPungutanTotal($date='')
	{
		$query = $this->db->select("
				SUM(a.nilai_pabean) nilai,
				SUM(a.brt_koli) berat,
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->where_in("a.dokumen", $this->dok_penerimaan)
			->get();
		$query_res = $query->result_array();
		return $query_res[0];
	}

	public function PenerimaanDokumenPerBulan($date='')
	{
		$query = $this->db->select("
				b.year,
				b.month,
				a.dokumen,
				SUM(a.nilai_pabean) nilai,
				SUM(a.brt_koli) berat,
				SUM(a.bm) bm,
				SUM(a.jml_dok) jml_dok
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->where_in("a.dokumen", $this->dok_penerimaan)
			->group_by("b.year, b.month, a.dokumen")
			->get();
		return $query->result_array();
	}

	public function PenerimaanDokumenTotal($date='')
	{
		$query = $this->db->select("
				a.dokumen,
				SUM(a.bm) bm
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->where_in("a.dokumen", $this->dok_penerimaan)
			->group_by("a.dokumen")
			->get();
		return $query->result_array();
	}

	public function JumlahDokumenTotal($date='')
	{
		$query = $this->db->select("
				a.dokumen,
				SUM(a.jml_dok) jml_dok
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->where_in("a.dokumen", $this->dok_jumlah)
			->group_by("a.dokumen")
			->get();
		return $query->result_array();
	}

	public function JumlahDokumenPerBulan($date='')
	{
		$query = $this->db->select("
				b.year,
				b.month,
				a.dokumen,
				SUM(a.jml_dok) jml_dok
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
			->where_in("a.dokumen", $this->dok_jumlah)
			->group_by("b.year, b.month, a.dokumen")
			->get();
		return $query->result_array();
	}

	public function PenerimaanPungutanPerBulanChart($date='')
	{
		$query_res = $this->PenerimaanPungutanPerBulan($date);
		$jns_penerimaan = array('bm', 'ppn', 'pph', 'ppnbm');

		foreach ($query_res as $row) {
			$tgl = $row['year'] . '-' . $row['month'];
			$tgl = date('M-Y',strtotime($tgl));
			$data['tgl'][] = $tgl;

			foreach ($jns_penerimaan as $key => $value) {
				$data[$value][] = round($row[$value]/1000000,2);
			}
		}

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				
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
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 35,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Penerimaan (jutaan Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => [

			]
		];

		foreach ($jns_penerimaan as $key => $value) {
			$series = [
				'name' => strtoupper($value),
				'type' => 'line',
				'smooth' => true,
				'data' => $data[$value]
			];
			$jsonObject['legend']['data'][] = strtoupper($value);

			$jsonObject['series'][] = $series;
		}

		return $jsonObject;
	}

	public function PenerimaanDokumenPerBulanChart($date='')
	{
		$query_res = $this->PenerimaanDokumenPerBulan($date);

		foreach ($query_res as $row) {
			$tgl = $row['year'] . '-' . $row['month'];
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$list_dok[] = $row['dokumen'];

			$data[$row['dokumen']][] = round($row['bm']/1000000,2);
		}

		$data['tgl'] = array_values(array_unique($list_tgl));
		$data['dok'] = array_unique($list_dok);

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				
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
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 35,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Bea Masuk (jutaan Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => [

			]
		];

		foreach ($data['dok'] as $key => $value) {
			$series = [
				'name' => strtoupper($value),
				'type' => 'line',
				'smooth' => true,
				'data' => $data[$value]
			];
			$jsonObject['legend']['data'][] = strtoupper($value);

			$jsonObject['series'][] = $series;
		}

		return $jsonObject;
	}

	public function PenerimaanPungutanNettoChart($date='')
	{
		$date_ly = [
			'start' => date("Y-m-d", strtotime($date['start'] . " -1 year")),
			'end' => date("Y-m-d", strtotime($date['end'] . " -1 year"))
		];
		$query_this_year = $this->PenerimaanPungutanPerBulan($date);
		$query_last_year = $this->PenerimaanPungutanPerBulan($date_ly);

		foreach ($query_last_year as $row) {
			$dateObj = DateTime::createFromFormat('!m', $row['month']);
			$data['last']['tgl']['month'][] = $dateObj->format('M');
			$data['last']['tgl']['year'] = $row['year'];

			$data['last']['value']['bm'][] = round($row['bm']/1000000,2);
			$data['last']['value']['nilai pabean'][] = round($row['nilai']/1000000,2);
			$data['last']['value']['berat'][] = round($row['berat']/1000,2);
		}
		foreach ($query_this_year as $row) {
			$data['curr']['tgl']['year'] = $row['year'];
			$data['curr']['value']['bm'][] = round($row['bm']/1000000,2);
			$data['curr']['value']['nilai pabean'][] = round($row['nilai']/1000000,2);
			$data['curr']['value']['berat'][] = round($row['berat']/1000,2);
		}

		$list_value = array('bm', 'nilai pabean', 'berat');
		foreach ($list_value as $key => $value) {
			$list[$value] = array_merge($data['last']['value'][$value], $data['curr']['value'][$value]);
			$max[$value] = max($list[$value]);
			$level[$value] = pow(10, strlen(round($max[$value]))-1);
			$first[$value] = (int)substr($max[$value], 0, 1)+1;
			if($first[$value] % 2 == 1) $first[$value]++;
			$max[$value] = $first[$value]*$level[$value];
		}

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				
			],
			'calculable' => false,
			'grid' => [
				'left' => 75,
				'top' => 45,
				'right' => 165,
				'bottom' => 45
			],
			'xAxis' => [
				[
					'type' => 'category',
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 35,
					'data' => $data['last']['tgl']['month']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Berat (ton)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'min' => 0,
					'max' => $max['berat'],
					'interval' => $max['berat']/4,
					'axisPointer' => [
						'show' => true
					]
				],
				[
					'type' => 'value',
					'name' => 'Bea Masuk (jutaan Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'min' => 0,
					'max' => $max['bm'],
					'interval' => $max['bm']/4,
					'axisPointer' => [
						'show' => true
					]
				],
				[
					'type' => 'value',
					'name' => 'Nilai Pabean (jutaan Rp)',
					'nameLocation' => 'center',
					'offset' => 85,
					'nameGap' => 55,
					'min' => 0,
					'max' => $max['nilai pabean'],
					'interval' => $max['nilai pabean']/4,
					'axisPointer' => [
						'show' => true
					]
				],
			],
			'color' => ['#2F89FC', '#2F89FC', '#52DE97', '#FF5733', '#FF5733', '#FFC30F'],
			'series' => [

			]
		];

		foreach ($data as $key => $value) {
			$year = $value['tgl']['year'];
			foreach ($value['value'] as $k => $v) {
				$series = [
					'name' => strtoupper($k) . ' ' . $year,
					'smooth' => true,
					'data' => $v
				];

				if ($k == 'berat') {
					$series['type'] = 'bar';
					$series['yAxisIndex'] = 0;
					$series['barGap'] = '0%';
				} elseif ($k == 'bm') {
					$series['type'] = 'line';
					$series['yAxisIndex'] = 1;
				} else {
					$series['type'] = 'line';
					$series['yAxisIndex'] = 2;
					$series['symbol'] = 'diamond';
					$series['symbolSize'] = 8;
					$series['lineStyle']['type'] = 'dotted';
				}

				$jsonObject['legend']['data'][] = strtoupper($k) . ' ' . $year;

				$jsonObject['series'][] = $series;
			}
			
		}

		return $jsonObject;
	}

	public function JumlahDokumenPerBulanChart($date='')
	{
		$query_res = $this->JumlahDokumenPerBulan($date);

		foreach ($query_res as $row) {
			$tgl = $row['year'] . '-' . $row['month'];
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$list_dok[] = $row['dokumen'];

			$data[$row['dokumen']][] = $row['jml_dok'];
		}

		$data['tgl'] = array_values(array_unique($list_tgl));
		$data['dok'] = array_unique($list_dok);

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				
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
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 35,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Jumlah Dokumen',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => [

			]
		];

		foreach ($data['dok'] as $key => $value) {
			$series = [
				'name' => strtoupper($value),
				'type' => 'line',
				'smooth' => true,
				'data' => $data[$value]
			];
			$jsonObject['legend']['data'][] = strtoupper($value);

			$jsonObject['series'][] = $series;
		}

		return $jsonObject;
	}

	public function PenerimaanPungutanNettoTable($date='')
	{
		$date_ly = [
			'start' => date("Y-m-d", strtotime($date['start'] . " -1 year")),
			'end' => date("Y-m-d", strtotime($date['end'] . " -1 year"))
		];
		$query_this_year = $this->PenerimaanPungutanPerBulan($date);
		$query_last_year = $this->PenerimaanPungutanPerBulan($date_ly);

		$data = [];
		$nilai_curr_kum = 0;
		$berat_curr_kum = 0;
		$bm_curr_kum = 0;
		$nilai_last_kum = 0;
		$berat_last_kum = 0;
		$bm_last_kum = 0;
		for ($i=0; $i < count($query_this_year); $i++) { 
			$dateObj = DateTime::createFromFormat('!m', $query_this_year[$i]['month']);
			$data['value'][$i]['bulan'] = $dateObj->format('M');

			$nilai = $query_this_year[$i]['nilai']/1000000;
			$nilai_curr_kum += $nilai;
			
			$berat = $query_this_year[$i]['berat']/1000;
			$berat_curr_kum += $berat;

			$bm = $query_this_year[$i]['bm']/1000000;
			$bm_curr_kum += $bm;

			$data['value'][$i]['order'] = $i;
			$data['value'][$i]['nilai_curr'] = number_format($nilai, 2, ',', '.');
			$data['value'][$i]['nilai_curr_kum'] = number_format($nilai_curr_kum, 2, ',', '.');
			$data['value'][$i]['berat_curr'] = number_format($berat, 2, ',', '.');
			$data['value'][$i]['berat_curr_kum'] = number_format($berat_curr_kum, 2, ',', '.');
			$data['value'][$i]['bm_curr'] = number_format($bm, 2, ',', '.');
			$data['value'][$i]['bm_curr_kum'] = number_format($bm_curr_kum, 2, ',', '.');
			$data['year']['curr'] = $query_this_year[$i]['year'];
		}
		for ($i=0; $i < count($query_last_year); $i++) { 
			$dateObj = DateTime::createFromFormat('!m', $query_last_year[$i]['month']);
			$data['value'][$i]['bulan'] = $dateObj->format('M');

			$nilai = $query_last_year[$i]['nilai']/1000000;
			$nilai_last_kum += $nilai;
			
			$berat = $query_last_year[$i]['berat']/1000;
			$berat_last_kum += $berat;

			$bm = $query_last_year[$i]['bm']/1000000;
			$bm_last_kum += $bm;

			$data['value'][$i]['order'] = $i;
			$data['value'][$i]['nilai_last'] = number_format($nilai, 2, ',', '.');
			$data['value'][$i]['nilai_last_kum'] = number_format($nilai_last_kum, 2, ',', '.');
			$data['value'][$i]['berat_last'] = number_format($berat, 2, ',', '.');
			$data['value'][$i]['berat_last_kum'] = number_format($berat_last_kum, 2, ',', '.');
			$data['value'][$i]['bm_last'] = number_format($bm, 2, ',', '.');
			$data['value'][$i]['bm_last_kum'] = number_format($bm_last_kum, 2, ',', '.');
			$data['year']['last'] = $query_last_year[$i]['year'];
		}

		return $data;
	}

	public function SummaryKategoriHarian($date='')
	{
		$query = $this->db->query("
			SELECT
				a.tgl,
				a.kategori,
				SUM(a.jml_dok) jml_dok,
				SUM(a.nilai_pabean) nilai,
				SUM(a.bm) bm
			FROM 
				db_semesta.fact_term_kategori a
			INNER JOIN (
				SELECT
					a.kategori
				FROM
					db_semesta.fact_term_kategori a
				WHERE
					a.subkategori IS null
				GROUP BY
					1
				ORDER BY
					SUM(a.jml_dok) desc
				LIMIT 10
			) filter
			ON
				filter.kategori = a.kategori
			WHERE
				a.subkategori IS NULL and
				a.tgl BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "'
			GROUP BY
				a.tgl,
				a.kategori
		");
		return $query->result_array();
	}

	public function SummaryKategoriBulanan()
	{
		$query = $this->db->query("
			SELECT
				year(a.tgl) year,
				month(a.tgl) month,
				a.kategori,
				SUM(a.jml_dok) jml_dok,
				SUM(a.nilai_pabean) nilai,
				SUM(a.bm) bm
			FROM 
				db_semesta.fact_term_kategori a
			INNER JOIN (
				SELECT
					a.kategori
				FROM
					db_semesta.fact_term_kategori a
				WHERE
					a.subkategori IS null
				GROUP BY
					1
				ORDER BY
					SUM(a.jml_dok) desc
				LIMIT 10
			) filter
			ON
				filter.kategori = a.kategori
			WHERE
				a.subkategori IS NULL
			GROUP BY
				1,2,3
		");
		return $query->result_array();
	}

	public function SummaryKategoriHarianChart()
	{
		$query_res = $this->SummaryKategoriHarian();

		$date_start_num = strtotime($query_res[0]['tgl']);
		$date_start = datetime::createfromformat('Y-m-d', $query_res[0]['tgl']);
		$date_end = datetime::createfromformat('Y-m-d', end($query_res)['tgl']);
		$data_int = date_diff($date_start, $date_end);
		$data_len = $data_int->format('%a');
		$list_kategori = [];

		foreach ($query_res as $key => $value) {
			$list_kategori[] = $value['kategori'];
		}
		$unique_kategori = array_unique($list_kategori);
		$data['kategori'] = array_values($unique_kategori);

		foreach ($data['kategori'] as $key => $value) {
			$data[$value]['bm'] = array_fill(0, $data_len, '0');
			$data[$value]['nilai'] = array_fill(0, $data_len, 0);
		}

		for ($i=0; $i < count($query_res); $i++) { 
			$date_now = datetime::createfromformat('Y-m-d', $query_res[$i]['tgl']);
			$kategori = $query_res[$i]['kategori'];
			$bm = $query_res[$i]['bm'];
			$nilai = $query_res[$i]['nilai'];
			$dok = $query_res[$i]['jml_dok'];

			$interval = date_diff($date_start, $date_now);
			$day = $interval->format('%a');
			$data[$kategori]['dok'][$day] = $dok;
			$data[$kategori]['bm'][$day] = $bm;
			$data[$kategori]['nilai'][$day] = $nilai;
		}

		for ($i=0; $i <= $data_len; $i++) { 
			$data['tgl'][] = date("Y-m-d", $date_start_num + ($i*86400));
		}

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $data['kategori']
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
					'name' => 'Tanggal',
					'nameLocation' => 'center',
					'nameGap' => 35,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'BM',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			// 'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => [

			]
		];

		foreach ($data['kategori'] as $key => $value) {
			$series = [
				'name' => $value,
				'type' => 'line',
				// 'smooth' => true,
				'data' => $data[$value]['bm']
			];

			$jsonObject['series'][] = $series;
		}

		return $jsonObject;
	}

	public function SummaryKategoriBulananChart()
	{
		$query_res = $this->SummaryKategoriBulanan();
		$date_start = date('M-Y',strtotime($query_res[0]['year'] . '-' . $query_res[0]['month']));
		$date_start = datetime::createfromformat('M-Y',$date_start);
		$date_end = date('M-Y',strtotime(end($query_res)['year'] . '-' . end($query_res)['month']));
		$date_end = datetime::createfromformat('M-Y',$date_end);
		$interval = date_diff($date_start, $date_end);
		$year = $interval->format('%y');
		$month = $interval->format('%m');
		$data_len = 12*$year + $month;

		foreach ($query_res as $key => $value) {
			$list_kategori[] = $value['kategori'];
		}
		$unique_kategori = array_unique($list_kategori);
		$data['kategori'] = array_values($unique_kategori);

		foreach ($data['kategori'] as $key => $value) {
			$data['value'][$value]['bm'] = array_fill(0, $data_len, '0');
		}
		foreach ($query_res as $key => $value) {
			$tgl = $value['year'] . '-' . $value['month'];
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$date_now = datetime::createfromformat('M-Y',$tgl);

			$interval = date_diff($date_start, $date_now);
			$year = $interval->format('%y');
			$month = $interval->format('%m');
			$total_month = 12*$year + $month;

			$data['value'][$value['kategori']]['bm'][$total_month] = (int)$value['jml_dok'];
		}
		
		$data['tgl'] = array_values(array_unique($list_tgl));

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $data['kategori']
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
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 35,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Jumlah BM (jutaan Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			// 'color' => ['#FF4136', '#2ECC40', '#0074D9', '#FF851B'],
			'series' => [

			]
		];

		foreach ($data['kategori'] as $key => $value) {
			$series = [
				'name' => $value,
				'type' => 'line',
				'smooth' => true,
				'data' => $data['value'][$value]['bm']
			];

			$jsonObject['series'][] = $series;
		}

		return $data;
	}

}