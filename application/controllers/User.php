<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_auth', 'auth');
        date_default_timezone_set("Asia/Jakarta");
        $this->load->helper('tanggal_helper');
        if (!$this->session->userdata('nama')) {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $tombolModal = "";
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2) {
            $tombolModal = '
                <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" data-toggle="modal" data-target="#modal_tambah_user">
                    Input User Baru
                </button>
            ';
        } else {
            $tombolModal = '
                <ol class="breadcrumb p-0 m-t-10">
                    <li class="breadcrumb-item"><a href="#">Kas</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url('/user') . '">User</a></li>
                </ol>
            ';
        }
        $data = [
            'title' => 'Kas - Daftar User',
            'judul_modal' => 'Input User',
            'judul_tombol' => 'Tambah Data',
            'judul_halaman' => 'Halaman Daftar User',
            'roles' => $this->db->get('role_user')->result_array(),
            'kanan_atas' => $tombolModal,
            'halaman' => $this->load->view('pages/v_user', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function ambil()
    {
        if ($this->input->is_ajax_request()) {
            $post = $this->auth->ambilDataUser();
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
        }
    }

    public function tambah()
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules(
                'namaUser',
                'Nama',
                'required',
                ['required' => 'Field Nama harus diisi']
            );

            $this->form_validation->set_rules(
                'emailUser',
                'Email',
                'required|valid_email|is_unique[user.email]',
                [
                    'required' => 'Field Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            );

            $this->form_validation->set_rules(
                'passwordUser',
                'Password',
                'required|min_length[3]',
                [
                    'required' => 'Field Email harus diisi',
                    'min_length' => 'Password minimal 3 karakter'
                ]
            );

            if ($this->form_validation->run() == FALSE) {
                $data = [
                    'response' => 'error',
                    'message' => validation_errors()
                ];
            } else {
                $ajax_data = [
                    'nama' => $this->input->post('namaUser'),
                    'email' => $this->input->post('emailUser'),
                    'password' => password_hash($this->input->post('passwordUser'), PASSWORD_DEFAULT),
                    'image' => $this->input->post('gambarUser'),
                    'role_id' => $this->input->post('role'),
                    'is_active' => 0,
                    'last_seen' =>  date("Y-m-d H:i:s"),
                    'date_created' => date("Y-m-d")
                ];

                if ($this->auth->tambahDataUser($ajax_data)) {
                    $data = [
                        'responce' => 'success',
                        'message' => 'Registrasi  Berhasil!'
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
    public function infoUser()
    {
        $data = [
            'title' => 'Kas - Daftar User',
            'judul_modal' => 'Input User',
            'judul_tombol' => 'Tambah Data',
            'judul_halaman' => 'Halaman Daftar User',
            'kanan_atas' => '
                <ol class="breadcrumb p-0 m-t-10">
                    <li class="breadcrumb-item"><a href="' . base_url() . '">Kas</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url('/user') . '">User</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url('/user/infouser') . '">Info User</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_info_user', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function ubahPassword()
    {
        $data = [
            'title' => 'Kas - Daftar User',
            'judul_modal' => 'Input User',
            'judul_tombol' => 'Tambah Data',
            'judul_halaman' => 'Halaman Daftar User',
            'kanan_atas' => '
                <ol class="breadcrumb p-0 m-t-10">
                    <li class="breadcrumb-item"><a href="' . base_url() . '">Kas</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url('/user') . '">User</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url('/user/ubahpassword') . '">Ubah Password</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_ubah_password', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }

    public function ubah()
    {
        if ($this->input->is_ajax_request()) {
            $password = $this->input->post('password');
            $newPassword = $this->input->post('newPassword');
            $confirmPassword = $this->input->post('confirmPassword');
            $user = $this->auth->getDataByEmail($this->session->userdata('email'));

            if (password_verify($password, $user['password'])) {
                if ($password != null && $newPassword != null && $confirmPassword != null) {
                    if (strlen($newPassword) >= 3) {
                        if ($password != $newPassword) {
                            if ($newPassword == $confirmPassword) {
                                $this->db->set('password', password_hash($newPassword, PASSWORD_DEFAULT));
                                $this->db->where('email', $user['email']);
                                $this->db->update('user');

                                $data = [
                                    'response' => 'success',
                                    'message' => 'Password berhasil diubah'
                                ];
                            } else {
                                $data = [
                                    'response' => 'error',
                                    'message' => 'Password baru dan konfirmasi password tidak sama'
                                ];
                            }
                        } else {
                            $data = [
                                'response' => 'error',
                                'message' => 'Password baru sama dengan password lama!'
                            ];
                        }
                    } else {
                        $data = [
                            'response' => 'error',
                            'message' => 'Password baru harus lebih dari 3 karakter!'
                        ];
                    }
                } else {
                    $data = [
                        'response' => 'error',
                        'message' => 'Field tidak boleh kosong!'
                    ];
                }
            } else {
                $data = [
                    'response' => 'error',
                    'message' => 'Password lama anda salah!'
                ];
            }
            echo json_encode($data);
        }
    }
}

/* End of file User.php */
