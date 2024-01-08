<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {
    const CURRENT_ACCESS_LEVEL = 'kepala_desa';

    public function __construct() {
        parent::__construct();
        // Redirect if user is not login or wrong access level
        $this->load->model('m_auth');
        if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
            redirect('auth/login');
        }
    }

	public function index() {
        $user                 = $this->m_auth->current_user();
        $data['user']         = $user;
        $data['nama_pemilik'] = ucwords($user->nama_pemilik);
        $data['hak_akses']    = ucwords(preg_replace('/_+/', ' ', $user->hak_akses)); // replace all underscore with space

		$this->load->view('kepala_desa/v_dashboard', $data);
	}
}