<?php
$users = $this->db->get_where('vuser', ['email' => $this->session->userdata('email')])->result();
?>
<div class="card mb-3">
    <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" style="height: 150px !important;">
        <img class="card-profile profile-picture card-profile-left" src="https://picsum.photos/300/300?person" alt="Card image cap">
    </div>
    <?php
    foreach ($users as $user) :
        $rDilihat = explode(" ", $user->last_seen);
        $jam = $rDilihat[1];
        $tanggal = tanggalLaporan($rDilihat[0]);
    ?>
        <div class="card-body" style="margin: 40px 11.5rem 0;">
            <h5 class="card-title"><?= $user->nama; ?></h5>
            <ul class="list-group list-group-flush mx-n3">
                <li class="list-group-item d-flex justify-content-between align-items-center" style="border-top: none;">
                    Email
                    <span><?= $user->email; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Terakhir Dilihat
                    <span><?= $tanggal . " | " . $jam ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Tanggal Registrasi
                    <span><?= tanggalLaporan($user->date_created) ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Role User
                    <span><?= ucfirst($user->role) ?></span>
                </li>
            </ul>
        </div>
    <?php endforeach; ?>
</div>