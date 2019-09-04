<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Barkir extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib'));
	}

	// halaman impor statistik
	public function statistik()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'statistik';
		$data['content'] = 'barkir_statistik';
		$this->load->view('index', $data);
	}

	public function jalur_total()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->jalur_total($date);
		$chart = $this->Barkir_model->jalur_total_table($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function jalur()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->jalur($date);
		$chart = $this->Barkir_model->jalur_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function nilai_tonase()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->nilai_tonase($date);
		$chart = $this->Barkir_model->nilai_tonase_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function rata_nilai_tonase()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->nilai_tonase($date);
		$chart = $this->Barkir_model->rata_nilai_tonase_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function pjt()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->pjt($date);
		$chart = $this->Barkir_model->pjt_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function negara_pengirim()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->negara_pengirim($date);
		$chart = $this->Barkir_model->negara_pengirim_map($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function negara_pengirim_top()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_model');
		$date = $this->Barkir_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_model->negara_pengirim($date);
		$chart = $this->Barkir_model->negara_pengirim_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// halaman impor penerimaan
	public function penerimaan()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'penerimaan';
		$data['content'] = 'barkir_penerimaan';
		$this->load->view('index', $data);
	}

	public function penerimaan_total()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_penerimaan_model');
		$date = $this->Barkir_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_penerimaan_model->penerimaan_total($date);
		$chart = $this->Barkir_penerimaan_model->penerimaan_total_table($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function penerimaan_bulan()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_penerimaan_model');
		$date = $this->Barkir_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_penerimaan_model->penerimaan_bulan($date);
		$chart = $this->Barkir_penerimaan_model->penerimaan_bulan_line($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function penerimaan_top()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_penerimaan_model');
		$date = $this->Barkir_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_penerimaan_model->penerimaan_top($date);
		$chart = $this->Barkir_penerimaan_model->penerimaan_top_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function bm_top()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_penerimaan_model');
		$date = $this->Barkir_penerimaan_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_penerimaan_model->bm_top($date);
		$chart = $this->Barkir_penerimaan_model->bm_top_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// halaman impor dwelling time
	public function dwelling_time()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'dwelling_time';
		$data['content'] = 'barkir_dwelling_time';
		$this->load->view('index', $data);
	}

	public function dt_last()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$total = $this->Barkir_dwelling_time_model->dt_total_last();
		$jalur = $this->Barkir_dwelling_time_model->dt_jalur_last();
		$chart = $this->Barkir_dwelling_time_model->dt_last_table($total, $jalur);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_total()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_total($date);
		$chart = $this->Barkir_dwelling_time_model->dt_total_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_cn_re()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_cn_re_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_cn_hijau()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_cn_hijau_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_cn_merah_periksa()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_cn_merah_periksa_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_cn_merah_nonperiksa()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_cn_merah_nonperiksa_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_pibk_hijau()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_pibk_hijau_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_pibk_merah_periksa()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_pibk_merah_periksa_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	public function dt_pibk_merah_nonperiksa()
	{
		$this->mainlib->logged_in();
		$this->load->model('Barkir_dwelling_time_model');
		$date = $this->Barkir_dwelling_time_model->prep_date($_POST['start_date'], $_POST['end_date']);
		$data = $this->Barkir_dwelling_time_model->dt_jalur($date);
		$chart = $this->Barkir_dwelling_time_model->dt_pibk_merah_nonperiksa_bar($data);
		header('Content-type:application/json');
		echo json_encode($chart);
	}

	// //  halaman barang kiriman per pdtt
	// public function pdtt()
	// {
	// 	$this->mainlib->logged_in();
	// 	$this->mainlib->privilege();
	// 	$data['menus'] = $this->mainlib->menus();
	// 	$data['class'] = $this->router->fetch_class();
	// 	$data['hal'] = 'pdtt';
	// 	$data['content'] = 'barkir_pdtt';
	// 	$this->load->view('index', $data);
	// }

	// public function pdtt_jalur()
	// {
	// 	$this->mainlib->logged_in();
	// 	$this->load->model('Barkir_pdtt_model');
	// 	$date = $this->Barkir_pdtt_model->prep_date($_POST['start_date'], $_POST['end_date']);
	// 	$data = $this->Barkir_pdtt_model->jalur($_POST['id_pdtt'], $date);
	// 	$chart = $this->Barkir_pdtt_model->jalur_line($data);
	// 	header('Content-type:application/json');
	// 	echo json_encode($chart);
	// }

	// public function pdtt_penerimaan()
	// {
	// 	$this->mainlib->logged_in();
	// 	$this->load->model('Barkir_pdtt_model');
	// 	$date = $this->Barkir_pdtt_model->prep_date($_POST['start_date'], $_POST['end_date']);
	// 	$data = $this->Barkir_pdtt_model->penerimaan_bulan($_POST['id_pdtt'], $date);
	// 	$chart = $this->Barkir_pdtt_model->penerimaan_bulan_line($data);
	// 	header('Content-type:application/json');
	// 	echo json_encode($chart);
	// }

	// public function pdtt_detil()
	// {
	// 	$this->mainlib->logged_in();
	// 	$this->load->model('Barkir_pdtt_model');
	// 	$date = $this->Barkir_pdtt_model->prep_date($_POST['start_date'], $_POST['end_date']);
	// 	$data = $this->Barkir_pdtt_model->detil($_POST['id_pdtt'], $date);
	// 	$chart = $this->Barkir_pdtt_model->detil_table($data);
	// 	header('Content-type:application/json');
	// 	echo json_encode($chart);
	// }

	// public function pdtt_search()
	// {
	// 	$this->mainlib->logged_in();
	// 	$this->load->model('Barkir_pdtt_model');
	// 	$data = $this->Barkir_pdtt_model->search($_POST['pdtt']);
	// 	echo json_encode($data);
	// }

	// Halaman PDTT
	public function pdtt()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'pdtt';
		$data['content'] = 'barkir_pdtt';
		$this->load->view('index', $data);
	}

	public function pdtt_summary()
	{
		$this->load->model('Barkir_pdtt_model');
		$data = $this->Barkir_pdtt_model->GetSummary($_POST['jalur'], $_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

}