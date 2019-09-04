<?php

class Manif_out_atensi_model extends CI_Model {

	private function GetAtensiOutward()
	{
		// $datadb = $this->load->database('data', TRUE);

		$data = $this->db->select("
				a.NO_BC11, 
				a.TGL_BC11, 
				a.ID_JENIS_MANIFES, 
				a.NO_POS, 
				a.KODE_DOKUMEN_ASAL, 
				a.TGL_DOKUMEN_ASAL, 
				a.NO_DOKUMEN_ASAL
			")
			->from("data_dt.mo_dok_asal a")
			->where("a.TGL_BC11 < a.TGL_DOKUMEN_ASAL")
			->order_by('a.TGL_BC11', 'desc')
			->order_by('a.NO_BC11', 'desc')
			->order_by('a.ID_JENIS_MANIFES', 'asc')
			->order_by('a.NO_POS', 'asc')
			->get();

		return $data->result();
	}

	public function TableAtensiOutward()
	{
		$data = $this->GetAtensiOutward();

		$table = [];

		$table = [
			'paging' => [
				'enabled' => true,
				'limit' => 5,
				'size' => 10
			],
			'sorting' => [
				'enabled' => true
			]
		];

		foreach ($data[0] as $key => $value) {
			if (in_array($key, array('TGL_BC11', 'TGL_DOKUMEN_ASAL'))) {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'date'
				];
			} elseif (in_array($key, array('NO_BC11', 'NO_DOKUMEN_ASAL'))) {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'number'
				];
			} else {
				$columns[] = [
					'name' => $key,
					'title' => $key,
					'type' => 'text'
				];
			}
		}

		$table['columns'] = $columns;
		$table['rows'] = $data;

		return $table;
	}
}