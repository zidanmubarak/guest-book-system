<?php
class User extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('admin');
            redirect($url);
        };
		$this->load->model('m_user');
		$this->load->library('upload');
	}
	function index(){
		$kode=$this->session->userdata('idadmin');
		$x['user']=$this->m_user->get_user_login($kode);
		$x['data']=$this->m_user->get_all_user();
		$this->load->view('include/v_head',$x);
		$this->load->view('user/v_user',$x);
	}

	function simpan_user(){
		$config['upload_path'] = './assets/images/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
		$this->upload->initialize($config);
		if(!empty($_FILES['filefoto']['name']))
		{
		    if ($this->upload->do_upload('filefoto'))
		    {
				$gbr = $this->upload->data();
				//Compress Image
				$config['image_library']='gd2';
				$config['source_image']='./assets/images/'.$gbr['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '60%';
				$config['width']= 300;
				$config['height']= 300;
				$config['new_image']= './assets/images/'.$gbr['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$gambar 			=addslashes($gbr['file_name']);
				$nama 				=addslashes($this->input->post('xnama'));
				$jenkel 			=addslashes($this->input->post('xjenkel'));
				$username 			=addslashes($this->input->post('xusername'));
				$password 			=addslashes($this->input->post('xpassword'));
				$konfirm_password 	=addslashes($this->input->post('xpassword2'));
				$email 				=addslashes($this->input->post('xemail'));
				$nohp 				=str_replace(" ", "", $this->input->post('xkontak'));
				$level 				=addslashes($this->input->post('xlevel'));
				if ($password <> $konfirm_password) {
					echo $this->session->set_flashdata('msg','error');
					redirect('user');
				}else{
					$this->m_user->simpan_user($nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar);
					echo $this->session->set_flashdata('msg','success');
					redirect('user');
				}
		    }else{
		        echo $this->session->set_flashdata('msg','warning');
		        redirect('user');
		    }
		}else{
			$nama 				= addslashes($this->input->post('xnama'));
		    $jenkel 			= addslashes($this->input->post('xjenkel'));
		    $username 			= addslashes($this->input->post('xusername'));
		    $password 			= addslashes($this->input->post('xpassword'));
		    $konfirm_password	= addslashes($this->input->post('xpassword2'));
		    $email 				= addslashes($this->input->post('xemail'));
		    $nohp 				= str_replace(" ", "", $this->input->post('xkontak'));
			$level 				= addslashes($this->input->post('xlevel'));
			if ($password <> $konfirm_password) {
				echo $this->session->set_flashdata('msg','error');
		   		redirect('user');
			}else{
		   		$this->m_user->simpan_user_tanpa_gambar($nama,$jenkel,$username,$password,$email,$nohp,$level);
		        echo $this->session->set_flashdata('msg','success');
		   		redirect('user');
		   	}
		}
	}
	function update_user(){
		$config['upload_path'] = './assets/images/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
		$this->upload->initialize($config);
		if(!empty($_FILES['filefoto']['name']))
		{
		    if ($this->upload->do_upload('filefoto'))
		    {
				$gbr = $this->upload->data();
				//Compress Image
				$config['image_library']='gd2';
				$config['source_image']='./assets/images/'.$gbr['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '80%';
				$config['width']= 300;
				$config['height']= 300;
				$config['new_image']= './assets/images/'.$gbr['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				
				$gambar 			= addslashes($gbr['file_name']);
				$kode 				= addslashes($this->input->post('kode'));
				$nama 				= addslashes($this->input->post('xnama'));
		    	$jenkel 			= addslashes($this->input->post('xjenkel'));
		    	$username 			= addslashes($this->input->post('xusername'));
		    	$password 			= addslashes($this->input->post('xpassword'));
		    	$konfirm_password	= addslashes($this->input->post('xpassword2'));
				$email 				= addslashes($this->input->post('xemail'));
				$nohp 				= str_replace(" ", "", $this->input->post('xkontak'));
				$level 				= addslashes($this->input->post('xlevel'));
				if (empty($password) && empty($konfirm_password)) {
				   	$this->m_user->update_user_tanpa_pass($kode,$nama,$jenkel,$username,$email,$nohp,$level,$gambar);
					echo $this->session->set_flashdata('msg','info');
					redirect('user');
				}
				elseif ($password <> $konfirm_password) {
					echo $this->session->set_flashdata('msg','error');
					redirect('user');
				}
				else{
					$this->m_user->update_user($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar);
					echo $this->session->set_flashdata('msg','info');
					redirect('user');
				}
		    }
		    else{
		    	echo $this->session->set_flashdata('msg','warning');
		        redirect('user');
		    }
		}
		else{
			$kode				=addslashes($this->input->post('kode'));
			$nama 				=addslashes($this->input->post('xnama'));
		    $jenkel 			=addslashes($this->input->post('xjenkel'));
		    $username 			=addslashes($this->input->post('xusername'));
		    $password 			=addslashes($this->input->post('xpassword'));
		    $konfirm_password 	=addslashes($this->input->post('xpassword2'));
		    $email 				=addslashes($this->input->post('xemail'));
		    $nohp 				=str_replace(" ", "", $this->input->post('xkontak'));
			$level 				=addslashes($this->input->post('xlevel'));
			if(empty($password) && empty($konfirm_password)) {
		       	$this->m_user->update_user_tanpa_pass_dan_gambar($kode,$nama,$jenkel,$username,$email,$nohp,$level);
		        echo $this->session->set_flashdata('msg','info');
		   		redirect('user');
			}
			elseif ($password <> $konfirm_password) {
				echo $this->session->set_flashdata('msg','error');
		   		redirect('user');
			}
			else{
				$this->m_user->update_user_tanpa_gambar($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level);
				echo $this->session->set_flashdata('msg','info');
				redirect('user');
		   	}
		}
	}
	function hapus_user(){
		$kode=$this->input->post('kode');
		$data=$this->m_user->get_user_login($kode);
		$q=$data->row_array();
		$p=$q['user_photo'];
		$path='./assets/images/'.$p;

		if( file_exists($path) ) {
			unlink($path);
		}
		$this->m_user->hapus_user($kode);
	    echo $this->session->set_flashdata('msg','success-hapus');
	    redirect('user');
	}
	function reset_password(){
		$id=$this->uri->segment(3);
        $get=$this->m_user->getusername($id);
        if($get->num_rows()>0){
            $a=$get->row_array();
            $b=$a['username'];
        }
        $pass=rand(123456,999999);
        $this->m_user->resetpass($id,$pass);
        echo $this->session->set_flashdata('msg','show-modal');
        echo $this->session->set_flashdata('username',$b);
        echo $this->session->set_flashdata('upass',$pass);
	    redirect('user');
    }
}