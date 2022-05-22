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
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPaymentType"><i class="ti-plus pr-2"></i> New Payment Method</a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-middle table-bordered table-striped datatable-table">
                <thead>
                    <tr class="table-heading">
                        <th class="table-srno">#</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <?php if ($page_edit || $page_delete) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr> 
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><a class="text-primary font-14"><?php echo $value['name']; ?></a></td>
                            <td>
                                <?php if ($value['status'] == 1) { echo '<span class="label label-success">Active</span>'; }
                                else { echo '<span class="label label-danger">InActive</span>'; } ?>
                            </td>
                            <?php if ($page_edit || $page_delete) { ?>
                                <td class="table-action">
                                    <?php if ($page_edit) { ?>
                                        <a class="text-primary edit-paymenttype" data-name="<?php echo $value['name'] ?>" data-name="<?php echo $value['name'] ?>" data-id="<?php echo $value['id'] ?>" data-status="<?php echo $value['status'] ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="ti-pencil-alt"></i></a>
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
    <div class="modal fade" id="addPaymentType" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo $action; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Payment Method Name <span class="form-required">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Payment Method Name . . ." required>
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
        $('body').on('click', '.edit-paymenttype', function () {
            var ele = $(this);
            $('#addPaymentType input[name="name"]').val(ele.data("name"));
            $('#addPaymentType input[name="id"]').val(ele.data("id"));
            $('#addPaymentType select[name="status"]').val(ele.data("status"));
            $('#addPaymentType .modal-title').text('Edit Payment Method');
            $('#addPaymentType form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'paymentmethod/edit'; ?>');
            $('#addPaymentType').modal('show');
        });

        $('#addPaymentType').on('hidden.bs.modal', function (e) {
            $('#addPaymentType .modal-title').text('New Payment Method');
            $('#addPaymentType input').not( "[name='_token']" ).val('');
            $('#addPaymentType textarea').val('');
            $('#addPaymentType form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'paymentmethod/add'; ?>');
        });
        $('#finance-method a').addClass('active');

    });
</script>
<?php } if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>