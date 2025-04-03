<?php
	$this->load->view('include/v_header');
	$this->load->view('include/v_sidebar');
?>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tamu 	
        <input type="hidden" name="pagenomer" id="pagenomer" value="1" > 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tamu</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            	<a href="<?php echo base_url()?>data_buku_tamu/add_tamu" class="btn btn-success btn-flat"><span class="fa fa-plus"></span> Tambah Tamu</a>
            	<button class="btn btn-info btn-flat" data-toggle="modal" data-target="#ModalKartuTamu" ><span class="fa fa-exchange"></span> Pengembalian Kartu Tamu</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            	<!-- Posts List -->
            	<div class="row">
            		<div class="col-sm-12 col-md-6">
            			<div class="dataTables_length bs-select" >
            			
            			</div>
            		</div>
            		<div class="col-sm-12 col-md-6">
            			<div id="dtBasicExample_filter" class="dataTables_filter">
            				<label>Search:
            					<input type="search" class="form-control form-control-sm filter" placeholder="" aria-controls="dtBasicExample">
            				</label>
            			</div>
            		</div>
            	</div>
            	<table class="table table-bordered table-striped" id='tamuList'>
            		<thead>
	                	<tr>
							<th>No</th>
							<th>Photo</th>
							<th>Identitas</th>		          					
							<th>Keperluan</th>
							<th>Tujuan Ke</th>
							<th>ID Kartu Tamu</th>
							<th>Lampiran</th>
							<th class="text-center">Aksi</th>
	                	</tr>
	                </thead>
            		<tbody></tbody>
            	</table>
            	<!-- Paginate -->
            	<div id='pagination'></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
  	$this->load->view('include/v_footer');
  ?>
  	
  	<div class="modal fade" id="ModalKartuTamu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <span class="fa fa-close"></span>
                    </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Pengembalian Kartu Tamu</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="nomor_kartu" class="form-control" id="nomor_kartu" placeholder="nomor serial kartu" required/>
                        <p>Fokuskan Kursor pada inputan diatas ini dan tempelkan Kartu tamu pada pemindai RFID</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-flat" id="kembalikan_kartu">Simpan</button>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
	<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				 <div class="modal-header">
				 	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
				 	<h4 class="modal-title" id="myModalLabel">Hapus Data Tamu</h4>
				 </div>
				<div class="modal-body">
					<input type="hidden" name="id_hapus" id="id_hapus" value="" >
					<input type="hidden" name="foto" id="foto" value="" >
					<p>Anda yakin akan menghapus data tamu ini?</p>
				</div>
				<div class="modal-footer">
				 	<button type="button" class="btn btn-primary btn-flat hapus" id="hapus_tamu">Ya, Hapus!</button>
				 	<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>


