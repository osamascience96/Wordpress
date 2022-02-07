<?php
/**
 * Content - Posts Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-carousel/content.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div data-id="id-<?php echo get_the_ID(); ?>" class="lae-posts-carousel-item">

    <article id="post-<?php echo get_the_ID(); ?>" class="<?php echo join(' ', get_post_class('', $post_id)); ?>">

        <?php if ($settings['carousel_skin'] == 'custom_skin') : ?>

            <?php lae_get_template_part('addons/posts-carousel/custom-skin', $args); ?>

        <?php else : ?>

            <?php $target = $settings['post_link_new_window'] == 'yes' ? ' target="_blank"' : ''; ?>

            <?php $taxonomies = array($settings['taxonomy_chosen']); ?>

            <?php if ($thumbnail_exists = has_post_thumbnail() && $settings['display_thumbnail'] == 'yes'): ?>

                <div class="lae-project-image">

                    <?php $image_setting = ['id' => get_post_thumbnail_id()]; ?>

                    <?php $thumbnail_html = lae_get_image_html($image_setting, 'thumbnail_size', $settings); ?>

                    <?php if ($settings['image_linkable'] == 'yes'): ?>

                        <a href="<?php echo get_the_permalink(); ?>"<?php echo $target; ?>><?php echo $thumbnail_html; ?></a>

                    <?php else: ?>

                        <?php echo $thumbnail_html; ?>

                    <?php endif; ?>

                    <?php if (($settings['display_title_on_thumbnail'] == 'yes') || ($settings['display_taxonomy_on_thumbnail'] == 'yes')): ?>

                        <div class="lae-image-info">

                            <div class="lae-entry-info">

                                <?php if ($settings['display_title_on_thumbnail'] == 'yes'): ?>

                                    <<?php echo lae_validate_html_tag($settings['title_tag']); ?> class="lae-post-title">

                                        <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"
                                           rel="bookmark"<?php echo $target; ?>><?php echo get_the_title(); ?></a>

                                    </<?php echo lae_validate_html_tag($settings['title_tag']); ?>>

                                <?php endif; ?>

                                <?php if ($settings['display_taxonomy_on_thumbnail'] == 'yes'): ?>

                                    <?php echo lae_get_info_for_taxonomies($taxonomies); ?>

                                <?php endif; ?>

                            </div>

                        </div><!-- .lae-image-info -->

                    <?php endif; ?>

                </div>

            <?php endif; ?>

            <?php if (($settings['display_title'] == 'yes') || ($settings['display_summary'] == 'yes')) : ?>

                <div class="lae-entry-text-wrap <?php echo($thumbnail_exists ? '' : ' nothumbnail'); ?>">

                    <?php if ($settings['display_title'] == 'yes') : ?>

                        <<?php echo lae_validate_html_tag($settings['entry_title_tag']); ?> class="entry-title">

                            <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"
                               rel="bookmark"<?php echo $target; ?>><?php echo get_the_title(); ?></a>

                        </<?php echo lae_validate_html_tag($settings['entry_title_tag']); ?>>

                    <?php endif; ?>

                    <?php if (($settings['display_post_date'] == 'yes') || ($settings['display_author'] == 'yes') || ($settings['display_taxonomy'] == 'yes')) : ?>

                        <div class="lae-entry-meta">

                            <?php

                            if ($settings['display_author'] == 'yes'):

                                echo lae_entry_author();

                            endif;

                            if ($settings['display_post_date'] == 'yes'):

                                echo lae_entry_published();

                            endif;

                            if ($settings['display_taxonomy'] == 'yes'):

                                echo lae_get_info_for_taxonomies($taxonomies);

                            endif;

                            ?>

                        </div>

                    <?php endif; ?>

                    <?php if ($settings['display_summary'] == 'yes') : ?>

                        <div class="entry-summary">

                            <?php echo get_the_excerpt(); ?>

                        </div>

                    <?php endif; ?>

                    <?php if ($settings['display_read_more'] == 'yes') : ?>

                        <?php $read_more_text = $settings['read_more_text']; ?>

                        <div class="lae-read-more">

                            <a href="<?php echo get_the_permalink(); ?>"<?php echo $target; ?>><?php echo $read_more_text; ?></a>

                        </div>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </article><!-- .hentry -->

</div><!-- .lae-posts-carousel-item -->