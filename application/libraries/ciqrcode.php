<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CIQRCode {
    private $data;
    private $level;
    private $size;
    private $savename;
    
    public function __construct() {
        // Load QR Code library
        require_once(APPPATH . 'third_party/phpqrcode/qrlib.php');
    }
    
    public function generate($params) {
        $this->data = $params['data'];
        $this->level = isset($params['level']) ? $params['level'] : 'H';
        $this->size = isset($params['size']) ? $params['size'] : 10;
        $this->savename = isset($params['savename']) ? $params['savename'] : FCPATH . 'assets/qrcodes/qrcode.png';
        
        // Create directory if not exists
        $dir = dirname($this->savename);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        
        // Generate QR Code
        QRcode::png($this->data, $this->savename, $this->level, $this->size);
    }
} 