<?php
/**
 * Display conditions control
 *
 * @package Sydney
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sydney_Display_Conditions_Control extends WP_Customize_Control {
		
	/**
	 * The type of control being rendered
	 */
	public $type = 'sydney-display-conditions-control';

	public $title = '';

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue our scripts and styles
	 */
	public function enqueue() {
		wp_enqueue_script( 'sydney-select2-js', get_template_directory_uri() . '/inc/customizer/controls/typography/select2.full.min.js', array( 'jquery' ), '4.0.13', true );
		wp_enqueue_style( 'sydney-select2-css', get_template_directory_uri() . '/inc/customizer/controls/typography/select2.min.css', array(), '4.0.13', 'all' );
	}

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {

			$values = ( ! empty( $this->value() ) ) ? json_decode( $this->value(), true ) : array();

			$labels = array();

			foreach ( $values as $value ) {
				if ( ! empty( $value['id'] ) ) {
					$labels[ $value['id'] ] = self::get_option_text( $value );
				}
			}

			$settings = array(
				'title'  => $this->title,
				'label'  => $this->label,
				'values' => $values,
				'labels' => $labels,
			);

		?>
		<div class="sydney-display-conditions-control" data-condition-settings="<?php echo esc_attr( json_encode( $settings ) ); ?>">
			<?php if( ! empty( $this->label ) ) { ?>
				<span class="customize-control-title"><?php echo wp_kses_post( $this->label ); ?></span>
			<?php } ?>
			<?php if( ! empty( $this->description ) ) { ?>
				<span class="customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php } ?>
			<a href="#" class="button button-primary sydney-display-conditions-modal-button sydney-display-conditions-modal-toggle"><?php esc_html_e( 'Add/Edit Conditions', 'sydney' ); ?></a>
			<textarea id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="sydney-display-conditions-textarea hidden" <?php $this->link(); ?>><?php echo sanitize_textarea_field( $this->value() ); ?></textarea>
		</div>
		<?php
	}

	/**
	 * Get option text
	 */
	public static function get_option_text( $value ) {

		switch ( $value['condition'] ) {

			case 'post-id':
			case 'page-id':
			case 'product-id':
			case 'cpt-post-id':
				return get_the_title( $value['id'] );
			break;

			case 'tag-id':
			case 'category-id':
			
        $term = get_term( $value['id'] );

        if ( ! empty( $term ) ) {
					return $term->name;
        }

			break;

			case 'cpt-term-id':
			
        $term = get_term( $value['id'] );
        
        if ( ! empty( $term ) ) {
					return $term->name;
        }

			break;

			case 'cpt-taxonomy-id':
			
        $taxonomy = get_taxonomy( $value['id'] );
        
        if ( ! empty( $taxonomy ) ) {
					return $taxonomy->label;
        }

			break;

			case 'author':
			case 'author-id':
				return get_the_author_meta( 'display_name', $value['id'] );
			break;

		}

		// user-roles
		if ( substr( $value['condition'], 0, 10 ) === 'user_role_' ) {
			$user_rules = get_editable_roles();
			if ( ! empty( $user_rules[ $value['id'] ] ) ) {
				return $user_rules[ $value['id'] ]['name'];
			}
		}

		return $value['id'];

	}

}