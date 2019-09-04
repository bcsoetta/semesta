<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Guide_model extends CI_Model{

	public function __construct() {
		parent::__construct();
	}

	public function guide_create($data) {
		$arr = array(
			'guide_author' => $data['user_id'],
			'guide_title' => $data['guide_title'],
			'guide_content' => $data['guide_content']
		);
		$this->db->insert('guide', $arr);
	}

	// Fetch records
	public function get_guide_detail_for_paginate($rowno, $rowperpage, $search) {
		$this->db->select("id, guide_title, guide_content, DATE_FORMAT(guide_date, '%d %M, %Y') guide_date, guide_status, guide_author, name");
		$this->db->from('guide');
		$this->db->join('user', 'user.user_id = guide.guide_author', 'left');
		if ($search != ''){
			$this->db->like('guide_title', $search);
			// $this->db->or_like('role', $search);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();

		return $query->result_array();
	}

	// Select total records
	public function get_guide_detail_for_paginate_count($search) {
		$this->db->select('count(*) as allcount');
		$this->db->from('guide');
		$this->db->join('user', 'user.user_id = guide.guide_author', 'left');
		if ($search != ''){
			$this->db->like('guide_title', $search);
			// $this->db->or_like('role', $search);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	public function get_guide_detail_by_id($id) {
		$this->db->select("id, guide_title, guide_content, DATE_FORMAT(guide_date, '%d %M, %Y') guide_date, guide_status, guide_author, name");
		$this->db->join('user', 'user.user_id = guide.guide_author', 'left');
		$this->db->where("id", $id);
		$query = $this->db->get('guide');

		if($query->num_rows() > 0){
			$data = $query->row();
			$query->free_result();
		}
		else{
			$data = NULL;
		}
		return $data;
	}

	public function guide_update($data) {
		$this->db->where('id', $data['id']);
		$arr = array(
			'guide_author' => $data['user_id'],
			'guide_title' => $data['guide_title'],
			'guide_content' => $data['guide_content']
		);
		$this->db->update('guide', $arr);
	}



}