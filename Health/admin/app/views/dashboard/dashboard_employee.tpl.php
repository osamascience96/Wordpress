<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block">Dashboard</h2>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
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
    </div>
</div>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>