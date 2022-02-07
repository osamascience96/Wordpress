<?php

?>

<span class="author vcard"><?php echo esc_html__('By ', 'livemesh-el-addons'); ?>
    <a class="url fn n"
       href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
       title="<?php echo get_the_author_meta('display_name'); ?>"><?php echo esc_html(get_the_author_meta('display_name')); ?></a>
</span>