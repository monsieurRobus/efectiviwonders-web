<?php

namespace SuperbHelperPro\Utils;

use Exception;

if (! defined('WPINC')) {
    die;
}

class spbhlprproUpgrader
{
    private $upgrader;
    public function __construct($upgrader)
    {
        $this->upgrader = $upgrader;
    }

    public function upgrade_theme($package, $theme)
    {
        $parsed_args    = array(
                        'clear_update_cache' => true,
                    );
                
        $this->upgrader->init();
        $this->upgrader->upgrade_strings();
                
        add_filter('upgrader_pre_install', array( $this->upgrader, 'current_before' ), 10, 2);
        add_filter('upgrader_post_install', array( $this->upgrader, 'current_after' ), 10, 2);
        add_filter('upgrader_clear_destination', array( $this->upgrader, 'delete_old_theme' ), 10, 4);
        if ($parsed_args['clear_update_cache']) {
            // Clear cache so wp_update_themes() knows about the new theme.
            add_action('upgrader_process_complete', 'wp_clean_themes_cache', 9, 0);
        }
                
        $this->upgrader->run(
            array(
                            'package'           => $package,
                            'destination'       => get_theme_root($theme),
                            'clear_destination' => true,
                            'clear_working'     => true,
                            'hook_extra'        => array(
                                'theme'  => $theme,
                                'type'   => 'theme',
                                'action' => 'update',
                            ),
                        )
        );
                
        remove_action('upgrader_process_complete', 'wp_clean_themes_cache', 9);
        remove_filter('upgrader_pre_install', array( $this->upgrader, 'current_before' ));
        remove_filter('upgrader_post_install', array( $this->upgrader, 'current_after' ));
        remove_filter('upgrader_clear_destination', array( $this->upgrader, 'delete_old_theme' ));
                
        if (! $this->upgrader->result || is_wp_error($this->upgrader->result)) {
            return $this->upgrader->result;
        }
                
        wp_clean_themes_cache($parsed_args['clear_update_cache']);
                
        // Ensure any future auto-update failures trigger a failure email by removing
        // the last failure notification from the list when themes update successfully.
        $past_failure_emails = get_option('auto_plugin_theme_update_emails', array());
                
        if (isset($past_failure_emails[ $theme ])) {
            unset($past_failure_emails[ $theme ]);
            update_option('auto_plugin_theme_update_emails', $past_failure_emails);
        }
                
        return true;
    }


    public function upgrade_plugin($package, $plugin)
    {
        $parsed_args    = array(
                'clear_update_cache' => true,
            );

        $this->upgrader->init();
        $this->upgrader->upgrade_strings();

        add_filter('upgrader_pre_install', array( $this->upgrader, 'deactivate_plugin_before_upgrade' ), 10, 2);
        add_filter('upgrader_pre_install', array( $this->upgrader, 'active_before' ), 10, 2);
        add_filter('upgrader_clear_destination', array( $this->upgrader, 'delete_old_plugin' ), 10, 4);
        add_filter('upgrader_post_install', array( $this->upgrader, 'active_after' ), 10, 2);
        // There's a Trac ticket to move up the directory for zips which are made a bit differently, useful for non-.org plugins.
        // 'source_selection' => array( $this, 'source_selection' ),
        if ($parsed_args['clear_update_cache']) {
            // Clear cache so wp_update_plugins() knows about the new plugin.
            add_action('upgrader_process_complete', 'wp_clean_plugins_cache', 9, 0);
        }

        $this->upgrader->run(
            array(
                'package'           => $package,
                'destination'       => WP_PLUGIN_DIR,
                'clear_destination' => true,
                'clear_working'     => true,
                'hook_extra'        => array(
                    'plugin' => $plugin,
                    'type'   => 'plugin',
                    'action' => 'update',
                ),
            )
        );

        // Cleanup our hooks, in case something else does a upgrade on this connection.
        remove_action('upgrader_process_complete', 'wp_clean_plugins_cache', 9);
        remove_filter('upgrader_pre_install', array( $this->upgrader, 'deactivate_plugin_before_upgrade' ));
        remove_filter('upgrader_pre_install', array( $this->upgrader, 'active_before' ));
        remove_filter('upgrader_clear_destination', array( $this->upgrader, 'delete_old_plugin' ));
        remove_filter('upgrader_post_install', array( $this->upgrader, 'active_after' ));

        if (! $this->upgrader->result || is_wp_error($this->upgrader->result)) {
            return $this->upgrader->result;
        }

        // Force refresh of plugin update information.
        wp_clean_plugins_cache($parsed_args['clear_update_cache']);

        // Ensure any future auto-update failures trigger a failure email by removing
        // the last failure notification from the list when plugins update successfully.
        $past_failure_emails = get_option('auto_plugin_theme_update_emails', array());

        if (isset($past_failure_emails[ $plugin ])) {
            unset($past_failure_emails[ $plugin ]);
            update_option('auto_plugin_theme_update_emails', $past_failure_emails);
        }

        return true;
    }
}
