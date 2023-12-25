<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('m_alternatif');
	}

	public function index() {
        $data['alternatifs'] = $this->m_alternatif->get_all();

		$this->load->view('admin/v_alternatif', $data);
	}
}