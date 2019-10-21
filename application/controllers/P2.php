<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class P2 extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib'));

		$this->load->model('Terminal_model');
		$this->load->model('Tanggal_model');
	}

	// Halaman penerimaan terminal
	public function terminal_penerimaan()
	{
		$this->mainlib->logged_in();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'penerimaan terminal';
		$data['content'] = 'terminal_penerimaan';
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
			$data[$key] = number_format($value, 2, ',', '.');
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

}