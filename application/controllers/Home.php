<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => 'Kas - Home',
            'judul_halaman' => 'Dashboard',
            'kanan_atas' => '
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Kas</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                </ol>
            ',
            'halaman' => $this->load->view('pages/v_home', '', true)
        ];
        $this->parser->parse('template_admin', $data);
    }
}

/* End of file Home.php */
