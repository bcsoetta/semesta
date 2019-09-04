<?php

class Pib_atensi_model extends CI_Model {

	public function atensi_master($nip)
	{

		$query = $this->db->select("att_group, no_aju, LPAD(NO_PIB, 6, '0') NO_PIB, TGL_PIB, NM_IMP")
			->from("db_semesta.att_pib")
			->join("data_dt.new_pib_header", "db_semesta.att_pib.no_aju = data_dt.new_pib_header.CAR")
			->where("att_pib.nip_pfpd", $nip)
			->group_by(array("att_group", "no_aju"))
			->order_by("tgl_pib", "desc")
			->order_by("no_pib", "desc")
			->get();

		return $query->result();
	}

	public function atensi_header($input)
	{

		$query = $this->db->select("
				b.car, 
				LPAD(b.NO_PIB, 6, '0') NO_PIB, 
				DATE_FORMAT(b.TGL_PIB, '%d-%m-%Y') TGL_PIB, 
				b.JLR, b.NM_IMP, 
				b.WP_IMP, 
				b.NETTO_HDR, 
				b.BRUTO_HDR,
				a.netto_dtl,
				a.counted_item
			")
			->from("db_semesta.att_pib a")
			->join("data_dt.new_pib_header b", "a.no_aju = b.car")
			->where("b.car", $input)
			->get();

		return $query->result();
	}

	public function atensi_detil($input)
	{

		if ($input['group'] == 'kode_hs') {

			$query = $this->db->select("
					a.seri_brg 'Seri', 
					a.ur_brg_aju 'Uraian Barang', 
					a.hs_aju 'HS Aju', 
					a.hs_att 'HS Penetapan'
				")
				->from("att_pib a")
				->where("a.no_aju", $input["car"])
				->where("a.att_group", $input["group"])
				->order_by("a.seri_brg")
				->get();

		} elseif ($input['group'] == 'netto') {

			$query = $this->db->select("
					c.SERI_BARANG 'Seri', 
					c.URAIAN_BARANG 'Uraian Barang', 
					c.JML_SATUAN 'Jumlah', 
					c.KODE_SATUAN_BARANG 'Satuan', 
					c.NETTO 'Netto'
				")
				->from("data_dt.pib_detil c")
				->where("c.no_aju", $input['car'])
				->order_by("c.seri_barang")
				->get();

		}

		return $query->result();
	}

	public function atensi_master_table($query_res)
	{
		$data = [];

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

		$columns = [
			[
				'name' => 'att_group',
				'title' => 'Jenis Atensi',
				'classes' => 'att_group'
			],
			[
				'name' => 'NO_PIB',
				'title' => 'No PIB'
			],
			[
				'type' => 'date',
				'name' => 'TGL_PIB',
				'title' => 'Tgl PIB'
			],
			[
				'name' => 'NM_IMP',
				'title' => 'Importir'
			],
			[
				'name' => 'no_aju',
				'classes' => 'att_car',
				'visible' => false
			]
		];

		$data['columns'] = $columns;
		$data['rows'] = $query_res;
		return $data;
	}

	public function atensi_detil_table($query_res)
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

		foreach ($query_res[0] as $key => $value) {
			if (in_array($key, array('Seri', 'Jumlah', 'Netto'))) {
				$type = 'number';
			} else {
				$type = 'text';
			}

			$columns[] = [
				'name' => $key,
				'title' => $key,
				'type' => $type
			];
		}

		foreach ($query_res as $key => $value) {
			$value->{'Uraian Barang'} = [
				'options' => [
					'classes' => 'text-left'
				],
				'value' => $value->{'Uraian Barang'}
			];
		}

		$data['columns'] = $columns;
		$data['rows'] = $query_res;
		return $data;
	}

}