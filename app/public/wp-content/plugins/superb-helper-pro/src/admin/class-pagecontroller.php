<?php

namespace SuperbHelperPro\Pages;

use SuperbHelperPro\SuperbHelperPro;

if (! defined('WPINC')) {
    die;
}

class PageController
{
    const BASE = "spbhlprpro";
    const KEY = "spbhlprpro_key";
    const UPDATE = "spbhlprpro_update";
    const HOOKS = array(self::BASE,self::KEY,self::UPDATE);
    const JS_PREFIX = "/js";
    const JS_AFFIX = ".min.js";

    private static $error_message = false;
    private static $event_message = false;

    public function __construct()
    {
        add_filter('plugin_row_meta', array($this, 'plugin_row_meta' ), 10, 2);
        add_action('admin_menu', array($this, 'add_menu_items'));
        add_action('admin_enqueue_scripts', array($this, 'spbhlprpro_enqueue'));
    }

    public function plugin_row_meta($row_meta, $file)
    {
        if (SUPERBHELPERPRO_BASE == $file) {
            $row_meta[] = '<a href="'.admin_url('admin.php?page='.self::BASE).'" aria-label="Products">Access Your Premium Products</a>';
        }
        return $row_meta;
    }

    public function add_menu_items()
    {
        $user_caps = apply_filters('spbhlprpro_user_capabilities', SuperbHelperPro::GetUserCaps());
        add_menu_page('Superb Helper Pro', 'SuperbThemes Premium', $user_caps, self::BASE, array($this, 'page_products'), SUPERBHELPERPRO_ASSETS_PATH . "/img/icon-small.png");
        add_submenu_page(self::BASE, 'Your SuperbThemes Products', 'Your Products', $user_caps, self::BASE);
        add_submenu_page(self::BASE, 'License Key', 'License Key', $user_caps, self::KEY, array($this, 'page_key'));
        add_submenu_page('spbhlprpro-self-update-pagehook', 'Updating Superb Helper Pro', 'Updating Superb Helper Pro', $user_caps, self::UPDATE, array($this, 'page_update'));
    }

    public function spbhlprpro_enqueue($page_hook)
    {
        if (self::CompareHook($page_hook, self::HOOKS)) {
            wp_enqueue_style('spbhlprpro-backend', SUPERBHELPERPRO_ASSETS_PATH.'/css/backend.css', false, SUPERBHELPERPRO_VERSION, 'all');
        }

        if (self::CompareHook($page_hook, self::BASE)) {
            wp_enqueue_script('spbhlprpro-products-script', SUPERBHELPERPRO_ASSETS_PATH.self::JS_PREFIX.'/products'.self::JS_AFFIX, array('jquery'), SUPERBHELPERPRO_VERSION);
            wp_localize_script('spbhlprpro-products-script', 'spbhlprpro_msgs', array(
                'checkingForUpdates'  => esc_html__("Checking for updates..", 'superbhelperpro'),
                'processing'  => esc_html__("Processing.. This may take up to several minutes..", 'superbhelperpro'),
                'waiting'  => esc_html__("Waiting for your product update order..", 'superbhelperpro'),
                'info_order' => esc_html__("When your order is complete, please hit the green \"Check for Updates\" button below."),
                'clickAgain'  => esc_html__("Click Again to Delete", 'superbhelperpro'),
                'justNow' => esc_html__("Just now", 'superbhelperpro'),
                'minutesAgo' => esc_html__(" minute(s) ago", 'superbhelperpro'),
                'hoursAgo' => esc_html__(" hour(s) ago", 'superbhelperpro')
            ));
        } elseif (self::CompareHook($page_hook, self::KEY)) {
            wp_enqueue_script('spbhlprpro-key-script', SUPERBHELPERPRO_ASSETS_PATH.self::JS_PREFIX.'/key'.self::JS_AFFIX, array('jquery'), SUPERBHELPERPRO_VERSION);
            wp_localize_script('spbhlprpro-key-script', 'spbhlprpro_msgs', array(
                'processing'  => esc_html__("Processing..", 'superbhelperpro'),
                'clickAgain'  => esc_html__("Click Again to Remove", 'superbhelperpro')
            ));
        }
        if (self::CompareHook($page_hook, self::UPDATE) || self::CompareHook($page_hook, self::BASE)) {
            wp_enqueue_script('spbhlprpro-update-script', SUPERBHELPERPRO_ASSETS_PATH.self::JS_PREFIX.'/update'.self::JS_AFFIX, array('jquery'), SUPERBHELPERPRO_VERSION);
            if (self::CompareHook($page_hook, self::UPDATE)) {
                wp_localize_script('spbhlprpro-update-script', 'spbhlprpro_msgs', array(
                'processing'  => esc_html__("Processing..", 'superbhelperpro')
            ));
            }
        }

        wp_enqueue_script('spbhlprpro-notices-script', SUPERBHELPERPRO_ASSETS_PATH.self::JS_PREFIX.'/notices'.self::JS_AFFIX, array('jquery'), SUPERBHELPERPRO_VERSION);
    }

    public function page_products()
    {
        new ProductsPage();
    }

    public function page_key()
    {
        new KeyPage();
    }

    public function page_update()
    {
        new UpdatePage();
    }

    public static function SetErrorMessage($msg)
    {
        self::$error_message = sanitize_text_field($msg);
    }

    public static function GetErrorMessage()
    {
        $err_msg = self::$error_message;
        self::$error_message = false;
        return $err_msg;
    }

    public static function SetEventMessage($msg)
    {
        self::$event_message = sanitize_text_field($msg);
    }

    public static function GetEventMessage()
    {
        $ev_msg = self::$event_message;
        self::$event_message = false;
        return $ev_msg;
    }

    public static function CompareHook($hook, $compare)
    {
        if ($compare == self::HOOKS) {
            return in_array(self::get_clean_hook($hook), self::HOOKS, true);
        }
        return self::get_clean_hook($hook) === $compare;
    }

    private static function get_clean_hook($hook = false)
    {
        if (!$hook) {
            $screen_id = get_current_screen()->id;
        } else {
            $screen_id = $hook;
        }
        return preg_replace('/^(admin_page_|toplevel_page_||superbthemes-premium_page_)/', '', $screen_id);
    }
}
