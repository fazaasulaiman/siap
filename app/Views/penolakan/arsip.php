<?= $this->extend('template/_template') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="ml-5">
        <h1 class="mt-5">Arsip Penolakan Pendaratan Digital </h1>
        Form Pencarian Arsip
        <hr />
        <form method="post" id="cari">
            <?= csrf_field(); ?>
            <div class="mb-3 row">
                <label for="inputTanggalSurat" class="col-sm-2 col-form-label">Tanggal Surat</label>
                <div class="input-group col-sm-7">
                    <input class="form-control datepicker" name="tglSurat" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputTanggalKejadian" class="col-sm-2 col-form-label">Tanggal Kejadian</label>
                <div class="input-group col-sm-7">
                    <input class="form-control datepicker" name="tglKejadian" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputKewarganegaraan" class="col-sm-2 col-form-label">Kewarganegaraan</label>
                <div class="col-sm-7">
                    <select class="form-control state" name="kewarganegaraan">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputConfPassword" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-7">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Laki-Laki">
                        <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Perempuan">
                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>

                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="input-group col-sm-7">
                    <input class="form-control datepicker" name="tglLahir" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPaspor" class="col-sm-2 col-form-label">No Paspor</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="noPaspor" onChange="removeError('noPaspor')">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPenolakan" class="col-sm-2 col-form-label">Jenis Penolakan</label>
                <div class="col-sm-7">
                    <select id="penolakan" name="penolakan" class="form-control">
                        <option value="">Pilih Jenis Penolakan</option>
                        <option value="Denda">Denda</option>
                        <option value="Non Denda">Non Denda</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="col text-center">
            <a class="btn btn-secondary reset" href="#" role="button">Reset</a>
            <a class="btn btn-primary" href="#" role="button" id="filter">Submit</a>
        </div>
        <hr />
        <div class="mb-3 row">
            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" id="table">
                <thead class="bg-info">
                    <tr>
                        <th>Seksi</th>
                        <th>Tanggal <br> Kejadian</th>
                        <th>Tanggal <br> Surat</th>
                        <th>Nama</th>
                        <th>National</th>
                        <th>Gender</th>
                        <th>Paspor</th>
                        <th>Penolakan</th>
                        <th>Berkas</th>
                        <th>Bapen <br> TAK</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var obj = [{
            data: 'seksi',
            name: 'seksi'
        }, {
            data: 'tglKejadian',
            name: 'tglKejadian'
        },
        {
            data: 'tglSurat',
            name: 'tglSurat'
        },
        {
            data: 'nama',
            name: 'nama'
        },
        {
            data: 'kewarganegaraan',
            name: 'kewarganegaraan'
        },
        {
            data: 'gender',
            name: 'gender'
        },
        {
            data: 'noPaspor',
            name: 'noPaspor'
        },
        {
            data: 'penolakan',
            name: 'penolakan'
        },
        {
            data: 'dokumen',
            name: 'dokumen'
        },
        {
            data: 'bapen',
            name: 'bapen'
        }
    ]
    $(function() {
        <?php if ($_SESSION['level'] != 'lainnya') { ?>
            $('.table').find('tr').each(function(n) {

                $(this).find('th').eq(9).after('<th>aksi</th>');
            });
            obj.push({
            data: 'aksi',
            name: 'aksi'
            })
        <?php } ?>
        var customFilter = false;
        $('#filter').click(function() {
            customFilter = true;
            table.ajax.reload(null, false);
        });
        $(".state").select2({
            placeholder: "Pilih / ketikan negara",
            allowClear: true,
            width: '100%',
            theme: 'bootstrap4',
            ajax: {
                url: '/api/negara',
                dataType: 'json',
                type: "GET",
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data, page) {
                    return {
                        results: data
                    };
                },
            },
            cache: true
        });
        $("#validate").click(function(e) {

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
            scrollY: '50vh',
            scrollX: true,
            searching: false,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            ajax: {
                url: '/penolakan/arsipJson',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                type: "POST",
                "data": function(data) {
                    data.cari = $('#cari').serialize();
                    data.customFilter = customFilter;
                }
            },
            columns: obj,
        });
    });

    function hapus(id, name) {

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Ingin menghapus penolakan " + name,
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
                    url: '/penolakan/remove',
                    type: "POST",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        id: id,
                        name: name
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Nberhasil('Penolakan ' + name + ' berhasil dihapus');
                            table.ajax.reload(null, false);
                        } else {
                            val = '';
                            $.each(data.text, function(key, value) {
                                val += value + '\n';
                            });
                            console.log(val);
                            Nwarning(val);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Nerror(errorThrown)

                    }
                });

            }
        })

    }

    function upload(id, nama) {
        (async () => {

            const {
                value: file
            } = await Swal.fire({
                title: 'Pilih Dokumen Bapen \n' + nama,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Upload',
                input: 'file',
                inputAttributes: {
                    'accept': 'application/pdf',
                    'aria-label': 'Unggah Dokumen Bapen ' + nama,
                    'id': 'bapen',
                    'name': 'bapen'
                }
            })

            if (file) {
                Nloading();
                var formData = new FormData();
                formData.append("bapen", file);
                formData.append("id", id);
                formData.append("nama", nama);
                $.ajax({
                    context: this,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    type: "POST",
                    url: '/penolakan/bapen',
                    data: formData,
                    contentType: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Nberhasil('Bapen Penolakan ' + name + ' berhasil di unggah');
                            table.ajax.reload(null, false);
                        } else {
                            val = '';
                            $.each(data.text, function(key, text) {
                                val += text + ' \n';
                            });
                            console.log(val);
                            Nwarning(val);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Nerror(errorThrown)

                    }
                })
            }

        })()
    }
</script>
<?= $this->endSection() ?>