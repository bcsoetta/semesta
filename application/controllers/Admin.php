<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib', 'pagination'));
		
		$this->load->model('Admin_model');
		$this->load->model('Admin_pejabat_tambahan_model');
	}

	// Halaman setting plh
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

	public function plh_show()
	{
		$this->mainlib->logged_in();
		$result = $this->Admin_model->GetPlhById($_POST['id']);
		$data = $result[0];
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function plh_update()
	{
		$this->mainlib->logged_in();
		$m = $this->Admin_model->UpdatePlh($_POST['id_plh'], $_POST['id_pejabat']);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	public function plh_delete()
	{
		$this->mainlib->logged_in();
		$m = $this->Admin_model->DeletePlh($_POST['id']);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	// Halaman setting pejabat tambahan
	public function jabatan_tambahan($value='')
	{
		$this->mainlib->logged_in();
		// $this->mainlib->privilege();

		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['lsJabatan'] = $this->Admin_model->GetJabatanAll();
		$data['hal'] = 'jabatan tambahan';
		$data['content'] = 'admin_jabatan_tambahan';
		$this->load->view('index', $data);
	}

	public function jabatan_tambahan_list()
	{
		$this->mainlib->logged_in();
		$data = $this->Admin_pejabat_tambahan_model->GetActivePejabat();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function jabatan_tambahan_save()
	{
		$this->mainlib->logged_in();
		$msg = $this->Admin_pejabat_tambahan_model->SavePejabatTambahan($_POST);
		header('Content-type:application/json');
		echo json_encode($msg);
	}

	public function jabatan_tambahan_show()
	{
		$this->mainlib->logged_in();
		$data = $this->Admin_pejabat_tambahan_model->GetPejabatById($_POST['id']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function jabatan_tambahan_delete()
	{
		$this->mainlib->logged_in();
		$row = $this->Admin_pejabat_tambahan_model->DeletePejabatById($_POST['id']);

		if ($row > 0) {
			$msg = [
				'status' => 1,
				'message' => 'Data berhasil dihapus'
			];
		} else {
			$msg = [
				'status' => 0,
				'message' => 'Error'
			];
		}
		header('Content-type:application/json');
		echo json_encode($msg);
	}

	public function jabatan_tambahan_jab()
	{
		$this->mainlib->logged_in();
		$data = $this->Admin_pejabat_tambahan_model->GetPejabatByJabatan($_POST['jab']);
		header('Content-type:application/json');
		echo json_encode($data);
	}
}