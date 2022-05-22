<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block"><?php echo $result['name']; ?></h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li><?php echo $result['name']; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right">
        </div>
    </div>
</div>
<!-- payment Type page start -->
<div class="row">
    <div class="col-md-8">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-form-label">Template Name <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-tag"></i></span>
                            </div>
                            <input type="text" class="form-control" name="mail[name]" value="<?php echo $result['name']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Subject <span class="form-required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-tag"></i></span>
                            </div>
                            <input type="text" class="form-control" name="mail[subject]" value="<?php echo $result['subject']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Body <span class="form-required">*</span></label>
                        <textarea name="mail[message]" class="summernote"><?php echo $result['message']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-check"></i></span>
                            </div>
                            <select name="mail[status]" class="custom-select">
                                <option value="1" <?php if ($result['status'] == '1') { echo "selected"; } ?>>Send Mail</option>
                                <option value="0" <?php if ($result['status'] == '0') { echo "selected"; } ?>>Do not Send Mail</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="mail[template]" value="<?php echo $result['template']; ?>">
                </div>
                <div class="panel-footer text-center">
                    <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <?php include (DIR_ADMIN.'app/views/template/template_menu.tpl.php'); ?>
    </div>
</div>
<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/klinikal.summernote.js"></script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>