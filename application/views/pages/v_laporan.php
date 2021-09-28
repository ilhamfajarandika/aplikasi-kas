<h4 class="fw-400 text-center" style="margin-bottom: 25px;">Pilih Rentang Tanggal Laporan</h4>
<form id="form-cetak" target="_blank" method="post">
    <div class="form-group">
        <h6 class="text-muted fw-400">Tanggal</h6>
        <div>
            <div class="input-daterange input-group" id="date-range">
                <input type="date" class="form-control" name="tgl-mulai" required oninvalid="this.setCustomValidity('Tanggal harus diisi')" id="tgl-mulai" placeholder="Tanggal Mulai" />
                <input type="date" class="form-control" name="tgl-akhir" required oninvalid="this.setCustomValidity('Tanggal harus diisi')" id="tgl-akhir" placeholder="Tanggal Akhir" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <h6 class="text-muted fw-400">Desain Laporan</h6>
        <div class="col-md-9 px-0">
            <div class="form-check-inline" style="width: 65%;">
                <div class="custom-control custom-radio">
                    <input type="radio" id="table-border" value="border" checked name="table-design" class="custom-control-input">
                    <label class="custom-control-label font-weight-normal" for="table-border">Tabel Border</label>
                </div>
            </div>
            <div class="form-check-inline">
                <div class="custom-control custom-radio">
                    <input type="radio" id="table-stripped" value="strip" name="table-design" class="custom-control-input">
                    <label class="custom-control-label font-weight-normal" for="table-stripped">Tabel Strip</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-t-15">
        <button type="button" id="cetak-laporan" class="btn btn-primary waves-effect waves-light m-b-10">
            Cetak Laporan
        </button>
    </div>
</form>