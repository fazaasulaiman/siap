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
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="dashboard_graph">
                    <div class="row x_title">
                        <div class="col-md-2">
                            <h3>Grafik Aktivtas<small></small></h3>
                        </div>
                        <div class="col-md-10">
                            <form id="grafik">
                                <div class="row">
                                <div class="col">
                                        <select name="arsip" class="form-control">
                                            <option value="">Jenis Arsip</option>
                                            <option value="penolakan">Penolakan</option>
                                            <option value="waskat">Waskat</option>
                                            <option value="penundaan">Penundaan</option>
                                            <!-- <option value="all">Semua</option> -->
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="jenis" class="form-control">
                                            <option value="">Jenis Data</option>
                                            <option value="tglSurat">Jumlah Penolakan</option>
                                            <option value="kewarganegaraan">Kewarganegaraan</option>
                                            <option value="gender">Jenis Kelamin</option>
                                            <option value="keterangan">Seksi Pemeriksaan</option>
                                        </select>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" class="form-control datepicker" name="mulai" placeholder="Tgl Mulai" onChange="removeError('mulai')">
                                        <div class="input-group-append">
                                            <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" class="form-control datepicker" name="selesai" placeholder="Tgl Selesai" onChange="removeError('selesai')">
                                        <div class="input-group-append">
                                            <span class="input-group-text"> <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col"><a class="btn btn-success" href="#" role="button" id="process">Cari</a></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mx-auto" id="canvas"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $(function() {
        $.ajax({
            context: this,
            url: "stat",
            tyoe: "get",
            dataType: "JSON",
            success: function(data) {
                data = data.data;
                $('#Tpenolakan').text(data.penolakan);
                $('#Twaskat').text(data.waskat);
                $('#Tpenundaan').text(data.penundaan);

            }

        })
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
                    Nwarning(data.ket);
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
        if (data.type == 'pie') {
            var pie = new Chart(myChart, {
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
                    aspectRatio:2,
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
        if (data.type == 'line') {

            var line = new Chart(myChart, {
                type: 'bar',
                data: {
                    labels: datasets.label,
                    datasets: [{
                        label: data.title,
                        data: datasets.value,
                        fill: true,
                        fill: false,
                        backgroundColor: 'green',
                        borderColor: 'green'

                    }]
                },
                beginAtZero: true,
                options: {
                    spanGaps: true,
                    tension: 0.4,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Chart.js bar Chart'
                    },
                    animation: {
                        animateScale: true
                    },
                    scales: {

                        y: {
                            suggestedMax: Math.max.apply(this, datasets.value) + 2,
                            ticks: {

                                stepSize: 1
                            }
                        }
                    }
                    // scales: {
                    //     yAxes: [{
                    //         ticks: {
                    //             min: 0,
                    //             stepSize: 1
                    //         }
                    //     }],
                    //     xAxes: [{
                    //         time: {
                    //             unit: 'day',
                    //             displayFormats: {
                    //                 day: 'MMM DD'
                    //             }
                    //         }
                    //     }]
                    // }
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>