<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('masuk') != TRUE) {
            $url = base_url('login');
            redirect($url);
        }
        $this->load->model('m_acara');
        $this->load->helper('url');
    }
    
    function index() {
        // Get dashboard statistics
        $data['total_events'] = $this->db->count_all('tbl_acara');
        $data['total_participants'] = $this->db->count_all('tbl_peserta');
        
        // Count today's check-ins (if waktu_checkin column exists)
        $today = date('Y-m-d');
        $this->db->where('DATE(waktu_checkin)', $today);
        $this->db->where('status_hadir', 1);
        $data['today_checkins'] = $this->db->count_all_results('tbl_peserta');
        
        // Count upcoming events
        $now = date('Y-m-d H:i:s');
        $this->db->where('tanggal >', $now);
        $data['upcoming_events'] = $this->db->count_all_results('tbl_acara');
        
        // Get upcoming events
        $this->db->select('tbl_acara.*, (SELECT COUNT(*) FROM tbl_peserta WHERE tbl_peserta.acara_id = tbl_acara.id) as registered');
        $this->db->from('tbl_acara');
        $this->db->where('tbl_acara.tanggal >=', $now);
        $this->db->order_by('tbl_acara.tanggal', 'ASC');
        $this->db->limit(5);
        $query = $this->db->get();
        $data['events'] = $query->result_array();
        
        // Get recent check-ins
        $this->db->select('tbl_peserta.nama, tbl_peserta.waktu_checkin, tbl_acara.nama_acara');
        $this->db->from('tbl_peserta');
        $this->db->join('tbl_acara', 'tbl_acara.id = tbl_peserta.acara_id');
        $this->db->where('tbl_peserta.status_hadir', 1);
        $this->db->order_by('tbl_peserta.waktu_checkin', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        $data['recent_checkins'] = $query->result_array();
        
        // Load the dashboard view with headers and footers
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('include/v_footer');
    }
}