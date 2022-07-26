<?php

namespace SuperbHelperPro\Handlers;

use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Utils\spbhlprproException;

use Exception;

if (! defined('WPINC')) {
    die;
}

class CronController
{
    private static $instance;
    public static function GetInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    const CRON_NAME = 'spbhlprpro_cron_event';
    const UPDATES_TRANSIENT = 'spbhlprpro_updates';
    public function __construct()
    {
        add_action(self::CRON_NAME, array($this, 'spbhlprpro_cron_function'));
        if (!wp_next_scheduled(self::CRON_NAME)) {
            wp_schedule_event(time(), 'twicedaily', self::CRON_NAME);
        }
    }

    public function spbhlprpro_cron_function($loaded = false)
    {
        try {
            $data = ($loaded!==false && !is_null($loaded) && !empty($loaded)) ? $loaded : DataController::GetInstance()->get_data(false, true);
            if (!$data) {
                self::RemoveTransient();
                return;
            }
            if (!isset($data['products']) || !$data['products'] || count($data['products']) <= 0) {
                self::RemoveTransient();
                return;
            }
          
            $updates_available = array();
            foreach ($data['products'] as &$product) {
                $isActive = ProductController::get_product_active($product); /// Only for active products??
                $installedVersion = ProductController::get_installed_version($product);
                if (!$installedVersion) {
                    continue;
                }
                $isOutdated = ProductController::get_is_outdated($installedVersion, $product);
                if (!$isOutdated) {
                    continue;
                }
                $updates_available[] = array(
                    "name" => $product['name'],
                    "active" => $isActive
                );
            }
            unset($product);
            if (count($updates_available) <= 0) {
                self::RemoveTransient();
                return;
            }
            set_transient(self::UPDATES_TRANSIENT, $updates_available);
        } catch (spbhlprproException $spbex) {
            self::RemoveTransient();
        } catch (Exception $ex) {
            self::RemoveTransient();
        }
    }

    public static function RemoveTransient()
    {
        delete_transient(self::UPDATES_TRANSIENT);
    }
}
