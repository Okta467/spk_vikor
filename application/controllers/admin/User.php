<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'admin';

    public function __construct() {
        parent::__construct();
        // Redirect if user is not login or wrong access level
        $this->load->model('m_auth');
        if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
            redirect('auth/login');
        }

        $this->load->model('m_user');
        $this->load->model('m_dusun');
        $this->load->model('m_rt');
        $this->load->helper('formatting_validation_errors');
    }

	public function index() {
		$data['users']  = $this->m_user->get_join_all();
		$data['dusuns'] = $this->m_dusun->get_all();
        
		$this->load->view('admin/v_user', $data);
	}

    public function store() {
        $hak_akses = $this->input->post('xhak_akses', TRUE);

        // redirect jika hak_akses tidak sesuai
        if (!in_array($hak_akses, ['admin','kepala_desa','sekretaris_desa','bendahara_desa','kasi_kesejahteraan_sosial','kepala_dusun','ketua_rt'])) {
            $this->session->set_flashdata('msg', 'Hak akses tidak ada!');
            redirect('admin/user');
        }

        // jika bukan kepala_desa dan ketua_rt
        // kosongkan value dusun_id dan rt, lalu set required (untuk validasi form) ke false
        if (!in_array($hak_akses, ['kepala_dusun','ketua_rt'])) {
            $dusun_id_is_required = false;
            $rt_id_is_required    = false;
            
            $dusun_id = NULL;
            $rt_id    = NULL;
        } else {
            $dusun_id_is_required = true;
            $rt_id_is_required    = true;

            $dusun_id = $this->input->post('xdusun_id', TRUE);
            $rt_id    = $this->input->post('xrt_id', TRUE);
        }

        // Validasi input
        $rules = $this->m_user->rules($dusun_id_is_required, $rt_id_is_required);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/user');
        }

        $insert = $this->m_user->insert([
            'dusun_id'     => $dusun_id,
            'rt_id'        => $rt_id,
            'nama_pemilik' => $this->input->post('xnama_pemilik', TRUE),
            'username'     => $this->input->post('xusername', TRUE),
            'password'     => password_hash($this->input->post('xpassword', TRUE), PASSWORD_DEFAULT),
            'hak_akses'    => $this->input->post('xhak_akses', TRUE),
        ]);

        !$insert
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
            
        redirect('admin/user');
    }

    public function update() {
        $hak_akses = $this->input->post('xhak_akses', TRUE);

        // redirect jika hak_akses tidak sesuai
        if (!in_array($hak_akses, ['admin','kepala_desa','sekretaris_desa','bendahara_desa','kasi_kesejahteraan_sosial','kepala_dusun','ketua_rt'])) {
            $this->session->set_flashdata('msg', 'Hak akses tidak ada!');
            redirect('admin/user');
        }

        // jika bukan kepala_desa dan ketua_rt
        // kosongkan value dusun_id dan rt, lalu set required (untuk validasi form) ke false
        if (!in_array($hak_akses, ['kepala_dusun','ketua_rt'])) {
            $dusun_id_is_required = false;
            $rt_id_is_required    = false;
            $password_is_required = false;
            
            $dusun_id = NULL;
            $rt_id    = NULL;
        } else {
            $dusun_id_is_required = true;
            $rt_id_is_required    = true;
            $password_is_required = false;

            $dusun_id = $this->input->post('xdusun_id', TRUE);
            $rt_id    = $this->input->post('xrt_id', TRUE);
        }

        $user_id      = $this->input->post('xuser_id');
        $current_user = $this->m_user->get_by_id($user_id)->row();

        // Format validasi (username is_unique jika tidak sama dengan sekarang)
        $current_username   = $current_user->username;
        $new_username       = $this->input->post('xusername');
        $username_is_unique = $current_username !== $new_username;

        // Validasi input
        $rules = $this->m_user->rules($dusun_id_is_required, $rt_id_is_required, $password_is_required, $username_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/user');
        }

        $data_update_user = [
            'dusun_id'     => $dusun_id,
            'rt_id'        => $rt_id,
            'nama_pemilik' => $this->input->post('xnama_pemilik', TRUE),
            'username'     => $this->input->post('xusername', TRUE),
            'hak_akses'    => $this->input->post('xhak_akses', TRUE),
        ];

		// Set data password untuk update user jika password tidak kosong
        if (!empty($this->input->post('xpassword'))) {
            $data_update_user['password'] = password_hash($this->input->post('xpassword', TRUE), PASSWORD_DEFAULT);
        }

        !$this->m_user->update($this->input->post('xuser_id'), $data_update_user)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');

        redirect('admin/user');
    }

    public function destroy($user_id) {
        $user = $this->m_user->get_by_id($user_id)->row();
        
        if (!$user) {
            $this->session->set_flashdata('msg', 'User tidak ditemukan!');
            redirect('admin/user');
        }
        
        !$this->m_user->delete($user_id)
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');
            
        redirect('admin/user');
    }

	public function get_user_by_id() {
		$user_id = $this->input->post('user_id', TRUE);
		$data    = $this->m_user->get_join_all_where(['a.id' => $user_id])->row_array();
		echo json_encode($data);
	}
}