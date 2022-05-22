<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block">Currencies</h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li>Currencies</li>
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
            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCurrency"><i class="ti-plus pr-2"></i> New Currency</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-middle table-bordered table-striped datatable-table">
                        <thead>
                            <tr class="table-heading">
                                <th class="table-srno">#</th>
                                <th>Currency Code</th>
                                <th>Currency Abbr</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result) { foreach ($result as $key => $value) { ?>
                                <tr> 
                                    <td class="table-srno"><?php echo $key+1; ?></td>
                                    <td><a href="#" class="text-primary font-14"><?php echo $value['name']; ?></a></td>
                                    <td><?php echo $value['abbr']; ?></td>
                                    <td>
                                        <?php if ($value['status'] == 1) { echo '<span class="badge badge-success badge-pill badge-sm">Active</span>'; }
                                        else { echo '<span class="badge badge-warning badge-pill badge-sm">InActive</span>'; } ?>
                                    </td>
                                    <td class="table-action">
                                        <a class="text-primary edit-currency" data-name="<?php echo $value['name'] ?>" data-abbr="<?php echo $value['abbr'] ?>" data-id="<?php echo $value['id'] ?>" data-status="<?php echo $value['status'] ?>" data-toggle="tooltip" title="Edit"><i class="ti-pencil-alt"></i></a>
                                        <a class="table-delete text-danger delete" data-toggle="tooltip" title="Delete">
                                            <i class="ti-trash"></i><input type="hidden" value="<?php echo $value['id'];?>">
                                        </a>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php include (DIR_ADMIN.'app/views/finance/finance-menu.tpl.php'); ?>
    </div>
</div>

<!-- ADD EDIT MODAL -->
<div class="modal fade" id="addCurrency" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Currency</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Currency Code <span class="form-required">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Currency Code . . ." required>
                        <span class="form-text text-muted">Please enter international currnecy code.</span>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Currency Abbr <span class="form-required">*</span></label>
                        <input type="text" class="form-control" name="abbr" placeholder="Enter Currency Abbreviation . . ." required>
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
                <div class="modal-footer text-center">
                    <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //New or Edit Payment type Modal *************
        $('body').on('click', '.edit-currency', function () {
            var ele = $(this);
            $('#addCurrency input[name="name"]').val(ele.data("name"));
            $('#addCurrency input[name="abbr"]').val(ele.data("abbr"));
            $('#addCurrency input[name="id"]').val(ele.data("id"));
            $('#addCurrency select[name="status"]').val(ele.data("status"));
            $('#addCurrency .modal-title').text('Edit Currency');
            $('#addCurrency form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'currency/edit'; ?>');
            $('#addCurrency').modal('show');
        });

        $('#addCurrency').on('hidden.bs.modal', function (e) {
            $('#addCurrency .modal-title').text('New Currency');
            $('#addCurrency input').not( "[name='_token']" ).val('');
            $('#addCurrency textarea').val('');
            $('#addCurrency form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'currency/add'; ?>');
        });

        $('#finance-currency a').addClass('active');
    });
</script>

<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>