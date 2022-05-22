<form action="<?php echo $action; ?>" method="post" class="row pt-3">
    <input type="hidden" name="_token" value="<?php echo $token ?>">
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="firstname" pattern="[A-Z,a-z, ]*" value="<?php echo $user_data['firstname']; ?>" required>
            <label><?php echo $lang['text_first_name']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="lastname" pattern="[A-Z,a-z, ]*" value="<?php echo $user_data['lastname']; ?>" required>
            <label><?php echo $lang['text_last_name']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="<?php echo $user_data['email']; ?>" required>
            <label><?php echo $lang['text_email_address']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="mobile" pattern="[0-9]*" value="<?php echo $user_data['mobile']; ?>" required>
            <label><?php echo $lang['text_mobile_number']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="dob" class="dob" value="<?php echo date_format(date_create($user_data['dob']), $siteinfo['date_format']); ?>" required>
            <label><?php echo $lang['text_birthday']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <select name="gender" required>
                <option value=""><?php echo $lang['text_gender']; ?></option>
                <option value="Male" <?php if ($user_data['gender'] == 'Male') { echo "selected"; } ?>><?php echo $lang['text_male']; ?></option>
                <option value="Female" <?php if ($user_data['gender'] == 'Female') { echo "selected"; } ?>><?php echo $lang['text_female']; ?></option>
                <option value="Other" <?php if ($user_data['gender'] == 'Other') { echo "selected"; } ?>><?php echo $lang['text_other']; ?></option>
            </select>
            <label><?php echo $lang['text_gender']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <select name="bloodgroup">
                <option value=""><?php echo $lang['text_blood_group']; ?></option>
                <option value="O+" <?php if ($user_data['bloodgroup'] == 'O+') { echo "selected"; } ?>>O+</option>
                <option value="A+" <?php if ($user_data['bloodgroup'] == 'A+') { echo "selected"; } ?>>A+</option>
                <option value="B+" <?php if ($user_data['bloodgroup'] == 'B+') { echo "selected"; } ?>>B+</option>
                <option value="O-" <?php if ($user_data['bloodgroup'] == 'O-') { echo "selected"; } ?>>O-</option>
                <option value="A-" <?php if ($user_data['bloodgroup'] == 'A-') { echo "selected"; } ?>>A-</option>
                <option value="B-" <?php if ($user_data['bloodgroup'] == 'B-') { echo "selected"; } ?>>B-</option>
                <option value="AB+" <?php if ($user_data['bloodgroup'] == 'AB+') { echo "selected"; } ?>>AB+</option>
                <option value="AB-" <?php if ($user_data['bloodgroup'] == 'AB-') { echo "selected"; } ?>>AB-</option>
            </select>
            <label class="col-form-label"><?php echo $lang['text_blood_group']; ?></label>
        </div>
    </div>
    <div class="col-12">
        <div class="br-dotted-1 mb-4"></div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="address[address1]" value="<?php echo $user_data['address']['address1']; ?>">
            <label class="col-form-label"><?php echo $lang['text_address_line1']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="address[address2]" value="<?php echo $user_data['address']['address2']; ?>">
            <label class="col-form-label"><?php echo $lang['text_address_line2']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="address[city]" value="<?php echo $user_data['address']['city']; ?>">
            <label class="col-form-label"><?php echo $lang['text_city']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="address[country]" value="<?php echo $user_data['address']['country']; ?>">
            <label class="col-form-label"><?php echo $lang['text_country']; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-box">
            <input type="text" name="address[postal]" value="<?php echo $user_data['address']['postal']; ?>">
            <label class="col-form-label"><?php echo $lang['text_postal_code']; ?></label>
        </div>
    </div>
    <div class="col-12 pb-2">
        <div class="br-dotted-1 mb-4 text-dark"></div>
    </div>
    <div class="col-12">
        <div class="input-type-box">
            <span><?php echo $lang['text_medical_history']; ?></span>
            <div class="row">
                <?php foreach ($history as $key => $value) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="custom-control custom-checkbox font-14 mb-2">
                            <input type="checkbox" name="history[]" class="custom-control-input" value="<?php echo $value; ?>" id="<?php echo $key; ?>" <?php if (!empty($user_data['history'])) { foreach ($user_data['history'] as $k => $v) { if ($v == $value) { echo "checked"; } } } ?>>
                            <label class="custom-control-label" for="<?php echo $key; ?>"><?php echo $value; ?></label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-box">
            <textarea name="other" rows="4"><?php echo $user_data['other']; ?></textarea>
            <label class="col-form-label"><?php echo $lang['text_other_history']; ?></label>
        </div>
    </div>
    <div class="col-12 text-center pb-3">
        <button type="submit" name="submit" class="btn btn-primary btn-shadow btn-pill"><?php echo $lang['text_save']; ?></button>
    </div>
</form>