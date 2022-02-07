<?php
/**
 * Social Profile Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/team-members/social-profile.php
 *
 */
?>

<div class="lae-social-wrap">
    <div class="lae-social-list">

        <?php

        $email = $team_member['member_email'];
        $facebook_url = $team_member['facebook_url'];
        $twitter_url = $team_member['twitter_url'];
        $linkedin_url = $team_member['linkedin_url'];
        $dribbble_url = $team_member['dribbble_url'];
        $pinterest_url = $team_member['pinterest_url'];
        $googleplus_url = $team_member['google_plus_url'];
        $instagram_url = $team_member['instagram_url'];

        ?>
        <?php if ($email): ?>
            <div class="lae-social-list-item">
                <a class="lae-email" href="mailto:<?php echo $email; ?>"
                   title="<?php echo __("Send an email", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-email"></i>
                </a>
            </div>
        <?php endif; ?>
        <?php if ($facebook_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-facebook" href="<?php echo $facebook_url; ?>"
                   target="_blank"
                   title="<?php echo __("Follow on Facebook", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-facebook"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($twitter_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-twitter" href="<?php echo $twitter_url; ?>" target="_blank"
                   title="<?php echo __("Subscribe to Twitter Feed", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-twitter"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($linkedin_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-linkedin" href="<?php echo $linkedin_url; ?>"
                   target="_blank"
                   title="<?php echo __("View LinkedIn Profile", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-linkedin">

                    </i>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($googleplus_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-googleplus" href="<?php echo $googleplus_url; ?>"
                   target="_blank"
                   title="<?php echo __("Follow on Google Plus", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-googleplus"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($instagram_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-instagram" href="<?php echo $instagram_url; ?>"
                   target="_blank"
                   title="<?php echo __("View Instagram Feed", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-instagram"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($pinterest_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-pinterest" href="<?php echo $pinterest_url; ?>"
                   target="_blank"
                   title="<?php echo __("Subscribe to Pinterest Feed", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-pinterest"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($dribbble_url): ?>
            <div class="lae-social-list-item">
                <a class="lae-dribbble" href="<?php echo $dribbble_url; ?>" target="_blank"
                   title="<?php echo __("View Dribbble Portfolio", 'livemesh-el-addons'); ?>">
                    <i class="lae-icon-dribbble"></i>
                </a>
            </div>
        <?php endif; ?>

    </div><!-- .lae-social-list -->
</div><!-- .lae-social-wrap -->


