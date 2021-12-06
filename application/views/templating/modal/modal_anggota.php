<div class="col-sm-6 col-md-3 m-t-30">
    <div id="modal_tambah_anggota" data-keyboard="false" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label_modal_tambah_anggota" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="label_modal_tambah_anggota">{judul_modal}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#insert-anggota" role="tab">Manual</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link insert" data-toggle="tab" href="#import-anggota" role="tab">CSV File</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="insert-anggota" role="tabpanel">
                            <form action="" method="post" id="form_tambah_data_anggota">
                                <input class="form-control" type="hidden" name="idanggota" id="idanggota">
                                <div class="form-group">
                                    <label for="nama-anggota">Nama</label>
                                    <input class="form-control" type="text" name="nama-anggota" id="nama-anggota" autocomplete="off" autofocus>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane p-3" id="import-anggota" role="tabpanel">
                            <div class="row">
                                <div class="col-12">

                                    <h4 class="mt-0 header-title">Import File</h4>
                                    <p class="text-muted m-b-15 font-14">
                                        Tarik file atau klik area kotak untuk pilih file.
                                    </p>

                                    <form action="#" id="form_import_anggota" enctype="multipart/form-data" method="post">
                                        <div class="input-group mt-2">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="csv-file">Pilih File</label>
                                                <input type="file" class="custom-file-input" name="nFileUploadAnggota" id="csv-file-anggota" required accept="text/csv" />
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="sumbit">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" id="tombol-keluar" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambah-anggota">{judul_tombol}</button>
                </div>
            </div>
        </div>
    </div>
</div>