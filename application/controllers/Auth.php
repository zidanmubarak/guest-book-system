<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('form_validation');
        $this->load->library('session'); // Tambahkan ini
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index() {
        // Cek apakah user sudah login
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        // Redirect ke halaman login
        redirect('login');
    }

    public function login() {
        // Cek apakah user sudah login
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Rules validasi
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // Jika validasi gagal, tampilkan form login
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login - Sistem Buku Tamu';
            $this->load->view('templates/auth_template', [
                'content' => 'auth/login',
                'data' => $data
            ]);
        } else {
            // Proses login
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->auth_model->login_temp($username, $password);
            
            if ($user) {
                // Set session user
                $user_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'theme' => $user->theme_preference,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($user_data);
                
                // Update last login
                $this->auth_model->update_last_login($user->id);
                
                // Redirect ke dashboard
                redirect('dashboard');
            } else {
                // Jika login gagal
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('login');
            }
        }
    }

    public function register() {
        // Cek apakah registrasi diizinkan
        if (!$this->auth_model->is_registration_allowed()) {
            $this->session->set_flashdata('error', 'Registrasi tidak diizinkan saat ini.');
            redirect('login');
        }

        // Rules validasi
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'trim|required|matches[password]');

        // Jika validasi gagal, tampilkan form register
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Register - Sistem Buku Tamu';
            $this->load->view('templates/auth_template', [
                'content' => 'auth/register',
                'data' => $data
            ]);
        } else {
            // Proses registrasi
            $data = array(
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => 'staff', // Default role
                'theme_preference' => 'light' // Default theme
            );
            
            $user_id = $this->auth_model->register($data);
            
            if ($user_id) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat registrasi.');
                redirect('register');
            }
        }
    }

    public function logout() {
        // Hapus session dan redirect ke login
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('theme');
        $this->session->unset_userdata('logged_in');
        
        $this->session->set_flashdata('success', 'Berhasil logout.');
        redirect('login');
    }
}