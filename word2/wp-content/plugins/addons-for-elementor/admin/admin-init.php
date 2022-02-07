<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class LAE_Admin {


    protected $plugin_slug = 'livemesh_el_addons';

    public function __construct() {

        $this->includes();
        $this->init_hooks();

    }

    public function includes() {

        // load class admin ajax function
        require_once LAE_PLUGIN_DIR . 'admin/admin-ajax.php';

        /**
         * Classes responsible for displaying admin notices.
         */
        if (lae_fs()->is_not_paying()) {

            require_once LAE_PLUGIN_DIR . 'admin/notices/admin-notice.php';

            require_once LAE_PLUGIN_DIR . 'admin/notices/admin-notice-rate.php';
        }

    }

    public function init_hooks() {

        // Build admin menu/pages
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

        add_action('admin_init', array($this, 'handle_external_redirects'), 1);

        // Load admin style sheet and JavaScript.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        add_action('current_screen', array($this, 'remove_admin_notices'));


        /**
         * Notice: Rate plugin
         */
        if (lae_fs()->is_not_paying()) {
            $rate = new LAE_Notice_Rate('rate', LAE_PLUGIN_DIR . 'admin/notices/templates/rate.php');

            add_action('load-plugins.php', array($rate, 'defer_first_time'));
            add_action('admin_notices', array($rate, 'display_notice'));
            add_action('admin_post_lae_dismiss_notice', array($rate, 'dismiss_notice'));
        }

    }

    public function remove_admin_notices($screen) {

        // If this screen is Addons for Elementor plugin options page, remove annoying admin notices
        if (strpos($screen->id, $this->plugin_slug) !== false && strpos($screen->id, $this->plugin_slug . '_license') === false) {
            add_action('admin_notices', array(&$this, 'remove_notices_start'));
            add_action('admin_notices', array(&$this, 'remove_notices_end'), 999);
        }
    }

    public function remove_notices_start() {

        // Turn on output buffering
        ob_start();

    }

    public function remove_notices_end() {

        // Get current buffer contents and delete current output buffer
        $content = ob_get_contents();
        ob_clean();

    }

    public function add_plugin_admin_menu() {

        add_menu_page(
            __('Livemesh Addons for Elementor', 'livemesh-el-addons'),
            __('Livemesh Addons', 'livemesh-el-addons'),
            'manage_options',
            $this->plugin_slug,
            array($this, 'display_settings_page'),
            LAE_PLUGIN_URL . 'admin/assets/images/logo-shape16.png'
        );

        // add plugin settings submenu page
        add_submenu_page(
            $this->plugin_slug,
            __('Widgets Settings', 'livemesh-el-addons'),
            __('Settings', 'livemesh-el-addons'),
            'manage_options',
            $this->plugin_slug,
            array($this, 'display_settings_page')
        );

        // add import/export submenu page
        add_submenu_page(
            $this->plugin_slug,
            __('Widgets Documentation', 'livemesh-el-addons'),
            __('Documentation', 'livemesh-el-addons'),
            'manage_options',
            $this->plugin_slug . '_documentation',
            '__return_false',
            null
        );

    }

    public function handle_external_redirects() {
        if (empty($_GET['page'])) {
            return;
        }

        if ($this->plugin_slug . '_documentation' === $_GET['page']) {
            wp_redirect('https://livemeshelementor.com/documentation/');
            die;
        }
    }

    public function display_settings_page() {

        require_once('views/admin-header.php');
        require_once('views/admin-banner2.php');
        require_once('views/settings.php');
        require_once('views/admin-footer.php');

    }

    public function enqueue_admin_scripts() {

        // Use minified libraries if LAE_SCRIPT_DEBUG is turned off
        $suffix = (defined('LAE_SCRIPT_DEBUG') && LAE_SCRIPT_DEBUG) ? '' : '.min';

        // get current admin screen
        $screen = get_current_screen();

        // If screen is a part of Addons for Elementor plugin options page
        if (strpos($screen->id, $this->plugin_slug) !== false) {

            wp_enqueue_script('jquery-ui-datepicker');

            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');

            wp_register_style('lae-admin-styles', LAE_PLUGIN_URL . 'admin/assets/css/lae-admin.css', array(), LAE_VERSION);
            wp_enqueue_style('lae-admin-styles');

            wp_register_script('lae-admin-scripts', LAE_PLUGIN_URL . 'admin/assets/js/lae-admin' . $suffix . '.js', array(), LAE_VERSION, true);
            wp_enqueue_script('lae-admin-scripts');

            wp_register_style('lae-admin-page-styles', LAE_PLUGIN_URL . 'admin/assets/css/lae-admin-page.css', array(), LAE_VERSION);
            wp_enqueue_style('lae-admin-page-styles');
        }

    }

}

new LAE_Admin;