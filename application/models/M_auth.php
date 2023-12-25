<?php
class M_auth extends CI_Model {
    private $_table = "tbl_user";
    const SESSION_KEY = 'user_id';
    const SESSION_ACCESS_LEVEL = 'hak_akses';

    public function rules() {
        return [
            [
                'field' => 'xusername',
                'label' => 'Username',
                'rules' => 'required|max_length[32]|alpha_numeric'
            ],
            [
                'field' => 'xpassword',
                'label' => 'Password',
                'rules' => 'required|max_length[255]'
            ]
        ];
    }

    public function rules_admin() {
        $rules_admin = array_push($this->rules(),
            [
                'field' => 'xhak_akses',
                'label' => 'Hak Akses',
				'rules' => 'required|max_length[20]|regex_match[/^(admin|kepala_desa|sekretaris_desa|bendahara_desa|kasi_kesejahteraan_sosial|kepala_dusun|ketua_rt)+$/]',
				'errors'=> array('regex_match' => '{field} hanya boleh berupa admin, kepala_desa, sekretaris_desa, bendahara_desa, kasi_kesejahteraan_sosial, kepala_dusun, ketua_rt.')
            ]
        );
        return $rules_admin;
    }

    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get($this->_table);
        $user = $query->row();

        // cek apakah user sudah terdaftar?
        if (!$user) {
            return FALSE;
        }

        // cek apakah passwordnya benar?
        if (!password_verify($password, $user->password)) {
            return FALSE;
        }

        // membuat session
        $this->session->set_userdata([self::SESSION_KEY => $user->id]);
        $this->session->set_userdata([self::SESSION_ACCESS_LEVEL => $user->hak_akses]);
        $this->_update_last_login($user->id);

        return $this->session->has_userdata(self::SESSION_KEY);
    }

    public function current_user() {
        if (!$this->session->has_userdata(self::SESSION_KEY)) {
            return null;
        }

        $user_id = $this->session->userdata(self::SESSION_KEY);
        $query = $this->db->get_where($this->_table, ['id' => $user_id]);
        return $query->row();
    }

    public function current_access_level() {
        if (!$this->session->has_userdata(self::SESSION_ACCESS_LEVEL)) {
            return null;
        }

        return $this->session->userdata(self::SESSION_ACCESS_LEVEL);
    }

    public function is_correct_access_level($access_level = null) {
        return $this->current_access_level() == $access_level;
    }

    public function logout() {
        $this->session->unset_userdata(self::SESSION_KEY);
        $this->session->unset_userdata(self::SESSION_ACCESS_LEVEL);
        return !$this->session->has_userdata(self::SESSION_KEY);
    }

    private function _update_last_login($id) {
        $data = [
            'last_login' => date("Y-m-d H:i:s"),
        ];

        return $this->db->update($this->_table, $data, ['id' => $id]);
    }
}
