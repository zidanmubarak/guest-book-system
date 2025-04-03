<?php
class M_user extends CI_Model{

	function get_all_user(){
		$level = $this->session->userdata('level');
		if($level == 1) {
			$hsl=$this->db->query("SELECT tbl_user.* FROM tbl_user");
		}else {
			$id = $this->session->userdata('idadmin');
			$hsl=$this->db->query("SELECT tbl_user.* FROM tbl_user where user_id='$id'");
		}

		return $hsl;	
	}

	function simpan_user($nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar){
		$hsl=$this->db->query("INSERT INTO tbl_user (nama,jenkel,username,password,email,nohp,level,photo) VALUES ('$nama','$jenkel','$username',md5('$password'),'$email','$nohp','$level','$gambar')");
		return $hsl;
	}

	function simpan_tanpa_gambar($nama,$jenkel,$username,$password,$email,$nohp,$level){
		$hsl=$this->db->query("INSERT INTO tbl_user (nama,jenkel,username,password,email,nohp,level) VALUES ('$nama','$jenkel','$username',md5('$password'),'$email','$nohp','$level')");
		return $hsl;
	}

	//UPDATE user //
	function update_user($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level,$gambar){
		$hsl=$this->db->query("UPDATE tbl_user set nama='$nama',jenkel='$jenkel',username='$username',password='md5($password)',email='$email',nohp='$nohp',level='$level',photo='$gambar' where user_id='$kode'");
		return $hsl;
	}
	function update_user_tanpa_pass($kode,$nama,$jenkel,$username,$email,$nohp,$level,$gambar){
		$hsl=$this->db->query("UPDATE tbl_user set nama='$nama',jenkel='$jenkel',username='$username',email='$email',nohp='$nohp',level='$level',photo='$gambar' where user_id='$kode'");
		return $hsl;
	}

	function update_user_tanpa_pass_dan_gambar($kode,$nama,$jenkel,$username,$email,$nohp,$level){
		$hsl=$this->db->query("UPDATE tbl_user set nama='$nama',jenkel='$jenkel',username='$username',email='$email',nohp='$nohp',level='$level' where user_id='$kode'");
		return $hsl;
	}
	function update_user_tanpa_gambar($kode,$nama,$jenkel,$username,$password,$email,$nohp,$level){
		$hsl=$this->db->query("UPDATE tbl_user set nama='$nama',jenkel='$jenkel',username='$username',password=md5('$password'),email='$email',nohp='$nohp',level='$level' where user_id='$kode'");
		return $hsl;
	}
	//END UPDATE user//

	function hapus_user($kode){
		$hsl=$this->db->query("DELETE FROM tbl_user where user_id='$kode'");
		return $hsl;
	}
	function getusername($id){
		$hsl=$this->db->query("SELECT * FROM tbl_user where user_id='$id'");
		return $hsl;
	}
	function resetpass($id,$pass){
		$hsl=$this->db->query("UPDATE tbl_user set password=md5('$pass') where user_id='$id'");
		return $hsl;
	}

	function get_user_login($kode){
		$hsl=$this->db->query("SELECT * FROM tbl_user where user_id='$kode'");
		return $hsl;
	}


}