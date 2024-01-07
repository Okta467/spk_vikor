<?php
class M_alternatif extends CI_Model {
	private $_table = 'tbl_alternatif';

	const SELECT_JOIN_ALL = '
        a.id AS alternatif_id, a.kode AS kode_alternatif, a.kk_kepala_keluarga, a.nik_kepala_keluarga, a.nama_kepala_keluarga, a.alamat AS alamat_alternatif, a.created_at AS created_at_alternatif, a.updated_at AS updated_at_alternatif,
        b.id AS dusun_id, b.nama AS dusun, b.alamat AS alamat_dusun, b.created_at AS created_at_dusun, b.updated_at AS updated_at_dusun,
        c.id AS rt_id, c.nama AS rt, c.alamat AS alamat_rt, c.created_at AS created_at_rt, c.updated_at AS updated_at_rt';

	/**
	 * Rules insert/update tbl_alternatif
	 * 
	 * @return array<validation_rules
	 */
	public function rules($kode_is_unique = true, $kk_kepala_keluarga_is_unique = true, $nik_kepala_keluarga_is_unique = true) {
		$kode_is_unique                = $kode_is_unique ? '|is_unique[tbl_alternatif.kode]' : '';
		$kk_kepala_keluarga_is_unique  = $kk_kepala_keluarga_is_unique ? '|is_unique[tbl_alternatif.kk_kepala_keluarga]' : '';
		$nik_kepala_keluarga_is_unique = $nik_kepala_keluarga_is_unique ? '|is_unique[tbl_alternatif.nik_kepala_keluarga]' : '';

		return [
			[
				'field'  => 'xdusun_id',
				'label'  => 'ID Dusun',
				'rules'  => 'required|integer',
			],
			[
				'field'  => 'xrt_id',
				'label'  => 'ID RT',
				'rules'  => 'required|integer',
			],
			[
				'field'  => 'xkode',
				'label'  => 'Kode Alternatif',
				'rules'  => 'required|alpha_numeric' . $kode_is_unique,
			],
			[
				'field'  => 'xkk_kepala_keluarga',
				'label'  => 'Kartu Keluarga Kepala Keluarga',
				'rules'  => 'required|max_length[32]|integer' . $kk_kepala_keluarga_is_unique,
				'errors' => array('is_unique' => 'Nama role sudah ada.')
			],
			[
				'field'  => 'xnik_kepala_keluarga',
				'label'  => 'NIK Kepala Keluarga',
				'rules'  => 'required|max_length[32]|integer' . $nik_kepala_keluarga_is_unique,
				'errors' => array('is_unique' => 'Nama role sudah ada.')
			],
			[
				'field'  => 'xnama_kepala_keluarga',
				'label'  => 'Nama Kepala Keluarga',
				'rules'  => 'required|max_length[255]|regex_match[/^[\sA-Za-z]*$/]',
				'errors' => array('regex_match' => '{field} hanya boleh huruf dan spasi.')
			],
			[
				'field'  => 'xalamat_alternatif',
				'label'  => 'Alamat Alternatif',
				'rules'  => 'required|max_length[1024]|regex_match[/^[a-zA-Z0-9.,()\- ]*$/]',
				'errors' => array('regex_match' => '{field} hanya boleh huruf, angka spasi dan simbol berikut .,()-')
			],
		];
	}

	public function insert($data) {
		return $this->db->insert($this->_table, $data);
	}

	public function update($id, $data) {
		return $this->db->update($this->_table, $data, array('id' => $id));
	}

	public function delete($id) {
		return $this->db->delete($this->_table, array('id' => $id));
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

	public function get_join_all() {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_alternatif AS a')
			->join('tbl_dusun AS b', 'a.dusun_id = b.id', 'LEFT')
			->join('tbl_rt AS c', 'a.rt_id = c.id', 'LEFT')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_alternatif AS a')
			->join('tbl_dusun AS b', 'a.dusun_id = b.id', 'LEFT')
			->join('tbl_rt AS c', 'a.rt_id = c.id', 'LEFT')
            ->where($where)
			->order_by('a.id', 'DESC')
            ->get();
	}
}
