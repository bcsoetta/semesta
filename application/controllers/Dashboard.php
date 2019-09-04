<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('mainlib'));
	}

	public function index() {
		$this->mainlib->logged_in();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'dashboard';
		$data['content'] = 'dashboard';
		$this->load->view('index', $data);
	}
}