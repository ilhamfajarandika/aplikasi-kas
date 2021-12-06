<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_auth extends CI_Model
{

    public function tambahDataUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function ambilDataUser()
    {
        $this->db->order_by('iduser', 'desc');
        return $this->db->get('vuser')->result();
    }

    public function cekLogin($email, $password)
    {
        return $user = $this->db->get_where('user', ["email" => $email])->row_array();
    }
}

/* End of file Model_auth.php */
