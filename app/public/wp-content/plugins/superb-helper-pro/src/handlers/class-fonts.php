<?php
namespace SuperbHelperPro\Handlers;

use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Utils\spbhlprproException;

use Exception;

if (! defined('WPINC')) {
    die;
}

class FontController
{
    private $BASE_PANEL_TITLE;
    private $SECTION_DESCRIPTION;
    private $THEME;
    
    private $SlideshowEnabled = false;
    private $SidebarEnabled = false;
    private $HeaderEnabled = false;

    public function __construct()
    {
        $this->BASE_PANEL_TITLE = esc_html__('SuperbThemes Typography', 'superbhelperpro');
        if (\is_plugin_active('easy-google-fonts/easy-google-fonts.php')) {
            try {
                \delete_option("egf_force_user_redirect");
                $this->THEME = \wp_get_theme()->get_stylesheet();
                $this->SECTION_DESCRIPTION = esc_html__('Use the font controls below to customize font size, font family and more.', 'superbhelperpro');
                \add_action('customize_register', array($this, 'spbhlprpro_customizer_panel'), 100);
                \add_action('tt_font_get_option_parameters', array($this, 'spbhlprpro_add_egs_controls'), 200);
            } catch (Exception $ex) {
                return;
            }
        } else {
            \add_action('customize_register', array($this, 'spbhlprpro_no_egs_section'), 100);
        }
    }

