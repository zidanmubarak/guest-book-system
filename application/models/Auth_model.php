<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function login_temp($username, $password) {
        // Hard-coded admin check untuk sementara
        if ($username === 'admin' && $password === 'admin123') {
            // Ambil data user admin dari database
            $this->db->where('username', 'admin');
            $query = $this->db->get('users');
            
            if ($query->num_rows() == 1) {
                return $query->row();
            } else {
                // Jika tidak ada di database, buat object user dummy
                $user = new stdClass();
                $user->id = 1;
                $user->username = 'admin';
                $user->name = 'Administrator';
                $user->email = 'admin@example.com';
                $user->role = 'admin';
                $user->theme_preference = 'light';
                return $user;
            }
        }
        
        return FALSE;
    }

    /**
     * Mendaftarkan user baru
     *
     * @param array $data Data user
     * @return integer|boolean ID user jika berhasil, FALSE jika gagal
     */
    public function register($data) {
        $this->db->insert('users', $data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        
        return FALSE;
    }

    /**
     * Update waktu login terakhir
     *
     * @param integer $user_id ID user
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function update_last_login($user_id) {
        $this->db->where('id', $user_id);
        $this->db->update('users', ['last_login' => date('Y-m-d H:i:s')]);
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Cek apakah registrasi diizinkan
     *
     * @return boolean TRUE jika diizinkan, FALSE jika tidak
     */
    public function is_registration_allowed() {
        $this->db->where('setting_name', 'allow_registration');
        $query = $this->db->get('settings');
        
        if ($query->num_rows() > 0) {
            $setting = $query->row();
            return ($setting->setting_value == '1');
        }
        
        // Default: tidak diizinkan
        return FALSE;
    }

    /**
     * Mendapatkan data user berdasarkan ID
     *
     * @param integer $user_id ID user
     * @return object|boolean User object jika ditemukan, FALSE jika tidak
     */
    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return FALSE;
    }

    /**
     * Update data user
     *
     * @param integer $user_id ID user
     * @param array $data Data yang akan diupdate
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Update password user
     *
     * @param integer $user_id ID user
     * @param string $new_password Password baru (belum di-hash)
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function update_password($user_id, $new_password) {
        $this->db->where('id', $user_id);
        $this->db->update('users', ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Update preferensi tema user
     *
     * @param integer $user_id ID user
     * @param string $theme Tema ('light' atau 'dark')
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function update_theme_preference($user_id, $theme) {
        $this->db->where('id', $user_id);
        $this->db->update('users', ['theme_preference' => $theme]);
        
        if ($this->db->affected_rows() > 0) {
            // Update session
            $this->session->set_userdata('theme', $theme);
            return TRUE;
        }
        
        return FALSE;
    }
}