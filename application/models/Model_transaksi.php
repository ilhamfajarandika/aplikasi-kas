<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_transaksi extends CI_Model
{
    public function getAllDataTransaksi()
    {
        return $this->db->get('vtransaksi')->result();
    }

    public function getDataTransaksiById($id)
    {
        return $this->db->get_where('transaksi', array('idtransaksi' => $id))->result();
    }

    public function tambahData($data)
    {
        return $this->db->insert('transaksi', $data);
    }

    public function updateData($data)
    {
        return $this->db->update('transaksi', $data, ['idtransaksi' => $data['idtransaksi']]);
    }

    public function hapusData($id)
    {
        return $this->db->delete('transaksi', ['idtransaksi' => $id]);;
    }
}

/* End of file Model_transaksi.php */
