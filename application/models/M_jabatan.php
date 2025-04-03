<?php
class M_jabatan extends CI_Model{
	function get_all_jabatan(){
		$hsl=$this->db->count_all("tbl_jabatan");
		return $hsl;
	}
	function get_jabatan_perpage($offset,$limit){
		$this->db->limit($offset, $limit);
        $hsl = $this->db->get('tbl_jabatan')->result_array();
		return $hsl;
	}
	function simpan_jabatan($jabatan){
		$hsl=$this->db->query("insert into tbl_jabatan(nama_jabatan) values('$jabatan')");
		return $hsl;
	}
	function get_jabatan_byid($id){
		$hsl=$this->db->query("select * from tbl_jabatan where id='$id'");
		return $hsl;
	}
	function update_jabatan($id,$jabatan,$status){
		$hsl=$this->db->query("update tbl_jabatan set nama_jabatan='$jabatan', status='$status' where id='$id'");
		return $hsl;
	}
	function hapus_jabatan($id){
		$hsl=$this->db->query("delete from tbl_jabatan where id='$id'");
		return $hsl;
	}
}
