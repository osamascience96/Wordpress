<?php
/**
 * Display Conditions
 *
 * @package Sydney
 */

/**
 * Display Conditions
 */
function sydney_get_display_conditions( $maybe_rules, $default = true, $mod_default = '[]' ) {

	$rules  = array();
	$result = $default;

	if ( is_array( $maybe_rules ) && ! empty( $maybe_rules ) ) {
		$rules = $maybe_rules;
	} else {
		$option = get_theme_mod( $maybe_rules, $mod_default );
		$rules  = json_decode( $option, true );
	}

	if ( ! empty( $rules ) ) {

		foreach ( $rules as $rule ) {

			$object_id = ( ! empty( $rule['id'] ) ) ? intval( $rule['id'] ) : 0;
			$condition = ( ! empty( $rule['condition'] ) ) ? $rule['condition'] : '';
			$boolean   = ( ! empty( $rule['type'] ) && $rule['type'] === 'include' ) ? true : false;

			// Entrie Site
			if ( $condition === 'all' ) {
				$result = $boolean;
			}

			// Basic
			if ( $condition === 'singular' && is_singular() ) {
				$result = $boolean;
			}

			if ( $condition === 'archive' && is_archive() ) {
				$result = $boolean;
			}

			// Posts
			if ( $condition === 'single-post' && is_single() ) {
				$result = $boolean;
			}

			if ( $condition === 'post-archives' && is_archive() ) {
				$result = $boolean;
			}

			if ( $condition === 'post-categories' && is_category() ) {
				$result = $boolean;
			}

			if ( $condition === 'post-tags' && is_tag() ) {
				$result = $boolean;
			}

			if ( $condition === 'cpt-post-id' && get_queried_object_id() === $object_id ) {
				$result = $boolean;
			}

			if ( $condition === 'cpt-term-id' && get_queried_object_id() === $object_id ) {
				$result = $boolean;
			}

			if ( $condition === 'cpt-taxonomy-id' && is_tax( $object_id ) ) {
				$result = $boolean;
			}

			// Pages
			if ( $condition === 'single-page' && is_page() ) {
				$result = $boolean;
			}

			// WooCommerce
			if ( class_exists( 'WooCommerce' ) ) {
	
				if ( $condition === 'single-product' && is_singular( 'product' ) ) {
					$result = $boolean;
				}
	
				if ( $condition === 'product-archives' && ( is_shop() || is_product_tag() || is_product_category() ) ) {
					$result = $boolean;
				}
	
				if ( $condition === 'product-categories' && is_product_category() ) {
					$result = $boolean;
				}
	
				if ( $condition === 'product-tags' && is_product_tag() ) {
					$result = $boolean;
				}

				if ( $condition === 'product-id' && get_queried_object_id() === $object_id ) {
					$result = $boolean;
				}

			}

			// Specific
			if ( $condition === 'post-id' && get_queried_object_id() === $object_id ) {
				$result = $boolean;
			}

			if ( $condition === 'page-id' && get_queried_object_id() === $object_id ) {
				$result = $boolean;
			}

			if ( $condition === 'category-id' && is_category() && get_queried_object_id() === $object_id ) {
				$result = $boolean;
			}

			if ( $condition === 'tag-id' && is_tag() && get_queried_object_id() === $object_id ) {
				$result = $boolean;
			}

			if ( $condition === 'author-id' && get_the_author_meta( 'ID' ) === $object_id ) {
				$result = $boolean;
			}

			// User Auth
			if ( $condition === 'logged-in' && is_user_logged_in() ) {
				$result = $boolean;
			}

			if ( $condition === 'logged-out' && ! is_user_logged_in() ) {
				$result = $boolean;
			}

			// User Roles
			if ( substr( $condition, 0, 10 ) === 'user_role_' && is_user_logged_in() ) {

				$user_role  = str_replace( 'user_role_', '', $condition );
				$user_id    = get_current_user_id();
				$user_roles = get_userdata( $user_id )->roles;

				if ( in_array( $user_role, $user_roles ) ) {
					$result = $boolean;
				}

			}

			// Others
			if ( $condition === 'front-page' && is_front_page() ) {
				$result = $boolean;
			}

			if ( $condition === 'blog' && is_home() ) {
				$result = $boolean;
			}

			if ( $condition === '404' && is_404() ) {
				$result = $boolean;
			}

			if ( $condition === 'search' && is_search() ) {
				$result = $boolean;
			}

			if ( $condition === 'author' && is_author() ) {
				$result = $boolean;
			}

			if ( $condition === 'privacy-policy-page' && is_page() ) {

				$post_id    = get_the_ID();
				$privacy_id = get_option( 'wp_page_for_privacy_policy' );

				if ( intval( $post_id ) === intval( $privacy_id ) ) {
					$result = $boolean;
				}

			}

		}

	}

	$result = apply_filters( 'sydney_display_conditions_result', $result, $rules );

	return $result;

}