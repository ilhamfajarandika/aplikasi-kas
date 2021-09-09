<?php
$user = $this->db->get('user')->result_array();
$this->load->helper('tanggal_helper');
foreach ($user as $row) : ?>
    <div class="col-md-4 float-left">

        <!-- Simple card -->
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" src="<?= base_url("vendor/assets/images/small/img-1.jpg"); ?>" alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0 mb-10"><?= $row['nama']; ?></h4>
                <ul class="list-group list-group-flush m-b-10">
                    <li class="list-group-item card-text" title="Email"> <?= $row['email']; ?></li>
                    <li class="list-group-item card-text" title="Tanggal Registrasi"> <?= tanggalLaporan($row['date_created']); ?></li>
                    <li class="list-group-item card-text" title="User Aktif"> <?= ($row['is_active'] == 0) ? "Tidak Aktif" : "Aktif" ?></li>
                    <li class="list-group-item card-text" title="Terakhir Online"> <?= $row['last_seen']; ?></li>
                </ul>
            </div>
        </div>

    </div><!-- end col -->
<?php endforeach; ?>