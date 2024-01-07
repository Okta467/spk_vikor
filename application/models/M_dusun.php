<?php
class M_dusun extends CI_Model {
	private $_table = 'tbl_dusun';

	const SELECT_JOIN_ALL = '
		a.id AS dusun_id, a.nama AS dusun, a.alamat AS alamat_dusun, a.created_at AS created_at_dusun, a.updated_at AS updated_at_dusun,
        b.id AS rt_id, b.nama AS rt, b.alamat AS alamat_rt, b.created_at AS created_at_rt, b.updated_at AS updated_at_rt';

	/**
	 * Rules insert/update tbl_dusun
	 * 
	 * @return array<validation_rules
	 */
	public function rules($nama_is_unique = true) {
		$nama_is_unique   = $nama_is_unique ? '|is_unique[tbl_dusun.nama]' : '';

		return [
			[
				'field'  => 'xnama',
				'label'  => 'Nama Dusun',
				'rules'  => 'required|max_length[255]|regex_match[/^[a-zA-Z0-9.,()\- ]*$/]' . $nama_is_unique,
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
			->from('tbl_dusun AS a')
			->join('tbl_rt AS b', 'a.id = b.dusun_id', 'LEFT')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_dusun AS a')
			->join('tbl_rt AS b', 'a.id = b.dusun_id', 'LEFT')
            ->where($where)
			->order_by('a.id', 'DESC')
            ->get();
	}
}