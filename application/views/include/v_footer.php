<footer class="main-footer"> 
		<div class="pull-right hidden-xs"> 
			<b>Version</b> 1.0 
		</div> 
		<strong>Copyright &copy; <?php echo date('Y')?> <a href="<?php echo base_url()?>">GuestBook</a>.</strong> All rights reserved. 
	</footer> 
	<div class="control-sidebar-bg"></div> 
	 
	<div id="myModalImage" class="modal"> 
		<span onclick="closemodal()" data-dismiss="modal" class="close">&times;</span> 
		<img class="modal-content" id="img01"> 
	</div> 
</div> <!-- ./wrapper -->  

<!-- jQuery 2.2.3 --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
<!-- Bootstrap 3.3.6 --> 
<script src="<?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script> 
<!-- FastClick --> 
<script src="<?php echo base_url().'assets/plugins/fastclick/fastclick.js'?>"></script> 
<!-- AdminLTE App --> 
<script src="<?php echo base_url().'assets/dist/js/app.min.js'?>"></script> 
<!-- DataTables --> 
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js'?>"></script> 
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js'?>"></script> 
<!-- Sparkline --> 
<script src="<?php echo base_url().'assets/plugins/sparkline/jquery.sparkline.min.js'?>"></script> 
<!-- jvectormap --> 
<script src="<?php echo base_url().'assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'?>"></script> 
<script src="<?php echo base_url().'assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'?>"></script> 
<!-- SlimScroll 1.3.0 --> 
<script src="<?php echo base_url().'assets/plugins/slimScroll/jquery.slimscroll.min.js'?>"></script> 
<!-- ChartJS 1.0.1 --> 
<script src="<?php echo base_url().'assets/plugins/chartjs_old/Chart.js'?>"></script> 
<!-- toast --> 
<script type="text/javascript" src="<?php echo base_url().'assets/plugins/toast/jquery.toast.min.js'?>"></script> 
<!-- Select2 --> 
<script src="<?php echo base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>  
<script type="text/javascript" src="<?php echo base_url().'assets/dist/js/demo.js'?>"></script> 

<script type="text/javascript"> 
	$(window).on('load', function(){ 
		$("#preloader").fadeOut(300); 
	}); 
	
	$(function () { 
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-tooltip="tooltip"]').tooltip();
	});  
	
	function modalimage(img){ 
		var modal = document.getElementById("myModalImage"); 
		var modalImg = document.getElementById("img01");     
		modal.style.display = "block";     
		modalImg.src = img; 
	} 
	
	function closemodal(){ 
		var modal = document.getElementById("myModalImage"); 
		modal.style.display = "none"; 
	} 
	
	$('#pagination').on('click','a',function(e){ 
		e.preventDefault();  
		var pageno = $(this).attr('data-ci-pagination-page'); 
		$("#pagenomer").val(pageno); 
		loadPagination(pageno); 
	}); 
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
                position: 'top-right',
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
                position: 'top-right',
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
                position: 'top-right',
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
                position: 'top-right',
                bgColor: '#00a65a'
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
                position: 'top-right',
                bgColor: '#f39c12'
            });
        </script>
    <?php else:?>

    <?php endif;?>
</body>
</html>