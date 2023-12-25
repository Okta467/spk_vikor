<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Role extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('m_user_role');
	}

	public function index() {
        $data['user_roles'] = $this->m_user_role->get_all();

		$this->load->view('admin/v_user_role', $data);
	}
}