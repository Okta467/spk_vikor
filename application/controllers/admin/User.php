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
		$data['users'] = $this->m_user->get_join_all();

		$this->load->view('admin/v_user', $data);
	}

    public function store() {
        // Validasi input
        $rules = $this->m_user->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/user');
        }

        $hak_akses = $this->input->post('xhak_akses_hidden', TRUE);

        // redirect jika hak_akses tidak sesuai
        if (!in_array($hak_akses, ['admin', 'mahasiswa', 'dosen', 'koordinator', 'kaprodi'])) {
            $this->session->set_flashdata('msg', 'Hak akses tidak ada!');
            redirect('admin/user');
        }

        // simpan user admin
        if ($hak_akses == 'admin') {
            $insert = $this->m_user->insert([
                'username'  => $this->input->post('xusername', TRUE),
                'password'  => password_hash($this->input->post('xpassword', TRUE), PASSWORD_DEFAULT),
                'hak_akses' => $this->input->post('xhak_akses', TRUE),
            ]);

            !$insert
                ? $this->session->set_flashdata('msg', 'error-other')
                : $this->session->set_flashdata('msg', 'success');
                
            redirect('admin/user');
        }


        // simpan user mahasiswa, dosen, koordinator, kaprodi
        $this->db->trans_start();

        $this->m_user->insert([
            'username'  => $this->input->post('xpemilik_akun', TRUE),
            'password'  => password_hash($this->input->post('xpassword', TRUE), PASSWORD_DEFAULT),
            'hak_akses' => $this->input->post('xhak_akses', TRUE),
        ]);

        // base data untuk insert mahasiswa/dosen
        $data_tmp = array(
            'username'  => $this->input->post('xpemilik_akun', TRUE),
            'nama'      => $this->input->post('xnama', TRUE),
            'jk'        => $this->input->post('xjk', TRUE),
            'alamat'    => $this->input->post('xalamat', TRUE),
            'tmp_lahir' => $this->input->post('xtmp_lahir', TRUE),
            'tgl_lahir' => $this->input->post('xtgl_lahir', TRUE),
            'no_telp'   => $this->input->post('xno_telp', TRUE),
            'email'     => $this->input->post('xemail', TRUE),
        );

        // insert tbl_mahasiswa atau tbl_dosen
        if ($hak_akses == 'mahasiswa') {
            $data_pemilik_mhs                 = $data_tmp;
            $data_pemilik_mhs['nim']          = $this->input->post('xpemilik_akun', TRUE);
            $data_pemilik_mhs['nip_dosen_pa'] = $this->input->post('xnip_dosen_pa', TRUE);
            $this->m_mahasiswa->insert($data_pemilik_mhs);
        } else if (in_array($hak_akses, ['dosen', 'koordinator', 'kaprodi'])) {
            $data_pemilik_dosen        = $data_tmp;
            $data_pemilik_dosen['nip'] = $this->input->post('xpemilik_akun', TRUE);
            $this->m_dosen->insert($data_pemilik_dosen);
        }

        // Transaction process
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('msg', 'error-other');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('msg', 'success');
        }

        redirect('admin/user');
    }

    public function update() {
        // Format validasi (username is_unique jika tidak sama dengan sekarang)
        $current_username   = $this->input->post('xpemilik_akun_hidden', TRUE);
        $username           = $this->input->post('xusername');
        $username_is_unique = $current_username !== $username;

        // Validasi input
        $rules = $this->m_user->rules($username_is_unique);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/user');
        }

        $data_update_user = [
            'username'  => $this->input->post('xusername', TRUE),
            'hak_akses' => $this->input->post('xhak_akses_hidden')
        ];

		// Set data password untuk update user jika password tidak kosong
        if (!empty($this->input->post('xpassword'))) {
            $data_update_user['password'] = password_hash($this->input->post('xpassword', TRUE), PASSWORD_DEFAULT);
        }

        $hak_akses = $this->input->post('xhak_akses_hidden');

        // redirect jika hak_akses tidak sesuai
        if (!in_array($hak_akses, ['admin', 'mahasiswa', 'dosen', 'koordinator', 'kaprodi'])) {
            $this->session->set_flashdata('msg', 'Hak akses tidak ada!');
            redirect('admin/user');
        }

        // update user admin
        if ($hak_akses == 'admin') {
            !$this->m_user->update($this->input->post('xid_user'), $data_update_user)
                ? $this->session->set_flashdata('msg', 'error-other')
                : $this->session->set_flashdata('msg', 'success');

            redirect('admin/user');
        }


        // update table user, mahasiswa/dosen
        $this->db->trans_start();

        // update tbl_user - jangan update hak aksesnya (dengan menghapus indeks hak akses pada array)
        unset($data_update_user['hak_akses']);
        $this->m_user->update($this->input->post('xid_user'), $data_update_user);

        // update mahasiswa/dosen
        $data_pemilik = array(
            'nama'      => $this->input->post('xnama', TRUE),
            'jk'        => $this->input->post('xjk', TRUE),
            'alamat'    => $this->input->post('xalamat', TRUE),
            'tmp_lahir' => $this->input->post('xtmp_lahir', TRUE),
            'tgl_lahir' => $this->input->post('xtgl_lahir', TRUE),
            'no_telp'   => $this->input->post('xno_telp', TRUE),
            'email'     => $this->input->post('xemail', TRUE)
        );
        if ($hak_akses == 'mahasiswa') {
            $data_pemilik_mhs                 = $data_pemilik;
            $data_pemilik_mhs['nim']          = $this->input->post('xpemilik_akun');
            $data_pemilik_mhs['nip_dosen_pa'] = $this->input->post('xnip_dosen_pa');

            // update tbl_mahasiswa
            $mahasiswa = $this->m_mahasiswa->get_by_nim($this->input->post('xpemilik_akun_hidden'))->row();
            $this->m_mahasiswa->update($mahasiswa->id, $data_pemilik_mhs);
        } else if (in_array($hak_akses, ['dosen', 'koordinator', 'kaprodi'])) {
            $data_pemilik_dosen        = $data_pemilik;
            $data_pemilik_dosen['nip'] = $this->input->post('xpemilik_akun');

            // update tbl_dosen
            $dosen = $this->m_dosen->get_by_nip($this->input->post('xpemilik_akun_hidden'))->row();
            $this->m_dosen->update($dosen->id, $data_pemilik_dosen);
        }

        // Transaction process
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('msg', 'error-other');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('msg', 'success');
        }

        redirect('admin/user');
    }

    public function destroy($id_user) {
        $user = $this->m_user->get_by_id($id_user)->row();
        
        if (!$user) {
            $this->session->set_flashdata('msg', 'User tidak ditemukan!');
            redirect('admin/user');
        }

        $hak_akses = $user->hak_akses;
        $username  = $user->username;

        // Hapus data user admin
        if ($hak_akses === 'admin') {
            if (!$this->m_user->delete($id_user)) {
                $this->session->set_flashdata('msg', 'error-other');
                redirect('admin/user');
            }

            $this->session->set_flashdata('msg', 'success-hapus');
            redirect('admin/user');
        }

        $this->db->trans_start();
    

        // Hapus data user dosen (termasuk koordinator dan kaprodi)
        if (in_array($hak_akses, ['dosen', 'koordinator', 'kaprodi'])) {
            $dosen = $this->m_dosen->get_where(['username' => $username])->row();
            $this->m_user->delete($id_user);
            $this->m_dosen->delete($dosen->id);

            // Transaction process
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('msg', 'error-other');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('msg', 'success-hapus');
            }
    
            redirect('admin/user');
        }


        // Hapus data user mahasiswa
        if ($hak_akses == 'mahasiswa') {
            $mahasiswa = $this->m_mahasiswa->get_where(['username' => $username])->row();
            $this->m_user->delete($id_user);
            $this->m_mahasiswa->delete($mahasiswa->id);

            // Transaction process
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('msg', 'error-other');
                redirect('admin/user');
            }
    
            // delete all folder and its files of mahasiswa by nim
            try {
                $nim = $username;
                delete_files('./assets/uploads/pendaftaran_judul/' . $nim, TRUE);
                delete_files('./assets/uploads/pendaftaran_proposal/' . $nim, TRUE);
                delete_files('./assets/uploads/pendaftaran_hasil/' . $nim, TRUE);
                delete_files('./assets/uploads/pendaftaran_skripsi/' . $nim, TRUE);
                delete_files('./assets/uploads/sempro/' . $nim, TRUE);
                delete_files('./assets/uploads/semhas/' . $nim, TRUE);
                delete_files('./assets/uploads/skripsi/' . $nim, TRUE);
                delete_files('./assets/uploads/bimbingan/' . $nim, TRUE);
                delete_files('./assets/uploads/perbaikan_ujian/' . $nim, TRUE);
                @rmdir('./assets/uploads/pendaftaran_judul/' . $nim);
                @rmdir('./assets/uploads/pendaftaran_proposal/' . $nim);
                @rmdir('./assets/uploads/pendaftaran_hasil/' . $nim);
                @rmdir('./assets/uploads/pendaftaran_skripsi/' . $nim);
                @rmdir('./assets/uploads/sempro/' . $nim);
                @rmdir('./assets/uploads/semhas/' . $nim);
                @rmdir('./assets/uploads/skripsi/' . $nim);
                @rmdir('./assets/uploads/bimbingan/' . $nim);
                @rmdir('./assets/uploads/perbaikan_ujian/' . $nim);
            } catch (Exception $e) {
                $error_msg =  'Error: ' . $e->getMessage();
                $this->session->set_flashdata('msg', $error_msg);
                redirect('admin/user');
            }
    
            // commit db changes and redirect if all process success
            $this->db->trans_commit();
            $this->session->set_flashdata('msg', 'success-hapus');
            redirect('admin/user');
        }

        $this->session->set_flashdata('msg', 'Hak akses tidak ada!');
        redirect('admin/user');
    }

	public function get_user_by_id() {
		$user_id = $this->input->post('user_id', TRUE);
		$data = $this->m_user->get_join_all_where(['user_id' => $user_id])->row_array();
		echo json_encode($data);
	}
}