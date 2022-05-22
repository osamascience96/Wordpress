<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<!-- Items list page start -->
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block">Notes</h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li>Notes</li>
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
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNote"><i class="ti-plus pr-2"></i> New Note</a>
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
                        <th>Note Type</th>
                        <th>Note</th>
                        <?php if ($page_edit || $page_delete) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td class="text-primary"><?php echo $value['type'];?></td>
                            <td><?php echo $value['note']; ?></td>
                            <?php if ($page_edit || $page_delete) { ?>
                                <td class="table-action">
                                    <?php if ($page_edit) { ?>
                                        <a class="edit edit-note" data-type="<?php echo $value['type']; ?>" data-note="<?php echo $value['note']; ?>" data-id="<?php echo $value['id'] ?>" data-toggle="tooltip" title="Edit"><i class="ti-pencil-alt"></i></a>
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
<?php if ($page_edit || $page_add) { ?>
    <!-- ADD EDIT MODAL -->
    <div class="modal fade" id="addNote" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo $action; ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="id" name="note[id]" value="">
                        <input type="hidden" name="_token" value="<?php echo $token; ?>">
                        <div class="form-group">
                            <label class="col-form-label">Note Type <span class="form-required">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-tag"></i></span></div>
                                <select class="custom-select type" name="note[type]">
                                    <option value="Problem">Problem</option>
                                    <option value="Observation">Observation</option>
                                    <option value="Diagnosis">Diagnosis</option>
                                    <option value="Investigation">Investigation</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Note <span class="form-required">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-paragraph"></i></span></div>
                                <textarea class="form-control note" name="note[note]" placeholder="Enter Note . . ." required></textarea>
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
            $('body').on('click', '.edit-note', function () {
                var ele = $(this);
                $('#addNote .type').val(ele.data('type'));
                $('#addNote .note').val(ele.data('note'));
                $('#addNote .id').val(ele.data('id'));
                $('#addNote .modal-title').text('Edit Note');
                $('#addNote').modal('show');
            });

            $('#addNote').on('hidden.bs.modal', function (e) {
                $('#addNote .modal-title').text('New Note');
                $('#addNote input').not( "[name='_token']" ).val('');
                $('#addNote textarea').val('');
            });
        });
    </script>
<?php } ?>
<?php
if ($page_delete) { include DIR_VIEW.'common/delete_modal.tpl.php'; }
include (DIR_ADMIN.'app/views/common/footer.tpl.php'); 
?>