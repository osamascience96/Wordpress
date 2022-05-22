<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Items list page start -->
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block">Items</h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li>Items</li>
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
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addItem"><i class="ti-plus pr-2"></i> New Item</a>
            <?php } ?>
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
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <?php if ($page_edit || $page_delete) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['name'];?></td>
                            <td><?php echo $common['info']['currency_abbr'].$value['price']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <?php if ($page_edit || $page_delete) { ?>
                                <td class="table-action">
                                    <?php if ($page_edit) { ?>
                                        <a class="text-primary edit edit-item" data-name="<?php echo $value['name']; ?>" data-description="<?php echo $value['description']; ?>" data-id="<?php echo $value['id'] ?>" data-price="<?php echo $value['price']; ?>" data-currency="<?php echo $value['currency']; ?>" data-toggle="tooltip" title="Edit"><i class="ti-pencil-alt"></i></a>
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
    <div class="modal fade" id="addItem" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo $action; ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="id" name="item[id]" value="">
                        <input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
                        <div class="form-group">
                            <label class="col-form-label">Name <span class="form-required">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
                                <input type="text" class="form-control name" value="" name="item[name]" placeholder="Enter Item Name . . ." required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-paragraph"></i></span></div>
                                <textarea class="form-control description" name="item[description]" placeholder="Enter Item Description . . ."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Price <span class="form-required">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $common['info']['currency_abbr']; ?></span>
                                </div>
                                <input type="text" class="form-control price" name="item[price]" value="" placeholder="Enter Item Price . . ." required>
                            </div>
                        </div>
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
            $('body').on('click', '.edit-item', function () {
                var ele = $(this);
                $('#addItem .name').val(ele.data("name"));
                $('#addItem .description').val(ele.data("description"));
                $('#addItem .price').val(ele.data("price"));
                $('#addItem .currency').val(ele.data("currency"));
                $('#addItem .id').val(ele.data("id"));
                $('#addItem .modal-title').text('Edit Item');
                $('#addItem').modal('show');
            });

            $('#addItem').on('hidden.bs.modal', function (e) {
                $('#addItem .modal-title').text('New Item');
                $('#addItem input').not( "[name='_token']" ).val('');
                $('#addItem textarea').val('');
            });
        });
    </script>
<?php } ?>
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>