<?php

class Barkir_model extends CI_Model {

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

	public function jalur_total($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT 
				c.jenis,
				case
					when a.pdtt = 1
					then 1
					else 0
				end sistem,
				a.jalur,
				sum(a.jumlah_dok) dok
			from db_semesta.fact_barkir a
			inner join dim_date b on a.tgl_house_blawb = b.id
			inner join dim_barkir_jenis_aju c on a.jenis_aju = c.id
			where b.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by jenis, sistem, jalur
		");

		return $query->result();
	}

	public function jalur($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT 
				dim.year,
				dim.month,
				dim.jenis,
				case
					when dim.jalur = 1 then 'MT'
					when dim.jalur = 2 then 'MP'
					when dim.jalur = 3 and dim.sistem = 0 then 'H'
					else 'S'
				end jalur,
				sum(e.jumlah_dok) dok
			from db_semesta.fact_barkir e
			right join (
				select a.id tgl, a.year, a.month, b.id id_jenis, b.jenis, c.id jalur, sistem.id sistem
					from dim_date a
					left join dim_barkir_jenis_aju b	on 1=1
					left join dim_barkir_jalur c on 1=1
					left join (
						select 
							case
								when d.id = 1
								then 1
								else 0
							end id
						from dim_pegawai d
						where grup = 1
					) sistem on b.jenis = 'CN' and c.id = 3
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
				union
				select a.id tgl, a.year, a.month, b.id id_jenis, b.jenis, c.id jalur, sistem.id sistem
					from dim_date a
					right join dim_barkir_jenis_aju b on 1=1
					right join dim_barkir_jalur c	on 1=1
					right join (
						select 
							case
								when d.id = 1
								then 1
								else 0
							end id
						from dim_pegawai d
						where grup = 1
					) sistem on b.jenis = 'CN' and c.id = 3
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			) dim
			on e.tgl_house_blawb = dim.tgl
			and e.jenis_aju = dim.id_jenis
			and e.jalur = dim.jalur
			and 
				case
					when e.pdtt = 1
					then 1
					else 0
				end = dim.sistem
			group by year, month, jenis, jalur
		");

		return $query->result();
	}

	public function nilai_tonase($date)
	{
		$query = $this->db->select("
				b.year,
				b.month,
				SUM(a.total_netto_aju) netto,
				SUM(a.total_nilai_pabean_aju) nilai,
				SUM(a.total_bm_penetapan) bm
			")
			->from("db_semesta.fact_barkir a")
			->join("db_semesta.dim_date b", "a.tgl_house_blawb = b.id")
			->where("b.date between '" . $date['start'] . "' and '" . $date['end'] . "'")
			->group_by("b.year, b.month")
			->get();

		return $query->result();
	}

	public function pjt($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT
				b.nama,
				sum(a.jumlah_dok) dok
			from fact_barkir a
			inner join dim_pengguna_jasa b on a.pjt = b.id
			inner join dim_date c on a.tgl_house_blawb = c.id
			where c.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			group by a.pjt
			order by dok desc
			limit 10
		");

		return $query->result();
	}

	public function negara_pengirim($date)
	{
		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT
				b.kd_negara kode,
				b.nm_echarts name,
				sum(a.jumlah_dok) value
			from fact_barkir a
			inner join dim_negara b on a.negara_pengirim = b.id
			inner join dim_date c on a.tgl_house_blawb = c.id
			where c.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			and b.nm_echarts is not null
			group by b.nm_echarts
			order by value desc
		");

		return $query->result();
	}

	public function jalur_total_table($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {
			$data[$row->jenis . '-' . $row->sistem . $row->jalur] = $row->dok;
		}

		return $data;
	}

	public function jalur_line($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {
			$jalur = $row->jenis . '-' . $row->jalur;
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

	public function nilai_tonase_line($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['jml']['netto'][] = round((float)$row->netto/1000,2);
			$data['jml']['nilai'][] = round((float)$row->nilai/1000000000,2);
			$data['jml']['bm'][] = round((float)$row->bm/1000000000,2);
		}
		$data['legend'] = array('netto', 'nilai', 'bm');
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

			$data['nilai'][] = round(((float)$row->nilai/1000000)/((float)$row->netto/1000),2);
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
				'data' => $data['nilai']
			]
		];

		return $jsonObject;
	}

	public function pjt_bar($query_res)
	{
		$query_res = array_reverse($query_res);
		$data_pjt = [];
		$data_jml = [];

		$rep_pattern = '^([Pp][Tt]\W\s|[Pp][Tt]\W|[Cc][Vv]\W\s|[Cc][Vv]\W)^';

		foreach ($query_res as $row) {
			$pjt = preg_replace($rep_pattern, '', $row->nama);
			$jml = $row->dok;

			if (strlen($pjt) > 15) {
				$pjt = substr($pjt, 0, 15);
				$data_pjt[] = $pjt.'...';
			} else {
				$data_pjt[] = $pjt;
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
					'data' => $data_pjt
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

	public function negara_pengirim_map($query_res)
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

	public function negara_pengirim_bar($query_res)
	{
		$data = [];

		foreach ($query_res as $row) {
			$data['negara'][] = $row->kode;
			$data['dok'][] = $row->value;
		}

		$max_value = max($data['dok']);

		$jsonObject = [
			'title' => [
				'text' => '10 Negara pengirim terbesar',
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
				'right' => '20%',
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