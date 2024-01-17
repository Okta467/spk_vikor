<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_Kriteria extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'sekretaris_desa';

    public function __construct() {
        parent::__construct();
        // Redirect if user is not login or wrong access level
        $this->load->model('m_auth');
        if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
            redirect('auth/login');
        }

        $this->load->model('m_kriteria');
        $this->load->model('m_sub_kriteria');
        $this->load->helper('formatting_validation_errors');
    }

	public function index() {
		$data['kriterias']     = $this->m_kriteria->get_all();
		$data['sub_kriterias'] = $this->m_sub_kriteria->get_join_all();

		$this->load->view('sekretaris_desa/v_sub_kriteria', $data);
	}
} 