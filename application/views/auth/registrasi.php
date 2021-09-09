<!-- Begin page -->
<div class="accountbg"></div>
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center mt-0">
                <span class="logo logo-admin">
                    Halaman Registrasi
                </span>
            </h3>
            <div class="p-3">
                <form class="form-horizontal" method="post" action="">
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="<?= set_value('nama'); ?>" type="text" name="nama" id="nama" placeholder="Nama">
                            <?= form_error('nama', '<small class="form-text text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="<?= set_value('email'); ?>" type="text" name="email" id="email" placeholder="Email">
                            <?= form_error('email', '<small class="form-text text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                            <?= form_error('password', '<small class="form-text text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-danger btn-block waves-effect waves-light" id="signup" type="button">
                                Sign Up
                            </button>
                        </div>
                    </div>

                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-12 m-t-20 text-center">
                            <a href="<?= base_url("login"); ?>" class="text-muted">Sudah Punya Akun?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>