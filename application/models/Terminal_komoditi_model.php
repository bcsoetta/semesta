<?php

class Terminal_komoditi_model extends CI_Model {

	public function SummaryKategori($date='',$dok='')
	{
		if ($dok == '') {
			$dok = array('spp','st','cd');
		}
		$this->db->select("
			a.kategori,
			SUM(a.jml_dok) jml_dok,
			SUM(a.berat) berat,
			SUM(a.nilai_pabean) nilai_pabean,
			SUM(a.bm) bm,
			SUM(a.ppn) ppn,
			SUM(a.pph) pph,
			SUM(a.ppnbm) ppnbm
		");
		$this->db->from("db_semesta.fact_term_kategori a");
		$this->db->where("a.tgl >=", $date['start']);
		$this->db->where("a.tgl <=", $date['end']);
		$this->db->where("a.kategori <>", "");
		$this->db->where("a.subkategori", "");
		$this->db->where_in("a.dokumen", $dok);
		$this->db->group_by("a.kategori");
		$this->db->order_by(2, 'desc');
		$this->db->limit(100);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function SummaryKategoriBulanan($date)
	{
		$query = $this->db->query("
			SELECT
				year(a.tgl) year,
				month(a.tgl) month,
				a.kategori,
				SUM(a.berat) berat,
				SUM(a.jml_dok) jml_dok,
				SUM(a.nilai_pabean) nilai_pabean,
				SUM(a.bm) bm
			FROM
				db_semesta.fact_term_kategori a
			INNER JOIN (
				SELECT
					a.kategori
				FROM
					db_semesta.fact_term_kategori a
				WHERE
					a.tgl BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "' and
					a.subkategori = ''
				GROUP BY 
					a.kategori
				ORDER BY
					SUM(a.jml_dok) desc
				LIMIT
					10
			) filter
			ON
				filter.kategori = a.kategori
			WHERE
				a.tgl BETWEEN '" . $date['start'] . "' AND '" . $date['end'] . "' and
				a.subkategori = ''
			GROUP BY
				1,2,3
		");
		return $query->result_array();
	}

	public function DetailKategoriBulanan($date='',$kategori='')
	{
		$query = $this->db->select("
				year(a.tgl) year,
				month(a.tgl) month,
				a.kategori,
				SUM(a.berat) berat,
				SUM(a.jml_dok) jml_dok,
				SUM(a.nilai_pabean) nilai_pabean,
				SUM(a.bm) bm
			")
			->from("db_semesta.fact_term_kategori a")
			->where("a.tgl >=", $date['start'])
			->where("a.tgl <=", $date['end'])
			->where("a.kategori", $kategori)
			->where("a.subkategori", "")
			->group_by("1,2,3")
			->get();
		return $query->result_array();
	}

	public function DetailKategoriTransaksi($date='',$kategori='')
	{
		$query = $this->db->select("
				a.dok,
				a.terminal,
				a.no_cd_pibk,
				a.tgl,
				a.urbar
			")
			->from("test.fact_trans_barang a")
			->join("test.fact_dok_kategori_barang b", "
					a.dok = b.dokumen and
					a.terminal = b.terminal and
					a.tahun = b.tahun and
					a.no_cd_pibk = b.`no`
				")
			->where("a.tgl >=", $date['start'])
			->where("a.tgl <=", $date['end'])
			->where("b.category", $kategori)
			->where("b.subcategory", "")
			->get();
		return $query->result_array();
	}

	public function SummaryKategoriTable($date='',$dok='')
	{
		$date_ly = [
			'start' => date("Y-m-d", strtotime($date['start'] . " -1 year")),
			'end' => date("Y-m-d", strtotime($date['end'] . " -1 year"))
		];
		$query_this_year = $this->SummaryKategori($date,$dok);
		$query_last_year = $this->SummaryKategori($date_ly,$dok);
		// $data = $query_this_year;
		$data = [];
		$list_kategori = [];
		foreach ($query_this_year as $key => $value) {
			$list_kategori[] = $value['kategori'];
			// $data[] = $value;
			$jml_dok = $value['jml_dok'];
			$berat = $value['berat'];
			$nilai_pabean = $value['nilai_pabean']/1000000;
			$bm = $value['bm']/1000000;

			$data['value'][$key]['kategori'] = $value['kategori'];
			$data['value'][$key]['jml_dok'] = $jml_dok;
			$data['value'][$key]['berat'] = $berat;
			$data['value'][$key]['nilai_pabean'] = $nilai_pabean;
			$data['value'][$key]['bm'] = $bm;
			$data['value'][$key]['jml_dok_last'] = 0;
			$data['value'][$key]['berat_last'] = 0;
			$data['value'][$key]['nilai_pabean_last'] = 0;
			$data['value'][$key]['bm_last'] = 0;
		}
		foreach ($query_last_year as $key => $value) {
			$jml_dok = $value['jml_dok'];
			$berat = $value['berat'];
			$nilai_pabean = $value['nilai_pabean']/1000000;
			$bm = $value['bm']/1000000;

			if (in_array($value['kategori'], $list_kategori)) {
				$key_kategori = array_search($value['kategori'], $list_kategori);
				$data['value'][$key_kategori]['jml_dok_last'] = $jml_dok;
				$data['value'][$key_kategori]['berat_last'] = $berat;
				$data['value'][$key_kategori]['nilai_pabean_last'] = $nilai_pabean;
				$data['value'][$key_kategori]['bm_last'] = $bm;
			} else {
				$data['value'][] = [
					'kategori' => $value['kategori'],
					'jml_dok' => 0,
					'berat' => 0,
					'nilai_pabean' => 0,
					'bm' => 0,
					'jml_dok_last' => $jml_dok,
					'berat_last' => $berat,
					'nilai_pabean_last' => $nilai_pabean,
					'bm_last' => $bm
				];
			}
		}
		$data['year'] = [
			'this' => date('Y', strtotime($date['start'])),
			'last' => date('Y', strtotime($date['start'] . " -1 year"))
		];
		return $data;
	}

	public function SummaryKategoriBulananChart($date='', $jenis='')
	{
		$query_res = $this->SummaryKategoriBulanan($date);
		$date_start = date('M-Y',strtotime($query_res[0]['year'] . '-' . $query_res[0]['month']));
		$date_start = datetime::createfromformat('M-Y',$date_start);
		$date_end = date('M-Y',strtotime(end($query_res)['year'] . '-' . end($query_res)['month']));
		$date_end = datetime::createfromformat('M-Y',$date_end);
		$interval = date_diff($date_start, $date_end);
		$year = $interval->format('%y');
		$month = $interval->format('%m');
		$data_len = 12*$year + $month;

		switch ($jenis) {
			case 'bm':
				$division = 1000000;
				$ylabel = 'Jumlah BM (jutaan Rp)';
				break;

			case 'nilai_pabean':
				$division = 1000000;
				$ylabel = 'Jumlah Nilai Pabean (jutaan Rp)';
				break;

			case 'jml_dok':
				$division = 1;
				$ylabel = 'Jumlah Dokumen';
				break;

			case 'berat':
				$division = 1000;
				$ylabel = 'Jumlah Berat (ton)';
				break;
			
			default:
				$division = 1;
				$ylabel = 'undefined';
				break;
		}

		foreach ($query_res as $key => $value) {
			$list_kategori[] = $value['kategori'];
		}
		$unique_kategori = array_unique($list_kategori);
		$data['kategori'] = array_values($unique_kategori);

		foreach ($data['kategori'] as $key => $value) {
			$data['value'][$value] = array_fill(0, $data_len, '0');
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

			$data['value'][$value['kategori']][$total_month] = $value[$jenis]/$division;
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
					'name' => $ylabel,
					'nameLocation' => 'center',
					'nameGap' => 55,
					'splitNumber' => 4
				]
			],
			'color' => ['#e6194B', '#f58231', '#ffe119', '#469990', '#3cb44b', '#42d4f4', '#4363d8', '#911eb4', '#f032e6', '#a9a9a9'],
			'series' => [

			]
		];

		foreach ($data['kategori'] as $key => $value) {
			$series = [
				'name' => $value,
				'type' => 'line',
				'smooth' => true,
				'data' => $data['value'][$value]
			];

			$jsonObject['series'][] = $series;
		}

		return $jsonObject;
	}

	public function DetailKategoriBulananChart($date='',$kategori='')
	{

		$date_ly = [
			'start' => date("Y-m-d", strtotime($date['start'] . " -1 year")),
			'end' => date("Y-m-d", strtotime($date['end'] . " -1 year"))
		];
		$query_this_year = $this->DetailKategoriBulanan($date, $kategori);
		$query_last_year = $this->DetailKategoriBulanan($date_ly, $kategori);

		foreach ($query_last_year as $row) {
			$dateObj = DateTime::createFromFormat('!m', $row['month']);
			$data['last']['tgl']['month'][] = $dateObj->format('M');
			$data['last']['tgl']['year'] = $row['year'];

			$data['last']['value']['bm'][] = round($row['bm']/1000000,2);
			$data['last']['value']['nilai pabean'][] = round($row['nilai_pabean']/1000000,2);
			$data['last']['value']['berat'][] = round($row['berat'],2);
		}
		foreach ($query_this_year as $row) {
			$data['curr']['tgl']['year'] = $row['year'];
			$data['curr']['value']['bm'][] = round($row['bm']/1000000,2);
			$data['curr']['value']['nilai pabean'][] = round($row['nilai_pabean']/1000000,2);
			$data['curr']['value']['berat'][] = round($row['berat'],2);
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
					'name' => 'Berat (kg)',
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

}