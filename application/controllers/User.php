<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Kas - Daftar User',
            'judul_halaman' => 'Halaman Daftar User',
            'user' => $this->db->get('user')->result_array(),
            'kanan_atas' => '
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item"><a href="' . base_url() . '">Kas</a></li>
                    <li class="breadcrumb-item"><a href="' . base_url("user") . '">User</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_user', '', true),
        ];
        $this->parser->parse('template_admin', $data);
    }
}

/* End of file User.php */
