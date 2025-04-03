<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Jika menggunakan PhpSpreadsheet (versi terbaru)
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel {
    protected $spreadsheet;
    
    public function __construct() {
        // Membuat instance baru
        $this->spreadsheet = new Spreadsheet();
    }
    
    public function getSpreadsheet() {
        return $this->spreadsheet;
    }
    
    public function createWriter($type = 'Xlsx') {
        return IOFactory::createWriter($this->spreadsheet, $type);
    }
}