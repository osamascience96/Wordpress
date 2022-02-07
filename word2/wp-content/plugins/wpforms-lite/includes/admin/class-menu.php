<?php

/**
 * Register menu elements and do other global tasks.
 *
 * @since 1.0.0
 */
class WPForms_Admin_Menu {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Let's make some menus.
		add_action( 'admin_menu', array( $this, 'register_menus' ), 9 );
		add_action( 'admin_head', array( $this, 'hide_wpforms_submenu_items' ) );

		// Plugins page settings link.
		add_filter( 'plugin_action_links_' . plugin_basename( WPFORMS_PLUGIN_DIR . 'wpforms.php' ), array( $this, 'settings_link' ), 10 );
	}

	/**
	 * Register our menus.
	 *
	 * @since 1.0.0
	 */
	public function register_menus() {

		$manage_cap = wpforms_get_capability_manage_options();
		$access     = wpforms()->get( 'access' );

		if ( ! method_exists( $access, 'get_menu_cap' ) ) {
			return;
		}

		// Default Forms top level menu item.
		add_menu_page(
			esc_html__( 'WPForms', 'wpforms-lite' ),
			esc_html__( 'WPForms', 'wpforms-lite' ),
			$access->get_menu_cap( 'view_forms' ),
			'wpforms-overview',
			array( $this, 'admin_page' ),
			'data:image/svg+xml;base64,' . base64_encode( '<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="#9ea3a8" d="M643 911v128h-252v-128h252zm0-255v127h-252v-127h252zm758 511v128h-341v-128h341zm0-256v128h-672v-128h672zm0-255v127h-672v-127h672zm135 860v-1240q0-8-6-14t-14-6h-32l-378 256-210-171-210 171-378-256h-32q-8 0-14 6t-6 14v1240q0 8 6 14t14 6h1240q8 0 14-6t6-14zm-855-1110l185-150h-406zm430 0l221-150h-406zm553-130v1240q0 62-43 105t-105 43h-1240q-62 0-105-43t-43-105v-1240q0-62 43-105t105-43h1240q62 0 105 43t43 105z"/></svg>' ),
			apply_filters( 'wpforms_menu_position', '58.9' )
		);

		// All Forms sub menu item.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'WPForms', 'wpforms-lite' ),
			esc_html__( 'All Forms', 'wpforms-lite' ),
			$access->get_menu_cap( 'view_forms' ),
			'wpforms-overview',
			array( $this, 'admin_page' )
		);

		// Add New sub menu item.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'WPForms Builder', 'wpforms-lite' ),
			esc_html__( 'Add New', 'wpforms-lite' ),
			$access->get_menu_cap( array( 'create_forms', 'edit_forms' ) ),
			'wpforms-builder',
			array( $this, 'admin_page' )
		);

		// Entries sub menu item.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'Form Entries', 'wpforms-lite' ),
			esc_html__( 'Entries', 'wpforms-lite' ),
			$access->get_menu_cap( 'view_entries' ),
			'wpforms-entries',
			array( $this, 'admin_page' )
		);

		do_action_deprecated(
			'wpform_admin_menu',
			array( $this ),
			'1.5.5 of the WPForms plugin',
			'wpforms_admin_menu'
		);
		do_action( 'wpforms_admin_menu', $this );

		// Settings sub menu item.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'WPForms Settings', 'wpforms-lite' ),
			esc_html__( 'Settings', 'wpforms-lite' ),
			$manage_cap,
			'wpforms-settings',
			array( $this, 'admin_page' )
		);

		// Tools sub menu item.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'WPForms Tools', 'wpforms-lite' ),
			esc_html__( 'Tools', 'wpforms-lite' ),
			$access->get_menu_cap( array( 'create_forms', 'view_forms', 'view_entries' ) ),
			'wpforms-tools',
			array( $this, 'admin_page' )
		);

		// Hidden placeholder paged used for misc content.
		add_submenu_page(
			'wpforms-settings',
			esc_html__( 'WPForms', 'wpforms-lite' ),
			esc_html__( 'Info', 'wpforms-lite' ),
			$access->get_menu_cap( 'any' ),
			'wpforms-page',
			array( $this, 'admin_page' )
		);

		// Addons submenu page.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'WPForms Addons', 'wpforms-lite' ),
			'<span style="color:#f18500">' . esc_html__( 'Addons', 'wpforms-lite' ) . '</span>',
			$manage_cap,
			'wpforms-addons',
			array( $this, 'admin_page' )
		);

		// Analytics submenu page.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'Analytics', 'wpforms-lite' ),
			esc_html__( 'Analytics', 'wpforms-lite' ),
			$manage_cap,
			WPForms\Admin\Pages\Analytics::SLUG,
			array( $this, 'admin_page' )
		);

		// SMTP submenu page.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'SMTP', 'wpforms-lite' ),
			esc_html__( 'SMTP', 'wpforms-lite' ),
			$manage_cap,
			WPForms\Admin\Pages\SMTP::SLUG,
			array( $this, 'admin_page' )
		);

		// About submenu page.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'About WPForms', 'wpforms-lite' ),
			esc_html__( 'About Us', 'wpforms-lite' ),
			$access->get_menu_cap( 'any' ),
			WPForms_About::SLUG,
			array( $this, 'admin_page' )
		);

		// Community submenu page.
		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'Community', 'wpforms-lite' ),
			esc_html__( 'Community', 'wpforms-lite' ),
			$manage_cap,
			WPForms\Admin\Pages\Community::SLUG,
			array( $this, 'admin_page' )
		);
	}

	/**
	 * Hide "Add New" admin menu item if a user can't create forms.
	 *
	 * @since 1.5.8
	 */
	public function hide_wpforms_submenu_items() {

		if ( wpforms_current_user_can( 'create_forms' ) ) {
			return;
		}

		global $submenu;

		if ( ! isset( $submenu['wpforms-overview'] ) ) {
			return;
		}

		foreach ( $submenu['wpforms-overview'] as $key => $item ) {
			if ( isset( $item[2] ) && 'wpforms-builder' === $item[2] ) {
				unset( $submenu['wpforms-overview'][ $key ] );
				break;
			}
		}

		$this->hide_wpforms_menu_item();
	}

	/**
	 * Hide "WPForms" admin menu if it has no submenu items.
	 *
	 * @since 1.5.8
	 */
	public function hide_wpforms_menu_item() {

		global $submenu, $menu;

		if ( ! empty( $submenu['wpforms-overview'] ) ) {
			return;
		}

		unset( $submenu['wpforms-overview'] );

		foreach ( $menu as $key => $item ) {
			if ( isset( $item[2] ) && 'wpforms-overview' === $item[2] ) {
				unset( $menu[ $key ] );
				break;
			}
		}
	}

	/**
	 * Wrapper for the hook to render our custom settings pages.
	 *
	 * @since 1.0.0
	 */
	public function admin_page() {
		do_action( 'wpforms_admin_page' );
	}

	/**
	 * Add settings link to the Plugins page.
	 *
	 * @since 1.3.9
	 *
	 * @param array $links Plugin row links.
	 *
	 * @return array $links
	 */
	public function settings_link( $links ) {

		$custom['settings'] = sprintf(
			'<a href="%s" aria-label="%s">%s</a>',
			esc_url(
				add_query_arg(
					array(
						'page' => 'wpforms-settings',
					),
					admin_url( 'admin.php' )
				)
			),
			esc_attr__( 'Go to WPForms Settings page', 'wpforms-lite' ),
			esc_html__( 'Settings', 'wpforms-lite' )
		);

		$custom['support'] = sprintf(
			'<a href="%1$s" aria-label="%2$s" style="font-weight:bold;">%3$s</a>',
			esc_url(
				add_query_arg(
					array(
						'page' => 'wpforms-about',
						'view' => 'versus',
					),
					admin_url( 'admin.php' )
				)
			),
			esc_attr__( 'Go to WPForms Lite vs Pro comparison page', 'wpforms-lite' ),
			esc_html__( 'Premium Support', 'wpforms-lite' )
		);

		return array_merge( $custom, (array) $links );
	}
}

new WPForms_Admin_Menu();
