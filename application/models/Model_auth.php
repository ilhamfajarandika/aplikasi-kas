<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_auth extends CI_Model
{

    public function tambahDataUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function cekLogin($email, $password)
    {
        return $user = $this->db->get_where('user', ["email" => $email])->row_array();

        // if (!empty($cek)) {
        //     if (password_verify($password, $user->password)) {
        //         return $user->result();
        //     } else {
        //         return FALSE;
        //     }
        // } else {
        //     return FALSE;
        // }
    }
}

/* End of file Model_auth.php */
