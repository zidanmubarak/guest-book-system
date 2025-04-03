<?php
$acara = $data_acara->row_array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Acara
            <small><?php echo $acara['nama_acara']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url().'data_acara'; ?>">Acara</a></li>
            <li class="active">Edit Acara</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Edit Acara</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url().'data_acara/update_acara'?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="xkode" value="<?php echo $acara['id']; ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Acara</label>
                                        <input type="text" name="xnama_acara" class="form-control" value="<?php echo $acara['nama_acara']; ?>" placeholder="Nama Acara" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Acara</label>
                                        <?php 
                                        // Format tanggal untuk input datetime-local
                                        $tanggal = new DateTime($acara['tanggal']);
                                        $tanggal_format = $tanggal->format('Y-m-d\TH:i');
                                        ?>
                                        <input type="datetime-local" name="xtanggal" class="form-control" value="<?php echo $tanggal_format; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <input type="text" name="xlokasi" class="form-control" value="<?php echo $acara['lokasi']; ?>" placeholder="Lokasi Acara" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="xdeskripsi" class="form-control" rows="3" placeholder="Deskripsi Acara"><?php echo $acara['deskripsi']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Penyelenggara</label>
                                        <input type="text" name="xpenyelenggara" class="form-control" value="<?php echo $acara['penyelenggara']; ?>" placeholder="Penyelenggara Acara" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kapasitas</label>
                                        <input type="number" name="xkapasitas" class="form-control" value="<?php echo $acara['kapasitas']; ?>" placeholder="Kapasitas Peserta" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Poster Acara</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" name="xposter" id="file-input">
                                        <input type="hidden" name="xposter_lama" value="<?php echo $acara['poster']; ?>">
                                        <p class="help-block">Pilih file untuk mengganti poster yang ada.</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="img-preview">
                                            <?php if(!empty($acara['poster'])): ?>
                                                <img id="preview-img" src="<?php echo base_url().'assets/images/poster_acara/'.$acara['poster']; ?>" style="max-width:200px;">
                                            <?php else: ?>
                                                <img id="preview-img" src="<?php echo base_url().'assets/images/no-image.jpg'; ?>" style="max-width:200px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <a href="<?php echo base_url().'data_acara'; ?>" class="btn btn-default"><span class="fa fa-arrow-left"></span> Kembali</a>
                            <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-save"></span> Update</button>
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

<!-- Add this at the end of your v_edit_acara.php file, replacing the existing script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded! Please check your page includes.');
        return;
    }
    
    jQuery(function($){
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
        
        console.log("Edit form initialized");
    });
});
</script>