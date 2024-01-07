<?php
class M_penilaian_alternatif extends CI_Model {
	private $_table = 'tbl_penilaian_alternatif';
    
	const SELECT_JOIN_ALL = '
        a.id AS alternatif_id, a.kode AS kode_alternatif, a.kk_kepala_keluarga, a.nik_kepala_keluarga, a.nama_kepala_keluarga, a.alamat AS alamat_alternatif, a.created_at AS created_at_alternatif, a.updated_at AS updated_at_alternatif,
        b.id AS penilaian_alternatif_id, b.tahun_penilaian, b.created_at AS created_at_penilaian_alternatif, b.updated_at AS updated_at_penilaian_alternatif,
		c.id AS kriteria_id, c.kode AS kode_kriteria, c.nama AS kriteria, c.atribut AS atribut_kriteria, c.bobot AS bobot_kriteria, c.created_at AS created_at_kriteria, c.updated_at AS updated_at_kriteria,
        d.id AS sub_kriteria_id, d.kode AS kode_sub_kriteria, d.nama AS sub_kriteria, d.skor AS skor_sub_kriteria, d.created_at AS created_at_sub_kriteria, d.updated_at AS updated_at_sub_kriteria,
		e.id AS dusun_id, e.nama AS dusun, e.alamat AS alamat_dusun, e.created_at AS created_at_dusun, e.updated_at AS updated_at_dusun,
        f.id AS rt_id, f.nama AS rt, f.alamat AS alamat_rt, f.created_at AS created_at_rt, f.updated_at AS updated_at_rt';
    
	const SELECT_JOIN_ALL_SIMPLE = '
        b.id AS penilaian_alternatif_id, b.alternatif_id, b.tahun_penilaian, b.created_at AS created_at_penilaian_alternatif, b.updated_at AS updated_at_penilaian_alternatif,
		c.id AS kriteria_id, c.kode AS kode_kriteria, c.nama AS kriteria, c.atribut AS atribut_kriteria, c.bobot AS bobot_kriteria, c.created_at AS created_at_kriteria, c.updated_at AS updated_at_kriteria,
        d.id AS sub_kriteria_id, d.kode AS kode_sub_kriteria, d.nama AS sub_kriteria, d.skor AS skor_sub_kriteria, d.created_at AS created_at_sub_kriteria, d.updated_at AS updated_at_sub_kriteria';

	/**
	 * Rules insert/update tbl_penilaian_alternatif
	 * 
	 * @return array<validation_rules
	 */
	public function rules() {
		return [
			[
				'field'  => 'xalternatif_id',
				'label'  => 'Alternatif',
				'rules'  => 'required|integer'
			],
			[
				'field'  => 'xtahun_penilaian',
				'label'  => 'Tahun Penilaian',
				'rules'  => 'required|integer',
			],
		];
	}

	public function insert($data) {
		return $this->db->insert($this->_table, $data);
	}

	public function update($id, $data) {
		return $this->db->update($this->_table, $data, array('id' => $id));
	}

	public function update_where($where, $data) {
		return $this->db->update($this->_table, $data, $where);
	}

	public function delete($id) {
		return $this->db->delete($this->_table, array('id' => $id));
	}

	public function delete_where($where) {
		return $this->db->delete($this->_table, $where);
	}

	public function get_all() {
		return $this->db->order_by('id', 'DESC')->get($this->_table);
	}

	public function get_by_id($id) {
		return $this->db->get_where($this->_table, array('id' => $id));
	}

	public function get_where($where) {
		return $this->db->order_by('id', 'DESC')->get_where($this->_table, $where);
	}

    /*
    SELECT a.*, b.*, c.*, d.*
    FROM tbl_alternatif AS a
    LEFT JOIN tbl_penilaian_alternatif AS b
        ON a.id = b.alternatif_id
    LEFT JOIN tbl_kriteria AS c
        ON c.id = b.kriteria_id
    LEFT JOIN tbl_sub_kriteria AS d
        ON c.id = d.kriteria_id
    WHERE b.tahun_penilaian = YEAR(CURDATE())
    GROUP BY a.id;
    */

