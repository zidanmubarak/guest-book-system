<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_acara extends CI_Controller {
    function __construct() {
        parent::__construct();
        if($this->session->userdata('masuk') != TRUE) {
            $url = base_url('login');
            redirect($url);
        }
        $this->load->model('m_acara');
        $this->load->library('upload');
        $this->load->helper('url');
        $this->load->library('pagination');
    }
    
    function index() {
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_data_acara');
        $this->load->view('include/v_footer');
    }
    
    function loadRecord($limit = 0) {
        $offset = 10;
        if($limit != 0) {
            $limit = ($limit-1) * $offset;
        }
        $allcount = $this->m_acara->get_all_acara();
        $users_record = $this->m_acara->get_acara_perpage($offset, $limit);
        $config['base_url'] = base_url().'data_acara/loadRecord';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $offset;
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
 
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $limit;
 
        echo json_encode($data);
    }

    // Add filter_data function that was missing
    function filter_data() {
        $offset = 10;
        $keywords = $this->input->post('keywords');
        
        $allcount = $this->m_acara->get_all_acara();
        $users_record = $this->m_acara->get_filter_acara_perpage($offset, 0, $keywords);
        
        $config['base_url'] = base_url().'data_acara/loadRecord';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $offset;
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
 
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = 0;
 
        echo json_encode($data);
    }
    
    // Add function to handle event deletion
    function hapus_acara() {
        $id = $this->input->post('id');
        $poster = $this->input->post('poster');
        
        // Delete the poster file if it exists
        if(!empty($poster)) {
            $poster_path = './assets/images/poster_acara/'.$poster;
            if(file_exists($poster_path)) {
                unlink($poster_path);
            }
        }
        
        $result = $this->m_acara->hapus_acara($id);
        
        if($result) {
            echo "success";
        } else {
            echo "error";
        }
    }
    
    function add_acara() {
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_add_acara');
        $this->load->view('include/v_footer');
    }
    
    function simpan_acara() {
        $nama_acara = strip_tags(addslashes($this->input->post('xnama_acara')));
        $tanggal = strip_tags(addslashes($this->input->post('xtanggal')));
        $lokasi = strip_tags(addslashes($this->input->post('xlokasi')));
        $deskripsi = strip_tags(addslashes($this->input->post('xdeskripsi')));
        $penyelenggara = strip_tags(addslashes($this->input->post('xpenyelenggara')));
        $kapasitas = strip_tags($this->input->post('xkapasitas'));
        $user_id = $this->session->userdata('idadmin');
        $user_nama = $this->session->userdata('nama');
        
        // Configure upload for poster
        $config['upload_path'] = './assets/images/poster_acara/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048;
        $this->upload->initialize($config);
        
        // Handle poster upload
        if($this->upload->do_upload('xposter')) {
            $poster = $this->upload->data('file_name');
        } else {
            $poster = '';
        }
        
        // Save the event data
        $simpan_acara = $this->m_acara->simpan_acara($nama_acara, $tanggal, $lokasi, $deskripsi, $penyelenggara, $kapasitas, $poster, $user_id, $user_nama);
        
        if($simpan_acara){
            $this->session->set_flashdata('msg', 'success-simpan');
        } else {
            $this->session->set_flashdata('msg', 'danger');
        }
        
        redirect('data_acara');
    }

    function update_acara() {
        $id = $this->input->post('xkode');
        $nama_acara = strip_tags(addslashes($this->input->post('xnama_acara')));
        $tanggal = strip_tags(addslashes($this->input->post('xtanggal')));
        $lokasi = strip_tags(addslashes($this->input->post('xlokasi')));
        $deskripsi = strip_tags(addslashes($this->input->post('xdeskripsi')));
        $penyelenggara = strip_tags(addslashes($this->input->post('xpenyelenggara')));
        $kapasitas = strip_tags($this->input->post('xkapasitas'));
        $poster_lama = $this->input->post('xposter_lama');
        $user_id = $this->session->userdata('idadmin');
        $user_nama = $this->session->userdata('nama');
        
        // Handle poster upload if a new one is provided
        if(!empty($_FILES['xposter']['name'])) {
            $config['upload_path'] = './assets/images/poster_acara/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);
            
            if($this->upload->do_upload('xposter')) {
                // If upload successful, get new filename
                $poster = $this->upload->data('file_name');
                
                // Delete old poster if it exists
                if(!empty($poster_lama)) {
                    $poster_path = './assets/images/poster_acara/'.$poster_lama;
                    if(file_exists($poster_path)) {
                        unlink($poster_path);
                    }
                }
            } else {
                // If upload fails, keep using old poster
                $poster = $poster_lama;
            }
        } else {
            // No new poster uploaded, keep using old one
            $poster = $poster_lama;
        }
        
        // Update the event data
        $update_acara = $this->m_acara->update_acara($id, $nama_acara, $tanggal, $lokasi, $deskripsi, $penyelenggara, $kapasitas, $poster, $user_id, $user_nama);
        
        if($update_acara){
            $this->session->set_flashdata('msg', 'success-update');
        } else {
            $this->session->set_flashdata('msg', 'error-update');
        }
        
        redirect('data_acara');
    }
    
    function scan_qr() {
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_scan_qr');
        $this->load->view('include/v_footer');
    }
    
    function check_in() {
        $kode_undangan = $this->input->post('kode_undangan');
        $result = $this->m_acara->check_in_peserta($kode_undangan);
        
        if($result) {
            $data = array(
                'status' => 'success',
                'message' => 'Tamu berhasil di-check in'
            );
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'Kode undangan tidak valid atau tamu sudah check-in'
            );
        }
        
        echo json_encode($data);
    }
    
    function laporan($acara_id = NULL) {
        // If no acara_id provided, get the first available acara
        if($acara_id === NULL) {
            $first_acara = $this->m_acara->get_first_acara();
            if($first_acara) {
                $acara_id = $first_acara['id'];
            } else {
                // No events exist, show empty report
                $data['acara'] = NULL;
                $data['total_peserta'] = 0;
                $data['peserta_hadir'] = 0;
                $data['statistik_kategori'] = array();
                $data['kategori_hadir'] = array();
                
                $this->load->view('include/v_head');
                $this->load->view('include/v_header');
                $this->load->view('include/v_sidebar');
                $this->load->view('acara/v_laporan_acara', $data);
                $this->load->view('include/v_footer');
                return;
            }
        }
        
        // Get report data
        $acara = $this->m_acara->get_data_acara_by_kode($acara_id)->row_array();
        $total_peserta = $this->m_acara->get_total_peserta($acara_id);
        $peserta_hadir = $this->m_acara->get_peserta_hadir($acara_id);
        $statistik_kategori = $this->m_acara->get_statistik_kategori($acara_id);
        $kategori_hadir = $this->m_acara->get_kategori_hadir($acara_id);
        
        // Debug output to log
        error_log('Acara ID: ' . $acara_id);
        error_log('Total Tamu: ' . $total_peserta);
        error_log('Tamu Hadir: ' . $peserta_hadir);
        error_log('Statistik Kategori: ' . print_r($statistik_kategori, true));
        error_log('Kategori Hadir: ' . print_r($kategori_hadir, true));
        
        $data = array(
            'acara' => $acara,
            'total_peserta' => $total_peserta,
            'peserta_hadir' => $peserta_hadir,
            'statistik_kategori' => $statistik_kategori,
            'kategori_hadir' => $kategori_hadir
        );
        
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_laporan_acara', $data);
        $this->load->view('include/v_footer');
    }
    
    // Function to get a list of all events for dropdown
    function get_all_acara_list() {
        $acara_list = $this->m_acara->get_all_acara_list();
        echo json_encode($acara_list);
    }
    
    function peserta($acara_id) {
        $data['acara'] = $this->m_acara->get_data_acara_by_kode($acara_id)->row_array();
        $data['peserta'] = $this->m_acara->get_peserta_by_acara($acara_id);
        
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_peserta_acara', $data);
        $this->load->view('include/v_footer');
    }
    
    function add_peserta($acara_id) {
        $data['acara'] = $this->m_acara->get_data_acara_by_kode($acara_id)->row_array();
        $data['kategori_peserta'] = $this->m_acara->get_kategori_peserta();
        
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_add_peserta', $data);
        $this->load->view('include/v_footer');
    }
    
    function get_edit_acara($id) {
        $data['data_acara'] = $this->m_acara->get_data_acara_by_kode($id);
        
        $this->load->view('include/v_head');
        $this->load->view('include/v_header');
        $this->load->view('include/v_sidebar');
        $this->load->view('acara/v_edit_acara', $data);
        $this->load->view('include/v_footer');
    }
    
    function simpan_peserta() {
        $acara_id = $this->input->post('xacara_id');
        $nama = strip_tags(addslashes($this->input->post('xnama')));
        $email = strip_tags(addslashes($this->input->post('xemail')));
        $no_hp = strip_tags(str_replace(" ", "", $this->input->post('xnohp')));
        $institusi = strip_tags(addslashes($this->input->post('xinstitusi')));
        $jabatan = strip_tags(addslashes($this->input->post('xjabatan')));
        $kategori = strip_tags(addslashes($this->input->post('xkategori')));
        $kode_undangan = strtoupper(substr(md5(time()), 0, 8)); // Generate unique code
        
        // Handle photo if provided
        $image = $this->input->post('xnama_file_foto');
        if(!empty($image)) {
            $nama_peserta = strtolower(preg_replace(array('/[^a-z0-9\- ]/i', '/[ \-]+/'), array('', '-'), $nama));
            $foto = 'foto_'.$nama_peserta.'_peserta_'.date("Y-m-d").'.jpeg';
            
            $data = $image;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents('./assets/images/foto_peserta/'.$foto, $data);
        } else {
            $foto = "";
        }
        
        $user_id = $this->session->userdata('idadmin');
        $user_nama = $this->session->userdata('nama');
        
        // Save participant data
        $simpan_peserta = $this->m_acara->simpan_peserta($acara_id, $nama, $email, $no_hp, $institusi, $jabatan, $kategori, $kode_undangan, $foto, $user_id, $user_nama);
        
        if($simpan_peserta) {
            $this->session->set_flashdata('msg', 'success-simpan');
        } else {
            $this->session->set_flashdata('msg', 'danger');
        }
        
        redirect('data_acara/peserta/'.$acara_id);
    }

    function hapus_peserta() {
        $peserta_id = $this->input->post('id');
        
        // Get peserta details to delete foto if exists
        $peserta = $this->m_acara->get_peserta_by_id($peserta_id)->row_array();
        
        // Delete foto file if exists
        if(!empty($peserta['foto'])) {
            $foto_path = './assets/images/foto_peserta/'.$peserta['foto'];
            if(file_exists($foto_path)) {
                unlink($foto_path);
            }
        }
        
        // Delete participant from database
        $result = $this->m_acara->hapus_peserta($peserta_id);
        
        if($result) {
            echo "success";
        } else {
            echo "error";
        }
    }
    
    function cetak_id_card($peserta_id) {
        $data['peserta'] = $this->m_acara->get_peserta_by_id($peserta_id)->row_array();
        $data['acara'] = $this->m_acara->get_data_acara_by_kode($data['peserta']['acara_id'])->row_array();
        
        $this->load->view('acara/v_cetak_id_card', $data);
    }
    
    function export_peserta($acara_id) {
        // Load library Excel (wrapper untuk PhpSpreadsheet)
        $this->load->library('excel');
        
        // Dapatkan data acara dan peserta
        $acara = $this->m_acara->get_data_acara_by_kode($acara_id)->row_array();
        $peserta = $this->m_acara->get_peserta_by_acara($acara_id);
        
        // Dapatkan instance spreadsheet dari library
        $spreadsheet = $this->excel->getSpreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Tamu');
        
        // Header
        $sheet->setCellValue('A1', 'Daftar Tamu Acara: '.$acara['nama_acara']);
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama');
        $sheet->setCellValue('C3', 'Email');
        $sheet->setCellValue('D3', 'No HP');
        $sheet->setCellValue('E3', 'Institusi');
        $sheet->setCellValue('F3', 'Jabatan');
        $sheet->setCellValue('G3', 'Kategori');
        $sheet->setCellValue('H3', 'Kode Undangan');
        $sheet->setCellValue('I3', 'Status Kehadiran');
        
        // Format header
        $sheet->getStyle('A3:I3')->getFont()->setBold(true);
        $sheet->getStyle('A3:I3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:I3')->getFill()->getStartColor()->setRGB('CCCCCC');
        
        // Isi data
        $row = 4;
        $no = 1;
        
        foreach($peserta as $p) {
            $sheet->setCellValue('A'.$row, $no);
            $sheet->setCellValue('B'.$row, $p['nama']);
            $sheet->setCellValue('C'.$row, $p['email']);
            $sheet->setCellValue('D'.$row, $p['no_hp']);
            $sheet->setCellValue('E'.$row, $p['institusi']);
            $sheet->setCellValue('F'.$row, $p['jabatan']);
            $sheet->setCellValue('G'.$row, $p['kategori']);
            $sheet->setCellValue('H'.$row, $p['kode_undangan']);
            $sheet->setCellValue('I'.$row, ($p['status_hadir'] == 1) ? 'Hadir' : 'Belum Hadir');
            
            $row++;
            $no++;
        }
        
        // Auto size kolom
        foreach(range('A','I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Set border untuk semua cell
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A3:I'.($row-1))->applyFromArray($styleArray);
        
        // Set nama file
        $filename = 'Daftar_Peserta_'.$acara['nama_acara'].'_'.date('Y-m-d').'.xlsx';
        
        // Buat writer
        $writer = $this->excel->createWriter();
        
        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
    
    function generate_qr($kode_undangan) {
        // Load QR Code library
        $this->load->library('ciqrcode');
        
        // Generate QR Code
        $params['data'] = $kode_undangan;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH.'assets/qrcodes/'.$kode_undangan.'.png';
        
        $this->ciqrcode->generate($params);
        
        // Return QR Code image
        $this->output
            ->set_content_type('image/png')
            ->set_output(file_get_contents($params['savename']));
    }
    
}