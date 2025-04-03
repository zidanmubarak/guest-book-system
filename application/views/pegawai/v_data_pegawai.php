<?php
  $this->load->view('include/v_header');
  $this->load->view('include/v_sidebar');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Pegawai 	</h1>
      <input type="hidden" name="pagenomer" id="pagenomer" value="1" > 
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pegawai</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a class="btn btn-success btn-flat" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus"></span> Add Pegawai</a>
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
            	<table class="table table-bordered table-striped" id='pegawaiList' style="font-size:13px;">
            		<thead>
	                	<tr>
		          				<th>No.</th>
		          				<th>Nip</th>
		          				<th>Nama</th>
		          				<th>Jabatan</th>
		          				<th>Bagian</th>
		          				<th>No HP</th>
		          				<th>Status</th>
		          				<th class="text-center">#Act</th>
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
  <!--Modal Add Pegawai-->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	        <form class="form-horizontal" action="<?php echo base_url().'pegawai/simpan_pegawai'?>" method="post" enctype="multipart/form-data">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
	                <h4 class="modal-title" id="myModalLabel">Add Data Pegawai</h4>
	            </div>
	            <div class="modal-body">
					<div class="form-group">
					    <label for="nip" class="col-sm-3 control-label">Nip</label>
					    <div class="col-sm-9">
					        <input type="text" name="nip" class="form-control" id="nip" placeholder="Nip" >
					    </div>
					</div>
					<div class="form-group">
					    <label for="nama" class="col-sm-3 control-label">Nama</label>
					    <div class="col-sm-9">
					        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" required>
					    </div>
					</div>
					<div class="form-group">
					    <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
					    <div class="col-sm-9">
					    	  <select name="jabatan" class="form-control select2" id="jabatan" required></select>
					    </div>
					</div>
					<div class="form-group">
					    <label for="bagian" class="col-sm-3 control-label">Bagian</label>
					    <div class="col-sm-9">
					        <select type="text" name="bagian" class="form-control" id="bagian" required></select>
					    </div>
					</div>
					<div class="form-group">
					    <label for="no_hp" class="col-sm-3 control-label">Nomor HP</label>
					    <div class="col-sm-9">
					        <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="noHP" required>
					    </div>
					</div>
					<div class="form-group">
					    <label for="inputUserName" class="col-sm-3 control-label">Status</label>
					    <div class="col-sm-9">
					        <select class="form-control" name="status" required>
					            <option value="aktif" selected>Aktif</option>
					            <option value="block">Non Aktif</option>
					        </select>
					    </div>
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
	                <button type="submit" class="btn btn-primary btn-flat" id="simpan">Simpan</button>
	            </div>
	        </div>
	        </form>
	    </div>
	</div>

	<!--Modal Update Pegawai-->
	<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEditLabel">
	    <div class="modal-dialog" role="document">
	        <form class="form-horizontal" action="<?php echo base_url().'pegawai/update_pegawai'?>" method="post" enctype="multipart/form-data">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
	                <h4 class="modal-title" id="myModalLabel">Update Data Pegawai</h4>
	            </div>
	            <div class="modal-body">
					<div class="form-group">
					    <label for="inputNip" class="col-sm-3 control-label">Nip</label>
					    <div class="col-sm-9">
					        <input type="hidden" name="id_update" class="form-control" id="id_update" placeholder="id" >
					        <input type="text" name="nip_update" class="form-control" id="nip_update" placeholder="Nip" >
					    </div>
					</div>
					<div class="form-group">
					    <label for="nama" class="col-sm-3 control-label">Nama</label>
					    <div class="col-sm-9">
					        <input type="text" name="nama_update" class="form-control" id="nama_update" placeholder="Nama Lengkap" required>
					    </div>
					</div>
					<div class="form-group">
					    <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
					    <div class="col-sm-9">
					       <select type="text" name="jabatan_update" class="form-control select2" id="jabatan_update" required></select>
					    </div>
					</div>
					<div class="form-group">
					    <label for="bagian" class="col-sm-3 control-label">Bagian</label>
					    <div class="col-sm-9">
					        <select type="text" name="bagian_update" class="form-control" id="bagian_update" required></select>
					    </div>
					</div>
					<div class="form-group">
					    <label for="no_hp" class="col-sm-3 control-label">Nomor HP</label>
					    <div class="col-sm-9">
					        <input type="text" name="no_hp_update" class="form-control" id="no_hp_update" placeholder="noHP" required>
					    </div>
					</div>
					<div class="form-group">
					    <label for="inputUserName" class="col-sm-3 control-label">Status</label>
					    <div class="col-sm-9">
					        <select class="form-control" name="status_update" id="status_update" required>
					            <option value="aktif">Aktif</option>
					            <option value="block">Non Aktif</option>
					        </select>
					    </div>
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-primary btn-flat update" id="update">Update</button>
	                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
	            </div>
	        </div>
	        </form>
	    </div>
	</div>
	<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="ModalHapus">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				 <div class="modal-header">
				 	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
				 	<h4 class="modal-title" id="myModalLabel">Hapus Data Pegawai</h4>
				 </div>
				<div class="modal-body">
					<input type="hidden" name="id_hapus" id="id_hapus" value="" >
					<p>Anda yakin akan menghapus data pegawai ini?</p>
				</div>
				<div class="modal-footer">
				 	<button type="button" class="btn btn-primary btn-flat hapus" id="hapus_pegawai">Ya, Hapus!</button>
				 	<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>
