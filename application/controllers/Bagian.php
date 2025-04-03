<?php
class Bagian extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('admin');
            redirect($url);
        };
        $this->load->model('m_bagian');
	}
	function index(){
		
		if($this->session->userdata('masuk')==TRUE){
			$this->load->view('include/v_head');
			$jum = $this->m_bagian->get_all_bagian();
	        
	        $limit=$this->uri->segment(3);
	        
	        $offset = 10;
	        
	        if($limit != 0){
	        	$limit = ($limit-1) * $offset;
	        }

	        
	        $config['base_url'] = base_url().'bagian/index/';
	        $config['total_rows'] = $jum;
	        $config['per_page'] = $limit;
	        $config['num_links'] = 6;
	        $config['uri_segment'] = 3;

	        //Tambahan untuk styling
	        $config['full_tag_open']    = '<div class="dataTables_paginate paging_simple_numbers text-right"><nav><ul class="pagination justify-content-center">';
	        $config['full_tag_close']   = '</ul></nav></div>';
	        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
	        $config['num_tag_close']    = '</span></li>';
	        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
	        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
	        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
	        $config['next_tagl_close']  = '<span aria-hidden="true"><i class="fa fa-chevron-left"></i></span></span></li>';
	        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
	        $config['prev_tagl_close']  = '</span>Next</li>';
	        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
	        $config['first_tagl_close'] = '</span></li>';
	        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
	        $config['last_tagl_close']  = '</span></li>';
	        $config['first_link'] = 'First Page';
	        $config['last_link'] = 'Last Page';
	        $config['next_link'] = '<i class="fa fa-forward" aria-hidden="true"></i>';
	        $config['prev_link'] = '<i class="fa fa-backward" aria-hidden="true"></i>';
	        $this->pagination->initialize($config);
	        $x['csrfName'] = $this->security->get_csrf_token_name();
	        $x['csrfHash'] = $this->security->get_csrf_hash();
	        $x['page'] =$this->pagination->create_links();
	        $x['data']=$this->m_bagian->get_bagian_perpage($offset,$limit);
	        $x['row'] = $limit;

	        $this->load->view('bagian/v_bagian',$x);
		}else{
			redirect('admin');
		}
	
	}
	function simpan_bagian(){
		$bagian = addslashes($this->input->post('nama_bagian'));
		$simpan = $this->m_bagian->simpan_bagian($bagian);
		if($simpan) {
			echo $this->session->set_flashdata('msg','success-simpan');
		}else{
			echo $this->session->set_flashdata('msg','error-simpan');
		}
		redirect('bagian');
	}
	function update_bagian(){
		$id = $this->input->post('id_bagian');
		$bagian = addslashes($this->input->post('nama_bagian'));
		$status = addslashes($this->input->post('status'));
		$ubah = $this->m_bagian->update_bagian($id,$bagian,$status);
		if($ubah) {
			echo $this->session->set_flashdata('msg','success-ubah');
		}else{
			echo $this->session->set_flashdata('msg','error-ubah');
		}
		redirect('bagian');
		
	}
	function hapus_bagian(){
		$id=$this->input->post('id_bagian');
		$hapus = $this->m_bagian->hapus_bagian($id);
	    if($hapus) {
	    	echo $this->session->set_flashdata('msg','success-hapus');
	    }else{
	    	echo $this->session->set_flashdata('msg','error-hapus');	
	    }

	    redirect('bagian');
	}
	
}