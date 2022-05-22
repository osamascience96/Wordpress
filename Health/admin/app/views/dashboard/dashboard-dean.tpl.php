<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/chart.min.css">
<link rel="stylesheet" type="text/css" href="public/css/fullcalendar.min.css" />
<!-- Appointment Calendar -->
<div class="panel panel-default">
    <div class="panel-body">
        <div id="calendar"></div>
    </div>
</div>
<!-- Appointment Chart -->
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">Appointments</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <canvas id="appointment-chart" width="1000" height="450"></canvas>
            </div>
            <div class="col-md-4">
                <div class="widget-1 p-0">
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Appointments</h5>
                                <span class="descr">In last 12 Months</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-success"><?php echo (float)$appointment_stats['last_12']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Appointments</h5>
                                <span class="descr">In last Months</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-primary"><?php echo (float)$appointment_stats['last_1']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Completed</h5>
                                <span class="descr">In last 12 Months</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-info"><?php echo (float)$appointment_stats['completed_last_12']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Completed</h5>
                                <span class="descr">In last Months</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-warning"><?php echo (float)$appointment_stats['completed_last_1']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <!-- Patient Chart -->
        <div class="panel panel-default">
            <div class="panel-head">
                <div class="panel-title">Patients</div>
            </div>
            <div class="panel-body">
                <canvas id="patient-chart" width="1000" height="500"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Request Chart -->
        <div class="panel panel-default">
            <div class="panel-head">
                <div class="panel-title">Request</div>
            </div>
            <div class="panel-body">
                <canvas id="request-chart" width="1000" height="500"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- Notices Table -->
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">Notices</div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-middle table-bordered table-striped datatable-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notices)) { foreach ($notices as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['title']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <td><?php echo date_format(date_create($value['start_date']), $common['info']['date_format']); ?></td>
                            <td><?php echo date_format(date_create($value['end_date']), $common['info']['date_format']); ?></td>
                            <td>
                                <?php if ($value['status'] == '1') {
                                    echo '<span class="label label-success">Active</span>';
                                } elseif ($value['status'] == '0') {
                                    echo '<span class="label label-danger">Inactive</span>';
                                }?>
                            </td>
                            <td class="table-action">
                                <a class="text-primary edit" href="<?php echo URL_ADMIN.DIR_ROUTE.'noticeboard/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt"></i></a>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include DIR_ADMIN.'app/views/common/appointment_sidebar.tpl.php'; ?>
<script type="text/javascript" src="public/js/appointment.js"></script>
<script type="text/javascript" src="public/js/Chart.min.js"></script>
<script>
    //labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    //value: [20, 30, 20, 40, 30, 60, 30, 24, 32, 38, 30, 22]

    //Appointment count chart according to month
    ctx = document.getElementById("appointment-chart").getContext("2d")
    gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, Chart.helpers.color('#0abb87').alpha(1).rgbString());
    gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $chart_appointment['label']; ?>,
            datasets: [{
                fill: true,
                label: "Appointment",
                backgroundColor: gradient,
                borderColor: '#0abb87',

                pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                pointHoverBackgroundColor: "#0abb87",
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),

                data: <?php echo $chart_appointment['value']; ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: false,
            scales: {
                xAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    },
                    gridLines: {
                        color: "#d9dffa",
                        drawBorder: false,
                        offsetGridLines: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "#d9dffa",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        beginAtZero: true,
                        fontColor: "#afb4d4",
                        fontSize: 13,
                        padding: 10
                    }
                }],
                yAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Value'
                    },
                    gridLines: {
                        color: "#d9dffa",
                        drawBorder: false,
                        offsetGridLines: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "#d9dffa",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        beginAtZero: true,
                        fontColor: "#afb4d4",
                        fontSize: 13,
                        padding: 10
                    }
                }]
            },
            title: {
                display: false
            },
            hover: {
                mode: 'index'
            },
            tooltips: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
                bodySpacing: 5,
                yPadding: 10,
                xPadding: 10, 
                caretPadding: 0,
                displayColors: false,
                backgroundColor: "#067554",
                titleFontColor: '#ffffff', 
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            },
            plugins: {
                labels: []
            }
        }
    });

    //Request count chart
    ctx = document.getElementById("request-chart").getContext("2d")
    gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, Chart.helpers.color('#fec107').alpha(1).rgbString());
    gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $chart_appointment['label']; ?>,
            datasets: [{
                fill: true,
                label: "Request",
                backgroundColor: gradient,
                borderColor: '#fec107',
                steppedLine: true,
                pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                pointHoverBackgroundColor: "#fec107",
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),

                data: <?php echo $chart_appointment['value']; ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: false,
            scales: {
                xAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    },
                    gridLines: {
                        color: "#d9dffa",
                        drawBorder: false,
                        offsetGridLines: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "#d9dffa",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        beginAtZero: true,
                        fontColor: "#afb4d4",
                        fontSize: 13,
                        padding: 10
                    }
                }],
                yAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Value'
                    },
                    gridLines: {
                        color: "#d9dffa",
                        drawBorder: false,
                        offsetGridLines: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "#d9dffa",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        beginAtZero: true,
                        fontColor: "#afb4d4",
                        fontSize: 13,
                        padding: 10
                    }
                }]
            },
            title: {
                display: false
            },
            hover: {
                mode: 'index'
            },
            tooltips: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
                bodySpacing: 5,
                yPadding: 10,
                xPadding: 10, 
                caretPadding: 0,
                displayColors: false,
                backgroundColor: "#af8505",
                titleFontColor: '#ffffff', 
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            },
            plugins: {
                labels: []
            }
        }
    });

    //Patient count chart
    ctx = document.getElementById("patient-chart").getContext("2d")
    gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, Chart.helpers.color('#3483FF').alpha(1).rgbString());
    gradient.addColorStop(1, Chart.helpers.color('#f2feff').alpha(.2).rgbString());
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $chart_patient['label']; ?>,
            datasets : [ {
                label: "Patient",
                fill: false,
                backgroundColor: gradient,
                borderColor: '#3483FF',
                //steppedLine: true,

                pointHoverRadius: 4,
                pointHoverBorderWidth: 12,
                pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointHoverBackgroundColor: "#3483FF",
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                data: <?php echo $chart_patient['value']; ?>
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: false,
            scales: {
                xAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    },
                    gridLines: {
                        color: "#d9dffa",
                        drawBorder: false,
                        offsetGridLines: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "#d9dffa",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        beginAtZero: true,
                        fontColor: "#afb4d4",
                        fontSize: 13,
                        padding: 10
                    }
                }],
                yAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Value'
                    },
                    gridLines: {
                        color: "#d9dffa",
                        drawBorder: false,
                        offsetGridLines: false,
                        drawTicks: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "#d9dffa",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        beginAtZero: true,
                        fontColor: "#afb4d4",
                        fontSize: 13,
                        padding: 10
                    }
                }]
            },
            title: {
                display: false
            },
            hover: {
                mode: 'index'
            },
            tooltips: {
                enabled: true,
                intersect: false,
                mode: 'index',
                bodySpacing: 5,
                yPadding: 10,
                xPadding: 10, 
                caretPadding: 0,
                displayColors: false,
                backgroundColor: "#0d4194",
                titleFontColor: '#ffffff', 
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            },
            plugins: {
                labels: []
            }
        }
    });
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>