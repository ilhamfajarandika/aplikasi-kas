$(document).ready(function () {
	const label = $("#label_modal_tambah_transaksi");

	function bersih() {
		$('#nama').val("Pilih Nama Anggota").attr({
			'readonly': false,
			'disabled': false
		});
		$('#tanggal').val("").attr('readonly', false);
		$('#nominal').val("").attr('readonly', false);
		$('#rincian').val("").attr('readonly', false);
		$('#jenis').val("Pilih Jenis").attr({
			'readonly': false,
			'disabled': false
		});
	}

	// $("#tabel_transaksi_filter :input").attr("placeholder", "Search..");
	// var tombol = $("#tabel_transaksi_filter :input").html();
	// console.log(tombol);

	if (label.innerHTML = "Detail Data Transaksi") {
		$(document).on("click", ".keluar", function () {
			bersih();
		});
		$(document).on("click", ".keluar", function () {
			bersih();
		});
	}

	$('button[data-target="#modal_tambah_transaksi"]').on("click", function () {
		$(".notransaksi").css("display", "none");
		$('label[for="notransaksi"]').css("display", "none");
		$("#notransaksi").css("display", "none");
		$("ul.nav.nav-tabs").css("display", "flex");
	});

	$(".dz-default.dz-message > span").html("Pilih file untuk di import (.csv)");

    $(".custom-file-input").on("change", function() {
        let fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(".insert").on("click", function (e) { 
        $("#tambah-transaksi").css("display", "none");
    })
    
    $(".active").on("click", function (e) { 
        $("#tambah-transaksi").css("display", "block");
    })
});

$(document).on("submit", "#form_import_transaksi", function (e) {
	e.preventDefault();
	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/file/fImportTransaksi",
		data: new FormData(this),
        dataType: "json",
		contentType: false, 
        cache: false, 
        processData: false, 
		beforeSend: function () {
			let timerInterval
			Swal.fire({
                width: '100px',
				timer: 2000,
				timerProgressBar: true,
				didOpen: () => {
					Swal.showLoading()
				},
				willClose: () => {
					clearInterval(timerInterval)
				}
			})
		},
		success: function (data) {
			console.log(data);
            document.querySelector("#csv-file-transaksi").value = null;
			$("#modal_tambah_transaksi").modal('hide');
			$("#tombol-import-csv").attr("disabled", false);
			Swal.fire(
			    'Sukses!',
			    data.message,
			    'success'
			);
			$('#tabel_transaksi').DataTable().destroy();
			ambilDataPemasukan();
		}
	});
});

$(document).on("click", "#tambah-transaksi", function (e) {
	e.preventDefault();

	let angkaRandom = Math.floor(Math.random() * 900000) + 100000;

	let idanggota = $('#nama').find(":selected").val();
	let tanggal = $('#tanggal').val();
	let nominal = $('#nominal').val();
	let rincian = $('#rincian').val();
	let jenis = $('#jenis').find(":selected").val();

	let tanggalBersih = tanggal.replaceAll('-', '');
	console.log(tanggal);
	console.log(tanggalBersih);

	let noTransaksi = "IM-" + angkaRandom + "-" + tanggalBersih;
	$('#notransaksi').val(noTransaksi);

	let notransaksi = $('#notransaksi').val();

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/transaksi/tambah",
		data: {
			idanggota: idanggota,
			notransaksi: notransaksi,
			tanggal: tanggal,
			nominal: nominal,
			rincian: rincian,
			jenis: jenis,
		},
		dataType: "json",
		success: function (data) {
			if (data.responce == "success") {
				$("#modal_tambah_transaksi").modal('hide');
				$('#tabel_transaksi').DataTable().destroy();
				ambilDataPemasukan();
				Swal.fire(
					'Success!',
					data.message,
					'success'
				);
			} else {
				Swal.fire(
					'Failed!',
					data.message,
					'error'
				)
			}
		}
	});
});

$(document).on("click", "#detail-transaksi", function (e) {
	e.preventDefault();

	let id = $(this).data('id');

	$(".notransaksi").css("display", "block");
	$('label[for="notransaksi"]').css("display", "block");
	$("#notransaksi").css("display", "block");
	$("#tambah-transaksi").remove();
	$("#label_modal_tambah_transaksi").html("Detail Data Transaksi");
	$(".close").addClass("keluar");
	$("#tombol-keluar").addClass("keluar");
	$("ul.nav.nav-tabs").css("display", "none");

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/transaksi/ambilDataById",
		dataType: "json",
		data: {
			id: id
		},
		success: function (data) {
			let element = data[0];

			$('#nama').val(element.idanggota).attr({
				'readonly': true,
				'disabled': true
			});
			$('#notransaksi').val(element.notransaksi).attr('readonly', true);
			$('#tanggal').val(element.tanggal).attr('readonly', true);
			$('#nominal').val(element.nominal).attr('readonly', true);
			$('#rincian').val(element.rincian).attr('readonly', true);
			$('#jenis').val(element.jenis).attr({
				'readonly': true,
				'disabled': true
			});
		}
	});
});

