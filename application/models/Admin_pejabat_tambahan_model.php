<?php

class Admin_pejabat_tambahan_model extends CI_Model {

	public function GetPejabatById($id='')
	{
		$query = $this->db->select("id, level, jabatan, nip, nama")
			->from("db_semesta.dim_pejabat_tambahan")
			->where("id", $id)
			->get();
		$result = $query->result_array();
		return $result[0];
	}

	public function GetActivePejabat()
	{
		$query = $this->db->select("id, level, jabatan, nip, nama")
			->from("db_semesta.dim_pejabat_tambahan")
			->where("status", 1)
			->get();
		return $query->result_array();
	}

	public function SavePejabatTambahan($input='')
	{
		if ($input['level'] != '' && $input['jabatan'] != '') {
			$existing_pejabat = $this->CheckExistPejabat($input['level'], $input['jabatan']);
			if (empty($existing_pejabat)) {
				$this->db->insert('db_semesta.dim_pejabat_tambahan', $input);
			} else {
				foreach ($existing_pejabat as $pejabat) {
					$this->DeletePejabatById($pejabat['id']);
				}
				$this->db->insert('db_semesta.dim_pejabat_tambahan', $input);
			}
			$msg = [
				'status' => 1,
				'message' => 'Data disimpan'
			];
		} else {
			$msg = [
				'status' => 0,
				'message' => 'Isikan data dahulu'
			];
		}
		return $msg;
	}

	private function CheckExistPejabat($level='', $jabatan='')
	{
		$query = $this->db->select("id")
			->from("db_semesta.dim_pejabat_tambahan")
			->where("level", $level)
			->where("jabatan", $jabatan)
			->where("status", 1)
			->get();
		return $query->result_array();
	}

	public function DeletePejabatById($id='')
	{
		$timestamp = date("Y-m-d H:i:s");

		$this->db->set('status', null);
		$this->db->set('deleted_at', $timestamp);
		$this->db->where('id', $id);
		$this->db->update('dim_pejabat_tambahan');
		return $this->db->affected_rows();
	}
}