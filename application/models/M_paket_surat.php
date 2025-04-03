<?php
class M_paket_surat extends CI_Model{
	function simpan_paket_surat($asal_surat,$tujuan,$nama_penerima,$isi_paket,$foto){
		$hsl=$this->db->query("insert into 
			tbl_paket_surat(asal_surat, tujuan, nama_penerima, isi_paket, photo, nama_user)
			values('$asal_surat','$tujuan','$nama_penerima','$isi_paket','$foto','Petugas Satpam')");
		return $hsl;
	}
}