<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- <section id="chartjs-line-charts">
        <div class="row">
            <div class="col-xs-12">
                <div class="card" style="padding-bottom: 50px">
                    <div class="card-header">
                        <h4 class="card-title">Project Statistics</h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                                <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block chartjs">
                            <canvas id="line-chart" height="500"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    for ($i = 1; $i <= 12; $i++) {
    ?>
        <input type="hidden" value="<?php echo mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `antrian` WHERE YEAR(tgl_masuk) = '" . date('Y-m-d') . "' and MONTH(tgl_masuk) = '" . $i . "'")) ?>" id="ke<?php echo $i ?>">
    <?php
    }
    ?>
    <script src="../assets/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
    <script>
        // ------------------------------
        $(window).on("load", function() {

            //Get the context of the Chart canvas element we want to select
            var ctx = $("#line-chart");

            // Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },

                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: "#f3f3f3",
                            drawTicks: false,
                        },

                    }]
                },
                title: {
                    display: true,
                    text: 'Pengunjung Dental Bakri Pertahun'
                }
            };

            // Chart Data
            var chartData = {
                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: [{
                    label: "Pengunjung Dental Bakri",
                    data: [$("#ke1").val(), $("#ke2").val(), $("#ke3").val(), $("#ke4").val(), $("#ke5").val(), $("#ke6").val(), $("#ke7").val(), $("#ke8").val(), $("#ke9").val(), $("#ke10").val(), $("#ke11").val(), $("#ke12").val()],
                    fill: false,

                    borderColor: "#673AB7",
                    pointBorderColor: "#673AB7",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }]
            };

            var config = {
                type: 'line',

                // Chart Options
                options: chartOptions,

                data: chartData
            };

            // Create the chart
            var lineChart = new Chart(ctx, config);
        });
    </script> -->



</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->