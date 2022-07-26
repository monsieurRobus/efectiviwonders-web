<?php
namespace SuperbHelperPro\Handlers;

use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Utils\spbhlprproException;

use Exception;

if (! defined('WPINC')) {
    die;
}

class CustomizerController
{
    const CATEGORY_SETTING_KEY = 'spb_category_prefix_filter';
    const TAG_SETTING_KEY = 'spb_tag_prefix_filter';
    const AUTHOR_SETTING_KEY = 'spb_author_prefix_filter';

    public function __construct()
    {
        global $wp_version;
        if (!empty($wp_version) && version_compare($wp_version, "5.5") >= 0) {
            \add_action('customize_register', array($this, 'spbhlprpro_customizer_panel'), 100);
            \add_filter('get_the_archive_title_prefix', array($this, 'spb_remove_archive_title_prefix'), 100);
        }
    }

    public function spb_remove_archive_title_prefix($prefix)
    {
        if ($prefix === _x('Category:', 'category archive title prefix') && \get_theme_mod(self::CATEGORY_SETTING_KEY)) {
            $prefix = '';
        }
        if ($prefix === _x('Tag:', 'tag archive title prefix') && \get_theme_mod(self::TAG_SETTING_KEY)) {
            $prefix = '';
        }
        if ($prefix === _x('Author:', 'author archive title prefix') && \get_theme_mod(self::AUTHOR_SETTING_KEY)) {
            $prefix = '';
        }
        return $prefix;
    }


    public function spbhlprpro_customizer_panel($wp_customize)
    {
        try {
            $currentTheme = ProductController::get_validated_product(\get_template());
            // No exceptions, theme validated
            $wp_customize->add_setting(self::CATEGORY_SETTING_KEY, array(
                'default'   => false,
                'transport' => 'refresh',
            ));

            $wp_customize->add_setting(self::TAG_SETTING_KEY, array(
                'default'   => false,
                'transport' => 'refresh',
            ));

            $wp_customize->add_setting(self::AUTHOR_SETTING_KEY, array(
                'default'   => false,
                'transport' => 'refresh',
            ));

            $section_key = 'spb_helper_pro_settings_section';
            $wp_customize->add_section($section_key, array(
                'title'      => __('Extras', 'superbhelperpro'),
                'priority'   => 30,
            ));


            // Add control and output for select field
            $wp_customize->add_control(self::CATEGORY_SETTING_KEY, array(
                'label'      => __('Disable "Category:" Title Prefix', 'superbhelperpro'),
                'section'    => $section_key,
                'settings'   => self::CATEGORY_SETTING_KEY,
                'type'       => 'checkbox',
                'description'=> __('This will remove the "Category:" prefix for titles on category pages.', 'superbhelperpro')
            ));
            $wp_customize->add_control(self::TAG_SETTING_KEY, array(
                'label'      => __('Disable "Tag:" Title Prefix', 'superbhelperpro'),
                'section'    => $section_key,
                'settings'   => self::TAG_SETTING_KEY,
                'type'       => 'checkbox',
                'description'=> __('This will remove the "Tag:" prefix for titles on tag pages.', 'superbhelperpro')
            ));
            $wp_customize->add_control(self::AUTHOR_SETTING_KEY, array(
                'label'      => __('Disable "Author:" Title Prefix', 'superbhelperpro'),
                'section'    => $section_key,
                'settings'   => self::AUTHOR_SETTING_KEY,
                'type'       => 'checkbox',
                'description'=> __('This will remove the "Author:" prefix for titles on author pages.', 'superbhelperpro')
            ));
        } catch (spbhlprproException $spex) {
            return;
        } catch (Exception $ex) {
            return;
        }
    }
}
