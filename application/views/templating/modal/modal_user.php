<div class="col-sm-6 col-md-3 m-t-30">
    <div id="modal_tambah_user" data-keyboard="false" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label_modal_tambah_user" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="label_modal_tambah_user">{judul_modal}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    <form action="" method="post" id="form_tambah_data_user">
                        <!-- <input class="form-control" type="hidden" name="iduser" id="iduser"> -->
                        <div class="form-group">
                            <label for="namaUser">Nama</label>
                            <input class="form-control" type="text" name="namaUser" id="namaUser" placeholder="Masukkan nama anda ..." autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="emailUser">Email</label>
                            <input class="form-control" type="email" name="emailUser" id="emailUser" placeholder="email@example.com" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="passwordUser">Password</label>
                            <div class="input-group">
                                <input class="form-control" type="password" value="password" name="passwordUser" id="passwordUser" autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-primary d-flex align-items-center" type="button">
                                        <i class="mdi mdi-eye mdi-18px btn-see"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gambarUser">Gambar</label>
                            <input class="form-control" type="text" name="gambarUser" id="gambarUser" autocomplete="off">
                        </div>
                        <div class="form-group ">
                            <label for="role">Role</label>
                            <!-- <input class="form-control" type="hidden" name="role-edit" id="role-edit"> -->
                            <select name="role" id="role" class="form-control">
                                <option value="">--Pilih Role--</option>
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['idrole']; ?>"><?= ucfirst($role['role']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" id="tombol-keluar" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambah-user">{judul_tombol}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>