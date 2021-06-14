<?= $this->extend('template/_template') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="ml-5">
        <h1 class="mt-5">Register Form Pimpinan</h1>
        Silahkan Daftarkan User Pimpinan
        <hr />
        <div class="error"></div>
        <form method="post" id="tambah">
            <?= csrf_field(); ?>
            <input type="hidden" value="lainnya" name="level">
            <div class="mb-3 row">
                <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="inputUsername" name="username" onChange="removeError('username')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-7">
                    <input type="password" class="form-control inputPassword" id="inputPassword" name="password" onChange="removeError('password')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputConfPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-7">
                    <input type="password" class="form-control inputPassword" id="inputConfPassword" name="conf_password" onChange="removeError('conf_password')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputConfPassword" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-7">
                    <input type="checkbox" onclick="Toggle()"><b>Show Password</b>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputConfPassword" class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="inputKeterangan" name="keterangan" onChange="removeError('keterangan')">
                    <div class="invalid-feedback"></div>  
                </div>
            </div>
        </form>
        <div class="col text-center">
            <a class="btn btn-secondary reset" href="#" role="button">Reset</a>
            <a class="btn btn-primary" href="#" role="button" id="validate">Submit</a>
        </div>
        <hr />
        <div class="mb-3 row">
            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="table">
                <thead class="bg-info">
                    <tr>
                        <th>Username</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="error-update"></div>
            <form method="post" id="update">
                <input type="hidden" id="id-update">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email1">Username</label>
                        <input type="email" class="form-control" id="username-update" name="username" aria-describedby="emailHelp" placeholder="Username" onChange="removeError('username')">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="password1">Password</label>
                        <input type="password" class="form-control inputPassword" id="password-update" name="password" placeholder="Password" onChange="removeError('password')">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="password1">Confirm Password</label>
                        <input type="password" class="form-control inputPassword" id="confpassword-update" name="conf_password" placeholder="Confirm Password" onChange="removeError('conf_password')">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="password1"></label>
                        <input type="checkbox" onclick="Toggle()"><b>Show Password</b>
                    </div>
                    <div class="form-group">
                        <label for="password1">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan-update" name="keterangan" placeholder="keterangan" onChange="removeError('keterangan')">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </form>
            <div class="modal-footer border-top-0 d-flex justify-content-center">
                <a class="btn btn-success" href="#" role="button" id="validate-update">Update</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#validate").click(function(e) {
            $(".error").empty();
            Nloading();
            submit();
            e.preventDefault();
        });
        $("#validate-update").click(function(e) {
            $(".error-update").empty();
            Nloading();
            update();
            e.preventDefault();
        });
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/register/pimpinanJson'
            },
            columns: [{
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ]
        });
    });

    function submit() {
        $("#validate").addClass('disabled');
        $.ajax({
            context: this,
            url: "/register/process/pimpinan",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: "POST",
            data: $('#tambah').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    reset();
                    table.ajax.reload(null, false);
                    $('#validate').text('Submit');
                    $("#validate").removeClass('disabled');
                    Nberhasil('Berhasil Menambahkan data');
                } else {
                    $.each(data.ket, function(key, value) {
                        $('#tambah input[name="' + key + '"],#tambah select[name="' + key + '"]').addClass('is-invalid');
                        $('#tambah input[name="' + key + '"],#tambah select[name="' + key + '"]').siblings(":last").text(value);
                    });
                    Nwarning('Input data sesuai dengan yang diminta');
                    $("#validate").removeClass('disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Nerror(errorThrown)
                $("#validate").removeClass('disabled');

            }
        });

    }

    function update() {
        $("#validate-update").addClass('disabled');
        $.ajax({
            context: this,
            url: 'seksi/' + $('#id-update').val() + '/edit',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: "POST",
            data: $('#update').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    table.ajax.reload(null, false);
                    $('#validate-update').text('Update');
                    $("#validate-update").removeClass('disabled');
                    $(".error-update").empty();
                    $('#modalupdate').modal('hide');
                    Nberhasil('Berhasil Merubah data');
                } else {
                    Nwarning('Input data sesuai dengan yang diminta');
                    $.each(data.ket, function(key, value) {
                        $('#update input[name="' + key + '"],#update select[name="' + key + '"]').addClass('is-invalid');
                        $('#update input[name="' + key + '"],#update select[name="' + key + '"]').siblings(":last").text(value);
                    });
                    $("#validate-update").removeClass('disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Nerror(errorThrown)
                $("#validate").removeClass('disabled');

            }
        });

    }

    function edit(id) {
        $.ajax({
            url: 'seksi/' + id + '/edit',
            type: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    akun = data.data
                    $('#update input[name],#update select').removeClass('is-invalid');
                    $('#id-update').val(akun.id);
                    $('#username-update').val(akun.username);
                    $('#password-update').val(akun.password);
                    $('#confpassword-update').val(akun.password);
                    $("#keterangan-update").val(akun.keterangan)
                    $('#modalupdate').modal('show');
                } else {
                    Nwarning('Data tidak ditemukan');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Nerror(errorThrown)

            }
        });
    }

    function hapus(id, username) {

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Ingin menghapus " + username,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus aja!',
            cancelButtonText: 'Tidak jadi!',
        }).then((result) => {
            if (result.isConfirmed) {
                Nloading();
                $.ajax({
                    url: '/register/remove',
                    type: "POST",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        id: id,
                        username: username
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Nberhasil(username + ' berhasil dihapus');
                            table.ajax.reload(null, false);
                        } else {
                            Nwarning('Data tidak ditemukan');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Nerror(errorThrown)

                    }
                });

            }
        })

    }
</script>
<?= $this->endSection() ?>