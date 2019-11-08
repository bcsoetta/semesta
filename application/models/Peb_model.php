<?php

class Peb_model extends CI_Model {

	private function prep_date($start, $end)
	{
		$date = [];

		if ($start == null) {
			$date['start'] = date('Y-01-01');
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

	private function JenisEkspor($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT
				dim.year,
				dim.month,
				dim.uraian jenis,
				sum(e.jumlah_dok) dok
			from db_semesta.fact_peb e
			right join (
				select a.id id_date, a.year, a.month, b.kode, b.uraian
					from dim_date a
					left join dim_peb_jenis_ekspor b
					on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
				union
				select a.id id_date, a.year, a.month, b.kode, b.uraian
					from dim_date a
					right join dim_peb_jenis_ekspor b
					on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			) dim
			on 
				dim.id_date = e.tgl_peb and
				dim.kode = e.jns_ekspor
			group by dim.year, dim.month, dim.kode
			order by dim.year, dim.month, dim.kode
		");

		return $query->result();
	}

	private function KategoriEkspor($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->query("
			SELECT
				dim.year,
				dim.month,
				dim.kategori,
				sum(e.jumlah_dok) dok
			from db_semesta.fact_peb e
			right join (
				select a.id id_date, a.year, a.month, b.id id_kategori, b.kategori
					from dim_date a
					left join dim_peb_kategori_ekspor b
					on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
				union
				select a.id id_date, a.year, a.month, b.id id_kategori, b.kategori
					from dim_date a
					right join dim_peb_kategori_ekspor b
					on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
			) dim
			on 
				dim.id_date = e.tgl_peb and
				dim.id_kategori = e.kat_ekspor
			group by dim.year, dim.month, dim.id_kategori
			order by dim.year, dim.month, dim.id_kategori
		");

		return $query->result();
	}

	private function NilaiTonase($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->select("
				b.year,
				b.month,
				sum(a.total_netto) netto,
				sum(a.total_devisa_usd) nilai
			")
			->from("db_semesta.fact_peb a")
			->join("db_semesta.dim_date b", "a.tgl_peb = b.id")
			->where("b.date between '" . $date['start'] . "' and '" . $date['end'] . "'")
			->group_by("1,2")
			->get();

		return $query->result();
	}

	private function Eksportir($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->select("
				b.nama,
				sum(a.total_devisa_usd) nilai
			")
			->from("db_semesta.fact_peb a")
			->join("db_semesta.dim_pengguna_jasa b", "a.eksportir = b.id")
			->join("db_semesta.dim_date c", "a.tgl_peb = c.id")
			->where("c.date between '" . $date['start'] . "' and '" . $date['end'] . "'")
			->group_by("b.id")
			->order_by("2", "desc")
			->limit("10")
			->get();

		return $query->result();
	}

	private function NegaraPenerima($start_date, $end_date)
	{
		$date = $this->prep_date($start_date, $end_date);

		// $semestadb = $this->load->database('semesta', TRUE);

		$query = $this->db->select("
				b.kd_negara kode,
				b.nm_echarts name,
				round(sum(a.total_devisa_usd)/1000, 2) value
			")
			->from("db_semesta.fact_peb a")
			->join("db_semesta.dim_negara b", "a.negara_penerima = b.id")
			->join("db_semesta.dim_date c", "a.tgl_peb = c.id")
			->where("c.date between '" . $date['start'] . "' and '" . $date['end'] . "'")
			->group_by("b.id")
			->order_by("3", "desc")
			->get();

		return $query->result();
	}

	public function JenisEksporLine($start_date, $end_date)
	{
		$query_res = $this->JenisEkspor($start_date, $end_date);

		$data = [];

		foreach ($query_res as $row) {
			$jenis = $row->jenis;
			$list_jenis[] = $jenis;

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['jml'][$jenis][] = (int)$row->dok;
		}
		$data['jenis'] = array_unique($list_jenis);
		$data['tgl'] = array_values(array_unique($list_tgl));


		$jsonObject = [
			'tooltip' => [
				'trigger' => 'axis'
			],
			'legend' => [
				'data' => $data['jenis']
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
			// 'color' => ['#78909c', '#ce93d8', '#8e24aa', '#a5d6a7', '#4caf50', '#2e7d32', '#ffeb3b', '#ef9a9a', '#f44336', '#c62828'],
			'series' => [

			]
		];

		foreach ($data['jenis'] as $jenis) {
			$series = [
				'name' => $jenis,
				'type' => 'line',
				'smooth' => true,
				'data' => $data['jml'][$jenis]	
			];

			$jsonObject['series'][] = $series;

		}

		return $jsonObject;
	}

	public function KategoriEksporLine($start_date, $end_date)
	{
		$query_res = $this->KategoriEkspor($start_date, $end_date);

		$data = [];

		foreach ($query_res as $row) {
			$kategori = $row->kategori;
			$list_kategori[] = $kategori;

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['jml'][$kategori][] = (int)$row->dok;
		}
		$data['kategori'] = array_unique($list_kategori);
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
			// 'color' => ['#78909c', '#ce93d8', '#8e24aa', '#a5d6a7', '#4caf50', '#2e7d32', '#ffeb3b', '#ef9a9a', '#f44336', '#c62828'],
			'series' => [

			]
		];

		foreach ($data['kategori'] as $kategori) {
			$series = [
				'name' => $kategori,
				'type' => 'line',
				'smooth' => true,
				'data' => $data['jml'][$kategori]	
			];

			$jsonObject['series'][] = $series;

		}

		return $jsonObject;
	}

	public function NilaiTonaseLine($start_date, $end_date)
	{
		$query_res = $this->NilaiTonase($start_date, $end_date);

		$data = [];

		foreach ($query_res as $row) {

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['jml']['netto'][] = round((float)$row->netto/1000,2);
			$data['jml']['nilai'][] = round((float)$row->nilai/1000000,2);
		}
		$data['legend'] = array('netto', 'nilai');
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
					'name' => 'Devisa (juta USD)',
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

		return $jsonObject;
	}

	public function RataNilaiTonaseLine($start_date, $end_date)
	{
		$query_res = $this->NilaiTonase($start_date, $end_date);

		$data = [];

		foreach ($query_res as $row) {

			$tgl = $row->year . '-' . $row->month;
			$tgl = date('M-Y',strtotime($tgl));
			$list_tgl[] = $tgl;

			$data['nilai'][] = round(((float)$row->nilai/1000)/((float)$row->netto/1000),2);
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
					'name' => 'Devisa/Netto (ribu USD/ton)',
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

	public function EksportirBar($start_date, $end_date)
	{
		$query_res = $this->Eksportir($start_date, $end_date);

		$query_res = array_reverse($query_res);
		$data_nama = [];
		$data_nilai = [];

		$rep_pattern = '^([Pp][Tt]\W\s|[Pp][Tt]\W|[Cc][Vv]\W\s|[Cc][Vv]\W)^';

		foreach ($query_res as $row) {
			$nama = preg_replace($rep_pattern, '', $row->nama);
			$nilai = $row->nilai;

			if (strlen($nama) > 15) {
				$nama = substr($nama, 0, 15);
				$data_nama[] = $nama.'...';
			} else {
				$data_nama[] = $nama;
			}
			
			$data_nilai[] = round($nilai/1000000,2);
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
					'name' => 'Devisa (juta USD)',
					'nameLocation' => 'center',
					'nameGap' => 30,
					'type' => 'value',
					'boundaryGap' => [0, 0.1]
				]
			],
			'yAxis' => [
				[
					'name' => 'Eksportir',
					'nameLocation' => 'center',
					'nameGap' => 140,
					'type' => 'category',
					'data' => $data_nama
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
					'data' => $data_nilai
				]
			]
		];

		return $jsonObject;
	}

	public function NegaraPenerimaMap($start_date, $end_date)
	{
		$query_res = $this->NegaraPenerima($start_date, $end_date);

		$value = [];

		foreach ($query_res as $row) {
			unset($row->kode);
			$value[] = $row->value;
		}

		$max_value = doubleval(max($value));

		$jsonObject = [
			'tooltip' => [
				'trigger' => 'item'
			],
			'visualMap' => [
				'min' => 0,
				'max' => (1000 * ceil($max_value / 1000)),
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

	public function NegaraPenerimaBar($start_date, $end_date)
	{
		$query_res = $this->NegaraPenerima($start_date, $end_date);
		
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