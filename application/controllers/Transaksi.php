<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_transaksi', 'transaksi');
        $this->load->library('pdf');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->helper('tanggal_helper');
    }

    public function index()
    {
        $data = [
            'title' => 'Kas - Transaksi',
            'judul_halaman' => 'Halaman Transaksi',
            'judul_modal' => 'Input Transaksi',
            'judul_tombol' => 'Tambah Data',
            'kanan_atas' => '
                <a id="download-template-transaksi" href="http://localhost/aplikasikas/file/download/template_transaksi" title="Download Template Input Transaksi (.csv)" class="btn btn-success waves-effect waves-light m-b-10 m-r-5 text-light">
                    Download Template
                </a>
                <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" data-toggle="modal" data-target="#modal_tambah_transaksi">
                    Input Transaksi
                </button>
            ',
            'halaman' => $this->load->view('pages/v_transaksi', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function ambilData()
    {
        if ($this->input->is_ajax_request()) {
            $post = $this->transaksi->getAllDataTransaksi();
            if ($post) {
                $data = [
                    'responce' => 'success',
                    'post' => $post
                ];
            } else {
                $data = [
                    'responce' => 'error',
                    'post' => 'Failed to fetch data'
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function ambilDataById()
    {
        $id = $this->input->post('id');
        $data = $this->transaksi->getDataTransaksiById($id);
        echo json_encode($data);
    }

    public function tambah()
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules(
                'nominal',
                'Nominal',
                'required',
                ['required' => 'Field Nominal harus diisi']
            );
            $this->form_validation->set_rules(
                'rincian',
                'Rincian',
                'required',
                ['required' => 'Field Rincian harus diisi']
            );

            if ($this->form_validation->run() == FALSE) {
                $data = [
                    'responce' => 'error',
                    'message' => validation_errors()
                ];
            } else {

                $nama_user = strtolower($this->session->userdata('nama'));
                $tanggal = date('Ymd');
                $jam = date('His');

                $ajax_data = [
                    'idanggota' => $this->input->post('idanggota'),
                    'notransaksi' => $this->input->post('notransaksi'),
                    'indikator' => $nama_user . '@' . $tanggal . '.' . $jam,
                    'tanggal' => $this->input->post('tanggal'),
                    'nominal' => $this->input->post('nominal'),
                    'rincian' => $this->input->post('rincian'),
                    'jenis' => $this->input->post('jenis'),
                ];
                if ($this->transaksi->tambahData($ajax_data)) {
                    $data = [
                        'responce' => 'success',
                        'message' => 'Data Berhasil Ditambahkan'
                    ];
                } else {

                    $data = [
                        'responce' => 'error',
                        'message' => 'Data gagal Ditambahkan'
                    ];
                }
            }

            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function edit()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id');
            $post = $this->transaksi->getDataTransaksiById($id);

            if ($post) {
                $data = [
                    'responce' => 'success',
                    'post' => $post
                ];
            } else {
                $data = [
                    'responce' => 'error',
                    'message' => 'Failed to fetch record'
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function update()
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules(
                'nominal',
                'Nominal',
                'required',
                ['required' => 'Field Nominal harus diisi']
            );
            $this->form_validation->set_rules(
                'rincian',
                'Rincian',
                'required',
                ['required' => 'Field Rincian harus diisi']
            );

            if ($this->form_validation->run() == FALSE) {
                $data = [
                    'responce' => 'error',
                    'message' => validation_errors()
                ];
            } else {
                $data = [
                    'idtransaksi' => $this->input->post('idtransaksi'),
                    'idanggota' => $this->input->post('idanggota'),
                    'tanggal' => $this->input->post('tanggal'),
                    'nominal' => $this->input->post('nominal'),
                    'rincian' => $this->input->post('rincian'),
                    'jenis' => $this->input->post('jenis'),
                ];

                if ($this->transaksi->updateData($data)) {
                    $data = [
                        'responce' => 'success',
                        'message' => 'Data Berhasil Diubah'
                    ];
                } else {
                    $data = [
                        'responce' => 'error',
                        'message' => 'Data Gagal Diubah'
                    ];
                }
            }

            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function hapus()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id_hapus');
            $post = $this->transaksi->hapusData($id);

            if ($post) {
                $data = [
                    'responce' => 'success',
                    'message' => 'Data Berhasil Dihapus'
                ];
            } else {
                $data = [
                    'responce' => 'error',
                    'message' => 'Data Gagal Dihapus'
                ];
            }

            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }


    public function cetak($id)
    {
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetLineWidth(.3);

        $data = $this->db->get_where('vtransaksi', ['id' => $id])->result();


        // header
        // $pdf->SetFont('Arial', 'B', 16);
        // $pdf->Cell(280, 7, 'LAPORAN TRANSAKSI KAS', 0, 1, 'C');
        // $pdf->SetFont('Arial', 'B', 14);
        // $pdf->Cell(280, 7, 'TOKO KELONTONG ABAH SEKELUARGA', 0, 1, 'C');
        // $pdf->SetFont('Arial', 'B', 12);
        // $pdf->Cell(280, 7, 'Jl. Jeruk No. 12, Sukamaju', 0, 0, 'C');
        // $pdf->Line(20, 34, 280, 34);
        // $pdf->SetLineWidth(.5);

        $pdf->RoundedRect(10, 15, 190, 128, 5, '1234', 'D');
        $pdf->SetXY(15, 20);
        $pdf->Cell(180, 15, '', 0, 1, 'C');

        $pdf->SetXY(20, 20);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(180, 15, 'LAPORAN TRANSAKSI KAS', 0, 1, 'L');

        $pdf->SetXY(20, 30);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 7, 'TOKO KELONTONG ABAH SEKELUARGA', 0, 1, 'L');

        foreach ($data as $row) {

            $pdf->SetXY(140, 25);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(50, 10, 'No : ' . $row->notransaksi, 1, 1, 'C');

            $pdf->SetXY(80, 45);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(50, 10, ($row->jenis == 'K') ? 'Kwitansi Kas Keluar' : 'Kwitansi Kas Masuk', 0, 1, 'C');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, 58);
            $pdf->Cell(50, 10, 'Nama          :', 0, 1, 'L');
            $pdf->SetXY(48, 58);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(142, 8, $row->nama, 'B', 1, 'L');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, 69);
            $pdf->Cell(50, 10, 'Rincian       :', 0, 1, 'L');
            $pdf->SetXY(48, 69);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(142, 8, $row->rincian, 'B', 1, 'L');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, 80);
            $pdf->Cell(50, 10, 'Nominal      :', 0, 1, 'L');
            $pdf->SetXY(48, 80);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(142, 8, 'Rp ' . $row->nominal, 'B', 1, 'L');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(20, 91);
            $pdf->Cell(50, 10, 'Tanggal      :', 0, 1, 'L');
            $pdf->SetXY(48, 91);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(142, 8, date('d-m-Y', strtotime($row->tanggal)), 'B', 1, 'L');
        }


        // $pdf->SetXY(15, 20);
        // $pdf->Cell(20, 120, '', 0, 1, 'C');

        // $pdf->SetXY(15, 133);
        // $pdf->Cell(180, 7, '', 0, 1, 'C');

        // $pdf->SetXY(175, 20);
        // $pdf->Cell(20, 120, '', 0, 1, 'C');

        $pdf->SetXY(150, 50);
        $pdf->Cell(20, 120, 'Malang, ' . tanggalLaporan(date('Y-m-d')), 0, 1, 'C');

        $pdf->SetXY(150, 70);
        $pdf->Cell(20, 120, $this->session->userdata('nama'), 0, 1, 'C');

        $pdf->SetXY(95, 79);
        $pdf->Cell(20, 120, 'Dicetak : ' . date('d-m-Y') . ' ' . date('H:i:s') . '  ' .  $this->session->userdata('nama'), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(250, 50);

        $pdf->Output();
    }
}

/* End of file Transaksi.php */
