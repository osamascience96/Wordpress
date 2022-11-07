<?php
/**
 * Select2 dropdown control
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Multi select control
 */

/**
 * Customizer Control: oceanwp-multiple-select.
 *
 * @package     OceanWP WordPress theme
 * @subpackage  Controls
 * @see   		https://github.com/aristath/kirki
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Multi select control
 */
class Sydney_Select2_Custom_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'sydney-multiple-select';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'select2', get_template_directory_uri() . '/js/select2.min.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'select2', get_template_directory_uri() . '/css/select2.min.css', null );
		wp_enqueue_script( 'sydney-multiple-select', get_template_directory_uri() . '/inc/customizer/controls/multiple-select/multiple-select.js', array( 'jquery', 'customize-base', 'select2' ), false, true );
		wp_enqueue_style( 'sydney-multiple-select', get_template_directory_uri() . '/inc/customizer/controls/multiple-select/multiple-select.css', null );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		} else {
			$this->json['default'] = $this->setting->default;
		}
		$this->json['value']       = (array) $this->value();
		$this->json['choices']     = $this->choices;
		$this->json['link']        = $this->get_link();
		$this->json['id']          = $this->id;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<select {{{ data.inputAttrs }}} {{{ data.link }}}>

			<# _.each( data.choices, function( label, choice ) { #>

				<option value="{{ choice }}" <# if ( -1 !== data.value.indexOf( choice ) ) { #> selected="selected" <# } #>>{{ label }}</option>

			<# } ) #>

		</select>
		<?php
	}
}
