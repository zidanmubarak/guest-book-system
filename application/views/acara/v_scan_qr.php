<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Scan QR Code
            <small>Check-in Tamu</small>
        </h1>
        <ol class="breadcrumb"">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Scan QR Code</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Scan QR Code</h3>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Arahkan kamera ke QR code pada undangan atau ID card tamu.
                        </div>
                        
                        <div id="scanner-container" style="max-width: 100%; margin: 0 auto;">
                            <video id="qr-video" style="width: 100%; max-width: 400px; border: 1px solid #ddd;"></video>
                        </div>
                        
                        <div class="text-center" style="margin-top: 15px;">
                            <button id="stop-scanner" class="btn btn-danger">
                                <i class="fa fa-stop"></i> Hentikan Scanner
                            </button>
                            <button id="start-scanner" class="btn btn-success">
                                <i class="fa fa-play"></i> Mulai Scanner
                            </button>
                            <div id="camera-select-container" style="margin-top: 10px; display: none;">
                                <select id="camera-select" class="form-control">
                                    <option value="">Pilih Kamera</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Check-In Manual</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Kode Undangan</label>
                            <div class="input-group">
                                <input type="text" id="kode-undangan" class="form-control" placeholder="Masukkan kode undangan">
                                <span class="input-group-btn">
                                    <button id="check-in-manual" class="btn btn-primary">Check-in</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="box box-success" id="result-box" style="display: none;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hasil Check-in</h3>
                    </div>
                    <div class="box-body">
                        <div id="check-in-result"></div>
                    </div>
                </div>
                
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Riwayat Check-in</h3>
                    </div>
                    <div class="box-body">
                        <div id="history-container">
                            <div class="alert alert-info">
                                Belum ada riwayat check-in.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal for camera permissions -->
<div class="modal fade" id="cameraPermissionModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cameraModalLabel">Akses Kamera Diperlukan</h4>
      </div>
      <div class="modal-body">
        <p>Aplikasi ini membutuhkan akses ke kamera untuk memindai kode QR.</p>
        <p>Silakan berikan izin akses kamera saat diminta oleh browser.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

