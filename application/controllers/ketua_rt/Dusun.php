<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dusun extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'ketua_rt';

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

		$this->load->view('ketua_rt/v_dusun', $data);
	}

	public function get_all_rt() {
		$dusun_id = $this->input->post('dusun_id', TRUE);
		$data     = $this->m_dusun->get_join_all_where(['b.dusun_id' => $dusun_id])->result_array();
		echo json_encode($data);
	}
} 