<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/chart.min.css">
<script type="text/javascript" src="public/js/Chart.min.js"></script>
<script type="text/javascript" src="public/js/fullcalendar.min.js"></script>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block">Dashboard</h2>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary btn-sm appointment-sidebar"><i class="ti-plus pr-2"></i> New Appointment</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="calendar"></div>
                <!-- <input type="hidden" id="calendar-appointment" value="1"> -->
                <input type="hidden" value="<?php echo htmlspecialchars($all_appointment, ENT_QUOTES, 'UTF-8'); ?>" id="appointment-data">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="myChart" width="1000" height="800"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="myChart2" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <canvas id="myChart3" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="sidebar sidebar-right appointmet-sidebar">
    <div class="sidebar-hdr">
        <div class="sidebar-close"><i class="ti-close"></i></div>
        <h3 class="title">Appointment</h3>
    </div>
    <form class="sidebar-bdy" action="<?php echo $action; ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo $token; ?>">
        <div id="apnt-info">
            <input type="hidden" class="apnt-id" name="appointment[id]">
            <div class="form-group mb-2">
                <label>Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-timer"></i></span>
                    </div>
                    <input type="text" name="appointment[name]" class="form-control apnt-name" placeholder="Enter Name . . ." required>
                    <input type="hidden" name="appointment[patient_id]" class="form-control patient-id">
                </div>
            </div>
            <div class="form-group mb-2">
                <label>Email Address</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-timer"></i></span>
                    </div>
                    <input type="text" name="appointment[mail]" class="form-control apnt-email" placeholder="Enter Email Address . . ." required>
                </div>
            </div>
            <div class="form-group mb-2">
                <label>Mobile Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-timer"></i></span>
                    </div>
                    <input type="text" name="appointment[mobile]" class="form-control apnt-mobile" placeholder="Enter Mobile Number . . ." required>
                </div>
            </div>
            <div class="form-group mb-2">
                <label>Doctor</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-timer"></i></span>
                    </div>
                    <select name="appointment[doctor]" class="custom-select apnt-doctor" data-live-search="true" required>
                        <option value="">Select Doctor</option>
                        <?php foreach ($doctors as $value) { ?>
                            <option value="<?php echo $value['id']; ?>" data-department="<?php echo $value['department_id']; ?>" data-weekly="<?php echo htmlspecialchars($value['weekly'], ENT_QUOTES, 'UTF-8'); ?>" data-national="<?php echo htmlspecialchars($value['national'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $value['name'].' (' . $value['department'] . ')'; ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" class="apnt-department" name="appointment[department]" value="">
                </div>
            </div>
            <div class="form-group mb-2">
                <label>Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-timer"></i></span>
                    </div>
                    <input type="text" name="appointment[date]" class="form-control apnt-date" value="" placeholder="Select Date . . ." required autocomplete="off">
                </div>
            </div>
            <div class="form-group mb-2">
                <label>Time</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-timer"></i></span>
                    </div>
                    <input type="text" name="appointment[time]" class="form-control apnt-time" value="" required readonly>
                    <input type="hidden" name="appointment[slot]" class="apnt-slot-time" value="" required>
                </div>
                <div class="apnt-slot"></div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-check-box"></i></span>
                    </div>
                    <select name="appointment[status]" class="custom-select apnt-status" required>
                        <option value="2">In Process</option>
                        <option value="3">Confirmed</option>
                        <option value="4">Completed</option>
                        <option value="1">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="sidebar-ftr text-right">
            <a href="#" class="btn btn-default">View</a>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<div class="modal fade" id="appointmentChooseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Time slot has been booked already. Please select another slot.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="public/js/appointment.js"></script>
<script type="text/javascript" src="public/js/Chart.min.js"></script>
<script>

    window.chartColors = {
        primary: 'rgb(52, 131, 255)',
        success: 'rgb(11, 195, 110)',
        warning: 'rgb(254, 193, 7)',
        danger: 'rgb(251, 150, 120)',
        secondary: 'rgb(205, 15, 216)',
        dark: 'rgb(85, 85, 85)',
        grey: 'rgb(201, 203, 207)' 
    };
    var color = Chart.helpers.color;

    var config = {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: color(window.chartColors.primary).alpha(0.8).rgbString(),
                borderColor: window.chartColors.primary,
                borderWidth: 1,
                data: [ -28, 61, -49, 71, -89, 38, 76 ]
            }, {
                label: 'Dataset 2',
                backgroundColor: color(window.chartColors.danger).alpha(0.8).rgbString(),
                borderColor: window.chartColors.danger,
                borderWidth: 1,
                data: [ 21, 84, 69, 81, -25, -65, -27 ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };

    var ctx = document.getElementById('myChart').getContext('2d');
    window.myLine = new Chart(ctx, config);

    var config1 = {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [ {
                label: 'Primary',
                backgroundColor: color(window.chartColors.primary).alpha(0.5).rgbString(),
                borderWidth: 1,
                data: [ 0, 5, 65, 7, 150, 40, 10 ],
            }, {
                label: 'Success',
                backgroundColor: color(window.chartColors.success).alpha(0.5).rgbString(),
                borderWidth: 1,
                data: [ 0, 50 , 20, 100 , 30, 25, 10 ],
            }, {
                label: 'Secondary',
                backgroundColor: color(window.chartColors.dark).alpha(0.5).rgbString(),
                borderWidth: 1,
                data: [ 0, 15, 50, 12, 30, 25, 10],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    };

    var ctx = document.getElementById("myChart2").getContext("2d");
    window.myLine = new Chart(ctx, config1);

</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>