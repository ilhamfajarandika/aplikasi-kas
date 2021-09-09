<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_anggota extends CI_Model
{
    public function getAllDataAnggota()
    {
        return $query = $this->db->get('anggota')->result();
    }

    public function tambahDataAnggota($data)
    {
        return $this->db->insert('anggota', $data);
    }

    public function hapusDataAnggota($id)
    {
        return $this->db->delete('anggota', ['idanggota' => $id]);
    }

    public function getDataAnggotaById($id)
    {
        return $this->db->get_where('anggota', ['idanggota' => $id])->result();
    }

    public function updateDataAnggota($post)
    {
        return $this->db->update('anggota', $post, ['idanggota' => $post['idanggota']]);
    }
}

/* End of file Model_anggota.php */
