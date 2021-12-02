<?php

defined('BASEPATH') or exit('No direct script access allowed');

class File extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'download']);
        $this->load->model('Model_file', 'file');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('nama')) {redirect('login', 'refresh');}
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
        $rFileName = 'data_transaksi_' . mt_rand(100, 2000) . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$rFileName");
        header("Content-Type: application/csv; ");

        // ambil data 
        $rDataAnggota = $this->file->getAllData('vtransaksi');

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

    public function fImportTransaksi()
    {
        if ($this->input->is_ajax_request()) {

            // config lib upload
            $rFilePath = APPPATH . '../dist/assets/file/upload/';
            $rNewName = sha1(rand()).'.csv';
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
                                    'notransaksi' => 'MG-' . mt_rand(1000, 6000). '-' . date("Ymd"),
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
