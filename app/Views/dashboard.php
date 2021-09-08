<?= $this->extend('template/_template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="ml-5 mt-5">
        <form>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="First name">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Last name">
                </div>
            </div>
        </form>
        <form id="grafik">
            <div class="row">
                <div class="col">
                    <select name="jenis" class="form-control">
                        <option value="">Pilih Jenis Data</option>
                        <option value="penolakan">Jumlah Penolakan</option>
                        <option value="kewarganegaraan">Kewarganegaraan</option>
                        <option value="gender">Jenis Kelamin</option>
                        <option value="seksi">Seksi Pemeriksaan</option>
                    </select>
                </div>
                <div class="col input-group">
                    <input type="text" class="form-control datepicker" name="mulai" placeholder="Tanggal Mulai" onChange="removeError('mulai')">
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col input-group">
                    <input type="text" class="form-control datepicker" name="selesai" placeholder="Tanggal Selesai" onChange="removeError('selesai')">
                    <div class="input-group-append">
                        <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col"><a class="btn btn-success" href="#" role="button" id="process">Cari</a></div>
            </div>
        </form>
        <div class="row">
        <div class="mx-auto h-75" id="canvas"></div>
  
        </div>


    </div>

</div>
<script>
    $(function() {
        $("#process").click(function(e) {

            Nloading();
            submit();
            e.preventDefault();
        });
    });

    function submit() {
        //$("#process").addClass('disabled');
        $.ajax({
            context: this,
            url: "grafik",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: "get",
            data: $('#grafik').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#process').text('Submit');
                    $("#process").removeClass('disabled');
                    Nberhasil('Menampilkan grafik');
                    chart(data);
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

    function chart(data) {
        $("#myChart").remove();
        $('#canvas').append('<canvas id="myChart"></canvas>');
       
        datasets = data.data;
        let myChart = document.getElementById('myChart').getContext('2d');
        var WeatherChart = new Chart(myChart, {
            type: data.type,
            data: {
                labels: datasets.label,
                datasets: [{
                    label: '# of Votes',
                    data: datasets.value,
                    backgroundColor: datasets.color,
                    borderColor: datasets.color,
                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: data.title
                    },
                }
            },
        });
    }
</script>
<?= $this->endSection() ?>