<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block">Email Setting</h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li>Email Setting</li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right">
        </div>
    </div>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo $token; ?>">
    <div class="panel panel-default">
        <div class="panel-body">
         <div class="tab-pane" id="email-settings">
            <div class="form-group">
                <label>Default</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-envelope"></i></span>
                    </div>
                    <select name="smtp[status]" class="custom-select mail-type">
                        <option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> >Disable Mail</option>
                        <option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> >Default PHP Mail</option>
                        <option value="2" <?php if($result['status'] == '2') { echo "selected";} ?> >SMTP Mail</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="br-bottom-1x mt-3 mb-4"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">From Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-email"></i></span>
                            </div>
                            <input type="text" name="smtp[fromemail]" class="form-control" value="<?php echo $result['fromemail'] ?>" placeholder="Enter From Email Address . . ." required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">From Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" name="smtp[fromname]" class="form-control" value="<?php echo $result['fromname'] ?>" placeholder="Enter From Name . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">Reply-To Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-email"></i></span>
                            </div>
                            <input type="text" name="smtp[reply]" class="form-control" value="<?php echo $result['reply'] ?>" placeholder="Enter Reply-To Email Address . . .">
                        </div>
                        <div class="form-text text-muted">Optional. This email address will be used in the "Reply-To" field of the email. Leave it blank to use "From" email as the reply-to value.</div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div id="smtp-mail" class="row" <?php if ($result['status'] == "0" || $result['status'] == "1") { echo 'style="display: none;"'; } ?>>
                <div class="col-12">
                    <div class="br-bottom-1x mt-3 mb-4"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">SMTP Host</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-server"></i></span>
                            </div>
                            <input type="text" name="smtp[host]" class="form-control" value="<?php echo $result['host'] ?>" placeholder="Enter SMTP Host . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">SMTP Port</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-server"></i></span>
                            </div>
                            <input type="text" name="smtp[port]" class="form-control" value="<?php echo $result['port'] ?>" placeholder="Enter SMTP Port . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">SMTP Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-text"></i></span>
                            </div>
                            <input type="text" name="smtp[username]" class="form-control" value="<?php echo $result['username'] ?>" placeholder="Enter SMTP Username . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label">SMTP Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-infinite"></i></span>
                            </div>
                            <input type="text" name="smtp[password]" class="form-control" value="<?php echo $result['password'] ?>" placeholder="Enter SMTP Password . . .">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-form-label">Type of Encryption</label>
                        <div class="">
                            <div class="custom-control custom-radio custom-checkbox-1 d-inline-block mr-2">
                                <input type="radio" class="custom-control-input" name="smtp[encryption]" value="none" id="encryption-none" <?php if ($result['encryption'] == "none") { echo "checked"; } ?>>
                                <label class="custom-control-label" for="encryption-none">none</label>
                            </div>
                            <div class="custom-control custom-radio custom-checkbox-1 d-inline-block mr-2">
                                <input type="radio" class="custom-control-input" name="smtp[encryption]" value="ssl" id="encryption-sss" <?php if ($result['encryption'] == "ssl") { echo "checked"; } ?>>
                                <label class="custom-control-label" for="encryption-sss">SSL</label>
                            </div>
                            <div class="custom-control custom-radio custom-checkbox-1 d-inline-block">
                                <input type="radio" class="custom-control-input" name="smtp[encryption]" value="tls" id="encryption-tls" <?php if ($result['encryption'] == "tls") { echo "checked"; } ?>>
                                <label class="custom-control-label" for="encryption-tls">TLS</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">SMTP Authentication</label>
                        <div class="">
                            <div class="custom-control custom-radio d-inline-block mr-2">
                                <input type="radio" class="custom-control-input" name="smtp[authentication]" value="0" id="authentication-no" <?php if ($result['authentication'] == "0") { echo "checked"; } ?>>
                                <label class="custom-control-label" for="authentication-no">No</label>
                            </div>
                            <div class="custom-control custom-radio d-inline-block">
                                <input type="radio" class="custom-control-input" name="smtp[authentication]" value="1" id="authentication-yes" <?php if ($result['authentication'] == "1") { echo "checked"; } ?>>
                                <label class="custom-control-label" for="authentication-yes">Yes</label>
                            </div>
                        </div>
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
<script>
    $('body').on('change', 'select.mail-type', function () {
        if ($(this).val() == "2") { $('#smtp-mail').show(); }
        else { $('#smtp-mail').hide(); }
    });
</script>

<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>