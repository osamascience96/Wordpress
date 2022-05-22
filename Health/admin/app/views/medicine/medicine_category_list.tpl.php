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
            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-supplier"><i class="ti-plus pr-2"></i> New Category</a>
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
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr> 
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['name']; ?></td>
                            <td class="table-action">
                                <a class="text-primary edit-tax" data-name="<?php echo $value['name'] ?>" data-id="<?php echo $value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="ti-pencil-alt"></i></a>
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

<!-- ADD EDIT MODAL -->
<div class="modal fade" id="add-supplier" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Medicine Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                            <input type="text" class="form-control" name="name" placeholder="Enter Supplier Name . . ." required>
                        </div>
                    </div>
                    <input type="hidden" name="id">
                    <input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
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
        $('body').on('click', '.edit-tax', function () {
            var ele = $(this);
            var data = ele.data();
            $('#add-supplier input[name="name"]').val(ele.data("name"));
            $('#add-supplier input[name="id"]').val(ele.data("id"));
            $('#add-supplier .modal-title').text('Edit Medicine Category');
            $('#add-supplier form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'medicine/category/edit'; ?>');
            $('#add-supplier').modal('show');
        });

        $('#add-supplier').on('hidden.bs.modal', function (e) {
            $('#add-supplier .modal-title').text('New Medicine Category');
            $('#add-supplier input').not( "[name='_token']" ).val('');
            $('#add-supplier textarea').val('');
            $('#add-supplier form').attr('action', '<?php echo URL_ADMIN.DIR_ROUTE.'medicine/category/add'; ?>');
        });
    });
</script>
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>