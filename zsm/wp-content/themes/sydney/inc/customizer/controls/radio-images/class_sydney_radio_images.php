<?php
/**
 * Radio images control
 *
 * @package Sydney
 */

class Sydney_Radio_Images extends WP_Customize_Control {

	public $type = 'botiga-radio-image';

	public $cols;

	public function render_content() {

		if ( empty( $this->choices ) )
			return; ?>

		<?php if ( !empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( !empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<div id="<?php echo esc_attr( "input_{$this->id}" ); ?>" class="botiga-radio-images-wrapper">

			<?php foreach ( $this->choices as $value => $args ) : ?>

				<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( "_customize-radio-{$this->id}" ); ?>" id="<?php echo esc_attr( "{$this->id}-{$value}" ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> /> 

				<label for="<?php echo esc_attr( "{$this->id}-{$value}" ); ?>">
					<span class="screen-reader-text"><?php echo esc_html( $args['label'] ); ?></span>
					<div class="img-cont"><img src="<?php echo esc_url( sprintf( $args['url'], get_template_directory_uri(), get_stylesheet_directory_uri() ) ); ?>" title="<?php echo esc_attr( $args['label'] ); ?>" alt="<?php echo esc_attr( $args['label'] ); ?>" /></div>
				</label>

			<?php endforeach; ?>

		</div><!-- .image -->

		<script type="text/javascript">
			jQuery( document ).ready( function() {
				jQuery( '#<?php echo esc_attr( "input_{$this->id}" ); ?>' ).buttonset();
				jQuery( '#<?php echo esc_attr( "input_{$this->id}" ); ?>' ).find( 'label' ).removeClass( 'ui-button' );
			} );
		</script>
	<?php }

	/**
	 * Loads the jQuery UI Button script and hooks our custom styles in.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );

		add_action( 'customize_controls_print_styles', array( $this, 'print_styles' ) );
	}

	/**
	 * Outputs custom styles to give the selected image a visible border.
	 */
	public function print_styles() { ?>

		<style type="text/css" id="hybrid-customize-botiga-radio-image-css">
			.customize-control-botiga-radio-image img { border: 1px solid transparent;border-radius:3px;width:100%;display:block;transition: opacity 0.2s;}
			.customize-control-botiga-radio-image .img-cont {margin:5px;}
			<?php if ( $this->cols === 3 ) : ?>
				.customize-control-botiga-radio-image #<?php echo esc_attr( "input_{$this->id}" ); ?> label { float:left; width: 33.3333%;}
			<?php elseif ( $this->cols === 2 ) : ?>
				.customize-control-botiga-radio-image #<?php echo esc_attr( "input_{$this->id}" ); ?> label { float:left; width: 50%;}
			<?php else : ?>
				.customize-control-botiga-radio-image #<?php echo esc_attr( "input_{$this->id}" ); ?> label { float:left; width: 25%;}
			<?php endif; ?>
			.customize-control-botiga-radio-image img:hover { opacity:1; }
			.customize-control-botiga-radio-image .ui-state-active img { border-color: #317CB5;opacity:1; }
			.customize-control-botiga-radio-image .ui-state-active .img-cont {position:relative;}
			.customize-control-botiga-radio-image .ui-state-active .img-cont:after { content:'';background:rgba(49, 124, 181, 0.1);top:0;left:0;position:absolute;width:100%;height:100%; }
		</style>
	<?php }
}