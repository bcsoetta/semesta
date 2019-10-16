<?php

class Admin_model extends CI_Model {

	public function GetJabatanAll()
	{
		$query = $this->db->select("k_jbtn, nama")
			->from("jabatan")
			->order_by("k_jbtn")
			->get();

		return $query->result();
	}

	public function GetPlhAll($date='')
	{
		$query = $this->db->select("a.id, a.tgl, b.nama jabatan, c.nama, c.nip")
			->from("admin_plh a")
			->join("jabatan b", "a.jabatan = b.k_jbtn")
			->join("profile c", "a.plh = c.id")
			->where("a.tgl", $date)
			->get();

		return $query->result();
	}

	public function GetPlh($date='', $jabatan='0')
	{
		$query = $this->db->select('plh')
			->from('admin_plh')
			->where('tgl', $date)
			->where('jabatan', $jabatan)
			->get();

		return $query->result();
	}

	public function GetPlhById($id='')
	{
		$query = $this->db->select('a.id, a.tgl, a.jabatan, b.nama ur_jabatan, a.plh, c.nip, c.nama')
			->from('admin_plh a')
			->join('jabatan b', 'a.jabatan = b.k_jbtn')
			->join('profile c', 'a.plh = c.id')
			->where('a.id', $id)
			->get();

		return $query->result_array();
	}

	public function SavePlh($input='')
	{
		$date = [];
		$data = [];
		$start_date = strtotime($input['start_date']);
		$end_date = strtotime($input['end_date']);

		if ($input['end_date'] == '') {
			$date[] = date("Y-m-d", $start_date);
		} else {
			$date = $this->ListDate($start_date, $end_date);
		}

		foreach ($date as $key => $value) {
			$data[] = [
				'tgl' => $value,
				'jabatan' => $input['jabatan'],
				'plh' => $input['id_pejabat']
			];
		}

		$this->db->insert_batch('admin_plh', $data);
	}

	public function ListDate($start_date='', $end_date='')
	{
		$list = [];
		for ($i=$start_date; $i<=$end_date; $i+=86400) {
		    $list[] = date("Y-m-d", $i);
		}
		return $list;
	}

	public function GetPegawai($input='', $exclude=[])
	{

		if (count($exclude) > 0) {
			$excludeStr = implode(',', $exclude);
		} else {
			$excludeStr = '0';
		}
		
		$query = $this->db->query("
			SELECT a.id, a.nip, a.nama
			from db_semesta.profile a
			where 
				(
					a.nip like '%" . $input . "%' or
					a.nama like '%" . $input . "%'
				) and
				a.id not in (" . $excludeStr . ")
			limit 10
		");

		return $query->result();
	}

	public function UpdatePlh($id_plh='', $id_pejabat='')
	{
		if ($id_pejabat != '') {
			$query = $this->db->set('plh', $id_pejabat)
				->where('id', $id_plh)
				->update('admin_plh');
			$message = 'Plh berhasil diupdate';
		} else {
			$message = 'Isikan pejabat plh dulu';
		}
		return $message;
	}
}