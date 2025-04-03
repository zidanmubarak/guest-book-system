<?php
ob_start(); // Start output buffering
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_buku_tamu extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('admin');
            redirect($url);
        };
		$this->load->model('m_tamu');
		$this->load->library('upload');
		$this->load->helper('url');
		$this->load->library('pagination');
	}
	function index(){
		$this->load->view('include/v_head');
		$this->load->view('buku_tamu/v_data_tamu');		
	}
	function loadRecord($limit=0){
		$offset = 10;
		if($limit != 0){
        	$limit = ($limit-1) * $offset;
      	}
      	$allcount = $this->m_tamu->get_all_tamu();
      	$users_record = $this->m_tamu->get_tamu_perpage($offset,$limit);
      	$config['base_url'] = base_url().'tamu/loadRecord';
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
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $limit;
 
        echo json_encode($data);
    }
    function get_kartu(){
		$id = $this->input->post('id');
		$query_kartu = $this->m_tamu->get_kartu_visitor($id);
		$result_kartu = $query_kartu->result();
		$no_kartu = 1;
		
		$hasil = "<ul style='padding:0;list-style:none'>";
		if(count($result_kartu) > 0) {
			foreach ($result_kartu as $row) {
				// Add default status if empty
				if(empty($row->status) || $row->status === NULL) {
					$status_label = "<span class='label label-danger'> Belum Dikembalikan</span>";
				} else if($row->status == 'y') {
					$status_label = "<span class='label label-danger'> Belum Dikembalikan</span>"; 
				} else if($row->status == 'n') {
					$status_label = "<span class='label label-success'> Dikembalikan</span>";
				} else {
					$status_label = "<span class='label label-warning'> Status Tidak Diketahui</span>";
				}
				
				$serial_display = (strlen($row->serial_kartu) > 15) ? substr($row->serial_kartu, 0, 15)."..." : $row->serial_kartu;
				$hasil .= "<li>".$serial_display."<br>".$status_label."</li>";
				$no_kartu++;
			}
		} else {
			$hasil .= "<li><span class='label label-default'>Tidak Ada Kartu</span></li>";
		}
		$hasil .= "</ul>";
		
		$data['hasil'] = $hasil;
		echo json_encode($data);
	}

	function kembalikan_kartu() {
    $serial_kartu = $this->input->post('serial_kartu');
    
    // Validate input
    if(empty($serial_kartu)) {
        $response = array(
            'status' => 'error',
            'message' => 'Nomor kartu tidak boleh kosong'
        );
        echo json_encode($response);
        return;
    }
    
    // Check if the card exists
    $check_query = $this->db->query("SELECT * FROM tbl_kartu_tamu WHERE serial_kartu = '$serial_kartu' LIMIT 1");
    
    if($check_query->num_rows() > 0) {
        $card_data = $check_query->row();
        
        // Check if the card is already returned
        if($card_data->status == 'n') {
            $response = array(
                'status' => 'error',
                'message' => 'Kartu ini sudah dikembalikan sebelumnya'
            );
            echo json_encode($response);
            return;
        }
        
        // Update the status and also set the return date
        $update_result = $this->db->query("UPDATE tbl_kartu_tamu SET 
            status = 'n', 
            tgl_dikembalikan = NOW() 
            WHERE serial_kartu = '$serial_kartu'");
        
        if($this->db->affected_rows() > 0) {
            $response = array(
                'status' => 'success',
                'message' => 'Kartu berhasil dikembalikan'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal mengupdate status kartu'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Kartu dengan nomor tersebut tidak ditemukan'
        );
    }
    
    echo json_encode($response);
}

    function get_file_lampiran(){
    	$id 		=$this->input->post('id');
    	$query = $this->m_tamu->get_file_lampiran($id);
    	$result=$query->result();
    	$no = 1;
    	
    	$hasil = "<ul style='padding:0;list-style:none'>";
    	foreach ($result as $row) {
    		$hasil .="<li><a href='".base_url()."assets/file_lampiran/".$row->file."' style='text-decoration:none' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i> &nbsp;".substr($row->file,0,7)."...</a></li>";
    		$no++;
    	}
    	$hasil .="</ul>";
    	$data['hasil'] = $hasil;
    	echo json_encode($data);
    }
    function filter_data($limit=0){
    	$keywords=$this->input->post('keywords');
    	if($keywords !== null) {

    		$offset = 100;
			if($limit != 0){
	        	$limit = ($limit-1) * $offset;
	      	}
	      	$allcount = $this->m_tamu->get_all_tamu();
	      	$users_record = $this->m_tamu->get_filter_tamu_perpage($offset,$limit,$keywords);
	      	$config['base_url'] = base_url().'data_buku_tamu/filter_data';
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
    	}else{
    		$this->loadRecord($limit=0);
    	}
    }
	function add_tamu(){
		$this->load->view('include/v_head');
		$this->load->view('buku_tamu/v_add_tamu');
	}
	function loadpegawai(){

		$data=$this->m_tamu->get_pegawai();
        $hasil = '<option value="">::Pilih yang dituju::</option> ';
        foreach ($data as $r) {
            $hasil .= '<option value="'.$r->id.'" >'.$r->nama.'</option>';
        }
        echo $hasil;
	}
	function loadbagian(){
		$data=$this->m_tamu->get_bagian();
        $hasil = '<option value="">::PilihBagian::</option> ';
        foreach ($data as $r) {
            $hasil .= '<option value="'.$r->nama_bagian.'" >'.$r->nama_bagian.'</option>';
        }
        echo $hasil;
	}
	function simpan_tamu(){
		$nama 			=strip_tags(addslashes($this->input->post('xnama')));
		$alamat 		=strip_tags(addslashes($this->input->post('xalamat')));
		$jenkel 		=strip_tags($this->input->post('xjenkel'));
		$no_hp 			=strip_tags(str_replace(" ", "", $this->input->post('xnohp')));
		$tujuan 		=strip_tags(addslashes($this->input->post('xtujuan')));
		$nama_tujuan 		=strip_tags(addslashes($this->input->post('xnamatujuan')));
		$keperluan 		=strip_tags(addslashes($this->input->post('xkeperluan')));
		$image 			=$_POST['xnama_file_foto'];
		if(!empty($image)) {
			$nama_tamu = strtolower(preg_replace( array('/[^a-z0-9\- ]/i', '/[ \-]+/'), array('', '-'), $nama));
 			$foto = 'foto_'.$nama_tamu.'_tamu_'.date("Y-m-d").'.jpeg';
		}
		else {
			$foto ="";
		}
			

		$user_id=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('idadmin');

		//Simpan data tamu text
		$simpan_data_tamu = $this->m_tamu->simpan_tamu($nama,$alamat,$jenkel,$no_hp,$tujuan,$keperluan,$nama_tujuan,$foto,$user_id,$user_nama);
		if($simpan_data_tamu){
			$tamu = $this->m_tamu->get_tamu_last_id();
			$t = $tamu->row_array();
			$id = $t['id'];
			$foto = $t['photo'];

			if(!empty($image)){
				if($foto !=="") {
					if(file_exists('./assets/images/foto_tamu/'.$foto)){
						unlink('./assets/images/foto_tamu/'.$foto);
					}
					$data = $image;
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					file_put_contents('./assets/images/foto_tamu/'.$foto, $data);
				}
				else{
					$data = $image;
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					file_put_contents('./assets/images/foto_tamu/'.$foto, $data);
				}

			}
			
			$item_rfid = $_POST['item_xrfid'];
			if(!empty($item_rfid)){
				$no_array = 0;
				foreach($item_rfid as $r){
					if($_POST['item_xrfid'][$no_array] !="") 
					{
						$serial_kartu = $_POST['item_xrfid'][$no_array];
						$insert_kartu_rfid	= $this->m_tamu->insert_kartu_rfid($id,$serial_kartu);
						$no_array++;	
					}
				}
			}

			$item_lampiran_count = count($_FILES["item_xnamalampiran"]['name']);
			if(count($_FILES["item_xnamalampiran"]['name']) > 0) {
				for($j=0; $j < count($_FILES["item_xnamalampiran"]['name']); $j++)
				{
					$filen = $_FILES["item_xnamalampiran"]['name'][$j];	
					$pathfolder = "./assets/file_lampiran/";
					if ($filen != "") {
						$path = "./assets/file_lampiran/".$filen;
						if(move_uploaded_file($_FILES["item_xnamalampiran"]['tmp_name']["$j"], $path)) { 
							$insert =  $this->m_tamu->insert_lampiran($id,$filen);
							if ($item_lampiran_count == $j+1) {
								echo $this->session->set_flashdata('msg','success 1');
								redirect('data_buku_tamu');
							}
						}
						else{
							//sukses DENGAN foto dan lampiran
							echo $this->session->set_flashdata('msg','success 2');
							redirect('data_buku_tamu');
						}
					}
				}
				
			}
			echo $this->session->set_flashdata('msg','success-simpan');
			redirect('data_buku_tamu');
			 
		}
		else{
			echo $this->session->set_flashdata('msg','danger');
			redirect('data_buku_tamu');
		}
	}
	function get_edit_tamu(){
		$id=$this->uri->segment(3);
		$x['data_tamu']=$this->m_tamu->get_data_tamu_by_kode($id);
		$x['rfid']=$this->m_tamu->get_kartu_visitor($id);
		$x['lampiran']=$this->m_tamu->get_file_lampiran($id);
		$this->load->view('include/v_head',$x);
		$this->load->view('buku_tamu/v_edit_tamu',$x);
	}
	function update_tamu(){
		$id_tamu 		=strip_tags(addslashes($this->input->post('xkode')));
		$nama 			=strip_tags(addslashes($this->input->post('xnama')));
		$alamat 		=strip_tags(addslashes($this->input->post('xalamat')));
		$jenkel 		=strip_tags($this->input->post('xjenkel'));
		$no_hp 			=strip_tags(str_replace(" ", "", $this->input->post('xnohp')));
		$tujuan 		=strip_tags($this->input->post('xtujuan'));
		$keperluan 		=strip_tags(addslashes($this->input->post('xkeperluan')));
		$nama_tujuan 		=strip_tags(addslashes($this->input->post('xnamatujuan')));
		$image 			=addslashes($_POST['xnama_file_foto']);
		
		if(!empty($image)) {
			$nama_tamu = strtolower(preg_replace( array('/[^a-z0-9\- ]/i', '/[ \-]+/'), array('', '-'), $nama));
 			$foto = 'foto_'.$nama_tamu.'_tamu_'.date("Y-m-d").'.jpeg';
		}else {
			$foto ="";
		}
		
		$user_id=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');

		//Update data tamu text
		$update_data_tamu = $this->m_tamu->update_tamu($id_tamu,$nama,$alamat,$jenkel,$no_hp,$tujuan,$keperluan,$nama_tujuan,$foto,$user_id,$user_nama);
		if($update_data_tamu){
			//cek apa kartu rfid disertakan
			$item_rfid = $_POST['item_xrfid'];
			$rowItem_xrfid = count($item_rfid);
			$id=$id_tamu;
			if($rowItem_xrfid > 0){
				$hapus_kartu_rfid = $this->m_tamu->hapus_all_kartu_rfid($id);

				$no_array = 0;
				foreach($item_rfid as $r){
					if($_POST['item_xrfid'][$no_array] !=""){
						$serial_kartu = $_POST['item_xrfid'][$no_array];
						$insert_kartu_rfid	= $this->m_tamu->insert_kartu_rfid($id,$serial_kartu);
						$no_array++;	
					}
				}
			}
			else{
				$hapus_kartu_rfid = $this->m_tamu->hapus_all_kartu_rfid($id);

			}
			if(!empty($foto)){
				
				if(file_exists('./assets/images/foto_tamu/'.$foto)){
					unlink('./assets/images/foto_tamu/'.$foto);
				}
				$data_foto = $image;
				list($type, $data_foto) = explode(';', $data_foto);
				list(, $data_foto)      = explode(',', $data_foto);
				$data_foto = base64_decode($data_foto);
				$put_image = file_put_contents('./assets/images/foto_tamu/'.$foto, $data_foto);
			}
			
			
			$item_lampiran_count = count($_FILES["item_xnamalampiran"]['name']);
			$no_array_lamp = 0;
			if(count($_FILES["item_xnamalampiran"]['name']) > 0) {
				for($j=0; $j < count($_FILES["item_xnamalampiran"]['name']); $j++){
					$filen = $_FILES["item_xnamalampiran"]['name'][$j];	
					$pathfolder = "./assets/file_lampiran/";
					if ($filen != "") {
						$path = "./assets/file_lampiran/".$filen;
						if(move_uploaded_file($_FILES["item_xnamalampiran"]['tmp_name']["$j"], $path)) { 
							$insert =  $this->m_tamu->insert_lampiran($id,$filen);
						}
					}
				}
			}
			echo $this->session->set_flashdata('msg','success-update');
			redirect('data_buku_tamu');
		}
		else{
			echo $this->session->set_flashdata('msg','gagal-update');
			redirect('data_buku_tamu');
		}
	}
	function hapus_lampiran(){
		$id 			= $this->input->post('id');
		$lampiran 		= $this->m_tamu->get_file_lampiran_by_id($id);
		$lamp 			= $lampiran->row_array();
		$id_lampiran 	= $lamp['id'];
		$file 			= $lamp['file'];
		if(file_exists('./assets/file_lampiran/'.$file)){
			$path 		='./assets/file_lampiran/'.$file;
			unlink($path);
			$hapus 		= $this->m_tamu->hapus_file_lampiran($id_lampiran);
			if($hapus) {
				$callback = array(
					'pesan'=>'success',
					'csrfName'=>$this->security->get_csrf_token_name(),
					'csrfHash'=>$this->security->get_csrf_hash()
				);
			}else{
				$callback = array(
					'pesan'=>'gagal',
					'csrfName'=>$this->security->get_csrf_token_name(),
					'csrfHash'=>$this->security->get_csrf_hash()
				);
			}
			echo json_encode($callback);
		}else {
			$hapus 		= $this->m_tamu->hapus_file_lampiran($id_lampiran);
			if($hapus) {
				$callback = array(
					'pesan'=>'success',
					'csrfName'=>$this->security->get_csrf_token_name(),
					'csrfHash'=>$this->security->get_csrf_hash()
				);
			}else{
				$callback = array(
					'pesan'=>'gagal',
					'csrfName'=>$this->security->get_csrf_token_name(),
					'csrfHash'=>$this->security->get_csrf_hash()
				);
			}
			echo json_encode($callback);
		}
	}
	function hapus_tamu(){
		$id=$this->input->post('id');
		$foto=$this->input->post('foto');
		if($foto !=="") {
			if(file_exists('./assets/images/foto_tamu/'.$foto)){
				unlink('./assets/images/foto_tamu/'.$foto);
			}
		}

		$this->m_tamu->hapus_tamu($id);


		$kartu = $this->m_tamu->get_kartu_visitor($id);
		$card = $kartu->result();
		foreach ($card as $row) {
			$id_kartu = $row->id;
			$serial_kartu = $row->serial_kartu;
			$this->m_tamu->hapus_kartu_rfid($id_kartu);
		}

		$lampiran = $this->m_tamu->get_file_lampiran($id);
		$lamp = $lampiran->result();
		foreach($lamp as $row) {
			$id_lampiran = $row->id;
			$file = $row->file;
			if(file_exists('./assets/file_lampiran/'.$file)){
					unlink('./assets/file_lampiran/'.$file);
			}
			$this->m_tamu->hapus_file_lampiran($id_lampiran);
		}
		$hapus = $this->m_tamu->hapus_tamu($id);
		if($hapus){
			echo json_encode("success");
		}else{
			echo json_encode("gagal");
		}
	}
	function hapus_foto(){
		$id=$this->input->post('id');
		$foto=$this->input->post('foto');

		if(file_exists('./assets/images/foto_tamu/'.$foto)){
			$path='./assets/images/foto_tamu/'.$foto;
			unlink($path);
			$update = $this->m_tamu->update_foto_tamu($id);
			if($update) {
				$callback = array(
					'pesan'=>'success'
				);
			}else{
				$callback = array(
					'pesan'=>'gagal'
				);
			}
			echo json_encode($callback);
		}
		else{
			$update = $this->m_tamu->update_foto_tamu($id);
			if($update) {
				$callback = array(
					'pesan'=>'success'
				);
			}else{
				$callback = array(
					'pesan'=>'gagal'
				);
			}
			echo json_encode($callback);
		}		
	}
	

}