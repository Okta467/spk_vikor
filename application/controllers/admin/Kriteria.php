<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'admin';

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
		$data['kriterias'] = $this->m_kriteria->get_all();

		$this->load->view('admin/v_kriteria', $data);
	}

    public function store() {
        // Validasi input
        $kode_is_unique = true;
        $rules          = $this->m_kriteria->rules($kode_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/kriteria');
        }

        $insert = $this->m_kriteria->insert([
            'kode'    => $this->input->post('xkode', TRUE),
            'nama'    => $this->input->post('xnama', TRUE),
            'atribut' => $this->input->post('xatribut', TRUE),
            'bobot'   => $this->input->post('xbobot', TRUE),
        ]);

        !$insert
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
            
        redirect('admin/kriteria');
    }

    public function update() {
        // Validasi input
        $new_kriteria_id  = $this->input->post('xkriteria_id', TRUE);
        $current_kriteria = $this->m_kriteria->get_by_id($new_kriteria_id)->row();
        $kode_is_unique   = $current_kriteria->id !== $new_kriteria_id;
        $rules            = $this->m_kriteria->rules($kode_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/kriteria');
        }

        $data_update_kriteria = [
            'kode'    => $this->input->post('xkode', TRUE),
            'nama'    => $this->input->post('xnama', TRUE),
            'atribut' => $this->input->post('xatribut', TRUE),
            'bobot'   => $this->input->post('xbobot', TRUE),
        ];

        !$this->m_kriteria->update($this->input->post('xkriteria_id'), $data_update_kriteria)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');

        redirect('admin/kriteria');
    }

    public function destroy($kriteria_id) {
        $kriteria = $this->m_kriteria->get_by_id($kriteria_id)->row();
        
        if (!$kriteria) {
            $this->session->set_flashdata('msg', 'Dusun tidak ditemukan!');
            redirect('admin/kriteria');
        }

        !$this->m_kriteria->delete($kriteria_id)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');

        redirect('admin/kriteria');
    }

    public function get_kriteria_by_id() {
		$kriteria_id = $this->input->post('kriteria_id', TRUE);
		$data        = $this->m_kriteria->get_by_id($kriteria_id)->row_array();;
		echo json_encode($data);
    }

	public function get_all_sub_kriteria() {
		$kriteria_id = $this->input->post('kriteria_id', TRUE);
		$data        = $this->m_sub_kriteria->get_where(['kriteria_id' => $kriteria_id])->result_array();
		echo json_encode($data);
	}
} 