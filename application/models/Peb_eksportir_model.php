<?php

class Peb_eksportir_model extends CI_Model {

	public function GetEksportirAll($value='')
	{
		$query = $this->db->query("
			SELECT
				eks.npwp,
				eks.nama,
				sum(d.jumlah_dok) jml_dok
			FROM (
				SELECT
					a.id,
					a.npwp,
					a.nama
				FROM db_semesta.dim_pengguna_jasa a
				INNER JOIN db_semesta.ref_pengguna_jasa b ON a.id = b.id_pengguna_jasa
				INNER JOIN db_semesta.dim_grup_pengguna_jasa c ON b.id_group = c.id
				WHERE c.grup = 'eksportir'
				GROUP BY a.id
			) eks
			LEFT JOIN db_semesta.fact_peb d ON eks.id = d.eksportir
			GROUP BY eks.id
		");

		return $query->result();
	}

}