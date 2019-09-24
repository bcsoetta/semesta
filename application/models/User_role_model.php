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
}