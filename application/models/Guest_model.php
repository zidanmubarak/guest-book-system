<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mendapatkan semua data tamu
     *
     * @return array Data tamu
     */
    public function get_all_guests() {
        $this->db->order_by('check_in', 'DESC');
        $query = $this->db->get('guests');
        return $query->result();
    }

    /**
     * Mendapatkan tamu berdasarkan ID
     *
     * @param integer $id ID tamu
     * @return object|null Data tamu
     */
    public function get_guest_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('guests');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return null;
    }

    /**
     * Menambahkan tamu baru
     *
     * @param array $data Data tamu
     * @return integer|boolean ID tamu jika berhasil, FALSE jika gagal
     */
    public function add_guest($data) {
        $this->db->insert('guests', $data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        
        return FALSE;
    }

    /**
     * Memperbarui data tamu
     *
     * @param integer $id ID tamu
     * @param array $data Data yang akan diupdate
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function update_guest($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('guests', $data);
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Menghapus data tamu
     *
     * @param integer $id ID tamu
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function delete_guest($id) {
        $this->db->where('id', $id);
        $this->db->delete('guests');
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Melakukan checkout tamu
     *
     * @param integer $id ID tamu
     * @return boolean TRUE jika berhasil, FALSE jika gagal
     */
    public function checkout_guest($id) {
        $data = [
            'check_out' => date('Y-m-d H:i:s'),
            'status' => 'completed'
        ];
        
        $this->db->where('id', $id);
        $this->db->update('guests', $data);
        
        return ($this->db->affected_rows() > 0);
    }

    /**
     * Mendapatkan daftar departemen
     *
     * @return array Daftar departemen
     */
    public function get_departments() {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('departments');
        return $query->result();
    }

    /**
     * Mendapatkan jumlah tamu per status
     *
     * @return array Jumlah tamu per status
     */
    public function get_guests_count_by_status() {
        $this->db->select('status, COUNT(*) as total');
        $this->db->group_by('status');
        $query = $this->db->get('guests');
        
        $result = [
            'waiting' => 0,
            'in-progress' => 0,
            'completed' => 0,
            'canceled' => 0
        ];
        
        foreach ($query->result() as $row) {
            $result[$row->status] = $row->total;
        }
        
        return $result;
    }

    /**
     * Mendapatkan tamu hari ini
     *
     * @return array Data tamu hari ini
     */
    public function get_today_guests() {
        $this->db->where('DATE(check_in)', date('Y-m-d'));
        $this->db->order_by('check_in', 'DESC');
        $query = $this->db->get('guests');
        return $query->result();
    }

    /**
     * Mendapatkan laporan tamu harian
     *
     * @param string $date Tanggal (format: Y-m-d)
     * @return array Data laporan
     */
    public function get_daily_report($date) {
        $this->db->where('DATE(check_in)', $date);
        $this->db->order_by('check_in', 'ASC');
        $query = $this->db->get('guests');
        return $query->result();
    }

    /**
     * Mendapatkan laporan tamu bulanan
     *
     * @param string $month Bulan (format: Y-m)
     * @return array Data laporan
     */
    public function get_monthly_report($month) {
        $this->db->where('DATE_FORMAT(check_in, "%Y-%m")', $month);
        $this->db->order_by('check_in', 'ASC');
        $query = $this->db->get('guests');
        return $query->result();
    }

    /**
     * Mendapatkan laporan tamu untuk ekspor
     *
     * @param string $start_date Tanggal mulai (format: Y-m-d)
     * @param string $end_date Tanggal akhir (format: Y-m-d)
     * @return array Data laporan
     */
    public function get_export_report($start_date, $end_date) {
        $this->db->where('DATE(check_in) >=', $start_date);
        $this->db->where('DATE(check_in) <=', $end_date);
        $this->db->order_by('check_in', 'ASC');
        $query = $this->db->get('guests');
        return $query->result();
    }
}