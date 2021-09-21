$(document).ready(function () {
    const tanggal = new Date();
    const hariAwal = tanggal.getDate();
    const hariAkhir =  new Date(tanggal.getFullYear(), tanggal.getMonth()+1, 0);
    const bulan = (tanggal.getMonth() < 10) ? '0'+(tanggal.getMonth()+1) : tanggal.getMonth() +1;
    const tahun = tanggal.getFullYear();

    console.log(tanggal);
    console.log(hariAkhir.getDate());
    console.log(bulan);
    
    $("#tgl-mulai").val(`${tahun}-${bulan}-${hariAwal}`);
    $("#tgl-akhir").val(`${tahun}-${bulan}-${hariAkhir.getDate()}`);
    
    let tanggalawal = $("#tgl-mulai").val();
    let tanggalakhir = $("#tgl-akhir").val();
    
});