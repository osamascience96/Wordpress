<?php
/**
 * Gutenberg Compatibility File.
 *
 * @since 3.7.1
 * @package Astra
 */

/**
 * Astra Gutenberg Compatibility
 *
 * @since 3.7.1
 */
class Astra_Gutenberg {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'render_block', array( $this, 'restore_group_inner_container' ), 10, 2 );
	}

	/**
	 * Add Group block inner container when theme.json is added
	 * to avoid the group block width from changing to full width.
	 *
	 * @since 3.7.1
	 * @access public
	 *
	 * @param string $block_content Rendered block content.
	 * @param array  $block         Block object.
	 *
	 * @return string Filtered block content.
	 */
	public function restore_group_inner_container( $block_content, $block ) {
		$group_with_inner_container_regex = '/(^\s*<div\b[^>]*wp-block-group(\s|")[^>]*>)(\s*<div\b[^>]*wp-block-group__inner-container(\s|")[^>]*>)((.|\S|\s)*)/';

		if (
			( isset( $block['blockName'] ) && 'core/group' !== $block['blockName'] ) ||
			1 === preg_match( $group_with_inner_container_regex, $block_content )
		) {
			return $block_content;
		}

		$replace_regex   = '/(^\s*<div\b[^>]*wp-block-group[^>]*>)(.*)(<\/div>\s*$)/ms';
		$updated_content = preg_replace_callback(
			$replace_regex,
			array( $this, 'group_block_replace_regex' ),
			$block_content
		);
		return $updated_content;
	}

	/**
	 * Update the block content with inner div.
	 *
	 * @since 3.7.1
	 * @access public
	 *
	 * @param mixed $matches block content.
	 *
	 * @return string New block content.
	 */
	public function group_block_replace_regex( $matches ) {
		return $matches[1] . '<div class="wp-block-group__inner-container">' . $matches[2] . '</div>' . $matches[3];
	}

}

/**
 * Kicking this off by object
 */
new Astra_Gutenberg();
