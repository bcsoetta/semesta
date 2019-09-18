<?php

class Penomoran_model extends CI_Model {

	public function GetNo($jenis_surat='', $agenda='', $tahun='')
	{
		$query = $this->db->select('nomor')
			->from('penomoran')
			->where('jenis_surat', $jenis_surat)
			->where('agenda', $agenda)
			->where('tahun', $tahun)
			->get()
			->result();

		if (count($query) > 0) {
			$nomor = $query[0]->nomor;
			$this->UpdateNo($jenis_surat, $agenda, $tahun);
			return (int)$nomor + 1;
		} else {
			$this->CreateNo($jenis_surat, $agenda, $tahun);
			return 1;
		}
	}

	private function UpdateNo($jenis_surat='', $agenda='', $tahun='')
	{
		$query = $this->db->set('nomor', 'nomor + 1', FALSE)
			->set('jenis_surat', $jenis_surat)
			->set('agenda', $agenda)
			->set('tahun', $tahun)
			->where('jenis_surat', $jenis_surat)
			->where('agenda', $agenda)
			->where('tahun', $tahun)
			->update('penomoran');
	}

	private function CreateNo($jenis_surat='', $agenda='', $tahun='')
	{
		$query = $this->db->set('nomor', 1)
			->set('jenis_surat', $jenis_surat)
			->set('agenda', $agenda)
			->set('tahun', $tahun)
			->where('jenis_surat', $jenis_surat)
			->where('agenda', $agenda)
			->where('tahun', $tahun)
			->insert('penomoran');
	}
}