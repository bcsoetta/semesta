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
		$this->db->from("db_semesta.fact_term_kategori_copy a");
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

}