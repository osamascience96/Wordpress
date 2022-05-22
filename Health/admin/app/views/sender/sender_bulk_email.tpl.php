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
        <div class="col-sm-6 text-right"></div>
    </div>
</div>
<form class="row" action="<?php echo $action; ?>" method="post">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <input type="hidden" name="_token" value="<?php echo $token; ?>">
                <div class="form-group">
                    <label>User Type <span class="form-required">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                        <select name="receiver[user_type]" class="custom-select send-user-type" data-live-search="true" required>
                            <option value="">Select User Type</option>
                            <?php if (!empty($roles)) { foreach ($roles as $key => $value) { ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php } } ?>
                            <option value="patient">Patient</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Subject <span class="form-required">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-comment"></i></span></div>
                        <input type="text" name="receiver[subject]" class="form-control" placeholder="Enter Subject . . ." required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="receiver[message]" class="summernote" required></textarea>
                </div>
            </div>
            <div class="panel-footer text-center">
                <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-head">
                <div class="panel-title">
                    <i class="ti-user panel-head-icon"></i>
                    <span class="panel-title-text">Select Receiver</span>
                </div>
                <div class="panel-action"></div>
            </div>
            <div class="panel-body">
                <div class="receiver-container"></div>
            </div>
        </div>
    </div>
</form>

<script>
    $('.send-user-type').on('change', function() {
        var ele = $(this), user = ele.find('option:selected').val(), receiver = $('select.send-receiver');
        $('.receiver-container .block').remove();
        $.ajax({
            method: "POST",
            url: "index.php?route=get/receiver",
            data: { user: user , _token: $('.s_token').val()},
            error: function () {
                alert('Sorry Try Again!');
            },
            success: function (response) {
                $.each(JSON.parse(response), function (key, value) {
                    //receiver.append('<option value="'+value.id+'">'+value.name+'</option>');
                    if (value.id === 'all') {
                        $('.receiver-container').append('<div class="custom-control custom-checkbox block mb-3 receiver-all">'+
                            '<input type="checkbox" class="custom-control-input" id="receiver-'+value.id+'" value="'+value.id+'" checked>'+
                            '<label class="custom-control-label" for="receiver-'+value.id+'">'+value.name+'</label></div>');
                    } else {
                        $('.receiver-container').append('<div class="custom-control custom-checkbox block mb-3 receiver-single">'+
                            '<input type="checkbox" name="receiver[user][]" class="custom-control-input" id="receiver-'+value.id+'" value="'+value.id+'" checked>'+
                            '<label class="custom-control-label" for="receiver-'+value.id+'">'+value.name+'</label></div>');
                    }
                });
                //receiver.parents('.form-group').removeClass('d-none');
            }
        });
    });

    $('.receiver-container').on('change', '.receiver-all input', function () {
        var ele = $(this);
        if (ele.is(":checked")) {
            ele.parents('.receiver-container').find('input').prop("checked", true);
        } else {
            ele.parents('.receiver-container').find('input').prop("checked", false);
        }
    });

    $('.receiver-container').on('change', '.receiver-single input', function () {
        var ele = $(this);
        $('.receiver-container').find('.receiver-all input').prop("checked", false);
    });

</script>
<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>

<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>