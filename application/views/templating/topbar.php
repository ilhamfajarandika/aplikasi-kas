<!-- Top Bar Start -->
<div class="topbar">

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user text-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <small><?= $this->session->userdata('nama'); ?></small> |
                    <!-- <img src="https://picsum.photos/200/300?cow" alt="user" class="rounded-circle"> -->
                    <img src="https://source.unsplash.com/1600x1050?cow" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= base_url('user/infouser') ?>"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profil User</a>
                    <a class="dropdown-item" href="<?= base_url('user/ubahpassword') ?>"><i class="mdi mdi-account-settings-variant m-r-5 text-muted"></i> Ubah Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="" id="logout"><i class="mdi mdi-logout-variant m-r-5 text-muted"></i> Log Out</a>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>
<!-- Top Bar End -->