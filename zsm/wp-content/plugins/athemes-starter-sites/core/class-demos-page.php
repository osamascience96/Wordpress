<?php
/**
 * Demos Page
 *
 * @package Athemes Starter Sites
 * @subpackage Core
 * @version    1.0.0
 * @since      1.0.0
 */

/**
 * Demos Page class.
 */
class ATSS_Demos_Page {

	/**
	 * The slug name to refer to this menu by.
	 *
	 * @var string $menu_slug The menu slug.
	 */
	public $menu_slug = 'starter-sites';

	/**
	 * The dashboard menu slug.
	 *
	 * @var string $dashboard_menu_slug The dashboard menu slug.
	 */
	public $dashboard_menu_slug = 'theme-dashboard';

	/**
	 * The pro_status of theme.
	 *
	 * @var string $pro_status The pro_status.
	 */
	public $pro_status = false;

	/**
	 * The settings of page.
	 *
	 * @var array $settings The settings.
	 */
	public $settings = array(
		'pro_label'  => 'Get Pro',
		'pro_link'   => '#',
		'categories' => array(),
		'builders'   => array(),
	);

	/**
	 * The demos of page.
	 *
	 * @var array $demos The demos.
	 */
	public $demos = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$self = $this;

		add_action( 'init', array( $this, 'set_demos' ) );
		add_action( 'init', array( $this, 'set_settings' ) );

		add_action( 'init', function () use ( $self ) {
			add_action( 'admin_menu', array( $self, 'add_menu_page' ) );
		} );

