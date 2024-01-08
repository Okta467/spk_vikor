<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'ketua_rt';

    public function __construct() {
        parent::__construct();
        // Redirect if user is not login or wrong access level
        $this->load->model('m_auth');
        if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
            redirect('auth/login');
        }

        $this->load->model('m_kriteria');
        $this->load->model('m_sub_kriteria');
    }

	public function index() {
		$data['kriterias'] = $this->m_kriteria->get_all();

		$this->load->view('ketua_rt/v_kriteria', $data);
	}

	public function get_all_sub_kriteria() {
		$kriteria_id = $this->input->post('kriteria_id', TRUE);
		$data        = $this->m_sub_kriteria->get_where(['kriteria_id' => $kriteria_id])->result_array();
		echo json_encode($data);
	}
} 