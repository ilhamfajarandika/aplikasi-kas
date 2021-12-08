<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('tanggal_helper');
        if (!$this->session->userdata('nama')) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $hSaldo = 0;
        $hMasuk = 0;
        $hKeluar = 0;

        $rTanggalHariIni = date('Y-m-d');
        $rTransaksiHari = $this->db->get_where('vtotal', ['tanggal' => $rTanggalHariIni])->result_array();

        if ($rTransaksiHari) {
            foreach ($rTransaksiHari as $i) {
                $hMasuk += $i['Masuk'];
                $hKeluar += $i['Keluar'];
                $hSaldo = $hMasuk - $hKeluar;

                $rDataTransaksi = [
                    'masuk' => $hMasuk,
                    'keluar' => $hKeluar,
                    'saldo' => $hSaldo
                ];
            }
        } else {
            $rDataTransaksi = [
                'masuk' => 0,
                'keluar' => 0,
                'saldo' => 0
            ];
        }

        $data = [
            'title' => 'Kas - Home',
            'judul_halaman' => 'Dashboard',
            'masuk' => $rDataTransaksi['masuk'],
            'keluar' => $rDataTransaksi['keluar'],
            'saldo' => $rDataTransaksi['saldo'],
            'kanan_atas' => '
                <ol class="breadcrumb p-0 m-t-10">
                    <li class="breadcrumb-item"><a href="#">Kas</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_home', '', true)
        ];
        $this->parser->parse('template_home', $data);
    }

    public function chart()
    {
        if ($this->input->is_ajax_request()) {
            $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            $rAwalBulan = [];
            $rAkhirBulan = [];
            $rTransaksiBulan = [];

            foreach ($months as $month) {
                $ts = strtotime($month . date('Y'));

                $dAwalBulan = date('Y-m-01', $ts);
                $dAkhirBulan = date('Y-m-t', $ts);

                $rAwalBulan[] = $dAwalBulan;
                $rAkhirBulan[] = $dAkhirBulan;

                $kelompok = [
                    'mulai' => $rAwalBulan,
                    'selesai' => $rAkhirBulan
                ];
            }

            for ($i = 0; $i < count($months); $i++) {
                $dTransaksiBulan = $this->db->query("SELECT SUM( Masuk ) AS Pemasukan, SUM( Keluar ) AS Pengeluaran  FROM vtotal WHERE tanggal BETWEEN '" . $kelompok['mulai'][$i] . "' AND '" . $kelompok['selesai'][$i] . "'")->result_array();
                $rTransaksiBulan[$months[$i]] = $dTransaksiBulan;
            }

            echo json_encode($rTransaksiBulan);
        }
    }
}

/* End of file Home.php */
