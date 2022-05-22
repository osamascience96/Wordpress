<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>

<div class="page-title">
	<div class="row align-items-center">
		<div class="col-sm-6">
			<h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
			<div class="breadcrumbs d-inline-block">
				<ul>
					<li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
					<li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescriptions'; ?>">Prescriptions</a></li>
					<li><?php echo $page_title; ?></li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 text-right"></div>
	</div>
</div>

<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $common['token']; ?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label">Patient Name <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
							<input type="text" name="prescription[name]" class="form-control patient-name" value="<?php echo $result['name']; ?>" placeholder="Seach Patient Name or Enter . . ." required>
							<input type="hidden" name="prescription[patient_id]" class="form-control patient-id" value="<?php echo $result['patient_id']; ?>">
						</div>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label">Patient Email Address</label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
							<input type="text" name="prescription[email]" class="form-control patient-mail" value="<?php echo $result['email']; ?>" placeholder="Enter Patient Email Address . . ." required>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label">Doctor <span class="form-required">*</span></label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="ti-heart-broken"></i></span></div>
							<?php if ($common['user']['role_id'] == '3' && $common['info']['doctor_access'] == '1') { ?>
								<input type="text" class="form-control" value="<?php echo $common['user']['firstname'].' '.$common['user']['lastname']; ?>" readonly>
								<input type="hidden" name="prescription[doctor]" value="<?php echo $common['user']['doctor']; ?>">
							<?php } else { ?>
								<select name="prescription[doctor]" class="custom-select" required>
									<option value="">Select Doctor</option>
									<?php foreach ($doctors as $value) { ?>
										<option value="<?php echo $value['id']; ?>" <?php if ($result['doctor_id'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
									<?php } ?>
								</select>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive mt-3">
				<table class="table table-bordered medicine-table">
					<thead>
						<tr class="medicine-row">
							<th style="width: 20%;">Drug Name <span class="form-required">*</span></th>
							<th>Generic</th>
							<th style="width: 9%;">Frequency</th>
							<th style="width: 9%;">Duration <span class="form-required">*</span></th>
							<th style="width: 25%;">Instruction</th>
							<th style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($result['prescription'])) { foreach ($result['prescription'] as $key => $value) { ?>
							<tr class="medicine-row">
								<td>
									<input class="form-control prescription-name" name="prescription[medicine][<?php echo $key; ?>][name]" value="<?php echo $value['name'] ?>" placeholder="Medicine Name" required>
								</td>
								<td>
									<textarea class="form-control prescription-generic" name="prescription[medicine][<?php echo $key; ?>][generic]" rows="3" placeholder="Generic"><?php echo $value['generic'] ?></textarea>
								</td>
								<td>
									<select name="prescription[medicine][<?php echo $key; ?>][dose]" class="form-control">
										<option value="1-0-0" <?php if ($value['dose'] == '1-0-0') { echo "selected";} ?> >1-0-0</option>
										<option value="1-0-1" <?php if ($value['dose'] == '1-0-1') { echo "selected";} ?> >1-0-1</option>
										<option value="1-1-1" <?php if ($value['dose'] == '1-1-1') { echo "selected";} ?> >1-1-1</option>
										<option value="0-0-1" <?php if ($value['dose'] == '0-0-1') { echo "selected";} ?> >0-0-1</option>
										<option value="0-1-0" <?php if ($value['dose'] == '0-1-0') { echo "selected";} ?> >0-1-0</option>
									</select>
								</td>
								<td>
									<select name="prescription[medicine][<?php echo $key; ?>][duration]" class="form-control">
										<option value="1" <?php if ($value['duration'] == '1') { echo "selected";} ?> >1 Days</option>
										<option value="2" <?php if ($value['duration'] == '2') { echo "selected";} ?> >2 Days</option>
										<option value="3" <?php if ($value['duration'] == '3') { echo "selected";} ?> >3 Days</option>
										<option value="4" <?php if ($value['duration'] == '4') { echo "selected";} ?> >4 Days</option>
										<option value="5" <?php if ($value['duration'] == '5') { echo "selected";} ?> >5 Days</option>
										<option value="6" <?php if ($value['duration'] == '6') { echo "selected";} ?> >6 Days</option>
										<option value="8" <?php if ($value['duration'] == '8') { echo "selected";} ?> >8 Days</option>
										<option value="10" <?php if ($value['duration'] == '10') { echo "selected";} ?> >10 Days</option>
										<option value="15" <?php if ($value['duration'] == '15') { echo "selected";} ?> >15 Days</option>
										<option value="20" <?php if ($value['duration'] == '20') { echo "selected";} ?> >20 Days</option>
										<option value="30" <?php if ($value['duration'] == '30') { echo "selected";} ?> >30 Days</option>
										<option value="60" <?php if ($value['duration'] == '60') { echo "selected";} ?> >60 Days</option>
									</select>
								</td>
								<td>
									<textarea name="prescription[medicine][<?php echo $key; ?>][instruction]" class="form-control" rows="3" placeholder="Instruction"><?php echo $value['instruction']; ?></textarea>
								</td>
								<td>
									<a class="table-action-button medicine-delete"><i class="ti-trash text-danger"></i></a>
								</td>
							</tr>
						<?php } } else { ?>
							<tr class="medicine-row">
								<td>
									<input class="form-control prescription-name" name="prescription[medicine][0][name]" placeholder="Medicine Name" required>
								</td>
								<td>
									<textarea name="prescription[medicine][0][generic]" class="form-control prescription-generic" rows="3" placeholder="Generic"></textarea>
								</td>
								<td>
									<select name="prescription[medicine][0][dose]" class="form-control">
										<option value="1-0-0">1-0-0</option>
										<option value="1-0-1">1-0-1</option>
										<option value="1-1-1">1-1-1</option>
										<option value="0-0-1">0-0-1</option>
										<option value="0-1-0">0-1-0</option>
									</select>
								</td>
								<td>
									<select name="prescription[medicine][0][duration]" class="form-control">
										<option value="1">1 Days</option>
										<option value="2">2 Days</option>
										<option value="3">3 Days</option>
										<option value="4">4 Days</option>
										<option value="5">5 Days</option>
										<option value="6">6 Days</option>
										<option value="8">8 Days</option>
										<option value="10">10 Days</option>
										<option value="15">15 Days</option>
										<option value="20">20 Days</option>
										<option value="30">30 Days</option>
										<option value="60">60 Days</option>
									</select>
								</td>
								<td>
									<textarea name="prescription[medicine][0][instruction]" class="form-control" rows="3" placeholder="Instruction"></textarea>
								</td>
								<td><a class="table-action-button medicine-delete"><i class="ti-trash text-danger"></i></a></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="6">
								<a id="add-medicine" class="font-12 text-primary cursor-pointer">Add Medicine</a>
								<?php if (!empty($result['prescription_id'])) { ?>
									<a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointment/prescription&id='.$result['prescription_id']; ?>" class="color-green cursor-pointer pull-right" target="_blank">Print Prescription</a>
								<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
		<input type="hidden" name="prescription[id]" value="<?php echo $result['id'];?>">
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary"><i class="ti-save-alt pr-2"></i> Save</button>
		</div>
	</div>
</form>

<script>
	var path = '<?php echo URL_ADMIN.DIR_ROUTE; ?>'
	function medicine_autocomplete() {
		$(".prescription-name").autocomplete({
			minLength: 0,
			source: '<?php echo URL_ADMIN.DIR_ROUTE.'getmedicine'; ?>',
			focus: function( event, ui ) {
				$(this).parents('tr').find('.prescription-name').val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
				$(this).parents('tr').find('.prescription-name').val( ui.item.label );
				$(this).parents('tr').find('.prescription-generic').val( ui.item.generic );
				return false;
			}
		}).autocomplete( "instance" )._renderItem = function( ul, item ) {
			return $( "<li>" )
			.append( "<div>" + item.label + "<br>" + item.generic + "</div>" )
			.appendTo( ul );
		};
	}

	$('body').on('keydown.autocomplete', '.prescription-name', function() {
		medicine_autocomplete();
	});
	if ($(".medicine-delete").length < 2) { $(".medicine-delete").hide(); }
	else { $(".medicine-delete").show(); }

	$('body').on('click', '.medicine-delete', function() {
		$(this).parents('tr').remove();
		if ($(".medicine-delete").length < 2) $(".medicine-delete").hide();
	});

	$('#add-medicine').on('click', function () {
		if ($(".medicine-delete").length < 1) { $(".medicine-delete").hide(); }
		else { $(".medicine-delete").show(); }
		var count = $('.medicine-table .medicine-row:last .prescription-name').attr('name').split('[')[2];
		count = parseInt(count.split(']')[0]) + 1;
		$(".medicine-row:last").after('<tr class="medicine-row">'+
			'<td><input class="form-control prescription-name" name="prescription[medicine]['+count+'][name]" value="" placeholder="Medicine Name" required></td>'+
			'<td><textarea class="form-control prescription-generic" name="prescription[medicine]['+count+'][generic]" rows="3" placeholder="Generic"></textarea></td>'+
			'<td><select name="prescription[medicine]['+count+'][dose]" class="form-control"><option value="1-0-0">1-0-0</option><option value="1-0-1">1-0-1</option><option value="1-1-1">1-1-1</option><option value="0-0-1">0-0-1</option><option value="0-1-0">0-1-0</option></select></td>'+
			'<td><select name="prescription[medicine]['+count+'][duration]" class="form-control"><option value="1">1 Days</option><option value="2">2 Days</option><option value="3">3 Days</option><option value="4">4 Days</option><option value="5">5 Days</option><option value="6">6 Days</option><option value="8">8 Days</option><option value="10">10 Days</option><option value="15">15 Days</option><option value="20">20 Days</option><option value="30">30 Days</option><option value="60">60 Days</option></select></td>'+
			'<td><textarea name="prescription[medicine]['+count+'][instruction]" class="form-control" rows="3" placeholder="Instruction"></textarea></td>'+
			'<td><a class="table-action-button medicine-delete"><i class="ti-trash text-danger"></i></a></td>'+
			'</tr>');
	});
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>