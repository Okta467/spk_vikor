<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
        $this->load->model('m_auth');

		// cek apakah sekarang sudah login?
		if ($this->m_auth->current_user()) {
			redirect($this->m_auth->current_access_level());
		}

        $this->load->view('depan/v_login');
    }
}