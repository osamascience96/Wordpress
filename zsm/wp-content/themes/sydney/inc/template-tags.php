<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Sydney
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'sydney' ); ?></h2>
		<div class="nav-links clearfix">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'sydney' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'sydney' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'sydney_post_navigation' ) ) :
function sydney_post_navigation() {

	if ( !apply_filters( 'sydney_single_post_nav_enable', true ) ) {
		return;
	}	

	$single_post_show_post_nav = get_theme_mod( 'single_post_show_post_nav', 1 );
	if ( !$single_post_show_post_nav ) {
		return;
	}

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'sydney' ); ?></h2>
		<div class="nav-links clearfix">
		<?php
				previous_post_link( '<div class="nav-previous"><span><svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.19643 0.741072C5.19643 0.660715 5.16071 0.589286 5.10714 0.535715L4.66071 0.0892859C4.60714 0.0357151 4.52679 0 4.45536 0C4.38393 0 4.30357 0.0357151 4.25 0.0892859L0.0892857 4.25C0.0357143 4.30357 0 4.38393 0 4.45536C0 4.52679 0.0357143 4.60714 0.0892857 4.66072L4.25 8.82143C4.30357 8.875 4.38393 8.91072 4.45536 8.91072C4.52679 8.91072 4.60714 8.875 4.66071 8.82143L5.10714 8.375C5.16071 8.32143 5.19643 8.24107 5.19643 8.16964C5.19643 8.09822 5.16071 8.01786 5.10714 7.96429L1.59821 4.45536L5.10714 0.946429C5.16071 0.892858 5.19643 0.8125 5.19643 0.741072Z" fill="#737C8C"/></svg></span>%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link<span><svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.19643 4.45536C5.19643 4.38393 5.16071 4.30357 5.10714 4.25L0.946429 0.0892859C0.892857 0.0357151 0.8125 0 0.741071 0C0.669643 0 0.589286 0.0357151 0.535714 0.0892859L0.0892857 0.535715C0.0357143 0.589286 0 0.669643 0 0.741072C0 0.8125 0.0357143 0.892858 0.0892857 0.946429L3.59821 4.45536L0.0892857 7.96429C0.0357143 8.01786 0 8.09822 0 8.16964C0 8.25 0.0357143 8.32143 0.0892857 8.375L0.535714 8.82143C0.589286 8.875 0.669643 8.91072 0.741071 8.91072C0.8125 8.91072 0.892857 8.875 0.946429 8.82143L5.10714 4.66072C5.16071 4.60714 5.19643 4.52679 5.19643 4.45536Z" fill="#737C8C"/></svg></span></div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
add_action( 'sydney_after_single_entry', 'sydney_post_navigation' );

/**
 * Archives post navigation
 */
if ( ! function_exists( 'sydney_posts_navigation' ) ) :
function sydney_posts_navigation() {

	if ( !apply_filters( 'sydney_archive_post_nav_enable', true ) ) {
		return;
	}

	the_posts_pagination( array(
		'mid_size'  => 1,
		'prev_text' => '&lt;',
		'next_text' => '&gt;',
	) );	

}
endif;

if ( ! function_exists( 'sydney_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function sydney_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s" ' . sydney_get_schema( 'published_date' ) . '>%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" ' . sydney_get_schema( 'modified_date' ) . '>%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
endif;

if ( ! function_exists( 'sydney_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function sydney_posted_by() {
		global $post;
		$author = $post->post_author;
		$show_avatar = get_theme_mod( 'show_avatar', 0 );

		$byline = '<span class="author vcard">';
		if ( $show_avatar ) {
			$avatar = get_avatar( get_the_author_meta( 'email', $author ) , 16 );
		} else {
			$avatar = '';
		}

		$byline .= sprintf(
			_x( 'By %1$s %2$s', 'post author', 'sydney' ),
			$avatar,
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);

		$byline .= '</span>';

		echo '<span class="byline">' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'sydney_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function sydney_entry_footer() {

	$single_post_show_tags = get_theme_mod( 'single_post_show_tags', 1 );

	if ( !$single_post_show_tags ) {
		return;
	}

	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( '', 'sydney' ) );
		if ( $tags_list && is_single() ) {
			printf( '<span class="tags-links">' . __( ' %1$s', 'sydney' ) . '</span>', $tags_list );
		}
	}
	edit_post_link( __( 'Edit', 'sydney' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'sydney_post_categories' ) ) :
	function sydney_post_categories() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'sydney' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . '%1$s' . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}		
	}
endif;

if ( ! function_exists( 'sydney_entry_comments' ) ) :
	function sydney_entry_comments() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( '0 comments', 'sydney' ), esc_html__( '1 comment', 'sydney' ), esc_html__( '% comments', 'sydney' ) );
			echo '</span>';
		}		
	}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'sydney' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'sydney' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'sydney' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'sydney' ), get_the_date( _x( 'Y', 'yearly archives date format', 'sydney' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'sydney' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'sydney' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'sydney' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'sydney' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'sydney' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'sydney' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'sydney' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'sydney' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'sydney' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function sydney_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'sydney_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'sydney_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so sydney_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so sydney_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in sydney_categorized_blog.
 */
function sydney_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'sydney_categories' );
}
add_action( 'edit_category', 'sydney_category_transient_flusher' );
add_action( 'save_post',     'sydney_category_transient_flusher' );

