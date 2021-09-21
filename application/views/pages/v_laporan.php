<h4 class="fw-400 text-center" style="margin-bottom: 25px;">Pilih Rentang Tanggal Laporan</h4>
<form target="_blank" action="<?= base_url("laporan/cetaklaporan"); ?>" method="POST">
    <div class="form-group">
        <h6 class="text-muted fw-400">Tanggal</h6>
        <div>
            <div class="input-daterange input-group" id="date-range">
                <input type="date" class="form-control" name="tgl-mulai" required oninvalid="this.setCustomValidity('Tanggal harus diisi')" id="tgl-mulai" placeholder="Tanggal Mulai" />
                <input type="date" class="form-control" name="tgl-akhir" required oninvalid="this.setCustomValidity('Tanggal harus diisi')" id="tgl-akhir" placeholder="Tanggal Akhir" />
            </div>
        </div>
        <div class="form-group m-t-15">
            <button type="submit" id="cetak-laporan" class="btn btn-primary waves-effect waves-light m-b-10">
                Cetak Laporan
            </button>
        </div>
    </div>
</form>