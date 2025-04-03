<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mendapatkan semua pengaturan
     *
     * @return array Pengaturan
     */
    public function get_all_settings() {
        $query = $this->db->get('settings');
        
        $settings = [];
        foreach ($query->result() as $row) {
            $settings[$row->setting_name] = $row->setting_value;
        }
        
        return $settings;
    }

    /**
     * Mendapatkan nilai pengaturan
     *
     * @param string $name Nama pengaturan
     * @param mixed $default Nilai default jika pengaturan tidak ditemukan
     * @return mixed Nilai pengaturan
     */
    public function get_setting($name, $default = null) {
        $this->db->where('setting_name', $name);
        $query = $this->db->get('settings');
        
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        
        return $default;
    }

    /**
     * Menyimpan pengaturan
     *
     * @param string $name Nama pengaturan
     * @param string $value Nilai pengaturan
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function save_setting($name, $value) {
        $this->db->where('setting_name', $name);
        $query = $this->db->get('settings');
        
        if ($query->num_rows() > 0) {
            // Update
            $this->db->where('setting_name', $name);
            $this->db->update('settings', ['setting_value' => $value]);
        } else {
            // Insert
            $this->db->insert('settings', [
                'setting_name' => $name,
                'setting_value' => $value
            ]);
        }
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Menyimpan beberapa pengaturan sekaligus
     *
     * @param array $settings Array pengaturan (key => value)
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function save_settings($settings) {
        $success = true;
        
        foreach ($settings as $name => $value) {
            $result = $this->save_setting($name, $value);
            $success = $success && $result;
        }
        
        return $success;
    }
}