<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rt extends CI_Controller {
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
		$data['rts']    = $this->m_rt->get_join_all();

		$this->load->view('admin/v_rt', $data);
	}

    public function store() {
        $dusun_id          = $this->input->post('xdusun_id', TRUE);
        $nama_rt           = $this->input->post('xnama', TRUE);
        $where             = "a.dusun_id = {$dusun_id} AND a.nama = {$nama_rt}";
        $is_nama_rt_exists = $this->m_rt->get_join_all_where($where)->row();
        $nama_dusun        = $is_nama_rt_exists->dusun ?? null;

        // Cek ketersediaan nama RT pada dusun yang dipilih
        if ($is_nama_rt_exists) {
            $this->session->set_flashdata('msg', "Nama RT <b>{$nama_rt}</b> sudah ada untuk <b>{$nama_dusun}</b>!");
            redirect('admin/rt');
        }

        // Validasi input
        $rules = $this->m_rt->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/rt');
        }

        $insert = $this->m_rt->insert([
            'dusun_id' => $this->input->post('xdusun_id', TRUE),
            'nama'     => $this->input->post('xnama', TRUE),
            'alamat'   => $this->input->post('xalamat', TRUE),
        ]);

        !$insert
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
            
        redirect('admin/rt');
    }

    public function update() {
        $dusun_id = $this->input->post('xdusun_id', TRUE);
        $rt_id    = $this->input->post('xrt_id', TRUE);
        $nama_rt  = $this->input->post('xnama', TRUE);
        $rt       = $this->m_rt->get_by_id($rt_id)->row();

        // Cek dusun yg dipilih saat ini sama/tidak dengan di db
        if ($dusun_id !== $rt->dusun_id) {
            $where             = "a.dusun_id = {$dusun_id} AND a.nama = {$nama_rt}";
            $is_nama_rt_exists = $this->m_rt->get_join_all_where($where)->row();
            $nama_dusun        = $is_nama_rt_exists->dusun ?? null;
    
            // Cek ketersediaan nama RT pada dusun yang dipilih
            if ($is_nama_rt_exists) {
                $this->session->set_flashdata('msg', "Nama RT <b>{$nama_rt}</b> sudah ada untuk <b>{$nama_dusun}</b>!");
                redirect('admin/rt');
            }
        }

        // Validasi input
        $rules = $this->m_rt->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/rt');
        }

        $data_update_rt = [
            'dusun_id' => $this->input->post('xdusun_id', TRUE),
            'nama'     => $this->input->post('xnama', TRUE),
            'alamat'   => $this->input->post('xalamat', TRUE),
        ];

        !$this->m_rt->update($this->input->post('xrt_id'), $data_update_rt)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');

        redirect('admin/rt');
    }

    public function destroy($dusun_id) {
        $dusun = $this->m_rt->get_by_id($dusun_id)->row();
        
        if (!$dusun) {
            $this->session->set_flashdata('msg', 'RT tidak ditemukan!');
            redirect('admin/rt');
        }

        !$this->m_rt->delete($dusun_id)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');

        redirect('admin/rt');
    }

    public function get_rt_by_id() {
		$rt_id = $this->input->post('rt_id', TRUE);
		$data  = $this->m_rt->get_by_id($rt_id)->row_array();;
		echo json_encode($data);
    }
} 