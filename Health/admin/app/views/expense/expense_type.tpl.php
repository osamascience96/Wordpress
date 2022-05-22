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
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addExpenseModel"><i class="ti-plus pr-2"></i> New Expense Type</a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Expense Type page start -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-container">
            <table class="table table-middle table-bordered table-striped datatable-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <?php if ($page_delete || $page_edit) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr> 
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['name']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <td>
                                <?php if ($value['status'] == 1) { ?>
                                    <span class="label label-success">Active</span>
                                <?php } else { ?>
                                    <span class="label label-danger">InActive</span>
                                <?php } ?>
                            </td>
                            <?php if ($page_delete || $page_edit) { ?>
                                <td class="table-action">
                                    <?php if ($page_edit) { ?>
                                        <a class="edit-expense-type edit" data-name="<?php echo $value['name'] ?>" data-description="<?php echo $value['description'] ?>" data-id="<?php echo $value['id'] ?>" data-status="<?php echo $value['status'] ?>" data-toggle="tooltip" title="Edit">
                                            <i class="ti-pencil-alt"></i>
                                        </a>
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
<?php if ($page_add || $page_edit) { ?>
    <!-- ADD EDIT MODAL -->
    <div class="modal fade" id="addExpenseModel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Expense Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo $action; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Expense Type Name <span class="form-required">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Expense Type Name" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter Description . . ."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Status</label>
                            <select name="status" class="custom-select">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                        <input type="hidden" name="id">
                        <input type="hidden" name="_token" value="<?php echo $token; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            //New or Edit Payment type Modal *************
            $('body').on('click', '.edit-expense-type', function () {
                var ele = $(this);
                $('#addExpenseModel input[name="name"]').val(ele.data("name"));
                $('#addExpenseModel textarea[name="description"]').val(ele.data("description"));
                $('#addExpenseModel input[name="id"]').val(ele.data("id"));
                $('#addExpenseModel select[name="status"]').val(ele.data("status"));
                $('#addExpenseModel .modal-title').text('Edit Expense Type');
                $('#addExpenseModel form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'expensetype/edit'; ?>');
                $('#addExpenseModel').modal('show');
            });

            $('#addExpenseModel').on('hidden.bs.modal', function (e) {
                $('#addExpenseModel .modal-title').text('New Expense Type');
                $('#addExpenseModel input').not( "[name='_token']" ).val('');
                $('#addExpenseModel textarea').val('');
                $('#addExpenseModel form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'expensetype/add'; ?>');
            });
        });
    </script>
<?php }

if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>





