<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class P2 extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib'));

		$this->load->model('Terminal_model');
		$this->load->model('Terminal_komoditi_model');
		$this->load->model('Tanggal_model');
	}

	// Halaman penerimaan terminal
	public function terminal()
	{
		$this->mainlib->logged_in();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'penerimaan';
		$data['content'] = 'terminal';
		$this->load->view('index', $data);
	}

	public function terminal_penerimaan_all()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_model->PenerimaanPungutanPerBulanChart($date);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_penerimaan_total()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$query_result = $this->Terminal_model->PenerimaanPungutanTotal($date);
		foreach ($query_result as $key => $value) {
			if (in_array($key, array('bm', 'ppn', 'pph', 'ppnbm'))) {
				$data[$key] = number_format($value, 2, ',', '.');
			}
		}
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_penerimaan_dok_all()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_model->PenerimaanDokumenPerBulanChart($date);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_penerimaan_dok_total()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$query_result = $this->Terminal_model->PenerimaanDokumenTotal($date);
		foreach ($query_result as $key => $value) {
			$data[$value['dokumen']] = number_format($value['bm'], 2, ',', '.');
		}
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_jumlah_dok_total()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$query_result = $this->Terminal_model->JumlahDokumenTotal($date);
		foreach ($query_result as $key => $value) {
			$data[$value['dokumen']] = number_format($value['jml_dok'], 0, '', '.');
		}
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_jumlah_dok_bulan()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_model->JumlahDokumenPerBulanChart($date);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_penerimaan_berat()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_model->PenerimaanPungutanNettoChart($date);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_penerimaan_berat_detail()
	{
		$this->mainlib->logged_in();
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_model->PenerimaanPungutanNettoTable($date);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman kategori terminal
	public function terminal_komoditi()
	{
		$this->mainlib->logged_in();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'komoditi';
		$data['content'] = 'terminal_komoditi';
		$this->load->view('index', $data);
	}

	public function terminal_kategori()
	{
		$this->mainlib->logged_in();
		// $date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_model->SummaryKategoriHarianChart();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_komoditi_summary()
	{
		$this->mainlib->logged_in();
		// $_POST['start_date'] = null;
		// $_POST['end_date'] = null;
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_komoditi_model->SummaryKategoriTable($date);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_kategori_bulan()
	{
		$this->mainlib->logged_in();
		// $date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_komoditi_model->SummaryKategoriBulananChart($_POST['jenis']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function terminal_komoditi_detail()
	{
		$this->mainlib->logged_in();
		$_POST['start_date'] = null;
		$_POST['end_date'] = null;
		$date = $this->Tanggal_model->PrepFilterDate($_POST['start_date'], $_POST['end_date']);
		$data = $this->Terminal_komoditi_model->DetailKategoriBulananChart($date, $_POST['komoditi']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

}