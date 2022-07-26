<?php

namespace SuperbHelperPro\Handlers;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Utils\spbhlprproException;
use SuperbHelperPro\Utils\spbhlprproUpgrader;
use SuperbHelperPro\Utils\spbhlprpro_upgrader_skin;

use stdClass;
use Exception;

if (! defined('WPINC')) {
    die;
}

class SelfUpdater
{
    public function __construct()
    {
        add_filter('plugins_api', array($this, 'spbhlprpro_plugin_info'), 20, 3);
        add_filter('site_transient_update_plugins', array($this, 'spbhlprpro_push_update'));
        add_action('upgrader_process_complete', array($this, 'spbhlprpro_after_update'), 10, 2);
    }

    public static function update_self()
    {
        try {
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            $upgrader = new \Plugin_Upgrader(new spbhlprpro_upgrader_skin());
            $customUpgrader = new spbhlprproUpgrader($upgrader);
            $slug = "superb-helper-pro/superb-helper-pro.php";
            $installed_version = ProductController::is_plugin_installed($slug);
            $data = DataController::GetInstance()->get_data("ignore_refresh");
            if (!isset($data['version'])) {
                throw new spbhlprproException(__("Unable to update. New version could not be determined.", 'superbhelperpro'), "7501");
            }
            if ($installed_version) {
                if (version_compare($installed_version, $data['version'], '>=')) {
                    throw new spbhlprproException(__("Unable to update. Plugin is already up to date.", 'superbhelperpro'), "7502");
                }
                $installed = $customUpgrader->upgrade_plugin("https://superbthemes.com/wp-content/superb-helper-pro/superb-helper-pro.zip?v=".esc_url($data['version']), $slug);
            } else {
                $installed = $upgrader->install("https://superbthemes.com/wp-content/superb-helper-pro/superb-helper-pro.zip?v=".esc_url($data['version']));
            }
            if (!is_wp_error($installed) && $installed) {
                activate_plugin($slug);
                // return false to signal no errors
                return false;
            }
            throw new Exception();
        } catch (spbhlprproException $spbex) {
            return $spbex->getMessage()." (error code #".$spbex->getCode().").";
        } catch (Exception $ex) {
            $code = $ex->getCode() != 0 ? $ex->getCode() : "500";
            return __("Something went wrong during the update process.", "superbhelperpro")." (error code #".$code.").";
        }
    }

        
    /* Plugin update stuff */
    /*
     * $res empty at this step
     * $action 'plugin_information'
     * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
     */
    public function spbhlprpro_plugin_info($res, $action, $args)
    {

    // do nothing if this is not about getting plugin information
        if ('plugin_information' !== $action) {
            return false;
        }

        $plugin_slug = 'superb-helper-pro'; // we are going to use it in many places in this function

        // do nothing if it is not our plugin
        if ($plugin_slug !== $args->slug) {
            return false;
        }

        // trying to get from cache first
        if (false == $remote = get_transient('spbhlprpro_update_' . $plugin_slug)) {

        // info.json is the file with the actual plugin information on your server
            $remote = wp_remote_get(
                'https://superbthemes.com/wp-content/superb-helper-pro/superbhelperpro.json',
                array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json'
                ) )
            );

            if (! is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && ! empty($remote['body'])) {
                set_transient('spbhlprpro_update_' . $plugin_slug, $remote, 500); // 500 seconds cache
            }
        }

        if (! is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && ! empty($remote['body'])) {
            $remote = json_decode($remote['body']);
            $res = new stdClass();

            $res->name = $remote->name;
            $res->slug = $plugin_slug;
            $res->version = $remote->version;
            $res->tested = $remote->tested;
            $res->requires = $remote->requires;
            $res->author = '<a href="http://superbthemes.com/">SuperbThemes</a>';
            $res->author_profile = 'http://superbthemes.com/';
            $res->download_link = $remote->download_url;
            $res->trunk = $remote->download_url;
            $res->requires_php = '5.3';
            $res->last_updated = $remote->last_updated;
            $res->sections = array(
            'description' => $remote->sections->description,
            'installation' => $remote->sections->installation,
            'changelog' => $remote->sections->changelog
        );
            if (!empty($remote->sections->screenshots)) {
                $res->sections['screenshots'] = $remote->sections->screenshots;
            }

            $res->banners = array(
            'low' => 'https://ps.w.org/superb-helper/assets/banner-772x250.png',
            'high' => 'https://ps.w.org/superb-helper/assets/banner-772x250.png'
        );
            return $res;
        }

        return false;
    }

    public function spbhlprpro_push_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        // trying to get from cache first, to disable cache comment 10,20,21,22,24
        if (false == $remote = get_transient('spbhlprpro_upgrade_superb-helper-pro')) {
            $remote = wp_remote_get(
                'https://superbthemes.com/wp-content/superb-helper-pro/superbhelperpro.json',
                array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json'
                ) )
            );

            if (!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
                set_transient('spbhlprpro_upgrade_superb-helper-pro', $remote, 500); // 500 seconds cache
            }
        }

        // server down -> crash fix: && !is_wp_error($remote)
        if ($remote && !is_wp_error($remote)) {
            $remote = json_decode($remote['body']);

            if ($remote && version_compare(SUPERBHELPERPRO_VERSION, $remote->version, '<') && version_compare($remote->requires, get_bloginfo('version'), '<')) {
                $res = new stdClass();
                $res->slug = 'superb-helper-pro';
                $res->plugin = 'superb-helper-pro/superb-helper-pro.php';
                $res->new_version = $remote->version;
                $res->tested = $remote->tested;
                $res->package = $remote->download_url;
                $transient->response[$res->plugin] = $res;
                //$transient->checked[$res->plugin] = $remote->version;
            }
        }
        return $transient;
    }


    public function spbhlprpro_after_update($upgrader_object, $options)
    {
        if ($options['action'] == 'update' && $options['type'] === 'plugin') {
            // just clean the cache when new plugin version is installed
            delete_transient('spbhlprpro_upgrade_superb-helper-pro');
        }
    }
}
