<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_Alternatif extends CI_Controller {
	const CURRENT_ACCESS_LEVEL = 'admin';

	public function __construct() {
		parent::__construct();
		// Redirect if user is not login or wrong access level
		$this->load->model('m_auth');
		if (!$this->m_auth->current_user() || !$this->m_auth->is_correct_access_level(self::CURRENT_ACCESS_LEVEL)) {
			redirect('auth/login');
		}

		$this->load->model('m_alternatif');
		$this->load->model('m_penilaian_alternatif');
		$this->load->model('m_kriteria');
		$this->load->model('m_sub_kriteria');
		$this->load->model('m_penilaian_alternatif');
		$this->load->model('m_dusun');
		$this->load->model('m_rt');
		$this->load->helper('formatting_validation_errors');
	}

	public function index() {
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_join_all_where(['tahun_penilaian' => date('Y')])->result_array();
        $alternatifs           = $this->m_alternatif->get_join_all()->result_array();

        // Create an associative array with 'alternatif_id' as the key
        $mergedArray = [];

        foreach ($penilaian_alternatifs as $item) {
            $alternatif_id = $item['alternatif_id'];
            $mergedArray[$alternatif_id] = $item;
        }

        foreach ($alternatifs as $item) {
            $alternatif_id = $item['alternatif_id'];
            if (isset($mergedArray[$alternatif_id])) {
                // Merge the data from $alternatifs into the existing entry in $mergedArray
                $mergedArray[$alternatif_id] = array_merge($mergedArray[$alternatif_id], $item);
            } else {
                // If 'alternatif_id' does not exist in $penilaian_alternatifs, add the entry from $alternatifs
                $mergedArray[$alternatif_id] = $item;
            }
        }

        $data['penilaian_alternatifs'] =$mergedArray;
        
        $kriterias              = $this->m_kriteria->get_all()->result();
        $data['kriterias']      = $kriterias;
        $kriteria_id_collection = '';

        // Gabungkan seluruh kriteria_id menjadi satu string dipisahkan oleh koma (,)
        foreach ($kriterias as $kriteria) {
            $kriteria_id_collection .= $kriteria->id . ', '; 
        }

        // Hapus koma dan spasi pada ujung string
        $kriteria_id_collection = rtrim($kriteria_id_collection, ', ');
        $where                  = "kriteria_id IN({$kriteria_id_collection})";
        $data['sub_kriterias']  = $this->m_sub_kriteria->get_where($where)->result();

        // urutkan kriteria dan subnya secara ascending berdasarkan id (karena di model defaultnya desc)
        usort($data['kriterias'], fn($a, $b) => $a->id - $b->id);
        usort($data['sub_kriterias'], fn($a, $b) => $a->id - $b->id);

		$this->load->view('admin/v_penilaian_alternatif', $data);
	}

    public function store() {
        $alternatif_id = $this->input->post('xalternatif_id', TRUE);
        $is_penilaian_alternatif_exists = $this->m_penilaian_alternatif->get_where(['alternatif_id' => $alternatif_id])->row();

        if ($is_penilaian_alternatif_exists) {
            $this->session->set_flashdata('msg', 'Alternatif sudah dinilai!');
            redirect('admin/penilaian_alternatif');
        }

        // Validasi input
        $rules = $this->m_penilaian_alternatif->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/penilaian_alternatif');
        }

        $this->db->trans_start();

        // get semua kriteria aktif untuk menentukan value input kriteria dan subnya
        // sort by id (desc) agar data di db ter-insert dengan rapi
        $kriterias = $this->m_kriteria->get_where(['status_aktif' => '1'])->result();
        usort($kriterias, fn($a, $b) => $a->id - $b->id);

        // insert semua penilaian yang dipilih
        foreach($kriterias as $kriteria) {
            $this->m_penilaian_alternatif->insert([
                'alternatif_id'   => $this->input->post('xalternatif_id', TRUE),
                'tahun_penilaian' => $this->input->post('xtahun_penilaian', TRUE),
                'kriteria_id'     => $this->input->post("xkriteria_id_{$kriteria->kode}", TRUE),
                'sub_kriteria_id' => $this->input->post("xsub_kriteria_id_{$kriteria->kode}", TRUE),
            ]);
        }

        // Transaction process
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('msg', 'error-other');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('msg', 'success');
        }
            
        redirect('admin/penilaian_alternatif');
    }

    public function update() {
        // Validasi input
        $rules = $this->m_penilaian_alternatif->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect('admin/penilaian_alternatif');
        }

        $this->db->trans_start();

        // get semua kriteria aktif untuk menentukan jumlah update data
        $kriterias = $this->m_kriteria->get_where(['status_aktif' => '1'])->result();
        usort($kriterias, fn($a, $b) => $a->id - $b->id);

        // insert semua penilaian yang dipilih
        foreach($kriterias as $kriteria) {
            $where = [
                'alternatif_id' => $this->input->post('xalternatif_id', TRUE),
                'kriteria_id'   => $this->input->post("xkriteria_id_{$kriteria->kode}", TRUE)
            ];

            $this->m_penilaian_alternatif->update_where($where, [
                'tahun_penilaian' => $this->input->post('xtahun_penilaian', TRUE),
                'sub_kriteria_id' => $this->input->post("xsub_kriteria_id_{$kriteria->kode}", TRUE),
            ]);
        }

        // Transaction process
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('msg', 'error-other');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('msg', 'success');
        }
            
        redirect('admin/penilaian_alternatif');
    }

    public function destroy($alternatif_id) {
        $penilaian_alternatif = $this->m_penilaian_alternatif->get_where(['alternatif_id' => $alternatif_id])->row();
        
        if (!$penilaian_alternatif) {
            $this->session->set_flashdata('msg', "Penilaian alternatif tidak ditemukan!");
            redirect('admin/penilaian_alternatif');
        }
        
        !$this->m_penilaian_alternatif->delete_where(['alternatif_id' => $penilaian_alternatif->alternatif_id])
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');
            
        redirect('admin/penilaian_alternatif');
    }

    public function get_penilaian_alternatif() {
        $alternatif_id = $this->input->post('alternatif_id', TRUE);
        $data          = $this->m_penilaian_alternatif->get_join_all_penilaian_where(['a.id' => $alternatif_id])->result_array();
        echo json_encode($data);
    }
}
