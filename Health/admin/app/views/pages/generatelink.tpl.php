<li id="<?php echo $menu_id; ?>">
	<div class="w-accordion" data-id="<?php echo $menu_id ?>" data-type-id="<?php echo $menu_type_id; ?>" data-page-id="<?php echo $menu_page_id; ?>">
		<div class="w-hdr">
			<div class="title"><?php echo $menu_label; ?></div>
			<div class="control"><span>Custom Link</span><i class="ti-angle-down"></i></div>
		</div>
		<div class="w-bdy">
			<div class="form-group">
				<label>Label</label>
				<input type="text" class="form-control menu-label form-control-sm" value="<?php echo $menu_label; ?>">
			</div>
			<div class="form-group">
				<label>Link</label>
				<input type="text" class="form-control menu-link form-control-sm" value="<?php echo $menu_link; ?>">
				<input type="hidden" class="menu-custom" value="<?php echo $menu_custom; ?>">
			</div>
			<div class="text-right">
				<a href="#" class="font-12 text-danger menu-remove mr-2" data-id="<?php echo $menu_id ?>">Remove</a>
				<a href="#" class="font-12 text-secondary menu-cancel" data-id="<?php echo $menu_id ?>">Close</a>
			</div>
		</div>
	</div>
