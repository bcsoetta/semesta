<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Umum extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib', 'pagination'));
	}

	public function index() {
		echo "Index";
	}

	public function ppkp_update() {

		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$this->load->model('Umum_model');

		if (isset($_GET['pid'])) {
		    $ppkp_id = $_GET['pid'];
			$ff = $this->Umum_model->get_ppkp_by_id($ppkp_id);
			if (empty($ff)) {
				redirect(base_url('errorx'));
			}
		} else {
			redirect(base_url('errorx'));
		}
		
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['ppkp'] = $this->Umum_model->get_ppkp_by_id($ppkp_id);
		$data['hal'] = 'update PPKP';
		$data['content'] = 'ppkp_update';
		$this->load->view('index', $data);
	}

	public function ppkp_update_process() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data = $_POST;
		print_r($data);
		$this->load->model('Umum_model');
		$result = $this->Umum_model->ppkp_update_process($data);
		if ($result) {
			redirect(base_url('umum/ppkp_browse'));
		} else {
			redirect(base_url('umum/ppkp_create'));
		}
	}

	public function ppkp_create() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$this->load->model('Umum_model');
		$data['list_ppkp'] = $this->Umum_model->get_all_ppkp();
		$data['jum_ppkp'] = $this->Umum_model->get_jum_ppkp();
		$data['score'] = $this->Umum_model->ppkp_score_by_ppkp_id();
		$data['hal'] = 'create PPKP';
		$data['content'] = 'ppkp_create';
		$this->load->view('index', $data);
	}

	public function ppkp_create_process() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data = $_POST;
		$this->load->model('Umum_model');
		$result = $this->Umum_model->ppkp_create_process($data);
		if ($result) {
			redirect(base_url('umum/ppkp_browse'));
		} else {
			redirect(base_url('umum/ppkp_create'));
		}
		
	}

	public function ppkp_browse() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$this->load->model('Umum_model');
		$data['list_ppkp'] = $this->Umum_model->get_all_ppkp();
		$data['jum_ppkp'] = $this->Umum_model->get_jum_ppkp();
		$data['score'] = $this->Umum_model->ppkp_score_by_ppkp_id();
		$data['hal'] = 'browse PPKP';
		$data['content'] = 'ppkp_browse';
		$this->load->view('index', $data);
	}

	public function load_ppkp_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$tglawal = $_GET['tglawal'];
		if ($tglawal == "" OR $tglawal == "undefined" OR $tglawal == NULL) {
			$tglawal == "";
		} else {
			$tglawal = date('Y-m-d', strtotime($_GET['tglawal']));
		}

		$tglakhir = $_GET['tglakhir'];
		if ($tglakhir == "" OR $tglakhir == "undefined" OR $tglakhir == NULL) {
			$tglakhir == "";
		} else {
			$tglakhir = date('Y-m-d', strtotime($_GET['tglakhir']));
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$this->load->model('Umum_model');
		$allcount = $this->Umum_model->get_ppkp_for_paginate_count($search, $tglawal, $tglakhir);
		$users_record = $this->Umum_model->get_ppkp_for_paginate($rowno, $rowperpage, $search, $tglawal, $tglakhir);
		$ppkp_score = $this->Umum_model->ppkp_score_by_ppkp_id();

		// Pagination
		$config['base_url'] = base_url().'user/page';
		$config['reuse_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		$config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:20px; float: right;">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		// Initialize
		$this->pagination->initialize($config);

		// Initialize data array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['score'] = $ppkp_score;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	public function ppkp() {

		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$this->load->model('User_model');
		$this->load->model('Umum_model');

		if (isset($_GET['pid'])) {
		    $ppkp_id = $_GET['pid'];
			$ff = $this->Umum_model->get_ppkp_by_id($ppkp_id);
			if (empty($ff)) {
				redirect(base_url('errorx'));
			}
		} else {
			$ppkp_id = null;
		}

		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'PPKP';
		$data['content'] = 'ppkp_peserta';
		$data['ppkp'] = $this->Umum_model->get_ppkp_by_id($ppkp_id);
		$data['js'] = $this->User_model->get_user_status_count();
		$data['udata'] = $this->User_model->get_user_detail();
		$this->load->view('index', $data);
	}

	public function load_user_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$pid = $_GET['pid'];
		if ($pid == "" OR $pid == "undefined" OR $pid == NULL) {
			$pid == "";
		}

		$this->load->model('Umum_model');
		$allcount = $this->Umum_model->get_user_detail_for_paginate_count($search, $pid);
		$users_record = $this->Umum_model->get_user_detail_for_paginate($rowno, $rowperpage, $search, $pid);

		// Pagination
		$config['base_url'] = base_url().'user/page';
		$config['reuse_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		$config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:20px; float: right;">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		// Initialize
		$this->pagination->initialize($config);

		// Initialize data array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	// pagination
	public function load_privils_ref_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$pid = $_GET['pid'];
		if ($pid == "" OR $pid == "undefined" OR $pid == NULL) {
			$pid == "";
		}

		$this->load->model('Umum_model');
		$allcount = $this->Umum_model->get_privils_ref_detail_for_paginate_count($search);
		$users_record = $this->Umum_model->get_privils_ref_detail_for_paginate($rowno, $rowperpage, $search, $pid);
		// print_r($users_record);

		// Pagination
		$config['base_url'] = base_url().'umum/page';
		$config['reuse_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		$config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:20px; float: right;">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		// Initialize
		$this->pagination->initialize($config);

		// Initialize data array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	public function tambah_peserta_ppkp() {
		$pid = $_POST['pid'];
		$nama = $_POST['nama']; 
		$nip = $_POST['nip']; 
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->tambah_peserta_ppkp($pid, $nama, $nip);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function hapus_peserta_ppkp() {
		$pid = $_POST['pid'];
		$nama = $_POST['nama']; 
		$nip = $_POST['nip']; 
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->hapus_peserta_ppkp($pid, $nama, $nip);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function absen_tidak_hadir() {
		$tbid = $_POST['tbid'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->absen_tidak_hadir($tbid);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function absen_hadir() {
		$tbid = $_POST['tbid'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->absen_hadir($tbid);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function scoring() {
		$tbid = $_POST['tbid'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->scoring($tbid);
		
		if ($rem) {
			echo $rem;
		} else {
			echo '0';
		}
	}

	public function scoring_() {
		$tbid = $_POST['tbid'];
		$pre_test = $_POST['pre_test'];
		$post_test = $_POST['post_test'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->scoring_($tbid, $pre_test, $post_test);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}
}