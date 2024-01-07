<?php
class M_kriteria extends CI_Model {
	private $_table = 'tbl_kriteria';

	const SELECT_JOIN_ALL = '
		a.id AS kriteria_id, a.kode AS kode_kriteria, a.nama AS kriteria, a.atribut AS atribut_kriteria, a.bobot AS bobot_kriteria, a.created_at AS created_at_kriteria, a.updated_at AS updated_at_kriteria,
        b.id AS sub_kriteria_id, b.kode AS kode_sub_kriteria, b.nama AS sub_kriteria, b.skor AS skor_sub_kriteria, b.created_at AS created_at_sub_kriteria, b.updated_at AS updated_at_sub_kriteria';

	/**
	 * Rules insert/update tbl_kriteria
	 * 
	 * @return array<validation_rules
	 */
	public function rules($kode_is_unique = true) {
		$kode_is_unique   = $kode_is_unique ? '|is_unique[tbl_kriteria.kode]' : '';

		return [
			[
				'field'  => 'xkode',
				'label'  => 'Kode Kriteria',
				'rules'  => 'required|max_length[255]|alpha_numeric' . $kode_is_unique,
			],
			[
				'field'  => 'xnama',
				'label'  => 'Nama Kriteria',
				'rules'  => 'required|max_length[255]|regex_match[/^[a-zA-Z0-9.,()\- ]*$/]',
				'errors' => array('regex_match' => '{field} hanya boleh huruf, angka spasi dan simbol berikut .,()-')
			],
			[
				'field'  => 'xatribut',
				'label'  => 'Atribut Kriteria',
				'rules'  => 'required|max_length[255]|regex_match[/^[benefit|cost]*$/]',
				'errors' => array('regex_match' => '{field} hanya boleh diisi benefit dan cost')
			],
			[
				'field'  => 'xbobot',
				'label'  => 'Bobot Kriteria',
				'rules'  => 'required|numeric',
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
			->from('tbl_kriteria AS a')
			->join('tbl_sub_kriteria AS b', 'a.id = b.kriteria_id', 'LEFT')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_kriteria AS a')
			->join('tbl_sub_kriteria AS b', 'a.id = b.kriteria_id', 'LEFT')
            ->where($where)
			->order_by('a.id', 'DESC')
            ->get();
	}
}