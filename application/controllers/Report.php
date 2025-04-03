<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        // Periksa apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('guest_model');
        $this->load->helper(['url', 'form', 'date']);
        $this->load->library(['form_validation', 'pdf']);
    }

    /**
     * Halaman index laporan
     */
    public function index() {
        // Redirect ke laporan harian
        redirect('reports/daily');
    }

    /**
     * Laporan harian
     */
    public function daily() {
        $data['title'] = 'Laporan Harian';
        
        // Ambil tanggal dari input, default tanggal hari ini
        $date = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d');
        $data['date'] = $date;
        
        // Ambil data laporan
        $data['guests'] = $this->guest_model->get_daily_report($date);
        
        // Hitung statistik
        $data['total'] = count($data['guests']);
        $data['completed'] = 0;
        $data['waiting'] = 0;
        $data['in_progress'] = 0;
        $data['canceled'] = 0;
        
        foreach ($data['guests'] as $guest) {
            if ($guest->status == 'completed') {
                $data['completed']++;
            } elseif ($guest->status == 'waiting') {
                $data['waiting']++;
            } elseif ($guest->status == 'in-progress') {
                $data['in_progress']++;
            } elseif ($guest->status == 'canceled') {
                $data['canceled']++;
            }
        }
        
        $this->load->view('templates/admin_template', [
            'content' => 'report/daily',
            'data' => $data
        ]);
    }

    /**
     * Laporan bulanan
     */
    public function monthly() {
        $data['title'] = 'Laporan Bulanan';
        
        // Ambil bulan dari input, default bulan ini
        $month = $this->input->get('month') ? $this->input->get('month') : date('Y-m');
        $data['month'] = $month;
        
        // Ambil data laporan
        $data['guests'] = $this->guest_model->get_monthly_report($month);
        
        // Hitung statistik
        $data['total'] = count($data['guests']);
        $data['completed'] = 0;
        $data['waiting'] = 0;
        $data['in_progress'] = 0;
        $data['canceled'] = 0;
        
        // Group by date
        $data['daily_stats'] = [];
        
        foreach ($data['guests'] as $guest) {
            $day = date('Y-m-d', strtotime($guest->check_in));
            
            if (!isset($data['daily_stats'][$day])) {
                $data['daily_stats'][$day] = 0;
            }
            
            $data['daily_stats'][$day]++;
            
            if ($guest->status == 'completed') {
                $data['completed']++;
            } elseif ($guest->status == 'waiting') {
                $data['waiting']++;
            } elseif ($guest->status == 'in-progress') {
                $data['in_progress']++;
            } elseif ($guest->status == 'canceled') {
                $data['canceled']++;
            }
        }
        
        $this->load->view('templates/admin_template', [
            'content' => 'report/monthly',
            'data' => $data
        ]);
    }

    /**
     * Halaman export data
     */
    public function export() {
        $data['title'] = 'Ekspor Data';
        
        // Ambil tanggal dari input
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        if ($start_date && $end_date) {
            // Ambil data laporan
            $data['guests'] = $this->guest_model->get_export_report($start_date, $end_date);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
        } else {
            $data['guests'] = [];
            
            // Default tanggal: bulan ini
            $data['start_date'] = date('Y-m-01');
            $data['end_date'] = date('Y-m-d');
        }
        
        $this->load->view('templates/admin_template', [
            'content' => 'report/export',
            'data' => $data
        ]);
    }

    /**
     * Export ke PDF
     */
    public function export_pdf() {
        // Ambil tanggal dari input
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        if (!$start_date || !$end_date) {
            $this->session->set_flashdata('error', 'Tanggal awal dan akhir harus diisi');
            redirect('reports/export');
        }
        
        // Ambil data laporan
        $data['guests'] = $this->guest_model->get_export_report($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['company_name'] = $this->setting_model->get_setting('company_name', 'PT Example Indonesia');
        $data['site_name'] = $this->setting_model->get_setting('site_name', 'Sistem Buku Tamu');
        
        // Load library PDF
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-tamu-" . $start_date . "-" . $end_date . ".pdf";
        $this->pdf->load_view('report/pdf_template', $data);
    }

    /**
     * Export ke Excel
     */
    public function export_excel() {
        // Ambil tanggal dari input
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        if (!$start_date || !$end_date) {
            $this->session->set_flashdata('error', 'Tanggal awal dan akhir harus diisi');
            redirect('reports/export');
        }
        
        // Ambil data laporan
        $guests = $this->guest_model->get_export_report($start_date, $end_date);
        
        // Load library Excel
        $this->load->library('excel');
        
        // Set properties
        $this->excel->getProperties()
            ->setCreator($this->session->userdata('name'))
            ->setLastModifiedBy($this->session->userdata('name'))
            ->setTitle("Laporan Tamu " . $start_date . " - " . $end_date)
            ->setSubject("Laporan Tamu")
            ->setDescription("Laporan Tamu dari " . $start_date . " sampai " . $end_date);
        
        // Set header
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Institusi')
            ->setCellValue('D1', 'Telepon')
            ->setCellValue('E1', 'Email')
            ->setCellValue('F1', 'Tujuan')
            ->setCellValue('G1', 'Bertemu Dengan')
            ->setCellValue('H1', 'Check In')
            ->setCellValue('I1', 'Check Out')
            ->setCellValue('J1', 'Status');
        
        // Set data
        $row = 2;
        $no = 1;
        
        foreach ($guests as $guest) {
            $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $guest->name)
                ->setCellValue('C' . $row, $guest->institution)
                ->setCellValue('D' . $row, $guest->phone)
                ->setCellValue('E' . $row, $guest->email)
                ->setCellValue('F' . $row, $guest->purpose)
                ->setCellValue('G' . $row, $guest->person_to_meet)
                ->setCellValue('H' . $row, date('d/m/Y H:i', strtotime($guest->check_in)))
                ->setCellValue('I' . $row, $guest->check_out ? date('d/m/Y H:i', strtotime($guest->check_out)) : '-')
                ->setCellValue('J' . $row, ucfirst($guest->status));
            
            $row++;
        }
        
        // Set auto column width
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        
        // Set active sheet index to the first sheet
        $this->excel->setActiveSheetIndex(0);
        
        // Set filename
        $filename = "laporan-tamu-" . $start_date . "-" . $end_date . ".xlsx";
        
        // Redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}