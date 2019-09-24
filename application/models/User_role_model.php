<?php

class User_role_model extends CI_Model {

	public function GetAllRole()
	{
		$query = $this->db->select('a.id, a.role')
			->from('priv_role a')
			->get();
		return $query->result_array();
	}

	public function GetRoleByDesc($desc='')
	{
		$query = $this->db->select('a.id, a.role')
			->from('priv_role a')
			->where('a.role', $desc)
			->get();
		return $query->result_array();
	}

	public function GetUnusedRoleByAppId($app_id='')
	{
		$query = $this->db->query('
			SELECT
				a.id,
				a.role
			FROM priv_role a
			WHERE a.id NOT IN (
				SELECT 
					b.role_id
				FROM priv_role_feature b
				WHERE b.app_id = ' . $app_id . '
			)
		');
		return $query->result_array();
	}

	public function GetUsedRoleByAppId($app_id='')
	{
		$query = $this->db->select('b.id, b.role, group_concat(c.url) feature')
			->from('priv_role_feature a')
			->join('priv_role b', 'a.role_id = b.id')
			->join('priv_app_feature c', 'a.feature_id = c.id')
			->where('a.app_id', $app_id)
			->group_by('a.role_id')
			->get();
		return $query->result_array();
	}

	public function SaveRole($input='')
	{
		$message = [];
		$role = $input['role'];
		$status = isset($input['status']) ? $input['status'] : 0;
		if ($role == '') {
			$m_content = 'Isikan nama role dahulu';
			$m_status = 0;
		} else {
			$checkRole = $this->GetRoleByDesc($role);
			if (count($checkRole) > 0) {
				$m_content = 'Nama role sudah ada';
				$m_status = 0;
			} else {
				$data = [
					'role' => $role,
					'status' => $status
				];
				$this->db->insert('priv_role', $data);
				$m_content = 'role berhasil disimpan';
				$m_status = 1;
			}
		};
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
	}

	public function SaveRoleFeature($input='')
	{
		if (isset($input['feature'])) {
			$app = $input['app'];
			$role = $input['role'];
			$feature = $input['feature'];
			foreach ($feature as $f) {
				$data = [
					'app_id' => $app,
					'role_id' => $role,
					'feature_id' => $f
				];
				$this->db->insert('priv_role_feature', $data);
			}
			$m_content = 'Role berhasil disimpan';
			$m_status = 1;
		} else {
			$m_content = 'Feature wajib diisi';
			$m_status = 0;
		}
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
	}
}