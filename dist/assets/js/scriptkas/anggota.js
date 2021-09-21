function ambilNamaAnggota() {
    $.ajax({
        type: "post",
        url: "http://localhost/aplikasikas/anggota/ambilData",
        dataType: "json",
        success: function (data) {
            let select = document.querySelector("#nama");
            let opsiPertama = document.querySelector("option#pilih-anggota");
            const namaAnggota = [];
            const isiAnggota = [];
            
            for (const nama in data.post) {
                if (Object.hasOwnProperty.call(data.post, nama)) {
                    let isi = data.post[nama].idanggota;
                    let element = data.post[nama].nama;
                    namaAnggota.push(element);
                    isiAnggota.push(isi);
                }
            }
                
            for (let j = 0; j < isiAnggota.length; j++) {
                for (let i = 0; i < namaAnggota.length; i++) {
                    const isiNama = isiAnggota[j];
                    opsiNama = document.createElement("option");
                    opsiNama.value = isiNama;
                }

                const nama = namaAnggota[j];
                opsiNama.innerHTML = nama;
                select.appendChild(opsiNama);
            }
        }
    });
}
ambilNamaAnggota();

function ambilDataAnggota() {
    $.ajax({
        type: "post",
        url: "http://localhost/aplikasikas/anggota/ambilData",
        dataType: "json",
        success: function (data) {
            let i = "0", a;
            $("#tabel_anggota").DataTable({
                processing: true,
                data: data.post,
                dom:  "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-5'f>>"+
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        text: 'Download CSV',
                        className: "btn btn-success",
                        action: function ( e, dt, node, config ) {
                            location = 'http://localhost/aplikasikas/file/fExportAnggota';
                        }
                    }
                ],
                language: {
					search: "_INPUT_",
					searchPlaceholder: "Search..."
				},
                columns: [
                    {
                        "render": function () { 
                            return ++i;
                        }
                    },
                    {"data": "nama"},
                    {
                        "data": null,
                        "render": function (data, type, row, meta) { 
                            a = `
                                <a class="btn btn-sm btn-warning text-light" data-id="${row.idanggota}" href="" role="button" id="edit-anggota" data-toggle="modal" data-target="#modal_tambah_anggota" title="Edit Data"><i class="mdi mdi-lead-pencil" ></i></a>
                                <a class="btn btn-sm btn-danger" data-id="${row.idanggota}" href="" role="button" id="hapus-anggota" title="Edit Data"><i class="mdi mdi-delete"></i></a>
                            `;
                            return a; 
                        }
                    },
                ],
                bDestroy: true
            });
        }
    });
}
ambilDataAnggota();

$(document).on("submit", "#form_import_anggota", function (e) {
	e.preventDefault();
	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/file/fImportAnggota",
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
			// console.log(data);
            let inputFile = $("#csv-file-anggota");
            // inputFile.replaceWith(inputFile.val('').clone(true));
			// $("#csv-file-anggota").wrap('<form>').closest('form').get(0).reset();
			$("#modal_tambah_anggota").modal('hide');
			$("#tombol-import-csv").attr("disabled", false);
			Swal.fire(
			    'Sukses!',
			    data.message,
			    'success'
			);
			$('#tabel_anggota').DataTable().destroy();
            ambilDataAnggota();
		}
	});
});

$(document).on("click", "#tambah-anggota", function (e) {
    e.preventDefault();

    let nama = $('#nama-anggota').val();

    $.ajax({
        type: "post",
        url: "http://localhost/aplikasikas/anggota/tambah",
        data: {
            nama: nama,
        },
        dataType: "json",
        success: function (data) {
            if (data.responce == "success") {
                $("#modal_tambah_pemasukan").modal('hide');
                $('#tabel_anggota').DataTable().destroy();
                ambilDataAnggota();
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

$(document).on("click", "#hapus-anggota", function (e) {
    e.preventDefault();

    let id_hapus = $(this).data("id");

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
                url: "http://localhost/aplikasikas/anggota/hapus",
                data: {id_hapus: id_hapus},
                dataType: "json",
                success: function (data) {
                    if (data.responce == "success") {
                        $("#modal_tambah_anggota").modal('hide');
                        $('#tabel_anggota').DataTable().destroy();
                        ambilDataAnggota();
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

$(document).on("click", "#edit-anggota", function () {
    let id_edit = $(this).data("id");

    $("#label_modal_tambah_anggota").html("Edit Data Anggota");
    $("#tambah-anggota").html("Edit Data");
    $("#tambah-anggota").attr("id", "update-anggota");

    $.ajax({
        type: "post",
        url: "http://localhost/aplikasikas/anggota/edit",
        dataType: "json",
        data: {id_edit: id_edit},
        success: function (data) {
            $('#idanggota').val(data.post[0].idanggota);
            $('#nama-anggota').val(data.post[0].nama);
        }
    });
});

$(document).on("click", "#update-anggota", function (e) {
    let idanggota = $("#idanggota").val();
    let nama =  $('#nama-anggota').val();

    $.ajax({
        type: "post",
        url: "http://localhost/aplikasikas/anggota/update",
        data: {
            idanggota: idanggota,
            nama: nama,
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            
            if (data.responce == "success") {
                $("#modal_tambah_anggota").modal('hide');
                $('#tabel_anggota').DataTable().destroy();
                ambilDataAnggota();
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

$(document).ready(function () {
    const label = $("#label_modal_tambah_anggota");

    function bersih() {
        $('#nama-anggota').val("").attr('readonly', false);
    }

    if ( label.innerHTML = "Edit Data Anggota" ) {
        $(document).on("click", ".close", function () {
            bersih();
        });
        $(document).on("click", "#tombol-keluar", function () {
            bersih();
        });
    } 

    $(".insert").on("click", function (e) { 
        $("#tambah-anggota").css("display", "none");
    })
    
    $(".active").on("click", function (e) { 
        $("#tambah-anggota").css("display", "block");
    })
});
