<?php

namespace SuperbHelperPro\Companions;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Utils\spbhlprpro_upgrader_skin;

use Exception;

if (! defined('WPINC')) {
    die;
}

class CompanionController
{
    public function __construct()
    {
    }

    public static function enable_companions()
    {
        try {
            $settings = DataController::GetInstance()->get_settings();
            if (!$settings['companions']) {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }

        $companions = array(
            array(
                "slug" => "easy-google-fonts/easy-google-fonts.php", "package" => "https://downloads.wordpress.org/plugin/easy-google-fonts.zip"
            ),
            array(
                "slug" => "superb-recent-posts-with-thumbnail-images/superb-recent-posts-with-images.php", "package" => "https://downloads.wordpress.org/plugin/superb-recent-posts-with-thumbnail-images.latest-stable.zip"
            ));

        try {
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            $upgrader = new \Plugin_Upgrader(new spbhlprpro_upgrader_skin());
            foreach ($companions as &$companion) {
                $should_reactivate_plugin = false;
                $slug = $companion['slug'];
                $installed_version = ProductController::is_plugin_installed($slug);
                if ($installed_version) {
                    $should_reactivate_plugin = is_plugin_active($slug);
                    $installed = $upgrader->upgrade($slug);
                } else {
                    $should_reactivate_plugin = true;
                    $installed = $upgrader->install($companion['package']);
                }
                if (!is_wp_error($installed) && $installed && $should_reactivate_plugin) {
                    activate_plugin($slug);
                }
            }
            unset($companion);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
