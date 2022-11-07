<?php
/**
 * Posts archive class
 *
 * @package Sydney
 */


if ( !class_exists( 'Sydney_Posts_Archive' ) ) :
	Class Sydney_Posts_Archive {

		/**
		 * Instance
		 */		
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			
			add_action( 'wp', array( $this, 'filters' ) );
			add_action( 'sydney_loop_post', array( $this, 'post_markup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		public function enqueue() {
			if ( 'layout5' === $this->blog_layout() ) {
				wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-masonry');
			}
		}

		/**
		 * Filters
		 */
		public function filters() {
			if ( is_singular() || is_404() || ( class_exists( 'Woocommerce' ) && is_woocommerce() ) ) {
				return;
			}

			$sidebar = get_theme_mod( 'sidebar_archives', 0 );
			if ( 0 == $sidebar ) {
				add_filter( 'sydney_content_class', function() { return 'no-sidebar'; } );
				add_filter( 'sydney_sidebar', '__return_false' );
			}

			add_filter( 'post_class', array( $this, 'post_classes' ) );
		}

		public function post_classes( $classes ) {
			$text_align = get_theme_mod( 'archive_text_align', 'left' );
			$columns 	= get_theme_mod( 'archives_grid_columns', '3' );
			$columns	= 'col-lg-' . 12/$columns . ' col-md-' . 12/$columns;
			$classes[] 	= 'post-align-' . esc_attr( $text_align );

			$vertical_align = get_theme_mod( 'archives_list_vertical_alignment', 'middle' );
			$classes[] = 'post-vertical-align-' . esc_attr( $vertical_align );


			if ( 'layout3' === $this->blog_layout() || 'layout5' === $this->blog_layout() ) {
				$classes[] = $columns;
			} else {
				$classes[] = 'col-md-12';
			}

			return $classes;
		}

		/**
		 * Blog layout
		 */
		public function blog_layout() {
			$layout = get_theme_mod( 'blog_layout', 'layout2' );

			return $layout;
		}

		/**
		 * Default meta elements
		 */
		public function default_meta_elements() {
			return array( 'post_date', 'post_categories' );
		}

		/**
		 * Create the archive posts
		 */
		public function post_markup() {

			$layout 			= $this->blog_layout();
			$image_placement 	= get_theme_mod( 'archive_list_image_placement', 'left' );
			$meta_position 		= get_theme_mod( 'archive_meta_position', 'above-title' );

			switch ( $layout ) {
				case 'layout3':
				case 'layout5':
					$this->post_image();
					if ( 'above-title' === $meta_position ) {
						$this->post_meta( $meta_position );
					}
					$this->post_title();
					$this->post_excerpt();
					if ( 'below-excerpt' === $meta_position ) {
						$this->post_meta( $meta_position );
					}

					break;

				case 'layout1':	
					$this->post_image();
					if ( 'above-title' === $meta_position ) {
						$this->post_meta( $meta_position );
					}
					$this->post_title();
					$this->post_excerpt();	
					if ( 'below-excerpt' === $meta_position ) {
						$this->post_meta( $meta_position );
					}

					break;

				case 'layout2':	
					if ( 'above-title' === $meta_position ) {
						$this->post_meta( $meta_position );
					}
					$this->post_title();
					$this->post_image();
					$this->post_excerpt();	
					if ( 'below-excerpt' === $meta_position ) {
						$this->post_meta( $meta_position );
					}

					break;	
					
				case 'layout4':	
				case 'layout6':
					echo '<div class="list-image image-' . esc_attr( $image_placement ) . '">';
					$this->post_image();
					echo '</div>';

					echo '<div class="list-content">';
					if ( 'above-title' === $meta_position ) {
						$this->post_meta( $meta_position );
					}
					$this->post_title();
					$this->post_excerpt();
					if ( 'below-excerpt' === $meta_position ) {
						$this->post_meta( $meta_position );
					}					
					echo '</div>';	
					
					break;						
			}
		}

		/**
		 * Post image
		 */
		public function post_image() {
			$enable = get_theme_mod( 'index_feat_image', 1 );

			if ( has_post_thumbnail() && $enable ) : ?>
				<div class="entry-thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('large-thumb'); ?></a>
				</div>
			<?php endif;
		}

		/**
		 * Post meta
		 */
		public function post_meta( $position ) {

			$elements 				= get_theme_mod( 'archive_meta_elements', $this->default_meta_elements() );
			$archive_meta_delimiter = get_theme_mod( 'archive_meta_delimiter', 'dot' );

			if ( 'post' !== get_post_type() || empty( $elements ) ) {
				return;
			}

			echo '<div class="entry-meta ' . esc_attr( $position ) . ' delimiter-' . esc_attr( $archive_meta_delimiter ) . '">';
			foreach( $elements as $element ) {
				call_user_func( array( $this, $element ) );
			}			
			echo '</div>';
		}	
		
		/**
		 * Post title
		 */
		public function post_title() {
			?>
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="title-post entry-title" ' . sydney_get_schema( "headline" ) . '><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->
			<?php
		}	

		/**
		 * Post excerpt
		 */
		public function post_excerpt() {
			$excerpt 				= get_theme_mod( 'show_excerpt', 1 );
			$read_more 				= get_theme_mod( 'read_more_link', 0 );
			$full_content_home 		= get_theme_mod('full_content_home', 0 );		//Legacy option
			$full_content_archives 	= get_theme_mod('full_content_archives', 0 );	//Legacy option

			if ( !$excerpt ) {
				return;
			}
			?>
			<div class="entry-post" <?php sydney_do_schema( 'entry_content' ); ?>>
				<?php
				if ( ( $full_content_home == 1 && is_home() ) || ( $full_content_archives == 1 && is_archive() ) ) {
					the_content();
				} else {
					the_excerpt();
				}

				if ( $read_more ) {
					echo '<a class="read-more" title="' . esc_attr( strip_tags( get_the_title() ) ) . '" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read more', 'sydney' ) . '</a>';
				}
				?>
			</div>
			<?php
		}
		
		/**
		 * Post date
		 */
		public function post_date() {
			sydney_posted_on();
		}

		/**
		 * Post author
		 */
		public function post_author() {
			sydney_posted_by();
		}	
		
		/**
		 * Post categories
		 */
		public function post_categories() {
			sydney_post_categories();
		}

		/**
		 * Post comments
		 */
		public function post_comments() {
			sydney_entry_comments();
		}		
	}

	/**
	 * Initialize class
	 */
	Sydney_Posts_Archive::get_instance();

endif;