<?php

$template_id = $settings['item_template'];

if ($template_id) : 

    /* Initialize the theme builder templates - Requires elementor pro plugin */
    if (!is_plugin_active('elementor-pro/elementor-pro.php')) {

        echo lae_template_error(__('Custom skin requires Elementor Pro but the plugin is not installed/active', 'livemesh-el-addons'));

    }
    else {

        echo lae_get_item_template_content($template_id, $settings);

    }

else : 

    echo lae_template_error(__('Choose a custom skin template for the carousel item', 'livemesh-el-addons')); 

endif; 