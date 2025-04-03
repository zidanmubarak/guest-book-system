<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        // Periksa apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('setting_model');
        $this->load->model('auth_model');
        $this->load->library('form_validation');
    }

    public function index() {
        // Redirect ke halaman profil
        redirect('settings/profile');
    }

    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Pengaturan Profil';
        $data['user'] = $this->auth_model->get_user_by_id($user_id);
        
        // Rules validasi
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_template', [
                'content' => 'setting/profile',
                'data' => $data
            ]);
        } else {
            // Update profil
            $update_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email')
            ];
            
            $updated = $this->auth_model->update_user($user_id, $update_data);
            
            if ($updated) {
                // Update session
                $this->session->set_userdata('name', $update_data['name']);
                $this->session->set_userdata('email', $update_data['email']);
                
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
            }
            
            redirect('settings/profile');
        }
    }

    public function change_password() {
        $user_id = $this->session->userdata('user_id');
        $data['title'] = 'Ubah Password';
        
        // Rules validasi
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'trim|required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'trim|required|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_template', [
                'content' => 'setting/change_password',
                'data' => $data
            ]);
        } else {
            // Verifikasi password saat ini
            $user = $this->auth_model->get_user_by_id($user_id);
            
            if (password_verify($this->input->post('current_password'), $user->password)) {
                // Update password
                $updated = $this->auth_model->update_password($user_id, $this->input->post('new_password'));
                
                if ($updated) {
                    $this->session->set_flashdata('success', 'Password berhasil diubah.');
                    redirect('settings/profile');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengubah password.');
                    redirect('settings/change_password');
                }
            } else {
                $this->session->set_flashdata('error', 'Password saat ini salah.');
                redirect('settings/change_password');
            }
        }
    }

    public function appearance() {
        $data['title'] = 'Pengaturan Tampilan';
        $data['current_theme'] = $this->session->userdata('theme');
        
        // Rules validasi
        $this->form_validation->set_rules('theme', 'Tema', 'trim|required|in_list[light,dark]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_template', [
                'content' => 'setting/appearance',
                'data' => $data
            ]);
        } else {
            // Update tema
            $theme = $this->input->post('theme');
            $user_id = $this->session->userdata('user_id');
            
            $updated = $this->auth_model->update_theme_preference($user_id, $theme);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Tema berhasil diubah.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah tema.');
            }
            
            redirect('settings/appearance');
        }
    }
}