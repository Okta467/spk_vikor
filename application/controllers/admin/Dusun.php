<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dusun extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'admin';

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

		$this->load->view('admin/v_dusun', $data);
	}

    public function store() {
        // Validasi input
        $nama_is_unique = true;
        $rules = $this->m_dusun->rules($nama_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/dusun');
        }

        $insert = $this->m_dusun->insert([
            'nama'   => $this->input->post('xnama', TRUE),
            'alamat' => $this->input->post('xalamat', TRUE),
        ]);

        !$insert
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
            
        redirect('admin/dusun');
    }

    public function update() {
        // Validasi input
        $dusun_id       = $this->input->post('xdusun_id', TRUE);
        $new_nama       = $this->input->post('xnama', TRUE);
        $current_dusun  = $this->m_dusun->get_by_id($dusun_id)->row();
        $nama_is_unique = $new_nama !== $current_dusun->nama;
        $rules          = $this->m_dusun->rules($nama_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/dusun');
        }

        $data_update_dusun = [
            'nama'   => $this->input->post('xnama', TRUE),
            'alamat' => $this->input->post('xalamat', TRUE),
        ];

        !$this->m_dusun->update($this->input->post('xdusun_id'), $data_update_dusun)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');

        redirect('admin/dusun');
    }

    public function destroy($dusun_id) {
        $dusun = $this->m_dusun->get_by_id($dusun_id)->row();
        
        if (!$dusun) {
            $this->session->set_flashdata('msg', 'Dusun tidak ditemukan!');
            redirect('admin/dusun');
        }

        !$this->m_dusun->delete($dusun_id)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');

        redirect('admin/dusun');
    }

    public function get_dusun_by_id() {
		$dusun_id = $this->input->post('dusun_id', TRUE);
		$data     = $this->m_dusun->get_by_id($dusun_id)->row_array();;
		echo json_encode($data);
    }

	public function get_all_rt() {
		$dusun_id = $this->input->post('dusun_id', TRUE);
		$data     = $this->m_dusun->get_join_all_where(['b.dusun_id' => $dusun_id])->result_array();
		echo json_encode($data);
	}
} 