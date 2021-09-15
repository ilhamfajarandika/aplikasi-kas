<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_file extends CI_Model
{

    public function insert($tabel, $data)
    {
        return $this->db->insert($tabel, $data);
    }

    public function getAllData($tabel)
    {
        return $this->db->get($tabel)->result_array();
    }
}

/* End of file Model_file.php */