<!-- Load QR Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.2.1/html5-qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded! Please check your page includes.');
        return;
    }
    
    jQuery(function($) {
        console.log("QR Scanner script initialized");
        
        // Use HTML5 QR Scanner instead of Instascan (which is outdated)
        var html5QrCode;
        var historyCount = 0;
        var cameraId;
        var isScanning = false;
        
        // Show camera permission modal
        $('#cameraPermissionModal').modal('show');
        
        // Initialize QR scanner when modal is closed
        $('#cameraPermissionModal').on('hidden.bs.modal', function() {
            initializeScanner();
        });
        
        function initializeScanner() {
            console.log("Initializing scanner...");
            
            // Create scanner instance
            html5QrCode = new Html5Qrcode("scanner-container");
            
            // Get available cameras
            Html5Qrcode.getCameras()
                .then(function(devices) {
                    console.log("Cameras found:", devices.length);
                    
                    if (devices && devices.length > 0) {
                        // Populate camera selection dropdown
                        var cameraSelect = $('#camera-select');
                        cameraSelect.empty();
                        cameraSelect.append('<option value="">Pilih Kamera</option>');
                        
                        devices.forEach(function(device, index) {
                            var label = device.label || `Camera ${index + 1}`;
                            cameraSelect.append(`<option value="${device.id}">${label}</option>`);
                        });
                        
                        if (devices.length > 1) {
                            // Show camera selection if multiple cameras
                            $('#camera-select-container').show();
                        } else {
                            // Use the only camera available
                            cameraId = devices[0].id;
                        }
                        
                        // Auto-start scanner if there's only one camera
                        if (devices.length === 1) {
                            startScanner();
                        }
                    } else {
                        console.error("No cameras found");
                        alert('No cameras found on your device.');
                    }
                })
                .catch(function(err) {
                    console.error("Error getting cameras", err);
                    alert('Error accessing cameras: ' + err);
                });
        }
        
        // Camera selection changed
        $('#camera-select').on('change', function() {
            var selectedCameraId = $(this).val();
            if (selectedCameraId) {
                cameraId = selectedCameraId;
                if (isScanning) {
                    stopScanner();
                    startScanner();
                } else {
                    startScanner();
                }
            }
        });
        
        // Start scanner
        function startScanner() {
            if (!cameraId) {
                if ($('#camera-select option').length > 1) {
                    cameraId = $('#camera-select').val();
                    if (!cameraId) {
                        alert('Please select a camera first.');
                        return;
                    }
                } else {
                    alert('No camera available.');
                    return;
                }
            }
            
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            };
            
            html5QrCode.start(
                cameraId, 
                config,
                function onScanSuccess(decodedText) {
                    console.log("QR Code detected:", decodedText);
                    // Process the QR code
                    processCheckIn(decodedText);
                },
                function onScanError(error) {
                    // Ignore errors during scanning
                }
            )
            .then(() => {
                console.log("QR Code scanning started.");
                isScanning = true;
            })
            .catch((err) => {
                console.error("Error starting scanner:", err);
                alert("Error starting scanner: " + err);
            });
        }
        
        // Stop scanner
        function stopScanner() {
            if (html5QrCode && isScanning) {
                html5QrCode.stop()
                    .then(() => {
                        console.log("QR Code scanning stopped.");
                        isScanning = false;
                    })
                    .catch((err) => {
                        console.log("Error stopping scanner:", err);
                    });
            }
        }
        
        // Start scanner button
        $('#start-scanner').click(function() {
            startScanner();
        });
        
        // Stop scanner button
        $('#stop-scanner').click(function() {
            stopScanner();
        });
        
        // Manual check-in button
        $('#check-in-manual').click(function() {
            var kode = $('#kode-undangan').val().trim();
            if(kode) {
                processCheckIn(kode);
            } else {
                alert('Please enter an invitation code first.');
            }
        });
        
        // Enter key on invitation code input
        $('#kode-undangan').keypress(function(e) {
            if(e.which == 13) {
                $('#check-in-manual').click();
            }
        });
        
        // Process check-in
        function processCheckIn(kode) {
            console.log("Processing check-in for code:", kode);
            
            $.ajax({
                url: '<?php echo base_url(); ?>data_acara/check_in',
                type: 'POST',
                data: {kode_undangan: kode},
                dataType: 'json',
                success: function(response) {
                    var resultHtml = '';
                    
                    if(response.status === 'success') {
                        // Show success result
                        resultHtml = `
                            <div class="alert alert-success">
                                <h4><i class="icon fa fa-check"></i> Check-in Berhasil!</h4>
                                <p>Kode: <strong>${kode}</strong></p>
                                <p>Waktu: <strong>${getCurrentTime()}</strong></p>
                            </div>
                        `;
                        
                        // Add to history
                        addToHistory(kode, true);
                        
                        // Reset input
                        $('#kode-undangan').val('');
                        
                        // Play success sound if available
                        playSound('success');
                    } else {
                        // Show failed result
                        resultHtml = `
                            <div class="alert alert-danger">
                                <h4><i class="icon fa fa-ban"></i> Check-in Gagal!</h4>
                                <p>Kode: <strong>${kode}</strong></p>
                                <p>Error: <strong>${response.message}</strong></p>
                            </div>
                        `;
                        
                        // Add to history
                        addToHistory(kode, false);
                        
                        // Play failed sound if available
                        playSound('failed');
                    }
                    
                    // Show result
                    $('#check-in-result').html(resultHtml);
                    $('#result-box').show();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                    alert('Server error occurred: ' + error);
                }
            });
        }
        
        // Add to history
        function addToHistory(kode, success) {
            historyCount++;
            
            // Remove "no history" notification
            if(historyCount === 1) {
                $('#history-container').empty();
            }
            
            // Add new history item
            var historyItem = `
                <div class="callout ${success ? 'callout-success' : 'callout-danger'}">
                    <h4>${kode}</h4>
                    <p>${getCurrentTime()} - ${success ? 'Berhasil' : 'Gagal'}</p>
                </div>
            `;
            
            // Add to the top of the list
            $('#history-container').prepend(historyItem);
        }
        
        // Get current time
        function getCurrentTime() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            return hours + ':' + minutes + ':' + seconds;
        }
        
        // Play sound
        function playSound(type) {
            try {
                var audio = new Audio();
                if(type === 'success') {
                    audio.src = '<?php echo base_url(); ?>assets/sounds/success.mp3';
                } else {
                    audio.src = '<?php echo base_url(); ?>assets/sounds/failed.mp3';
                }
                audio.play().catch(function(e) {
                    console.log("Audio play error:", e);
                });
            } catch (e) {
                console.error("Error playing sound:", e);
            }
        }
    });
});
</script>