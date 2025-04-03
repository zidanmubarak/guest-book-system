<?php
  $this->load->view('include/v_header');
  $this->load->view('include/v_sidebar');
?>
<style>
.drop-box{  
    border: 7px solid rgb(34, 45, 50);  
    cursor: pointer;
    margin: 5px auto 30px auto;
    position: relative;
    text-align: center;
    width: 200px;
    min-height: 200px;
    background-color: rgb(34, 45, 50);
    z-index: 1;
}
.drop-box p{
    width: 100%;
    display: block;
    color: #fff;
    margin: 25% auto;
}

.drop-box:before {
    content: " ";
    position: absolute;
    z-index: 2;
    top: 1px;
    left: 1px;
    right: 1px;
    bottom: 1px;
    border: 2px dashed rgba(243, 237, 237, 0.32); 
}
#upl{
    display: none;
}
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data User
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User</a></li>
        <li class="active">Data User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                  <a class="btn btn-success btn-flat" data-toggle="modal" data-target="#myModal"><span class="fa fa-user-plus"></span> Add user</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped" >
                    <thead>
                    <tr>
    					<th>Photo</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Kontak</th>
                        <th>Level</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
    				<?php foreach ($data->result_array() as $i) :
                           $user_id=$i['user_id'];
                           $user_nama=$i['nama'];
                           $user_jenkel=$i['jenkel'];
                           $user_email=$i['email'];
                           $user_username=$i['username'];
                           $user_password=$i['password'];
                           $user_nohp=$i['nohp'];
                           $user_level=$i['level'];
                           $user_photo=$i['photo'];
                        ?>
                        <tr>
                            <td><img onclick="modalimage(this.src)" width="40" height="40" class="img-circle" src="<?php echo base_url().'assets/images/'.$user_photo;?>"></td>
                            <td><?php echo $user_nama;?></td>
                            <td><?php echo $user_email;?></td>
                            <?php if($user_jenkel=='L'):?>
                                <td>Laki-Laki</td>
                            <?php else:?>
                                <td>Perempuan</td>
                            <?php endif;?>
                            <td><?php echo $user_username;?></td>
                            <td><?php echo $user_password;?></td>
                            <td><?php echo $user_nohp;?></td>
                            <?php if($user_level=='1'):?>
                                <td>Admin</td>
                            <?php else:?>
                                <td>Petugas</td>
                            <?php endif;?>
                            <td style="text-align:center;">
                                <a class="btn btn-info" data-toggle="modal" data-target="#ModalEdit<?php echo $user_id;?>" ><span class="fa fa-pencil"></span></a>&nbsp;
                                <a class="btn btn-warning" href="<?php echo base_url().'user/reset_password/'.$user_id;?>"><span class="fa fa-refresh"></span></a>&nbsp;
                                <a class="btn btn-danger" data-toggle="modal" data-target="#ModalHapus<?php echo $user_id;?>"><span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
    				<?php endforeach;?>
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

