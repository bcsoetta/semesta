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
			->where('a.status', 1)
			->group_by('a.role_id')
			->get();
		return $query->result_array();
	}

	public function GetRoleFeatures($app_id='',$role_id='')
	{
		$query = $this->db->select('a.feature_id, b.url')
			->from('priv_role_feature a')
			->join('priv_app_feature b', 'a.feature_id = b.id')
			->where('a.app_id', $app_id)
			->where('a.role_id', $role_id)
			->where('a.status', 1)
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

	public function UpdateRoleFeature($input='')
	{
		if (isset($input['feature'])) {
			$app = $input['app_id'];
			$role = $input['role_id'];
			$feature = $input['feature'];
			$this->DisableFeatureByAppRole($app, $role);
			foreach ($feature as $f) {
				$data = [
					'app_id' => $app,
					'role_id' => $role,
					'feature_id' => $f,
					'status' => 1
				];
				$sql = '
					INSERT INTO priv_role_feature (app_id, role_id, feature_id, status) 
					VALUES (?, ?, ?, ?)
					ON DUPLICATE KEY 
					UPDATE 
						app_id = VALUES(app_id),
						role_id = VALUES(role_id),
						feature_id = VALUES(feature_id),
						status = VALUES(status)
				';
				$this->db->query($sql, $data);
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

	private function DisableFeatureByAppRole($app_id='', $role_id='')
	{
		$this->db->set('status', 0);
		$this->db->where('app_id', $app_id);
		$this->db->where('role_id', $role_id);
		$this->db->update('priv_role_feature');
	}
}