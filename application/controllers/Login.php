<?php
class Login extends CI_Controller{
    function __construct(){
        parent:: __construct();
        $this->load->model('m_login');
    }
    function index(){
        $this->load->view('v_login');
    }
    function auth(){
        $username=strip_tags(str_replace("'", "", $this->input->post('username')));
        $password=strip_tags(str_replace("'", "", $this->input->post('password')));
        $u=$username;
        $p=$password;
        $cadmin=$this->m_login->cekadmin($u,$p);
        echo json_encode($cadmin);
        if($cadmin->num_rows() > 0){
            $xcadmin=$cadmin->row_array();
            $level      =$xcadmin['level'];
            $idadmin    =$xcadmin['user_id'];
            $user_nama  =$xcadmin['nama'];
            $foto       =$xcadmin['photo'];
            $this->session->set_userdata('masuk',true);
            $this->session->set_userdata('user',$u);
            $this->session->set_userdata('akses','1');
            $this->session->set_userdata('level',$level);
            $this->session->set_userdata('idadmin',$idadmin);
            $this->session->set_userdata('nama',$user_nama);
            $this->session->set_userdata('foto',$foto);
            redirect('dashboard');
       }
       else{
            echo $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert"><span class="fa fa-close"></span></button> Username Atau Password Salah</div>');
            redirect('login');
       }

    }

    function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
}
