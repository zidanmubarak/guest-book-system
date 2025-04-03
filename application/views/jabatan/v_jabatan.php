<?php
	$this->load->view('include/v_header');
	$this->load->view('include/v_sidebar');
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Jabatan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Data Jabatan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-12">
    			<div class="box">
    				<div class="box-header with-border">
    					<a class="btn btn-success btn-flat" data-toggle="modal" data-target="#myModal"><span class="fa fa-user-plus"></span> Add Jabatan</a>
    				</div>
    				<!-- /.box-header -->
    				<div class="box-body">
    					<table class="table table-bordered table-striped">
    						<thead>
    							<tr>
    								<th>No</th>
    								<th>Nama Jabatan</th>
    								<th>status</th>
    								<th style="text-align:center;">Aksi</th>
    							</tr>
    						</thead>
    						<tbody>
								<?php
									$no = $row;
									foreach ($data as $i) :
				                       $id 			= $i['id'];
				                       $nama_jabatan	= $i['nama_jabatan'];
				                       $status 		= $i['status'];
				                       $no++;
				                    ?>
				                    <tr>
				                        <td><?php echo $no;?>.</td>
				                        <td><?php echo $nama_jabatan;?></td>
				                        <?php if($status=='1'):?>
                                            <td><span class="label label-success">Aktif</span></td>
                                        <?php else:?>
                                            <td><span class="label label-default">Non Aktif</span></td>
                                        <?php endif;?>
				                        <td style="text-align:center;">
				                            <a class="btn btn-info" data-toggle="modal" data-target="#ModalEdit<?php echo $id;?>" ><span class="fa fa-pencil"></span></a> &nbsp;
				                            <a class="btn btn-danger" data-toggle="modal" data-target="#ModalHapus<?php echo $id;?>"><span class="fa fa-trash"></span></a>
				                        </td>
				                    </tr>
								<?php 
									endforeach;
								?>
							</tbody>
						</table>
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

<!-- ./wrapper -->

<!--Modal Add jabatan-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="<?php echo base_url().'jabatan/simpan_jabatan'?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Add</h4>
                </div>
                <div class="modal-body">
                	<div class="form-group">
                		<label for="inputUserName" class="col-sm-4 control-label">Nama jabatan</label>
                		<div class="col-sm-7">
                			<input type="text" name="nama_jabatan" class="form-control" id="nama_jabatan" placeholder="Nama Jabatan" required>
                			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                		</div>
                	</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="simpan">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>

<?php 
foreach ($data as $i) :
	$id=$i['id'];
	$nama_jabatan=$i['nama_jabatan'];
	$status=$i['status'];
?>
	<!--Modal Edit user-->
    <div class="modal fade" id="ModalEdit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="<?php echo base_url().'jabatan/update_jabatan'?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Nama jabatan</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                    		<input type="hidden" name="id_jabatan" value="<?php echo $id;?>"/>
                            <input type="text" name="nama_jabatan" class="form-control" id="nama_jabatan" value="<?php echo $nama_jabatan;?>" placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="status" required>
                    		<?php if($status=='1'):?>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Non Aktif</option>
                    		<?php else:?>
                    			<option value="1" >Aktif</option>
                                <option value="0" selected>Non Aktif</option>
                    		<?php endif;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="update">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
<?php endforeach;?>

<?php 
foreach ($data as $i) :
	$id=$i['id'];
	$nama_jabatan=$i['nama_jabatan'];
?>
	<!--Modal Hapus jabatan-->
    <div class="modal fade" id="ModalHapus<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
        	 <form class="form-horizontal" action="<?php echo base_url().'jabatan/hapus_jabatan'?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Hapus jabatan</h4>
                </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
        				<input type="hidden" name="id_jabatan" value="<?php echo $id;?>"/>
                        <p>Apakah Anda yakin mau menghapus <b><?php echo $nama_jabatan;?></b> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" id="simpan">Hapus</button>
                </div>
            </div>
       		 </form>
        </div>
    </div>
<?php endforeach;?>

<?php 
    if($this->session->flashdata('msg')=='error-simpan'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Error',
                text: "Data Gagal disimpan, Hubungi Administrator!",
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 3000,
                position: 'top-right',
                bgColor: '#FF4859'
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
                position: 'top-right',
                bgColor: '#FF4859'
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
                position: 'top-right',
                bgColor: '#7EC857'
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
                position: 'top-right'
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
                position: 'top-right',
                bgColor: '#7EC857'
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
                position: 'top-right',
                bgColor: '#FF4859'
            });
        </script>
    <?php else:?>

    <?php endif;?>
</body>
</html>
