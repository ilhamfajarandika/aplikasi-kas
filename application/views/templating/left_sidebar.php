<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="<?= base_url(); ?>" class="logo"><i class="mdi mdi-minecraft"></i> Kas Kelas</a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Menu</li>

                <li>
                    <a href="<?= base_url(); ?>" class="waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url("transaksi"); ?>" class="waves-effect">
                        <i class="mdi mdi-autorenew"></i>
                        <span> Transaksi</span>
                    </a>
                </li>

                <!-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-clipboard-outline"></i>
                        <span> Laporan </span>
                        <i class="mdi mdi-chevron-right float-right"></i>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?= base_url("laporan"); ?>" class="waves-effect">
                                <span>Tabel Border</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url("laporan/strip"); ?>" class="waves-effect">
                                <span>Tabel Garis</span>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li>
                    <a href="<?= base_url("laporan"); ?>" class="waves-effect">
                        <i class="mdi mdi-clipboard-outline"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url("anggota"); ?>" class="waves-effect">
                        <i class="mdi mdi-account-box-outline"></i>
                        <span> Anggota</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') == 1) : ?>
                    <li>
                        <a href="<?= base_url("user"); ?>" class="waves-effect">
                            <i class="mdi mdi-account-multiple"></i>
                            <span> User</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->