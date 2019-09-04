<?php

class Pib_importir_model extends CI_Model {

	public function GetImportirAll($value='')
	{
		$query = $this->db->query("
			SELECT
				imp.npwp,
				imp.nama,
				sum(d.jumlah_dok) jml_dok
			FROM (
				SELECT
					a.id,
					a.npwp,
					a.nama
				FROM db_semesta.dim_pengguna_jasa a
				INNER JOIN db_semesta.ref_pengguna_jasa b ON a.id = b.id_pengguna_jasa
				INNER JOIN db_semesta.dim_grup_pengguna_jasa c ON b.id_group = c.id
				WHERE c.grup = 'importir'
				GROUP BY a.id
			) imp
			LEFT JOIN db_semesta.fact_pib d ON imp.id = d.wp_imp
			GROUP BY imp.id
		");

		return $query->result();
	}

}