<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rt extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'sekretaris_desa';

    public function __construct() {
        parent::__construct();
        // Redirect if user is not login or wrong access level
        $this->load->model('m_auth');
        if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
            redirect('auth/login');
        }

        $this->load->model('m_dusun');
        $this->load->model('m_rt');
        $this->load->helper('formatting_validation_errors');
    }

	public function index() {
		$data['dusuns'] = $this->m_dusun->get_all();
		$data['rts']    = $this->m_rt->get_join_all();

		$this->load->view('sekretaris_desa/v_rt', $data);
	}
} 