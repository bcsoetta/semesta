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

}