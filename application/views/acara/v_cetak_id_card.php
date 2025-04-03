<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak ID Card Lanyard (Depan & Belakang)</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Include the QR Code library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
        }
        
        .id-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            margin: 0 auto;
            gap: 30px;
        }
        
        .id-card-container {
            width: 85mm; /* Ukuran untuk lanyard standar */
            height: 135mm; /* Ukuran tinggi yang lebih panjang untuk lanyard */
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            page-break-inside: avoid;
        }
        
        .id-card-front, .id-card-back {
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        /* Front side styles */
        .id-card-front {
            display: flex;
            flex-direction: column;
        }
        
        .top-section {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50mm;
            background-color: #17a2b8;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);
            z-index: 1;
        }
        
        .bottom-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50mm;
            background-color: #ffc107;
            clip-path: polygon(0 30%, 100% 0, 100% 100%, 0 100%);
            z-index: 1;
        }
        
        .content-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .logo-container {
            margin-top: 30px; /* Increased top margin to move logo down */
            display: flex;
            flex-direction: column; /* Changed to column layout */
            align-items: center;
            text-align: center;
        }
        
        .small-logo {
            height: 40px; /* Increased logo size */
            margin-bottom: 8px; /* Added margin between logo and text */
        }
        
        .brand-text {
            font-size: 16px; /* Increased font size */
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        .event-subtitle {
            color: #fff;
            font-size: 12px;
            margin-top: 5px;
            opacity: 0.9;
        }
        
        .event-title {
            font-size: 12px;
            color: #333;
            margin-top: 15px; /* More spacing after corporate info */
            text-align: center;
            padding: 0 10px;
        }
        
        .photo-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: #fff;
            border: 3px solid #17a2b8;
            margin-top: 45px; /* Adjusted to create balance */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .photo-circle::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 1px solid rgba(23, 162, 184, 0.3);
            top: -5px;
            left: -5px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }
        
        .name-container {
            margin-top: 15px;
            text-align: center;
            width: 100%;
            padding: 0 15px;
        }
        
        .name {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .position {
            font-size: 13px;
            color: #555;
            margin-bottom: 3px;
            font-weight: 500;
        }
        
        .institution {
            font-size: 12px;
            color: #666;
        }
        
        .category-badge {
            margin-top: 15px;
            padding: 6px 25px;
            background-color: #222;
            color: #ffc107;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .category-badge.vip {
            background-color: #222;
            color: #17a2b8;
        }
        
        .category-badge.pembicara {
            background-color: #222;
            color: #28a745;
        }
        
        .category-badge.panitia {
            background-color: #222;
            color: #ffc107;
        }
        
        .category-badge.media {
            background-color: #222;
            color: #6f42c1;
        }
        
        .category-badge.sponsor {
            background-color: #222;
            color: #dc3545;
        }
        
        .category-badge.umum {
            background-color: #222;
            color: #6c757d;
        }
        
        .contact-info {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #333;
            font-weight: 500;
        }
        
        .contact-item {
            margin-bottom: 3px;
        }
        
        /* Back side styles */
        .id-card-back {
            background-color: #222;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .back-top-section {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50mm;
            background-color: #17a2b8;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 70%);
            z-index: 1;
        }
        
        .back-bottom-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50mm;
            background-color: #ffc107;
            clip-path: polygon(0 0, 100% 30%, 100% 100%, 0 100%);
            z-index: 1;
        }
        
        .back-content {
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            padding: 20px;
        }
        
        .lanyard-hole-cutout {
            width: 16mm;
            height: 8mm;
            background-color: #fff;
            border-radius: 0 0 8mm 8mm;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        
        .contact-email {
            color: #fff;
            font-size: 14px;
            margin-top: 40px;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }
        
        .qr-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .qr-code {
            margin-bottom: 10px;
        }
        
        .code-text {
            font-size: 12px;
            color: #333;
            margin-top: 10px;
            word-break: break-all;
            text-align: center;
            max-width: 150px;
            font-weight: 500;
        }
        
        .expiry-info {
            margin-top: 25px;
            color: #fff;
            font-size: 12px;
            text-align: center;
        }
        
        .id-number {
            margin-top: 5px;
            color: #fff;
            font-size: 12px;
        }
        
        .website-url {
            position: absolute;
            bottom: 15px;
            color: rgba(255,255,255,0.7);
            font-size: 10px;
            letter-spacing: 0.5px;
            z-index: 3;
        }
        
        .print-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px;
            background: linear-gradient(45deg, #17a2b8, #20c997);
            color: white;
            text-align: center;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
        }
        
        .print-button:active {
            transform: translateY(0);
        }
        
        .print-info {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .page-title, .print-button, .print-info {
                display: none;
            }
            
            .id-cards-container {
                display: block;
                max-width: 100%;
            }
            
            .id-card-container {
                box-shadow: none;
                page-break-after: always;
                margin: 0 auto 10mm;
            }
            
            .top-section, .back-top-section {
                background-color: #17a2b8 !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .bottom-section, .back-bottom-section {
                background-color: #ffc107 !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .id-card-back {
                background-color: #222 !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .category-badge {
                background-color: #222 !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <h1 class="page-title">ID Card Lanyard (Depan & Belakang)</h1>
    
    <p class="print-info">Silakan cetak ID card ini. Sisi depan dan belakang akan dicetak secara terpisah sehingga Anda dapat memasang kedua sisi pada holder ID card lanyard.</p>
    
    <div class="id-cards-container">
        <!-- Front Side of ID Card -->
        <div class="id-card-container" id="front-card">
            <!-- Lanyard hole cutout -->
            <div class="lanyard-hole-cutout"></div>
            
            <!-- Front side design -->
            <div class="id-card-front">
                <!-- Background sections -->
                <div class="top-section"></div>
                <div class="bottom-section"></div>
                
                <!-- Content layer -->
                <div class="content-layer">
                    <!-- Logo and corporate name -->
                    <div class="logo-container">
                        <img src="<?php echo base_url().'assets/images/guest.png'; ?>" alt="Logo" class="small-logo">
                        <div class="brand-text">YOUR CORPORATE</div>
                        <div class="event-subtitle">COPY PASTE</div>
                    </div>
                    
                    <!-- Optional event title -->
                    <?php if(!empty($acara['nama_acara'])): ?>
                    <div class="event-title"><?php echo $acara['nama_acara']; ?></div>
                    <?php endif; ?>
                    
                    <!-- Photo circle -->
                    <div class="photo-circle">
                        <?php if(!empty($peserta['foto'])): ?>
                            <img src="<?php echo base_url().'assets/images/foto_peserta/'.$peserta['foto']; ?>">
                        <?php else: ?>
                            <img src="<?php echo base_url().'assets/images/user_blank.png'; ?>">
                        <?php endif; ?>
                    </div>
                    
                    <!-- Name and position -->
                    <div class="name-container">
                        <div class="name"><?php echo $peserta['nama']; ?></div>
                        <?php if(!empty($peserta['jabatan'])): ?>
                            <div class="position"><?php echo $peserta['jabatan']; ?></div>
                        <?php endif; ?>
                        <?php if(!empty($peserta['institusi'])): ?>
                            <div class="institution"><?php echo $peserta['institusi']; ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Category badge -->
                    <div class="category-badge <?php echo $peserta['kategori']; ?>">
                        <?php 
                        switch($peserta['kategori']) {
                            case 'vip':
                                echo 'VIP';
                                break;
                            case 'pembicara':
                                echo 'PEMBICARA';
                                break;
                            case 'panitia':
                                echo 'PANITIA';
                                break;
                            case 'media':
                                echo 'MEDIA';
                                break;
                            case 'sponsor':
                                echo 'SPONSOR';
                                break;
                            default:
                                echo 'PESERTA';
                        }
                        ?>
                    </div>
                    
                    <!-- Contact information -->
                    <div class="contact-info">
                        <?php if(!empty($peserta['no_hp'])): ?>
                            <div class="contact-item"><?php echo $peserta['no_hp']; ?></div>
                        <?php endif; ?>
                        <div class="contact-item">www.yourevent.com</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Back Side of ID Card -->
        <div class="id-card-container" id="back-card">
            <!-- Lanyard hole cutout -->
            <div class="lanyard-hole-cutout"></div>
            
            <!-- Back side design -->
            <div class="id-card-back">
                <!-- Background sections -->
                <div class="back-top-section"></div>
                <div class="back-bottom-section"></div>
                
                <!-- Back content -->
                <div class="back-content">
                    <?php if(!empty($peserta['email'])): ?>
                        <div class="contact-email"><?php echo $peserta['email']; ?></div>
                    <?php else: ?>
                        <div class="contact-email">info@yourevent.com</div>
                    <?php endif; ?>
                    
                    <div class="qr-container">
                        <div id="qrcode" class="qr-code"></div>
                        <div class="code-text"><?php echo $peserta['kode_undangan']; ?></div>
                    </div>
                    
                    <div class="expiry-info">EXPIRE: <?php echo date('d-m-Y', strtotime('+1 day', strtotime($acara['tanggal']))); ?></div>
                    <div class="id-number">ID NO: <?php echo sprintf('%010d', $peserta['id']); ?>-0</div>
                    
                    <div class="website-url">www.eventattendancesystem.com</div>
                </div>
            </div>
        </div>
    </div>
    
    <button class="print-button" onclick="window.print()">Cetak ID Card (Depan & Belakang)</button>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate QR Code using qrcode.js library
            var kodeUndangan = '<?php echo $peserta['kode_undangan']; ?>';
            var qrCodeElement = document.getElementById('qrcode');
            
            // Clear the element first (in case it has content)
            qrCodeElement.innerHTML = '';
            
            // Create QR code with proper size for the back of the card
            new QRCode(qrCodeElement, {
                text: kodeUndangan,
                width: 130,
                height: 130,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            
            console.log("QR Code generated for code: " + kodeUndangan);
        });
    </script>
</body>
</html>