<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_auth', 'auth');
    }

    public function index()
    {
        $data = [
            'title' => 'Kas - Registrasi',
            'halaman' => $this->load->view('auth/registrasi.php', '', true),
        ];

        $this->parser->parse('template_page', $data);
    }

    public function signup()
    {
        if ($this->input->is_ajax_request()) {

            date_default_timezone_set("Asia/Jakarta");

            $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
                'required' => 'Nama Harus Diisi'
            ]);
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]', [
                'required' => 'Email Harus Diisi',
                'valid_email' => 'Email Tidak Valid',
                'is_unique' => 'Email Sudah Registrasi'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', [
                'required' => 'Password Harus Diisi',
                'min_length' => 'Password Terlalu Pendek',
            ]);

            if ($this->form_validation->run() == false) {
                $data = [
                    'responce' => 'error',
                    'message' => validation_errors()
                ];
            } else {

                $ajax_data = [
                    'nama' => $this->input->post('nama'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'image' => 'default.jpg',
                    'is_active' => 1,
                    'last_seen' =>  date("Y-m-d H:i:s"),
                    'date_created' => date("Y-m-d")
                ];

                if ($this->auth->tambahDataUser($ajax_data)) {
                    $data = [
                        'responce' => 'success',
                        'message' => 'Registrasi Berhasil!'
                    ];
                } else {
                    $data = [
                        'responce' => 'error',
                        'message' => 'Registrasi Gagal'
                    ];
                }
            }
            echo json_encode($data);
            $this->session->set_flashdata('pesan', 'Akun Sudah Anda Registrasi!');
        }
    }
}

/* End of file Registrasi.php */
