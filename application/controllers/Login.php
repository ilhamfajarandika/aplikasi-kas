<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_auth', 'auth');
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $data = [
            'title' => 'Kas - Login',
            'halaman' => $this->load->view('auth/login.php', '', true),
        ];

        $this->parser->parse('template_page', $data);
    }

    public function cek()
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
                'required' => 'Email Harus Diisi',
                'valid_email' => 'Email Tidak Valid',
            ]);
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]', [
                'required' => 'Password Harus Diisi',
                'min_length' => 'Password Terlalu Pendek',
            ]);


            if ($this->form_validation->run() == FALSE) {
                $data = [
                    'responce' => 'error',
                    'message' => validation_errors()
                ];
            } else {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $cek = $this->auth->cekLogin($email, $password);

                if (!empty($cek)) {
                    if ($cek['role_id'] != null) {
                        if (password_verify($password, $cek['password'])) {

                            $role = 0;

                            if ($cek['role_id'] == 1) {
                                $role = 1;
                            } elseif ($cek['role_id'] == 2) {
                                $role = 2;
                            } else {
                                $role = 3;
                            }
                            
                            $session_data = [
                                'nama' => $cek['nama'],
                                'role' => $role
                            ];

                            $this->session->set_userdata($session_data);

                            $data = [
                                'is_active' => 1
                            ];
                            
                            $this->db->update('user', $data, ['nama' => $this->session->userdata('nama')]);

                            $data = [
                                'responce' => 'success',
                                'message' => 'Berhasil Login!'
                            ];
                        } else {
                            $data = [
                                'responce' => 'error',
                                'message' => 'Password Salah!'
                            ];
                        }
                    } else {
                        $data = [
                            'responce' => 'error',
                            'message' => 'Gagal Login!'
                        ];
                    }
                } else {
                    $data = [
                        'responce' => 'error',
                        'message' => 'Gagal Login!'
                    ];
                }
            }
            echo json_encode($data);
        }
    }

    public function logout()
    {
        $data = [
            'is_active' => 0,
            'last_seen' => date('Y-m-d H:i:s')
        ];
        $this->db->update('user', $data, ['nama' => $this->session->userdata('nama')]);
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }
}

/* End of file Login.php */
