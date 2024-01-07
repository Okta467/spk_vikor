<?php
class M_user extends CI_Model {
	private $_table = 'tbl_user';

	const SELECT_JOIN_ALL = '
		a.id AS user_id, a.nama_pemilik, a.username, a.password, a.hak_akses, a.created_at AS created_at_user, a.last_login,
        b.id AS dusun_id, b.nama AS dusun, b.alamat AS alamat_dusun, b.created_at AS created_at_dusun, b.updated_at AS updated_at_dusun,
        c.id AS rt_id, c.nama AS rt, c.alamat AS alamat_rt, c.created_at AS created_at_rt, c.updated_at AS updated_at_rt';

	/**
	 * Rules insert/update tbl_user
	 * 
	 * @return array<validation_rules
	 */
	public function rules($dusun_id_is_required = true, $rt_id_is_required = true, $password_is_required = true, $username_is_unique = true) {
		$dusun_id_is_required = $dusun_id_is_required ? '|required' : '';
		$rt_id_is_required    = $rt_id_is_required ? '|required' : '';
		$password_is_required = $password_is_required ? '|required' : '';
		$username_is_unique   = $username_is_unique ? '|is_unique[tbl_user.username]' : '';

		return [
			[
				'field'  => 'xdusun_id',
				'label'  => 'ID Dusun',
				'rules'  => 'integer' . $dusun_id_is_required,
			],
			[
				'field'  => 'xrt_id',
				'label'  => 'ID RT',
				'rules'  => 'integer' . $rt_id_is_required,
			],
			[
				'field'  => 'xusername',
				'label'  => 'Username',
				'rules'  => 'required|max_length[32]|alpha_numeric' . $username_is_unique,
				'errors' => array('is_unique' => 'Username tidak boleh sama dengan pengguna lain.')
			],
			[
				'field' => 'xpassword',
				'label' => 'Password',
				'rules' => 'max_length[255]' . $password_is_required,
			],
			[
				'field' => 'xhak_akses',
				'label' => 'Hak Akses',
				'rules' => 'required|max_length[20]|regex_match[/^(admin|kepala_desa|sekretaris_desa|bendahara_desa|kasi_kesejahteraan_sosial|kepala_dusun|ketua_rt)+$/]',
				'errors' => array('regex_match' => '{field} hanya boleh berupa admin, kepala_desa, sekretaris_desa, bendahara_desa, kasi_kesejahteraan_sosial, kepala_dusun, ketua_rt.')
			],
		];
	}

	// Rules to update password only in profile page for all roles
	public function rules_update_password() {
		return [
			[
				'field' => 'xcur_password',
				'label' => 'Password Sekarang',
				'rules' => 'required|min_length[6]|max_length[255]',
				'errors' => array('min_length' => 'Password Sekarang minimal 6 karakter.')
			],
			[
				'field' => 'xnew_password',
				'label' => 'Password Baru',
				'rules' => 'required|min_length[6]|max_length[255]',
				'errors' => array('min_length' => 'Password Baru minimal 6 karakter.')
			],
			[
				'field' => 'xnew_password2',
				'label' => 'Password Baru (Ketikkan Ulang)',
				'rules' => 'required|min_length[6]|max_length[255]',
				'errors' => array('min_length' => 'Password Baru (ketikkan Ulang) minimal 6 karakter.')
			],
		];
	}

	public function insert($data) {
		return $this->db->insert($this->_table, $data);
	}

	public function update($id, $data) {
		return $this->db->update ($this->_table, $data, array('id' => $id));
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
			->from('tbl_user AS a')
			->join('tbl_dusun AS b', 'a.dusun_id = b.id', 'LEFT')
			->join('tbl_rt AS c', 'a.rt_id = c.id', 'LEFT')
			->order_by('a.id', 'DESC')
			->get();
	}

	public function get_join_all_where($where) {
		return $this->db
			->select(self::SELECT_JOIN_ALL)
			->from('tbl_user AS a')
			->join('tbl_dusun AS b', 'a.dusun_id = b.id', 'LEFT')
			->join('tbl_rt AS c', 'a.rt_id = c.id', 'LEFT')
			->where($where)
			->order_by('a.id', 'DESC')
			->get();
	}
}