<script>
	$('#pagination').on('click','a',function(e){
		e.preventDefault(); 
		var pageno = $(this).attr('data-ci-pagination-page');
		$("#pagenomer").val(pageno);
		loadPagination(pageno);
	});
	
	loadPagination(0);

	function loadPagination(pagno){
		$.ajax({
			url: '<?php echo base_url()?>pegawai/loadRecord/'+pagno,
			type: 'get',
			dataType: 'json',
			success: function(response){
				$('#pagination').html(response.pagination);
				createTable(response.result,response.row);
			}
		});
	}
	
	function createTable(result,sno){
		sno = Number(sno);
		$('#pegawaiList tbody').empty();
		for(index in result){
			var id 			= result[index].id;
			var nip 		= result[index].nip;
			var nama 		= result[index].nama;
			var jabatan		= result[index].jabatan;
			var bagian 		= result[index].bagian;
			var no_hp 		= result[index].no_hp;
			var status 		= result[index].status;
			sno+=1;
			var tr = "<tr>";
			tr += "<td>"+ sno +".</td>";
			tr += "<td>"+ nip +"</td>";
			tr += "<td>"+ nama +"</td>";
			tr += "<td>"+ jabatan +"</td>";
			tr += "<td>"+ bagian +"</td>";
			tr += "<td>"+ no_hp +"</td>";
			if(status == 'aktif') {
			    tr += "<td><span class='label label-success'>Aktif</span></td>";
			} else {
			    tr += "<td><span class='label label-default'>Non Aktif</span></td>";
			}
			tr += "<td class='text-center'> <a class='btn btn-info btn-edit' data-toggle='modal' data-id="+id+" data-target='#ModalEdit' ><span class='fa fa-pencil'></span></a>";
			tr += "&nbsp;<a class='btn btn-danger btn-hapus' data-toggle='modal' data-id="+id+" data-target='#ModalHapus'><span class='fa fa-trash'></span></a>";
			tr +="</td>";
			tr += "</tr>";
			$('#pegawaiList tbody').append(tr);
		}

		$(".btn-edit").on("click", function() {
			pageno = $("#pagenomer").val();
			id =  $(this).data('id');
			loadbagian();
			loadjabatan();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo base_url('pegawai/get_data_edit_pegawai')?>',
				data:{id:id},
				success: function(res){
					var pegawai =res.pegawai[0]; 
					$('#id_update').val(pegawai.id);
					$('#nip_update').val(pegawai.nip);
					$('#nama_update').val(pegawai.nama);
					$('#jabatan_update').val(pegawai.jabatan).change();;
					$("#bagian_update").val(pegawai.bagian).change();;
					$('#no_hp_update').val(pegawai.no_hp);
					$('#status_update').val(pegawai.status);
					
					$("#update").on("click", function() {
						var id = $('#id_update').val();
						var nip = $('#nip_update').val();
						var nama = $('#nama_update').val();
						var jabatan = $('#jabatan_update').val();
						var bagian = $('#bagian_update').val();
						var no_hp = $('#no_hp_update').val();
						var status = $('#status_update').val();
					
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: '<?php echo base_url('pegawai/update_pegawai')?>',
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
								loadPagination(pageno);
							}
						});
					});
				}
			});
		});
		$(".btn-hapus").on("click", function(){
			id =  $(this).data('id');
			$('#id_hapus').val(id);
		});
		
	}
	$("#hapus_pegawai").on("click", function(){
		id = $('#id_hapus').val();
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '<?php echo base_url('pegawai/hapus_pegawai')?>',
			data:{id:id},
			success: function(res){
				pageno = $("#pagenomer").val();
				loadPagination(pageno);
				if(res.pesan == 'success'){
					$.toast({
		                heading: 'Success',
		                text: "Data Berhasil dihapus.",
		                showHideTransition: 'slide',
		                icon: 'success',
		                hideAfter: 3000,
		                position: 'top-right',
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
		                position: 'top-right',
		                bgColor: '#f39c12'
		            });
				}
				$('#ModalHapus').modal('hide');
			}
		});
	});

	$(".filter").on("input", function() {
		var keywords = $('.filter').val();
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '<?php echo base_url('pegawai/filter_data')?>',
			data:{keywords:keywords},
			success: function(response){
				$('#pagination').html(response.pagination);
				createTable(response.result,response.row);
			}
		});
	});
	
	function loadbagian(){
		$.ajax({
			url: '<?php echo base_url()?>pegawai/loadbagian',
			type: 'get',
			success: function(response){
				$('#bagian').html(response);
				$('#bagian').select2();
				$('#bagian_update').html(response);
				$('#bagian_update').select2();
			}
		});
	}
	function loadjabatan(){
		$.ajax({
			url: '<?php echo base_url()?>pegawai/loadjabatan',
			type: 'get',
			success: function(response){
				$('#jabatan').html(response);
				$('#jabatan').select2();
				$('#jabatan_update').html(response);
				$('#jabatan_update').select2();
			}
		});
	}
	$(document).on('show.bs.modal','#myModal', function () {
		loadbagian();
		loadjabatan();
	});
	$(document).on('show.bs.modal','#ModalHapus', function () {
		loadbagian();
		loadjabatan();
	});
	$(document).on('hidden.bs.modal','.modal', function () {
		$(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
	});



</script>

<!-- <?php 
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

    <?php endif;?> -->
</body>
</html>

  