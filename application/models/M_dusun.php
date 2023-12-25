<?php
class M_dusun extends CI_Model {
	private $_table = 'tbl_dusun';

	/**
	 * Rules insert/update tbl_dusun
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
}