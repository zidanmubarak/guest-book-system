<?php
class M_acara extends CI_Model {

    // Fungsi untuk acara (events)
    function get_all_acara() {
        return $this->db->count_all("tbl_acara");
    }
    
    // Get the first acara in the database (for default reporting)
    function get_first_acara() {
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_acara');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return NULL;
    }
    
    function get_acara_perpage($offset, $limit) {
        $this->db->select('tbl_acara.*');
        $this->db->from('tbl_acara');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($offset, $limit);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function get_filter_acara_perpage($offset, $limit, $keywords) {
        $this->db->select('tbl_acara.*');
        $this->db->from('tbl_acara');
        $this->db->like('nama_acara', $keywords);
        $this->db->or_like('tanggal', $keywords);
        $this->db->or_like('lokasi', $keywords);
        $this->db->or_like('penyelenggara', $keywords);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($offset, $limit);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function get_all_acara_list() {
        $this->db->select('id, nama_acara, tanggal');
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get('tbl_acara');
        return $query->result_array();
    }
    
    function simpan_acara($nama_acara, $tanggal, $lokasi, $deskripsi, $penyelenggara, $kapasitas, $poster, $user_id, $user_nama) {
        $data = array(
            'nama_acara' => $nama_acara,
            'tanggal' => $tanggal,
            'lokasi' => $lokasi,
            'deskripsi' => $deskripsi,
            'penyelenggara' => $penyelenggara,
            'kapasitas' => $kapasitas,
            'poster' => $poster,
            'user_id' => $user_id,
            'user_nama' => $user_nama,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        return $this->db->insert('tbl_acara', $data);
    }
    
    function get_data_acara_by_kode($kode) {
        $this->db->where('id', $kode);
        return $this->db->get('tbl_acara');
    }
    
    function get_poster_by_id($id) {
        $this->db->select('poster');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_acara');
        
        if($query->num_rows() > 0) {
            return $query->row()->poster;
        }
        return '';
    }
    
    function update_acara($id, $nama_acara, $tanggal, $lokasi, $deskripsi, $penyelenggara, $kapasitas, $poster, $user_id, $user_nama) {
        $data = array(
            'nama_acara' => $nama_acara,
            'tanggal' => $tanggal,
            'lokasi' => $lokasi,
            'deskripsi' => $deskripsi,
            'penyelenggara' => $penyelenggara,
            'kapasitas' => $kapasitas,
            'poster' => $poster,
            'updated_at' => date('Y-m-d H:i:s'),
            'user_id' => $user_id,
            'user_nama' => $user_nama
        );
        
        $this->db->where('id', $id);
        return $this->db->update('tbl_acara', $data);
    }
    
    function hapus_acara($id) {
        // Delete all participants associated with this event
        $this->db->where('acara_id', $id);
        $this->db->delete('tbl_peserta');
        
        // Delete the event
        $this->db->where('id', $id);
        return $this->db->delete('tbl_acara');
    }
    
    // Functions for participants
    function get_kategori_peserta() {
        $kategori = array(
            'umum' => 'Umum',
            'vip' => 'VIP',
            'pembicara' => 'Pembicara',
            'panitia' => 'Panitia',
            'media' => 'Media',
            'sponsor' => 'Sponsor'
        );
        return $kategori;
    }
    
    function simpan_peserta($acara_id, $nama, $email, $no_hp, $institusi, $jabatan, $kategori, $kode_undangan, $foto, $user_id, $user_nama) {
        $data = array(
            'acara_id' => $acara_id,
            'nama' => $nama,
            'email' => $email,
            'no_hp' => $no_hp,
            'institusi' => $institusi,
            'jabatan' => $jabatan,
            'kategori' => $kategori,
            'kode_undangan' => $kode_undangan,
            'foto' => $foto,
            'status_hadir' => 0,
            'user_id' => $user_id,
            'user_nama' => $user_nama,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        return $this->db->insert('tbl_peserta', $data);
    }
    
    function get_peserta_by_acara($acara_id) {
        $this->db->where('acara_id', $acara_id);
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get('tbl_peserta');
        return $query->result_array();
    }
    
    function get_peserta_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('tbl_peserta');
    }
    
    function check_in_peserta($kode_undangan) {
        // Check if invitation code is valid
        $this->db->where('kode_undangan', $kode_undangan);
        $query = $this->db->get('tbl_peserta');
        
        if($query->num_rows() > 0) {
            $peserta = $query->row();
            
            // If not already checked in, update status
            if($peserta->status_hadir == 0) {
                $this->db->where('kode_undangan', $kode_undangan);
                $update_data = array(
                    'status_hadir' => 1,
                    'waktu_checkin' => date('Y-m-d H:i:s')
                );
                $this->db->update('tbl_peserta', $update_data);
                
                // Verify the update was successful
                $this->db->where('kode_undangan', $kode_undangan);
                $check_query = $this->db->get('tbl_peserta');
                $updated_peserta = $check_query->row();
                
                // Return true only if status_hadir is actually 1
                return ($updated_peserta->status_hadir == 1);
            }
            // Already checked in
            return false;
        }
        // Invalid invitation code
        return false;
    }
    
    function get_total_peserta($acara_id) {
        $this->db->where('acara_id', $acara_id);
        return $this->db->count_all_results('tbl_peserta');
    }
    
    function get_peserta_hadir($acara_id) {
        $this->db->where('acara_id', $acara_id);
        $this->db->where('status_hadir', 1);
        return $this->db->count_all_results('tbl_peserta');
    }

    function hapus_peserta($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_peserta');
    }
    
    function get_statistik_kategori($acara_id) {
        $this->db->select('kategori, COUNT(*) as jumlah');
        $this->db->where('acara_id', $acara_id);
        $this->db->group_by('kategori');
        $query = $this->db->get('tbl_peserta');
        
        $hasil = array();
        foreach($query->result_array() as $row) {
            $hasil[$row['kategori']] = $row['jumlah'];
        }
        
        return $hasil;
    }
    
    // Dashboard methods
    function count_all_events() {
        return $this->db->count_all('tbl_acara');
    }
    
    function count_all_participants() {
        return $this->db->count_all('tbl_peserta');
    }
    
    function count_today_checkins() {
        $today = date('Y-m-d');
        $this->db->where('DATE(waktu_checkin)', $today);
        $this->db->where('status_hadir', 1);
        return $this->db->count_all_results('tbl_peserta');
    }
    
    function count_upcoming_events() {
        $now = date('Y-m-d H:i:s');
        $this->db->where('tanggal >', $now);
        return $this->db->count_all_results('tbl_acara');
    }
    
    function get_upcoming_events($limit = 5) {
        $now = date('Y-m-d H:i:s');
        
        $this->db->select('tbl_acara.*, (SELECT COUNT(*) FROM tbl_peserta WHERE tbl_peserta.acara_id = tbl_acara.id) as registered');
        $this->db->from('tbl_acara');
        $this->db->where('tbl_acara.tanggal >=', $now);
        $this->db->order_by('tbl_acara.tanggal', 'ASC');
        $this->db->limit($limit);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function get_recent_checkins($limit = 5) {
        $this->db->select('tbl_peserta.nama, tbl_peserta.waktu_checkin, tbl_acara.nama_acara');
        $this->db->from('tbl_peserta');
        $this->db->join('tbl_acara', 'tbl_acara.id = tbl_peserta.acara_id');
        $this->db->where('tbl_peserta.status_hadir', 1);
        $this->db->order_by('tbl_peserta.waktu_checkin', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    // Create QR code for guest
    function generate_qr_code($kode_undangan) {
        // This would typically use a QR code library
        // Return the URL or data URI of the generated QR code
        return $kode_undangan;
    }

    function get_kategori_hadir($acara_id) {
        // Get attendees by category 
        $this->db->select('kategori, COUNT(*) as jumlah');
        $this->db->where('acara_id', $acara_id);
        $this->db->where('status_hadir', 1); // Pastikan ini adalah peserta yang hadir
        $this->db->group_by('kategori');
        $query = $this->db->get('tbl_peserta');
        
        $hasil = array();
        foreach($query->result_array() as $row) {
            $hasil[$row['kategori']] = (int)$row['jumlah']; // Pastikan jumlah adalah integer
        }
        
        return $hasil;
    }
    
}