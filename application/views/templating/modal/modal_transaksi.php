<div class="col-sm-6 col-md-3 m-t-30">
    <div id="modal_tambah_transaksi" data-keyboard="false" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label_modal_tambah_transaksi" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="label_modal_tambah_transaksi">{judul_modal}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form_tambah_data_transaksi">
                        <input class="form-control" type="hidden" name="idtransaksi" id="idtransaksi">
                        <div class="form-group notransaksi">
                            <label for="notransaksi">Nomor Transaksi</label>
                            <input class="form-control" type="text" name="notransaksi" id="notransaksi">
                        </div>
                        <div class="form-group ">
                            <label for="nama">Nama</label>
                            <select class="form-control" name="nama" id="nama">
                                <option value="Pilih Nama Anggota" id="pilih-anggota">Pilih Nama Anggota</option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="tanggal">Tanggal</label>
                            <input class="form-control" name="tanggal" type="date" id="tanggal">
                        </div>
                        <div class="form-group ">
                            <label for="nominal">Nominal</label>
                            <input class="form-control" autocomplete="off" type="text" name="nominal" id="nominal">
                        </div>
                        <div class="form-group ">
                            <label for="rincian">Rincian</label>
                            <textarea class="form-control" name="rincian" id="rincian"></textarea>
                        </div>
                        <div class="form-group ">
                            <label for="jenis">Jenis</label>
                            <input class="form-control" type="hidden" name="jenis-edit" id="jenis-edit">
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="Pilih Jenis">Pilih Jenis</option>
                                <option value="M">Masuk</option>
                                <option value="K">Keluar</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" id="tombol-keluar" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambah-transaksi">{judul_tombol}</button>
                </div>
            </div>
        </div>
    </div>
</div>