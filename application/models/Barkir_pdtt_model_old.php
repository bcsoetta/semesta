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

	public function jalur($pdtt, $date)
	{

		$query = $this->db->query("
			SELECT 
				dim.year,
				dim.month,
				dim.jenis,
				case
					when dim.jalur = 1 then 'MT'
					when dim.jalur = 2 then 'MP'
					when dim.jalur = 3 then 'H'
				end jalur,
				sum(e.jumlah_dok) dok
			from db_semesta.fact_barkir e
			right join (
				select a.id tgl, a.year, a.month, b.id id_jenis, b.jenis, c.id jalur, d.id id_pdtt, d.nip
					from dim_date a
					left join dim_barkir_jenis_aju b on 1=1
					left join dim_barkir_jalur c on 1=1
					left join dim_pegawai d on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
					and d.nip = '" . $pdtt . "'
				union
				select a.id tgl, a.year, a.month, b.id id_jenis, b.jenis, c.id jalur, d.id id_pdtt, d.nip
					from dim_date a
					right join dim_barkir_jenis_aju b on 1=1
					right join dim_barkir_jalur c on 1=1
					right join dim_pegawai d on 1=1
					where a.date between '" . $date['start'] . "' and '" . $date['end'] . "'
					and d.nip = '" . $pdtt . "'
			) dim
			on e.tgl_house_blawb = dim.tgl
			and e.jenis_aju = dim.id_jenis
			and e.jalur = dim.jalur
			and e.pdtt = dim.id_pdtt
			group by year, month, jenis, jalur, nip
		");

		return $query->result();
	}

	public function penerimaan_bulan($pdtt, $date)
	{

		$query = $this->db->query("
			SELECT 
				b.year, b.month, 
				sum(a.total_bm_penetapan) bm, 
				sum(a.total_ppn_penetapan) ppn, 
				sum(a.total_pph_penetapan) pph, 
				sum(a.total_ppnbm_penetapan) ppnbm
			from fact_barkir a
			inner join dim_date b on a.tgl_house_blawb = b.id
			inner join dim_pegawai c on a.pdtt = c.id
			where 
				b.date between '" . $date['start'] . "' and '" . $date['end'] . "' and
				c.nip = '" . $pdtt . "'
			group by b.year, b.month
		");

		return $query->result();
	}

	public function detil($pdtt, $date = array('start' => '2019-01-01', 'end' => '2019-05-31'))
	{

		$query = $this->db->query("
			SELECT 
				b.year, b.month, 
				ifnull(
					sum(
						case
							when a.jenis_aju = 1
							then a.jumlah_dok
						end
					), 0
				) cn,
				ifnull(
					sum(
						case
							when a.jenis_aju = 2
							then a.jumlah_dok
						end
					), 0
				) pibk,
				ifnull(sum(a.total_bm_penetapan), 0) bm, 
				ifnull(sum(a.total_ppn_penetapan), 0) ppn, 
				ifnull(sum(a.total_pph_penetapan), 0) pph, 
				ifnull(sum(a.total_ppnbm_penetapan), 0) ppnbm
			from fact_barkir a
			inner join dim_date b on a.tgl_house_blawb = b.id
			inner join dim_pegawai c on a.pdtt = c.id
			where 
				b.date between '" . $date['start'] . "' and '" . $date['end'] . "' and
				c.nip = '" . $pdtt . "'
			group by b.year, b.month
			order by b.year, b.month
		");

		return $query->result();
	}

	public function search($input)
	{

		$query = $this->db->query("
			SELECT a.nip, a.nama
			from dim_pegawai a
			where 
				(
					a.nip like '%" . $input . "%' or
					a.nama like '%" . $input . "%'
				) and
				a.grup = 1 and
				a.nip <> 'system'
			limit 10
		");
		return $query->result();
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
				'left' => 60,
				'right'=> 35,
				'top' => 45,
				'bottom' => 40
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
					'name' => 'Jumlah dokumen',
					'nameLocation' => 'center',
					'nameGap' => 45,
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
					'left' => 55,
					'right'=> 35,
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
					'nameGap' => 40,
					'type' => 'value'
				]
			],
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

	public function detil_table($query_res)
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

		$columns[] = [
			'name' => 'date',
			'title' => 'tanggal',
			'type' => 'date'
		];

		foreach ($query_res[0] as $key => $value) {
			if (!in_array($key, array('year', 'month'))) {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'number'
				];
			}
		}

		foreach ($query_res as $key => $value) {
			$date = $value->year . '-' . $value->month;
			$value->date = date("M-Y", strtotime($date));
			unset($value->year);
			unset($value->month);
		}

		$data['columns'] = $columns;
		$data['rows'] = $query_res;
		return $data;
	}

}