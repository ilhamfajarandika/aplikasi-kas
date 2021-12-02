$(document).ready(function () {
	const tanggal = new Date();
	const hariAwal =
		tanggal.getDate() < 10 ? "0" + tanggal.getDate() : tanggal.getDate();
	const hariAkhir = new Date(tanggal.getFullYear(), tanggal.getMonth() + 1, 0);
	const bulan =
		tanggal.getMonth() < 9
			? "0" + (tanggal.getMonth() + 1)
			: tanggal.getMonth() + 1;
	const tahun = tanggal.getFullYear();

	$("#tgl-mulai").val(`${tahun}-${bulan}-${hariAwal}`);
	$("#tgl-akhir").val(`${tahun}-${bulan}-${hariAkhir.getDate()}`);

	let tanggalawal = $("#tgl-mulai").val();
	let tanggalakhir = $("#tgl-akhir").val();
});

$(document).on("click", "#cetak-laporan", function () {
	let modeltable = $("input[name='table-design']:checked").val();
	let tanggalawal = $("#tgl-mulai").val();
	let tanggalakhir = $("#tgl-akhir").val();

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/laporan/cetak",
		data: {
			modeltable: modeltable,
			tanggalakhir: tanggalakhir,
			tanggalawal: tanggalawal,
		},
		dataType: "json",
		success: function (data) {
			if (data.tabel == "border") {
				window.open(
					"http://localhost/aplikasikas/laporan/cetak" + data.tabel,
					"_blank"
				);
			} else {
				window.open(
					"http://localhost/aplikasikas/laporan/cetak" + data.tabel,
					"_blank"
				);
			}
		},
	});
});
