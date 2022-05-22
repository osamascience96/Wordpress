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
            <div class="dropdown d-inline-block mr-2">
                <a class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-download text-primary pr-2"></i> Export</a>
                <ul class="dropdown-menu dropdown-menu-right export-button">
                    <li><a href="#" class="pdf"><i class="far fa-file-pdf pr-2"></i>PDF</a></li>
                    <li><a href="#" class="excel"><i class="far fa-file-excel pr-2"></i>Excel</a></li>
                    <li><a href="#" class="csv"><i class="ti-clipboard pr-2"></i>CSV</a></li>
                    <li><a href="#" class="print"><i class="ti-printer pr-2"></i>Print</a></li>
                    <li><a href="#" class="copy"><i class="ti-layers pr-2"></i>Copy</a></li>
                </ul>
            </div>
            <?php if ($page_add) { ?>
                <a href="<?php echo URL_ADMIN.DIR_ROUTE.'deathrecord/add'; ?>" class="btn btn-primary btn-sm"><i class="ti-plus pr-2"></i> Add Death Record</a>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Tax list page start -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-middle table-bordered table-striped datatable-table">
                <thead>
                    <tr class="table-heading">
                        <th>#</th>
                        <th>Patient</th>
                        <th>Gender</th>
                        <th>DeathDate</th>
                        <th>Guardian</th>
                        <?php if ($page_delete || $page_edit) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr> 
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><a class="text-primary"><?php echo $value['name']; ?></a></td>
                            <td><?php echo $value['gender']; ?></td>
                            <td><?php echo date_format(date_create($value['date']), $common['info']['date_format']).' AT '.$value['time']; ?></td>
                            <td><?php echo $value['guardian_name']; ?></td>
                            <?php if ($page_edit || $page_view || $page_delete) { ?>
                                <td class="table-action">
                                    <?php if ($page_edit || $page_view) { ?>
                                        <div class="dropdown d-inline-block">
                                            <a class="text-primary edit dropdown-toggle" data-toggle="dropdown"><i class="ti-more"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-right export-button">
                                                <?php if ($page_view) { ?>
                                                    <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'deathrecord/view&id='.$value['id'];?>"><i class="ti-layout-media-center-alt pr-2"></i>View</a></li>
                                                <?php } if ($page_edit) { ?>
                                                    <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'deathrecord/edit&id='.$value['id'];?>"><i class="ti-pencil-alt pr-2"></i>Edit</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } if ($page_delete) { ?>
                                        <a class="table-delete text-danger delete" data-toggle="tooltip" title="Delete">
                                            <i class="ti-trash"></i><input type="hidden" value="<?php echo $value['id'];?>">
                                        </a>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>