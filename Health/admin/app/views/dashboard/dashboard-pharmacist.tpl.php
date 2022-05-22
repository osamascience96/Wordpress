<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/chart.min.css">

<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">Pharmacy Revenue & Purchase</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <canvas id="bill-chart" width="1000" height="450"></canvas>
            </div>
            <div class="col-md-4">
                <div class="widget-1 p-0">
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Revenue</h5>
                                <span class="descr">In Last 12 Months</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-primary"><?php echo $common['info']['currency_abbr'].(float)$bill_stats['income_12']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Revenue</h5>
                                <span class="descr">In Last 30 Days</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-primary"><?php echo $common['info']['currency_abbr'].(float)$bill_stats['income_1']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Purchase</h5>
                                <span class="descr">In Last 12 Months</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-danger"><?php echo $common['info']['currency_abbr'].(float)$bill_stats['purchase_12']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="title">Purchase</h5>
                                <span class="descr">In Last 30 Days</span>
                            </div>
                            <div class="col text-right">
                                <div class="number text-danger"><?php echo $common['info']['currency_abbr'].(float)$bill_stats['purchase_1']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">Latest Purchase</div>
        <div class="panel-action">
            <a href="<?php echo URL_ADMIN.DIR_ROUTE.'medicine/purchase' ?>" class="btn btn-primary btn-sm">Purchase List</a>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-middle table-bordered table-striped datatable-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <th>Sub Total</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Amount</th>
                        <th>Purchase Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($purchase)) { foreach ($purchase as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['supplier'];?></td>
                            <td><?php echo $common['info']['currency_abbr'].$value['total']; ?></td>
                            <td><?php echo $common['info']['currency_abbr'].$value['tax']; ?></td>
                            <td><?php echo $common['info']['currency_abbr'].$value['discount_value'];?></td>
                            <td><?php echo $common['info']['currency_abbr'].$value['amount']; ?></td>
                            <td><?php echo date_format(date_create($value['date']), $common['info']['date_format']); ?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
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

<script type="text/javascript" src="public/js/Chart.min.js"></script>
<script>
    //Pharmcy Bill Chart
    var ctx = document.getElementById("bill-chart").getContext("2d");
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $chart_bill['label']; ?>,
            datasets: [{
                label: "Revenue",
                fill: true,
                backgroundColor: '#3483FF',
                borderColor: '#3483FF',
                //steppedLine: true,

                pointHoverRadius: 4,
                pointHoverBorderWidth: 12,
                pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                pointHoverBackgroundColor: "#3483FF",
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),

                data: <?php echo $chart_bill['value']; ?>
            },
            {
                label: "Purchase",
                fill: true,
                backgroundColor: '#fd397a',
                borderColor: '#fd397a',
                //steppedLine: true,
                
                pointHoverRadius: 4,
                pointHoverBorderWidth: 12,
                pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointHoverBackgroundColor: "#fd397a",
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                data: <?php echo $chart_purchase['value']; ?>
            }]
        },
        options: {
            title: {
                display: false,
            },
            legend: {
                display: false
            },
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                xAxes: [{
                    categoryPercentage: 0.45,
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
            elements: {
                line: {
                    tension: 0.2
                },
                point: {
                    radius: 4,
                    borderWidth: 12
                }
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
                backgroundColor: "#333333",
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