<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{title}</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php require_once 'templating/css.php' ?>

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">

        <?php require_once 'templating/left_sidebar.php' ?>

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <?php require_once 'templating/topbar.php' ?>

                <div class="page-content-wrapper ">

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <div class="float-right m-b-5">
                                        {kanan_atas}
                                    </div>
                                    <h4 class="">{judul_halaman}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="round">
                                                <i class="mdi mdi-login-variant"></i>
                                            </div>
                                            <div class="col-9 align-self-center text-center">
                                                <div class="m-l-10">
                                                    <p class="mb-0 m-t-5 text-muted">Pemasukan Hari Ini</p>
                                                    <h5 class="mt-0 m-r-15 round-inner">
                                                        Rp {masuk}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="round">
                                                <i class="mdi mdi-logout-variant"></i>
                                            </div>
                                            <div class="col-9 align-self-center text-center">
                                                <div class="m-l-10">
                                                    <p class="mb-0 m-t-5 text-muted">Pengeluaran Hari Ini</p>
                                                    <h5 class="mt-0 m-r-15 round-inner">Rp {keluar} </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="round">
                                                <i class="mdi mdi-wallet"></i>
                                            </div>
                                            <div class="col-9 align-self-center text-center">
                                                <div class="m-l-10">
                                                    <p class="mb-0 m-t-5 text-muted">Total Saldo Hari Ini</p>
                                                    <h5 class="mt-0 m-r-15 round-inner">Rp {saldo}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {halaman}
                        <!-- end page title end breadcrumb -->

                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->


            <?php require_once 'templating/footer.php' ?>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <?php require_once 'templating/js.php' ?>
    <?php require_once 'templating/modal/modal_transaksi.php' ?>
    <?php require_once 'templating/modal/modal_anggota.php' ?>

    <!-- Script Kas -->
    <script>
        let base_url = "http://localhost:85/aplikasikas/";
    </script>
    <script src="<?= base_url(); ?>dist/assets/js/scriptkas/auth.js"></script>
    <script src="<?= base_url(); ?>dist/assets/js/scriptkas/transaksi.js"></script>
    <script src="<?= base_url(); ?>dist/assets/js/scriptkas/anggota.js"></script>
    <script src="<?= base_url(); ?>dist/assets/js/scriptkas/laporan.js"></script>

</body>

</html>