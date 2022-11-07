<?php
/**
 * Radio buttons control
 *
 * @package Sydney
 */

class Sydney_Radio_Buttons extends WP_Customize_Control {

	public $type = 'sydney-radio-buttons';

	public $cols;

	public function render_content() {

		$allowed_tags = array(
			'div' => array(
				'style' => array()
			),
			'svg'     => array(
				'class'       => true,
				'xmlns'       => true,
				'width'       => true,
				'height'      => true,
				'viewbox'     => true,
				'aria-hidden' => true,
				'role'        => true,
				'focusable'   => true,
			),
			'path'    => array(
				'd'      => true,
			),
			'rect'    => array(
				'x'      => true,
				'y'      => true,
				'width'  => true,
				'height' => true,
				'transform' => true
			),			
		);
		?>
			<div class="text_radio_button_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<div class="radio-buttons">
					<?php foreach ( $this->choices as $key => $value ) { ?>
						<label class="radio-button-label" tabindex="0">
							<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
							<span><?php echo wp_kses( $value, $allowed_tags ); ?></span>
						</label>
					<?php	} ?>
				</div>
			</div>
		<?php
	}
}