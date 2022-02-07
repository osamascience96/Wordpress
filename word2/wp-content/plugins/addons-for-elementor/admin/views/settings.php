<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$theme_color = lae_get_option( 'lae_theme_color', '#f94213' );
$theme_hover_color = lae_get_option( 'lae_theme_hover_color', '#888888' );
$debug_mode = lae_get_option( 'lae_enable_debug', false );
$custom_css = lae_get_option( 'lae_custom_css', '' );
/* Deactivation of Elementor Elements */
$deactivate_element_carousel = lae_get_option( 'lae_deactivate_element_carousel', false );
$deactivate_element_clients = lae_get_option( 'lae_deactivate_element_clients', false );
$deactivate_element_heading = lae_get_option( 'lae_deactivate_element_heading', false );
$deactivate_element_odometers = lae_get_option( 'lae_deactivate_element_odometers', false );
$deactivate_element_piecharts = lae_get_option( 'lae_deactivate_element_piecharts', false );
$deactivate_element_portfolio = lae_get_option( 'lae_deactivate_element_portfolio', false );
$deactivate_element_posts_carousel = lae_get_option( 'lae_deactivate_element_posts_carousel', false );
$deactivate_element_posts_slider = lae_get_option( 'lae_deactivate_element_posts_slider', false );
$deactivate_element_posts_multislider = lae_get_option( 'lae_deactivate_element_posts_multislider', false );
$deactivate_element_posts_gridbox_slider = lae_get_option( 'lae_deactivate_element_posts_gridbox_slider', false );
$deactivate_element_pricing_table = lae_get_option( 'lae_deactivate_element_pricing_table', false );
$deactivate_element_services = lae_get_option( 'lae_deactivate_element_services', false );
$deactivate_element_message_box = lae_get_option( 'lae_deactivate_element_message_box', false );
$deactivate_element_stats_bar = lae_get_option( 'lae_deactivate_element_stats_bar', false );
$deactivate_element_team = lae_get_option( 'lae_deactivate_element_team', false );
$deactivate_element_testimonials = lae_get_option( 'lae_deactivate_element_testimonials', false );
$deactivate_element_testimonials_slider = lae_get_option( 'lae_deactivate_element_testimonials_slider', false );
$deactivate_element_tab_slider = lae_get_option( 'lae_deactivate_element_tab_slider', false );
?>

<div class="lae-settings">

    <div class="postbox">

        <!-------------------
        OPTIONS HOLDER START
        -------------------->
        <div class="lae-menu-options settings-options">

            <div class="lae-inner">

                <!-------------------  LI TABS -------------------->

                <ul class="lae-tabs-wrap">
                    <li class="lae-tab selected" data-target="general"><i
                                class="lae-icon dashicons dashicons-admin-generic"></i><?php 
echo  __( 'General', 'livemesh-el-addons' ) ;
?>
                    </li>
                    <li class="lae-tab" data-target="elements"><i
                                class="lae-icon dashicons dashicons-admin-settings"></i><?php 
echo  __( 'Elements', 'livemesh-el-addons' ) ;
?>
                    </li>
                    <?php 
?>
                    <li class="lae-tab" data-target="custom-css"><i
                                class="lae-icon dashicons dashicons-editor-code"></i><?php 
echo  __( 'Custom CSS', 'livemesh-el-addons' ) ;
?>
                    </li>
                    <li class="lae-tab" data-target="debugging"><i
                                class="lae-icon dashicons dashicons-warning"></i><?php 
echo  __( 'Debugging', 'livemesh-el-addons' ) ;
?>
                    </li>
                    <li class="lae-tab" data-target="premium-version"><i
                                class="lae-icon dashicons dashicons-yes"></i><?php 
echo  __( 'Premium Version', 'livemesh-el-addons' ) ;
?>
                    </li>
                </ul>

                <!-------------------  GENERAL TAB -------------------->

                <div class="lae-tab-content general lae-tab-show">

                    <!---- Theme Colors -->
                    <div class="lae-box-side">
                        <h3><?php 
