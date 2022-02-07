<?php
/**
 * Global admin related items and functionality.
 *
 * @since 1.3.9
 */

/**
 * Load styles for all WPForms-related admin screens.
 *
 * @since 1.3.9
 */
function wpforms_admin_styles() {

	if ( ! wpforms_is_admin_page() ) {
		return;
	}

	$min = wpforms_get_min_suffix();

	// jQuery confirm.
	wp_enqueue_style(
		'jquery-confirm',
		WPFORMS_PLUGIN_URL . 'assets/css/jquery-confirm.min.css',
		array(),
		'3.3.2'
	);

	// Minicolors (color picker).
	wp_enqueue_style(
		'minicolors',
		WPFORMS_PLUGIN_URL . 'assets/css/jquery.minicolors.css',
		array(),
		'2.2.6'
	);

	// FontAwesome.
	wp_enqueue_style(
		'wpforms-font-awesome',
		WPFORMS_PLUGIN_URL . 'assets/css/font-awesome.min.css',
		null,
		'4.7.0'
	);

	// Main admin styles.
	wp_enqueue_style(
		'wpforms-admin',
		WPFORMS_PLUGIN_URL . "assets/css/admin{$min}.css",
		array(),
		WPFORMS_VERSION
	);

	// Remove TinyMCE editor styles from third-party themes and plugins.
	remove_editor_styles();

	// WordPress 5.7 color set.
	if ( version_compare( get_bloginfo( 'version' ), '5.7', '>=' ) ) {
		wp_enqueue_style(
			'wpforms-admin-wp5.7-color',
			WPFORMS_PLUGIN_URL . "assets/css/admin-wp5.7-colors{$min}.css",
			[ 'wpforms-admin' ],
			WPFORMS_VERSION
		);
	}
}
add_action( 'admin_enqueue_scripts', 'wpforms_admin_styles' );

/**
 * Load scripts for all WPForms-related admin screens.
 *
 * @since 1.3.9
 */
