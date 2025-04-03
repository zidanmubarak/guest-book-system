<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        // Periksa apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('guest_model');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form', 'file', 'string', 'date']);
    }

    /**
     * Menampilkan daftar tamu
     */
    public function index() {
        $data['title'] = 'Daftar Tamu';
        $data['guests'] = $this->guest_model->get_all_guests();
        
        $this->load->view('templates/admin_template', [
            'content' => 'guest/list',
            'data' => $data
        ]);
    }

    /**
     * Menampilkan form tambah tamu
     */
    public function add() {
        $data['title'] = 'Tambah Tamu Baru';
        $data['departments'] = $this->guest_model->get_departments();
        
        // Rules validasi
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('purpose', 'Tujuan', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_template', [
                'content' => 'guest/add',
                'data' => $data
            ]);
        } else {
            // Upload foto jika ada
            $photo = '';
            if (!empty($_FILES['photo']['name'])) {
                $config['upload_path'] = './uploads/guests/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = 'guest_' . time() . '_' . random_string('alnum', 8);
                
                // Buat direktori jika belum ada
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('photo')) {
                    $photo_data = $this->upload->data();
                    $photo = $photo_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }
            }
            
            // Simpan data tamu
            $data = [
                'name' => $this->input->post('name'),
                'institution' => $this->input->post('institution'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'purpose' => $this->input->post('purpose'),
                'person_to_meet' => $this->input->post('person_to_meet'),
                'check_in' => date('Y-m-d H:i:s'),
                'notes' => $this->input->post('notes'),
                'photo' => $photo,
                'status' => 'waiting',
                'created_by' => $this->session->userdata('user_id')
            ];
            
            $guest_id = $this->guest_model->add_guest($data);
            
            if ($guest_id) {
                $this->session->set_flashdata('success', 'Data tamu berhasil ditambahkan.');
                redirect('guests');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data tamu.');
                redirect('guests/add');
            }
        }
    }

    /**
     * Menampilkan form edit tamu
     */
    public function edit($id) {
        $data['title'] = 'Edit Data Tamu';
        $data['guest'] = $this->guest_model->get_guest_by_id($id);
        $data['departments'] = $this->guest_model->get_departments();
        
        if (!$data['guest']) {
            $this->session->set_flashdata('error', 'Data tamu tidak ditemukan.');
            redirect('guests');
        }
        
        // Rules validasi
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('purpose', 'Tujuan', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_template', [
                'content' => 'guest/edit',
                'data' => $data
            ]);
        } else {
            // Upload foto jika ada
            $photo = $data['guest']->photo;
            if (!empty($_FILES['photo']['name'])) {
                $config['upload_path'] = './uploads/guests/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = 'guest_' . time() . '_' . random_string('alnum', 8);
                
                // Buat direktori jika belum ada
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('photo')) {
                    $photo_data = $this->upload->data();
                    
                    // Hapus foto lama jika ada
                    if (!empty($photo) && file_exists('./uploads/guests/' . $photo)) {
                        unlink('./uploads/guests/' . $photo);
                    }
                    
                    $photo = $photo_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }
            }
            
            // Update data tamu
            $update_data = [
                'name' => $this->input->post('name'),
                'institution' => $this->input->post('institution'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'purpose' => $this->input->post('purpose'),
                'person_to_meet' => $this->input->post('person_to_meet'),
                'notes' => $this->input->post('notes'),
                'photo' => $photo,
                'status' => $this->input->post('status')
            ];
            
            $updated = $this->guest_model->update_guest($id, $update_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Data tamu berhasil diperbarui.');
                redirect('guests');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data tamu.');
                redirect('guests/edit/' . $id);
            }
        }
    }

    /**
     * Menampilkan detail tamu
     */
    public function view($id) {
        $data['title'] = 'Detail Tamu';
        $data['guest'] = $this->guest_model->get_guest_by_id($id);
        
        if (!$data['guest']) {
            $this->session->set_flashdata('error', 'Data tamu tidak ditemukan.');
            redirect('guests');
        }
        
        $this->load->view('templates/admin_template', [
            'content' => 'guest/detail',
            'data' => $data
        ]);
    }

    /**
     * Menghapus data tamu
     */
    public function delete($id) {
        $guest = $this->guest_model->get_guest_by_id($id);
        
        if (!$guest) {
            $this->session->set_flashdata('error', 'Data tamu tidak ditemukan.');
            redirect('guests');
        }
        
        // Hapus foto jika ada
        if (!empty($guest->photo) && file_exists('./uploads/guests/' . $guest->photo)) {
            unlink('./uploads/guests/' . $guest->photo);
        }
        
        $deleted = $this->guest_model->delete_guest($id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Data tamu berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data tamu.');
        }
        
        redirect('guests');
    }

    /**
     * Check-out tamu
     */
    public function checkout($id) {
        $guest = $this->guest_model->get_guest_by_id($id);
        
        if (!$guest) {
            $this->session->set_flashdata('error', 'Data tamu tidak ditemukan.');
            redirect('guests');
        }
        
        if ($guest->status == 'completed') {
            $this->session->set_flashdata('error', 'Tamu sudah check-out.');
            redirect('guests');
        }
        
        $updated = $this->guest_model->checkout_guest($id);
        
        if ($updated) {
            $this->session->set_flashdata('success', 'Tamu berhasil di-checkout.');
        } else {
            $this->session->set_flashdata('error', 'Gagal melakukan checkout.');
        }
        
        redirect('guests');
    }
}