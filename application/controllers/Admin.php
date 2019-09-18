<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib', 'pagination'));
		
		$this->load->model('Admin_model');
	}

	public function plh($value='')
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['lsJabatan'] = $this->Admin_model->GetJabatanAll();
		$data['hal'] = 'update Plh';
		$data['content'] = 'admin_plh';
		$this->load->view('index', $data);
	}

	public function daftar_plh()
	{
		$this->mainlib->logged_in();
		if ($_POST['tgl'] != '') {
			$date = date("Y-m-d", strtotime($_POST['tgl']));
		} else {
			$date = date("Y-m-d");
		}
		$lsPlh = $this->Admin_model->GetPlhAll($date);
		header('Content-type:application/json');
		echo json_encode($lsPlh);
	}

	public function simpan_plh()
	{
		$this->mainlib->logged_in();
		$this->Admin_model->SavePlh($_POST);
	}

	public function cari_pegawai()
	{
		$this->mainlib->logged_in();
		$list = $this->Admin_model->GetPegawai($_POST['pegawai']);
		header('Content-type:application/json');
		echo json_encode($list);
	}

}