function wpforms_admin_scripts() {

	if ( ! wpforms_is_admin_page() ) {
		return;
	}

	$min = wpforms_get_min_suffix();

	wp_enqueue_media();

	// jQuery confirm.
	wp_enqueue_script(
		'jquery-confirm',
		WPFORMS_PLUGIN_URL . 'assets/js/jquery.jquery-confirm.min.js',
		[ 'jquery' ],
		'3.3.2',
		false
	);

	// Minicolors (color picker).
	wp_enqueue_script(
		'minicolors',
		WPFORMS_PLUGIN_URL . 'assets/js/jquery.minicolors.min.js',
		[ 'jquery' ],
		'2.2.6',
		false
	);

	// Choices.js.
	wp_enqueue_script(
		'choicesjs',
		WPFORMS_PLUGIN_URL . 'assets/js/choices.min.js',
		[],
		'9.0.1',
		false
	);

	// jQuery Conditionals.
	wp_enqueue_script(
		'jquery-conditionals',
		WPFORMS_PLUGIN_URL . 'assets/js/jquery.conditionals.min.js',
		[ 'jquery' ],
		'1.0.1',
		false
	);

	// Main admin script.
	wp_enqueue_script(
		'wpforms-admin',
		WPFORMS_PLUGIN_URL . "assets/js/admin{$min}.js",
		[ 'jquery' ],
		WPFORMS_VERSION,
		false
	);

	$strings = [
		'addon_activate'                  => esc_html__( 'Activate', 'wpforms-lite' ),
		'addon_activated'                 => esc_html__( 'Activated', 'wpforms-lite' ),
		'addon_active'                    => esc_html__( 'Active', 'wpforms-lite' ),
		'addon_deactivate'                => esc_html__( 'Deactivate', 'wpforms-lite' ),
		'addon_inactive'                  => esc_html__( 'Inactive', 'wpforms-lite' ),
		'addon_install'                   => esc_html__( 'Install Addon', 'wpforms-lite' ),
		'addon_error'                     => esc_html__( 'Could not install the addon. Please download it from wpforms.com and install it manually.', 'wpforms-lite' ),
		'plugin_error'                    => esc_html__( 'Could not install the plugin automatically. Please download and install it manually.', 'wpforms-lite' ),
		'addon_search'                    => esc_html__( 'Searching Addons', 'wpforms-lite' ),
		'ajax_url'                        => admin_url( 'admin-ajax.php' ),
		'cancel'                          => esc_html__( 'Cancel', 'wpforms-lite' ),
		'close'                           => esc_html__( 'Close', 'wpforms-lite' ),
		'entry_delete_confirm'            => esc_html__( 'Are you sure you want to delete this entry and all its information (files, notes, logs, etc.)?', 'wpforms-lite' ),
		'entry_delete_all_confirm'        => esc_html__( 'Are you sure you want to delete ALL entries and all their information (files, notes, logs, etc.)?', 'wpforms-lite' ),
		'entry_delete_n_confirm'          => sprintf( /* translators: %s - entry count. */
			esc_html__( 'Are you sure you want to delete %s entry(s) and all the information (files, notes, logs, etc.)?', 'wpforms-lite' ),
			'{entry_count}'
		),
		'entry_empty_fields_hide'         => esc_html__( 'Hide Empty Fields', 'wpforms-lite' ),
		'entry_empty_fields_show'         => esc_html__( 'Show Empty Fields', 'wpforms-lite' ),
		'entry_field_columns'             => esc_html__( 'Entries Field Columns', 'wpforms-lite' ),
		'entry_note_delete_confirm'       => esc_html__( 'Are you sure you want to delete this note?', 'wpforms-lite' ),
		'entry_unstar'                    => esc_html__( 'Unstar entry', 'wpforms-lite' ),
		'entry_star'                      => esc_html__( 'Star entry', 'wpforms-lite' ),
		'entry_read'                      => esc_html__( 'Mark entry read', 'wpforms-lite' ),
		'entry_unread'                    => esc_html__( 'Mark entry unread', 'wpforms-lite' ),
		'form_delete_confirm'             => esc_html__( 'Are you sure you want to delete this form and all its information?', 'wpforms-lite' ),
		'form_duplicate_confirm'          => esc_html__( 'Are you sure you want to duplicate this form?', 'wpforms-lite' ),
		'heads_up'                        => esc_html__( 'Heads up!', 'wpforms-lite' ),
		'importer_forms_required'         => esc_html__( 'Please select at least one form to import.', 'wpforms-lite' ),
		'isPro'                           => wpforms()->pro,
		'nonce'                           => wp_create_nonce( 'wpforms-admin' ),
		'almost_done'                     => esc_html__( 'Almost Done', 'wpforms-lite' ),
		'oops'                            => esc_html__( 'Oops!', 'wpforms-lite' ),
		'ok'                              => esc_html__( 'OK', 'wpforms-lite' ),
		'plugin_install_activate_btn'     => esc_html__( 'Install and Activate', 'wpforms-lite' ),
		'plugin_install_activate_confirm' => esc_html__( 'needs to be installed and activated to import its forms. Would you like us to install and activate it for you?', 'wpforms-lite' ),
		'plugin_activate_btn'             => esc_html__( 'Activate', 'wpforms-lite' ),
		'plugin_activate_confirm'         => esc_html__( 'needs to be activated to import its forms. Would you like us to activate it for you?', 'wpforms-lite' ),
		'provider_delete_confirm'         => esc_html__( 'Are you sure you want to disconnect this account?', 'wpforms-lite' ),
		'provider_delete_error'           => esc_html__( 'Could not disconnect this account.', 'wpforms-lite' ),
		'provider_auth_error'             => esc_html__( 'Could not authenticate with the provider.', 'wpforms-lite' ),
		'save_refresh'                    => esc_html__( 'Save and Refresh', 'wpforms-lite' ),
		'server_error'                    => esc_html__( 'Unfortunately there was a server connection error.', 'wpforms-lite' ),
		'settings_form_style_base'        => sprintf(
			wp_kses( /* translators: %s - WPForms.com docs page URL. */
				__( 'You\'ve selected <strong>Base Styling Only</strong>, which may result in styling issues. <a href="%s" target="_blank" rel="noopener noreferrer">Please check out our tutorial</a> for common issues and recommendations.', 'wpforms-lite' ),
				[
					'strong' => [],
					'a'      => [
						'href'   => [],
						'target' => [],
						'rel'    => [],
					],
				]
			),
			'https://wpforms.com/docs/how-to-choose-an-include-form-styling-setting/'
		),
		'settings_form_style_none'        => sprintf(
			wp_kses( /* translators: %s - WPForms.com docs page URL. */
				__( 'You\'ve selected <strong>No Styling</strong>, which will likely result in significant styling issues and is recommended only for developers. <a href="%s" target="_blank" rel="noopener noreferrer">Please check out our tutorial</a> for more details and recommendations.', 'wpforms-lite' ),
				[
					'strong' => [],
					'a'      => [
						'href'   => [],
						'target' => [],
						'rel'    => [],
					],
				]
			),
			'https://wpforms.com/docs/how-to-choose-an-include-form-styling-setting/'
		),
		'testing'                         => esc_html__( 'Testing', 'wpforms-lite' ),
		'upgrade_completed'               => esc_html__( 'Upgrade was successfully completed!', 'wpforms-lite' ),
		'upload_image_title'              => esc_html__( 'Upload or Choose Your Image', 'wpforms-lite' ),
		'upload_image_button'             => esc_html__( 'Use Image', 'wpforms-lite' ),
		'upgrade_modal'                   => wpforms_get_upgrade_modal_text(),
		'choicesjs_loading'               => esc_html__( 'Loading...', 'wpforms-lite' ),
		'choicesjs_no_results'            => esc_html__( 'No results found', 'wpforms-lite' ),
		'choicesjs_no_choices'            => esc_html__( 'No choices to choose from', 'wpforms-lite' ),
		'choicesjs_item_select'           => esc_html__( 'Press to select', 'wpforms-lite' ),
		'debug'                           => wpforms_debug(),
		'edit_license'                    => esc_html__( 'To edit the License Key, please first click the Deactivate Key button. Please note that deactivating this key will remove access to updates, addons, and support.', 'wpforms-lite' ),
		'something_went_wrong'            => esc_html__( 'Something went wrong', 'wpforms-lite' ),
	];
	$strings = apply_filters( 'wpforms_admin_strings', $strings );

	wp_localize_script(
		'wpforms-admin',
		'wpforms_admin',
		$strings
	);
}