/**
 * Post date
 */
function sydney_post_date( $notext = false ) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s" ' . sydney_get_schema( 'published_date' ) . '>%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" ' . sydney_get_schema( 'modified_date' ) . '>%4$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	if ( $notext == false ) {
		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'sydney' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	} else {
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	}

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}

/**
 * First category
 */
function sydney_get_first_cat() {
	if ( 'post' === get_post_type() ) {
		$cats = get_the_category();
		if( isset($cats[0]) ) {
			echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" title="' . esc_attr( $cats[0]->name ) . '" class="post-cat">' . esc_html( $cats[0]->name ) . '</a>';
		}
	}
}

/**
 * Get all post categories
 */
function sydney_all_cats() {
	$categories = get_the_category();
	if ( $categories && sydney_categorized_blog() ) {
		foreach ($categories as $cat) {
			echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" title="' . esc_attr( $cat->name ) . '" class="post-cat">' . esc_html( $cat->name ) . '</a>';
		}
	}
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Shim for wp_body_open() function
	 */
	// phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedFunctionFound
	function wp_body_open() {
		// phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'sydney_single_post_meta' ) ) :
	/**
	 * Single post meta
	 */
	function sydney_single_post_meta( $location ) {

		$disable = get_theme_mod( 'hide_meta_single', 0 ); 

		if ( $disable || apply_filters( 'sydney_single_post_meta_enable', false ) ) {
			return;
		}

		$elements 				= get_theme_mod( 'single_post_meta_elements', array( 'sydney_posted_by', 'sydney_posted_on', 'sydney_post_categories' ) );
		$archive_meta_delimiter = get_theme_mod( 'archive_meta_delimiter', 'dot' );

		echo '<div class="entry-meta ' . esc_attr( $location ) . ' delimiter-' . esc_attr( $archive_meta_delimiter ) . '">';
		foreach( $elements as $element ) {
			call_user_func( $element );
		}			
		echo '</div>';		
	}
endif;



if ( ! function_exists( 'sydney_single_post_thumbnail' ) ) :
	/**
	 * Single post featured image
	 */
	function sydney_single_post_thumbnail( $disable, $class = false ) {

		$show_mods = get_theme_mod( 'single_post_show_featured', 1 );

		if ( !has_post_thumbnail() || $disable || !$show_mods ) {
			return; //return if no image set or disabled from meta or customizer
		}

		?>
		<div class="entry-thumb <?php echo esc_attr( $class ? $class : '' ); ?>">
			<?php the_post_thumbnail('large-thumb'); ?>
		</div>
		<?php
	}
endif;