<?php

class User_priv_model extends CI_Model {

	public function GetPrivilegesByUser($user_id='')
	{
		$query = $this->db->select('b.id, b.description app, c.role')
			->from('priv_user a')
			->join('priv_app_feature b', 'a.app_id = b.id')
			->join('priv_role c', 'a.role_id = c.id')
			->where('a.user_id', $user_id)
			->get();
		return $query->result_array();
	}

	public function GetUnregisteredAppsByUser($user_id='')
	{
		$query = $this->db->query('
			SELECT 
				a.id,
				a.description
			FROM priv_app_feature a
			WHERE 
				a.parent_id = 0 and
				a.id NOT IN (
				SELECT 
					b.app_id
				FROM priv_user b
				WHERE b.user_id = ' . $user_id . '
			)
		');
		return $query->result_array();
	}

	public function SaveUserPrivilege($input='')
	{
		$message = [];
		$user = $input['uid'];
		$app = isset($input['app']) ? $input['app'] : null;
		$role = isset($input['role']) ? $input['role'] : null;
		if ($app == null) {
			$m_content = 'Aplikasi wajib dipilih';
			$m_status = 0;
		} else {
			if ($role == '') {
				$m_content = 'Role wajib dipilih';
				$m_status = 0;
			} else {
				$data = [
					'user_id' => $input['uid'],
					'app_id' => $input['app'],
					'role_id' => $input['role']
				];
				$this->db->insert('priv_user', $data);
				$m_content = 'Privilege berhasil disimpan';
				$m_status = 1;
			}
		};
		$message['message'] = $m_content;
		$message['status'] = $m_status;
		return $message;
	}

	public function GetPrivilege()
	{
		$uid = $_SESSION['user_id'];
		$query = $this->db->select('a.feature_id, b.url')
			->from('priv_role_feature a')
			->join('priv_app_feature b', 'a.feature_id = b.id')
			->join('priv_user c', 'a.app_id = c.app_id and a.role_id = c.role_id')
			->where('c.user_id', $uid)
			->get();
		return $query->result_array();
	}

	public function GetMenu()
	{
		$uid = $_SESSION['user_id'];
		$query = $this->db->select('c.description menu_parent, b.description menu_child, b.url menu_url')
			->from('priv_role_feature a')
			->join('priv_app_feature b', 'a.feature_id = b.id')
			->join('priv_app_feature c', 'b.parent_id = c.id')
			->join('priv_user d', 'a.app_id = d.app_id and a.role_id = d.role_id')
			->where('d.user_id', $uid)
			->where('b.have_view', 1)
			->where('a.`status`', 1)
			->where('d.`status`', 1)
			->where('b.`status`', 1)
			->get();
		return $query->result_array();
	}

	public function GetUserRole($app_url='')
	{
		$uid = $_SESSION['user_id'];
		$query = $this->db->select('b.role_id')
			->from('priv_app_feature a')
			->join('priv_user b', 'a.parent_id = b.app_id')
			->where('a.url', $app_url)
			->where('b.user_id', $uid)
			->get();
		return $query->result_array();
	}
}