echo  __( 'Theme Colors', 'livemesh-el-addons' ) ;
?></h3>
                    </div>
                    <div class="lae-inner lae-box-inner">
                        <div class="lae-row lae-field">
                            <label
                                    class="lae-label"><?php 
echo  __( 'Theme Color Scheme', 'livemesh-el-addons' ) ;
?></label>
                            <p class="lae-desc"><?php 
echo  __( 'Most themes use a single color as a major color across the site. This color is often used for links, titles, buttons, icons, highlights etc. <br> To maintain the consistent look with the theme, specify the default color used by the theme activated on your site. This color will be applied to the plugin addon controls by default. <br>The hover color refers to the color set for links on mouse hover.', 'livemesh-el-addons' ) ;
?></p>
                        </div>

                        <div class="lae-clearfix"></div>

                        <!---- Theme color -->
                        <div class="lae-row lae-field lae-type-color">
                            <label class="lae-label"><?php 
echo  __( 'Theme Color', 'livemesh-el-addons' ) ;
?></label>
                            <p class="lae-desc"><?php 
echo  __( 'Select the default theme color.', 'livemesh-el-addons' ) ;
?></p>
                            <div class="lae-spacer" style="height: 5px"></div>
                            <input class="lae-colorpicker" name="lae_theme_color" type="text"
                                   data-default="#f94213" value="<?php 
echo  $theme_color ;
?>"/>
                        </div>


                        <div class="lae-spacer"></div>

                        <!---- Theme Hover color -->
                        <div class="lae-row lae-field lae-type-color">
                            <label class="lae-label"><?php 
echo  __( 'Theme Hover Color', 'livemesh-el-addons' ) ;
?></label>
                            <p class="lae-desc"><?php 
echo  __( 'Select the default hover color for your theme.', 'livemesh-el-addons' ) ;
?></p>
                            <div class="lae-spacer" style="height: 5px"></div>
                            <input class="lae-colorpicker" name="lae_theme_hover_color" type="text"
                                   data-default="#888888" value="<?php 
echo  $theme_hover_color ;
?>"/>
                        </div>


                    </div>

                    <div class="lae-clearfix"></div>


                </div>

                <?php 
?>


                <!-------------------  ELEMENTS TAB -------------------->

                <div class="lae-tab-content elements">

                    <!---- Auto activate Elementor Addons -->
                    <div class="lae-box-side">

                        <h3><?php 
echo  __( 'Optimize Plugin', 'livemesh-el-addons' ) ;
?></h3>

                    </div>

                    <div class="lae-inner lae-box-inner">


                        <div class="lae-row lae-field">
                            <label class="lae-label"><?php 
echo  __( 'Deactivate elements for better performance', 'livemesh-el-addons' ) ;
?></label>

                            <p class="lae-desc"><?php 
echo  __( 'You can deactivate those elements that you do not intend to use to avoid loading scripts and files related to those elements.', 'livemesh-el-addons' ) ;
?></p>
                        </div>

                        <div class="lae-spacer" style="height: 15px"></div>

                        <div class="lae-elements-deactivate">

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Carousel', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the carousel element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox" name="lae_deactivate_element_carousel"
                                           id="lae_deactivate_element_carousel" data-default=""
                                           value="<?php 
