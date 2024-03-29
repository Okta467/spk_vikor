<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_Kriteria extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'kepala_desa';

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

		$this->load->view('kepala_desa/v_sub_kriteria', $data);
	}

    public function store() {
        $kriteria_id            = $this->input->post("xkriteria_id", TRUE);
        $nama_sub_kriteria      = $this->input->post('xnama', TRUE);
        $where                  = "a.kriteria_id = {$kriteria_id} AND a.nama = '{$nama_sub_kriteria}'";
        $is_sub_kriteria_exists = $this->m_sub_kriteria->get_join_all_where($where)->row();
        $nama_kriteria          = $is_sub_kriteria_exists->nama_kriteria ?? null;

        // Cek ketersediaan nama sub kriteria pada kriteria yang dipilih
        if ($is_sub_kriteria_exists) {
            $this->session->set_flashdata('msg', "Nama Sub Kriteria <b>{$nama_sub_kriteria}</b> sudah ada untuk <b>{$nama_kriteria}</b>!");
            redirect('kepala_desa/Sub_Kriteria');
        }

        // Validasi input
        $rules = $this->m_sub_kriteria->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('kepala_desa/Sub_Kriteria');
        }

        $insert = $this->m_sub_kriteria->insert([
            'kriteria_id' => $this->input->post('xkriteria_id', TRUE),
            'kode'        => $this->input->post('xkode', TRUE),
            'nama'        => $this->input->post('xnama', TRUE),
            'skor'        => $this->input->post('xskor', TRUE),
        ]);

        !$insert
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
            
        redirect('kepala_desa/Sub_Kriteria');
    }

    public function update() {
        $new_kriteria_id      = $this->input->post('xkriteria_id', TRUE);
        $sub_kriteria_id      = $this->input->post('xsub_kriteria_id', TRUE);
        $nama_sub_kriteria    = $this->input->post('xnama', TRUE);
        $current_sub_kriteria = $this->m_sub_kriteria->get_by_id($sub_kriteria_id)->row();

        // Cek sub kriteria saat ini sama/tidak dengan di db
        if ($new_kriteria_id !== $current_sub_kriteria->kriteria_id) {
            $where                       = "a.kriteria_id = {$new_kriteria_id} AND b.nama = {$nama_sub_kriteria}";
            $is_nama_sub_kriteria_exists = $this->m_sub_kriteria->get_join_all_where($where)->row();
            $nama_kriteria               = $is_nama_sub_kriteria_exists->nam_kriteria;
    
            // Cek ketersediaan nama sub kriteria pada kriteria yang dipilih
            if ($is_nama_sub_kriteria_exists) {
                $this->session->set_flashdata('msg', "Nama Sub Kriteria <b>{$nama_sub_kriteria}</b> sudah ada untuk kriteria <b>{$nama_kriteria}</b>!");
                redirect('kepala_desa/Sub_Kriteria');
            }
        }

        // Validasi input
        $rules = $this->m_sub_kriteria->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('kepala_desa/Sub_Kriteria');
        }

        $data_update_sub_kriteria = [
            'kriteria_id' => $this->input->post('xkriteria_id', TRUE),
            'kode'        => $this->input->post('xkode', TRUE),
            'nama'        => $this->input->post('xnama', TRUE),
            'skor'        => $this->input->post('xskor', TRUE),
        ];

        !$this->m_sub_kriteria->update($this->input->post('xsub_kriteria_id'), $data_update_sub_kriteria)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');

        redirect('kepala_desa/Sub_Kriteria');
    }

    public function destroy($sub_kriteria_id) {
        $sub_kriteria = $this->m_sub_kriteria->get_by_id($sub_kriteria_id)->row();
        
        if (!$sub_kriteria) {
            $this->session->set_flashdata('msg', 'Sub Kriteria tidak ditemukan!');
            redirect('kepala_desa/Sub_Kriteria');
        }

        !$this->m_sub_kriteria->delete($sub_kriteria_id)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');

        redirect('kepala_desa/Sub_Kriteria');
    }

    public function get_sub_kriteria_by_id() {
		$sub_kriteria_id = $this->input->post('sub_kriteria_id', TRUE);
		$data            = $this->m_sub_kriteria->get_by_id($sub_kriteria_id)->row_array();;
		echo json_encode($data);
    }
} 