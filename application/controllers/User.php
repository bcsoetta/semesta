<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->library(array('mainlib', 'pagination'));
	}

	public function index() {
		redirect('user/browse');
	}

	public function browse() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$this->load->model('User_model');
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'browse';
		$data['content'] = 'user_browse';
		$data['jr'] = $this->User_model->get_user_role_count();
		$data['js'] = $this->User_model->get_user_status_count();
		$data['udata'] = $this->User_model->get_user_detail();
		$this->load->view('index', $data);
	}

	public function get_user_role_count() {
		$this->mainlib->logged_in();
		$this->load->model('User_model');
		$data['jr'] = $this->User_model->get_user_role_count();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'browse';
		$data['content'] = 'user_browse';
		$data['udata'] = $this->User_model->get_user_detail();
		$this->load->view('index', $data);

	}

	public function profile() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$user_id = $_SESSION['user_id'];
		$this->load->model('User_model');
		$data['udata'] = $this->User_model->get_user_detail_by_id($user_id);
		$data['content'] = 'profile';
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'profile';
		$this->load->view('index', $data);
	}

	public function privil4() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$user_id = $_GET['uid'];
		$this->load->model('User_model');
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'privileges';
		$data['content'] = 'user_privil';
		$data['jr'] = $this->User_model->get_user_role_count();
		$data['js'] = $this->User_model->get_user_status_count();
		$data['udata'] = $this->User_model->get_user_detail();
		$data['user'] = $this->User_model->get_user_detail_by_id($user_id);
		$this->load->view('index', $data);
	}

	public function privil4_disable() {
		$uid = $_POST['uid'];
		$menu_id = $_POST['menu_id']; 
		$this->load->model('User_model');
		$rem = $this->User_model->privil4_disable($uid, $menu_id);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function privil4_activate() {
		$uid = $_POST['uid'];
		$menu_id = $_POST['menu_id']; 
		$this->load->model('User_model');
		$rem = $this->User_model->privil4_activate($uid, $menu_id);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function privil4_enable() {
		$uid = $_POST['uid'];
		$menu_id = $_POST['menu_id']; 
		$this->load->model('User_model');
		$rem = $this->User_model->privil4_enable($uid, $menu_id);
		
		if ($rem) {
			echo '1';
		} else {
			echo '0';
		}
	}

	// pagination
	public function load_privils_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$uid = $_GET['uid'];
		if ($uid == "" OR $uid == "undefined" OR $uid == NULL) {
			$uid == "";
		}

		$this->load->model('User_model');
		$allcount = $this->User_model->get_privils_detail_for_paginate_count($search, $uid);
		$users_record = $this->User_model->get_privils_detail_for_paginate($rowno, $rowperpage, $search, $uid);

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

		$uid = $_GET['uid'];
		if ($uid == "" OR $uid == "undefined" OR $uid == NULL) {
			$uid == "";
		}

		$this->load->model('User_model');
		$allcount = $this->User_model->get_privils_ref_detail_for_paginate_count($search);
		$users_record = $this->User_model->get_privils_ref_detail_for_paginate($rowno, $rowperpage, $search, $uid);

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
	public function load_user_for_pagination($rowno = 0) {
		$search = $_GET['search'];
		if ($search == "" OR $search == "undefined" OR $search == NULL) {
			$search == "";
		}

		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		$this->load->model('User_model');
		$allcount = $this->User_model->get_user_detail_for_paginate_count($search);
		$users_record = $this->User_model->get_user_detail_for_paginate($rowno, $rowperpage, $search);

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

	// register
	protected $username_temp;

	public function register() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required|matches[password]');
		$this->form_validation->set_rules('nip', 'Nip', 'required|callback_nip_check');

		$this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
		$this->form_validation->set_message('min_length', 'kurang dari 5 digit');
		$this->form_validation->set_message('matches', 'password tidak sama');
		$this->form_validation->set_error_delimiters('<span class="reginfo">&nbsp; Notif: &nbsp;','</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['content'] = 'form_register';
			$data['class'] = $this->router->fetch_class();
			$data['hal'] = 'register';
			$this->load->view('index', $data);
		}
		else {
			$this->load->model('User_model');
			$this->User_model->user_register($this->input->post(NULL,TRUE));
			redirect(base_url('user/browse'));
		}
		
	}

	public function nip_check($str) {
		$this->load->model('User_model');
		if ($this->User_model->exist_row_check('nip', $str) > 0) {
			$this->form_validation->set_message('nip_check', 'sudah terdaftar');
			return FALSE;
		} 
		else {
			return TRUE;
		}
	}

	public function username_check($str) {
		$this->load->model('User_model');
		if ($this->User_model->exist_row_check('username', $str) > 0) {
			$this->form_validation->set_message('username_check', 'sudah terdaftar');
			return FALSE;
		} 
		else {
			return TRUE;
		}
	}	

	// ubah password
	public function upassw() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required|matches[password]');

		$this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
		$this->form_validation->set_message('min_length', 'Kurang dari 5 digit');
		$this->form_validation->set_message('matches', 'Password tidak sama');
		$this->form_validation->set_error_delimiters('<span class="reginfo">','</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['hal'] = 'password';
			$data['content'] = 'password';
			$data['class'] = $this->router->fetch_class();
			$this->load->view('index', $data);
		}
		else {
			$this->load->model('User_model');
			$this->User_model->user_upassw($this->input->post(NULL,TRUE));
			redirect(base_url('user/logout'));
		}
		
	}

	// update akun
	public function update() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$user_id = $_GET['uid'];
		$this->load->model('User_model');
		$data['udata'] = $this->User_model->get_user_detail_by_id($user_id);
		$data['content'] = 'form_update';
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'update';
		$this->load->view('index', $data);
	}

	public function update_process() {
		$this->mainlib->logged_in();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_username_update_check');
		$this->form_validation->set_rules('nip', 'Nip', 'required|callback_nip_update_check');

		$this->form_validation->set_message('required', '{field} masih kosong, silahkan diisi');
		$this->form_validation->set_error_delimiters('<span class="reginfo">&nbsp; Notif: &nbsp;','</span>');

		if ($this->form_validation->run() == FALSE) {
			$this->mainlib->logged_in();
			$data['menus'] = $this->mainlib->menus();
			$user_id = $_POST['user_id'];
			$this->load->model('User_model');
			$data['udata'] = $this->User_model->get_user_detail_by_id($user_id);
			$data['content'] = 'form_update';
			$data['class'] = $this->router->fetch_class();
			$data['hal'] = 'update';
			$this->load->view('index', $data);
		}
		else {
			$this->load->model('User_model');
			$this->User_model->user_update($this->input->post(NULL,TRUE));
			redirect(base_url('user/browse'));
		}
		
	}

	public function username_update_check($str) {
		$uid = $this->input->post('user_id');
		$this->load->model('User_model');
		if ($this->User_model->exist_row_check_update('username', $uid, $str) > 0) {
			$this->form_validation->set_message('username_update_check', 'sudah terdaftar');
			return false;
		} 
		else {
			return true;
		}
	}	

	public function nip_update_check($str) {
		$uid = $this->input->post('user_id');
		$this->load->model('User_model');
		if ($this->User_model->exist_row_check_update('nip', $uid, $str) > 0) {
			$this->form_validation->set_message('nip_update_check', 'sudah terdaftar');
			return false;
		} 
		else {
			return true;
		}
	}

	// login
	public function login() {
		$this->load->library('form_validation');
		$input = $this->input->post(NULL,TRUE);
		$this->username_temp = @$input['username'];

		$this->form_validation->set_rules('username', 'Username', 'required|callback_usernamex_check');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_password_check');

		if ($this->form_validation->run() == FALSE) {
			$uinfo = form_error('username');
			$pinfo = form_error('password');

			$data['loginfo'] = "";
			if ($uinfo !== "") {
				$data['loginfo'] = $uinfo;
			} else {
				$data['loginfo'] = $pinfo;
			}
			$this->load->view('auth', $data);
		} 
		else {
			$this->load->model('User_model');
			$user_detail = $this->User_model->get_user_detail_by_username($this->username_temp);
			$session_data = array(
				'user_id' => $user_detail['user']['user_id'],
				'username' => $user_detail['user']['username'],
				'name' => $user_detail['user']['name'],
				'nip' => $user_detail['user']['nip'],
				'role' => $user_detail['user']['role'],
				'login_status' => TRUE
			);

			$this->session->set_userdata($session_data);
			session_write_close();

			redirect(base_url('dashboard'));
		}
		
	}

	public function usernamex_check($str) {
		$this->load->model('User_model');
		if ($this->User_model->exist_row_check('username', $str) > 0) {
			return TRUE;
		} 
		else {
			$this->form_validation->set_message('usernamex_check', 'Username dan/atau password tidak sesuai, silahkan coba lagi.');
			return FALSE;
		}
	}

	public function password_check($str) {
		$this->load->model('User_model');
		$user_detail = $this->User_model->get_user_detail_by_username($this->username_temp);
		if ($user_detail) {
			if ($user_detail['user']['password'] == crypt($str,$user_detail['user']['password'])) {
				return TRUE;
			} 
			else {
				$this->form_validation->set_message('password_check','Password tidak sesuai, silahkan coba lagi.');
				return FALSE;
			}
		}
	}

	public function logout() {
		$this->mainlib->logged_in();
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect(base_url('user/login'));
	}

	public function log() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'log';
		$data['content'] = 'user_log';
		$this->load->view('index', $data);
	}

	public function info() {
		$this->mainlib->logged_in();
		$this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'info';
		$data['content'] = 'info';
		$this->load->view('index', $data);
	}

	// Halaman setting feature
	public function feature()
	{
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'aplikasi';
		$data['content'] = 'priv_feature';
		$this->load->view('index', $data);
	}

	public function feature_list()
	{
		$this->load->model('User_feature_model');
		$data = $this->User_feature_model->GetAllFeature();
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function feature_save()
	{
		$fitur = $_POST['nama-fitur'];
		$this->load->model('User_feature_model');
		$m = $this->User_feature_model->SaveFeature($fitur);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	public function feature_show()
	{
		$id = $_POST['id'];
		$this->load->model('User_feature_model');
		$data = $this->User_feature_model->GetFeatureById($id);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function feature_update()
	{
		$this->load->model('User_feature_model');
		$m = $this->User_feature_model->UpdateFeature($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	public function subfeature_list()
	{
		$this->load->model('User_feature_model');
		$data = $this->User_feature_model->GetAllSubFeatureById($_POST['id']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function subfeature_save()
	{
		$this->load->model('User_feature_model');
		$m = $this->User_feature_model->SaveSubFeature($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	public function subfeature_update()
	{
		$this->load->model('User_feature_model');
		$m = $this->User_feature_model->UpdateSubFeature($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	// Halaman setting role
	public function role()
	{
		$data['menus'] = $this->mainlib->menus();
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'role';
		$data['content'] = 'priv_role';
		$this->load->view('index', $data);
	}

	public function role_list_unused()
	{
		$this->load->model('User_role_model');
		$data = $this->User_role_model->GetUnusedRoleByAppId($_POST['app_id']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function role_list_used()
	{
		$data = [];
		$this->load->model('User_role_model');
		$result = $this->User_role_model->GetUsedRoleByAppId($_POST['app_id']);
		foreach ($result as $key => $value) {
			$features = explode(',', $value['feature']);
			$data[] = [
				'id' => $value['id'],
				'role' => $value['role'],
				'features' => $features
			];
		};
		header('Content-type:application/json');
		echo json_encode($data, JSON_UNESCAPED_SLASHES);
	}

	public function role_save()
	{
		$this->load->model('User_role_model');
		$m = $this->User_role_model->SaveRole($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	public function role_feature_save()
	{
		$this->load->model('User_role_model');
		$m = $this->User_role_model->SaveRoleFeature($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	public function role_feature_list()
	{
		$this->load->model('User_role_model');
		$this->load->model('User_feature_model');
		$active_features = $this->User_role_model->GetRoleFeatures($_POST['app_id'], $_POST['role_id']);
		$all_features = $this->User_feature_model->GetAllSubFeatureById($_POST['app_id']);
		$active_features_id = [];
		foreach ($active_features as $key => $value) {
			$active_features_id[] = $value['feature_id'];
		}
		for ($i=0; $i < count($all_features); $i++) { 
			if (in_array($all_features[$i]['id'], $active_features_id)) {
				$all_features[$i]['selected'] = 1;
			} else {
				$all_features[$i]['selected'] = 0;
			}
		}
		$data = $all_features;
		header('Content-type:application/json');
		echo json_encode($data);	
	}

	public function role_feature_update()
	{
		$this->load->model('User_role_model');
		$m = $this->User_role_model->UpdateRoleFeature($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

	// Halaman setting privilege
	public function privilege()
	{
		$this->mainlib->logged_in();
		// $this->mainlib->privilege();
		$data['menus'] = $this->mainlib->menus();
		$user_id = $_GET['uid'];
		$this->load->model('User_model');
		$this->load->model('User_priv_model');
		$data['class'] = $this->router->fetch_class();
		$data['hal'] = 'privileges';
		// $data['content'] = 'priv_user';
		$data['content'] = 'user_privil';
		$data['user'] = $this->User_model->get_user_detail_by_id($user_id);
		$this->load->view('index', $data);
	}

	public function user_privilege_list()
	{
		$this->load->model('User_priv_model');
		$data = $this->User_priv_model->GetPrivilegesByUser($_POST['uid']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function user_unregistered_app()
	{
		$this->load->model('User_priv_model');
		$data = $this->User_priv_model->GetUnregisteredAppsByUser($_POST['uid']);
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function role_list_by_app()
	{
		$this->load->model('User_role_model');
		$data = $this->User_role_model->GetUsedRoleByAppId($_POST['app_id']);
		for ($i=0; $i < count($data); $i++) { 
			unset($data[$i]['feature']);
		}
		header('Content-type:application/json');
		echo json_encode($data);
	}

	public function user_privilege_save()
	{
		$this->load->model('User_priv_model');
		$m = $this->User_priv_model->SaveUserPrivilege($_POST);
		header('Content-type:application/json');
		echo json_encode($m);
	}

}