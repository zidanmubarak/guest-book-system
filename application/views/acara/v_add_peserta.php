<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tambah Tamu Baru
            <small><?php echo $acara['nama_acara']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('data_acara'); ?>">Acara</a></li>
            <li><a href="<?php echo base_url('data_acara/peserta/'.$acara['id']); ?>">Tamu</a></li>
            <li class="active">Tambah Tamu</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Tambah Tamu</h3>
                    </div>
                    <!-- form start -->
                    <form action="<?php echo base_url('data_acara/simpan_peserta')?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="xnama" class="form-control" placeholder="Nama Lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="xemail" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label>No. HP</label>
                                        <input type="text" name="xnohp" class="form-control" placeholder="Nomor HP">
                                    </div>
                                    <div class="form-group">
                                        <label>Institusi/Perusahaan</label>
                                        <input type="text" name="xinstitusi" class="form-control" placeholder="Institusi/Perusahaan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <input type="text" name="xjabatan" class="form-control" placeholder="Jabatan">
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori Tamu</label>
                                        <select name="xkategori" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach($kategori_peserta as $key => $value): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Tamu</label>
                                        <p class="help-block mb-3"><i class="fa fa-info-circle"></i> Ambil foto tamu untuk ID Card</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="camera-box">
                                                    <div id="webcam"></div>
                                                    <div class="webcam-controls">
                                                        <button type="button" id="reset-btn" class="btn btn-warning">
                                                            <i class="fa fa-refresh"></i> Reset Cam
                                                        </button>
                                                        <button type="button" id="capture-btn" class="btn btn-primary">
                                                            <i class="fa fa-camera"></i> Ambil Foto
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="img-preview" id="photo-container">
                                                    <img id="photo-preview" src="<?php echo base_url().'assets/images/user_blank.png'?>" class="img-responsive" style="max-height: 180px;">
                                                </div>
                                                <input type="hidden" name="xnama_file_foto" id="foto-base64">
                                                <div class="text-center" style="margin-top: 10px;">
                                                    <button type="button" id="delete-photo-btn" class="btn btn-danger" style="display: none;">
                                                        <i class="fa fa-times"></i> Hapus Foto
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="xacara_id" value="<?php echo $acara['id']; ?>">
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <a href="<?php echo base_url().'data_acara/peserta/'.$acara['id']; ?>" class="btn btn-default"><span class="fa fa-arrow-left"></span> Kembali</a>
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

<style>
/* Camera capture styling */
.camera-box {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.img-preview {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

#webcam {
    background-color: #000;
    border-radius: 6px;
    margin-bottom: 15px;
    overflow: hidden;
}

.webcam-controls {
    display: flex;
    gap: 10px;
}

.webcam-controls .btn {
    flex: 1;
}

.help-block {
    color: #6c757d;
    font-size: 13px;
    margin-bottom: 15px;
}

.help-block i {
    margin-right: 5px;
}

.box-primary {
    border-top-color: #007bff;
}
</style>
    
<!-- Camera Capture Script -->
<script src="<?php echo base_url();?>assets/webcamjs/webcam.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if webcam JS is loaded
    if (typeof Webcam === 'undefined') {
        console.error("Webcam.js is not loaded properly!");
        return;
    }
    
    // Elements
    var webcamDiv = document.getElementById('webcam');
    var photoPreview = document.getElementById('photo-preview');
    var captureBtn = document.getElementById('capture-btn');
    var resetBtn = document.getElementById('reset-btn');
    var deleteBtn = document.getElementById('delete-photo-btn');
    var fotoBase64 = document.getElementById('foto-base64');
    
    // Set up webcam
    function setupWebcam() {
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false,
            flip_horiz: true,
            fps: 45
        });
        
        try {
            Webcam.attach('#webcam');
            console.log("Webcam attached successfully");
        } catch (e) {
            console.error("Error attaching webcam: ", e);
        }
    }
    
    // Initialize on page load
    setupWebcam();
    
    // Capture photo
    if (captureBtn) {
        captureBtn.addEventListener('click', function() {
            Webcam.snap(function(data_uri) {
                photoPreview.src = data_uri;
                fotoBase64.value = data_uri;
                deleteBtn.style.display = 'inline-block';
            });
        });
    }
    
    // Reset webcam
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            Webcam.reset();
            setupWebcam();
        });
    }
    
    // Delete photo
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            photoPreview.src = '<?php echo base_url().'assets/images/user_blank.png'?>';
            fotoBase64.value = '';
            deleteBtn.style.display = 'none';
        });
    }
    
    // Clean up resources when leaving the page
    window.addEventListener('beforeunload', function() {
        Webcam.reset();
    });
});
</script>