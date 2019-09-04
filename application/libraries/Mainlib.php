<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mainlib {

	public function logged_in(){
		$_this =& get_instance();
		if ($_this->session->userdata('login_status') != TRUE) {
			redirect(base_url('user/login'));
		}
	}

	public function file_upload_load(){
		$_this =& get_instance();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 100;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;

		$_this->load->library('upload', $config);
	}

	// check user privileges
	public function privilege() {
		$_this =& get_instance();
		$_this->load->model('User_model');
		$result = $_this->User_model->get_privsx();

		$r = [];
		foreach ($result as $key => $value) {
			$r[] = $value['menu_url'];
		}

		$class = $_this->router->fetch_class();
		$method = $_this->router->fetch_method();
		$x = $class . '/' . $method;

		if (in_array($x, $r)) {
			return true;
		} else {
			redirect('errorx');
		}
	}

	// generate menu
	public function menus() {
		$_this =& get_instance();
		$_this->load->model('User_model');
		$result = $_this->User_model->get_priv_menu();

		$privs = array();
		foreach ($result as $val) {
			if ($val['menu_parent']) {
		        $privs[$val['menu_parent']][$val['menu_child']] = $val['menu_url'];
		    }
		}

		$_this->load->library('MenuBuilder', $privs);
		$ul = new MenuBuilder($privs);

		return $ul;
	}
}