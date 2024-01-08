<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif extends CI_Controller {
	const CURRENT_ACCESS_LEVEL = 'kepala_dusun';

	public function __construct() {
		parent::__construct();
		// Redirect if user is not login or wrong access level
		$this->load->model('m_auth');
		if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
			redirect('auth/login');
		}

		$this->load->model('m_alternatif');
		$this->load->model('m_dusun');
		$this->load->model('m_rt');
		$this->load->model('m_user');
		$this->load->helper('formatting_validation_errors');
	}

	public function index() {
		$current_user           = $this->m_auth->current_user();
        $current_user_full_info = $this->m_user->get_join_all_where(['a.id' => $current_user->id])->row();
        $dusun_id               = $current_user_full_info->dusun_id;
        $dusun                  = $current_user_full_info->dusun;

        $data['user_dusun_id'] = $dusun_id;
        $data['user_dusun']    = $dusun;

		$data['alternatifs'] = $this->m_alternatif->get_join_all_where([
            'b.id' => $dusun_id,
        ]);

		$data['rts'] = $this->m_rt->get_where(['dusun_id' => $dusun_id])->result();

		$this->load->view('kepala_dusun/v_alternatif', $data);
	}

    public function store() {
        // Validasi input
		$kode_is_unique                = true;
		$kk_kepala_keluarga_is_unique  = true;
		$nik_kepala_keluarga_is_unique = true;
        $rules = $this->m_alternatif->rules($kode_is_unique, $kk_kepala_keluarga_is_unique, $nik_kepala_keluarga_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('kepala_dusun/alternatif');
        }

		$current_user           = $this->m_auth->current_user();
        $current_user_full_info = $this->m_user->get_join_all_where(['a.id' => $current_user->id])->row();
        $user_dusun_id          = $current_user_full_info->dusun_id;
        $input_dusun_id         = $this->input->post('xdusun_id', TRUE);

        if ($input_dusun_id !== $user_dusun_id) {
            $this->session->set_flashdata('msg', 'Dusun tidak sama dengan user saat ini!');
            redirect('ketua_rt/alternatif');
        }

        $insert = $this->m_alternatif->insert([
            'dusun_id'             => $this->input->post('xdusun_id', TRUE),
            'rt_id'                => $this->input->post('xrt_id', TRUE),
            'kode'                 => $this->input->post('xkode', TRUE),
            'kk_kepala_keluarga'   => $this->input->post('xkk_kepala_keluarga', TRUE),
            'nik_kepala_keluarga'  => $this->input->post('xnik_kepala_keluarga', TRUE),
            'nama_kepala_keluarga' => $this->input->post('xnama_kepala_keluarga', TRUE),
            'alamat'               => $this->input->post('xalamat_alternatif', TRUE),
        ]);

        !$insert
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
            
        redirect('kepala_dusun/alternatif');
    }

    public function update() {
        // Validasi input
		$kode_is_unique                = false;
		$kk_kepala_keluarga_is_unique  = false;
		$nik_kepala_keluarga_is_unique = false;
        $rules = $this->m_alternatif->rules($kode_is_unique, $kk_kepala_keluarga_is_unique, $nik_kepala_keluarga_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('kepala_dusun/alternatif');
        }

		$current_user           = $this->m_auth->current_user();
        $current_user_full_info = $this->m_user->get_join_all_where(['a.id' => $current_user->id])->row();
        $user_dusun_id          = $current_user_full_info->dusun_id;
        $input_dusun_id         = $this->input->post('xdusun_id', TRUE);

        if ($input_dusun_id !== $user_dusun_id) {
            $this->session->set_flashdata('msg', 'Dusun tidak sama dengan user saat ini!');
            redirect('ketua_rt/alternatif');
        }

        $data_update_alternatif = [
            'dusun_id'             => $this->input->post('xdusun_id', TRUE),
            'rt_id'                => $this->input->post('xrt_id', TRUE),
            'kode'                 => $this->input->post('xkode', TRUE),
            'kk_kepala_keluarga'   => $this->input->post('xkk_kepala_keluarga', TRUE),
            'nik_kepala_keluarga'  => $this->input->post('xnik_kepala_keluarga', TRUE),
            'nama_kepala_keluarga' => $this->input->post('xnama_kepala_keluarga', TRUE),
            'alamat'               => $this->input->post('xalamat_alternatif', TRUE),
        ];

        !$this->m_alternatif->update($this->input->post('xalternatif_id'), $data_update_alternatif)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');

        redirect('kepala_dusun/alternatif');
    }

    public function destroy($alternatif_id) {
        $alternatif = $this->m_alternatif->get_by_id($alternatif_id)->row();
        
        if (!$alternatif) {
            $this->session->set_flashdata('msg', 'Alternatif tidak ditemukan!');
            redirect('kepala_dusun/alternatif');
        }

		$current_user           = $this->m_auth->current_user();
        $current_user_full_info = $this->m_user->get_join_all_where(['a.id' => $current_user->id])->row();
        $user_dusun_id          = $current_user_full_info->dusun_id;

        if ($alternatif->dusun_id !== $user_dusun_id) {
            $this->session->set_flashdata('msg', 'Dusun tidak sama dengan user saat ini!');
            redirect('ketua_rt/alternatif');
        }
        
        !$this->m_alternatif->delete($alternatif_id)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');
            
        redirect('kepala_dusun/alternatif');
    }

	public function get_alternatif_by_id() {
		$alternatif_id = $this->input->post('alternatif_id', TRUE);
		$data          = $this->m_alternatif->get_join_all_where(['a.id' => $alternatif_id])->row_array();
		echo json_encode($data);
	}
}
