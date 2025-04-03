<?php
class M_bagian extends CI_Model{
	function get_all_bagian(){
		$hsl=$this->db->count_all("tbl_bagian");
		return $hsl;
	}
	function get_bagian_perpage($offset,$limit){
		$this->db->limit($offset, $limit);
        $hsl = $this->db->get('tbl_bagian')->result_array();
		return $hsl;
	}
	function simpan_bagian($bagian){
		$hsl=$this->db->query("insert into tbl_bagian(nama_bagian) values('$bagian')");
		return $hsl;
	}
	function get_bagian_byid($id){
		$hsl=$this->db->query("select * from tbl_bagian where id='$id'");
		return $hsl;
	}
	function update_bagian($id,$bagian,$status){
		$hsl=$this->db->query("update tbl_bagian set nama_bagian='$bagian', status='$status' where id='$id'");
		return $hsl;
	}
	function hapus_bagian($id){
		$hsl=$this->db->query("delete from tbl_bagian where id='$id'");
		return $hsl;
	}
}
