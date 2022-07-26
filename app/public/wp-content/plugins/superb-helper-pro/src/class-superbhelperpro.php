<?php

namespace SuperbHelperPro;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Handlers\SelfUpdater;
use SuperbHelperPro\Handlers\CronController;
use SuperbHelperPro\Handlers\FontController;
use SuperbHelperPro\Handlers\CustomizerController;
use SuperbHelperPro\Companions\RecommendedController;
use SuperbHelperPro\Companions\CompanionController;
use SuperbHelperPro\Notices\NoticeController;
use SuperbHelperPro\Events\EventController;
use SuperbHelperPro\Pages\PageController;

if (! defined('WPINC')) {
    die;
}

class SuperbHelperPro
{
    private static $instance;
    private static $user_caps = 'activate_plugins';
    private $db;
    private $cron;

    public static function GetInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function GetUserCaps()
    {
        return self::$user_caps;
    }

    public function __construct()
    {
        $this->cron = CronController::GetInstance();
        $this->db = DataController::GetInstance();
        register_activation_hook(SUPERBHELPERPRO_BASE_PATH, array($this, 'spbhlprpro_initialize'));
        if (get_option('spbhlprpro_db_version') != $this->db->db_version) {
            $this->spbhlprpro_initialize();
        }
        register_deactivation_hook(SUPERBHELPERPRO_BASE_PATH, array($this, 'spbhlprpro_deactivate'));
        new SelfUpdater();
        new CompanionController();
        new RecommendedController();
        new NoticeController();
        new EventController();
        new PageController();
        new FontController();
        new CustomizerController();
    }

    public function spbhlprpro_initialize()
    {
        //ob_start();
        $this->db->create_table();
        //trigger_error(ob_get_contents(), E_USER_ERROR);
    }

    public function spbhlprpro_deactivate()
    {
        $timestamp = wp_next_scheduled(CronController::CRON_NAME);
        if ($timestamp) {
            wp_unschedule_event($timestamp, CronController::CRON_NAME);
        }
    }
}
