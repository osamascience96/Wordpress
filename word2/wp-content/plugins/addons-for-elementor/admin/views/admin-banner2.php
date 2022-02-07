<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<div id="lae-banner-wrap">

    <div id="lae-banner" class="lae-banner-sticky">
        <h2><span><?php echo __('Livemesh Addons for Elementor', 'livemesh-el-addons'); ?></span><?php echo __('Plugin Settings', 'livemesh-el-addons') ?></h2>
        <div id="lae-buttons-wrap">
            <a class="lae-button" data-action="lae_save_settings" id="lae_settings_save"><i
                    class="dashicons dashicons-yes"></i><?php echo __('Save Settings', 'livemesh-el-addons') ?></a>
            <a class="lae-button reset" data-action="lae_reset_settings" id="lae_settings_reset"><i
                    class="dashicons dashicons-update"></i><?php echo __('Reset', 'livemesh-el-addons') ?></a>
        </div>
    </div>

</div>