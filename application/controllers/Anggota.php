<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_anggota', 'anggota');
        if (!$this->session->userdata('nama')) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {

        $tombolModal = "";
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2) {
            $tombolModal = '
                <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" data-toggle="modal" data-target="#modal_tambah_anggota">
                    Tambah Anggota
                </button>
            ';
        } else {
            $tombolModal = '
                <ol class="breadcrumb p-0 m-t-10">
                    <li class="breadcrumb-item"><a href="' . base_url() . '">Kas</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url('/anggota') . '">Anggota</a></li>
                </ol>
            ';
        }
        $data = [
            'title' => 'Kas - Daftar Anggota',
            'judul_halaman' => 'Halaman Daftar Anggota',
            'judul_modal' => 'Tambah Anggota',
            'judul_tombol' => 'Tambah Data',
            'kanan_atas' => $tombolModal,
            'halaman' => $this->load->view('pages/v_anggota', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function ambilData()
    {
        if ($this->input->is_ajax_request()) {
            $post = $this->anggota->getAllDataAnggota();
            if ($post) {
                $data = [
                    'responce' => 'success',
                    'post' => $post
                ];
            } else {
                $data = [
                    'responce' => 'error',
                    'post' => 'Gagal Mengambil Data!'
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '
                
            ',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function tambah()
    {
        if ($this->input->is_ajax_request()) {

            $ajax_data = $this->input->post();
            $post = $this->anggota->tambahDataAnggota($ajax_data);

            if ($post) {
                $data = [
                    'responce' => 'success',
                    'message' => 'Data Berhasil Ditambahkan'
                ];
            } else {
                $data = [
                    'responce' => 'error',
                    'message' => 'Data Gagal Ditambahkan'
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '
                
            ',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function hapus()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id_hapus');
            $post = $this->anggota->hapusDataAnggota($id);

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
                'kanan_atas' => '
                
            ',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function edit()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_edit');
            $post = $this->anggota->getDataAnggotaById($id);

            if ($post) {
                $data = [
                    'responce' => 'success',
                    'post' => $post
                ];
            } else {
                $data = [
                    'responce' => 'error',
                    'message' => 'Gagal Mengambil Data'
                ];
            }

            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '
                
            ',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }

    public function update()
    {
        if ($this->input->is_ajax_request()) {

            $post = [
                'idanggota' => $this->input->post('idanggota'),
                'nama' => $this->input->post('nama')
            ];

            if ($this->anggota->updateDataAnggota($post)) {
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
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Kas - Error 404',
                'judul_halaman' => '',
                'judul_modal' => '',
                'judul_tombol' => '',
                'kanan_atas' => '
                
            ',
                'halaman' => $this->load->view('errors/html/error_404.php', '', true),
            ];
            $this->parser->parse('template_page', $data);
        }
    }
}

/* End of file Anggota.php */
