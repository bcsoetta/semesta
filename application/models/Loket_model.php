<?php

class Loket_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function GetDoksByLayanan($input='')
	{
		$query = $this->db->select('a.id, a.tanggal, a.kd_agd, a.no_surat, a.tgl_surat, a.dari, a.hal, a.sta')
			->from('dokagd a')
			->where('a.nm_layan', $input)
			->where('a.tanggal >=', '2019-01-01')
			->get();

		return $query->result();
	}

}