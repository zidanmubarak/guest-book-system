<?php
class M_pegawai extends CI_Model{

	function get_all_pegawai(){
		$hsl=$this->db->count_all("tbl_pegawai");
		return $hsl;
	}
	function get_pegawai_perpage($offset,$limit){
		$this->db->limit($offset, $limit);
        $hsl = $this->db->get('tbl_pegawai')->result_array();
		return $hsl;
	}
	function get_fiter_pegawai_perpage($offset,$limit,$keywords){
		$this->db->like('nip',$keywords);
		$this->db->or_like('nama',$keywords);
		$this->db->or_like('jabatan',$keywords);
		$this->db->or_like('bagian',$keywords);
		$this->db->or_like('no_hp',$keywords);
		$this->db->limit($offset, $limit);
        $hsl = $this->db->get('tbl_pegawai')->result_array();
		return $hsl;
	}
	function simpan_pegawai($data_array){
		$hsl = $this->db->insert('tbl_pegawai', $data_array);
		return $hsl;
	}
	function update_pegawai($id,$data_array){
		$hsl = $this->db->where('id', $id);
		$hsl = $this->db->update('tbl_pegawai', $data_array);
		return $hsl;
	}
	function hapus_pegawai($id){
		$hsl=$this->db->query(" DELETE FROM tbl_pegawai  WHERE id = '$id' ");
		return $hsl;
	}	
	function get_data_pegawai_by_id($id){
		$hsl=$this->db->query("SELECT * FROM tbl_pegawai where id='$id'");
		return $hsl;
	}
	function get_bagian(){
        $hsl = $this->db->where('status','1');		
        $hsl = $this->db->get('tbl_bagian')->result();		
		return $hsl;
	}
	function get_jabatan(){
        $hsl = $this->db->where('status','1');		
        $hsl = $this->db->get('tbl_jabatan')->result();		
		return $hsl;
	}	
}