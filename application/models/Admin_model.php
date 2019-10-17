<?php

class Admin_model extends CI_Model {

	public function GetActivePejabat($date='', $kd_jabatan='')
	{
		$plh = $this->GetPlh($date, $kd_jabatan);
		if (empty($plh)) {
			$pejabat = $this->GetPejabat($kd_jabatan);
			$pejabat[0]->plh = 0;
		} else {
			$pejabat = $plh;
			$pejabat[0]->plh = 1;
		}
		return $pejabat;
	}

	public function GetJabatanAll()
	{
		$query = $this->db->select("k_jbtn, nama")
			->from("jabatan")
			->order_by("k_jbtn")
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

	public function GetPlhAll($date='')
	{
		$query = $this->db->select("a.id, a.tgl, b.nama jabatan, c.nama, c.nip")
			->from("admin_plh a")
			->join("jabatan b", "a.jabatan = b.k_jbtn")
			->join("profile c", "a.plh = c.id")
			->where("a.tgl", $date)
			->where("a.status <>", null)
			->get();

		return $query->result();
	}

	public function GetPlh($date='', $jabatan='0')
	{
		$query = $this->db->select('b.id, b.nama, b.nip, b.jabatan')
			->from('admin_plh a')
			->join('profile b', 'a.plh = b.id')
			->where('a.tgl', $date)
			->where('a.jabatan', $jabatan)
			->where('a.status <>', null)
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

	public function DeletePlh($id_plh='')
	{
		$query = $this->db->set('status', null)
			->where('id', $id_plh)
			->update('admin_plh');
		$message = 'Plh telah dihapus';
		return $message;
	}
}