<?php

/**
 * Skin for Portfolio module
 */
class aThemes_Testimonials_Skin extends Elementor\Skin_Base {
	

	public function get_id() {
		return 'athemes-testimonials-skin';
	}

	public function get_title() {
		return __( 'Side by side', 'sydney-toolbox' );
	}

	public function render() {
		$settings = $this->parent->get_settings();

		?>

		<div class="testimonials-wrapper">
			<div class="roll-testimonials <?php echo $this->get_id(); ?>" data-autoplay="5000">
				<?php foreach ( $settings['testimonials_list'] as $index => $item ) : ?>
					<div class="customer">
						<?php if ( $item['image']['url'] ) :
							$this->parent->add_render_attribute( 'image-' . $index, 'src', $item['image']['url'] );
							$this->parent->add_render_attribute( 'image-' . $index, 'alt', Elementor\Control_Media::get_image_alt( $item['image'] ) );							
							?>
							<div class="avatar">
								<img <?php echo $this->parent->get_render_attribute_string( 'image-' . $index ); ?>/>
							</div>
						<?php endif; ?>

						<div class="testimonial-content">
							<div class="testimonial-quote">
								<svg width="27" height="23" viewBox="0 0 27 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.06 23C19.404 23 18 22.3673 16.848 21.1019C15.696 19.7621 15.12 17.9757 15.12 15.7427C15.12 12.5421 15.588 9.93689 16.524 7.92718C17.46 5.84304 18.504 4.2055 19.656 3.01456C20.952 1.67476 22.5 0.669903 24.3 0L25.38 1.78641C24.156 2.38188 23.076 3.089 22.14 3.90777C21.348 4.6521 20.592 5.54531 19.872 6.58738C19.224 7.55502 18.9 8.74596 18.9 10.1602C18.9 10.6812 18.972 11.0906 19.116 11.3883C19.188 11.6116 19.296 11.7605 19.44 11.835C19.584 11.7605 19.8 11.6861 20.088 11.6117C20.304 11.5372 20.52 11.4628 20.736 11.3883C21.024 11.3139 21.312 11.2767 21.6 11.2767C23.256 11.2767 24.552 11.7977 25.488 12.8398C26.496 13.8074 27 15.1472 27 16.8592C27 18.5712 26.424 20.0227 25.272 21.2136C24.12 22.4045 22.716 23 21.06 23ZM5.94 23C4.284 23 2.88 22.3673 1.728 21.1019C0.576 19.7621 0 17.9757 0 15.7427C0 12.5421 0.468 9.93689 1.404 7.92718C2.34 5.84304 3.384 4.2055 4.536 3.01456C5.832 1.67476 7.38 0.669903 9.18 0L10.26 1.78641C9.036 2.38188 7.956 3.089 7.02 3.90777C6.228 4.6521 5.472 5.54531 4.752 6.58738C4.104 7.55502 3.78 8.74596 3.78 10.1602C3.78 10.6812 3.852 11.0906 3.996 11.3883C4.068 11.6116 4.176 11.7605 4.32 11.835C4.464 11.7605 4.68 11.6861 4.968 11.6117C5.184 11.5372 5.4 11.4628 5.616 11.3883C5.904 11.3139 6.192 11.2767 6.48 11.2767C8.136 11.2767 9.432 11.7977 10.368 12.8398C11.376 13.8074 11.88 15.1472 11.88 16.8592C11.88 18.5712 11.304 20.0227 10.152 21.2136C9 22.4045 7.596 23 5.94 23Z" fill="#D8E3DE"/></svg>
							</div>

							<blockquote class="whisper"><?php echo wp_kses_post( $item['testimonial'] ); ?></blockquote>                               
					
							<div class="name">
								<div class="testimonial-name"><?php echo esc_html( $item['name'] ); ?></div>
								<span class="testimonial-position"><?php echo esc_html( $item['position'] ); ?></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>		
			</div>	
			<div class="testimonials-nav">
				<div class="tc-prev"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 5.95041L2.3256 0.639553C1.94111 0.279697 1.34343 0.279697 0.958938 0.639553L0.927438 0.669035C0.505529 1.06391 0.505164 1.73317 0.926643 2.12851L5.00127 5.95041L0.926643 9.77232C0.505164 10.1677 0.505528 10.8369 0.927437 11.2318L0.958937 11.2613C1.34343 11.6211 1.94111 11.6211 2.3256 11.2613L8 5.95041Z"/></svg></div>
				<div class="tc-next"><svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0 6.04959L5.36932 11.3142C5.75781 11.6951 6.37968 11.6951 6.76817 11.3142C7.16733 10.9228 7.16768 10.2801 6.76895 9.8883L2.86242 6.04959L6.76895 2.21087C7.16768 1.81906 7.16733 1.17634 6.76817 0.784964C6.37968 0.404047 5.75781 0.404047 5.36932 0.784964L0 6.04959Z"/></svg></div>
			</div>	
		</div>
		<?php
	}

}

add_action( 'elementor/widget/athemes-testimonials/skins_init', function( $widget ) {
   $widget->add_skin( new aThemes_Testimonials_Skin( $widget ) );
} );







