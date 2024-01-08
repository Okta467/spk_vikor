<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_Alternatif extends CI_Controller {
	const CURRENT_ACCESS_LEVEL = 'kepala_dusun';

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
		$this->load->model('m_user');
		$this->load->helper('formatting_validation_errors');
	}

	public function index() {
        $tahun_penilaian = $this->input->get('tahun_penilaian', TRUE);
        $tahun_penilaian = ($tahun_penilaian) ?? date('Y');

        $data['tahun_penilaian']             = $tahun_penilaian;
        $data['tahun_penilaian_alternatifs'] = array();

        // masukkan data tahun untuk filter data yang ditampilkan by tahun
        $i = 0;
        for ($tahun = date('Y'); $tahun >= 2000; $tahun--) {
            $data['tahun_penilaian_alternatifs'][$i]['tahun'] = $tahun;
            $data['tahun_penilaian_alternatifs'][$i]['jumlah_data'] = $this->m_penilaian_alternatif->get_count_penilaian_alternatif($tahun);
            $i++;
        }

        // untuk filter data alternatif berdasarkan dusun dan rt saat ini
		$current_user           = $this->m_auth->current_user();
        $current_user_full_info = $this->m_user->get_join_all_where(['a.id' => $current_user->id])->row();
        $dusun_id               = $current_user_full_info->dusun_id;
        
        // data penilaian seluruh (alternatif, penilaian, kriteria, sub kriteria, dusun, rt)
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_join_all_where([
            'tahun_penilaian' => $tahun_penilaian,
            'e.id'            => $dusun_id,
        ])->result_array();

        // seluruh data alternatif untuk membandingkan/mendapatkan alternatif yang belum dinilai
        $alternatifs = $this->m_alternatif->get_join_all_where([
            'b.id' => $dusun_id,
        ])->result_array();

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

        $data['penilaian_alternatifs'] = $mergedArray;

        // ambil kriteria_id berdasarkan alternatif yang telah dinilai (jika ada)
        // atau kriteria yang saat ini aktif (jika tidak ada data penilaian alternatif)
        if ($penilaian_alternatifs) {
            $alternatif_id_tmp      = $penilaian_alternatifs[0]['alternatif_id'];
            $tahun_penilaian_tmp    = $penilaian_alternatifs[0]['tahun_penilaian'];
            $kriteria_id_collection = $this->get_all_kriteria_id_by_alternatif_id($alternatif_id_tmp, $tahun_penilaian_tmp);
        } else {
            $kriteria_id_collection = $this->get_all_kriteria_id_aktif();
        }

        // Ambil kriteria berdasarkan id yang telah di-filter
        $data['kriterias'] = $this->m_kriteria->get_where(
            "id IN({$kriteria_id_collection})"
        )->result();

        // Ambil sub kriteria berdasarkan kriteria
        $data['sub_kriterias']  = $this->m_sub_kriteria->get_where(
            "kriteria_id IN({$kriteria_id_collection})"
        )->result();

        // urutkan kriteria dan subnya secara ascending berdasarkan id (karena di model defaultnya desc)
        usort($data['kriterias'], fn($a, $b) => $a->id - $b->id);
        usort($data['sub_kriterias'], fn($a, $b) => $a->id - $b->id);

		$this->load->view('kepala_dusun/v_penilaian_alternatif', $data);
	}

    public function store() {
        $tahun_penilaian = $this->input->post('xtahun_penilaian', TRUE);

        // ambil data penilaian alternatif untuk menentukan kriteria (yang sudah ada atau yang statusnya aktif)
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_where([
            'tahun_penilaian' => $tahun_penilaian
        ])->row_array();
        
        $alternatif_id = $this->input->post('xalternatif_id', TRUE);
        $is_penilaian_alternatif_exists = $this->m_penilaian_alternatif->get_where([
            'alternatif_id'   => $alternatif_id,
            'tahun_penilaian' => $tahun_penilaian
        ])->row();

        if ($is_penilaian_alternatif_exists) {
            $this->session->set_flashdata('msg', 'Alternatif sudah dinilai!');
            redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
        }

        // Validasi input
        $rules = $this->m_penilaian_alternatif->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
        }

        $this->db->trans_start();

        // ambil kriteria_id berdasarkan alternatif yang telah dinilai (jika ada)
        // atau kriteria yang saat ini aktif (jika tidak ada data penilaian alternatif)
        if ($penilaian_alternatifs) {
            $alternatif_id_tmp      = $penilaian_alternatifs['alternatif_id'];
            $tahun_penilaian_tmp    = $penilaian_alternatifs['tahun_penilaian'];
            $kriteria_id_collection = $this->get_all_kriteria_id_by_alternatif_id($alternatif_id_tmp, $tahun_penilaian_tmp);
        } else {
            $kriteria_id_collection = $this->get_all_kriteria_id_aktif();
        }

        // Ambil kriteria berdasarkan id yang telah di-filter
        $kriterias = $this->m_kriteria->get_where(
            "id IN({$kriteria_id_collection})"
        )->result();

        // sort by id (desc) agar data di db ter-insert dengan rapi
        usort($kriterias, fn($a, $b) => $a->id - $b->id);

        // insert semua penilaian yang dipilih
        foreach($kriterias as $kriteria) {
            $this->m_penilaian_alternatif->insert([
                'alternatif_id'   => $this->input->post('xalternatif_id', TRUE),
                'tahun_penilaian' => $tahun_penilaian,
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
            
        redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
    }

    public function update() {
        $tahun_penilaian = $this->input->post('xtahun_penilaian', TRUE);

        // Validasi input
        $rules = $this->m_penilaian_alternatif->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors(' ', ' ');
            $error = formatting_validation_errors($error);
            $this->session->set_flashdata('msg', $error);
            redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
        }

        $this->db->trans_start();

        // ambil data penilaian alternatif untuk menentukan kriteria (yang sudah ada atau yang statusnya aktif)
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_where([
            'tahun_penilaian' => $tahun_penilaian
        ])->row_array();

        // ambil kriteria_id berdasarkan alternatif yang telah dinilai (jika ada)
        // atau kriteria yang saat ini aktif (jika tidak ada data penilaian alternatif)
        if ($penilaian_alternatifs) {
            $alternatif_id_tmp      = $penilaian_alternatifs['alternatif_id'];
            $tahun_penilaian_tmp    = $penilaian_alternatifs['tahun_penilaian'];
            $kriteria_id_collection = $this->get_all_kriteria_id_by_alternatif_id($alternatif_id_tmp, $tahun_penilaian_tmp);
        } else {
            $kriteria_id_collection = $this->get_all_kriteria_id_aktif();
        }

        // Ambil kriteria berdasarkan id yang telah di-filter
        $kriterias = $this->m_kriteria->get_where(
            "id IN({$kriteria_id_collection})"
        )->result();

        // sort by id (desc) agar data di db ter-insert dengan rapi
        usort($kriterias, fn($a, $b) => $a->id - $b->id);

        // insert semua penilaian yang dipilih
        foreach($kriterias as $kriteria) {
            $where = [
                'alternatif_id'   => $this->input->post('xalternatif_id', TRUE),
                'kriteria_id'     => $this->input->post("xkriteria_id_{$kriteria->kode}", TRUE),
                'tahun_penilaian' => $tahun_penilaian
            ];
            
            $update = $this->m_penilaian_alternatif->update_where($where, [
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
            
        redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
    }

    public function destroy($alternatif_id, $tahun_penilaian) {
        $penilaian_alternatif = $this->m_penilaian_alternatif->get_where(['alternatif_id' => $alternatif_id])->row();
        
        if (!$penilaian_alternatif) {
            $this->session->set_flashdata('msg', "Penilaian alternatif tidak ditemukan!");
            redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
        }
        
        !$this->m_penilaian_alternatif->delete_where(['alternatif_id' => $penilaian_alternatif->alternatif_id])
            ? $this->session->set_flashdata('msg', 'error-other')
            : $this->session->set_flashdata('msg', 'success-hapus');
            
        redirect("kepala_dusun/penilaian_alternatif/?tahun_penilaian={$tahun_penilaian}");
    }

    public function get_penilaian_alternatif() {
        $alternatif_id = $this->input->post('alternatif_id', TRUE);
        $data          = $this->m_penilaian_alternatif->get_join_all_penilaian_where(['a.id' => $alternatif_id])->result_array();
        echo json_encode($data);
    }

    /**
     * Mendapatkan kriteria_id dari satu alternatif (by alternatif_id)
     * 
     * @param int $alternatif_id
     * @return string - formatted kriteria_id untuk pemanggilan WHERE IN. Contoh: 1, 2, 3, 4
     */
    private function get_all_kriteria_id_by_alternatif_id($alternatif_id, $tahun_penilaian) {
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_join_all_penilaian_simple_where([
            'b.alternatif_id'   => $alternatif_id,
            'b.tahun_penilaian' => $tahun_penilaian
        ])->result();

        $kriteria_ids = array();

        foreach($penilaian_alternatifs as $penilaian_alternatif) {
            array_push($kriteria_ids, $penilaian_alternatif->kriteria_id);
        }
        
        // Gabungkan seluruh kriteria_id menjadi satu string dipisahkan oleh koma (,)
        $kriteria_id_collection = '';

        foreach ($kriteria_ids as $kriteria_id) {
            $kriteria_id_collection .= $kriteria_id . ', ';
        }

        // Hapus koma dan spasi pada ujung string
        $kriteria_id_collection = rtrim($kriteria_id_collection, ', ');

        // return $kriteria_id_collection;
        return $kriteria_id_collection;
    }

    private function get_all_kriteria_id_aktif() {
        $kriterias              = $this->m_kriteria->get_where(['status_aktif' => '1'])->result();
        $kriteria_id_collection = '';

        // Gabungkan seluruh kriteria_id menjadi satu string dipisahkan oleh koma (,)
        foreach ($kriterias as $kriteria) {
            $kriteria_id_collection .= $kriteria->id . ', '; 
        }

        // Hapus koma dan spasi pada ujung string
        $kriteria_id_collection = rtrim($kriteria_id_collection, ', ');

        return $kriteria_id_collection;
    }
}
