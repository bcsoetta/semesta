<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pib extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('mainlib'));
	}
	
	public function index()
	{
		$this->mainlib->logged_in();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'statistik';
		$data['content'] = 'pib';
		$this->load->view('index', $data);
	}

	// cek logged in user
	private function loggedUser()
	{
		$this->load->model('User_model');
		$user_id = $_SESSION['user_id'];
		$user = $this->User_model->get_user_detail_by_id($user_id);
		return $user->nip;
	}

	// Halaman penerimaan
	public function statistik()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'statistik';
		$data['content'] = 'pib_statistik';
		$this->load->view('index', $data);
	}

	public function jalur()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->jalur($date);
		$chart = $this->Pib_model->jalur_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function jalur_total()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->jalur_total($date);
		$chart = $this->Pib_model->jalur_total_table($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function nilai_tonase()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->nilai_tonase($date);
		$chart = $this->Pib_model->nilai_tonase_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function rata_nilai_tonase()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->nilai_tonase($date);
		$chart = $this->Pib_model->rata_nilai_tonase_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function importir()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->importir($date);
		$chart = $this->Pib_model->importir_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function negara_pemasok()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->negara_pemasok($date);
		$chart = $this->Pib_model->negara_pemasok_map($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function negara_pemasok_top()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_model');
		$date = $this->Pib_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_model->negara_pemasok($date);
		$chart = $this->Pib_model->negara_pemasok_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// Halaman penerimaan
	public function penerimaan()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'penerimaan';
		$data['content'] = 'pib_penerimaan';
		$this->load->view('index', $data);
	}

	public function penerimaan_total()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_penerimaan_model');
		$date = $this->Pib_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_penerimaan_model->penerimaan_total($date);
		$chart = $this->Pib_penerimaan_model->penerimaan_total_table($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function penerimaan_bulan()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_penerimaan_model');
		$date = $this->Pib_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_penerimaan_model->penerimaan_bulan($date);
		$chart = $this->Pib_penerimaan_model->penerimaan_bulan_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function penerimaan_top()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_penerimaan_model');
		$date = $this->Pib_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_penerimaan_model->penerimaan_top($date);
		$chart = $this->Pib_penerimaan_model->penerimaan_top_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function bm_top()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_penerimaan_model');
		$date = $this->Pib_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_penerimaan_model->bm_top($date);
		$chart = $this->Pib_penerimaan_model->bm_top_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// Halaman dwelling time
	public function dwelling_time()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'dwelling time';
		$data['content'] = 'pib_dwelling_time';
		$this->load->view('index', $data);
	}

	public function dt_last()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_dwelling_time_model');
		$total = $this->Pib_dwelling_time_model->dt_total_last();
		$jalur = $this->Pib_dwelling_time_model->dt_jalur_last();
		$chart = $this->Pib_dwelling_time_model->dt_last_table($total, $jalur);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_total()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_dwelling_time_model');
		$date = $this->Pib_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_dwelling_time_model->dt_total($date);
		$chart = $this->Pib_dwelling_time_model->dt_total_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_prioritas()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_dwelling_time_model');
		$date = $this->Pib_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_dwelling_time_model->dt_jalur($date);
		$chart = $this->Pib_dwelling_time_model->dt_prioritas_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_hijau()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_dwelling_time_model');
		$date = $this->Pib_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_dwelling_time_model->dt_jalur($date);
		$chart = $this->Pib_dwelling_time_model->dt_hijau_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_kuning()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_dwelling_time_model');
		$date = $this->Pib_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_dwelling_time_model->dt_jalur($date);
		$chart = $this->Pib_dwelling_time_model->dt_kuning_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_merah()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_dwelling_time_model');
		$date = $this->Pib_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Pib_dwelling_time_model->dt_jalur($date);
		$chart = $this->Pib_dwelling_time_model->dt_merah_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// Halaman impor atensi
	public function atensi()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'atensi';
		$data['content'] = 'pib_atensi';
		$this->load->view('index', $data);
	}

	public function atensi_master()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_atensi_model');
		$nip = $this->loggedUser();
		$data = $this->Pib_atensi_model->atensi_master($nip);
		$chart = $this->Pib_atensi_model->atensi_master_table($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function atensi_detil()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_atensi_model');
		$header = $this->Pib_atensi_model->atensi_header($_POST['car']);
		$barang = $this->Pib_atensi_model->atensi_detil($_POST);
		$data['header'] = $header[0];
		$data['barang'] = $this->Pib_atensi_model->atensi_detil_table($barang);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function tes()
	{
		$this->load->model('Pib_dwelling_time_model');
		$total = $this->Pib_dwelling_time_model->dt_total_last();
		$jalur = $this->Pib_dwelling_time_model->dt_jalur_last();
		$chart = $this->Pib_dwelling_time_model->dt_last_table($total, $jalur);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// Halaman pfpd
	public function pfpd()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'pfpd';
		$data['content'] = 'pib_pfpd';
		$this->load->view('index', $data);
	}

	public function pfpd_data()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_pfpd_model');
		$data = $this->Pib_pfpd_model->GetHit($_POST["jalur"], $_POST["start_date"], $_POST["end_date"]);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman importir
	public function list_importir()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'importir';
		$data['content'] = 'pib_importir';
		$this->load->view('index', $data);
	}

	public function get_importir()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_importir_model');
		$data = $this->Pib_importir_model->GetImportirAll();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman importir
	public function komoditi()
	{
		$this->mainlib->logged_in();
		// $this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'komoditi';
		$data['content'] = 'pib_komoditi';
		$this->load->view('index', $data);
	}

	public function get_komoditi()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_komoditi_model');
		$data = $this->Pib_komoditi_model->ChartsHs();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function get_komoditi_test()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_komoditi_model');
		$data = $this->Pib_komoditi_model->ChartsHs();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function get_komoditi_test2()
	{
		$this->mainlib->logged_in();
		$this->load->model('Pib_komoditi_model');
		$data = $this->Pib_komoditi_model->test2();
		header('Content-type:application/json');
		echo json_encode($data);
	}
}