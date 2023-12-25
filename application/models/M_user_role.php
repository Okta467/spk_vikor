<?php
class M_user_role extends CI_Model {
	private $_table = 'tbl_user_role';

	/**
	 * Rules insert/update tbl_user_role
	 * 
	 * @param bool $name_is_unique set is_unique to feild xusername using tbl_user_role.name
	 * @return array<validation_rules
	 */
	public function rules($name_is_unique = true) {
		$name_is_unique = $name_is_unique ? '|is_unique[tbl_user_role.name]' : '';

		return [
			[
				'field'  => 'xnama_role',
				'label'  => 'Nama Role',
				'rules'  => 'required|max_length[32]|alpha_dash' . $name_is_unique,
				'errors' => array('is_unique' => 'Nama role sudah ada.')
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
