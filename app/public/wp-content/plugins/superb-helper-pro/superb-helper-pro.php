<?php

namespace SuperbHelperPro;

/*
Plugin Name: Superb Helper Pro
Plugin URI: http://superbthemes.com/
Description: Access and update all of your SuperbThemes Premium Products with Superb Helper Pro.
Version: 4.4
Author: Superb Themes
Author URI: http://superbthemes.com/
Text Domain: superbhelperpro
*/

defined('ABSPATH') || exit;

if (! defined('WPINC')) {
    die;
}
// Constants
if (! defined('SUPERBHELPERPRO_VERSION')) {
    define('SUPERBHELPERPRO_VERSION', '4.4');
}

if (! defined('SUPERBHELPERPRO_BASE')) {
    define('SUPERBHELPERPRO_BASE', plugin_basename(__FILE__));
}

if (! defined('SUPERBHELPERPRO_BASE_PATH')) {
    define('SUPERBHELPERPRO_BASE_PATH', __FILE__);
}

if (! defined('SUPERBHELPERPRO_PATH')) {
    define('SUPERBHELPERPRO_PATH', untrailingslashit(plugins_url('', SUPERBHELPERPRO_BASE_PATH)));
}

if (! defined('SUPERBHELPERPRO_PLUGIN_DIR')) {
    define('SUPERBHELPERPRO_PLUGIN_DIR', untrailingslashit(dirname(SUPERBHELPERPRO_BASE_PATH)));
}

if (! defined('SUPERBHELPERPRO_ASSETS_PATH')) {
    define('SUPERBHELPERPRO_ASSETS_PATH', SUPERBHELPERPRO_PATH . '/assets');
}
//

// Autoload
require_once SUPERBHELPERPRO_PLUGIN_DIR . '/vendor/autoload.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';
use \SuperbHelperPro\SuperbHelperPro;

$spbhlprpro = SuperbHelperPro::GetInstance();

//