add_action( 'admin_enqueue_scripts', 'wpforms_admin_scripts' );

/**
 * Add body class to WPForms admin pages for easy reference.
 *
 * @since 1.3.9
 *
 * @param string $classes CSS classes, space separated.
 *
 * @return string
 */
function wpforms_admin_body_class( $classes ) {

	if ( ! wpforms_is_admin_page() ) {
		return $classes;
	}

	return "$classes wpforms-admin-page";
}

add_filter( 'admin_body_class', 'wpforms_admin_body_class', 10, 1 );

/**
 * Output the WPForms admin header.
 *
 * @since 1.3.9
 */
function wpforms_admin_header() {

	// Bail if we're not on a WPForms screen or page (also exclude form builder).
	if ( ! wpforms_is_admin_page() ) {
		return;
	}

	if ( ! apply_filters( 'wpforms_admin_header', true ) ) {
		return;
	}

	// Omit header from Welcome activation screen.
	if ( 'wpforms-getting-started' === $_REQUEST['page'] ) {
		return;
	}

	do_action( 'wpforms_admin_header_before' );
	?>
	<div id="wpforms-header-temp"></div>
	<div id="wpforms-header" class="wpforms-header">
		<img class="wpforms-header-logo" src="<?php echo WPFORMS_PLUGIN_URL; ?>assets/images/logo.png" alt="WPForms Logo"/>
	</div>
	<?php
	do_action( 'wpforms_admin_header_after' );
}

add_action( 'in_admin_header', 'wpforms_admin_header', 100 );

/**
 * Remove non-WPForms notices from WPForms pages.
 *
 * @since 1.3.9
 * @since 1.6.9 Added callback for removing on `admin_footer` hook.
 */
