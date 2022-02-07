<?php

namespace LivemeshAddons\Widgets;

use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor widget base.
 *
 * An abstract class to register new Elementor widgets for Livemesh Addons. It extended the
 * `Widget_Base` class from Elementor to inherit its properties.
 *
 * This abstract class must be extended in order to register new widgets.
 *
 * @since 6.2
 * @abstract
 */
abstract class LAE_Widget_Base extends Widget_Base {

    /**
     * Parse text editor.
     *
     * Parses the content from rich text editor with shortcodes, oEmbed and
     * filtered data.
     *
     * @param string $content Text editor content.
     *
     * @return string Parsed content.
     * @since 6.2
     * @access public
     *
     */
    public function parse_text_editor($content) {

        return parent::parse_text_editor($content);
    }
}