    public function spbhlprpro_font_control_scripts()
    {
        echo "<style>ul#sub-accordion-panel-spbhlprpro-font-control-panel .description.customize-panel-description, #accordion-section-spbhlprpro-no-egs {
            display: block !important;
            visibility: visible !important;
        }</style>";
        echo "<script>jQuery(document).ready(function($){
            $('.customize-control.customize-control-font .components-button.components-panel__body-toggle').click(function(){
                setTimeout(function(){
                $('.egf-font-control__tab.components-tab-panel__tabs-item').click(function(){
                    setTimeout(function(){
                    $('.egf-font-color-control .components-dropdown button, .egf-background-color-control .components-dropdown button').attr('type','button');
                    },0);
                });
                },0);
            });
        });</script>";
    }

    public function spbhlprpro_no_egs_section($wp_customize)
    {
        \add_action('customize_controls_print_footer_scripts', array($this, 'spbhlprpro_font_control_scripts'), 100);
        $wp_customize->add_section('spbhlprpro-no-egs', array(
            'priority'       => 1,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => $this->BASE_PANEL_TITLE,
            'description'    => "The plugin <strong>Easy Google Fonts</strong> is needed for the SuperbThemes Typography settings. You'll need to activate this plugin to use these settings. If you haven't already, you'll need to install the <strong>Easy Google Fonts</strong> plugin, or reinstall your theme in Superb Helper Pro while 'Install Companion Plugins' is active in the licensing settings."
        ));
    }

    public function spbhlprpro_customizer_panel($wp_customize)
    {
        try {
            $currentTheme = ProductController::get_validated_product(\get_template());
            // No exceptions, theme validated
            \add_action('customize_controls_print_footer_scripts', array($this, 'spbhlprpro_font_control_scripts'), 100);
        } catch (spbhlprproException $spex) {
            return;
        } catch (Exception $ex) {
            return;
        }

        $this->SlideshowEnabled = !is_null($wp_customize->get_panel('slideshow_settings'));

        $this->SidebarEnabled = !is_null($wp_customize->get_section('sidebar_settings'));

        $this->HeaderEnabled = (!is_null($wp_customize->get_section('image_banner')) || !is_null($wp_customize->get_section('header_image')));
        // Base Panel
        $wp_customize->add_panel('spbhlprpro-font-control-panel', array(
            'priority'       => 10,
             'capability'     => 'edit_theme_options',
             'theme_supports' => '',
             'title'          => $this->BASE_PANEL_TITLE,
             'description'    => 'Font controls for SuperbThemes elements - made easy with the Easy Google Fonts plugin. <br />Do note that some font controls are only supported if the theme has support for the element. For example, <strong>a font control for the sidebar will not work if the theme does not feature a sidebar.</strong>',
           ));

        $this->add_section(
            $wp_customize,
            "font-sitewide",
            esc_html__('Sitewide', 'superbhelperpro'),
            "<h3>Warning</h3>Setting a sitewide font will attempt to apply the font settings to all elements on your website. This setting may be overriden by other font settings, and may alternatively overwrite other font settings. Because of this, we recommend that you <strong style='color:red;'>only adjust the Font Family</strong> when using this font control."
        );

        $this->add_section(
            $wp_customize,
            "font-site-titles",
            esc_html__('Site Title & Tagline', 'superbhelperpro')
        );

        if ($this->HeaderEnabled) {
            $this->add_section(
                $wp_customize,
                "font-header",
                esc_html__('Header / Image Banner', 'superbhelperpro'),
                $this->SECTION_DESCRIPTION."<br />Do note that other settings may need to be adjusted, such as a larger background image, if the text size is increased beyond the size of the image banner / header.<br/>Some font controls, such as 'Buttons', will only work if the theme features such elements."
            );
        }

        if ($this->SlideshowEnabled) {
            $this->add_section(
                $wp_customize,
                "font-slideshow",
                esc_html__('Slideshow', 'superbhelperpro')
            );
        }

        $this->add_section(
            $wp_customize,
            "font-postspages",
            esc_html__('Posts & Pages', 'superbhelperpro')
        );

        $this->add_section(
            $wp_customize,
            "font-navigation",
            esc_html__('Navigation Menu', 'superbhelperpro')
        );

        if ($this->SidebarEnabled) {
            $this->add_section(
                $wp_customize,
                "font-sidebar",
                esc_html__('Sidebar', 'superbhelperpro')
            );
        }

        $this->add_section(
            $wp_customize,
            "font-footer",
            esc_html__('Footer', 'superbhelperpro')
        );
    }

    private function spbhlprpro_add_theme_affix($control_name)
    {
        return $control_name."_".$this->THEME;
    }

    public function spbhlprpro_add_egs_controls($font_controls)
    {
        // All
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_body_font')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_body_font'),
            'type'        => 'font',
            'title'       => esc_html__('Sitewide Font', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for your website", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'body *', 'force_styles' => "1", "" ),
            'tab' => 'spbhlprpro-font-sitewide',
            'wp_section' => '1'
        );
        
        $font_controls = $this->title_tagline_controls($font_controls);

        $font_controls = $this->posts_pages_controls($font_controls);
        
        $font_controls = $this->navigation_controls($font_controls);

        $font_controls = $this->header_controls($font_controls);

        $font_controls = $this->slideshow_controls($font_controls);
        
        $font_controls = $this->sidebar_controls($font_controls);

        $font_controls = $this->footer_controls($font_controls);

        return $font_controls;
    }

    private function add_section($wp_customize, $section_name, $title, $description = false)
    {
        if (!$description) {
            $description = $this->SECTION_DESCRIPTION;
        }
        
        $wp_customize->add_section('spbhlprpro-'.$section_name, array(
            'priority'       => 1,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => $title,
            'description'    => $description,
            'panel'  => 'spbhlprpro-font-control-panel',
        ));
    }

    private function title_tagline_controls($font_controls)
    {
        // Site Title
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_site_title')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_site_title'),
            'type'        => 'font',
            'title'       => esc_html__('Site Title', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for site title", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'header h1.site-title, header .site-title a, .site-branding .site-title, .site-branding .site-title a', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-site-titles',
            'wp_section' => '1'
        );
        // Tagline
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_tagline')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_tagline'),
            'type'        => 'font',
            'title'       => esc_html__('Tagline', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the tagline", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'header .site-description', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-site-titles',
            'wp_section' => '1'
        );

        return $font_controls;
    }

    private function posts_pages_controls($font_controls)
    {
        // Blog Feed Post Titles
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_blog_entry_title')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_blog_entry_title'),
            'type'        => 'font',
            'class'         => 'testing-class-numba-1',
            'title'       => esc_html__('Blog Feed Post Titles', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the blog feed post titles", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'body.blog h2.entry-title, body.blog h2.entry-title a, body.blog .preview-inner .preview-title a, body.blog article .title a', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );
        
        // Blog feed read more button
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_feed_readmore_btn')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_feed_readmore_btn'),
            'type'        => 'font',
            'title'       => esc_html__('Blog Feed Button', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the blog feed read more button.", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'body.blog .entry-content a.blogpost-button, body.blog .entry-content .readmore-wrapper a, body.blog .entry-content .continue-reading a', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );

        // Post & Page Titles
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_entry_title')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_entry_title'),
            'type'        => 'font',
            'title'       => esc_html__('Post / Page Titles', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the post & page titles", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'h1.entry-title, h1.post-title, article h1.single-title', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );


        // post meta
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_post_meta')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_post_meta'),
            'type'        => 'font',
            'title'       => esc_html__('Post Date and Author', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the post meta.", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'article .entry-meta, .entry-meta time, .entry-meta p, .entry-meta a, .entry-meta span, body.blog .preview-inner .post-meta a, body.blog article .entry-meta, article .post-date-customizable', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );

        // content Paragraphs
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_paragraphs')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_paragraphs'),
            'type'        => 'font',
            'title'       => esc_html__('Paragraphs', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the post & page paragraphs", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.entry-content p, .preview-inner p, body.blog article .post-content, #content p', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );

        // content Lists
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_lists')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_lists'),
            'type'        => 'font',
            'title'       => esc_html__('Lists', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the post & page lists", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.entry-content ul, .entry-content ol, .entry-content li, article .post-single-content ul, article .post-single-content ol, article .post-single-content li', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );

        // content Links
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_links')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_links'),
            'type'        => 'font',
            'title'       => esc_html__('Links', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the post & page links", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.entry-content a:not(.reveal__button__link), #content a:not(.reveal__button__link)', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-postspages',
            'wp_section' => '1'
        );

        return $font_controls;
    }

    private function navigation_controls($font_controls)
    {
        // navigation Logo
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_nav_logo')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_nav_logo'),
            'type'        => 'font',
            'title'       => esc_html__('Title', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the navigation menu title", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'nav.primary-menu .site-logo a, nav.main-navigation .site-logo a, nav.site-navigation .site-logo a, header .site-nav .site-logo a, header #navigation .site-logo a, header .top-bar-title .site-title a', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-navigation',
            'wp_section' => '1'
        );
        // navigation Links
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_nav_links')] = array(
                    'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_nav_links'),
                    'type'        => 'font',
                    'title'       => esc_html__('Links', 'superbhelperpro'),
                    'description' => esc_html__("Please select a font for the navigation menu links", 'superbhelperpro'),
                    'properties'  => array( 'selector' => 'nav.primary-menu a:not(.site-logo), nav.main-navigation a:not(.site-logo), nav.site-navigation a:not(.site-logo), header .site-nav a:not(.site-logo), header #navigation a:not(.site-logo)', 'force_styles' => "1" ),
                    'tab' => 'spbhlprpro-font-navigation',
                    'wp_section' => '1'
                );
        
        //
        return $font_controls;
    }

    private function slideshow_controls($font_controls)
    {
        // slideshow title
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_slideshow_title')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_slideshow_title'),
            'type'        => 'font',
            'title'       => esc_html__('Title', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the slideshow title", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.header-slideshow .slider-content h3', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-slideshow',
            'wp_section' => '1'
        );

        // slideshow tagline
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_slideshow_tagline')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_slideshow_tagline'),
            'type'        => 'font',
            'title'       => esc_html__('Tagline', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the slideshow tagline", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.header-slideshow .slider-content p', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-slideshow',
            'wp_section' => '1'
        );

        // slideshow button
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_slideshow_button')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_slideshow_button'),
            'type'        => 'font',
            'title'       => esc_html__('Button', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the slideshow button", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.header-slideshow .slider-content a', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-slideshow',
            'wp_section' => '1'
        );

        return $font_controls;
    }

    private function header_controls($font_controls)
    {
        // header pretext
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_header_pretext')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_header_pretext'),
            'type'        => 'font',
            'title'       => esc_html__('Text Before Title', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the header text before title", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.bottom-header-wrapper .bottom-header-tagline', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-header',
            'wp_section' => '1'
        );

        // header title
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_header_text')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_header_text'),
            'type'        => 'font',
            'title'       => esc_html__('Title', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the header title", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.bottom-header-wrapper .bottom-header-title, .site-branding-header .site-title', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-header',
            'wp_section' => '1'
        );

        // header after text / tagline
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_header_aftertext')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_header_aftertext'),
            'type'        => 'font',
            'title'       => esc_html__('Tagline / Text After Title', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the header text after title", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.bottom-header-wrapper .bottom-header-below-title, .site-branding-header .site-description, .bottom-header-wrapper .bottom-header-paragraph', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-header',
            'wp_section' => '1'
        );

        
        // header button
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_header_button')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_header_button'),
            'type'        => 'font',
            'title'       => esc_html__('Buttons', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the header buttons", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.site-branding-header a', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-header',
            'wp_section' => '1'
        );

        // header Widget Titles
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_header_widgettitle')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_header_widgettitle'),
            'type'        => 'font',
            'title'       => esc_html__('Widget Titles', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the header widget titles", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.header-widgets-wrapper .widget-title, .upper-widgets-grid-wrapper .widget-title, .top-widget-inner-wrapper .widget-title', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-header',
            'wp_section' => '1'
        );

        // header Widget Text
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_header_widgettext')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_header_widgettext'),
            'type'        => 'font',
            'title'       => esc_html__('Widget Text', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the header widget text", 'superbhelperpro'),
            'properties'  => array( 'selector' => '.header-widgets-wrapper section *:not(.widget-title, div), .upper-widgets-grid-wrapper .widget *:not(.widget-title, div), .top-widget-inner-wrapper *:not(.widget-title, div)', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-header',
            'wp_section' => '1'
        );
        //
        return $font_controls;
    }

    private function sidebar_controls($font_controls)
    {
        // sidebar Widget Titles
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_sidebar_widgettitle')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_sidebar_widgettitle'),
            'type'        => 'font',
            'title'       => esc_html__('Widget Titles', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the sidebar widget titles", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'aside.featured-sidebar section .widget-title, aside.widget-area section .widget-title, .header-inner .sidebar-widgets .widget-title, aside.sidebar .widget .widget-title, aside.widget-area .widget .widget-title', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-sidebar',
            'wp_section' => '1'
        );

        // sidebar Widget Text
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_sidebar_widgettext')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_sidebar_widgettext'),
            'type'        => 'font',
            'title'       => esc_html__('Widget Text', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the sidebar widget text", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'aside.featured-sidebar section *:not(.widget-title, div), aside.widget-area section *:not(.widget-title, div), .header-inner .sidebar-widgets *:not(.widget-title, div), aside.sidebar .widget *:not(.widget-title, div), aside.widget-area .widget *:not(.widget-title, div)', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-sidebar',
            'wp_section' => '1'
        );
        //
        return $font_controls;
    }

    private function footer_controls($font_controls)
    {
        // footer Widget Titles
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_footer_widgettitle')] = array(
                    'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_footer_widgettitle'),
                    'type'        => 'font',
                    'title'       => esc_html__('Widget Titles', 'superbhelperpro'),
                    'description' => esc_html__("Please select a font for the footer widget titles", 'superbhelperpro'),
                    'properties'  => array( 'selector' => 'footer.site-footer .content-wrap .widget-title, footer .widget-title', 'force_styles' => "1" ),
                    'tab' => 'spbhlprpro-font-footer',
                    'wp_section' => '1'
                );
        
        // footer Widget Text
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_footer_widgettext')] = array(
                    'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_footer_widgettext'),
                    'type'        => 'font',
                    'title'       => esc_html__('Widget Text', 'superbhelperpro'),
                    'description' => esc_html__("Please select a font for the footer widget text", 'superbhelperpro'),
                    'properties'  => array( 'selector' => 'footer.site-footer .content-wrap section *:not(.widget-title, div), footer.site-footer section *:not(.widget-title, div), footer .footer-widgets *:not(.widget-title, div)', 'force_styles' => "1" ),
                    'tab' => 'spbhlprpro-font-footer',
                    'wp_section' => '1'
                );
        //

        // footer Copyright Text
        $font_controls[$this->spbhlprpro_add_theme_affix('spbhlprpro_footer_copyrighttext')] = array(
            'name'        => $this->spbhlprpro_add_theme_affix('spbhlprpro_footer_copyrighttext'),
            'type'        => 'font',
            'title'       => esc_html__('Copyright/Info Text', 'superbhelperpro'),
            'description' => esc_html__("Please select a font for the footer copyright/info text", 'superbhelperpro'),
            'properties'  => array( 'selector' => 'footer .site-info, footer .site-info *:not(.widget-title, div), footer .site-info *:not(.widget-title, div), footer .copyrights *:not(.widget-title, div), footer .copyright, footer .copyright *:not(.widget-title, div)', 'force_styles' => "1" ),
            'tab' => 'spbhlprpro-font-footer',
            'wp_section' => '1'
        );
//

        return $font_controls;
    }
}
