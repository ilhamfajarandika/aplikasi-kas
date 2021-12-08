$(document).ready(function () {
	let btn = $("button.btn.btn-primary.d-flex.align-items-center");
	$(btn).on("click", function (el) {
		let target = el.target;

		if (target.classList.contains("mdi")) {
			target.classList.toggle("mdi-eye-off");
			target.classList.toggle("mdi-eye");

			target.classList.contains("mdi-eye-off")
				? $(".input-group-append").prev().attr("type", "text")
				: $(".input-group-append").prev().attr("type", "password");
		} else if (target.classList.contains("btn")) {
			target.firstElementChild.classList.toggle("mdi-eye-off");
			target.firstElementChild.classList.toggle("mdi-eye");

			target.firstElementChild.classList.contains("mdi-eye-off")
				? target.parentElement.previousElementSibling.setAttribute(
						"type",
						"text"
				  )
				: target.parentElement.previousElementSibling.setAttribute(
						"type",
						"password"
				  );
		}
	});
});

$("#tambah-user").on("click", function () {
	let namaUser = $("#namaUser").val();
	let emailUser = $("#emailUser").val();
	let passwordUser = $("#passwordUser").val();
	let gambarUser = "default.jpg";
	let idRole = $("#role").find(":selected").val();

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/user/tambah",
		data: {
			namaUser: namaUser,
			emailUser: emailUser,
			passwordUser: passwordUser,
			gambarUser: gambarUser,
			role: idRole,
		},
		dataType: "json",
		success: function (data) {
			if (data.responce == "success") {
				Swal.fire({
					title: data.message,
					text: "Data user berhasil ditambahkan",
					icon: "success",
					confirmButtonColor: "#3085d6",
					confirmButtonText: "OK",
				}).then((result) => {
					if (result.isConfirmed) {
						$("#nama").val(" ");
						$("#email").val(" ");
						$("#password").val(" ");
						$("#modal_tambah_user").modal("hide");
						$.ajax({
							type: "post",
							url: "http://localhost/aplikasikas/user/ambil",
							dataType: "json",
							success: function (data) {
								$("#container").empty();
								ambilDataUser();
							},
						});
					}
				});
			} else {
				Swal.fire("Error!", data.message, "error");
			}
		},
	});
});

$("#submit-ubah-password").on("click", function (e) {
	e.preventDefault();
	Swal.fire({
		title: "Apakah Yakin?",
		text: "Sandi akan diubah!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Ubah Sandi!",
	}).then((result) => {
		if (result.isConfirmed) {
			let password = $("#password").val();
			let newPassword = $("#password-baru").val();
			let confirmPassword = $("#konfirmasi-password").val();

			$.ajax({
				type: "post",
				url: "http://localhost/aplikasikas/user/ubah",
				data: {
					password: password,
					newPassword: newPassword,
					confirmPassword: confirmPassword,
				},
				dataType: "json",
				success: function (data) {
					if (data.response == "success") {
						Swal.fire({
							title: "Success!",
							text: data.message,
							icon: "success",
							confirmButtonColor: "#3085d6",
							confirmButtonText: "OK",
						}).then((result) => {
							if (result.isConfirmed) {
								$("#password").val("");
								$("#password-baru").val("");
								$("#konfirmasi-password").val("");
							}
						});
					} else {
						Swal.fire({
							title: "Error!",
							text: data.message,
							icon: "error",
						});
					}
				},
			});
		}
	});
});

$(document).on("click", ".hapus-user", function (e) {
	e.preventDefault();
	let id = $(this).data("userid");
	let nama = $(this).data("username");

	Swal.fire({
		title: "Warning!",
		text: "Anda akan menghapus akun " + nama,
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus!",
	}).then((result) => {
		if (result.isConfirmed) {
			console.log("hapus");
			$.ajax({
				type: "post",
				url: "http://localhost/aplikasikas/user/hapususer",
				data: {
					id: id,
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
					Swal.fire({
						title: "Success!",
						text: data.message,
						icon: "success",
						confirmButtonColor: "#3085d6",
						confirmButtonText: "OK",
					});
					$("#container").empty();
					ambilDataUser();
				},
			});
		}
	});
});

