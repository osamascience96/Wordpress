<?php

/**
 * Base panel class.
 *
 * @since 1.0.0
 */
abstract class WPForms_Builder_Panel {

	/**
	 * Full name of the panel.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Slug.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * Font Awesome Icon used for the editor button, eg "fa-list".
	 *
	 * @since 1.0.0
	 *
	 * @var mixed
	 */
	public $icon = false;

	/**
	 * Priority order the field button should show inside the "Add Fields" tab.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	public $order = 50;

	/**
	 * If panel contains a sidebar element or is full width.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	public $sidebar = false;

	/**
	 * Contain form object if we have one.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public $form;

	/**
	 * Contain array of the form data (post_content).
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $form_data;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Load form if found.
		$form_id         = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : false;
		$this->form      = wpforms()->form->get( $form_id );
		$this->form_data = $this->form ? wpforms_decode( $this->form->post_content ) : false;

		// Bootstrap.
		$this->init();

		// Load panel specific enqueues.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueues' ), 15 );

		// Primary panel button.
		add_action( 'wpforms_builder_panel_buttons', array( $this, 'button' ), $this->order, 2 );

		// Output.
		add_action( 'wpforms_builder_panels', array( $this, 'panel_output' ), $this->order, 2 );
	}

	/**
	 * All systems go. Used by children.
	 *
	 * @since 1.0.0
	 */
	public function init() {
	}

	/**
	 * Enqueue assets for the builder. Used by children.
	 *
	 * @since 1.0.0
	 */
	public function enqueues() {
	}

	/**
	 * Primary panel button in the left panel navigation.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $form
	 * @param string $view
	 */
	public function button( $form, $view ) {

		$active = $view === $this->slug ? 'active' : '';
		?>

		<button class="wpforms-panel-<?php echo esc_attr( $this->slug ); ?>-button <?php echo $active; ?>" data-panel="<?php echo esc_attr( $this->slug ); ?>">
			<i class="fa <?php echo esc_attr( $this->icon ); ?>"></i>
			<span><?php echo esc_html( $this->name ); ?></span>
		</button>

		<?php
	}

	/**
	 * Output the contents of the panel.
	 *
	 * @since 1.0.0
	 *
	 * @param object $form
	 * @param string $view
	 */
	public function panel_output( $form, $view ) {

		$active = $view === $this->slug ? 'active' : '';
		$wrap   = $this->sidebar ? 'wpforms-panel-sidebar-content' : 'wpforms-panel-full-content';

		printf( '<div class="wpforms-panel %s" id="wpforms-panel-%s">', esc_attr( $active ), esc_attr( $this->slug ) );

		printf( '<div class="%s">', $wrap );

		if ( true === $this->sidebar ) {

			echo '<div class="wpforms-panel-sidebar">';

			do_action( 'wpforms_builder_before_panel_sidebar', $this->form, $this->slug );

			$this->panel_sidebar();

			do_action( 'wpforms_builder_after_panel_sidebar', $this->form, $this->slug );

			echo '</div>';

		}

		echo '<div class="wpforms-panel-content-wrap">';

		echo '<div class="wpforms-panel-content">';

		do_action( 'wpforms_builder_before_panel_content', $this->form, $this->slug );

		$this->panel_content();

		do_action( 'wpforms_builder_after_panel_content', $this->form, $this->slug );

		echo '</div>';

		echo '</div>';

		echo '</div>';

		echo '</div>';
	}

	/**
	 * Output the panel's sidebar if we have one.
	 *
	 * @since 1.0.0
	 */
	public function panel_sidebar() {
	}

	/**
	 * Output panel sidebar sections.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name
	 * @param string $slug
	 * @param string $icon
	 */
	public function panel_sidebar_section( $name, $slug, $icon = '' ) {

		$class  = '';
		$class .= $slug === 'default' ? ' default' : '';
		$class .= ! empty( $icon ) ? ' icon' : '';

		echo '<a href="#" class="wpforms-panel-sidebar-section wpforms-panel-sidebar-section-' . esc_attr( $slug ) . $class . '" data-section="' . esc_attr( $slug ) . '">';

		if ( ! empty( $icon ) ) {
			echo '<img src="' . esc_url( $icon ) . '">';
		}

		echo esc_html( $name );

		echo '<i class="fa fa-angle-right wpforms-toggle-arrow"></i>';

		echo '</a>';
	}

	/**
	 * Output the panel's primary content.
	 *
	 * @since 1.0.0
	 */
	public function panel_content() {
	}
}