	/**
	 * =============================================================================
	 * 
	 * Untuk mendapatkan semua alternatif yang akan dinilai (group by alternatif_id)
	 * 
	 * =============================================================================
	 */

	public function get_join_all() {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_alternatif AS a')
            ->join('tbl_penilaian_alternatif AS b', 'a.id = b.alternatif_id', 'LEFT')
            ->join('tbl_kriteria AS c', 'c.id = b.kriteria_id', 'LEFT')
			->join('tbl_sub_kriteria AS d', 'c.id = d.kriteria_id', 'LEFT')
			->join('tbl_dusun AS e', 'e.id = a.dusun_id', 'LEFT')
			->join('tbl_rt AS f', 'e.id = f.dusun_id', 'LEFT')
			->group_by('a.id')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_alternatif AS a')
            ->join('tbl_penilaian_alternatif AS b', 'a.id = b.alternatif_id', 'LEFT')
            ->join('tbl_kriteria AS c', 'c.id = b.kriteria_id', 'LEFT')
			->join('tbl_sub_kriteria AS d', 'c.id = d.kriteria_id', 'LEFT')
			->join('tbl_dusun AS e', 'e.id = a.dusun_id', 'LEFT')
			->join('tbl_rt AS f', 'e.id = f.dusun_id', 'LEFT')
            ->where($where)
			->group_by('a.id')
			->order_by('a.id', 'DESC')
            ->get();
	}

	/**
	 * ===============================================================================
	 * 
	 * Untuk mendapatkan semua penilaian alternatif (group by penilaian_alternatif_id)
	 * 
	 * ===============================================================================
	 */

	public function get_join_all_penilaian() {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_alternatif AS a')
            ->join('tbl_penilaian_alternatif AS b', 'b.alternatif_id = a.id', 'LEFT')
            ->join('tbl_kriteria AS c', 'c.id = b.kriteria_id', 'LEFT')
			->join('tbl_sub_kriteria AS d', 'd.id = b.sub_kriteria_id', 'LEFT')
			->join('tbl_dusun AS e', 'e.id = a.dusun_id', 'LEFT')
			->join('tbl_rt AS f', 'f.dusun_id = e.id', 'LEFT')
			->group_by('b.id')
			->get();
	}

	public function get_join_all_penilaian_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_alternatif AS a')
            ->join('tbl_penilaian_alternatif AS b', 'b.alternatif_id = a.id', 'LEFT')
            ->join('tbl_kriteria AS c', 'c.id = b.kriteria_id', 'LEFT')
			->join('tbl_sub_kriteria AS d', 'd.id = b.sub_kriteria_id', 'LEFT')
			->join('tbl_dusun AS e', 'e.id = a.dusun_id', 'LEFT')
			->join('tbl_rt AS f', 'f.dusun_id = e.id', 'LEFT')
            ->where($where)
			->group_by('b.id')
            ->get();
	}

	/**
	 * ===============================================================================
	 * 
	 * Untuk mendapatkan semua penilaian alternatif (group by penilaian_alternatif_id)
	 * 
	 * note:
	 * Simple untuk mengambil data secara efisien (hanya penilaian, kriteria dan sub)
	 * 
	 * ===============================================================================
	 */

	public function get_join_all_penilaian_simple() {
		return $this->db
			->select(self::SELECT_JOIN_ALL_SIMPLE)
			->from('tbl_penilaian_alternatif AS b')
            ->join('tbl_kriteria AS c', 'c.id = b.kriteria_id', 'LEFT')
			->join('tbl_sub_kriteria AS d', 'd.id = b.sub_kriteria_id', 'LEFT')
			->group_by('b.id')
			->get();
	}

	public function get_join_all_penilaian_simple_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL_SIMPLE)
			->from('tbl_penilaian_alternatif AS b')
            ->join('tbl_kriteria AS c', 'c.id = b.kriteria_id', 'LEFT')
			->join('tbl_sub_kriteria AS d', 'd.id = b.sub_kriteria_id', 'LEFT')
            ->where($where)
			->group_by('b.id')
            ->get();
	}
}