$(document).on("click", ".reset-password", function (e) {
	e.preventDefault();
	let id = $(this).data("userid");
	let nama = $(this).data("username");

	Swal.fire({
		title: "Warning!",
		text: "Anda akan mereset password " + nama,
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Reset Password!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: "post",
				url: "http://localhost/aplikasikas/user/resetpassword",
				data: {
					password: "password",
					id: id,
				},
				dataType: "json",
				success: function (data) {
					Swal.fire({
						title: "Success!",
						text: data.message,
						icon: "success",
						confirmButtonColor: "#3085d6",
						confirmButtonText: "OK",
					});
				},
			});
		}
	});
});

function ambilDataUser() {
	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/user/ambil",
		dataType: "json",
		success: function (data) {
			$.each(data.post, function (index, value) {
				let roleUser = value.role.charAt(0).toUpperCase() + value.role.slice(1);
				let tanggalDibuat = value.date_created.split("-").reverse().join("-");
				let [tanggal, jam] = value.last_seen.split(" ");
				let i = Math.round(Math.random() * 20);

				let element = `
				<div class="col-md-4 float-left" id="card-profile">
					<div class="card m-b-30">
						<img class="card-img-top img-fluid" src="https://picsum.photos/1600/1050?nature=?${i}" alt="Card image cap">
						<div class="card-profile">
							<img src="https://picsum.photos/150/150?person${i}" alt="Card image cap">
						</div>
						<div class="card-body" id="profile-user">
							<h4 class="card-title font-20 my-2 mx-2 d-flex justify-content-between align-items-center" id="nama-user">
								<span>
									<span class="nama">
										${value.nama}
									</span>
									<i title="${
										value.is_active == 1 ? "User Aktif" : "User Tidak Aktif"
									}" class="mdi mdi-checkbox-blank-circle is-aktif ml-2 ${
					value.is_active == 1 ? "text-primary" : "text-danger"
				}" style="font-size: 1rem;"></i>
								</span>
								<div class="dropdown notification-list">
									<button class="dropdown-toggle btn btn-primary arrow-none waves-effect text-light" data-toggle="dropdown" type="button" role="button" aria-haspopup="false" aria-expanded="false">
										<i class="mdi mdi-settings btn-reset"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-right profile-dropdown bg-primary">
										<a class="dropdown-item text-light hapus-user" data-userid="${
											value.iduser
										}" data-username="${
					value.nama
				}" href="#"><i class="mdi mdi-delete m-r-5 text-light"></i> <span>Hapus User</span></a>
					                    <div class="dropdown-divider text-light my-1 mx-3"></div>
										<a class="dropdown-item text-light reset-password" data-userid="${
											value.iduser
										}" data-username="${
					value.nama
				}" href="#"><i class="mdi mdi-account-convert m-r-5 text-light"></i> <span>Reset Password</span></a>
									</div>
								</div>
							</h4>
							<ul class="list-group list-group-flush my-2 mx-n2">
				                <li class="list-group-item d-flex justify-content-between align-items-center" style="border-top: none;">
									Email
									<span> ${value.email} </span>
								</li>
				                <li class="list-group-item d-flex justify-content-between align-items-center">
									Role
									<span> ${roleUser} </span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Tanggal Registrasi
									<span> ${tanggalDibuat} </span>
								</li>
				                <li class="list-group-item d-flex justify-content-between align-items-center">
									Terakhir Online
									<span> ${tanggal.split("-").reverse().join("-")} ${jam} </span>
									
								</li> 
							</ul>
						</div>
					</div>
				</div>
				`;

				$("#container").append(element);
			});
		},
	});
}

ambilDataUser();
