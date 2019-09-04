<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Peb extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib'));
		$this->load->model('Peb_model');
		$this->load->model('Peb_eksportir_model');
	}

	public function statistik()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'statistik';
		$data['content'] = 'peb_statistik';
		$this->load->view('index', $data);
	}

	public function jenis_ekspor()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->JenisEksporLine($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function kategori_ekspor()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->KategoriEksporLine($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function nilai_tonase()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->NilaiTonaseLine($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function rata_nilai_tonase()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->RataNilaiTonaseLine($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function eksportir()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->EksportirBar($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function negara_penerima()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->NegaraPenerimaMap($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function negara_penerima_top()
	{
		$this->mainlib->logged_in();
		$chart = $this->Peb_model->NegaraPenerimaBar($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// Halaman eksportir
	public function list_eksportir()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'eksportir';
		$data['content'] = 'peb_eksportir';
		$this->load->view('index', $data);
	}

	public function get_eksportir()
	{
		$this->mainlib->logged_in();
		$data = $this->Peb_eksportir_model->GetEksportirAll();
		header('Content-type:application/json');
		echo json_encode($data);
	}

}