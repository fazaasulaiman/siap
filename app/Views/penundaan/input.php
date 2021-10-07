<style>
    .is-invalid .select2-selection,
    .needs-validation~span>.select2-dropdown {
        border-color: red !important;
    }
</style>
<?= $this->extend('template/_template') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="ml-5">
        <h1 class="mt-5">Form Input Penundaan</h1>
        Silahkan masukan data penundaan
        <hr />
        <div class="error"></div>
        <form method="post" id="tambah" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="mb-3 row">
                <label for="inputSurat" class="col-sm-2 col-form-label">No Surat</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="noSurat" onChange="removeError('noSurat')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputTanggalSurat" class="col-sm-2 col-form-label">Tanggal Surat</label>
                <div class="input-group col-sm-7">
                    <input class="form-control datepicker" name="tglSurat" onChange="removeError('tglSurat')" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputTanggalKejadian" class="col-sm-2 col-form-label">Tanggal Kejadian</label>
                <div class="input-group col-sm-7">
                    <input class="form-control datepicker" name="tglKejadian" onChange="removeError('tglKejadian')" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback"> </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPaspor" class="col-sm-2 col-form-label">No Paspor</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="noPaspor" onChange="removeError('noPaspor')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="nama" onChange="removeError('nama')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputKewarganegaraan" class="col-sm-2 col-form-label">Kewarganegaraan</label>
                <div class="col-sm-7">
                    <select class="form-control state" name="kewarganegaraan" onChange="removeError('kewarganegaraan')">
                        <option value=""></option>
                    </select>
                    <div class="invalid-feedback"> </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputConfPassword" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-7">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Laki-Laki" onChange="removeError('gender')">
                        <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Perempuan" onChange="removeError('gender')">
                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                        <div class="invalid-feedback col-sm-12">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputLahir" class="col-sm-2 col-form-label">Tempat & Tanggal Lahir</label>
                <div class="input-group col-sm-4">
                    <input class="form-control" type="text" name="tempatLahir" onChange="removeError('tempatLahir')" />
                    <div class="invalid-feedback"></div>
                </div>
                <div class="input-group col-sm-3">
                    <input class="form-control datepicker" name="tglLahir" onChange="removeError('tglLahir')" />
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPesawat" class="col-sm-2 col-form-label">Pesawat</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="pesawat" onChange="removeError('pesawat')">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputDokumen" class="col-sm-2 col-form-label">Unggah Dokumen</label>
                <div class="col-sm-7">
                    <div class="custom-file">
                        <input type="file" id="dokumen" class="custom-file-input" name="dokumen" aria-describedby="fileHelp" accept="application/pdf" onChange="removeError('dokumen')">
                        <label class="custom-file-label" for="validatedCustomFile">
                            Upload file...
                        </label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputDokumen" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-7">
                    <span>Upload Laporan Kejadian Penundaan beserta lampirannya jika ada</span>
                </div>
            </div>
        </form>
        <div class="col text-center">
            <a class="btn btn-secondary reset" href="#" role="button">Reset</a>
            <a class="btn btn-primary" href="#" role="button" id="validate">Submit</a>
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

    });

    function submit() {
        $("#validate").addClass('disabled');
        var formData = new FormData($('#tambah').get(0));
        $.ajax({
            context: this,
            url: "/penundaan/process",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    reset();
                    $('.datepicker').datepicker('setDate', null);
                    $(".state").val('').trigger('change');
                    $('#dokumen').val('').trigger('change');
                    $('input[name="gender"]').prop('checked', false);
                    $('#validate').text('Submit');
                    $("#validate").removeClass('disabled');
                    Nberhasil('Berhasil Menambahkan data');
                } else {
                    Nwarning('Input data sesuai dengan yang diminta');
                    $.each(data.text, function(key, value) {
                        $('input[name="' + key + '"],select[name="' + key + '"],radio[name="' + key + '"]').addClass('is-invalid');
                        $('input[name="' + key + '"],select[name="' + key + '"],radio[name="' + key + '"]').siblings(":last").text(value);
                    });
                    $("#validate").removeClass('disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Nerror(errorThrown)
                $("#validate").removeClass('disabled');

            }
        });

    }
</script>
<?= $this->endSection() ?>