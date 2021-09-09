<?php
if (!function_exists('tanggalLaporan')) {
    function tanggalLaporan($tanggal)
    {
        if ($tanggal == null) {
            return 'DSO : NULL';
        } else {
            $tanggal   = $tanggal <> null ? $tanggal : '2017.01.01';
            $mTahun    = substr($tanggal, 0, 4);
            $mBulan    = substr($tanggal, 5, 2);
            $mTangal   = substr($tanggal, 8, 2);
            // //
            //1 => Menetukan nilai awal array dengan nilai awal 1, jika kosong nilai awal tersisi dengan nilai 0
            $bulan = array(1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            //
            return $mTangal . ' ' . $bulan[(int) $mBulan] . ' ' . $mTahun;
        }
    }
}
