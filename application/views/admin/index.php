<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="shadow-sm p-3 mb-4 bg-white rounded">
        <h1 class="h3 mb-2 mt-2 text-gray-800 "><?= $title; ?></h1>

    </div>
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/chart.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.bundle.min.js"></script>

    <div class="container-fluid">
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
                                <?php $query = $this->db->query("SELECT * FROM `user`"); ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= $query->num_rows(); ?></div>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pegawai</div>
                                <?php $query = $this->db->query("SELECT * FROM `user` WHERE `role_id` =2"); ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $query->num_rows(); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <?php
            $query = $this->db->query('SELECT * FROM `request_task` WHERE `status` NOT LIKE "%denied%" AND `status` NOT LIKE "%Invoiced%"');
            $querys = $this->db->query('SELECT * FROM `request_task` WHERE `status` LIKE "%pending%"');
            $ini = $querys->num_rows();
            $equals = $query->num_rows();

            $hasilpersen = 100 - $equals;

            ?>
            <!-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Coaching Selesai</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width:<?= $hasilpersen ?>%" aria-valuenow="<?= $hasilpersen ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Coaching Selesai</div>
                                <?php $event_hasil = $this->db->query("SELECT * FROM `event` WHERE `status`LIKE '%disetujui%'"); ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $event_hasil->num_rows(); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Coaching Tertunda</div>
                                <?php $event_hasil_2 = $this->db->query("SELECT * FROM `event` WHERE `status`LIKE '%diajukan%'"); ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $event_hasil_2->num_rows(); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <a href="#collapseCardExample3" class="card-header py-3 d-flex flex-row align-items-center justify-content-between" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                        <h6 class="m-0 font-weight-bold" style="color:#1a4645;">Grafik Pengajuan Coaching Clinic</h6>
                        <!-- Card Body -->
                    </a>
                    <div class="collapse show" id="collapseCardExample3">
                        <div class="card-body">
                            <div class="chart-area">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="chartproject" style="display: block; height: 320px; width: 467px;" width="583" height="400" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php
    for ($i = 1; $i <= 12; $i++) {
    ?>
        <?php $query = $this->db->query("SELECT * FROM `event` WHERE YEAR(date_event) = '" . date('Y-m-d') . "' and MONTH(date_event) = '" . $i . "'"); ?>
        <input type="hidden" value="<?= $query->num_rows(); ?>" id="ke<?= $i ?>">
    <?php
    }
    ?>

    <script>
        $(window).on("load", function() {
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#1a4645';

            function number_format(number, decimals, dec_point, thousands_sep) {
                // *     example: number_format(1234.56, 2, ',', ' ');
                // *     return: '1 234,56'
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

            // Area Chart Example
            var chartproject = document.getElementById("chartproject");
            var chartku = new Chart(chartproject, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Projects",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "#1a4645",
                        pointRadius: 3,
                        pointBackgroundColor: "#1a4645",
                        pointBorderColor: "#1a4645",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [$("#ke1").val(), $("#ke2").val(), $("#ke3").val(), $("#ke4").val(), $("#ke5").val(), $("#ke6").val(), $("#ke7").val(), $("#ke8").val(), $("#ke9").val(), $("#ke10").val(), $("#ke11").val(), $("#ke12").val()],

                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                suggestedMin: 0,
                                suggestedMax: 20,
                                stepSize: 2,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    },
                    responsive: true
                }
            });
        });
    </script>



</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->