$(document).on("click", "#edit-transaksi", function (e) {
	e.preventDefault();
	let id = $(this).data('id');

	$("#tambah-transaksi").html("Edit Data");
	$("#tambah-transaksi").attr("id", "update-transaksi");
	$("#label_modal_tambah_transaksi").html("Edit Data Transaksi");
	$(".close").addClass("keluar");
	$("#tombol-keluar").addClass("keluar");

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/transaksi/edit",
		dataType: "json",
		data: {
			id: id
		},
		success: function (data) {
			$('#notransaksi').val(data.post[0].notransaksi).attr({
				'readonly': true,
				'disabled': true
			});
			$('#nama').val(data.post[0].idanggota);
			$('#idtransaksi').val(data.post[0].idtransaksi)
			$('#tanggal').val(data.post[0].tanggal);
			$('#nominal').val(data.post[0].nominal);
			$('#rincian').val(data.post[0].rincian);
			$('#jenis').val(data.post[0].jenis);
		}
	});
});

$(document).on("click", "#update-transaksi", function () {
	let idanggota = $('#nama').find(":selected").val();
	let idtransaksi = $('#idtransaksi').val();
	let tanggal = $('#tanggal').val();
	let nominal = $('#nominal').val();
	let rincian = $('#rincian').val();
	let jenis = $('#jenis').find(":selected").val();

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/transaksi/update",
		data: {
			idtransaksi: idtransaksi,
			idanggota: idanggota,
			tanggal: tanggal,
			nominal: nominal,
			rincian: rincian,
			jenis: jenis
		},
		dataType: "json",
		success: function (data) {
			if (data.responce == "success") {
				$("#modal_tambah_transaksi").modal('hide');
				$('#tabel_transaksi').DataTable().destroy();
				ambilDataPemasukan();
				Swal.fire(
					'Success!',
					data.message,
					'success'
				)
			} else {
				Swal.fire(
					'Failed!',
					data.message,
					'error'
				)
			}
		}
	});
});

$(document).on("click", "#hapus-transaksi", function (e) {
	e.preventDefault();

	let id_hapus = $(this).data("id");
	console.log(id_hapus);

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	});

	Swal.fire({
		title: 'Apakah Yakin?',
		text: "Data Ini Akan Dihapus!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Hapus Data!'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: "post",
				url: "http://localhost/aplikasikas/transaksi/hapus",
				data: {
					id_hapus: id_hapus
				},
				dataType: "json",
				success: function (data) {
					if (data.responce == "success") {
						$('#tabel_transaksi').DataTable().destroy();
						ambilDataPemasukan();
						swalWithBootstrapButtons.fire(
							'Success!',
							data.message,
							'success'
						);
					} else {
						swalWithBootstrapButtons.fire(
							'Failed!',
							data.message,
							'error'
						);
					}
				}
			});
		}
	});

});

function ambilDataPemasukan() {
	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/transaksi/ambilData",
		dataType: "json",
		success: function (data) {
			let i = "0",
				a;
			let nominal = 0;
			for (let j = 0; j < data.post.length; j++) {
				let element = parseInt(data.post[j].nominal);
				nominal += element;
			}

			$("#tabel_transaksi").DataTable({
				processing: true,
				data: data.post,
				dom:  "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-4 tombol-download'B><'col-sm-12 col-md-5 tab-search'f>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        text: 'Download CSV',
                        className: "btn btn-success",
                        action: function ( e, dt, node, config ) {
                            location = 'http://localhost/aplikasikas/file/fExportTransaksi';
                        }
                    }
                ],
				language: {
					search: "_INPUT_",
					searchPlaceholder: "Search..."
				},
				columns: [{
						"render": function () {
							return ++i;
						}
					},
					{
						"data": null,
						"render": function (data, type, row, meta) {
							a = `
                            <a class="btn btn-sm btn-primary" href="#" data-id="${row.id}" data-toggle="modal" data-target="#modal_tambah_transaksi" id="detail-transaksi" title="Detail Data"><i class="mdi mdi-information-outline"></i></a>
                            <a class="btn btn-sm btn-warning text-light" data-id="${row.id}" text-light" href="" role="button" id="edit-transaksi" data-toggle="modal" data-target="#modal_tambah_transaksi" title="Edit Data"><i class="mdi mdi-lead-pencil"></i></a>
                            <a class="btn btn-sm btn-danger" data-id="${row.id}" href="" role="button" id="hapus-transaksi" title="Hapus Data"><i class="mdi mdi-delete"></i></a>
                            <a class="btn btn-sm btn-success text-light" value="${row.id}" name="kwitansi" href="http://localhost/aplikasikas/transaksi/cetak/${row.id}" target="_blank" role="button" id="cetak-transaksi" title="Cetak Kwitansi"><i class="mdi mdi-printer"></i></a>
                            `;
							return a;
						}
					},
					{
						"data": "notransaksi"
					},
					{
						"data": "nama"
					},
					{
						"data": "jenis"
					},
					{
						"data": "nominal",
						"render": function (data, type, row) {
							return 'Rp ' + new Intl.NumberFormat(['ban', 'id']).format(data);
						}
					},
				],
			});
		}
	});
}
ambilDataPemasukan();
