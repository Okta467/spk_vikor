<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_Alternatif extends CI_Controller {
	const CURRENT_ACCESS_LEVEL = 'bendahara_desa';

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
        
        // data penilaian seluruh (alternatif, penilaian, kriteria, sub kriteria, dusun, rt)
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_join_all_where([
            'tahun_penilaian' => $tahun_penilaian
        ])->result_array();

        // seluruh data alternatif untuk membandingkan/mendapatkan alternatif yang belum dinilai
        $alternatifs = $this->m_alternatif->get_join_all()->result_array();

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

		$this->load->view('bendahara_desa/v_penilaian_alternatif', $data);
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