<!--Modal Add User-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="<?php echo base_url().'user/simpan_user'?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Add User</h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-7">
                                <input type="text" name="xnama" class="form-control" id="inputUserName" placeholder="Nama Lengkap" required>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-7">
                                <input type="email" name="xemail" class="form-control" id="inputEmail3" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Jenis Kelamin</label>
                            <div class="col-sm-7">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" id="inlineRadio1" value="L" name="xjenkel" checked=""> 
                                        Laki - laki
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio"  id="inlineRadio1" value="P" name="xjenkel">
                                        Perempuan 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-7">
                                <input type="text" name="xusername" class="form-control" id="inputUserName" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-7">
                                <input type="password" name="xpassword" class="form-control" id="inputPassword3" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword4" class="col-sm-4 control-label">Ulangi Password</label>
                            <div class="col-sm-7">
                                <input type="password" name="xpassword2" class="form-control" id="inputPassword4" placeholder="Ulangi Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Kontak Person</label>
                            <div class="col-sm-7">
                                <input type="text" name="xkontak" class="form-control" id="inputUserName" placeholder="Kontak Person" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Level</label>
                            <div class="col-sm-7">
                                <select class="form-control" name="xlevel" required>
                                    <option value="1">Administrator</option>
                                    <option value="2">Petugas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUserName" class="col-sm-4 control-label">Photo</label>
                            <div class="col-sm-7">
                                <input type="file" name="filefoto" required/>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-flat" id="simpan">Simpan</button>
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>

	<?php 
        foreach ($data->result_array() as $i) :
            $user_id=$i['user_id'];
            $user_nama=$i['nama'];
            $user_jenkel=$i['jenkel'];
            $user_email=$i['email'];
            $user_username=$i['username'];
            $user_password=$i['password'];
            $user_nohp=$i['nohp'];
            $user_level=$i['level'];
            $user_photo=$i['photo'];
    ?>
        <!--Modal Edit user-->
    <div class="modal fade" id="ModalEdit<?php echo $user_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" action="<?php echo base_url().'user/update_user'?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit user</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                    		<input type="hidden" name="kode" value="<?php echo $user_id;?>"/>
                            <input type="text" name="xnama" class="form-control" id="inputUserName" value="<?php echo $user_nama;?>" placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-7">
                            <input type="email" name="xemail" class="form-control" value="<?php echo $user_email;?>" id="inputEmail3" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Jenis Kelamin</label>
                        <div class="col-sm-7">
                    	<?php if($user_jenkel == 'L'):?>
                           <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="L" name="xjenkel" checked>
                                <label for="inlineRadio1"> Laki-Laki</label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="P" name="xjenkel">
                                <label for="inlineRadio2"> Perempuan </label>
                            </div>
                    	<?php else:?>
                    		<div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="L" name="xjenkel">
                                <label for="inlineRadio1"> Laki-Laki </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="P" name="xjenkel" checked>
                                <label for="inlineRadio2"> Perempuan </label>
                            </div>
                    	<?php endif;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Username</label>
                        <div class="col-sm-7">
                            <input type="text" name="xusername" class="form-control" value="<?php echo $user_username;?>" id="inputUserName" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-7">
                            <input type="password" name="xpassword" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword4" class="col-sm-4 control-label">Ulangi Password</label>
                        <div class="col-sm-7">
                            <input type="password" name="xpassword2" class="form-control" id="inputPassword4" placeholder="Ulangi Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Kontak Person</label>
                        <div class="col-sm-7">
                            <input type="text" name="xkontak" class="form-control" value="<?php echo $user_nohp;?>" id="inputUserName" placeholder="Kontak Person" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Level</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="xlevel" required>
                    		<?php if($user_level=='1'):?>
                                <option value="1" selected>Administrator</option>
                                <option value="2">Author</option>
                    		<?php else:?>
                    			<option value="1">Administrator</option>
                                <option value="2" selected>Author</option>
                    		<?php endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserName" class="col-sm-4 control-label">Photo</label>
                        <div class="col-sm-7">
                            <input type="file" name="filefoto" /><br>
                            <div id="ambil_foto_tamu" class="drop-box" >
                                <?php 
                                if(!empty($user_photo) || $user_photo !==""){
                                    if( file_exists("./assets/images/".$user_photo) ) {
                                        echo "<img src='".base_url()."assets/images/".$user_photo."' class='user-image' width='185px' height='185px' />";
                                    }else {
                                        echo "<p>Foto tidak ada</p>";
                                    }
                                }else {
                                    echo "<p>Foto tidak ada</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-flat" id="update">Update</button>
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
	<?php endforeach;?>

	<?php 
        foreach ($data->result_array() as $i) :
            $user_id=$i['user_id'];
            $user_nama=$i['nama'];
            $user_jenkel=$i['jenkel'];
            $user_email=$i['email'];
            $user_username=$i['username'];
            $user_password=$i['password'];
            $user_nohp=$i['nohp'];
            $user_level=$i['level'];
            $user_photo=$i['photo'];
            ?>
	   <!--Modal Hapus user-->
    <div class="modal fade" id="ModalHapus<?php echo $user_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Hapus user</h4>
                </div>
                <form class="form-horizontal" action="<?php echo base_url().'user/hapus_user'?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
        				<input type="hidden" name="kode" value="<?php echo $user_id;?>"/>
                        <p>Apakah Anda yakin mau menghapus user <b><?php echo $user_nama;?></b> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-flat" id="simpan">Hapus</button>
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
	<!--Modal Reset Password-->
    <div class="modal fade" id="ModalResetPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="fa fa-close"></span></span></button>
                    <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <th style="width:120px;">Username</th>
                            <th>:</th>
                            <th><?php echo $this->session->flashdata('username');?></th>
                        </tr>
                        <tr>
                            <th style="width:120px;">Password Baru</th>
                            <th>:</th>
                            <th><?php echo $this->session->flashdata('upass');?></th>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	<?php endforeach;?>





<!-- page script -->
<?php 
    if($this->session->flashdata('msg')=='error'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Error',
                text: "Password dan Ulangi Password yang Anda masukan tidak sama.",
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: false,
                position: 'top-right',
                bgColor: '#FF4859'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='warning'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Warning',
                text: "Image yang Anda masukan terlalu besar/ Tanpa Menyimpan Image.",
                showHideTransition: 'slide',
                icon: 'warning',
                hideAfter: false,
                position: 'top-right',
                bgColor: '#FFC017'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='success'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Success',
                text: "user Berhasil disimpan ke database.",
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: false,
                position: 'top-right',
                bgColor: '#7EC857'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='info'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Info',
                text: "Data User berhasil di perbaharui",
                showHideTransition: 'slide',
                icon: 'info',
                hideAfter: false,
                position: 'top-right',
                bgColor: '#7EC857'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='success-hapus'):?>
        <script type="text/javascript">
            $.toast({
                heading: 'Success',
                text: "user Berhasil dihapus.",
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: false,
                position: 'top-right',
                bgColor: '#7EC857'
            });
        </script>
    <?php elseif($this->session->flashdata('msg')=='show-modal'):?>
        <script type="text/javascript">
                $('#ModalResetPassword').modal('show');
        </script>
    <?php else:?>

    <?php endif;?>
</body>
</html>
