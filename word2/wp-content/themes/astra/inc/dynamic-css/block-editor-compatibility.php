<?php
/**
 * Astra WordPress-5.8 compatibility - Dynamic CSS.
 *
 * @package astra
 * @since 3.6.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'astra_dynamic_theme_css', 'astra_block_editor_compatibility_css' );

/**
 * Astra WordPress compatibility - Dynamic CSS.
 *
 * @param string $dynamic_css Dynamic CSS.
 * @since 3.6.5
 */
function astra_block_editor_compatibility_css( $dynamic_css ) {

	if ( Astra_Dynamic_CSS::is_block_editor_support_enabled() ) {

		$compatibility_css = '
		.wp-block-search {
			margin-bottom: 20px;
		}
		.wp-block-site-tagline {
			margin-top: 20px;
		}
        form.wp-block-search .wp-block-search__input, .wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper, .wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper {
            border-color: #eaeaea;
			background: #fafafa;
        }
		.wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper .wp-block-search__input:focus, .wp-block-loginout input:focus {
			outline: thin dotted;
		}
		.wp-block-loginout input:focus {
			border-color: transparent;
		}
	 	form.wp-block-search .wp-block-search__inside-wrapper .wp-block-search__input {
			padding: 12px;
		}
		form.wp-block-search .wp-block-search__button svg {
            fill: currentColor;
			width: 20px;
			height: 20px;
        }
		.wp-block-loginout p label {
			display: block;
		}
		.wp-block-loginout p:not(.login-remember):not(.login-submit) input {
			width: 100%;
		}
		.wp-block-loginout .login-remember input {
			width: 1.1rem;
			height: 1.1rem;
			margin: 0 5px 4px 0;
			vertical-align: middle;
		}';

		$dynamic_css .= Astra_Enqueue_Scripts::trim_css( $compatibility_css );
	}

	/** @psalm-suppress InvalidScalarArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	if ( astra_get_option( 'improve-gb-editor-ui', true ) ) {
		/** @psalm-suppress InvalidScalarArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
		$is_site_rtl = is_rtl();

		$editor_improvement_css = '
		body .wp-block-file .wp-block-file__button {
			text-decoration: none;
		}
		blockquote {
			padding: 0 1.2em 1.2em;
		}
		.wp-block-file {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			justify-content: space-between;
		}
		.wp-block-pullquote {
			border: none;
		}
		.wp-block-pullquote blockquote::before {
			content: "\201D";
			font-family: "Helvetica",sans-serif;
			display: flex;
			transform: rotate( 180deg );
			font-size: 6rem;
			font-style: normal;
			line-height: 1;
			font-weight: bold;
			align-items: center;
			justify-content: center;
		}
		figure.wp-block-pullquote.is-style-solid-color blockquote {
			max-width: 100%;
			text-align: inherit;
		}
		ul.wp-block-categories-list.wp-block-categories, ul.wp-block-archives-list.wp-block-archives {
			list-style-type: none;
		}
		.wp-block-button__link {
			border: 2px solid currentColor;
		}';

		if ( $is_site_rtl ) {
			$editor_improvement_css .= '
			ul, ol {
				margin-right: 20px;
			}
			figure.alignright figcaption {
				text-align: left;
			}';
		} else {
			$editor_improvement_css .= '
			ul, ol {
				margin-left: 20px;
			}
			figure.alignright figcaption {
				text-align: right;
			}';
		}
	} else {
		$editor_improvement_css = '
			blockquote {
				padding: 1.2em;
			}
		';
	}

	$dynamic_css .= Astra_Enqueue_Scripts::trim_css( $editor_improvement_css );

	return $dynamic_css;
}