		add_action( 'wp_ajax_atss_html_import_data', array( $this, 'html_import_data' ) );
		add_action( 'wp_ajax_nopriv_atss_html_import_data', array( $this, 'html_import_data' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_notices', array( $this, 'display_notice' ) );
		add_action( 'wp_ajax_atss_dismissed_handler', array( $this, 'dismissed_handler' ) );

		add_action( 'atss_plugin_activation', array( $this, 'reset_notices' ) );
		add_action( 'atss_plugin_deactivation', array( $this, 'reset_notices' ) );
	}

	/**
	 * Add menu page
	 */
	public function add_menu_page() {
		add_submenu_page( 'themes.php', esc_html__( 'Starter Sites', 'athemes-starter-sites' ), esc_html__( 'Starter Sites', 'athemes-starter-sites' ), 'manage_options', $this->menu_slug, array( $this, 'html_carcase' ), 2 );
	}

	/**
	 * Settings
	 *
	 * @param array $settings The settings.
	 */
	public function set_settings( $settings ) {
		$this->settings = apply_filters( 'atss_register_demos_settings', $this->settings );

		if ( isset( $this->settings['pro_status'] ) ) {
			$this->pro_status = $this->settings['pro_status'];
		}

	}

	/**
	 * Demos
	 *
	 * @param array $demos The demos.
	 */
	public function set_demos( $demos ) {
		$this->demos = apply_filters( 'atss_register_demos_list', $this->demos );
	}

	/**
	 * Html Import Data
	 */
	public function html_import_data() {
		check_ajax_referer( 'nonce', 'nonce' );

		$demo_id = isset( $_POST['demo_id'] ) ? sanitize_text_field( $_POST['demo_id'] ) : false;

		if ( $demo_id ) {

			if ( ! isset( $this->demos[ $demo_id ] ) ) {
				wp_send_json_error( esc_html__( 'Invalid demo content id.', 'athemes-starter-sites' ) );
				wp_die();
			}

			// Reset import data.
			delete_transient( 'atss_importer_data' );

			$demo_data = $this->demos[ $demo_id ];

			ob_start();
			?>
			<div class="atss-import-data">
				<?php if ( isset( $demo_data['plugins'] ) && $demo_data['plugins'] ) { ?>
					<div class="atss-import-plugins">
						<div class="atss-import-subheader">
							<?php esc_html_e( 'Install Plugins', 'athemes-starter-sites' ); ?>
						</div>

						<?php
						foreach ( $demo_data['plugins'] as $plugin ) {
							if ( isset( $plugin['name'] ) ) {
								$name = $plugin['name'];
							} else {
								continue;
							}
							if ( isset( $plugin['slug'] ) ) {
								$slug = $plugin['slug'];
							} else {
								continue;
							}
							if ( isset( $plugin['path'] ) ) {
								$path = $plugin['path'];
							} else {
								continue;
							}

							$required = isset( $plugin['required'] ) ? $plugin['required'] : false;
							?>
							<form>
								<div class="atss-switcher">
									<?php echo esc_html( $plugin['name'] ); ?> <input class="atss-checkbox" type="checkbox" name="<?php echo esc_attr( $plugin['slug'] ); ?>" value="1" <?php echo wp_kses_post( $required ? 'readony onclick="return false;"' : null ); ?> checked>

									<div class="atss-switch"><span class="atss-switch-slider"></span></div>

									<div class="atss-tooltip"><?php esc_html_e( 'Required plugin will be installed', 'athemes-starter-sites' ); ?></div>
								</div>

								<input type="hidden" name="demo_id" value="<?php echo esc_attr( $demo_id ); ?>">

								<input type="hidden" name="plugin_slug" value="<?php echo esc_attr( $plugin['slug'] ); ?>">

								<input type="hidden" name="plugin_path" value="<?php echo esc_attr( $plugin['path'] ); ?>">

								<input type="hidden" name="step_name" value="<?php esc_html_e( 'Installing and activating', 'athemes-starter-sites' ); ?> <?php echo esc_attr( $plugin['name'] ); ?>...">

								<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nonce' ) ); ?>">

								<input type="hidden" name="action" value="atss_import_plugin">
							</form>
						<?php } ?>
					</div>
				<?php } ?>

				<div class="atss-import-content">
					<div class="atss-import-subheader">
						<?php esc_html_e( 'Import Content', 'athemes-starter-sites' ); ?>
					</div>

					<?php if ( isset( $demo_data['import']['content'] ) && $demo_data['import']['content'] ) { ?>
						<form>
							<div class="atss-switcher">
								<?php esc_html_e( 'Content', 'athemes-starter-sites' ); ?> <input class="atss-checkbox" type="checkbox" name="url" value="<?php echo esc_attr( $demo_data['import']['content'] ); ?>" checked>

								<div class="atss-switch"><span class="atss-switch-slider"></span></div>

								<input type="hidden" name="demo_id" value="<?php echo esc_attr( $demo_id ); ?>">

								<input type="hidden" name="step_name" value="<?php esc_html_e( 'Importing contents...', 'athemes-starter-sites' ); ?>">

								<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nonce' ) ); ?>">

								<input type="hidden" name="action" value="atss_import_contents">
							</div>
						</form>
					<?php } ?>

					<?php if ( isset( $demo_data['import']['widgets'] ) && $demo_data['import']['widgets'] ) { ?>
						<form>
							<div class="atss-switcher">
								<?php esc_html_e( 'Widgets', 'athemes-starter-sites' ); ?> <input class="atss-checkbox" type="checkbox" name="url" value="<?php echo esc_attr( $demo_data['import']['widgets'] ); ?>" checked>

								<div class="atss-switch"><span class="atss-switch-slider"></span></div>
							</div>

							<input type="hidden" name="demo_id" value="<?php echo esc_attr( $demo_id ); ?>">

							<input type="hidden" name="step_name" value="<?php esc_html_e( 'Importing widgets...', 'athemes-starter-sites' ); ?>">

							<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nonce' ) ); ?>">

							<input type="hidden" name="action" value="atss_import_widgets">
						</form>
					<?php } ?>

					<?php if ( isset( $demo_data['import']['customizer'] ) && $demo_data['import']['customizer'] ) { ?>
						<form>
							<div class="atss-switcher">
								<?php esc_html_e( 'Customizer', 'athemes-starter-sites' ); ?> <input class="atss-checkbox" type="checkbox" name="url" value="<?php echo esc_attr( $demo_data['import']['customizer'] ); ?>" checked>

								<div class="atss-switch"><span class="atss-switch-slider"></span></div>
							</div>

							<input type="hidden" name="demo_id" value="<?php echo esc_attr( $demo_id ); ?>">

							<input type="hidden" name="step_name" value="<?php esc_html_e( 'Importing customizer options...', 'athemes-starter-sites' ); ?>">

							<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nonce' ) ); ?>">

							<input type="hidden" name="action" value="atss_import_customizer">
						</form>
					<?php } ?>

					<?php if ( isset( $demo_data['import']['options'] ) && $demo_data['import']['options'] ) { ?>
						<form>
							<div class="atss-switcher">
								<?php esc_html_e( 'Options', 'athemes-starter-sites' ); ?> <input class="atss-checkbox" type="checkbox" name="url" value="<?php echo esc_attr( $demo_data['import']['options'] ); ?>" checked>

								<div class="atss-switch"><span class="atss-switch-slider"></span></div>
							</div>

							<input type="hidden" name="step_name" value="<?php esc_html_e( 'Importing options...', 'athemes-starter-sites' ); ?>">

							<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nonce' ) ); ?>">

							<input type="hidden" name="action" value="atss_import_options">
						</form>
					<?php } ?>

					<form class="hidden">
						<div class="atss-switcher">
							<?php esc_html_e( 'Finish', 'athemes-starter-sites' ); ?> <input class="atss-checkbox" type="checkbox" name="finish" value="1" checked>

							<div class="atss-switch"><span class="atss-switch-slider"></span></div>
						</div>

						<input type="hidden" name="step_name" value="<?php esc_html_e( 'Finishing setup...', 'athemes-starter-sites' ); ?>">

						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'nonce' ) ); ?>">

						<input type="hidden" name="action" value="atss_import_finish">
					</form>
				</div>
			</div>

			<div class="atss-import-actions">
				<div class="atss-import-theme-cancel">
					<a href="#" class="atss-button atss-demo-import-close button">
						<?php esc_html_e( 'Cancel', 'athemes-starter-sites' ); ?>
					</a>
				</div>

				<div class="atss-import-theme-start">
					<a href="#" class="atss-demo-import-start button button-primary">
						<?php esc_html_e( 'Import', 'athemes-starter-sites' ); ?>
					</a>
				</div>
			</div>
			<?php
			wp_send_json_success( ob_get_clean() );
		} else {
			wp_send_json_error( esc_html__( 'Demo content id not set.', 'athemes-starter-sites' ) );
		}