<script>
	
	loadPagination(0);

	function loadPagination(pagno){
		$.ajax({
			url: '<?php echo base_url()?>data_buku_tamu/loadRecord/'+pagno,
			type: 'get',
			dataType: 'json',
			success: function(response){
				$('#pagination').html(response.pagination);
				createTable(response.result,response.row);
				
			}
		});
	}
	//search filter
	$(".filter").on("input", function() {
		var keywords = $('.filter').val();
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '<?php echo base_url('data_buku_tamu/filter_data')?>',
			data:{keywords:keywords},
			success: function(response){
				$('#pagination').html(response.pagination);
				createTable(response.result,response.row);
			}
		});
	});
	function get_visitorcard(id){
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '<?php echo base_url('data_buku_tamu/get_kartu')?>',
			data:{id:id},
			success: function(res){
				visitorCard = res.hasil;
				$(".visitorCard"+id).html(visitorCard);
			}
		});
	}
	function get_lampiran(id){
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '<?php echo base_url('data_buku_tamu/get_file_lampiran')?>',
			data:{id:id},
			success: function(res){
				lampiran = res.hasil;
				$(".lampiran"+id).html(lampiran);
			}
		});
	}
	
	function createTable(result,sno){
		sno = Number(sno);
		$('#tamuList tbody').empty();
		for(index in result){
			var id 			= result[index].id;
			var nama 		= result[index].nama;
			var alamat		= result[index].alamat;
			var jenkel		= result[index].jenkel;
			var no_hp 		= result[index].no_hp;
			if(jenkel=='L'){
				var gender = "(Laki-Laki)";
			}
			else if(jenkel=='P'){
				gender = "(Perempuan)";
			}
			else {
				gender = "";
			}
			var identitas 	= "<b>"+nama+"</b> "+gender+"<br><p>"+alamat+"<br> No HP: <b>"+no_hp+"</b></p>";
			var tujuan 		= result[index].tujuan;
			var keperluan 	= result[index].keperluan;
			var namatujuan	= result[index].namatujuan;
			var photo 		= result[index].photo;
			if(photo != ""){
				var foto = '<img width="100" height="100" class="profile-user-img img-responsive" src="<?php echo base_url()?>assets/images/foto_tamu/'+photo+'" onclick="modalimage(this.src)" style="cursor:pointer;">';
			}else {
				var foto = '<img width="100" height="100" class="img-circle" src="<?php echo base_url()?>assets/images/user_blank.png">';
			}
			sno+=1;
			var tr = "<tr>";
			tr += "<td>"+ sno +".</td>";
			tr += "<td class='text-center'>"+ foto +"</td>";
			tr += "<td>"+ identitas +"</td>";
			tr += "<td>"+ keperluan +"</td>";
			tr += "<td>"+ tujuan +"<br>"+namatujuan+"</td>";
			tr += "<td><span class='visitorCard"+id+"' data-id='"+id+"'></span></td>";
			tr += "<td><span class='lampiran"+id+"'></span></td>";
			tr += "<td class='text-center'>";
			tr += "<a href='<?php echo base_url()?>data_buku_tamu/get_edit_tamu/"+id+"' class='btn btn-info'><span class='fa fa-pencil'></span></a>&nbsp;";
			tr += "<a class='btn btn-danger btn-hapus' data-toggle='modal' data-id='"+id+"' data-foto='"+photo+"' data-target='#ModalHapus'><span class='fa fa-trash'></span></a>";
			tr += "</td>";
			tr += "</tr>";
			$('#tamuList tbody').append(tr);
			
			get_visitorcard(id);
			get_lampiran(id);
		}

		$(".btn-edit").on("click", function() {
			id =  $(this).data('id');
			loadbagian();
			csrfName = $("#csrfname").val();
			csrfHash = $("#csrfhash").val();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo base_url('data_buku_tamu/get_data_edit_tamu')?>',
				data:{id:id},
				success: function(res){
					var tamu =res.tamu[0]; 
					$('#id_update').val(tamu.id);
					$('#nip_update').val(tamu.nip);
					$('#nama_update').val(tamu.nama);
					$('#jabatan_update').val(tamu.jabatan);
					$("#bagian_update").val(tamu.bagian);
					$('#no_hp_update').val(tamu.no_hp);
					$('#status_update').val(tamu.status);
					
					csrfName = res.csrfName;
					csrfHash = res.csrfHash;
					$("#csrfname").val(csrfName);
					$("#csrfhash").val(csrfHash);

					$("#update").on("click", function() {
						var id = $('#id_update').val();
						var nip = $('#nip_update').val();
						var nama = $('#nama_update').val();
						var jabatan = $('#jabatan_update').val();
						var bagian = $('#bagian_update').val();
						var no_hp = $('#no_hp_update').val();
						var status = $('#status_update').val();
						csrfName = $("#csrfname").val();
						csrfHash = $("#csrfhash").val();
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: '<?php echo base_url('data_buku_tamu/update_tamu')?>',
							data:{
								
								id:id,
								nip:nip,
								nama:nama,
								jabatan:jabatan,
								bagian:bagian,
								no_hp:no_hp,
								status:status
							},
							success: function(res){
								$('#ModalEdit').modal('hide');
								csrfName = res.csrfName;
								csrfHash = res.csrfHash;
								$("#csrfname").val(csrfName);
								$("#csrfhash").val(csrfHash);
								pageno = $("#pagenomer").val();
								loadPagination(pageno);
								//window.location.reload();
							}
						});
					});
				}
			});
		});
		$(".btn-hapus").on("click", function(){
			id =  $(this).data('id');
			foto =  $(this).data('foto');
			$('#id_hapus').val(id);
			$('#foto').val(foto);
		});
		
		$("#hapus_tamu").on("click", function(){
			id = $('#id_hapus').val();
			foto = $('#foto').val();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo base_url('data_buku_tamu/hapus_tamu')?>',
				data:{id:id,foto:foto},
				success: function(res){
					pageno = $("#pagenomer").val();
					loadPagination(pageno);
					if(res == 'success'){
						$.toast({
							heading: 'Success',
							text: "Data Berhasil dihapus.",
							showHideTransition: 'slide',
							icon: 'success',
							hideAfter: 3000,
							position: 'bottom-right',
							bgColor: '#00a65a'
			            });
					}
					else{
						$.toast({
			                heading: 'Error',
			                text: "Data Gagal di hapus, Hubungi Administrator!.",
			                showHideTransition: 'slide',
			                icon: 'error',
			                hideAfter: 3000,
			                position: 'bottom-right',
			                bgColor: '#f39c12'
			            });
					}
					$('#ModalHapus').modal('hide');
				}
			});
		});

	$(document).ready(function() {
    $("#kembalikan_kartu").on("click", function() {
        var nomor_kartu = $('#nomor_kartu').val();
        
        if(nomor_kartu === '') {
            $.toast({
                heading: 'Error',
                text: "Silahkan scan kartu terlebih dahulu!",
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right',
                bgColor: '#f39c12'
            });
            return false;
        }
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo base_url('data_buku_tamu/kembalikan_kartu')?>',
            data: {
                serial_kartu: nomor_kartu
            },
            success: function(res) {
                if(res.status === 'success') {
                    $.toast({
                        heading: 'Success',
                        text: "Kartu berhasil dikembalikan.",
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 3000,
                        position: 'bottom-right',
                        bgColor: '#00a65a'
                    });
                    
                    // Reload the data to update the card status
                    $('#ModalKartuTamu').modal('hide');
                    $('#nomor_kartu').val('');
                    
                    // Force refresh the data
                    var current_page = $("#pagenomer").val() || 0;
                    loadPagination(current_page);
                    
                    // Add delay to allow the table to refresh before updating card status
                    setTimeout(function() {
                        // Update all card status displays by re-fetching them
                        $('.visitorCard').each(function() {
                            var id = $(this).data('id');
                            get_visitorcard(id);
                        });
                    }, 500);
                    
                } else {
                    $.toast({
                        heading: 'Error',
                        text: res.message || "Gagal mengembalikan kartu. Kartu tidak ditemukan atau sudah dikembalikan.",
                        showHideTransition: 'slide',
                        icon: 'error',
                        hideAfter: 3000,
                        position: 'bottom-right',
                        bgColor: '#f39c12'
                    });
                }
            },
            error: function() {
                $.toast({
                    heading: 'Error',
                    text: "Terjadi kesalahan. Hubungi administrator.",
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 3000,
                    position: 'bottom-right',
                    bgColor: '#f39c12'
                });
            }
        });
    });
});
	}

	
</script>

<?php 
    if($this->session->flashdata('msg')=='error-simpan'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Error',
                text: "Data Gagal disimpan, Hubungi Administrator!",
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right',
                bgColor: '#f39c12'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='error-ubah'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Error',
                text: "Data Gagal Di perbaharui, Hubungi Administrator!.",
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right',
                bgColor: '#f39c12'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='success-simpan'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Success',
                text: "Data berhasil disimpan ke database.",
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 3000,
                position: 'bottom-right',
                bgColor: '#00a65a'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='success-ubah'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Info',
                text: "Data berhasil di perbaharui",
                showHideTransition: 'slide',
                icon: 'info',
                hideAfter: 3000,
                position: 'bottom-right'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='success-hapus'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Success',
                text: "Data Berhasil dihapus.",
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 3000,
                position: 'bottom-right',
                bgColor: '#00a65a'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='error-hapus'):?>
         <script type="text/javascript">
            $.toast({
                heading: 'Error',
                text: "Data Gagal di hapus, Hubungi Administrator!.",
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'bottom-right',
                bgColor: '#f39c12'
            });
        </script>
    <?php else:?>

    <?php endif;?>
</body>
</html>