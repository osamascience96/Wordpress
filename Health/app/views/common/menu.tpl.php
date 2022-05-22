 <li>
 	<a href="<?php if ($menu_custom == '1') { echo URL.DIR_ROUTE.$menu_link; } else if ($menu_custom == '0') { echo $menu_link; }  ?>">
 		<?php echo $menu_label; if (isset($menu_icon)) { echo $menu_icon; } ?>
 	</a>