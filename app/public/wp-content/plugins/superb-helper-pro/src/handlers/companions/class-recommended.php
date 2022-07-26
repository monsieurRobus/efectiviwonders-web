<?php

namespace SuperbHelperPro\Companions;

use SuperbHelperPro\Data\DataController;

if (! defined('WPINC')) {
    die;
}

class RecommendedController
{
    public function __construct()
    {
        try {
            $this->db = DataController::GetInstance();
            $settings = $this->db->get_settings();
            if (!$settings['recommended']) {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
        add_action('admin_menu', array($this, 'spbhlpr_recommended_plugins_page'));
        add_action('admin_enqueue_scripts', array($this, 'spbhlpr_add_script_to_menu_page'));
        add_action('customize_register', array($this, 'superb_helper_pro_customizer_options'));
    }
    // Add recommended plugins page to the backend
    public function spbhlpr_recommended_plugins_page()
    {
        add_submenu_page('plugins.php', 'Recommended Plugins', 'Recommended <span style="font-size: 15px; margin-top: 1px;" class="dashicons dashicons-admin-plugins"></span>', 'manage_options', 'recommended-plugins-page', array($this,'spbhlpr_recommended_plugins_submenu_page_callback'));
    }

    // Add recommended plugins page css
    public function spbhlpr_add_script_to_menu_page()
    {
        global $pagenow;
        if ($pagenow != 'plugins.php') {
            return false;
        }
        wp_enqueue_style('superb-helper-pro-recommend', plugins_url('/assets/css/superbhelperpro-recommend.css', __FILE__));
    }

    // Recommended plugins page content
    public function spbhlpr_recommended_plugins_submenu_page_callback()
    {
        ?>
        <div class="superbhelperpro-recommend-wrap">

            <h1 class="superbhelperpro-recommend-wp-heading-inline wp-heading-inline">Recommended Plugins</h1>

            <div class="wp-filter superbhelperpro-recommend-wp-filter">
                <ul class="filter-links">
                    <li class="plugin-install-featured"><a class="current" aria-current="page">Recommended Plugins</a> </li>
                </ul>
            </div>


            <p class="superbhelperpro-recommend-italic">The following plugins are recommended by SuperbThemes for your WordPress theme. Even though most of the recommended plugins are free, some of the buttons contain an affiliate link, meaning that SuperbThemes will earn revenue if a purchase is made using these links. None of the plugins are required for your theme to work. Plugins extend and expand the functionality of WordPress.</p>

            <!--<form id="plugin-filter" method="post">-->
                <div class="wp-list-table widefat plugin-install">
                    <h2 class="screen-reader-text">Plugins list</h2>
                    <div id="the-list">


                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-wprocket">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        WP Rocket <img src="<?php echo SUPERBHELPERPRO_ASSETS_PATH.'/img/wprocket-logo-square.jpg'; ?>" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/theme-ref/wp-rocket" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>Speed up your WordPress website, more traffic, conversions and money with WP Rocket caching plugin.</p>
                                    <p class="authors">
                                        <cite>By 
                                            <a href="https://superbthemes.com/theme-ref/wp-rocket" target="_blank">WP Rocket</a>
                                        </cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->

                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-elementor">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        Elementor <img src="https://ps.w.org/elementor/assets/icon.svg?rev=1426809" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/theme-ref/elementor/" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites…</p>
                                    <p class="authors">
                                        <cite>By 
                                            <a href="https://superbthemes.com/theme-ref/elementor/" target="_blank">Elementor</a>
                                        </cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->

                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-superbhelper">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        Superb Tables <img src="https://ps.w.org/superb-tables/assets/icon-256x256.png?rev=2044672" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/plugins/superb-tables/" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>Create responsive tables easily & insert them with a shortcode. Lots of different designs, functions…</p>
                                    <p class="authors">
                                        <cite>By 
                                            <a target="_blank" href="https://superbthemes.com/plugins/superb-tables/">Suplugins</a>
                                        </cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->

                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-wp-forms">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        HubSpot – CRM, Email Marketing, Live Chat, Forms & Analytics <img src="https://ps.w.org/leadin/assets/icon-128x128.png" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/visit/hubspot/wp-plugin" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>Capture, organize and engage web visitors with free forms, live chat, CRM (contact management), email marketing, and analytics.</p>
                                    <p class="authors">
                                        <cite>By <a target="_blank" href="https://superbthemes.com/visit/hubspot">HubSpot</a></cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->

                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-wp-forms">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        Contact Form by WPForms – Drag & Drop Form Builder <img src="https://ps.w.org/wpforms-lite/assets/icon-128x128.png?" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/visit/wpforms" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>The best WordPress contact form plugin. Drag & Drop online form builder that helps you create beautiful contact forms with just a few clicks.</p>
                                    <p class="authors">
                                        <cite>By <a target="_blank" href="https://superbthemes.com/visit/wpforms">WP Forms</a></cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->

                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-shareandfollowbuttons">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        Share & Follow Buttons <img src="https://ps.w.org/superb-social-share-and-follow-buttons/assets/icon-256x256.png?rev=2109629" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/plugins/social-media-share-and-follow-buttons/" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>Social media share buttons & follow buttons, quick & easy! 25+ Social networks & 50+ options…</p>
                                    <p class="authors">
                                        <cite>By <a target="_blank" href="https://superbthemes.com/plugins/social-media-share-and-follow-buttons/">Suplugins</a></cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->

                        <!-- Plugin recommendation start-->
                        <div class="plugin-card plugin-card-shareandfollowbuttons">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        Reveal Buttons <img src="https://ps.w.org/coupon-reveal-button/assets/icon-256x256.png?rev=1896356" class="plugin-icon" alt="">
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li>
                                            <a class="install-now button superbhelper-recommend-install-now" data-slug="superb-tables" href="https://superbthemes.com/plugins/reveal-buttons/" target="_blank">Get Plugin <span class="dashicons dashicons-external"></span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p>Get your reveal buttons ready with our simple wordpress coupon plugin. Enter your text & link…</p>
                                    <p class="authors">
                                        <cite>By <a target="_blank" href="https://superbthemes.com/plugins/reveal-buttons/">Suplugins</a></cite>
                                    </p>
                                </div>
                            </div>
                            <div class="plugin-card-bottom spbhlp-card-bottom">
                                <div class="column-compatibility superbhelperpro-recommend-column-compatibility">
                                    <span class="compatibility-compatible">
                                        <strong>Compatible</strong> with your version of WordPress
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Plugin recommendation end-->
                    </div>
                </div>
                <!--</form>-->
            </div>
            <?php
    }

    // Customizer recommend
    public function superb_helper_pro_customizer_options($wp_customize)
    {
        $wp_customize->add_section('helperpro_recommend_elementor', array(
                'title'      => __('Recommended Plugins', 'superbhelperpro'),
                'priority'   => 1,
                'capability' => 'edit_theme_options',
            ));

        $wp_customize->add_setting('superbhelperpro_elementor_recommendation', array(
                'default' => 0,
                'sanitize_callback' => 'sanitize_text_field',
            ));

        $wp_customize->add_control('superbhelperpro_elementor_recommendation', array(
                'label'    => __('We recommend that you install the recommended plugins for even more customization options, such as drag & drop editor, page speed optimization and much more!', 'superbhelperpro'),
                'section'  => 'helperpro_recommend_elementor',

                'description'   =>  __('<a href="'. admin_url() .'plugins.php?page=recommended-plugins-page" style="font-style:normal;margin-top:20px;" class="button button-primary" target="_blank">'.__('View Recommended Plugins', 'superbhelperpro').'</a>', 'superbhelperpro'),
                'priority' => 0,
                'settings' => 'superbhelperpro_elementor_recommendation',
                'type'     => 'hidden',

            ));
    }
}