function wpforms_admin_hide_unrelated_notices() { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.MaxExceeded, Generic.Metrics.NestingLevel.MaxExceeded

	if ( ! wpforms_is_admin_page() ) {
		return;
	}

	global $wp_filter;

	// Define rules to remove callbacks.
	$rules = [
		'user_admin_notices' => [], // remove all callbacks.
		'admin_notices'      => [],
		'all_admin_notices'  => [],
		'admin_footer'       => [
			'render_delayed_admin_notices', // remove this particular callback.
		],
	];

	// Extra deny callbacks (will be removed for each hook tag defined in $rules).
	$common_deny_callbacks = [
		'wpformsdb_admin_notice', // 'Database for WPForms' plugin.
	];

	$notice_types = array_keys( $rules );

	foreach ( $notice_types as $notice_type ) {
		if ( empty( $wp_filter[ $notice_type ]->callbacks ) || ! is_array( $wp_filter[ $notice_type ]->callbacks ) ) {
			continue;
		}

		$remove_all_filters = empty( $rules[ $notice_type ] );

		foreach ( $wp_filter[ $notice_type ]->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( is_object( $arr['function'] ) && is_callable( $arr['function'] ) ) {
					if ( $remove_all_filters ) {
						unset( $wp_filter[ $notice_type ]->callbacks[ $priority ][ $name ] );
					}
					continue;
				}

				$class = ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) ? strtolower( get_class( $arr['function'][0] ) ) : '';

				// Remove all callbacks except WPForms notices.
				if ( $remove_all_filters && strpos( $class, 'wpforms' ) === false ) {
					unset( $wp_filter[ $notice_type ]->callbacks[ $priority ][ $name ] );
					continue;
				}

				$cb = is_array( $arr['function'] ) ? $arr['function'][1] : $arr['function'];

				// Remove a specific callback.
				if ( ! $remove_all_filters ) {
					if ( in_array( $cb, $rules[ $notice_type ], true ) ) {
						unset( $wp_filter[ $notice_type ]->callbacks[ $priority ][ $name ] );
					}
					continue;
				}

				// Remove non-WPForms callbacks from `$common_deny_callbacks` denylist.
				if ( in_array( $cb, $common_deny_callbacks, true ) ) {
					unset( $wp_filter[ $notice_type ]->callbacks[ $priority ][ $name ] );
				}
			}
		}
	}
}
add_action( 'admin_print_scripts', 'wpforms_admin_hide_unrelated_notices' );

/**
 * Upgrade link used within the various admin pages.
 *
 * Previously was only included as a method in wpforms-lite.php, but made
 * available globally in 1.3.9.
 *
 * @since 1.3.9
 *
 * @param string $medium  URL parameter: utm_medium.
 * @param string $content URL parameter: utm_content.
 *
 * @return string.
 */
function wpforms_admin_upgrade_link( $medium = 'link', $content = '' ) {

	$medium      = apply_filters( 'wpforms_upgrade_link_medium', $medium );
	$license_key = wpforms_get_license_key();

	if ( wpforms()->pro ) {
		$upgrade = add_query_arg(
			[
				'utm_source'   => 'WordPress',
				'utm_campaign' => 'plugin',
				'utm_medium'   => $medium,
				'license_key'  => sanitize_text_field( $license_key ),
			],
			'https://wpforms.com/pricing/'
		);
	} else {
		$upgrade = add_query_arg(
			[
				'discount'     => 'LITEUPGRADE',
				'utm_source'   => 'WordPress',
				'utm_campaign' => 'liteplugin',
				'utm_medium'   => $medium,
			],
			'https://wpforms.com/lite-upgrade/'
		);
	}

	if ( ! empty( $content ) ) {
		$upgrade = add_query_arg( 'utm_content', $content, $upgrade );
	}

	return apply_filters( 'wpforms_upgrade_link', $upgrade );
}

/**
 * Check the current PHP version and display a notice if on unsupported PHP.
 *
 * @since 1.4.0.1
 * @since 1.5.0 Raising this awareness of old PHP version message from 5.2 to 5.3.
 */
