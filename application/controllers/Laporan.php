<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('Model_transaksi', 'transaksi');
        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('nama')) {
            redirect('login', 'refresh');
        }
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

    public function strip()
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
            'halaman' => $this->load->view('pages/v_laporan_strip', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function cetakLaporan()
    {
        $rTanggalMulai = $this->input->post('tgl-mulai');
        $rTanggalAkhir = $this->input->post('tgl-akhir');
        $image1 = base_url('dist/assets/images/laporan.png');

        // header
        $pdf = new FPDF('P', 'mm', 'A3');
        $pdf->AddPage();
        $pdf->Image($image1, $pdf->GetX(), 7, 33.78);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(280, 7, 'LAPORAN TRANSAKSI KAS', 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(280, 7, 'Jl. Jeruk No. 12, Sukamaju', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(281, 7, 'Telp : 0888-7577-1937 | email : abah@sekeluarga.com ', 0, 0, 'R');

        $pdf->SetLineWidth(.3);
        $pdf->Line(10, 36, 290, 36);
        $pdf->Ln(5);
        $pdf->Cell(10, 12, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(32, 8, 'Admin ', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(45, 8, ':   ' . $this->session->userdata('nama'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(32, 8, 'Tanggal Cetak ', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(31, 8, ':   ' . date('d-m-Y') . ' ' . date('H:i:s'), 0, 1,);
        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(32, 8, 'Tanggal Awal ', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(45, 8, ':   ' . date('d-m-Y', strtotime($rTanggalMulai)), 0, 0);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(32, 8, 'Tanggal Akhir ', 0, 0,);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(31, 8, ':   ' . date('d-m-Y', strtotime($rTanggalAkhir)), 0, 1,);
        } else {
            $pdf->Cell(32, 8, 'Tanggal Awal ', 0, 0,);
            $pdf->Cell(31, 8, ':   -', 0, 1);
            $pdf->Cell(32, 8, 'Tanggal Akhir ', 0, 1,);
            $pdf->Cell(31, 8, ':   -', 0, 1);
        }
        $pdf->Cell(10, 4, '', 0, 1);

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

        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $this->db->where('tanggal BETWEEN "' . date($rTanggalMulai) . '" AND "' . date($rTanggalAkhir) . '"');
        }

        $sql = "SELECT SUM(IF(jenis = 'M', nominal, -nominal)) AS saldoawal FROM transaksi WHERE tanggal < '" . date($rTanggalMulai) . "'";
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
        $pdf->Cell(30, 8, 'Rp 0', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Rp 0', 1, 0, 'C');
        $pdf->Cell(30, 8, ($saldoAwal == NULL) ? 'Rp 0' : 'Rp ' .  number_format($saldoAwal[0]['saldoawal'], 0, ".", "."), 1, 1, 'C');

        $data = $this->db->get('vtotal')->result();
        $i = 1;
        $saldo = (int)$saldoAwal[0]['saldoawal'];
        $totalMasuk = 0;
        $totalKeluar = 0;
        $pdf->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $pdf->Cell(10, 8, ++$i, 1, 0, 'C');
            $pdf->Cell(40, 8, $row->notransaksi, 1, 0, 'C');
            $pdf->Cell(30, 8, date('d-m-Y', strtotime($row->tanggal)), 1, 0, 'C');
            $pdf->Cell(35, 8, $row->nama, 1, 0, 'C');
            if ($row->rincian == "indomie") {
                $pdf->setFillColor(36, 255, 58);
                $pdf->Cell(60, 8, $row->rincian, 1, 0, 'C', true);
            } else {
                $pdf->Cell(60, 8, $row->rincian, 1, 0, 'C');
            }
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

    public function cetakLaporanStrip()
    {
        $rTanggalMulai = $this->input->post('tanggal_mulai_laporan_strip');
        $rTanggalAkhir = $this->input->post('tanggal_akhir_laporan_strip');
        $image1 = base_url('dist/assets/images/laporan.png');

        // header
        $pdf = new FPDF('P', 'mm', 'A3');
        $pdf->AddPage();
        $pdf->Image($image1, $pdf->GetX(), 7, 33.78);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(280, 7, 'LAPORAN TRANSAKSI KAS', 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(280, 7, 'Jl. Jeruk No. 12, Sukamaju', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(281, 7, 'Telp : 0888-7577-1937 | email : abah@sekeluarga.com ', 0, 0, 'R');

        $pdf->SetLineWidth(.3);
        $pdf->Line(10, 36, 290, 36);
        $pdf->Ln(5);
        $pdf->Cell(10, 12, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(32, 8, 'Admin ', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(45, 8, ':   ' . $this->session->userdata('nama'), 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(32, 8, 'Tanggal Cetak ', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(31, 8, ':   ' . date('m-d-Y') . ' ' . date('H:i:s'), 0, 1,);
        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(32, 8, 'Tanggal Awal ', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(45, 8, ':   ' . date('d-m-Y', strtotime($rTanggalMulai)), 0, 0);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(32, 8, 'Tanggal Akhir ', 0, 0,);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(31, 8, ':   ' . date('d-m-Y', strtotime($rTanggalAkhir)), 0, 1,);
        } else {
            $pdf->Cell(32, 8, 'Tanggal Awal ', 0, 0,);
            $pdf->Cell(31, 8, ':   -', 0, 1);
            $pdf->Cell(32, 8, 'Tanggal Akhir ', 0, 1,);
            $pdf->Cell(31, 8, ':   -', 0, 1);
        }
        $pdf->Cell(10, 4, '', 0, 1);

        //  tabel transaksi
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 8, 'No', 'BLT', 0, 'C');
        $pdf->Cell(40, 8, 'Nomor Transaksi', 'BT', 0, 'C');
        $pdf->Cell(30, 8, 'Tanggal', 'BT', 0, 'C');
        $pdf->Cell(35, 8, 'Nama', 'BT', 0, 'C');
        $pdf->Cell(60, 8, 'Rincian', 'BT', 0, 'C');
        $pdf->Cell(15, 8, 'Jenis', 'BT', 0, 'C');
        $pdf->Cell(30, 8, 'Masuk', 'BT', 0, 'C');
        $pdf->Cell(30, 8, 'Keluar', 'BT', 0, 'C');
        $pdf->Cell(30, 8, 'Saldo', 'BRT', 1, 'C');

        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $this->db->where('tanggal BETWEEN "' . date($rTanggalMulai) . '" AND "' . date($rTanggalAkhir) . '"');
        }

        $sql = "SELECT SUM(IF(jenis = 'M', nominal, -nominal)) AS saldoawal FROM transaksi WHERE tanggal < '" . date($rTanggalMulai) . "'";
        $query = $this->db->query($sql);
        $saldoAwal = $query->result_array();

        // var_dump($saldoAwal);
        // die;

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 8, '1', 'LB', 0, 'C');
        $pdf->Cell(40, 8, '-', 'B', 0, 'C');
        $pdf->Cell(30, 8, '-', 'B', 0, 'C');
        $pdf->Cell(35, 8, '-', 'B', 0, 'C');
        $pdf->Cell(60, 8, 'Saldo Awal', 'B', 0, 'C');
        $pdf->Cell(15, 8, 'M', 'B', 0, 'C');
        $pdf->Cell(30, 8, 'Rp 0', 'B', 0, 'C');
        $pdf->Cell(30, 8, 'Rp 0', 'B', 0, 'C');
        $pdf->Cell(30, 8, ($saldoAwal == NULL) ? 'Rp 0' : 'Rp ' .  number_format($saldoAwal[0]['saldoawal'], 0, ".", "."), 'BR', 1, 'C');

        $data = $this->db->get('vtotal')->result();
        $i = 1;
        $saldo = (int)$saldoAwal[0]['saldoawal'];
        $totalMasuk = 0;
        $totalKeluar = 0;
        $pdf->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $pdf->Cell(10, 8, ++$i, 'LB', 0, 'C');
            $pdf->Cell(40, 8, $row->notransaksi, 'B', 0, 'C');
            $pdf->Cell(30, 8, date('d-m-Y', strtotime($row->tanggal)), 'B', 0, 'C');
            $pdf->Cell(35, 8, $row->nama, 'B', 0, 'C');
            $pdf->Cell(60, 8, $row->rincian, 'B', 0, 'C',);
            $pdf->Cell(15, 8, $row->jenis, 'B', 0, 'C');
            $pdf->Cell(30, 8, 'Rp ' . number_format($row->Masuk, 0, ".", "."), 'B', 0, 'C');
            $pdf->Cell(30, 8, 'Rp ' . number_format($row->Keluar, 0, ".", "."), 'B', 0, 'C');
            if ($row->jenis == "M") {
                $saldo = $saldo + $row->Masuk;
                $totalMasuk = $totalMasuk + $row->Masuk;
            } else {
                $saldo = $saldo - $row->Keluar;
                $totalKeluar = $totalKeluar + $row->Keluar;
            }
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(30, 8, 'Rp ' . number_format($saldo, 0, ".", "."), 'BR', 1, 'C');
            $pdf->SetFont('Arial', '', 12);
        }
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'Total', 'LB', 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . number_format($totalMasuk, 0, ".", "."), 'B', 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . number_format($totalKeluar, 0, ".", "."), 'B', 0, 'C');
        $pdf->Cell(30, 8, 'Rp ' . number_format($saldo, 0, ".", "."), 'BR', 1, 'C');
        $pdf->SetXY(35, 25);

        $pdf->Output('I', 'Cetak Laporan.pdf');
    }
}

/* End of file Laporan.php */
