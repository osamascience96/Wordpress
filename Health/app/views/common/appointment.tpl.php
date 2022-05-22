<?php echo $header; ?>

<div class="appointment-wrapper">
	<form class="appointment-form">
		<div class="appointment">
			<div class="input-box doctor-box">
				<input type="hidden" class="department" name="department" value="">
				<select name="doctor" class="doctor" required>
					<option value=""><?php echo $lang['text_choose_doctor']; ?></option>
					<?php if (!empty($doctors)) { foreach ($doctors as $key => $value) { ?>
						<option value="<?php echo $value['id'] ?>" data-department="<?php echo $value['department_id'] ?>" data-weekly="<?php echo htmlspecialchars($value['weekly'], ENT_QUOTES, 'UTF-8'); ?>" data-national="<?php echo htmlspecialchars($value['national'], ENT_QUOTES, 'UTF-8'); ?>" ><?php echo 'Dr. '.$value['name'].' ('. $value['department'].')'; ?></option>
					<?php } } ?>
				</select>
				<label><?php echo $lang['text_choose_doctor']; ?></label>
			</div>
			<div class="input-box date-box">
				<input type="text" class="date" name="date" readonly required>
				<label><?php echo $lang['text_date']; ?></label>
			</div>
			<div class="input-type-box time-box pb-2">
				<span><?php echo $lang['text_time']; ?></span>
				<div class="slot"></div>
			</div>
			<div class="continue-box text-right">
				<a class="btn btn-primary continue"><?php echo $lang['text_continue']; ?></a>
			</div>
		</div>
		<div class="user">
			<div class="input-type-box info">
				<span><?php echo $lang['text_doctor'].' & '.$lang['text_datetime']; ?></span>
				<div><i class="fas fa-user-md mr-2"></i><text class="doctor-text"></text></div>
				<div><i class="far fa-calendar-plus mr-2"></i><text class="date-text"></text></div>
				<div><i class="far fa-clock mr-2"></i><text class="time-text"></text></div>
			</div>
			<div class="input-box">
				<input type="text" name="name" value="<?php echo $user['name']; ?>" required>
				<label><?php echo $lang['text_name']; ?></label>
			</div>
			<div class="input-box">
				<input type="email" name="mail" value="<?php echo $user['email']; ?>" required>
				<label><?php echo $lang['text_email_address']; ?></label>
			</div>
			<div class="input-box">
				<input type="text" name="mobile" value="<?php echo $user['mobile']; ?>" required>
				<label><?php echo $lang['text_mobile_number']; ?></label>
			</div>
			<div class="input-box">
				<textarea name="message"></textarea>
				<label><?php echo $lang['text_reason_problem']; ?></label>
			</div>
			<div class="submit-box">
				<div class="row">
					<div class="col-6 text-left">
						<a class="btn btn-default back"><?php echo $lang['text_back']; ?></a>
					</div>
					<div class="col-6 text-right">
						<a class="btn btn-primary submit"><?php echo $lang['text_submit']; ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="success text-center">
			<div class="details"><?php echo $lang['text_your_appointment_with']; ?> <span class="success-doctor"></span> <?php echo $lang['text_on']; ?> <span class="success-date"></span> <?php echo $lang['text_at']; ?> <span class="success-time"></span> <?php echo $lang['text_has_been_booked']; ?></div>
			<div class="icon"><i class="fas fa-envelope-open-text"></i></div>
			<div class="bottom"><?php echo $lang['text_for_more_information_visit_your_mail_box']; ?></div>
			<a href="<?php echo URL.DIR_ROUTE.'user/appointments'; ?>" class="btn btn-primary mt-3"><?php echo $lang['text_view'].' '.$lang['text_appointments']; ?></a>
		</div>
	</form>
</div>
<?php echo $footer; ?>