<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('m_auth');
	}

	public function index() {
		show_404();
	}

	public function login() {
		// cek apakah sekarang sudah login?
		if ($this->m_auth->current_user()) {
			redirect($this->m_auth->current_access_level());
		}

		$rules = $this->m_auth->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE) {
			redirect(base_url());
		}

		$username = $this->input->post('xusername');
		$password = $this->input->post('xpassword');

		if ($this->m_auth->login($username, $password)) {
			redirect($this->m_auth->current_access_level());
		} else {
			$this->session->set_flashdata('message_login_error', 'Pastikan Username dan Password benar!');
		}

		redirect(base_url());
	}

	public function logout() {
		$this->m_auth->logout();
		redirect(base_url());
	}
}
