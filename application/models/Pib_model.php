<?php

class Pib_model extends CI_Model {

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

	public function jalur($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT dim.year, dim.month, dim.jalur, sum(f.jumlah_dok) dok
			from fact_pib f
			right join(
				select a.id id_date, a.year, a.month, b.id id_jalur, b.jalur 
					from dim_date a
					left join dim_pib_jalur b
					on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
				union
				select a.id id_date, a.year, a.month, b.id id_jalur, b.jalur 
					from dim_date a
					right join dim_pib_jalur b
					on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			) dim
			on dim.id_date = f.tgl_pib
			and dim.id_jalur = f.jlr
			group by dim.year, dim.month, dim.jalur
			order by dim.year, dim.month, dim.id_jalur
		");

		return $query->result();
	}

	public function jalur_total($date)
	{

		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT b.jalur, sum(a.jumlah_dok) dok
			from fact_pib a
			inner join dim_pib_jalur b ON a.jlr = b.id
			inner join dim_date c on a.tgl_pib = c.id
			where c.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by 1
		");

		return $query->result();
	}

	public function nilai_tonase($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT 
				b.year, 
				b.month, 
				sum(a.total_netto) netto, 
				sum(a.total_nilai_pabean) devisa, 
				sum(a.total_bm) bm
			from fact_pib a
			inner join dim_date b
			on a.tgl_pib = b.id
			and b.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by b.year, b.month
		");

		return $query->result();
	}

	public function importir($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT b.nama, sum(a.jumlah_dok) dok
			from fact_pib a
			inner join dim_pib_importir b	on a.wp_imp = b.id
			inner join dim_date c	on a.tgl_pib = c.id
			where c.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by a.wp_imp
			order by 2 desc
			limit 10
		");

		return $query->result();
	}

	public function negara_pemasok($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT b.kd_negara kode, b.nm_echarts name, sum(a.jumlah_dok) value
			from fact_pib a
			inner join dim_negara b on a.negara_pemasok = b.id
			inner join dim_date c on a.tgl_pib = c.id
			where c.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			and b.nm_echarts is not null
			group by b.nm_echarts
			order by value desc
		");

		return $query->result();
	}