echo  $deactivate_element_carousel ;
?>" <?php 
echo  checked( !empty($deactivate_element_carousel), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_carousel"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Clients', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the clients element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox" name="lae_deactivate_element_clients"
                                           id="lae_deactivate_element_clients" data-default=""
                                           value="<?php 
echo  $deactivate_element_clients ;
?>" <?php 
echo  checked( !empty($deactivate_element_clients), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_clients"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Heading', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the heading element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox" name="lae_deactivate_element_heading"
                                           id="lae_deactivate_element_heading" data-default=""
                                           value="<?php 
echo  $deactivate_element_heading ;
?>" <?php 
echo  checked( !empty($deactivate_element_heading), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_heading"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Odometers', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the odometers element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_odometers"
                                           id="lae_deactivate_element_odometers" data-default=""
                                           value="<?php 
echo  $deactivate_element_odometers ;
?>" <?php 
echo  checked( !empty($deactivate_element_odometers), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_odometers"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Piecharts', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the piecharts element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_piecharts"
                                           id="lae_deactivate_element_piecharts" data-default=""
                                           value="<?php 
echo  $deactivate_element_piecharts ;
?>" <?php 
echo  checked( !empty($deactivate_element_piecharts), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_piecharts"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Portfolio', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the portfolio element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_portfolio"
                                           id="lae_deactivate_element_portfolio" data-default=""
                                           value="<?php 
echo  $deactivate_element_portfolio ;
?>" <?php 
echo  checked( !empty($deactivate_element_portfolio), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_portfolio"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Posts Carousel', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the posts carousel element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_posts_carousel"
                                           id="lae_deactivate_element_posts_carousel" data-default=""
                                           value="<?php 
echo  $deactivate_element_posts_carousel ;
?>" <?php 
echo  checked( !empty($deactivate_element_posts_carousel), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_posts_carousel"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Posts Slider', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the Posts Slider element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_posts_slider"
                                           id="lae_deactivate_element_posts_slider" data-default=""
                                           value="<?php 
echo  $deactivate_element_posts_slider ;
?>" <?php 
echo  checked( !empty($deactivate_element_posts_slider), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_posts_slider"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Posts Grid Box Slider', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the Posts Grid Box Slider element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_posts_gridbox_slider"
                                           id="lae_deactivate_element_posts_gridbox_slider" data-default=""
                                           value="<?php 
echo  $deactivate_element_posts_gridbox_slider ;
?>" <?php 
echo  checked( !empty($deactivate_element_posts_gridbox_slider), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_posts_gridbox_slider"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Posts Multislider', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the Posts Multislider element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_posts_multislider"
                                           id="lae_deactivate_element_posts_multislider" data-default=""
                                           value="<?php 
echo  $deactivate_element_posts_multislider ;
?>" <?php 
echo  checked( !empty($deactivate_element_posts_multislider), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_posts_multislider"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Pricing Table', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the pricing table element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_pricing_table"
                                           id="lae_deactivate_element_pricing_table" data-default=""
                                           value="<?php 
echo  $deactivate_element_pricing_table ;
?>" <?php 
echo  checked( !empty($deactivate_element_pricing_table), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_pricing_table"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Services', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the services element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox" name="lae_deactivate_element_services"
                                           id="lae_deactivate_element_spacer" data-default=""
                                           value="<?php 
echo  $deactivate_element_services ;
?>" <?php 
echo  checked( !empty($deactivate_element_services), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_services"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Message Box', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the message box element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox" name="lae_deactivate_element_message_box"
                                           id="lae_deactivate_element_spacer" data-default=""
                                           value="<?php 
echo  $deactivate_element_message_box ;
?>" <?php 
echo  checked( !empty($deactivate_element_message_box), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_message_box"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Stats Bars', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the stats bars element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_stats_bar"
                                           id="lae_deactivate_element_stats_bar" data-default=""
                                           value="<?php 
echo  $deactivate_element_stats_bar ;
?>" <?php 
echo  checked( !empty($deactivate_element_stats_bar), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_stats_bar"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Team', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the team element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox" name="lae_deactivate_element_team"
                                           id="lae_deactivate_element_team" data-default=""
                                           value="<?php 
echo  $deactivate_element_team ;
?>" <?php 
echo  checked( !empty($deactivate_element_team), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_team"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Testimonials', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the testimonials element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_testimonials"
                                           id="lae_deactivate_element_testimonials" data-default=""
                                           value="<?php 
echo  $deactivate_element_testimonials ;
?>" <?php 
echo  checked( !empty($deactivate_element_testimonials), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_testimonials"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Testimonials Slider', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the testimonials slider element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_testimonials_slider"
                                           id="lae_deactivate_element_testimonials_slider" data-default=""
                                           value="<?php 
echo  $deactivate_element_testimonials_slider ;
?>" <?php 
echo  checked( !empty($deactivate_element_testimonials_slider), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_testimonials_slider"></label>
                                </div>
                            </div>

                            <div class="lae-row lae-type-checkbox lae-field">
                                <label class="lae-label"><?php 
echo  __( 'Deactivate Tab Slider', 'livemesh-el-addons' ) ;
?></label>
                                <p class="lae-desc"><?php 
echo  __( 'Deactivate the tab slider element.', 'livemesh-el-addons' ) ;
?></p>
                                <div class="lae-spacer" style="height: 5px"></div>
                                <div class="lae-toggle">
                                    <input type="checkbox" class="lae-checkbox"
                                           name="lae_deactivate_element_tab_slider"
                                           id="lae_deactivate_element_tab_slider" data-default=""
                                           value="<?php 
echo  $deactivate_element_tab_slider ;
?>" <?php 
echo  checked( !empty($deactivate_element_tab_slider), 1, false ) ;
?>>
                                    <label for="lae_deactivate_element_tab_slider"></label>
                                </div>
                            </div>

                            <?php 
?>

                        </div>

                    </div>

                    <div class="lae-spacer"></div>

                    <div class="lae-clearfix"></div>


                </div>

                <!------------------- Custom CSS TAB -------------------->

                <div class="lae-tab-content custom-css">

                    <!---- Custom CSS -->
                    <div class="lae-box-side">
                        <h3><?php 
echo  __( 'Custom CSS', 'livemesh-el-addons' ) ;
?></h3>
                    </div>
                    <div class="lae-inner lae-box-inner">
                        <div class="lae-row lae-field lae-custom-css">
                            <label
                                    class="lae-label"><?php 
echo  __( 'Custom CSS', 'livemesh-el-addons' ) ;
?></label>
                            <div class="lae-spacer" style="height: 5px"></div>
                            <p class="lae-desc"><?php 
echo  __( 'Please enter custom CSS for custom styling of addons', 'livemesh-el-addons' ) ;
?></p>

                            <div class="lae-spacer" style="height: 15px"></div>

                            <textarea class="lae-textarea" name="lae_custom_css" id="lae_custom_css" rows="20"
                                      cols="120"><?php 
echo  $custom_css ;
?></textarea>

                        </div>
                    </div>

                    <div class="lae-clearfix"></div>

                </div>

                <!------------------- Debugging TAB -------------------->

                <div class="lae-tab-content debugging">

                    <!---- Enable script debugging -->
                    <div class="lae-box-side">
                        <h3><?php 
echo  __( 'Debug Mode', 'livemesh-el-addons' ) ;
?></h3>
                    </div>
                    <div class="lae-inner lae-box-inner">
                        <div class="lae-spacer" style="height: 15px"></div>
                        <label
                                class="lae-label lae-label-outside"><?php 
echo  __( 'Enable Script Debug Mode', 'livemesh-el-addons' ) ;
?></label>
                        <div class="lae-row lae-type-checkbox lae-field">
                            <p class="lae-desc"><?php 
echo  __( 'Use unminified Javascript files instead of minified ones to help developers debug an issue', 'livemesh-el-addons' ) ;
?></p>
                            <div class="lae-toggle">
                                <input type="checkbox" class="lae-checkbox" name="lae_enable_debug"
                                       id="lae_enable_debug"
                                       data-default=""
                                       value="<?php 
echo  $debug_mode ;
?>" <?php 
echo  checked( !empty($debug_mode), 1, false ) ;
?>>
                                <label for="lae_enable_debug"></label>
                            </div>
                        </div>
                    </div>

                    <div class="lae-clearfix"></div>

                    <!---- System Info -->
                    <div class="lae-box-side">
                        <h3><?php 
echo  __( 'System Info', 'livemesh-el-addons' ) ;
?></h3>
                    </div>
                    <div class="lae-inner lae-box-inner">

                        <div class="lae-row lae-field">
                            <label
                                    class="lae-label"><?php 
echo  __( 'System Information', 'livemesh-el-addons' ) ;
?></label>
                            <p class="lae-desc"><?php 
echo  __( 'Server setup information useful for debugging purposes.', 'livemesh-el-addons' ) ;
?></p>

                            <div class="lae-spacer" style="height: 15px"></div>

                            <p class="debug-info"><?php 
echo  nl2br( lae_get_sysinfo() ) ;
?></p>
                        </div>

                    </div>

                    <div class="lae-clearfix"></div>

                </div>

                <!------------------- PREMIUM VERSION TAB -------------------->

                <div class="lae-tab-content premium-version">

                    <!---- Premium Version Information -->
                    <div class="lae-box-side">
                        <h3><?php 
echo  __( 'Premium Version', 'livemesh-el-addons' ) ;
?></h3>
                    </div>
                    <div class="lae-inner lae-box-inner">


                        <div class="lae-row lae-field lae_premium_version">

                            <?php 

if ( lae_fs()->is_not_paying() ) {
    ?>

                                <label class="lae-label"><?php 
    echo  __( 'Why upgrade to Premium Version of the plugin?!', 'livemesh-el-addons' ) ;
    ?></label>

                            <?php 
} else {
    ?>

                                <label class="lae-label"><?php 
    echo  __( 'Thanks for upgrading to the Premium Version of the plugin!', 'livemesh-el-addons' ) ;
    ?></label>

                            <?php 
}

?>

                            <p>The premium version helps us to continue development of this plugin incorporating even
                                more features and enhancements along with offering more responsive support. Following
                                are
                                some of the reasons why you may want to upgrade to the premium version of this
                                plugin.</p>

                            <label class="lae-label">New Premium Widgets</label>

                            <p>Although the free version of the Addons for Elementor features a large repertoire of
                                premium quality addons, the premium
                                version does even more.</p>


                            <ul>
                                <li><a href="https://livemeshelementor.com/posts-block/" title="Post Blocks Addon"
                                       target="_blank">Post
                                        Blocks!</a> - Present your blog posts, events, news items or portfolio in a
                                    dozen creative ways. Comes with AJAX filtering,
                                    pagination and load more features to help visitors navigate your entire collection
                                    of blog posts or custom post types and
                                    their categories without reloading the page.
                                </li>
                                <li><a href="https://livemeshelementor.com/twitter-grid/" title="Twitter Grid Addon">Twitter Grid</a> to help showcase tweets on your site with load more option.</li>
                                <li><a href="https://livemeshelementor.com/youtube-grid/" title="YouTube Grid Addon">YouTube Grid</a> to display a collection of YouTube videos obtained from YouTube API given a Channel ID, PlayList ID or a list of Video IDs. Load More option is provided.</li>
                                <li><a href="https://livemeshelementor.com/vimeo-grid/" title="Vimeo Grid Addon">Vimeo Grid</a> to help showcase showcase a collection of Vimeo videos obtained using Vimeo API given a User ID, Channel ID, Album ID or a Group ID. Load More option is provided.</li>
                                <li><a href="https://livemeshelementor.com/instagram-grid/" title="Instagram Grid Addon">Instagram Grid</a> to help display images and videos obtained from Instagram API given one or more user names or hash tags.</li>
                                <li><a href="https://livemeshelementor.com/woocommerce-grid/" title="WooCommerce Grid Addon">WooCommerce Grid</a> is an enhancement of Posts Grid addon that lets you capture details of WooCommerce products like name, price, rating, add to cart, add to wish list etc. Comes with a quick view option to display product details in a modal window.</li>
                                <li><a href="https://livemeshelementor.com/tabs/" title="Tabs Addon" target="_blank">Responsive
                                        Tabs</a> - Exquisitely designed tabs that function seamlessly across all devices
                                    and resolutions. The
                                    plugin features never before choice of over dozen styles of tabs to choose from.
                                </li>
                                <li><a href="https://livemeshelementor.com/accordion/" title="Accordion/Toggle Addon"
                                       target="_blank">Accordion/Toggle</a> - Controls
                                    that capture collapsible content panels when space is limited.
                                </li>
                                <li><a href="https://livemeshelementor.com/sliders/" title="Image Slider Widget"
                                       target="_blank">Image
                                        Slider</a> - Create a responsive slider of images with support
                                    for captions,
                                    multiple slider types like Nivo, Flex, Slick and lightweight sliders, thumbnail
                                    navigation etc.
                                </li>
                                <li><a href="https://livemeshelementor.com/image-gallery/" title="Image Gallery Widget"
                                       target="_blank">Image
                                        Gallery</a> - Create a gallery of images with options for masonry
                                    or fit rows, pagination, lazy load, lightbox support etc.
                                </li>
                                <li><a href="https://livemeshelementor.com/video-gallery/" title="Video Gallery Widget"
                                       target="_blank">Video
                                        Gallery</a> - Create a beautiful gallery of videos to help
                                    showcase a collection of YouTube/Vimeo videos on your site.
                                </li>
                                <li><a href="https://livemeshelementor.com/gallery-carousel/" title="Image Carousel"
                                       target="_blank">Image
                                        Carousel</a> - Build a responsive carousel of images.
                                </li>
                                <li><a href="https://livemeshelementor.com/gallery-carousel/" title="Video Carousel"
                                       target="_blank">Video
                                        Carousel</a> - Build a responsive carousel of YouTube/Vimeo
                                    videos.
                                </li>
                                <li><a href="https://livemeshelementor.com/buttons/" title="Buttons Addon"
                                       target="_blank">Buttons</a> - Animated buttons with great choice of colors.
                                </li>
                                <li><a href="https://livemeshelementor.com/icon-lists/" title="Icon List"
                                       target="_blank">Icon List</a> - - Create a list of icons with description and
                                    link - for social media profiles,
                                    for showcasing services or features as well with icons or images.
                                </li>
                                <li><a href="https://livemeshelementor.com/faq-element/" title="FAQ Addon"
                                       target="_blank">FAQ</a> - Create a set of Frequently Asked Questions for display
                                    in a
                                    page.
                                </li>
                                <li><a href="https://livemeshelementor.com/features/" title="Features Addon"
                                       target="_blank">Features Addon</a> for showcasing product features or services
                                    provided by an agency/business.
                                </li>
                            </ul>

                            <div class="lae-spacer" style="height: 15px"></div>

                            <?php 

if ( lae_fs()->is_not_paying() ) {
    ?>

                                <a class="lae-button purchase" href="<?php 
    echo  lae_fs()->get_upgrade_url() ;
    ?>"><i
                                            class="dashicons dashicons-cart"></i><?php 
    echo  __( 'Purchase Now', 'livemesh-el-addons' ) ;
    ?>
                                </a>

                                <div class="lae-spacer" style="height: 25px"></div>

                            <?php 
}

?>

                            <label class="lae-label">Additional Features</label>

                            <p>Along with incorporating many new elements into premium version, the pro version is being
                                updated with additional features for existing elements -</p>

                            <ul>
                                <li><a href="https://livemeshelementor.com/portfolio-grid-pro/" title="Posts Grid"
                                       target="_blank">Lazy Load</a> - The portfolio/post grid and image gallery
                                    elements
                                    incorporate option to lazy load posts/images with the click of a Load More button.
                                </li>
                                <li><a href="https://livemeshelementor.com/portfolio-grid-pro/" title="Posts Grid"
                                       target="_blank">Load on Scroll or Infinite Scroll</a> - The portfolio/post grid and image gallery
                                    elements
                                    incorporate option to lazy load posts/images automatically as the user scrolls down the page (infinite scroll).
                                </li>
                                <li><a href="https://livemeshelementor.com/portfolio-grid-pro/" title="Posts Grid"
                                       target="_blank">Pagination</a> - Create a grid of posts or custom post types with
                                    AJAX
                                    based pagination support.
                                </li>
                                <li><a href="https://livemeshelementor.com/woocommerce-grid/" title="WooCommerce Grid Addon">WooCommerce Grid</a> is an enhancement of Posts Grid addon that lets you capture details of WooCommerce products like name, price, rating, add to cart, add to wish list etc. Comes with a quick view option to display product details in a modal window.</li>

                                <li><strong>Multiple Skins/Styles</strong> - The premium version comes with support for about eight skins for posts/portfolio grid.
                                </li>
                                <li><strong>Header Styles</strong> - About seven header styles with responsive dropdown support for filters on posts/portfolio grid.
                                </li>
                                <li><strong>Lightbox Support</strong> - The premium version comes with support for
                                    Lightbox for grid and carousel elements.
                                </li>
                                <li><strong>Custom Animations</strong> - Choose from over <strong>40+
                                        animations</strong>
                                    for most elements (excludes sliders, carousels and grid). The animations display on
                                    user scrolling to the element or when the element becomes visible in the browser
                                    window.
                                </li>
                                <li><strong>Sample Data</strong> - Sample data that you can import into your site to get
                                    started quickly on the addon elements and some sample layouts.
                                </li>
                            </ul>

                            <label class="lae-label">Premium Support</label>

                            <p>We offer premium support for our paid customers with following benefits - </p>

                            <ul>
                                <li><strong>Dedicated Support Portal</strong> - The customers will be provided access to
                                    a
                                    dedicated support portal powered by Freshdesk.
                                </li>
                                <li><strong>Private Tickets</strong> - Private tickets help you work with us
                                    directly regarding the issues you are facing in your site by sharing the details of
                                    your site securely.
                                </li>
                                <li><strong>Faster turnaround</strong> - The threads opened by paid customers will be
                                    attended to within 24 hours of opening a ticket.
                                </li>
                                <li><strong>Bug fixes and Enhancements</strong> - Any fixes and enhancements made to the
                                    elements will be prioritized to arrive quicker on the premium version.
                                </li>
                                <li><strong>Proven Expertize</strong> - Having served over <strong>12,280+
                                        customers</strong> of our themes over past 3 years, the support provided by us
                                    is proven in competence and commitment.
                                </li>
                            </ul>

                            <div class="lae-spacer" style="height: 25px"></div>

                            <?php 

if ( lae_fs()->is_not_paying() ) {
    ?>

                                <a class="lae-button purchase" href="<?php 
    echo  lae_fs()->get_upgrade_url() ;
    ?>"><i
                                            class="dashicons dashicons-cart"></i><?php 
    echo  __( 'Go Premium', 'livemesh-el-addons' ) ;
    ?>
                                </a>

                            <?php 
} else {
    ?>

                                <a class="lae-button know-more" href="https://livemeshelementor.com/"><i
                                            class="dashicons dashicons-external"></i><?php 
    echo  __( 'Know More', 'livemesh-el-addons' ) ;
    ?>
                                </a>

                            <?php 
}

?>


                        </div>

                    </div>

                </div>

                <!-------------------  OPTIONS HOLDER END  -------------------->
            </div>

        </div>

        <!------------------- BUILD PANEL SETTINGS -------------------->

    </div>

</div>
