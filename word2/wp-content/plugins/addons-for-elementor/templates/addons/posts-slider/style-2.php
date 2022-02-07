<?php
/**
 * Posts Slider Template 2
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-slider/style-2.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$taxonomies = array($settings['taxonomy_chosen']);

$post_id = get_the_ID();

?>

<div data-id="id-<?php echo get_the_ID(); ?>" class="lae-posts-slider-item">

    <article id="post-<?php echo get_the_ID(); ?>"
             class="lae-post-entry <?php echo join(' ', get_post_class('', $post_id)); ?>">

        <?php if ($thumbnail_exists = has_post_thumbnail() && $settings['display_thumbnail'] == 'yes'): ?>

            <?php if ($settings['image_linkable'] == 'yes'): ?>

                <a class="lae-post-link-overlay"
                   href="<?php echo get_the_permalink(); ?>"
                   target="<?php echo $target; ?>"></a>

            <?php endif; ?>

            <?php $image_setting = ['id' => get_post_thumbnail_id()]; ?>

            <?php $image_src = get_the_post_thumbnail_url($post_id, 'full'); ?>

            <div class="lae-post-overlay lae-post-featured-img-bg" style="background-image: url(<?php echo $image_src; ?>); height: <?php echo $settings['slider_height']; ?>px;">

                <?php if (($settings['display_title'] == 'yes') || ($settings['display_taxonomy'] == 'yes') || ($settings['display_summary'] == 'yes')): ?>

                    <div class="lae-post-text-wrap">

                        <div class="lae-post-text">

                            <?php if ($settings['display_taxonomy'] == 'yes'): ?>

                                <?php lae_get_template_part('post-meta/taxonomy-info', array('taxonomies' => $taxonomies)); ?>

                            <?php endif; ?>

                            <?php if ($settings['display_title'] == 'yes'): ?>

                                <?php lae_get_template_part('post-content/entry-title', array('target' => $target, 'title_tag' => $settings['entry_title_tag'])); ?>

                            <?php endif; ?>

                            <?php if (($settings['display_post_date'] == 'yes') || ($settings['display_author'] == 'yes') || ($settings['display_taxonomy'] == 'yes')) : ?>

                                <div class="lae-post-meta">

                                    <?php if ($settings['display_author'] == 'yes'): ?>

                                        <?php lae_get_template_part('post-meta/author'); ?>

                                    <?php endif; ?>

                                    <?php if ($settings['display_post_date'] == 'yes') : ?>

                                        <?php lae_get_template_part('post-meta/published'); ?>

                                    <?php endif; ?>

                                    <?php if ($settings['display_comments'] == 'yes') : ?>

                                        <?php lae_get_template_part('post-meta/comments-number'); ?>

                                    <?php endif; ?>

                                </div>

                            <?php endif; ?>

                            <?php if ($settings['display_summary'] == 'yes') : ?>

                                <?php lae_get_template_part('post-content/entry-summary'); ?>

                            <?php endif; ?>

                        </div><!-- .lae-post-info -->

                    </div>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </article><!-- .hentry -->

</div><!-- .lae-posts-slider-item -->