	public function jalur_line($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {
			$jalur = $row->jalur;
			$list_jalur[] = $jalur;

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['jml'][$jalur][] = (int)$row->dok;
		}
		$data['jalur'] = array_unique($list_jalur);
		$data['tgl'] = array_values(array_unique($list_tgl));


		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $data['jalur']
			],
			'calculable' => false,
			'grid' => [
				'x' => '75',
				'y' => '45'
			],
			'xAxis' => [
				[
					'type' => 'category',
					'boundaryGap' => false,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'axisLabel' => [
						'width' => '100px',
						[
							'rich' => [
								'width' => '100%'
							]
						]
					]
				]
			],
			'color' => ['#78909c', '#ce93d8', '#8e24aa', '#a5d6a7', '#4caf50', '#2e7d32', '#ffeb3b', '#ef9a9a', '#f44336', '#c62828'],
			'series' => [

			]
		];

		foreach ($data['jalur'] as $jalur) {
			$series = [
				'name' => $jalur,
				'type' => 'line',
				'smooth' => true,
				'data' => $data['jml'][$jalur]	
			];

			$jsonObject['series'][] = $series;

		}

		return $jsonObject;
	}

	public function jalur_total_table($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {
			$data[$row->jalur] = $row->dok;
		}

		return $data;
	}

	public function nilai_tonase_line($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['jml']['netto'][] = round((float)$row->netto/1000,2);
			$data['jml']['devisa'][] = round((float)$row->devisa/1000000000,2);
			$data['jml']['bm'][] = round((float)$row->bm/1000000000,2);
		}
		$data['legend'] = array('netto', 'devisa', 'bm');
		$data['tgl'] = array_values(array_unique($list_tgl));


		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $data['legend']
			],
			'calculable' => false,
			'grid' => [
				'top' => 25,
				'right' => 70,
				'bottom' => 40,
				'left' => 65
			],
			'xAxis' => [
				[
					'type' => 'category',
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 25,
					'boundaryGap' => false,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Netto (ton)',
					'nameLocation' => 'center',
					'nameGap' => 50
				],
				[
					'type' => 'value',
					'name' => 'Devisa, BM (milyar Rp)',
					'nameLocation' => 'center',
					'nameGap' => 55
				]
			],
			'color' => ['#228B22', '#DC143C', '#4682B4'],
			'series' => [

			]
		];

		foreach ($data['legend'] as $legend) {
			$series = [
				'name' => $legend,
				'type' => 'line',
				'smooth' => true,
				'data' => $data['jml'][$legend]	
			];

			$jsonObject['series'][] = $series;

		}

		$jsonObject['series'][1]['yAxisIndex'] = 1;
		$jsonObject['series'][2]['yAxisIndex'] = 1;

		return $jsonObject;
	}

	public function rata_nilai_tonase_line($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['devisa'][] = round(((float)$row->devisa/1000000)/((float)$row->netto/1000),2);
		}
		$data['tgl'] = array_values(array_unique($list_tgl));


		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'calculable' => false,
			'grid' => [
				'top' => 25,
				'right' => 30,
				'bottom' => 40,
				'left' => 65
			],
			'xAxis' => [
				[
					'type' => 'category',
					'name' => 'Bulan',
					'nameLocation' => 'center',
					'nameGap' => 25,
					'boundaryGap' => false,
					'data' => $data['tgl']
				]
			],
			'yAxis' => [
				[
					'type' => 'value',
					'name' => 'Devisa/Netto (juta Rp/ton)',
					'nameLocation' => 'center',
					'nameGap' => 50
				]
			],
			'series' => [
				'name' => 'rata_devisa',
				'type' => 'line',
				'smooth' => true,
				'data' => $data['devisa']
			]
		];

		return $jsonObject;
	}

	public function importir_bar($query_res)
	{
		$query_res = array_reverse($query_res);
		$data_imp = [];
		$data_jml = [];

		$rep_pattern = '^([Pp][Tt]\W\s|[Pp][Tt]\W|[Cc][Vv]\W\s|[Cc][Vv]\W)^';

		foreach ($query_res as $row) {
			$imp = preg_replace($rep_pattern, '', $row->nama);
			$jml = $row->dok;

			if (strlen($imp) > 15) {
				$imp = substr($imp, 0, 15);
				$data_imp[] = $imp.'...';
			} else {
				$data_imp[] = $imp;
			}
			
			$data_jml[] = $jml;
		}

		$jsonObject = [
			'calculable' => false,
			'grid' => [
				'x' => 150,
				'top' => 0,
				'bottom' => 45
			],
			'xAxis' => [
				[
					'name' => 'Jumlah',
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
					'data' => $data_jml
				]
			]
		];

		return $jsonObject;
	}

	public function negara_pemasok_map($query_res)
	{
		$value = [];

		foreach ($query_res as $row) {
			unset($row->kode);
			$value[] = $row->value;
		}

		$max_value = max($value);

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'item'
			],
			'visualMap' => [
				'min' => 0,
				'max' => (int)(1000 * ceil($max_value / 1000)),
				'text' => ['High', 'Low'],
				'realtime' => false,
				'calculable' => true,
				'inRange' => [
					'color' => ['lightskyblue', 'yellow', 'orangered']
				]
			],
			'series' => [
				[
					'type' => 'map',
					'mapType' => 'world',
					'roam' => true,
					'itemStyle' => [
						'label' => [
							'show' => true
						]
					],
					'data' => $query_res
				]
			]
		];

		return $jsonObject;
	}

	public function negara_pemasok_bar($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {
			$data['negara'][] = $row->kode;
			$data['dok'][] = $row->value;
		}

		$max_value = max($data['dok']);

		$jsonObject = [
			'title' => [
				'text' => '10 Negara pemasok terbesar',
				'textStyle' => [
					'color' => '#373a3c',
					'fontSize' => 13
				],
				'padding' => [50,10,5,10]
			],
			'tooltip' => [
				'trigger' => 'item'
			],
			'grid' => [
				'left' => '15%',
				'top' => '20%',
				'bottom' => '30%'
			],
			'xAxis' => [
				'type' => 'value',
				'show' => false
			],
			'yAxis' => [
				'type' => 'category',
				'axisLine' => [
					'show' => false
				],
				'axisTick' => [
					'show' => false
				],
				'data' => array_reverse(array_slice($data['negara'], 0, 9))
			],
			'visualMap' => [
				'show' => false,
				'min' => 0,
				'max' => (int)(1000 * ceil($max_value / 1000)),
				'text' => ['High', 'Low'],
				'dimension' => 0,
				'realtime' => false,
				'calculable' => true,
				'inRange' => [
					'color' => ['lightskyblue', 'yellow', 'orangered']
				]
			],
			'series' => [
				[
					'type' => 'bar',
					'barWidth' => 5,
					'barCategoryGap' => '10%',
					'label' => [
						'normal' => [
							'show' => true,
							'position' => 'right'
						]
					],
					'data' => array_reverse(array_slice($data['dok'], 0, 9))
				]
			]
		];

		return $jsonObject;
	}
}