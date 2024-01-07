<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_Perhitungan extends CI_Controller {
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
        // default tahun penilaian yaitu tahun sekarang
        $tahun_penilaian         = date('Y');
        $data['tahun_penilaian'] = $tahun_penilaian;

        // data penilaian seluruh (alternatif, penilaian, kriteria, sub kriteria, dusun, rt)
        $penilaian_alternatifs = $this->m_penilaian_alternatif->get_join_all_where([
            'tahun_penilaian' => $tahun_penilaian
        ])->result();

        // data penilaian saja (alternatif_id, kriteria, dan sub kriteria)
        $penilaian_alternatif_simples = $this->m_penilaian_alternatif->get_join_all_penilaian_simple_where([
            'tahun_penilaian' => $tahun_penilaian
        ])->result();
        
        $data['penilaian_alternatifs']        = $penilaian_alternatifs;
        $data['penilaian_alternatif_simples'] = $penilaian_alternatif_simples;

        // get min/max skor kriteria dari seluruh penilaian alternatif
        $data['max_kriterias'] = $this->get_max_kriteria($penilaian_alternatif_simples);
        $data['min_kriterias'] = $this->get_min_kriteria($penilaian_alternatif_simples);

        // get kriteria dan jumlah datanya
        $kriterias               = $this->m_kriteria->get_where(['status_aktif' => 1])->result();
        $data['kriterias']       = $kriterias;
        $data['jumlah_kriteria'] = count($kriterias);
        
        // Gabungkan seluruh kriteria_id menjadi satu string dipisahkan oleh koma (,)
        $kriteria_id_collection = '';

        foreach ($kriterias as $kriteria) {
            $kriteria_id_collection .= $kriteria->id . ', ';
        }

        // Hapus koma dan spasi pada ujung string
        $kriteria_id_collection = rtrim($kriteria_id_collection, ', ');

        // Ambil sub kriteria berdasarkan kriteria
        $data['sub_kriterias'] = $this->m_sub_kriteria->get_where(
            "kriteria_id IN({$kriteria_id_collection})"
        )->result();

        // urutkan kriteria dan subnya secara ascending berdasarkan id (karena di model defaultnya desc)
        usort($data['kriterias'], fn ($a, $b) => $a->id - $b->id);
        usort($data['sub_kriterias'], fn ($a, $b) => $a->id - $b->id);

        $this->load->view('admin/v_hasil_perhitungan', $data);
    }

    public function get_max_kriteria($kriteria) {
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

    public function get_min_kriteria($kriteria) {
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
}
