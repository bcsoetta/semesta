<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Errorx extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib'));
	}
	
	public function index() {
		$this->load->view('404');
	}
}