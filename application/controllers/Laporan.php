<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('Model_transaksi', 'transaksi');
    }

    public function index()
    {
        $data = [
            'title' => 'Kas - Laporan Transaksi',
            'judul_halaman' => 'Halaman Laporan Transaksi',
            'kanan_atas' => '
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Kas</a></li>
                    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_laporan', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function cetakLaporan()
    {
        $tanggalMulai = $this->input->post('tgl-mulai');
        $tanggalAkhir = $this->input->post('tgl-akhir');

        // header
        $pdf = new FPDF('P', 'mm', 'A3');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(280, 7, 'LAPORAN TRANSAKSI KAS', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(280, 7, 'Jl. Jeruk No. 12, Sukamaju', 0, 0, 'C');
        $pdf->SetLineWidth(.3);
        $pdf->Line(20, 27, 280, 27);
        $pdf->Ln(5);
        $pdf->Cell(10, 12, '', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 8, 'Admin : ' . $this->session->userdata('nama'), 0, 0);
        if (!empty($tanggalMulai) && !empty($tanggalAkhir)) {
            $pdf->Cell(52, 8, 'Tanggal Awal : ' . date('d-m-Y', strtotime($tanggalMulai),), 0, 0, 'C');
            $pdf->Cell(59, 8, 'Tanggal Akhir : ' . date('d-m-Y', strtotime($tanggalAkhir)), 0, 0, 'C');
        } else {
            $pdf->Cell(52, 8, 'Tanggal Awal : -', 0, 0, 'C');
            $pdf->Cell(59, 8, 'Tanggal Akhir : -', 0, 0, 'C');
        }
        $pdf->Cell(70, 8, 'Tanggal Cetak : ' . date('m-d-Y') . ' ' . date('H:i:s'), 0, 0);
        $pdf->Cell(10, 11, '', 0, 1);

        //  tabel transaksi
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Nomor Transaksi', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Nama', 1, 0, 'C');
        $pdf->Cell(60, 8, 'Rincian', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Jenis', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Masuk', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Keluar', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Saldo', 1, 1, 'C');

        if (!empty($tanggalMulai) && !empty($tanggalAkhir)) {
            $this->db->where('tanggal BETWEEN "' . date($tanggalMulai) . '" AND "' . date($tanggalAkhir) . '"');
        }

        $sql = "SELECT SUM(IF(jenis = 'M', nominal, -nominal)) AS saldoawal FROM transaksi WHERE tanggal <= '" . date($tanggalMulai) . "'";
        $query = $this->db->query($sql);
        $saldoAwal = $query->result_array();

        // var_dump($saldoAwal);
        // die;

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 8, '1', 1, 0, 'C');
        $pdf->Cell(40, 8, '-', 1, 0, 'C');
        $pdf->Cell(30, 8, '-', 1, 0, 'C');
        $pdf->Cell(35, 8, '-', 1, 0, 'C');
        $pdf->Cell(60, 8, 'Saldo Awal', 1, 0, 'C');
        $pdf->Cell(15, 8, 'M', 1, 0, 'C');
        $pdf->Cell(30, 8, ($saldoAwal == NULL) ? 'Rp 0' : 'Rp ' .  number_format($saldoAwal[0]['saldoawal'], 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . '0', 1, 0, 'C');
        $pdf->Cell(30, 8, ($saldoAwal == NULL) ? 'Rp 0' : 'Rp ' .  number_format($saldoAwal[0]['saldoawal'], 0, ".", "."), 1, 1, 'C');

        $data = $this->db->get('vtotal')->result();
        $i = 1;
        $saldo = 0;
        $totalMasuk = 0;
        $totalKeluar = 0;
        $pdf->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $pdf->Cell(10, 8, ++$i, 1, 0, 'C');
            $pdf->Cell(40, 8, $row->notransaksi, 1, 0, 'C');
            $pdf->Cell(30, 8, date('d-m-Y', strtotime($row->tanggal)), 1, 0, 'C');
            $pdf->Cell(35, 8, $row->nama, 1, 0, 'C');
            $pdf->Cell(60, 8, $row->rincian, 1, 0, 'C');
            $pdf->Cell(15, 8, $row->jenis, 1, 0, 'C');
            $pdf->Cell(30, 8, 'Rp ' . number_format($row->Masuk, 0, ".", "."), 1, 0, 'C');
            $pdf->Cell(30, 8, 'Rp ' . number_format($row->Keluar, 0, ".", "."), 1, 0, 'C');
            if ($row->jenis == "M") {
                $saldo = $saldo + $row->Masuk;
                $totalMasuk = $totalMasuk + $row->Masuk;
            } else {
                $saldo = $saldo - $row->Keluar;
                $totalKeluar = $totalKeluar + $row->Keluar;
            }
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(30, 8, 'Rp ' . number_format($saldo, 0, ".", "."), 1, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
        }
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'Total', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . number_format($totalMasuk, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . number_format($totalKeluar, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . number_format($saldo, 0, ".", "."), 1, 1, 'C');
        $pdf->SetXY(35, 25);

        $pdf->Output('I', 'Cetak Laporan.pdf');
    }
}

/* End of file Laporan.php */
