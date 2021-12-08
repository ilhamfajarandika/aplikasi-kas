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
                <ol class="breadcrumb p-0 m-t-10">
                    <li class="breadcrumb-item"><a href="' . base_url() . '">Kas</a></li>
                    <li class="breadcrumb-item"><a href' . base_url('laporan') . '">Laporan</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_laporan', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function cetak()
    {
        if ($this->input->is_ajax_request()) {
            $tanggalMulai = $this->input->post('tanggalawal');
            $tanggalAkhir = $this->input->post('tanggalakhir');
            $tabel = $this->input->post('modeltable');

            $tanggal = [
                'tglmulai' => $tanggalMulai,
                'tglakhir' => $tanggalAkhir
            ];

            $this->session->set_userdata($tanggal);

            if ($tabel == "border") {
                $data = [
                    'tabel' => 'border'
                ];
            } else {
                $data = [
                    'tabel' => 'strip'
                ];
            }

            echo json_encode($data);
        }
    }


    public function cetakborder()
    {
        $rTanggalMulai = $this->session->userdata('tglmulai');
        $rTanggalAkhir = $this->session->userdata('tglakhir');
        $image1 = base_url('dist/assets/images/laporan.png');

        // header
        $pdf = new FPDF('L', 'mm', 'A3');
        $pdf->AddPage();
        $pdf->Image($image1, $pdf->GetX(), 4, 47);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(398, 9, 'LAPORAN TRANSAKSI KAS', 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(398, 8, 'Jl. Jeruk No. 14, Sukamaju, Kotabaru', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(399, 8, 'Telp : 0888-7577-1937 | email : abah@sekeluarga.com ', 0, 0, 'R');

        $pdf->SetLineWidth(.3);
        $pdf->Line(10, 45, 409, 45);
        $pdf->Ln(5);
        $pdf->Cell(10, 20, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(34, 9, 'Admin ', 0, 0);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(50, 9, ':   ' . $this->session->userdata('nama'), 0, 0);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(38, 9, 'Tanggal Cetak ', 0, 0);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(31, 9, ':   ' . date('d-m-Y') . ' ' . date('H:i:s'), 0, 1,);
        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(34, 9, 'Tanggal Awal ', 0, 0);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(50, 9, ':   ' . date('d-m-Y', strtotime($rTanggalMulai)), 0, 0);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(38, 9, 'Tanggal Akhir ', 0, 0,);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(31, 9, ':   ' . date('d-m-Y', strtotime($rTanggalAkhir)), 0, 1,);
        } else {
            $pdf->Cell(38, 9, 'Tanggal Awal ', 0, 0,);
            $pdf->Cell(31, 9, ':   -', 0, 1);
            $pdf->Cell(38, 9, 'Tanggal Akhir ', 0, 1,);
            $pdf->Cell(31, 9, ':   -', 0, 1);
        }
        $pdf->Cell(10, 4, '', 0, 1);

        //  tabel transaksi
        $pdf->SetFont('Arial', 'B', 14.5);
        $pdf->Cell(15, 11, 'No', 1, 0, 'C');
        $pdf->Cell(60, 11, 'Nomor Transaksi', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(70, 11, 'Nama', 1, 0, 'C');
        $pdf->Cell(75, 11, 'Rincian', 1, 0, 'C');
        $pdf->Cell(20, 11, 'Jenis', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Masuk', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Keluar', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Saldo', 1, 1, 'C');

        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $this->db->where('tanggal BETWEEN "' . date($rTanggalMulai) . '" AND "' . date($rTanggalAkhir) . '"');
        }

        $sql = "SELECT SUM(IF(jenis = 'M', nominal, -nominal)) AS saldoawal FROM transaksi WHERE tanggal < '" . date($rTanggalMulai) . "'";
        $query = $this->db->query($sql);
        $saldoAwal = $query->result_array();

        $pdf->SetFont('Arial', '', 14.5);
        $pdf->Cell(15, 11, '1', 1, 0, 'C');
        $pdf->Cell(60, 11, '-', 1, 0, 'C');
        $pdf->Cell(40, 11, '-', 1, 0, 'C');
        $pdf->Cell(70, 11, '-', 1, 0, 'C');
        $pdf->Cell(75, 11, 'Saldo Awal', 1, 0, 'C');
        $pdf->Cell(20, 11, '-', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Rp 0', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Rp 0', 1, 0, 'C');
        $pdf->Cell(40, 11, ($saldoAwal == NULL) ? 'Rp 0' : 'Rp ' .  number_format($saldoAwal[0]['saldoawal'], 0, ".", "."), 1, 1, 'C');

        $data = $this->db->get('vtotal')->result();
        $i = 1;
        $saldo = (int)$saldoAwal[0]['saldoawal'];
        $totalMasuk = 0;
        $totalKeluar = 0;
        $pdf->SetFont('Arial', '', 14.5);
        foreach ($data as $row) {
            $pdf->Cell(15, 11, ++$i, 1, 0, 'C');
            $pdf->Cell(60, 11, $row->notransaksi, 1, 0, 'C');
            $pdf->Cell(40, 11, date('d-m-Y', strtotime($row->tanggal)), 1, 0, 'C');
            $pdf->Cell(70, 11, $row->nama, 1, 0, 'C');
            if ($row->rincian == "indomie") {
                $pdf->setFillColor(36, 255, 58);
                $pdf->Cell(75, 11, $row->rincian, 1, 0, 'C', true);
            } else {
                $pdf->Cell(75, 11, $row->rincian, 1, 0, 'C');
            }
            $pdf->Cell(20, 11, $row->jenis, 1, 0, 'C');
            $pdf->Cell(40, 11, 'Rp ' . number_format($row->Masuk, 0, ".", "."), 1, 0, 'C');
            $pdf->Cell(40, 11, 'Rp ' . number_format($row->Keluar, 0, ".", "."), 1, 0, 'C');
            if ($row->jenis == "M") {
                $saldo = $saldo + $row->Masuk;
                $totalMasuk = $totalMasuk + $row->Masuk;
            } else {
                $saldo = $saldo - $row->Keluar;
                $totalKeluar = $totalKeluar + $row->Keluar;
            }
            $pdf->SetFont('Arial', 'B', 14.5);
            $pdf->Cell(40, 11, 'Rp ' . number_format($saldo, 0, ".", "."), 1, 1, 'C');
            $pdf->SetFont('Arial', '', 14.5);
        }
        $pdf->SetFont('Arial', 'B', 14.5);
        $pdf->Cell(280, 11, 'Total', 1, 0, 'C');
        $pdf->Cell(40, 11, 'Rp ' . number_format($totalMasuk, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(40, 11, 'Rp ' . number_format($totalKeluar, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(40, 11, 'Rp ' . number_format($saldo, 0, ".", "."), 1, 1, 'C');
        $pdf->SetFont('Arial', '', 16);
        $pdf->Cell(450, 30, '', 0, 0, 'C');
        $pdf->Cell(-200, 30, 'Malang, ' . date("d-m-Y"), 0, 1, 'C');
        $pdf->Cell(450, 30, '', 0, 0, 'C');
        $pdf->Cell(-200, 30, $this->session->userdata('nama'), 0, 1, 'C');
        $pdf->Cell(450, -10, '', 0, 0, 'C');
        $pdf->Cell(-200, -10, 'Admin', 0, 1, 'C');
        $pdf->SetXY(35, 25);

        $pdf->Output('I', 'Cetak Laporan.pdf');
    }

    public function cetakstrip()
    {
        $rTanggalMulai = $this->session->userdata('tglmulai');
        $rTanggalAkhir = $this->session->userdata('tglakhir');
        $image1 = base_url('dist/assets/images/laporan.png');

        // header
        $pdf = new FPDF('L', 'mm', 'A3');
        $pdf->AddPage();
        $pdf->Image($image1, $pdf->GetX(), 4, 47);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(398, 9, 'LAPORAN TRANSAKSI KAS', 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(398, 8, 'Jl. Jeruk No. 14, Sukamaju, Kotabaru', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(399, 8, 'Telp : 0888-7577-1937 | email : abah@sekeluarga.com ', 0, 0, 'R');

        $pdf->SetLineWidth(.3);
        $pdf->Line(10, 45, 409, 45);
        $pdf->Ln(5);
        $pdf->Cell(10, 20, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(34, 9, 'Admin ', 0, 0);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(50, 9, ':   ' . $this->session->userdata('nama'), 0, 0);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(38, 9, 'Tanggal Cetak ', 0, 0);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(31, 9, ':   ' . date('d-m-Y') . ' ' . date('H:i:s'), 0, 1,);
        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(34, 9, 'Tanggal Awal ', 0, 0);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(50, 9, ':   ' . date('d-m-Y', strtotime($rTanggalMulai)), 0, 0);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(38, 9, 'Tanggal Akhir ', 0, 0,);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(31, 9, ':   ' . date('d-m-Y', strtotime($rTanggalAkhir)), 0, 1,);
        } else {
            $pdf->Cell(38, 9, 'Tanggal Awal ', 0, 0,);
            $pdf->Cell(31, 9, ':   -', 0, 1);
            $pdf->Cell(38, 9, 'Tanggal Akhir ', 0, 1,);
            $pdf->Cell(31, 9, ':   -', 0, 1);
        }
        $pdf->Cell(10, 4, '', 0, 1);

        //  tabel transaksi
        $pdf->SetFont('Arial', 'B', 14.5);
        $pdf->Cell(15, 11, 'No', 'LBT', 0, 'C');
        $pdf->Cell(60, 11, 'Nomor Transaksi', 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Tanggal', 'BT', 0, 'C');
        $pdf->Cell(70, 11, 'Nama', 'BT', 0, 'C');
        $pdf->Cell(75, 11, 'Rincian', 'BT', 0, 'C');
        $pdf->Cell(20, 11, 'Jenis', 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Masuk', 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Keluar', 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Saldo', 'RBT', 1, 'C');

        if (!empty($rTanggalMulai) && !empty($rTanggalAkhir)) {
            $this->db->where('tanggal BETWEEN "' . date($rTanggalMulai) . '" AND "' . date($rTanggalAkhir) . '"');
        }

        $sql = "SELECT SUM(IF(jenis = 'M', nominal, -nominal)) AS saldoawal FROM transaksi WHERE tanggal < '" . date($rTanggalMulai) . "'";
        $query = $this->db->query($sql);
        $saldoAwal = $query->result_array();

        $pdf->SetFont('Arial', '', 14.5);
        $pdf->Cell(15, 11, '1', 'LBT', 0, 'C');
        $pdf->Cell(60, 11, '-', 'BT', 0, 'C');
        $pdf->Cell(40, 11, '-', 'BT', 0, 'C');
        $pdf->Cell(70, 11, '-', 'BT', 0, 'C');
        $pdf->Cell(75, 11, 'Saldo Awal', 'BT', 0, 'C');
        $pdf->Cell(20, 11, 'M', 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Rp 0', 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Rp 0', 'BT', 0, 'C');
        $pdf->Cell(40, 11, ($saldoAwal == NULL) ? 'Rp 0' : 'Rp ' .  number_format($saldoAwal[0]['saldoawal'], 0, ".", "."), 'RBT', 1, 'C');

        $data = $this->db->get('vtotal')->result();
        $i = 1;
        $saldo = (int)$saldoAwal[0]['saldoawal'];
        $totalMasuk = 0;
        $totalKeluar = 0;
        $pdf->SetFont('Arial', '', 14.5);
        foreach ($data as $row) {
            $pdf->Cell(15, 11, ++$i, 'LBT', 0, 'C');
            $pdf->Cell(60, 11, $row->notransaksi, 'BT', 0, 'C');
            $pdf->Cell(40, 11, date('d-m-Y', strtotime($row->tanggal)), 'BT', 0, 'C');
            $pdf->Cell(70, 11, $row->nama, 'BT', 0, 'C');
            if ($row->rincian == "indomie") {
                $pdf->setFillColor(36, 255, 58);
                $pdf->Cell(75, 11, $row->rincian, 'BT', 0, 'C', true);
            } else {
                $pdf->Cell(75, 11, $row->rincian, 'BT', 0, 'C');
            }
            $pdf->Cell(20, 11, $row->jenis, 'BT', 0, 'C');
            $pdf->Cell(40, 11, 'Rp ' . number_format($row->Masuk, 0, ".", "."), 'BT', 0, 'C');
            $pdf->Cell(40, 11, 'Rp ' . number_format($row->Keluar, 0, ".", "."), 'BT', 0, 'C');
            if ($row->jenis == "M") {
                $saldo = $saldo + $row->Masuk;
                $totalMasuk = $totalMasuk + $row->Masuk;
            } else {
                $saldo = $saldo - $row->Keluar;
                $totalKeluar = $totalKeluar + $row->Keluar;
            }
            $pdf->SetFont('Arial', 'B', 14.5);
            $pdf->Cell(40, 11, 'Rp ' . number_format($saldo, 0, ".", "."), 'BTR', 1, 'C');
            $pdf->SetFont('Arial', '', 14.5);
        }
        $pdf->SetFont('Arial', 'B', 14.5);
        $pdf->Cell(280, 11, 'Total', 'BLT', 0, 'C');
        $pdf->Cell(40, 11, 'Rp ' . number_format($totalMasuk, 0, ".", "."), 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Rp ' . number_format($totalKeluar, 0, ".", "."), 'BT', 0, 'C');
        $pdf->Cell(40, 11, 'Rp ' . number_format($saldo, 0, ".", "."), 'BTR', 1, 'C');
        $pdf->SetFont('Arial', '', 16);
        $pdf->Cell(450, 30, 'Malang, ' . date("d-m-Y"), 0, 0, 'C');
        $pdf->Cell(-200, 30, 'Malang, ' . date("d-m-Y"), 0, 1, 'C');
        $pdf->Cell(450, 30, $this->session->userdata('nama'), 0, 0, 'C');
        $pdf->Cell(-200, 30, 'Bapak Ali', 0, 1, 'C');
        $pdf->Cell(450, -10, 'Admin', 0, 0, 'C');
        $pdf->Cell(-200, -10, 'Pengawas', 0, 1, 'C');
        $pdf->SetXY(35, 25);

        $pdf->Output('I', 'Cetak Laporan.pdf');
    }
}

/* End of file Laporan.php */
