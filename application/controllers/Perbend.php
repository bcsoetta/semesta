<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perbend extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib'));
		$this->load->model('Perbend_model');
	}

	public function piutang($value='')
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'piutang';
		$data['content'] = 'perbend_piutang';
		$this->load->view('index', $data);
	}

	public function piutang_total()
	{
		$this->mainlib->logged_in();
		$data = $this->Perbend_model->PiutangTotalTable($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function piutang_all()
	{
		$this->mainlib->logged_in();
		$data = $this->Perbend_model->PiutangAllChart($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function status_piutang()
	{
		$this->mainlib->logged_in();
		$data = $this->Perbend_model->StatusPiutangList($_POST['start_date'], $_POST['end_date']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function list_piutang()
	{
		$this->mainlib->logged_in();
		$data = $this->Perbend_model->ListPiutangTable($_POST);
		header('Content-type:application/json');
		echo json_encode($data);
	}

}