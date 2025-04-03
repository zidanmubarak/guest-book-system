<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Daftar Acara
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Daftar Acara</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a class="btn btn-success" href="<?php echo base_url().'data_acara/add_acara';?>">
                            <span class="fa fa-plus"></span> Tambah Acara Baru
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length bs-select">
                                
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
                        <table class="table table-bordered table-striped" id='acaraList'>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Poster</th>
                                    <th>Nama Acara</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Penyelenggara</th>
                                    <th>Kapasitas</th>
                                    <th style="text-align:center; width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
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

<!-- Modal Hapus -->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><span class="fa fa-close"></span></span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Hapus Acara</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="kode" id="textkode" value="">
                <input type="hidden" name="poster" id="textposter" value="">
                <div class="alert alert-warning">
                    <p>Apakah Anda yakin ingin menghapus acara ini?</p>
                    <p>Semua data Tamu pada acara ini juga akan terhapus.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger btn-flat" id="btn_hapus">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Add custom style for action buttons spacing -->
<style>
    .action-btn {
        margin: 2px 3px;
        min-width: 68px;
    }
    
    .action-btn-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .action-btn {
            margin: 3px 1px;
            font-size: 11px;
            padding: 3px 5px;
        }
    }
</style>

<!-- Ensure jQuery is properly loaded - Add a script to check -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded! Please check your page includes.');
        return;
    }
    
    jQuery(function($) {
        // Now $ is safely jQuery even in no-conflict mode
        loadPagination(0);
        
        function loadPagination(pagno) {
            $.ajax({
                url: '<?php echo base_url()?>data_acara/loadRecord/'+pagno,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#pagination').html(response.pagination);
                    createTable(response.result, response.row);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                    console.log("Response:", xhr.responseText);
                }
            });
        }
        
        // Handle pagination clicks
        $(document).on('click', '.pagination li a', function(e) {
            e.preventDefault();
            var pageno = $(this).attr('data-ci-pagination-page');
            loadPagination(pageno);
        });
        
        // Filter functionality
        $(".filter").on("input", function() {
            var keywords = $('.filter').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo base_url('data_acara/filter_data')?>',
                data: {keywords: keywords},
                success: function(response) {
                    $('#pagination').html(response.pagination);
                    createTable(response.result, response.row);
                },
                error: function(xhr, status, error) {
                    console.error("Error filtering data:", error);
                    console.log("Response:", xhr.responseText);
                }
            });
        });
        
        // Create the table from JSON data
        function createTable(result, sno) {
            sno = Number(sno);
            $('#acaraList tbody').empty();
            
            if (!result || result.length === 0) {
                var tr = "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
                $('#acaraList tbody').append(tr);
                return;
            }
            
            for(var i = 0; i < result.length; i++) {
                var id = result[i].id;
                var poster = result[i].poster;
                var nama_acara = result[i].nama_acara;
                
                // Parse date properly
                var tanggal_raw = result[i].tanggal;
                var tanggal = new Date(tanggal_raw);
                
                var lokasi = result[i].lokasi;
                var penyelenggara = result[i].penyelenggara;
                var kapasitas = result[i].kapasitas;
                
                // Format date safely
                var formattedDate = "";
                if(!isNaN(tanggal.getTime())) {  // Check if date is valid
                    formattedDate = tanggal.getDate() + '/' + (tanggal.getMonth() + 1) + '/' + tanggal.getFullYear() + 
                                ' ' + tanggal.getHours() + ':' + (tanggal.getMinutes() < 10 ? '0' : '') + tanggal.getMinutes();
                } else {
                    formattedDate = tanggal_raw; // Use raw date if parsing fails
                }
                
                // Poster image
                var posterImg = "";
                if(poster && poster != "") {
                    posterImg = '<img width="100" height="100" class="profile-user-img img-responsive" src="<?php echo base_url()?>assets/images/poster_acara/'+poster+'" onclick="modalimage(this.src)" style="cursor:pointer;">';
                } else {
                    posterImg = '<img width="100" height="100" class="img-circle" src="<?php echo base_url()?>assets/images/no-image.jpg">';
                }
                
                sno += 1;
                
                var tr = "<tr>";
                tr += "<td>"+ sno +".</td>";
                tr += "<td class='text-center'>"+ posterImg +"</td>";
                tr += "<td>"+ nama_acara +"</td>";
                tr += "<td>"+ formattedDate +"</td>";
                tr += "<td>"+ lokasi +"</td>";
                tr += "<td>"+ penyelenggara +"</td>";
                tr += "<td>"+ kapasitas +" orang</td>";
                tr += "<td class='text-center'>";
                tr += "<div class='action-btn-container'>";
                tr += "<a href='<?php echo base_url()?>data_acara/peserta/"+id+"' class='btn btn-primary btn-xs action-btn'><i class='fa fa-users'></i> Tamu</a>";
                tr += "<a href='<?php echo base_url()?>data_acara/laporan/"+id+"' class='btn btn-info btn-xs action-btn'><i class='fa fa-bar-chart'></i> Laporan</a>";
                tr += "<a href='<?php echo base_url()?>data_acara/get_edit_acara/"+id+"' class='btn btn-warning btn-xs action-btn'><i class='fa fa-edit'></i> Edit</a>";
                tr += "<a class='btn btn-danger btn-xs action-btn hapus-acara' data-id='"+id+"' data-poster='"+poster+"'><i class='fa fa-trash'></i> Hapus</a>";
                tr += "</div>";
                tr += "</td>";
                tr += "</tr>";
                
                $('#acaraList tbody').append(tr);
            }
            
            // Handle delete button click
            $('.hapus-acara').on('click', function() {
                var id = $(this).data('id');
                var poster = $(this).data('poster');
                $('#textkode').val(id);
                $('#textposter').val(poster);
                $('#ModalHapus').modal('show');
            });
        }
        
        // Handle confirm delete
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            var poster = $('#textposter').val();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>data_acara/hapus_acara',
                data: {id: kode, poster: poster},
                success: function(response) {
                    if(response === "success") {
                        $('#ModalHapus').modal('hide');
                        loadPagination(0);
                        
                        $.toast({
                            heading: 'Success',
                            text: "Acara berhasil dihapus.",
                            showHideTransition: 'slide',
                            icon: 'success',
                            hideAfter: 3000,
                            position: 'top-right',
                            bgColor: '#00a65a'
                        });
                    } else {
                        $.toast({
                            heading: 'Error',
                            text: "Gagal menghapus acara.",
                            showHideTransition: 'slide',
                            icon: 'error',
                            hideAfter: 3000,
                            position: 'top-right',
                            bgColor: '#f39c12'
                        });
                    }
                }
            });
        });
        
        // Print debug info
        console.log("jQuery version: " + $.fn.jquery);
        console.log("Event list page initialized");
    });
});
</script>