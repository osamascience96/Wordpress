<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'birthrecords'; ?>">Birth Records</a></li>
                    <li><?php echo $page_title; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?php echo URL_ADMIN.DIR_ROUTE.'birthrecord/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="ti-printer pr-2"></i> PDF/Print</a>
            <?php if ($page_edit) { ?>
                <a href="<?php echo URL_ADMIN.DIR_ROUTE.'birthrecord/edit&id='.$result['id']; ?>" class="btn btn-primary btn-sm"><i class="ti-pencil-alt pr-2"></i> Edit</a>
            <?php } ?>
            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#attach-file"><i class="ti-clip pr-1"></i> Add Documents</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-lg-12 col-xl-8">
        <div class="inv-template">
            <div class="inv-template-bdy table-responsive p-4">
                <div class="company table-responsive">
                    <table>
                        <tbody>
                            <tr>
                                <td class="info">
                                    <div class="logo"><img src="../public/uploads/<?php echo $common['info']['logo']; ?>" alt="logo"></div>
                                    <div class="name"><?php echo $common['info']['legal_name']; ?></div>
                                    <div class="text"><?php echo $common['info']['address']['address1'].', '.$common['info']['address']['address2'].', '.$common['info']['address']['city'].', '.$common['info']['address']['country'].' - '.$common['info']['address']['postal']; ?></div>
                                </td>
                                <td class="text-right">
                                    <div class="title">Birth Certificate</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="meta table-responsive">
                    <table>
                        <tbody>
                            <tr>
                                <td class="bill-to">
                                    <div class="title">Dr. <?php echo $result['doctor_name']; ?></div>
                                </td>
                                <td class="bill-to text-right">
                                    <div class="text">Date => <?php echo date_format(date_create($result['date_of_joining']), $common['info']['date_format']); ?></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="item table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mother Name</td>
                                <td class="font-500"><?php echo $result['mother_name'].' ( '.$result['mother_email']. ', ' . $result['mother_mobile'].' )'; ?></td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td class="font-500"><?php echo $result['father_name'].' ( '.$result['father_email']. ', ' . $result['father_mobile'].' )'; ?></td>
                            </tr>
                            <tr>
                                <td>Child Name</td>
                                <td class="font-500"><?php echo $result['child']; ?></td>
                            </tr>
                            <tr>
                                <td>Birth DateTime</td>
                                <td class="font-500"><?php echo date_format(date_create($result['date']), $common['info']['date_format']).' '.$result['time']; ?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td class="font-500"><?php echo $result['gender']; ?></td>
                            </tr>
                            <tr>
                                <td>Weight</td>
                                <td class="font-500"><?php echo $result['weight']; ?></td>
                            </tr>
                            <tr>
                                <td>Height</td>
                                <td class="font-500"><?php echo $result['height']; ?></td>
                            </tr>
                            <tr>
                                <td>Report/Remark</td>
                                <td class="font-500"><?php echo html_entity_decode($result['remark'], ENT_QUOTES | ENT_XML1, 'UTF-8'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-12 col-xl-4">
        <div class="panel panel-default">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="panel-title-text">Documents</span>
                </div>
                <div class="panel-action">
                    <a class="btn btn-info btn-sm" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#attach-file"><i class="ti-clip"></i></a>
                </div>
            </div>
            <div class="panel-wrapper">
                <div class="attachment-container">
                    <?php if (!empty($documents)) { foreach ($documents as $key => $value) { $file_ext = pathinfo($value['file'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
                        <div class="attachment-image attachment-pdf">
                            <a href="<?php echo '../public/uploads/attachments/'.$value['file']; ?>" class="open-pdf">
                                <img src="../public/images/pdf.png" alt="">
                            </a>
                            <div class="attachment-delete" data-toggle="tooltip" title="Delete"><a class="ti-close"></a></div>
                            <input type="hidden" name="report_name" value="<?php echo $value['file']; ?>">
                        </div>
                    <?php } else { ?>
                        <div class="attachment-image">
                            <a data-fancybox="gallery" href="<?php echo '../public/uploads/attachments/'.$value['file']; ?>">
                                <img src="<?php echo '../public/uploads/attachments/'.$value['file']; ?>" alt="">
                            </a>
                            <div class="attachment-delete" data-toggle="tooltip" title="Delete"><a class="ti-close"></a></div>
                            <input type="hidden" name="report_name" value="<?php echo $value['file']; ?>">
                        </div>
                    <?php } } } else { ?>
                        <p class="p-3 text-danger text-center">No doument found !!!</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attach File Modal -->
<div id="attach-file" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Documents</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?php echo URL_ADMIN.DIR_ROUTE.'attach/documents'; ?>" class="dropzone" id="attach-file-upload"></form>
            </div>
        </div>
    </div>
</div>

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
                    formData.append("type", 'birth');
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
                url: '<?php echo URL_ADMIN.DIR_ROUTE.'attach/documents/delete'; ?>',
                data: {name: name, type: 'birth', id: '<?php echo $result['id']; ?>', _token: $('.s_token').val()},
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

<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>