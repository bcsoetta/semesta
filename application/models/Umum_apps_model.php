<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Umum_apps_model extends CI_Model {

	public function GetAllApps()
	{
		$query = $this->db->select('id, nama, keterangan, alamat, tahun, pembuat, status')
			->from('umum_apps')
			->get();

		return $query->result();
	}

	public function GetAppById($input='')
	{
		$query = $this->db->select('id, nama, keterangan, alamat, tahun, pembuat, status')
			->from('umum_apps')
			->where('id', $input)
			->get();

		$data = $query->result();

		$pembuat = explode(', ', $data[0]->pembuat);
		$data[0]->pembuat = $pembuat;

		return $data[0];
	}

	public function SaveApp($input=[])
	{
		$data = [];
		$pembuat = [];
		foreach ($input['pembuat'] as $p) {
			$pembuat[] = $p;
		}

		$data['nama'] = $input['header']['nama'];
		$data['keterangan'] = $input['header']['keterangan'];
		$data['tahun'] = $input['header']['tahun'];
		$data['alamat'] = $input['header']['alamat'];
		$data['pembuat'] = implode(', ', $pembuat);
		$data['status'] = isset($input['header']['status']) ? $input['header']['status'] : 0;

		$this->db->insert('umum_apps', $data);
	}

	public function UpdateApp($input=[])
	{
		$data = [];
		$id = $input['header']['id'];
		$pembuat = [];
		foreach ($input['pembuat'] as $p) {
			$pembuat[] = $p;
		}

		$data['nama'] = $input['header']['nama'];
		$data['keterangan'] = $input['header']['keterangan'];
		$data['tahun'] = $input['header']['tahun'];
		$data['alamat'] = $input['header']['alamat'];
		$data['pembuat'] = implode(', ', $pembuat);
		$data['status'] = $input['header']['status'];

		$this->db->where('id', $id);
		$this->db->update('umum_apps', $data);
	}

	public function DeleteApp($input='')
	{
		$id = $input['id_data'];

		$this->db->where('id', $id);
		$this->db->delete('umum_apps');
	}
}