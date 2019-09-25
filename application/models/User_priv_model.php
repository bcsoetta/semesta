<?php

class User_priv_model extends CI_Model {

	public function GetPrivilegesByUser($user_id='')
	{
		# code...
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
}