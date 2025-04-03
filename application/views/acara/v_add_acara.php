<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tambah Acara Baru
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().'data_acara'; ?>">Acara</a></li>
            <li class="active">Tambah Acara</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Tambah Acara</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url().'data_acara/simpan_acara'?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Acara</label>
                                        <input type="text" name="xnama_acara" class="form-control" placeholder="Nama Acara" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Acara</label>
                                        <input type="datetime-local" name="xtanggal" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <input type="text" name="xlokasi" class="form-control" placeholder="Lokasi Acara" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="xdeskripsi" class="form-control" rows="3" placeholder="Deskripsi Acara"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Penyelenggara</label>
                                        <input type="text" name="xpenyelenggara" class="form-control" placeholder="Penyelenggara Acara" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kapasitas</label>
                                        <input type="number" name="xkapasitas" class="form-control" placeholder="Kapasitas Tamu" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Poster Acara</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" name="xposter" id="file-input">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="img-preview">
                                            <img id="preview-img" src="<?php echo base_url().'assets/images/no-image.jpg'?>" style="max-width:200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <a href="<?php echo base_url().'data_acara';?>" class="btn btn-default"><span class="fa fa-arrow-left"></span> Kembali</a>
                            <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-save"></span> Simpan</button>
                        </div>
                    </form>
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

<script>
    $(document).ready(function(){
        // Preview gambar saat dipilih
        $("#file-input").change(function() {
            readURL(this);
        });
        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#preview-img').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>