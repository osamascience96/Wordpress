<?php
/**
 * Display conditions script template
 *
 * @package Sydney
 */

function sydney_display_conditions_script_template() {

	$settings = array();

	$settings['types'][] = array(
		'id'   => 'include',
		'text' => esc_html__( 'Include', 'sydney' ),
	);

	$settings['types'][] = array(
		'id'   => 'exclude',
		'text' => esc_html__( 'Exclude', 'sydney' ),
	);

	$settings['display'][] = array(
		'id'   => 'all',
		'text' => esc_html__( 'Entire Site', 'sydney' ),
	);

	$settings['display'][] = array(
		'id'      => 'basic',
		'text'    => esc_html__( 'Basic', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'singular',
				'text' => esc_html__( 'Singulars', 'sydney' ),
			),
			array(
				'id'   => 'archive',
				'text' => esc_html__( 'Archives', 'sydney' ),
			),
		),
	);

	$settings['display'][] = array(
		'id'      => 'posts',
		'text'    => esc_html__( 'Posts', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'single-post',
				'text' => esc_html__( 'Single Post', 'sydney' ),
			),
			array(
				'id'   => 'post-archives',
				'text' => esc_html__( 'Post Archives', 'sydney' ),
			),
			array(
				'id'   => 'post-categories',
				'text' => esc_html__( 'Post Categories', 'sydney' ),
			),
			array(
				'id'   => 'post-tags',
				'text' => esc_html__( 'Post Tags', 'sydney' ),
			),
		),
	);

	$settings['display'][] = array(
		'id'      => 'pages',
		'text'    => esc_html__( 'Pages', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'single-page',
				'text' => esc_html__( 'Single Page', 'sydney' ),
			),
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {

		$settings['display'][] = array(
			'id'      => 'woocommerce',
			'text'    => esc_html__( 'WooCommerce', 'sydney' ),
			'options' => array(
				array(
					'id'   => 'single-product',
					'text' => esc_html__( 'Single Product', 'sydney' ),
				),
				array(
					'id'   => 'product-archives',
					'text' => esc_html__( 'Product Archives', 'sydney' ),
				),
				array(
					'id'   => 'product-categories',
					'text' => esc_html__( 'Product Categories', 'sydney' ),
				),
				array(
					'id'   => 'product-tags',
					'text' => esc_html__( 'Product Tags', 'sydney' ),
				),
				array(
					'id'   => 'product-id',
					'text' => esc_html__( 'Product name', 'sydney' ),
					'ajax' => true,
				),
			),
		);

	}

	$settings['display'][] = array(
		'id'      => 'specifics',
		'text'    => esc_html__( 'Specific', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'post-id',
				'text' => esc_html__( 'Post name', 'sydney' ),
				'ajax' => true,
			),
			array(
				'id'   => 'page-id',
				'text' => esc_html__( 'Page name', 'sydney' ),
				'ajax' => true,
			),
			array(
				'id'   => 'category-id',
				'text' => esc_html__( 'Category name', 'sydney' ),
				'ajax' => true,
			),
			array(
				'id'   => 'tag-id',
				'text' => esc_html__( 'Tag name', 'sydney' ),
				'ajax' => true,
			),
			array(
				'id'   => 'author-id',
				'text' => esc_html__( 'Author name', 'sydney' ),
				'ajax' => true,
			),
		),
	);

	$available_post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );
	$available_post_types = array_diff( array_keys( $available_post_types ), array( 'post', 'page', 'product' ) );

	if ( ! empty( $available_post_types ) ) {

		$settings['display'][] = array(
			'id'      => 'cpt',
			'text'    => esc_html__( 'Custom Post Types', 'sydney' ),
			'options' => array(
				array(
					'id'   => 'cpt-post-id',
					'text' => esc_html__( 'CPT: Post name', 'sydney' ),
					'ajax' => true,
				),
				array(
					'id'   => 'cpt-term-id',
					'text' => esc_html__( 'CPT: Term name', 'sydney' ),
					'ajax' => true,
				),
				array(
					'id'   => 'cpt-taxonomy-id',
					'text' => esc_html__( 'CPT: Taxonomy name', 'sydney' ),
					'ajax' => true,
				),
			),
		);

	}

	$settings['display'][] = array(
		'id'      => 'other',
		'text'    => esc_html__( 'Other', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'front-page',
				'text' => esc_html__( 'Front Page', 'sydney' ),
			),
			array(
				'id'   => 'blog',
				'text' => esc_html__( 'Blog', 'sydney' ),
			),
			array(
				'id'   => 'search',
				'text' => esc_html__( 'Search', 'sydney' ),
			),
			array(
				'id'   => '404',
				'text' => esc_html__( '404', 'sydney' ),
			),
			array(
				'id'   => 'author',
				'text' => esc_html__( 'Author', 'sydney' ),
			),
			array(
				'id'   => 'privacy-policy-page',
				'text' => esc_html__( 'Privacy Policy Page', 'sydney' ),
			),
		),
	);

	$user_roles = array();
	$user_rules = get_editable_roles();

	if ( ! empty( $user_rules ) ) {
		foreach ( $user_rules as $role_id => $role_data ) {
			$user_roles[] = array(
				'id'   => 'user_role_'. $role_id,
				'text' => $role_data['name'],
			);
		}
	}

	$settings['user'][] = array(
		'id'      => 'user-auth',
		'text'    => esc_html__( 'User Auth', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'logged-in',
				'text' => esc_html__( 'User Logged In', 'sydney' ),
			),
			array(
				'id'   => 'logged-out',
				'text' => esc_html__( 'User Logged Out', 'sydney' ),
			),
		),
	);

	$settings['user'][] = array(
		'id'      => 'user-roles',
		'text'    => esc_html__( 'User Roles', 'sydney' ),
		'options' => $user_roles,
	);

	$settings['user'][] = array(
		'id'      => 'other',
		'text'    => esc_html__( 'Other', 'sydney' ),
		'options' => array(
			array(
				'id'   => 'author',
				'text' => esc_html__( 'Author', 'sydney' ),
				'ajax' => true,
			),
		),
	);

	$settings = apply_filters( 'sydney_display_conditions_script_settings', $settings );

	?>
		<script type="text/javascript">
			var sydneyDCSettings = <?php echo json_encode( $settings ); ?>;
		</script>
		<script type="text/template" id="tmpl-sydney-display-conditions-template">
			<?php
			?>
			<div class="sydney-display-conditions-modal">
				<div class="sydney-display-conditions-modal-outer">
					<div class="sydney-display-conditions-modal-header">
						<h3>{{ data.title || data.label }}</h3>
						<i class="sydney-button-close sydney-display-conditions-modal-toggle dashicons dashicons-no-alt"></i>
					</div>
					<div class="sydney-display-conditions-modal-content">
						<ul class="sydney-display-conditions-modal-content-list">
							<li class="sydney-display-conditions-modal-content-list-item hidden">
								<div class="sydney-display-conditions-select2-type" data-type="include">
									<select name="type">
										<# _.each( sydneyDCSettings.types, function( type ) { #>
											<option value="{{ type.id }}">{{ type.text }}</option>
										<# }); #>
									</select>
								</div>
								<div class="sydney-display-conditions-select2-groupped">
									<# _.each( ['display', 'user'], function( conditionGroup ) { #>
										<div class="sydney-display-conditions-select2-condition" data-condition-group="{{ conditionGroup }}">
											<select name="condition">
												<# _.each( sydneyDCSettings[ conditionGroup ], function( condition ) { #>
													<# if ( _.isEmpty( condition.options ) ) { #>
														<option value="{{ condition.id }}">{{ condition.text }}</option>
													<# } else { #>
														<optgroup label="{{ condition.text }}">
															<# _.each( condition.options, function( option ) { #>
																<# var ajax = ( option.ajax ) ? ' data-ajax="true"' : ''; #>
																<option value="{{ option.id }}"{{{ ajax }}}>{{ option.text }}</option>
															<# }); #>
														</optgroup>
													<# } #>
												<# }); #>
											</select>
										</div>
									<# }); #>
									<div class="sydney-display-conditions-select2-id hidden">
										<select name="id"></select>
									</div>
								</div>
								<div class="sydney-display-conditions-modal-remove">
									<i class="dashicons dashicons-trash"></i>
								</div>
							</li>
							<# _.each( data.values, function( value ) { #>
								<li class="sydney-display-conditions-modal-content-list-item">
									<div class="sydney-display-conditions-select2-type" data-type="{{ value.type }}">
										<select name="type">
											<# _.each( sydneyDCSettings.types, function( type ) { #>
												<# var selected = ( value.type == type.id ) ? ' selected="selected"' : ''; #>
												<option value="{{ type.id }}"{{{ selected }}}>{{ type.text }}</option>
											<# }); #>
										</select>
									</div>
									<div class="sydney-display-conditions-select2-groupped">
										<# 
											var currentCondition;
											_.each( sydneyDCSettings, function( conditionValues, conditionKey ) {
												_.each( conditionValues, function( condition ) {
													if ( _.isEmpty( condition.options ) ) {
														if ( value.condition == condition.id ) {
															currentCondition = conditionKey;
														}
													} else {
														_.each( condition.options, function( option ) {
															if ( value.condition == option.id ) {
																currentCondition = conditionKey;
															}
														});
													}
												});
											});
										#>
										<# if ( ! _.isEmpty( currentCondition ) ) { #>
											<div class="sydney-display-conditions-select2-condition" data-condition-group="{{ currentCondition }}">
												<select name="condition">
													<# _.each( sydneyDCSettings[ currentCondition ], function( condition ) { #>
														<# if ( _.isEmpty( condition.options ) ) { #>
															<option value="{{ condition.id }}">{{ condition.text }}</option>
														<# } else { #>
															<optgroup label="{{ condition.text }}">
																<# _.each( condition.options, function( option ) { #>
																	<# var ajax = ( option.ajax ) ? ' data-ajax="true"' : ''; #>
																	<# var selected = ( value.condition == option.id ) ? ' selected="selected"' : ''; #>
																	<option value="{{ option.id }}"{{{ ajax }}}{{{ selected }}}>{{ option.text }}</option>
																<# }); #>
															</optgroup>
														<# } #>
													<# }); #>
												</select>
											</div>
										<# } #>
										<div class="sydney-display-conditions-select2-id hidden">
											<select name="id">
												<# if ( ! _.isEmpty( value.id ) ) { #>
													<option value="{{ value.id }}" selected="selected">{{ data.labels[ value.id ] }}</option>
												<# } #>
											</select>
										</div>
									</div>
									<div class="sydney-display-conditions-modal-remove">
										<i class="dashicons dashicons-trash"></i>
									</div>
								</li>
							<# }); #>
						</ul>
						<div class="sydney-display-conditions-modal-content-footer">
							<a href="#" class="button sydney-display-conditions-modal-add" data-condition-group="display"><?php esc_html_e( 'Add Display Condition', 'sydney' ); ?></a>
							<a href="#" class="button sydney-display-conditions-modal-add" data-condition-group="user"><?php esc_html_e( 'Add User Condition', 'sydney' ); ?></a>
						</div>
					</div>
					<div class="sydney-display-conditions-modal-footer">
						<a href="#" class="button button-primary sydney-display-conditions-modal-save sydney-display-conditions-modal-toggle"><?php esc_html_e( 'Save Conditions', 'sydney' ); ?></a>
					</div>
				</div>
			</div>
		</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts',  'sydney_display_conditions_script_template' );