$(document).ready(function () {
    $(document).on("click", "#signup", function () {
        let nama = $("#nama").val();
        let email = $("#email").val();
        let password = $("#password").val();

        $.ajax({
            type: "post",
            url: "http://localhost/aplikasikas/registrasi/signup",
            data: {
                nama: nama,
                email: email,
                password: password
            },
            dataType: "json",
            success: function (data) {
                if (nama == "") {
                    Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                    )
                } else if (email == "") {
                    Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                    )
                } else if (password == "") {
                    Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                    )
                } else {
                    if (data.responce == "success" ) {
                        Swal.fire({
                            title: data.message,
                            text: 'Silahkan Lakukan Login',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "http://localhost/aplikasikas/login/"
                            }
                        });

                        let nama = $("#nama").val("");
                        let email = $("#email").val("");
                        let password = $("#password").val("");
                        
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                }
                
            }
        });
    });

    $(document).on("click", "#logout", function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Logout?',
            text: 'Apakah Yakin Akan Logout',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
            }).then((result) => {
            if (result.isConfirmed) {
                location.href = "http://localhost/aplikasikas/login/logout"
            }
        });

    });

    $(document).on("click", "#login", function () {
        let password = $("#password").val();
        let email = $("#email").val();

        $.ajax({
            type: "post",
            url: "http://localhost/aplikasikas/login/cek",
            data: {
                email: email,
                password: password
            },
            dataType: "json",
            success: function (data) {
                if (email == "") {
                    Swal.fire(
                        'Error!',
                        data.message,
                        'error'
                    )
                } else if (password == "") {
                    Swal.fire(
                        'Error!',
                        data.message,
                        'error'
                    )
                } else {
                    if (data.responce == "success" ) {
                        Swal.fire({
                            text: data.message,
                            title: 'Selamat!',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "http://localhost/aplikasikas/"
                            }
                        });

                        let email = $("#email").val("");
                        let password = $("#password").val("");
                        
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                }
            }
        });
    });
});