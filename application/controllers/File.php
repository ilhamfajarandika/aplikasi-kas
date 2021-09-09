<?php

defined('BASEPATH') or exit('No direct script access allowed');

class File extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'download']);
    }

    public function download()
    {

        $file = $this->uri->segment(3);
        $namaFile = 'dist/assets/file/' . $file . '.csv';
        force_download($namaFile, NULL);
    }
}

/* End of file File.php */
