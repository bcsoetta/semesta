<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Umum extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib', 'pagination'));

		$this->load->model('Umum_st_model');
		$this->load->model('Umum_sdm_model');
		$this->load->model('Umum_apps_model');
		$this->load->model('Penomoran_model');
		$this->load->model('Tanggal_model');
		$this->load->model('Angka_model');
		$this->load->model('Admin_model');
	}

	public function index() {
		echo "Index";
	}

	public function ppkp_update() {

		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$this->load->model('Umum_model');

		if (isset($_GET['pid'])) {
		    $ppkp_id = $_GET['pid'];
			$ff = $this->Umum_model->get_ppkp_by_id($ppkp_id);
			if (empty($ff)) {
				redirect(base_url('errorx'));
			}
		} else {
			redirect(base_url('errorx'));
		}
		
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['ppkp'] = $this->Umum_model->get_ppkp_by_id($ppkp_id);
		$data['hal'] = 'update PPKP';
		$data['content'] = 'ppkp_update';
		$this->load->view('index', $data);
	}

	public function ppkp_update_process() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data = $_POST;
		print_r($data);
		$this->load->model('Umum_model');
		$result = $this->Umum_model->ppkp_update_process($data);
		if ($result) {
			redirect(base_url('umum/ppkp_browse'));
		} else {
			redirect(base_url('umum/ppkp_create'));
		}
	}

	public function ppkp_create() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$this->load->model('Umum_model');
		$data['list_ppkp'] = $this->Umum_model->get_all_ppkp();
		$data['jum_ppkp'] = $this->Umum_model->get_jum_ppkp();
		$data['score'] = $this->Umum_model->ppkp_score_by_ppkp_id();
		$data['hal'] = 'create PPKP';
		$data['content'] = 'ppkp_create';
		$this->load->view('index', $data);
	}

	public function ppkp_create_process() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data = $_POST;
		$this->load->model('Umum_model');
		$result = $this->Umum_model->ppkp_create_process($data);
		if ($result) {
			redirect(base_url('umum/ppkp_browse'));
		} else {
			redirect(base_url('umum/ppkp_create'));
		}
		
	}

	public function ppkp_browse() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$this->load->model('Umum_model');
		$data['list_ppkp'] = $this->Umum_model->get_all_ppkp();
		$data['jum_ppkp'] = $this->Umum_model->get_jum_ppkp();
		$data['score'] = $this->Umum_model->ppkp_score_by_ppkp_id();
		$data['hal'] = 'browse PPKP';
		$data['content'] = 'ppkp_browse';
		$this->load->view('index', $data);
	}

	public function load_ppkp_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$tglawal = $_GET['tglawal'];
		if ($tglawal == "" OR $tglawal == "undefined" OR $tglawal == NULL) {
			$tglawal == "";
		} else {
			$tglawal = date('Y-m-d', strtotime($_GET['tglawal']));
		}

		$tglakhir = $_GET['tglakhir'];
		if ($tglakhir == "" OR $tglakhir == "undefined" OR $tglakhir == NULL) {
			$tglakhir == "";
		} else {
			$tglakhir = date('Y-m-d', strtotime($_GET['tglakhir']));
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$this->load->model('Umum_model');
		$allcount = $this->Umum_model->get_ppkp_for_paginate_count($search, $tglawal, $tglakhir);
		$users_record = $this->Umum_model->get_ppkp_for_paginate($rowno, $rowperpage, $search, $tglawal, $tglakhir);
		$ppkp_score = $this->Umum_model->ppkp_score_by_ppkp_id();

		// Pagination
		$config['base_url'] = base_url().'user/page';
		$config['reuse_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		$config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:20px; float: right;">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		// Initialize
		$this->pagination->initialize($config);

		// Initialize data array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['score'] = $ppkp_score;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	public function ppkp() {

		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$this->load->model('User_model');
		$this->load->model('Umum_model');

		if (isset($_GET['pid'])) {
		    $ppkp_id = $_GET['pid'];
			$ff = $this->Umum_model->get_ppkp_by_id($ppkp_id);
			if (empty($ff)) {
				redirect(base_url('errorx'));
			}
		} else {
			$ppkp_id = null;
		}

		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'PPKP';
		$data['content'] = 'ppkp_peserta';
		$data['ppkp'] = $this->Umum_model->get_ppkp_by_id($ppkp_id);
		$data['js'] = $this->User_model->get_user_status_count();
		$data['udata'] = $this->User_model->get_user_detail();
		$this->load->view('index', $data);
	}

	public function load_user_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$pid = $_GET['pid'];
		if ($pid == "" OR $pid == "undefined" OR $pid == NULL) {
			$pid == "";
		}

		$this->load->model('Umum_model');
		$allcount = $this->Umum_model->get_user_detail_for_paginate_count($search, $pid);
		$users_record = $this->Umum_model->get_user_detail_for_paginate($rowno, $rowperpage, $search, $pid);

		// Pagination
		$config['base_url'] = base_url().'user/page';
		$config['reuse_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		$config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:20px; float: right;">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		// Initialize
		$this->pagination->initialize($config);

		// Initialize data array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	// pagination
	public function load_privils_ref_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$pid = $_GET['pid'];
		if ($pid == "" OR $pid == "undefined" OR $pid == NULL) {
			$pid == "";
		}

		$this->load->model('Umum_model');
		$allcount = $this->Umum_model->get_privils_ref_detail_for_paginate_count($search);
		$users_record = $this->Umum_model->get_privils_ref_detail_for_paginate($rowno, $rowperpage, $search, $pid);
		// print_r($users_record);

		// Pagination
		$config['base_url'] = base_url().'umum/page';
		$config['reuse_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;

		$config['query_string_segment'] = 'start';
 
		$config['full_tag_open'] = '<nav><ul class="pagination" style="margin-top:20px; float: right;">';
		$config['full_tag_close'] = '</ul></nav>';
		 
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		 
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		 
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		 
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		// Initialize
		$this->pagination->initialize($config);

		// Initialize data array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;

		echo json_encode($data);
	}

	public function tambah_peserta_ppkp() {
		$pid = $_POST['pid'];
		$nama = $_POST['nama']; 
		$nip = $_POST['nip']; 
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->tambah_peserta_ppkp($pid, $nama, $nip);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function hapus_peserta_ppkp() {
		$pid = $_POST['pid'];
		$nama = $_POST['nama']; 
		$nip = $_POST['nip']; 
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->hapus_peserta_ppkp($pid, $nama, $nip);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function absen_tidak_hadir() {
		$tbid = $_POST['tbid'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->absen_tidak_hadir($tbid);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function absen_hadir() {
		$tbid = $_POST['tbid'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->absen_hadir($tbid);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function scoring() {
		$tbid = $_POST['tbid'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->scoring($tbid);
		
		if ($rem) {
			echo $rem;
		} else {
			echo '0';
		}
	}

	public function scoring_() {
		$tbid = $_POST['tbid'];
		$pre_test = $_POST['pre_test'];
		$post_test = $_POST['post_test'];
		$this->load->model('Umum_model');
		$rem = $this->Umum_model->scoring_($tbid, $pre_test, $post_test);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	// Surat tugas
	public function surat_tugas()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'Surat Tugas';
		$data['content'] = 'umum_st';
		$this->load->view('index', $data);
	}

	public function get_st_all()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_st_model->GetStAll();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function simpan_st()
	{
		$this->mainlib->logged_in();
		$tahun = date("Y");

		switch ($_POST['header']['jenis_st']) {
			case '1':
				$agenda = 'KPU.03';
				$jenis_st = 'KK';
				break;

			case '10':
				$agenda = 'KPU.03/BG.01';
				$jenis_st = 'KBU';
				break;
			
			default:
				$agenda = '';
				break;
		}

		$_POST['header']['jenis_st'] = $jenis_st;

		foreach ($_POST['pegawai'] as $p) {
			if (isset($_POST['header']['spd']) && $_POST['header']['spd'] == 1 && $_POST['header']['dipa'] == 1) {
				$no_spd = $this->Penomoran_model->GetNo('SPD', 'KPU.03', $tahun);
			} else {
				$no_spd = null;
			}

			$pegawai[] = [
				'id_pegawai' => $p,
				'no_spd' => $no_spd
			];

		}

		$_POST['pegawai'] = $pegawai;
		
		$no_st = $this->Penomoran_model->GetNo('ST', $agenda, $tahun);
		$this->Umum_st_model->SaveSt($_POST, $no_st);
		header('Content-type:application/json');
		echo json_encode($_POST);
	}

	public function edit_st()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_st_model->GetSt($_POST['id_st']);
		if ($data['st_header']->jenis_st == 'KK') {
			$id_jabatan = 1;
		} else {
			$id_jabatan = 10;
		}

		$current_pjb = $this->Admin_model->GetActivePejabat($data['st_header']->tanggal, $id_jabatan);
		if ($current_pjb[0]->id != $data['st_header']->id_pejabat) {
			$data['st_header']->diff_pjb = 1;
		} else {
			$data['st_header']->diff_pjb = 0;
		}

		$current_kbu = $this->Admin_model->GetActivePejabat($data['st_header']->tanggal, 10);
		if ($current_kbu[0]->id != $data['st_header']->id_pejabat_kbu) {
			$data['st_header']->diff_kbu = 1;
		} else {
			$data['st_header']->diff_kbu = 0;
		}

		$tgl_tugas_start = $this->Tanggal_model->ConvertTanggal($data['st_header']->tgl_tugas_start, '%d-%m-%Y');
		$tgl_tugas_end = $this->Tanggal_model->ConvertTanggal($data['st_header']->tgl_tugas_end, '%d-%m-%Y');

		$data['st_header']->tgl_tugas_start = $tgl_tugas_start;
		$data['st_header']->tgl_tugas_end = $tgl_tugas_end;
		
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function update_st()
	{
		$this->mainlib->logged_in();
		$tahun = date("Y");

		$st = $this->Umum_st_model->GetSt($_POST['header']['id_st']);

		$del_detail = [];

		foreach ($st['st_detail'] as $key => $value) {
			if (!in_array($value->id_pegawai, $_POST['pegawai'])) {
				$del_detail[] = $value->id_pegawai;
			}
		}

		foreach ($_POST['pegawai'] as $key => $value) {
			if (isset($_POST['header']['spd']) && $_POST['header']['spd'] == 1 && $_POST['header']['dipa'] == 1) {
				$cek_no_spd = $this->Umum_st_model->CekSpd($_POST['header']['id_st'], $value);
				if ($cek_no_spd != null) {
					$no_spd = $cek_no_spd;
				} else {
					$no_spd = $this->Penomoran_model->GetNo('SPD', 'KPU.03', $tahun);	
				}
			} else {
				$no_spd = null;
			}

			$new_detail[] = [
				'id_pegawai' => $value,
				'no_spd' => $no_spd
			];
		}

		$this->Umum_st_model->UpdateSt($_POST['header'], $new_detail, $del_detail);
	}

	public function delete_st()
	{
		$this->mainlib->logged_in();
		$this->Umum_st_model->DeleteSt($_POST['id_st']);
	}

	public function preview_st()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_st_model->GetSt($_GET['id_st']);

		$tgl_tugas = $this->Tanggal_model->ConvertRangeTanggal($data['st_header']->tgl_tugas_start, $data['st_header']->tgl_tugas_end);
		$tgl_st = $this->Tanggal_model->ConvertTanggal($data['st_header']->tanggal, '%d %B %Y');
		$wkt_tugas = $this->Tanggal_model->ConvertRangeWaktu($data['st_header']->wkt_tugas_start, $data['st_header']->wkt_tugas_end);

		$data['st_header']->tgl_tugas = $tgl_tugas;
		$data['st_header']->tgl_st = $tgl_st;
		$data['st_header']->wkt_tugas = $wkt_tugas;

		$this->load->view('umum_st_form_st', $data);
	}

	public function preview_spd()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_st_model->GetSt($_GET['id_st']);

		$tgl_tugas_start = strtotime($data['st_header']->tgl_tugas_start);
		$tgl_tugas_end = ($data['st_header']->tgl_tugas_end != null ? strtotime($data['st_header']->tgl_tugas_end) : strtotime($data['st_header']->tgl_tugas_start));
		$date_diff = (($tgl_tugas_end - $tgl_tugas_start) / (60*60*24)) + 1;
		$data['st_header']->hari = $this->Angka_model->terbilang($date_diff);

		$data['st_header']->tgl_tugas_start = $this->Tanggal_model->ConvertTanggal($data['st_header']->tgl_tugas_start, '%d %B %Y');
		$data['st_header']->tgl_tugas_end = (
			$data['st_header']->tgl_tugas_end == null ? 
			$data['st_header']->tgl_tugas_start :
			$this->Tanggal_model->ConvertTanggal($data['st_header']->tgl_tugas_end, '%d %B %Y') 
		);
		$data['st_header']->tgl_spd = $this->Tanggal_model->ConvertTanggal($data['st_header']->tanggal, '%d %B %Y');

		$this->load->view('umum_st_form_spd', $data);
	}

	public function get_pejabat()
	{
		$this->mainlib->logged_in();
		$pejabat = $this->Admin_model->GetActivePejabat($_POST['tanggal'], $_POST['jabatan']);
		$data = $pejabat[0];
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function cari_pegawai()
	{
		$this->mainlib->logged_in();
		$list = $this->Umum_st_model->GetPegawai($_POST['pegawai'], $_POST['exclude']);
		header('Content-type:application/json');
		echo json_encode($list);
	}

	public function st_search()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_st_model->AdvSearch($_POST, 'header');
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function st_export_xlsx()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_st_model->AdvSearch($_POST, 'detail');

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'JENIS ST')
			->setCellValue('B1', 'NO ST')
			->setCellValue('C1', 'TGL ST')
			->setCellValue('D1', 'HAL ST')
			->setCellValue('E1', 'MULAI TUGAS')
			->setCellValue('F1', 'AKHIR TUGAS')
			->setCellValue('G1', 'TEMPAT')
			->setCellValue('H1', 'KOTA')
			->setCellValue('I1', 'NO SPD')
			->setCellValue('J1', 'NIP PEGAWAI')
			->setCellValue('K1', 'NAMA PEGAWAI');
		$r = 2;
		foreach ($data as $key => $value) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$r, $value->jenis_st)
				->setCellValue('B'.$r, $value->no)
				->setCellValue('C'.$r, $value->tanggal)
				->setCellValue('D'.$r, $value->hal)
				->setCellValue('E'.$r, $value->tgl_tugas_start)
				->setCellValue('F'.$r, $value->tgl_tugas_end)
				->setCellValue('G'.$r, $value->tempat_tugas)
				->setCellValue('H'.$r, $value->kota_tugas)
				->setCellValue('I'.$r, $value->no_spd)
				->setCellValue('J'.$r, $value->nip)
				->setCellValue('K'.$r, $value->nama);
			$r++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'rekap_surat_tugas';
		 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output'); // download file
	}

	// Halaman Monitor Aplikasi
	public function aplikasi()
	{
		$this->mainlib->logged_in();
		$this->mainlib->privilege();

		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'Monitor Aplikasi';
		$data['content'] = 'umum_aplikasi';
		$this->load->view('index', $data);
	}

	public function list_apps()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_apps_model->GetAllApps($_POST);

		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function simpan_apps()
	{
		$this->mainlib->logged_in();
		$this->Umum_apps_model->SaveApp($_POST);
	}

	public function edit_apps()
	{
		$this->mainlib->logged_in();
		$data = $this->Umum_apps_model->GetAppById($_POST['id_data']);

		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function update_apps()
	{
		$this->mainlib->logged_in();
		$this->Umum_apps_model->UpdateApp($_POST);
	}

	public function delete_app()
	{
		$this->mainlib->logged_in();
		$this->Umum_apps_model->DeleteApp($_POST);
	}
}