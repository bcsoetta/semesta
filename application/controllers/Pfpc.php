<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pfpc extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib'));

		// $this->load->model('Pfpc_perbaikan_pib_model');
		$this->load->model('Loket_model');
	}

	// Halaman perbaikan data PIB
	public function perbaikan_pib()
	{
		// $this->mainlib->logged_in();
		// $this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'perbaikan PIB';
		$data['content'] = 'pfpc_perbaikan_pib';
		$this->load->view('index', $data);
	}

	public function perbaikan_pib_browse()
	{
		$layanan = 'Perbaikan data PIB';
		$data = $this->Loket_model->GetDoksByLayanan($layanan);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman reekspor
	public function reekspor()
	{
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'reekspor';
		$data['content'] = 'pfpc_reekspor';
		$this->load->view('index', $data);
	}

	public function reekspor_browse()
	{
		$layanan = ['Reekspor eks impor sementara', 'Reekspor', 'Reekspor eks pengeluaran sebagian'];
		$data = [];
		foreach ($layanan as $key => $value) {
			$result = $this->Loket_model->GetDoksByLayanan($value);
			$data = array_merge($data, $result);
		}
		
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman pengeluaran sebagian
	public function pengeluaran_sebagian()
	{
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'pengeluaran sebagian';
		$data['content'] = 'pfpc_pengeluaran_sebagian';
		$this->load->view('index', $data);
	}

	public function pengeluaran_sebagian_browse()
	{
		$layanan = 'Pengeluaran Sebagian';
		$data = $this->Loket_model->GetDoksByLayanan($layanan);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman pembatalan PEB
	public function pembatalan_peb()
	{
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'pembatalan PEB';
		$data['content'] = 'pfpc_pembatalan_peb';
		$this->load->view('index', $data);
	}

	public function pembatalan_peb_browse()
	{
		$layanan = 'Pembatalan PEB';
		$data = $this->Loket_model->GetDoksByLayanan($layanan);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	// Halaman reimpor
	public function reimpor()
	{
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'reimpor';
		$data['content'] = 'pfpc_reimpor';
		$this->load->view('index', $data);
	}

	public function reimpor_browse()
	{
		$layanan = 'Reimpor';
		$data = $this->Loket_model->GetDoksByLayanan($layanan);
		header('Content-type:application/json');
		echo json_encode($data);
	}
}