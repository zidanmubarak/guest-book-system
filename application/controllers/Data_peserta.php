<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_peserta extends CI_Controller{
    function __construct(){
        parent::__construct();
        if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('admin');
            redirect($url);
        };
        $this->load->model('m_peserta');
        $this->load->model('m_acara');
        $this->load->library('upload');
        $this->load->helper('url');
        $this->load->library('pagination');
    }
    
    function index(){
        $this->load->view('include/v_head');
        $this->load->view('peserta/v_data_peserta');        
    }
    
    function loadRecord($limit=0){
        $offset = 10;
        if($limit != 0){
            $limit = ($limit-1) * $offset;
        }
        $allcount = $this->m_peserta->get_all_peserta();
        $peserta_record = $this->m_peserta->get_peserta_perpage($offset,$limit);
        $config['base_url'] = base_url().'data_peserta/loadRecord';
        $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $allcount;
            $config['per_page'] = $offset;
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tag_close']  = '</span></li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tag_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
     
            $this->pagination->initialize($config);
            
            $data['csrfName'] = $this->security->get_csrf_token_name();
            $data['csrfHash'] = $this->security->get_csrf_hash();
     
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $users_record;
            $data['row'] = $limit;
     
            echo json_encode($data);
        } else {
            $this->loadRecord($limit=0);
        };
        $config['total_rows'] = $allcount;
        $config['per_page'] = $offset;
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $peserta_record;
        $data['row'] = $limit;
 
        echo json_encode($data);
    }
    
    function add_peserta(){
        $x['acara'] = $this->m_acara->get_all_acara_aktif();
        $this->load->view('include/v_head');
        $this->load->view('peserta/v_add_peserta', $x);
    }
    
    function simpan_peserta(){
        $id_acara = strip_tags($this->input->post('xid_acara'));
        $nama = strip_tags(addslashes($this->input->post('xnama')));
        $email = strip_tags($this->input->post('xemail'));
        $no_hp = strip_tags(str_replace(" ", "", $this->input->post('xno_hp')));
        $instansi = strip_tags(addslashes($this->input->post('xinstansi')));
        $kategori = strip_tags($this->input->post('xkategori')); // VIP, Umum, Media
        $image = $_POST['xnama_file_foto'];
        
        if(!empty($image)) {
            $nama_peserta = strtolower(preg_replace(array('/[^a-z0-9\- ]/i', '/[ \-]+/'), array('', '-'), $nama));
            $foto = 'foto_'.$nama_peserta.'_acara_'.date("Y-m-d").'.jpeg';
        } else {
            $foto = "";
        }
        
        $user_id = $this->session->userdata('idadmin');
        $user_nama = $this->session->userdata('nama');
        
        // Generate kode unik peserta
        $kode_peserta = 'PST-'.strtoupper(substr(md5(time()), 0, 6));
        
        $simpan_peserta = $this->m_peserta->simpan_peserta($id_acara, $nama, $email, $no_hp, $instansi, $kategori, $foto, $kode_peserta, $user_id, $user_nama);
        
        if($simpan_peserta){
            // Simpan foto
            if(!empty($image)){
                $data = $image;
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                file_put_contents('./assets/images/foto_peserta/'.$foto, $data);
            }
            
            echo $this->session->set_flashdata('msg', 'success-simpan');
            redirect('data_peserta');
        } else {
            echo $this->session->set_flashdata('msg', 'error');
            redirect('data_peserta/add_peserta');
        }
    }
    
    function get_edit_peserta(){
        $id = $this->uri->segment(3);
        $x['data_peserta'] = $this->m_peserta->get_peserta_by_id($id);
        $x['acara'] = $this->m_acara->get_all_acara_aktif();
        $this->load->view('include/v_head', $x);
        $this->load->view('peserta/v_edit_peserta', $x);
    }
    
    function update_peserta(){
        $id_peserta = strip_tags($this->input->post('xkode'));
        $id_acara = strip_tags($this->input->post('xid_acara'));
        $nama = strip_tags(addslashes($this->input->post('xnama')));
        $email = strip_tags($this->input->post('xemail'));
        $no_hp = strip_tags(str_replace(" ", "", $this->input->post('xno_hp')));
        $instansi = strip_tags(addslashes($this->input->post('xinstansi')));
        $kategori = strip_tags($this->input->post('xkategori'));
        $image = $_POST['xnama_file_foto'];
        
        if(!empty($image)) {
            $nama_peserta = strtolower(preg_replace(array('/[^a-z0-9\- ]/i', '/[ \-]+/'), array('', '-'), $nama));
            $foto = 'foto_'.$nama_peserta.'_acara_'.date("Y-m-d").'.jpeg';
        } else {
            $foto = $this->input->post('xfoto_lama');
        }
        
        $user_id = $this->session->userdata('idadmin');
        $user_nama = $this->session->userdata('nama');
        
        $update_peserta = $this->m_peserta->update_peserta($id_peserta, $id_acara, $nama, $email, $no_hp, $instansi, $kategori, $foto, $user_id, $user_nama);
        
        if($update_peserta){
            // Update foto jika ada
            if(!empty($image) && $image != $this->input->post('xfoto_lama')){
                // Hapus foto lama jika ada
                $foto_lama = $this->input->post('xfoto_lama');
                if(!empty($foto_lama) && file_exists('./assets/images/foto_peserta/'.$foto_lama)){
                    unlink('./assets/images/foto_peserta/'.$foto_lama);
                }
                
                // Simpan foto baru
                $data = $image;
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                file_put_contents('./assets/images/foto_peserta/'.$foto, $data);
            }
            
            echo $this->session->set_flashdata('msg', 'success-update');
            redirect('data_peserta');
        } else {
            echo $this->session->set_flashdata('msg', 'error');
            redirect('data_peserta/get_edit_peserta/'.$id_peserta);
        }
    }
    
    function hapus_peserta(){
        $id = $this->input->post('id');
        $foto = $this->input->post('foto');
        
        if(!empty($foto) && file_exists('./assets/images/foto_peserta/'.$foto)){
            unlink('./assets/images/foto_peserta/'.$foto);
        }
        
        // Hapus QR Code jika ada
        $kode_peserta = $this->input->post('kode_peserta');
        if(file_exists('./assets/images/qrcode/'.$kode_peserta.'.png')){
            unlink('./assets/images/qrcode/'.$kode_peserta.'.png');
        }
        
        $hapus = $this->m_peserta->hapus_peserta($id);
        if($hapus){
            echo json_encode("success");
        } else {
            echo json_encode("gagal");
        }
    }
    
    function hapus_foto(){
        $id = $this->input->post('id');
        $foto = $this->input->post('foto');

        if(file_exists('./assets/images/foto_peserta/'.$foto)){
            $path = './assets/images/foto_peserta/'.$foto;
            unlink($path);
            $update = $this->m_peserta->update_foto_peserta($id);
            if($update) {
                $callback = array(
                    'pesan' => 'success'
                );
            } else {
                $callback = array(
                    'pesan' => 'gagal'
                );
            }
            echo json_encode($callback);
        } else {
            $update = $this->m_peserta->update_foto_peserta($id);
            if($update) {
                $callback = array(
                    'pesan' => 'success'
                );
            } else {
                $callback = array(
                    'pesan' => 'gagal'
                );
            }
            echo json_encode($callback);
        }
    }
    
    // Cetak kartu peserta
    function cetak_kartu($id){
        $data['peserta'] = $this->m_peserta->get_peserta_by_id($id);
        $data['acara'] = $this->m_acara->get_acara_by_id($data['peserta']->id_acara);
        
        $this->load->view('peserta/v_cetak_kartu', $data);
    }
    
    // Cetak QR Code
    function cetak_qr($id){
        $this->load->library('ciqrcode');
        
        $data['peserta'] = $this->m_peserta->get_peserta_by_id($id);
        
        // Generate QR code
        $params['data'] = $data['peserta']->kode_peserta;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH.'/assets/images/qrcode/'.$data['peserta']->kode_peserta.'.png';
        
        $this->ciqrcode->generate($params);
        
        $data['qr_image'] = base_url().'assets/images/qrcode/'.$data['peserta']->kode_peserta.'.png';
        $data['acara'] = $this->m_acara->get_acara_by_id($data['peserta']->id_acara);
        
        $this->load->view('peserta/v_cetak_qr', $data);
    }
    
    // Check-in peserta
    function checkin(){
        $kode_peserta = $this->input->post('kode_peserta');
        
        // Validasi input
        if(empty($kode_peserta)){
            $response = array(
                'status' => 'error',
                'message' => 'Kode peserta tidak boleh kosong'
            );
            echo json_encode($response);
            return;
        }
        
        // Cek keberadaan peserta
        $peserta = $this->m_peserta->get_peserta_by_kode($kode_peserta);
        
        if($peserta->num_rows() > 0){
            $peserta_data = $peserta->row();
            
            // Cek apakah sudah check-in
            if($peserta_data->status_checkin == 'y'){
                $response = array(
                    'status' => 'error',
                    'message' => 'Peserta sudah melakukan check-in sebelumnya'
                );
            } else {
                // Proses check-in
                $waktu_checkin = date('Y-m-d H:i:s');
                $update = $this->m_peserta->update_checkin($kode_peserta, $waktu_checkin);
                
                if($update){
                    $response = array(
                        'status' => 'success',
                        'message' => 'Check-in berhasil',
                        'data' => array(
                            'id' => $peserta_data->id,
                            'nama' => $peserta_data->nama,
                            'instansi' => $peserta_data->instansi,
                            'kategori' => $peserta_data->kategori,
                            'waktu_checkin' => $waktu_checkin
                        )
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Gagal melakukan check-in'
                    );
                }
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Kode peserta tidak ditemukan'
            );
        }
        
        echo json_encode($response);
    }
    }
    
    function filter_data($limit=0){
        $keywords=$this->input->post('keywords');
        if($keywords !== null) {
            $offset = 100;
            if($limit != 0){
                $limit = ($limit-1) * $offset;
            }
            $allcount = $this->m_peserta->get_all_peserta();
            $users_record = $this->m_peserta->get_filter_peserta_perpage($offset,$limit,$keywords);
            $config['base_url'] = base_url().'data_peserta/filter_data';
            $config['use_page_numbers'] = TRUE