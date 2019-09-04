<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manifest extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('mainlib'));
		$this->load->model('Manif_out_atensi_model');
	}

	public function mo_atensi()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'atensi outward';
		$data['content'] = 'mo_atensi';
		$this->load->view('index', $data);
	}

	public function DataAtensi()
	{
		$this->mainlib->logged_in();
		$chart = $this->Manif_out_atensi_model->TableAtensiOutward();
		header('Content-type:application/json');
		echo json_encode($chart);
	}

}