<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

	public function __construct() {
		parent::__construct();
	}

	public function user_register($input) {
		$this->load->helper('my_helper');
		$encrypt_password = bCrypt($input['password'],12);
		$array_user = array(
				'username' => $input['username'],
				'password' => $encrypt_password,
				'name' => $input['name'],
				'nip' => $input['nip'],
				'role' => $input['role'],
				'status' => $input['status']
			);

		$this->db->insert('user', $array_user);
	}

	public function user_upassw($input) {
		$this->load->helper('my_helper');
		$encrypt_password = bCrypt($input['password'],12);
		$this->db->where('user_id', $input['user_id']);
		$array_user = array(
				'password' => $encrypt_password
			);

		$this->db->update('user', $array_user);
	}

	public function user_update($input) {
		$this->db->where('user_id', $input['user_id']);
		$array_user = array(
				'username' => $input['username'],
				'name' => $input['name'],
				'nip' => $input['nip'],
				'role' => $input['role'],
				'status' => $input['status']
			);

		$this->db->update('user', $array_user);
	}

	public function exist_row_check($field, $data) {
		$this->db->where($field, $data);
		$this->db->from('user');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function exist_row_check_update($field, $uid, $data) {
		$this->db->where('user_id!=',$uid);
		$this->db->where($field.'=',$data);
		$this->db->from('user');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_user_detail() {
		$query = $this->db->get('user');
		if($query->num_rows() > 0){
			$data = $query->result_array();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function get_user_detail_by_username($username) {
		$this->db->select('user.user_id, user.password, user.name, user.nip, user.role, user.status');
		$this->db->from('user');;
		$this->db->where('user.username', $username);
		$this->db->where('user.status', '100');
		$this->db->order_by("user.username", "asc");
		$query = $this->db->get();

		$data = [];
		if ($query->num_rows() > 0){
			$data['user'] = $query->result_array()[0];
			$query->free_result();
		}
		else {
			$data = NULL;
		}
		return $data;
	}

	public function get_user_detail_by_id($user_id) {
		$this->db->where("user_id", $user_id);
		$query = $this->db->get('user');

		if($query->num_rows() > 0){
			$data = $query->row();
			$query->free_result();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function get_user_detail_for_paginate($rowno, $rowperpage, $search) {
		$this->db->select('user_id, name, nip, role, status');
		$this->db->from('user');
		if ($search != ''){
			$this->db->like('name', $search);
			// $this->db->or_like('role', $search);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_user_detail_for_paginate_count($search) {
		$this->db->select('count(*) as allcount');
		$this->db->from('user');
		if ($search != ''){
			$this->db->like('name', $search);
			// $this->db->or_like('role', $search);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	// Fetch records
	public function get_privils_detail_for_paginate($rowno, $rowperpage, $search, $uid) {
		$this->db->select('priv.menu_id, priv.user_id, priv.`status`, priv_ref.menu_parent, priv_ref.menu_child, priv_ref.menu_url');
		$this->db->from('priv');
		$this->db->join('priv_ref', 'priv.menu_id = priv_ref.id', 'inner');
		if ($search != ''){
			$this->db->like('priv_ref.menu_parent', $search);
		}
		$this->db->where('priv.user_id', $uid);
		$this->db->where('priv.status', 100);
		$this->db->order_by("priv_ref.menu_parent", "asc");

		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_privils_ref_detail_for_paginate($rowno, $rowperpage, $search, $uid) {
		$query = $this->db->query("SELECT menu_parent, menu_child, menu_id, menu_idx, user_id, `status` FROM (SELECT a.menu_parent, a.menu_child, a.id menu_id, b.menu_id menu_idx, b.user_id, b.`status` FROM priv_ref a INNER JOIN priv b ON a.id = b.menu_id WHERE b.user_id = '$uid' UNION SELECT r.menu_parent, r.menu_child, r.id menu_id, NULL, NULL, NULL FROM priv_ref r WHERE r.id NOT IN (SELECT t.menu_id FROM priv t WHERE t.user_id = '$uid')) a WHERE a.menu_parent LIKE '%$search%' ORDER BY a.menu_parent ASC LIMIT $rowno, $rowperpage");
		return $query->result_array();
	}

	public function get_privils_ref_detail_for_paginate_count($search) {
		$query = $this->db->query("SELECT COUNT(*) as allcount FROM priv_ref WHERE menu_parent LIKE '%$search%'");
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function get_privils_detail_for_paginate_count($search, $uid) {
		$this->db->select('count(*) as allcount');
		$this->db->from('user');
		$this->db->join('priv', 'user.user_id = priv.user_id', 'inner');
		$this->db->join('priv_ref', 'priv.menu_id = priv_ref.id', 'inner');
		if ($search != ''){
			$this->db->like('priv_ref.menu_parent', $search);
			// $this->db->or_like('priv_ref.menu_child', $search);
		}
		$this->db->where('user.user_id', $uid);
		$this->db->where('priv.status', 100);
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	public function privil4_disable($uid, $menu_id) {
		$this->db->where('user_id', $uid);
		$this->db->where('menu_id', $menu_id);
		$arr = array(
				'status' => 400
			);
		$this->db->update('priv', $arr);

		$aff = $this->db->affected_rows();

		if ($aff > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function privil4_enable($uid, $menu_id) {
		$this->db->where('user_id', $uid);
		$this->db->where('menu_id', $menu_id);
		$arr = array(
				'status' => 100
			);
		$this->db->update('priv', $arr);

		$aff = $this->db->affected_rows();

		if ($aff > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function privil4_activate($uid, $menu_id) {
		$this->db->from('priv');
		$this->db->where('user_id', $uid);
		$this->db->where('menu_id', $menu_id);
		$r = $this->db->get()->num_rows();
		if ($r > 0) {
			echo "You can't activate";
		} else {
			$arr = array(
				'menu_id' => $menu_id,
				'user_id' => $uid,
				'status' => 100
			);

			$this->db->insert('priv', $arr);

			$aff = $this->db->affected_rows();

			if ($aff > 0) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function get_user_role_count() {
		$this->db->select('role, COUNT(user_id) jrole');
		$this->db->from('user');
		$this->db->group_by('role'); 
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$data = $query->result_array();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function get_user_status_count() {
		$this->db->select('status, COUNT(user_id) jstatus');
		$this->db->from('user');
		$this->db->group_by('status'); 
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$data = $query->result_array();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function get_privsx() {
		$uid = $_SESSION['user_id'];
		$this->db->select('priv.menu_id, priv.user_id, priv.`status`, priv_ref.menu_parent, priv_ref.menu_child, priv_ref.menu_url');
		$this->db->from('priv');
		$this->db->join('priv_ref', 'priv.menu_id = priv_ref.id', 'inner');
		$this->db->where('priv.user_id', $uid);
		$this->db->where('priv.status', 100);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_priv_menu() {
		$uid = $_SESSION['user_id'];
		$this->db->select('priv.menu_id, priv.user_id, priv.`status`, priv_ref.menu_parent, priv_ref.menu_child, priv_ref.menu_url');
		$this->db->from('priv');
		$this->db->join('priv_ref', 'priv.menu_id = priv_ref.id', 'inner');
		$this->db->where('priv.user_id', $uid);
		$this->db->where('priv.status', 100);
		$this->db->where('priv_ref.exclude', 'N');
		$query = $this->db->get();
		return $query->result_array();
	}

}