<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_Perhitungan extends CI_Controller {
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
        $this->load->helper('formatting_validation_errors');
    }

    public function index() {
        $tahun_penilaian = $this->input->get('tahun_penilaian', TRUE);
        $tahun_penilaian = ($tahun_penilaian !== 'current_year')
            ? $tahun_penilaian
            : date('Y');
        
        $data = $this->get_hasil_perhitungan($tahun_penilaian);
        $data['tahun_penilaian'] = $tahun_penilaian;

        // untuk tools hasil perhitungan (tahun dan jumlah data penilaian pada tahun tersebut)
        $data['tahun_penilaian_alternatifs'] = array();

        // masukkan data untuk tools perhitungan
        $i = 0;
        for ($tahun = date('Y'); $tahun >= 2000; $tahun--) {
            $data['tahun_penilaian_alternatifs'][$i]['tahun'] = $tahun;
            $data['tahun_penilaian_alternatifs'][$i]['jumlah_data'] = $this->m_penilaian_alternatif->get_count_penilaian_alternatif($tahun);
            $i++;
        }

        $this->load->view('kepala_dusun/v_hasil_perhitungan', $data);
    }

    public function print() {
        $tahun_penilaian = $this->input->get('tahun_penilaian', TRUE);
        $tahun_penilaian = ($tahun_penilaian !== 'current_year')
            ? $tahun_penilaian
            : date('Y');

        $data = $this->get_hasil_perhitungan($tahun_penilaian);

        $this->load->view('kepala_dusun/v_hasil_perhitungan_print', $data);
    }

    public function get_max_skor_kriteria($kriteria) {
        // Initialize an associative array to store the maximum values for each kode_kriteria
        $maxValues = new stdClass();

        // Iterate through the data array
        foreach ($kriteria as $item) {
            $kodeKriteria = $item->kode_kriteria;
            $skorSubKriteria = $item->skor_sub_kriteria;

            // Check if the current skor_sub_kriteria is greater than the stored max for the kode_kriteria
            if (!isset($maxValues->{$kodeKriteria}) || $skorSubKriteria > $maxValues->{$kodeKriteria}) {
                $maxValues->{$kodeKriteria} = $skorSubKriteria;
            }
        }
        
        return $maxValues;
    }

    public function get_min_skor_kriteria($kriteria) {
        // Initialize an associative array to store the minimum values for each kode_kriteria
        $minValues = new stdClass();

        // Iterate through the data array
        foreach ($kriteria as $item) {
            $kodeKriteria = $item->kode_kriteria;
            $skorSubKriteria = $item->skor_sub_kriteria;

            // Check if the current skor_sub_kriteria is greater than the stored max for the kode_kriteria
            if (!isset($minValues->{$kodeKriteria}) || $skorSubKriteria < $minValues->{$kodeKriteria}) {
                $minValues->{$kodeKriteria} = $skorSubKriteria;
            }
        }
        
        return $minValues;
    }

    /**
     * Get hasil perhitungan termasuk kriteria dan sub-nya
     * 
     * @return array<data
     */
    private function get_hasil_perhitungan($tahun_penilaian = 'current_year'): array {
        // default tahun penilaian yaitu tahun sekarang
        $tahun_penilaian         = $this->input->get('tahun_penilaian', TRUE);
        $tahun_penilaian         = ($tahun_penilaian) ?? date('Y');
        $data['tahun_penilaian'] = $tahun_penilaian;

        // data penilaian seluruh (alternatif, penilaian, kriteria, sub kriteria, dusun, rt)
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_join_all_where(
            ['tahun_penilaian' => $tahun_penilaian]
            , 'a.kode'
            , 'ASC'
        )->result();

        // return data array kosong jika penilaian alternatif pada tahun x tidak ada
        if (!$penilaian_alternatifs) {
            return array(
                'penilaian_alternatifs'        => array(),
                'penilaian_alternatif_simples' => array(),
                'max_skor_kriterias'           => array(),
                'min_skor_kriterias'           => array(),
                'kriterias'                    => array(),
                'sub_kriterias'                => array(),
                'jumlah_kriteria'              => 1, // diberikan value 1 agar tidak error datatables (kolom theadtidak sama)
            );
        }

        // data penilaian saja (alternatif_id, kriteria, dan sub kriteria)
        $penilaian_alternatif_simples = $this->m_penilaian_alternatif->get_join_all_penilaian_simple_where([
            'tahun_penilaian' => $tahun_penilaian
        ])->result();
        
        $data['penilaian_alternatifs']        = $penilaian_alternatifs;
        $data['penilaian_alternatif_simples'] = $penilaian_alternatif_simples;

        // get min/max skor kriteria dari seluruh penilaian alternatif
        $data['max_skor_kriterias'] = $this->get_max_skor_kriteria($penilaian_alternatif_simples);
        $data['min_skor_kriterias'] = $this->get_min_skor_kriteria($penilaian_alternatif_simples);

        // string kriteria_id dengan format '1, 2, 3' untuk pemanggilan WHERE IN kriteria
        $alternatif_id          = $penilaian_alternatifs[0]->alternatif_id;
        $kriteria_id_collection = $this->get_all_kriteria_id_by_alternatif_id($alternatif_id, $tahun_penilaian);

        // get kriteria dan jumlah datanya
        $kriterias = $this->m_kriteria->get_where(
            "id IN({$kriteria_id_collection})
        ")->result();

        $data['kriterias']       = $kriterias;
        $data['jumlah_kriteria'] = count($kriterias);

        // Ambil sub kriteria berdasarkan kriteria
        $data['sub_kriterias'] = $this->m_sub_kriteria->get_where(
            "kriteria_id IN({$kriteria_id_collection})"
        )->result();

        // urutkan kriteria dan subnya secara ascending berdasarkan id (karena di model defaultnya desc)
        usort($data['kriterias'], fn ($a, $b) => $a->id - $b->id);
        usort($data['sub_kriterias'], fn ($a, $b) => $a->id - $b->id);

        return $data;
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
}
