<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Guide extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib', 'pagination'));
	}
	
	public function index() {
		redirect('guide/download');
	}

	public function create() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'create';
		$data['content'] = 'guide_create';
		$this->load->view('index', $data);
	}

	// create process
	public function create_() {
		$data['user_id'] = $_SESSION['user_id'];
		$data['guide_title'] = $_POST['guide_title'];
		$data['guide_content'] = $_POST['guide_content'];
		$this->load->model('Guide_model');
		$this->Guide_model->guide_create($data);
	}

	public function learn() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$this->load->model('Guide_model');
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'learn';
		$data['content'] = 'guide_learn';
		$this->load->view('index', $data);
	}

	// pagination
	public function load_guide_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$this->load->model('Guide_model');
		$allcount = $this->Guide_model->get_guide_detail_for_paginate_count($search);
		$guide_record = $this->Guide_model->get_guide_detail_for_paginate($rowno, $rowperpage, $search);

		// Pagination
		$config['base_url'] = base_url().'guide/page';
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
		$data['result'] = $guide_record;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	// update
	public function update() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$id = $_GET['gid'];
		$this->load->model('Guide_model');
		$data['gdata'] = $this->Guide_model->get_guide_detail_by_id($id);
		$data['content'] = 'guide_update';
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'update';
		$this->load->view('index', $data);
	}

	// update process
	public function update_() {
		$data['id'] = $_POST['gid'];
		$data['user_id'] = $_SESSION['user_id'];
		$data['guide_title'] = $_POST['guide_title'];
		$data['guide_content'] = $_POST['guide_content'];
		$this->load->model('Guide_model');
		$this->Guide_model->guide_update($data);
	}

	public function read() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$id = $_GET['gid'];
		$this->load->model('Guide_model');
		$data['gdata'] = $this->Guide_model->get_guide_detail_by_id($id);
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'read';
		$data['content'] = 'guide_read';
		$this->load->view('index', $data);
	}

	public function download() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'download';
		$data['content'] = 'guide_download';
		$this->load->view('index', $data);
	}
}