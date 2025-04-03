<?php
class M_tamu extends CI_Model{

	function get_all_tamu(){
		$hsl=$this->db->count_all("tbl_tamu");
		return $hsl;
	}
	/*
	function get_tamu(){
		$hsl=$this->db->query("SELECT tbl_tamu.*,DATE_FORMAT(tgl_datang,'%d/%m/%Y') AS tanggal FROM tbl_tamu ORDER BY id DESC");
		return $hsl;
	}
	*/
	function get_tamu_perpage($offset,$limit){
		$this->db->select('tbl_tamu.*,tbl_pegawai.id as id_pegawai,tbl_pegawai.nama as namatujuan ');
		$this->db->from('tbl_tamu');
		$this->db->join('tbl_pegawai','tbl_pegawai.id = tbl_tamu.nama_tujuan','LEFT');
		$this->db->limit($offset, $limit);
        $hsl = $this->db->get()->result_array();
		return $hsl;
	}
	function get_filter_tamu_perpage($offset,$limit,$keywords){
		$this->db->select('tbl_tamu.*,tbl_pegawai.id as id_pegawai,tbl_pegawai.nama as namatujuan ');
		$this->db->from('tbl_tamu');
		$this->db->join('tbl_pegawai','tbl_tamu.nama_tujuan = tbl_pegawai.id','LEFT');
		$this->db->like('tbl_tamu.nama',$keywords);
		$this->db->or_like('tbl_tamu.alamat',$keywords);
		$this->db->or_like('tbl_tamu.no_hp',$keywords);
		$this->db->or_like('tbl_tamu.tujuan',$keywords);
		$this->db->or_like('tbl_tamu.keperluan',$keywords);
		$this->db->or_like('tbl_pegawai.nama',$keywords);
		$this->db->or_like('tbl_tamu.photo',$keywords);
        $hsl = $this->db->get()->result_array();
		return $hsl;
	}
	function get_kartu_visitor($id){
		$hsl=$this->db->query("SELECT * FROM tbl_kartu_tamu WHERE id_tamu = '$id' ORDER BY id ASC");
		return $hsl;
	}
	function get_file_lampiran($id){
		$hsl=$this->db->query("SELECT tbl_lampiran.* FROM tbl_lampiran WHERE id_tamu = '$id' ORDER BY id ASC");
		return $hsl;
	}

	function simpan_tamu($nama,$alamat,$jenkel,$no_hp,$tujuan,$keperluan,$nama_tujuan,$foto,$user_id,$user_nama){
		$hsl=$this->db->query("insert into 
			tbl_tamu(nama, alamat, jenkel, no_hp, tujuan, keperluan, nama_tujuan, photo, user_id, nama_user)
			values('$nama','$alamat','$jenkel','$no_hp','$tujuan','$keperluan','$nama_tujuan','$foto','$user_id','$user_nama')");
		return $hsl;
	}
	function get_pegawai(){
		$hsl = $this->db->where('status','aktif');		
        $hsl = $this->db->get('tbl_pegawai')->result();		
		return $hsl;
	}
	function get_bagian(){
        $hsl = $this->db->where('status','1');		
        $hsl = $this->db->get('tbl_bagian')->result();		
		return $hsl;
	}
	function update_tamu($id_tamu,$nama,$alamat,$jenkel,$no_hp,$tujuan,$keperluan,$nama_tujuan,$foto,$user_id,$user_nama){
		$hsl=$this->db->query("UPDATE 
			tbl_tamu SET nama = '$nama' , alamat ='$alamat' , jenkel = '$jenkel', no_hp = '$no_hp', 
			tujuan = '$tujuan', keperluan ='$keperluan' , nama_tujuan = '$nama_tujuan' , photo = '$foto' , 
			user_id = '$user_id', nama_user = '$user_nama' 
			WHERE id = '$id_tamu'");
		return $hsl;
	}
		
	function update_foto_tamu($id){
		$hsl=$this->db->query("UPDATE tbl_tamu SET  photo = '' WHERE id = '$id'");
		return $hsl;
	}
	function hapus_tamu($id){
		$hsl=$this->db->query(" DELETE FROM tbl_tamu  WHERE id = '$id' ");
		return $hsl;
	}
	function get_tamu_last_id(){
		$hsl=$this->db->query("SELECT * FROM tbl_tamu order by id DESC LIMIT 1");
		return $hsl;
	}
	function get_data_tamu_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_tamu.*,DATE_FORMAT(tgl_datang,'%d/%m/%Y') AS tanggal FROM tbl_tamu where id='$kode'");
		return $hsl;
	}
	
	function insert_kartu_rfid($id,$serial_kartu){
		$hsl=$this->db->query("insert into tbl_kartu_tamu(id_tamu, serial_kartu) values('$id','$serial_kartu')");
		return $hsl;
	}
	function hapus_all_kartu_rfid($id){
		$hsl=$this->db->query(" DELETE FROM tbl_kartu_tamu  WHERE id_tamu = '$id' ");
		return $hsl;
	}
	function hapus_kartu_rfid($id_kartu){
		$hsl=$this->db->query(" DELETE FROM tbl_kartu_tamu  WHERE id = '$id_kartu' ");
		return $hsl;
	}
	
	
	function get_file_lampiran_by_id($id){
		$hsl=$this->db->query("SELECT tbl_lampiran.* FROM tbl_lampiran WHERE id = '$id' ORDER BY id ASC");
		return $hsl;
	}
	function insert_lampiran($id,$filen){
		$hsl=$this->db->query("insert into tbl_lampiran(id_tamu, file) values('$id','$filen')");
		return $hsl;
	}
	function hapus_file_lampiran($id_lampiran){
		$hsl=$this->db->query(" DELETE FROM tbl_lampiran  WHERE id = '$id_lampiran' ");
		return $hsl;
	}

}