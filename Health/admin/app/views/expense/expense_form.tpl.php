<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'expenses'; ?>">Expenses</a></li>
                    <li><?php echo $page_title; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" name="expense[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="Enter Purchase By . . ." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Amount <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><?php echo $common['info']['currency_abbr']; ?></span>
                            </div>
                            <input type="text" name="expense[amount]" class="form-control" value="<?php echo $result['amount']; ?>" placeholder="Enter Purchase Amount . . ." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-calendar"></i></span>
                            </div>
                            <input type="text" name="expense[date]" class="form-control date bg-white" value="<?php echo date_format(date_create($result['date']), $common['info']['date_format']); ?>" placeholder="Enter Purchase Date . . ." readonly autocomplete="off" required>
                        </div>
                    </div>
                    <?php if (!empty($result['id'])) { ?>
                        <div class="form-group">
                            <label>Receipt/Documents</label>
                            <div class="attach-file">
                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#attach-file"><i class="ti-cloud-up mr-2"></i> Upload</a>
                            </div>
                        </div>
                        <div class="attachment-container">
                            <?php if (!empty($receipt)) { foreach ($receipt as $key => $value) { $file_ext = pathinfo($value['file'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
                                <div class="attachment-image attachment-pdf">
                                    <a href="../public/uploads/attachments/<?php echo $value['file']; ?>" class="open-pdf">
                                        <img src="../public/images/pdf.png" alt="">
                                    </a>
                                    <div class="attachment-delete" data-toggle="tooltip" title="Delete"><a class="ti-close"></a></div>
                                    <input type="hidden" name="report_name" value="<?php echo $value['file']; ?>">
                                </div>
                            <?php } else { ?>
                                <div class="attachment-image">
                                    <a data-fancybox="gallery" href="../public/uploads/attachments/<?php echo $value['file']; ?>">
                                        <img src="../public/uploads/attachments/<?php echo $value['file']; ?>" alt="">
                                    </a>
                                    <div class="attachment-delete" data-toggle="tooltip" title="Delete"><a class="ti-close"></a></div>
                                    <input type="hidden" name="report_name" value="<?php echo $value['file']; ?>">
                                </div>
                            <?php } } } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Expense Type <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-notepad"></i></span>
                            </div>
                            <select class="custom-select" name="expense[expensetype]" required>
                                <?php if (!empty($expensetype)) { foreach ($expensetype as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['expense_type'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name'] ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Method <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-wallet"></i></span>
                            </div>
                            <select name="expense[method]" class="custom-select" required>
                                <?php if (!empty($method)) { foreach ($method as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['method'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name'] ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-paragraph"></i></span>
                            </div>
                            <textarea name="expense[description]" class="form-control" rows="6"><?php echo $result['description']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="expense[id]" value="<?php echo $result['id']; ?>">
        </div>
        <div class="panel-footer">
            <div class="content-submit text-center">
                <button type="submit" name="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>
<!-- Attach File Modal -->
<div id="attach-file" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Receipt</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?php echo URL_ADMIN.DIR_ROUTE.'attach/documents'; ?>" class="dropzone" id="attach-file-upload"></form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function () {
        $("a.open-pdf").fancybox({
            'frameWidth': 800,
            'frameHeight': 900,
            'overlayShow': true,
            'hideOnContentClick': false,
            'type': 'iframe'
        });

        $("#attach-file-upload").dropzone({
            addRemoveLinks: true,
            acceptedFiles: "image/*,application/pdf",
            maxFilesize: 2,
            dictDefaultMessage: 'Drop files here or click here to upload.<br /><br /> Only Image and PDF allowed.',
            init: function() {
                var attachmentDropzone = this;
                this.on("sending", function(file, xhr, formData) {
                    formData.append("id", <?php echo $result['id']; ?>);
                    formData.append("type", 'expense');
                    formData.append("_token", $('.s_token').val());
                });

                this.on("success", function(file, xhr){
                    var response = JSON.parse(xhr);
                    if (response.error === false) {
                        if (response.ext === "pdf") {
                            $('.attachment-container').append('<div class="attachment-image attachment-pdf">'+
                                '<a href="../public/uploads/attachments/'+response.name+'" class="open-pdf">'+
                                '<img class="img-thumbnail" src="../public/images/pdf.png" alt="">'+
                                '</a>'+
                                '<input type="hidden" name="report_name" value="'+response.name+'">'+
                                '<div class="attachment-delete" data-toggle="tooltip" title="" data-original-title="Delete"><a class="ti-close"></a></div>'+
                                '</div>');
                        } else {
                            $('.attachment-container').append('<div class="attachment-image">'+
                                '<a data-fancybox="gallery" href="../public/uploads/attachments/'+response.name+'">'+
                                '<img class="img-thumbnail" src="../public/uploads/attachments/'+response.name+'" alt="">'+
                                '</a>'+
                                '<div class="attachment-delete" data-toggle="tooltip" title="" data-original-title="Delete"><a class="ti-close"></a></div>'+
                                '<input type="hidden" name="report_name" value="'+response.name+'">'+
                                '</div>');
                        }
                        toastr.success('File uploaded successfully.', 'Success');
                        $('#attach-file').modal('hide');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                    attachmentDropzone.removeFile(file);
                });
            }
        });

        $('.attachment-container').on('click', '.attachment-delete a', function () {
            var ele = $(this),
            name = ele.parents('.attachment-image').find('input').val();
            $.ajax({
                type: 'POST',
                url: 'index.php?route=attach/documents/delete',
                data: {name: name, type: 'expense', id: '<?php echo $result['id']; ?>', _token: $('.s_token').val()},
                error: function() {
                    toastr.error('File could not be deleted', 'Server Error');
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.error === false) {
                        ele.parents('.attachment-image').remove();
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                }
            });
        });
    });
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>