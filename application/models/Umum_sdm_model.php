<?php

class Umum_sdm_model extends CI_Model {

	public function GetPegawaiById($id='')
	{
		$query = $this->db->select('a.id, a.nama, a.nip')
			->from('db_semesta.profile a')
			->where('id', $id)
			->get();

		return $query->result();
	}

	public function GetPejabat($jabatan='')
	{
		$query = $this->db->query("
			SELECT
				a.id,
				a.nama,
				a.nip,
				a.jabatan
			FROM db_semesta.profile a
			INNER JOIN db_semesta.jabatan b ON b.nama = a.jabatan COLLATE utf8_unicode_ci
			WHERE b.k_jbtn = '" . $jabatan . "'
		");

		return $query->result();
	}

	public function SearchPegawai($input='', $exclude='')
	{
		$excludeStr = implode(',', $exclude);

		$query = $this->db->query("
			SELECT a.id, a.nip, a.nama
			from db_semesta.profile a
			where 
				(
					a.nip like '%" . $input . "%' or
					a.nama like '%" . $input . "%'
				) and
				a.id not in (" . $excludeStr . ")
			order by a.nama
			limit 10
		");

		return $query->result();
	}

}