<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class File extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'download']);
        $this->load->model('Model_file', 'file');
        $this->load->helper('tanggal_helper');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('nama')) {
            redirect('login', 'refresh');
        }
    }

    public function download()
    {
        $rFile = $this->uri->segment(3);
        $rFile = 'dist/assets/file/download/' . $rFile . '.csv';
        force_download($rFile, NULL);
    }

    public function fExportAnggota()
    {
        // nama file
        $rFileName = 'data_anggota_' . date("Ymd") . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$rFileName");
        header("Content-Type: application/csv; ");

        // ambil data 
        $rDataAnggota = $this->file->getAllData('anggota');

        // membuat file
        $rFile = fopen('php://output', 'w');

        $rHeader = ["idanggota", "nama"];
        fputcsv($rFile, $rHeader, ";");

        foreach ($rDataAnggota as $key => $value) {
            fputcsv($rFile, $value, ";");
        }

        fclose($rFile);
        exit;
    }

    public function fExportTransaksi()
    {
        // nama file
        $rFileName = 'data_transaksi_' . date("d_m_Y") . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$rFileName");
        header("Content-Type: application/csv; ");

        // ambil data 
        $rDataAnggota = $this->file->getAllDataTransaksi('vtransaksi');

        // membuat file
        $rFile = fopen('php://output', 'w');

        $rHeader = ["id", "notransaksi", "nama", "tanggal", "nominal", "rincian", "jenis"];
        fputcsv($rFile, $rHeader, ";");

        foreach ($rDataAnggota as $key => $value) {
            fputcsv($rFile, $value, ";");
        }

        fclose($rFile);
        exit;
    }

    public function fExpostTransaksiExcel()
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // style header kolom tabel
        $style_col = [
            'font' => ['bold' => true], // font jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // text center secara horizontal
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // text center secara vertikal
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ], // set border dengan garis tipis

        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // text center secara vertikal
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ] // set border dengan garis tipis
        ];

        // set title file
        $sheet->setCellValue('A1', 'Data Transaksi');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->applyFromArray($style_col);

        // set header file
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nomor Transaksi');
        $sheet->setCellValue('C2', 'Nama Anggota');
        $sheet->setCellValue('D2', 'Tanggal');
        $sheet->setCellValue('E2', 'Nominal');
        $sheet->setCellValue('F2', 'Rincian');
        $sheet->setCellValue('G2', 'Jenis');

        // style header 
        $sheet->getStyle('A2')->applyFromArray($style_col);
        $sheet->getStyle('B2')->applyFromArray($style_col);
        $sheet->getStyle('C2')->applyFromArray($style_col);
        $sheet->getStyle('D2')->applyFromArray($style_col);
        $sheet->getStyle('E2')->applyFromArray($style_col);
        $sheet->getStyle('F2')->applyFromArray($style_col);
        $sheet->getStyle('G2')->applyFromArray($style_col);

        $dTransaksi = $this->file->getAllDataTransaksi('vtransaksi');
        $no = 1;
        $numRow = 3;
        foreach ($dTransaksi as $row) {
            $sheet->setCellValue('A' . $numRow, $no);
            $sheet->setCellValue('B' . $numRow, $row["notransaksi"]);
            $sheet->setCellValue('C' . $numRow, $row["nama"]);
            $sheet->setCellValue('D' . $numRow, reverseDate($row["tanggal"]));
            $sheet->setCellValue('E' . $numRow, $row["nominal"]);
            $sheet->setCellValue('F' . $numRow, $row["rincian"]);
            $sheet->setCellValue('G' . $numRow, $row["jenis"]);

            // style row 
            $sheet->getStyle('A' . $numRow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numRow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numRow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numRow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numRow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numRow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numRow)->applyFromArray($style_row);

            $no++;
            $numRow++;
        }

        // set width kolom
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(13);

        // set tinggi baris secara default
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->setTitle('Data Transaksi');

        // Proses file excel
        $filename = 'data_transaksi_' . date("d_m_Y") . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=' . $filename); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    public function fImportTransaksi()
    {
        if ($this->input->is_ajax_request()) {

            // config lib upload
            $rFilePath = APPPATH . '../dist/assets/file/upload/';
            $rNewName = sha1(rand()) . '.csv';
            $config = [
                'upload_path' => $rFilePath,
                'allowed_types' => 'csv',
                'overwrite' => true,
                'max_size' => 1024000 * 100000,
                'encrypt_name' => true,
                'file_name' => $rNewName
            ];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $rDoUpload = $this->upload->do_upload('nFileUploadTransaksi');
            $rDataUpload = $this->upload->data();

            // ambil ekstensi file
            $eksten = explode(".", $rDataUpload["file_name"]);

            if ($rDoUpload) {
                if (strtolower(end($eksten)) == "csv" && $rDataUpload["file_size"] > 0) {
                    $i = 0;
                    $rDataInsert = [];
                    $handle = fopen($rDataUpload["full_path"], "r"); // open file csv

                    // untuk indikator
                    $rNamaUser = strtolower($this->session->userdata('nama'));
                    $rTanggal = date('Ymd');
                    $rJam = date('His');

                    while (($row = fgetcsv($handle, 10000, ";"))) { // ambil file csv
                        if (array(null) !== $row) {
                            $i++;
                            if ($i == 1) continue;
                            $tanggal = explode('/', $row[1]);

                            if (strlen(trim($row[0] . $row[1] . $row[2] . $row[3] . $row[4] . $row[5])) > 0) {
                                // data yang diinsert ke db transaksi
                                $rDataInsert = [
                                    'idanggota' => $row[5],
                                    'notransaksi' => 'MG-' . mt_rand(1000, 6000) . '-' . date("Ymd"),
                                    'indikator' => $rNamaUser . '-MG@' . $rTanggal . '.' . $rJam,
                                    'tanggal' => $row[0],
                                    'nominal' => $row[1],
                                    'rincian' => $row[2],
                                    'jenis' => $row[3]
                                ];

                                $this->file->insert('transaksi', $rDataInsert); // insert data ke database
                            }
                        }
                    }
                    fclose($handle); // file close csv
                    $data = [
                        'response' => 'success',
                        'message' => 'Data Berhasil Diimport'
                    ];
                }
            } else {
                $data = [
                    'response' => 'error',
                    'message' => $this->upload->display_errors()
                ];
            }

            echo json_encode($data);
        }
    }

    public function fImportAnggota()
    {
        if ($this->input->is_ajax_request()) {

            // config lib upload
            $rFilePath = APPPATH . '../dist/assets/file/upload/';
            $config = [
                'upload_path' => $rFilePath,
                'allowed_types' => 'csv',
                'overwrite' => true,
                'max_size' => 1024000 * 100000,
            ];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $rDoUpload = $this->upload->do_upload('nFileUploadAnggota');
            $rDataUpload = $this->upload->data();

            // ambil ekstensi file
            $eksten = explode(".", $rDataUpload["file_name"]);

            if ($rDoUpload) {
                if (strtolower(end($eksten)) == "csv" && $rDataUpload["file_size"] > 0) {
                    $i = 0;
                    $rDataInsert = [];
                    $handle = fopen($rDataUpload["full_path"], "r"); // open file csv

                    // untuk indikator
                    $rNamaUser = strtolower($this->session->userdata('nama'));
                    $rTanggal = date('Ymd');
                    $rJam = date('His');

                    while (($row = fgetcsv($handle, 10000, ";"))) { // ambil file csv
                        if (array(null) !== $row) {
                            $i++;
                            if ($i == 1) continue;

                            if (strlen(trim($row[0])) > 0) {
                                // data yang diinsert ke db transaksi
                                $rDataInsert = [
                                    'nama' => $row[0],
                                ];

                                $this->file->insert('anggota', $rDataInsert); // insert data ke database
                            }
                        }
                    }
                    fclose($handle); // file close csv
                    $data = [
                        'response' => 'success',
                        'message' => 'Data Berhasil Diimport'
                    ];
                }
            } else {
                $data = [
                    'response' => 'error',
                    'message' => $this->upload->display_errors()
                ];
            }

            echo json_encode($data);
        }
    }
}

/* End of file File.php */
