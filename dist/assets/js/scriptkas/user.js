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
					console.log(data);
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
							<h4 class="card-title font-20 mt-0 mb-10" id="nama-user">
								${value.nama}
								<i title="${
									value.is_active == 1 ? "User Aktif" : "User Tidak Aktif"
								}" class="mdi mdi-checkbox-blank-circle is-aktif ml-2 ${
					value.is_active == 1 ? "text-primary" : "text-danger"
				}" style="font-size: 1rem;"></i>
							</h4>
							<ul class="list-group list-group-flush m-b-10">
								<li class="list-group-item card-text" title="Email" id="email-user">
									${value.email}
								</li>
								<li class="list-group-item card-text" title="Role">
									${roleUser}
								</li>
								<li class="list-group-item card-text" title="Tanggal Registrasi">
									${tanggalDibuat}
								</li>
								<li class="list-group-item card-text" title="Terakhir Online">
									${tanggal.split("-").reverse().join("-")}
									${jam}
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