		wp_die();
	}

	/**
	 * Html Carcase
	 */
	public function html_carcase() {
		?>
		<div class="atss-wrap atss-demos-page">
			<div class="atss-header">
				<div class="atss-header-left">
					<div class="atss-header-col atss-header-col-logo">
						<div class="atss-logo">
							<a target="_blank" href="<?php echo esc_url( 'https://athemes.com/'); ?>">
								<img width="96px" height="24px" src="<?php echo esc_url( ATSS_URL . 'assets/images/logo.svg' ); ?>" alt="<?php esc_html_e( 'aThemes', 'athemes-starter-sites' ); ?>">
							</a>
						</div>
					</div>

					<?php if ( isset( $this->settings['categories'] ) && $this->settings['categories'] ) { ?>
						<div class="atss-header-col atss-header-col-categories">
							<div class="atss-categories">
								<select class="atss-select atss-categories-select">
									<optgroup label="<?php esc_html_e( 'Select Category', 'athemes-starter-sites' ); ?>">
										<option value=""><?php esc_html_e( 'All Categories', 'athemes-starter-sites' ); ?></option>

										<?php
										foreach ( $this->settings['categories'] as $slug => $name ) {
											?>
												<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></option>
											<?php
										}
										?>
									</optgroup>
								</select>
							</div>
						</div>
					<?php } ?>

					<?php if ( isset( $this->settings['builders'] ) && $this->settings['builders'] ) { ?>
						<div class="atss-header-col atss-header-col-builders">
							<div class="atss-builders">
								<select class="atss-select atss-builders-select">
									<optgroup label="<?php esc_html_e( 'Select Page Builder', 'athemes-starter-sites' ); ?>">
										<option value=""><?php esc_html_e( 'All Builders', 'athemes-starter-sites' ); ?></option>

										<?php
										foreach ( $this->settings['builders'] as $slug => $name ) {
											$image = null;
											if ( 'elementor' === $slug ) {
												$image = ATSS_URL . 'assets/images/elementor.png';
											}
											if ( 'gutenberg' === $slug ) {
												$image = ATSS_URL . 'assets/images/gutenberg.png';
											}
											?>
												<option data-image="<?php echo esc_url( $image ); ?>" value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></option>
											<?php
										}
										?>
									</optgroup>
								</select>
							</div>
						</div>
					<?php } ?>
				</div>

				<?php if ( ! $this->pro_status ) { ?>
					<div class="atss-header-right">
						<div class="atss-get-pro-version">
							<a target="_blank" href="<?php echo esc_url( $this->settings['pro_link'] ); ?>" class="button button-primary">
								<?php echo esc_html( $this->settings['pro_label'] ); ?>
							</a>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="wrap">
				<h1 class="hidden"><?php esc_html_e( 'Starter Sites', 'athemes-starter-sites' ); ?></h1>

				<?php
				if ( $this->demos ) {
					?>
					<div class="atss-demos">
						<?php
						foreach ( $this->demos as $demo_id => $demo ) {
							// Demo Variables.
							$name    = isset( $demo['name'] ) && $demo['name'] ? $demo['name'] : null;
							$type    = isset( $demo['type'] ) && $demo['type'] ? $demo['type'] : null;
							$builder = isset( $demo['builder'] ) && $demo['builder'] ? $demo['builder'] : null;
							$preview = isset( $demo['preview'] ) && $demo['preview'] ? $demo['preview'] : 'false';

							// Categories.
							$categories = '[]';

							if ( isset( $demo['categories'] ) && $demo['categories'] ) {
								foreach ( $demo['categories'] as $category ) {
									$categories .= sprintf( '[%s]', $category );
								}
							}
							// Builders.
							$builders = '[]';

							if ( isset( $demo['builders'] ) && $demo['builders'] ) {
								foreach ( $demo['builders'] as $builder ) {
									$builders .= sprintf( '[%s]', $builder );
								}
							}
							?>
							<div class="atss-demo-item atss-demo-item-active"
								data-id="<?php echo esc_attr( $demo_id ); ?>"
								data-name="<?php echo esc_attr( $name ); ?>"
								data-type="<?php echo esc_attr( $type ); ?>"
								data-categories="<?php echo esc_attr( $categories ); ?>"
								data-builders="<?php echo esc_attr( $builders ); ?>"
								data-preview="<?php echo esc_url( $preview ); ?>">

								<div class="atss-demo-outer">
									<div class="atss-demo-thumbnail">
										<?php if ( isset( $demo['thumbnail'] ) && $demo['thumbnail'] ) { ?>
											<img src="<?php echo esc_url( $demo['thumbnail'] ); ?>">
										<?php } ?>

										<?php if ( isset( $demo['preview'] ) && $demo['preview'] ) { ?>
											<div class="atss-demo-preview">
												<span>
													<?php esc_html_e( 'Preview Demo', 'athemes-starter-sites' ); ?>
												</span>
											</div>
										<?php } ?>
									</div>
									<div class="atss-demo-data">
										<div class="atss-demo-info">
											<?php if ( isset( $demo['name'] ) && $demo['name'] ) { ?>
												<div class="atss-demo-name"><?php echo esc_html( $demo['name'] ); ?></div>
											<?php } ?>

											<?php if ( ! $this->pro_status && isset( $demo['type'] ) && $demo['type'] ) { ?>
												<?php if ( 'free' === $demo['type'] ) { ?>
													<div class="atss-demo-badge atss-badge atss-badge-success"><?php echo esc_html( $demo['type'] ); ?></div>
												<?php } ?>

												<?php if ( 'pro' === $demo['type'] ) { ?>
													<div class="atss-demo-badge atss-badge atss-badge-info"><?php echo esc_html( $demo['type'] ); ?></div>
												<?php } ?>
											<?php } ?>
										</div>

										<?php if ( isset( $demo['type'] ) && $demo['type'] ) { ?>
											<div class="atss-demo-actions">
												<?php if ( $this->pro_status || 'free' === $demo['type'] ) { ?>
													<div class="atss-demo-import">
														<a href="#" target="_blank" data-id="<?php echo esc_attr( $demo_id ); ?>" class="atss-demo-import-open button button-primary">
															<?php esc_html_e( 'Import', 'athemes-starter-sites' ); ?>
														</a>
													</div>
												<?php } ?>

												<?php if ( ! $this->pro_status && 'pro' === $demo['type'] ) { ?>
													<div class="atss-demo-pro-version">
														<a href="<?php echo esc_url( $this->settings['pro_link'] ); ?>" target="_blank" class="atss-demo-import-url button button-primary">
															<?php esc_html_e( 'Get Pro', 'athemes-starter-sites' ); ?>
														</a>
													</div>
												<?php } ?>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>

			<div class="atss-import-theme">
				<div class="atss-import-overlay"></div>

				<div class="atss-import-popup">
					<div class="atss-import-container">
						<div class="atss-import-step atss-import-step-active atss-import-start">
							<div class="atss-import-header">
								<?php esc_html_e( 'Import Theme', 'athemes-starter-sites' ); ?>
							</div>

							<div class="atss-import-output"></div>
						</div>

						<div class="atss-import-step atss-import-process">
							<div class="atss-import-header">
								<?php esc_html_e( 'Installing', 'athemes-starter-sites' ); ?>
							</div>

							<div class="atss-import-output">
								<div class="atss-import-desc">
									<?php esc_html_e( 'Please be patient and don\'t refresh this page, the import process may take a while, this also depends on your server.', 'athemes-starter-sites' ); ?>
								</div>

								<div class="atss-import-progress">
									<div class="atss-import-progress-label"></div>

									<div class="atss-import-progress-bar">
										<div class="atss-import-progress-indicator" style="--atss-indicator: 0%;"></div>
									</div>

									<div class="atss-import-progress-sublabel">0%</div>
								</div>
							</div>
						</div>

						<div class="atss-import-step atss-import-finish">
							<div class="atss-import-info">
								<div class="atss-import-logo">
									<svg class="progress-icon" width="96" height="96" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
										<g class="tick-icon" stroke-width="1" stroke="#3FB28F" transform="translate(1, 1.2)">
										<path id="tick-outline-path" d="M14 28c7.732 0 14-6.268 14-14S21.732 0 14 0 0 6.268 0 14s6.268 14 14 14z" opacity="0" />
										<path id="tick-path" d="M6.173 16.252l5.722 4.228 9.22-12.69" opacity="0"/>
										</g>
									</svg>
								</div>

								<div class="atss-import-title">
									<?php esc_html_e( 'Imported Successfully', 'athemes-starter-sites' ); ?>
								</div>

								<div class="atss-import-desc">
									<?php esc_html_e( 'Go ahead, customize the text, images and design to make it yours!', 'athemes-starter-sites' ); ?>
								</div>

								<div class="atss-import-customize">
									<a href="<?php echo esc_url( admin_url( '/customize.php' ) ); ?>" class="button button-primary" target="_blank">
										<?php esc_html_e( 'Customize', 'athemes-starter-sites' ); ?>
									</a>
								</div>
							</div>

							<div class="atss-import-actions">
								<a href="<?php echo esc_url( add_query_arg( 'page', $this->dashboard_menu_slug, admin_url( 'themes.php' ) ) ); ?>" class="atss-link">
									<?php esc_html_e( 'Return to Dashboard', 'athemes-starter-sites' ); ?>
								</a>

								<a href="<?php echo esc_url( home_url() ); ?>" class="atss-button button" target="_blank">
									<?php esc_html_e( 'View Site', 'athemes-starter-sites' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="atss-preview">
				<div class="atss-header">
					<div class="atss-header-left">
						<div class="atss-header-col atss-header-logo">
							<div class="atss-logo">
								<a target="_blank" href="<?php echo esc_url( 'https://athemes.com/' ); ?>">
									<img width="96px" height="24px" src="<?php echo esc_url( ATSS_URL . '/assets/images/logo.svg' ); ?>" alt="<?php esc_html_e( 'aThemes', 'athemes-starter-sites' ); ?>">
								</a>
							</div>
						</div>

						<div class="atss-header-col atss-header-arrow">
							<a href="#" class="atss-arrow atss-prev-demo"></a>
						</div>

						<div class="atss-header-col atss-header-arrow">
							<a href="#" class="atss-arrow atss-next-demo"></a>
						</div>

						<div class="atss-header-col atss-header-info"></div>
					</div>

					<div class="atss-header-right">
						<div class="atss-preview-cancel">
							<a href="#" class="button">
								<?php esc_html_e( 'Cancel', 'athemes-starter-sites' ); ?>
							</a>
						</div>

						<div class="atss-preview-actions"></div>
					</div>
				</div>

				<iframe class="atss-preview-iframe"></iframe>
			</div>
		</div>
		<?php
	}

	/**
	 * Is template of aThemes
	 */
	public function is_athemes_template() {
		$theme = wp_get_theme()->get( 'Name' );

		if ( wp_get_theme()->parent() ) {
			$theme = wp_get_theme()->parent()->get( 'Name' );
		}

		$list = array(
			'Airi',
			'Sydney',
			'Sydney Pro',
			'Botiga',
		);

		foreach ( $list as $name ) {
			if ( $theme === $name ) {
				return true;
			}
		}
	}

	/**
	 * Display a notification.
	 */
	public function display_notice() {

		if ( ! $this->is_athemes_template() ) {
			// Set transient name.
			$transient_name = sprintf( '%s_no_active_theme', $this->menu_slug );

			if ( ! get_transient( $transient_name ) ) {
				?>
				<div class="atss-notice notice notice-warning is-dismissible" data-notice="<?php echo esc_attr( $transient_name ); ?>">
					<p>
					<?php
						// Translators: Link.
						echo wp_kses( sprintf( __( 'aThemes Sites Import (plugin) requires an %1$s theme to be installed and activated.', 'athemes-starter-sites' ), '<a href="https://athemes.com/" target="_blank">' . __( 'aThemes', 'athemes-starter-sites' ) . '</a>' ), 'post' );
					?>
					</p>
				</div>
				<?php
			}
		}
	}

	/**
	 * Purified from the database information about notification.
	 */
	public function reset_notices() {
		delete_transient( sprintf( '%s_no_active_theme', $this->menu_slug ) );
	}

	/**
	 * Dismissed handler
	 */
	public function dismissed_handler() {
		wp_verify_nonce( null );

		if ( isset( $_POST['notice'] ) ) { // Input var ok; sanitization ok.
			set_transient( sanitize_text_field( wp_unslash( $_POST['notice'] ) ), true, 90 * DAY_IN_SECONDS ); // Input var ok.
		}
	}

	/**
	 *  Enqunue Scripts
	 *
	 * @param string $page Current page.
	 */
	public function enqueue_scripts( $page ) {
		wp_enqueue_script( 'jquery' );

		ob_start();
		?>
		<script>
			jQuery(function($) {
				$( document ).on( 'click', '.atss-notice .notice-dismiss', function () {
					jQuery.post( 'ajax_url', {
						action: 'atss_dismissed_handler',
						notice: $( this ).closest( '.atss-notice' ).data( 'notice' ),
					});
				} );
			});
		</script>
		<?php
		$script = str_replace( 'ajax_url', admin_url( 'admin-ajax.php' ), ob_get_clean() );

		wp_add_inline_script( 'jquery', str_replace( array( '<script>', '</script>' ), '', $script ) );
	}
}

new ATSS_Demos_Page();
