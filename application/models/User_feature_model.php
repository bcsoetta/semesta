<?php

class User_feature_model extends CI_Model {

	public function GetAllFeature()
	{
		$query = $this->db->select('a.id, a.description, a.`status`')
			->from('priv_app_feature a')
			->where('a.parent_id', 0)
			->get();

		return $query->result_array();
	}

	public function SaveFeature($input='')
	{
		$message = [];
		if ($input == '') {
			$m_content = 'Isikan nama fitur dahulu';
			$m_status = 0;
		} else {
			$checkFeature = $this->GetFeatureByDesc($input);
			if (count($checkFeature) > 0) {
				$m_content = 'Nama fitur sudah ada';
				$m_status = 0;
			} else {
				$data = [
					'parent_id' => 0,
					'description' => $input,
					'url' => '#',
					'status' => 1
				];
				$this->db->insert('priv_app_feature', $data);
				$m_content = 'Fitur berhasil disimpan';
				$m_status = 1;
			}
		};
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
	}

	public function UpdateFeature($input='')
	{
		$message = [];
		$id = $input['id'];
		$desc = $input['nama'];
		$status = isset($input['status']) ? $input['status'] : 0;
		if ($desc == '') {
			$m_content = 'Isikan nama fitur dahulu';
			$m_status = 0;
		} else {
			$checkFeature = $this->GetFeatureByDesc($desc);
			if (count($checkFeature) > 0) {
				if ($checkFeature[0]['id'] <> $id) {
					$m_content = 'Nama fitur sudah ada';
					$m_status = 0;
				} else {
					$data = [
						'parent_id' => 0,
						'description' => $desc,
						'url' => '#',
						'status' => $status
					];
					$this->db->where('id', $id);
					$this->db->update('priv_app_feature', $data);
					$m_content = 'Fitur berhasil diupdate';
					$m_status = 1;
				}
			} else {
				$data = [
					'parent_id' => 0,
					'description' => $desc,
					'url' => '#',
					'status' => $status
				];
				$this->db->where('id', $id);
				$this->db->update('priv_app_feature', $data);
				$m_content = 'Fitur berhasil diupdate';
				$m_status = 1;
			}
		}
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
	}

	public function GetFeatureByDesc($input='')
	{
		$query = $this->db->select('a.id, a.description', 'a.`status`')
			->from('priv_app_feature a')
			->where('a.description', $input)
			->get();
		return $query->result_array();
	}

	public function GetFeatureById($input='')
	{
		$query = $this->db->select('a.id, a.description, a.have_view, a.url, a.`status`')
			->from('priv_app_feature a')
			->where('a.id', $input)
			->get();
		return $query->result_array();
	}

	public function GetAllSubFeatureById($app_id='')
	{
		$query = $this->db->select('a.id, a.description, a.have_view, a.url, a.`status`')
			->from('priv_app_feature a')
			->where('a.parent_id', $app_id)
			->get();
		return $query->result_array();
	}

	private function GetSubFeatureByUrl($url='')
	{
		$query = $this->db->select('a.id, a.description, a.have_view, a.url, a.`status`')
			->from('priv_app_feature a')
			->where('a.url', $url)
			->get();
		return $query->result_array();
	}

	public function SaveSubFeature($input='')
	{
		$message = [];
		if ($input['url'] == '') {
			$m_content = 'URL harus diisi';
			$m_status = 0;
		} else {
			$checkSubfeature = $this->GetSubFeatureByUrl($input['url']);
			if (count($checkSubfeature) > 0 ) {
				$m_content = 'URL fitur sudah ada';
				$m_status = 0;
			} else {
				$this->db->insert('priv_app_feature', $input);
				$m_content = 'Fitur berhasil disimpan';
				$m_status = 1;
			}
		}
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
	}

	public function UpdateSubFeature($input='')
	{
		$message = [];
		if ($input['url'] == '') {
			$m_content = 'URL harus diisi';
			$m_status = 0;
		} else {
			$checkSubfeature = $this->GetSubFeatureByUrl($input['url']);
			if (count($checkSubfeature) > 0 && $input['id'] <> $checkSubfeature[0]['id']) {
				$m_content = 'URL fitur sudah ada';
				$m_status = 0;
			} else {
				$this->db->where('id', $input['id']);
				$this->db->update('priv_app_feature', $input);
				$m_content = 'Fitur berhasil disimpan';
				$m_status = 1;
			}
		}
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
		// return $checkSubfeature;
	}
}