function wpforms_check_php_version() {

	// Display for PHP below 5.6.
	if ( version_compare( PHP_VERSION, '5.5', '>=' ) ) {
		return;
	}

	// Display for admins only.
	if ( ! is_super_admin() ) {
		return;
	}

	// Display on Dashboard page only.
	if ( isset( $GLOBALS['pagenow'] ) && 'index.php' !== $GLOBALS['pagenow'] ) {
		return;
	}

	// Display the notice, finally.
	\WPForms\Admin\Notice::error(
		'<p>' .
		sprintf(
			wp_kses( /* translators: %1$s - WPForms plugin name; %2$s - WPForms.com URL to a related doc. */
				__( 'Your site is running an outdated version of PHP that is no longer supported and may cause issues with %1$s. <a href="%2$s" target="_blank" rel="noopener noreferrer">Read more</a> for additional information.', 'wpforms-lite' ),
				[
					'a' => [
						'href'   => [],
						'target' => [],
						'rel'    => [],
					],
				]
			),
			'<strong>WPForms</strong>',
			'https://wpforms.com/docs/supported-php-version/'
		) .
		'<br><br><em>' .
		wp_kses(
			__( '<strong>Please Note:</strong> Support for PHP 5.5 will be discontinued in 2020. After this, if no further action is taken, WPForms functionality will be disabled.', 'wpforms-lite' ),
			[
				'strong' => [],
				'em'     => [],
			]
		) .
		'</em></p>'
	);
}
add_action( 'admin_init', 'wpforms_check_php_version' );

/**
 * Get an upgrade modal text.
 *
 * @since 1.4.4
 *
 * @param string $type Either "pro" or "elite". Default is "pro".
 *
 * @return string
 */
function wpforms_get_upgrade_modal_text( $type = 'pro' ) {

	switch ( $type ) {
		case 'elite':
			$level = 'WPForms Elite';
			break;
		case 'pro':
		default:
			$level = 'WPForms Pro';
	}

	return
		'<p>' .
		sprintf( /* translators: %s - license level, WPForms Pro or WPForms Elite. */
			esc_html__( 'Thanks for your interest in %s!', 'wpforms-lite' ),
			$level
		) . '<br>' .
		sprintf(
			wp_kses(
				/* translators: %s - WPForms.com contact page URL. */
				__( 'If you have any questions or issues just <a href="%s" target="_blank" rel="noopener noreferrer">let us know</a>.', 'wpforms-lite' ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
						'rel'    => array(),
					),
				)
			),
			'https://wpforms.com/contact/'
		) .
		'</p>' .
		'<p>' .
		sprintf(
			wp_kses( /* translators: %s - license level, WPForms Pro or WPForms Elite. */
				__( 'After purchasing a license,<br>just <strong>enter your license key on the WPForms Settings page</strong>.<br>This will let your site automatically upgrade to %s!', 'wpforms-lite' ),
				[
					'strong' => [],
					'br'     => [],
				]
			),
			$level
		) . '<br>' .
		esc_html__( '(Don\'t worry, all your forms and settings will be preserved.)', 'wpforms-lite' ) .
		'</p>' .
		'<p>' .
		sprintf(
			wp_kses( /* translators: %s - WPForms.com upgrade from Lite to paid docs page URL. */
				__( 'Check out <a href="%s" target="_blank" rel="noopener noreferrer">our documentation</a> for step-by-step instructions.', 'wpforms-lite' ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
						'rel'    => array(),
					),
				)
			),
			'https://wpforms.com/docs/upgrade-wpforms-lite-paid-license/?utm_source=WordPress&amp;utm_medium=link&amp;utm_campaign=liteplugin'
		) .
		'</p>';
}

/**
 * Hide the wp-admin area "Version x.x" in footer on WPForms pages.
 *
 * @since 1.5.7
 *
 * @param string $text Default "Version x.x" or "Get Version x.x" text.
 *
 * @return string
 */
function wpforms_admin_hide_wp_version( $text ) {

	// Reset text if we're not on a WPForms screen or page.
	if ( wpforms_is_admin_page() ) {
		return '';
	}

	return $text;
}
add_filter( 'update_footer', 'wpforms_admin_hide_wp_version', PHP_INT_MAX );
