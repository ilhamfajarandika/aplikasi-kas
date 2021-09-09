<div class="col-sm-6 col-md-3 m-t-30">
    <div id="modal_tambah_anggota" data-keyboard="false" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label_modal_tambah_anggota" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="label_modal_tambah_anggota">{judul_modal}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form_tambah_data_anggota">
                        <input class="form-control" type="hidden" name="idanggota" id="idanggota">
                        <div class="form-group">
                            <label for="nama-anggota">Nama</label>
                            <input class="form-control" type="text" name="nama-anggota" id="nama-anggota" autocomplete="off" autofocus>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" id="tombol-keluar" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambah-anggota">{judul_tombol}</button>
                </div>
            </div>
        </div>
    </div>
</div>