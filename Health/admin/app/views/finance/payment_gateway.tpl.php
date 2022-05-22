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
        </div>
    </div>
</div>

<form action="<?php echo $action; ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo $token; ?>">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary d-none">
                <li class="nav-item">
                    <a class="nav-link active" href="" data-toggle="tab">Basic Info</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paypal Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-paragraph"></i></span>
                            </div>
                            <input type="text" class="form-control" name="paypal[username]" value="<?php echo $result['data']['paypal']['username']; ?>" placeholder="Enter Paypal Username . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paypal Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-key"></i></span>
                            </div>
                            <input type="text" class="form-control" name="paypal[password]" value="<?php echo $result['data']['paypal']['password']; ?>" placeholder="Enter Paypal Password . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paypal Signature</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-hand-drag"></i></span>
                            </div>
                            <input type="text" class="form-control" name="paypal[signature]" value="<?php echo $result['data']['paypal']['signature']; ?>" placeholder="Enter Paypal Signature . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paypal Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-email"></i></span>
                            </div>
                            <input type="text" class="form-control" name="paypal[email]" value="<?php echo $result['data']['paypal']['email']; ?>" placeholder="Enter Paypal Email Address . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paypal Mode</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-server"></i></span>
                            </div>
                            <select class="custom-select" name="paypal[mode]">
                                <option value="0" <?php if ($result['data']['paypal']['mode'] == '0') { echo "selected"; } ?>>Sandbox</option>
                                <option value="1" <?php if ($result['data']['paypal']['mode'] == '1') { echo "selected"; } ?>>Live</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-check"></i></span>
                            </div>
                            <select class="custom-select" name="paypal[status]">
                                <option value="1" <?php if ($result['data']['paypal']['status'] == '1') { echo "selected"; } ?>>Enable</option>
                                <option value="0" <?php if ($result['data']['paypal']['status'] == '0') { echo "selected"; } ?>>Disable</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-center">
            <button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
        </div>
    </div>
</form>

<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php');  ?>