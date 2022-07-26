<?php
namespace SuperbHelperPro\Utils;

if (! defined('WPINC')) {
    die;
}

include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
class spbhlprpro_upgrader_skin extends \WP_Upgrader_Skin
{
    public function feedback($string, ...$args)
    {
        // no feedback
    }

    public function header()
    {
        // nothing
    }

    public function footer()
    {
        // nothing
    }

    public function error($errors)
    {
        // nothing
    }
}
