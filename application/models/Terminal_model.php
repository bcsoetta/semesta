<?php

class Terminal_model extends CI_Model {

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
			->group_by("b.year, b.month")
			->get();
		return $query->result_array();
	}

	public function PenerimaanPungutanTotal($date='')
	{
		$query = $this->db->select("
				SUM(a.bm) bm,
				SUM(a.ppn) ppn,
				SUM(a.pph) pph,
				SUM(a.ppnbm) ppnbm
			")
			->from("db_semesta.fact_term_penerimaan a")
			->join("db_semesta.dim_date b", "a.tgl = b.id")
			->where("b.date >=", $date['start'])
			->where("b.date <=", $date['end'])
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
		->group_by("a.dokumen")
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
					'name' => 'Bea Masuk (jutaaan Rp)',
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
					'name' => 'Penerimaan (jutaaan Rp)',
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

}