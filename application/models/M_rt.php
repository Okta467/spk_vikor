<?php
class M_rt extends CI_Model {
	private $_table = 'tbl_rt';

	const SELECT_JOIN_ALL = '
        a.id AS id_rt, a.nama AS rt, a.alamat AS alamat_rt, a.created_at AS created_at_rt, a.updated_at AS updated_at_rt,
        b.id AS id_dusun, b.nama AS dusun, b.alamat AS alamat_dusun, b.created_at AS created_at_dusun, b.updated_at AS updated_at_dusun';

	/**
	 * Rules insert/update tbl_rt
	 * 
	 * @return array<validation_rules
	 */
	public function rules() {
		return [
			[
				'field'  => 'xnama',
				'label'  => 'Nama Dusun',
				'rules'  => 'required|max_length[255]|regex_match[/^[a-zA-Z0-9.,()\- ]*$/]',
				'errors' => array('regex_match' => '{field} hanya boleh huruf, angka spasi dan simbol berikut .,()-')
			],
			[
				'field'  => 'xalamat',
				'label'  => 'Alamat',
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
		return $this->db->get($this->_table);
	}

	public function get_by_id($id) {
		return $this->db->get_where($this->_table, array('id' => $id));
	}

	public function get_where($where) {
		return $this->db->get_where($this->_table, $where);
	}

	public function get_join_all() {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_rt AS a')
			->join('tbl_dusun AS b', 'a.dusun_id = b.id', 'LEFT')
			->join('tbl_rt AS c', 'a.rt_id = c.id', 'LEFT')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_rt AS a')
			->join('tbl_dusun AS b', 'a.dusun_id = b.id', 'LEFT')
			->join('tbl_rt AS c', 'a.rt_id = c.id', 'LEFT')
            ->where($where)
			->order_by('a.id', 'DESC')
            ->get();
	}
}