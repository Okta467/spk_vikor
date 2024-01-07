<?php
class M_sub_kriteria extends CI_Model {
	private $_table = 'tbl_sub_kriteria';

	const SELECT_JOIN_ALL = '
		a.id AS sub_kriteria_id, a.kode AS kode_sub_kriteria, a.nama AS nama_sub_kriteria, a.skor AS skor_sub_kriteria, a.created_at AS created_at_sub_kriteria, a.updated_at AS updated_at_sub_kriteria,
		b.id AS kriteria_id, b.kode AS kode_kriteria, b.nama AS nama_kriteria, b.atribut AS atribut_kriteria, b.bobot AS bobot_kriteria, b.created_at AS created_at_kriteria, b.updated_at AS updated_at_kriteria';

	/**
	 * Rules insert/update tbl_sub_kriteria
	 * 
	 * @return array<validation_rules
	 */
	public function rules() {
		return [
			[
				'field'  => 'xkode',
				'label'  => 'Kode Sub Kriteria',
				'rules'  => 'required|max_length[255]|alpha_numeric',
				'errors' => array('regex_match' => '{field} hanya boleh huruf, angka spasi dan simbol berikut .,()-')
			],
			[
				'field'  => 'xnama',
				'label'  => 'Nama Sub Kriteria',
				'rules'  => 'required|max_length[255]|regex_match[/^[a-zA-Z0-9.,()\- ]*$/]',
				'errors' => array('regex_match' => '{field} hanya boleh huruf, angka spasi dan simbol berikut .,()-')
			],
			[
				'field'  => 'xskor',
				'label'  => 'Skor Sub Kriteria',
				'rules'  => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[10]',
				'errors' => array(
					'greater_than_equal_to' => 'Skor minimal 1',
					'less_than_equal_to' => 'Skor maksimal 10'
				)
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
			->from('tbl_sub_kriteria AS a')
			->join('tbl_kriteria AS b', 'a.kriteria_id = b.id', 'LEFT')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_sub_kriteria AS a')
			->join('tbl_kriteria AS b', 'a.kriteria_id = b.id', 'LEFT')
            ->where($where)
			->order_by('a.id', 'DESC')
            ->get();
	}
}