<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'sekretaris_desa';

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
		$current_user           = $this->m_auth->current_user();
        $current_user_full_info = $this->m_user->get_join_all_where(['a.id' => $current_user->id])->row();
        
        $data['user'] = $current_user_full_info;
        
		$this->load->view('sekretaris_desa/v_profile', $data);
	}

    public function change_password() {
        // Validasi input
        $rules = $this->m_user->rules_update_password();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('sekretaris_desa/profile');
        }

        $user            = $this->m_auth->current_user();
        $password        = $this->input->post('xcur_password', TRUE);
        $new_password    = $this->input->post('xnew_password', TRUE);
        $retype_password = $this->input->post('xnew_password2', TRUE);

        // cek apakah input password sekarang benar?
        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('msg', 'Password sekarang salah!');    
            redirect('sekretaris_desa/profile');
        }
        
        // cek apakah password baru sama dengan password sekarang?
        if (password_verify($new_password, $user->password)) {
            $this->session->set_flashdata('msg', 'Password baru tidak boleh sama dengan password lama!');    
            redirect('sekretaris_desa/profile');
        }
        
        // cek apakah input new dan retype password sama?
        if ($new_password != $retype_password) {
            $this->session->set_flashdata('msg', 'New Password dan Retype Password tidak sama!');    
            redirect('sekretaris_desa/profile');
        }

        $update = $this->m_user->update($user->id, [
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
        ]);
        
        !$update
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
        
        redirect('sekretaris_desa/profile');
    }

    public function change_profile_details() {
        // Validasi input
        $password_is_required = false;
        $rules = $this->m_user->rules_update_details($password_is_required);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('sekretaris_desa/profile');
        }

        $user             = $this->m_auth->current_user();
        $nama_pemilik     = $this->input->post('xnama_pemilik');
        $current_password = $this->input->post('xcurrent_password');

        // cek apakah input password sekarang benar?
        if (!password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('msg', 'Password sekarang salah!');    
            redirect('sekretaris_desa/profile');
        }
        
        $update = $this->m_user->update($user->id, [
            'nama_pemilik' => $nama_pemilik
        ]);

        !$update
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success');
    
        redirect('sekretaris_desa/profile');
    }
}