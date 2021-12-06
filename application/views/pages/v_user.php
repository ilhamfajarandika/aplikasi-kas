<?php
$user = $this->db->get('vuser')->result_array();
$this->load->helper('tanggal_helper');
$i = 0;
foreach ($user as $row) : ?>
    <div id="container">

    </div>
    <!-- <div class="col-md-4 float-left" id="card-profile"> -->

    <?php
    $tanggal = explode("-", explode(" ", $row['last_seen'])[0]);
    $jam = explode(":", explode(" ", $row['last_seen'])[1]);
    ?>

    <!-- Simple card -->
    <!-- <div class="card m-b-30">
            <img class="card-img-top img-fluid" src="https://picsum.photos/1600/1050?nature=?<?= $i++; ?>" alt="Card image cap">
            <div class="card-profile"></div>
            <div class="card-body" id="profile-user">
                <h4 class="card-title font-20 mt-0 mb-10" id="nama-user">
                    <?= $row['nama']; ?>
                    <i title=" <?= ($row['is_active']) ? 'User Aktif' : 'User Tidak Aktif' ?>" class="mdi mdi-checkbox-blank-circle is-aktif ml-2 <?= ($row['is_active']) ? 'text-primary' : 'text-danger' ?>" style="font-size: 1rem;"></i>
                </h4>
                <ul class="list-group list-group-flush m-b-10">
                    <li class="list-group-item card-text" title="Email" id="email-user">
                        <?= $row['email']; ?>
                    </li>
                    <li class="list-group-item card-text" title="Role">
                        <?= ucfirst($row['role']); ?>
                    </li>
                    <li class="list-group-item card-text" title="Tanggal Registrasi">
                        <?= tanggalLaporan($row['date_created']); ?>
                    </li>
                    <li class="list-group-item card-text" title="Terakhir Online">
                        <?= $tanggal[2] . "-" . $tanggal[1] . "-" . $tanggal[0] ?>
                        <?= explode(" ", $row['last_seen'])[1]; ?>
                    </li> 
                </ul>
            </div>
        </div> -->

    <!-- </div> -->
    <!-- end col -->
<?php endforeach; ?>