<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li><?php echo $page_title; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right">
            <div class="btn btn-white btn-sm text-left">
                <i class="ti-filter text-primary pr-2"></i>
                <input type="text" class="table-date-range">
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-middle table-bordered table-striped datatable-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email To</th>
                        <th>Subject</th>
                        <th>Sent By</th>
                        <th>Created Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['email_to']; ?></td>
                            <td><?php echo $value['subject']; ?></td>
                            <td><?php echo $value['user']; ?></td>
                            <td><?php echo date_format(date_create($value['date_of_joining']), $common['info']['date_format'].' H:i:s'); ?></td>
                            <td class="table-action">
                                <a class="text-primary edit" data-message="<?php echo $value['message']; ?>"><i class="ti-layout-media-center-alt" data-toggle="tooltip" title="View"></i></a>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="messageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="log-message" style="padding: 10px; border: 5px solid #ddd;"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.table-action').on('click', '.edit', function () {
            var ele = $(this), message = ele.data('message');
            $('#messageModal .log-message').append('<div class="message">'+message+'</div>');
            $('#messageModal').modal('show');
        })

        $('#messageModal').on('hidden.bs.modal', function (e) {
            $('#messageModal .log-message .message').remove();
        })

        $('.table-date-range').daterangepicker({
            autoApply: false,
            alwaysShowCalendars: true,
            locale: {
                format: $('.common_daterange_format').val(),
                separator: " => ",
            },
            startDate: "<?php echo date_format(date_create($period['start']), $common['info']['date_format']); ?>",
            endDate: "<?php echo date_format(date_create($period['end']), $common['info']['date_format']); ?>",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(7, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'All Time': [moment('2015-01-01'), moment().add(30, 'days')]
            },
        });

        $('.table-date-range').on('apply.daterangepicker', function(ev, picker) {
            window.location.replace('<?php echo URL_ADMIN.DIR_ROUTE; ?>emaillogs'+'&start='+picker.startDate.format('YYYY-MM-DD')+'&end='+picker.endDate.format('YYYY-MM-DD'));
        });
    });
</script>

<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>