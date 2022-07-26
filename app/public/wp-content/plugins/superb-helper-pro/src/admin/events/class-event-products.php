<?php

namespace SuperbHelperPro\Events;

use SuperbHelperPro\Pages\PageController;
use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Handlers\InstallationController;

if (! defined('WPINC')) {
    die;
}
class ProductsEvent extends GenericEvent
{
    const REFRESH = 'spbhlprproupdate';
    const REFRESH_NONCE = '_spbhlprpro_update_check_nonce';
    const REFRESH_ACTION = 'spbhlprpro_update_check';

    const UPGRADE_INSTALL = 'spbhlprpro_install';
    const UPGRADE_DELETE = 'spbhlprpro_delete';
    const UPGRADE_ACTIVATE = 'spbhlprpro_activate';
    const UPGRADE_NONCE = '_spbhlprpro_upgrader_nonce';
    const UPGRADE_ACTION = 'spbhlprpro_upgrade';

    const PRODUCT_TRANSIENT = 'spbhlprpro-product-event';

    protected function Setup()
    {
        // no setup required
    }

    protected function Run()
    {
        if (isset($_POST[self::REFRESH])) {
            $this->RefreshEvent();
        } elseif (isset($_POST[self::UPGRADE_INSTALL])) {
            $this->InstallationEvent(self::UPGRADE_INSTALL);
        } elseif (isset($_POST[self::UPGRADE_ACTIVATE])) {
            $this->InstallationEvent(self::UPGRADE_ACTIVATE);
        } elseif (isset($_POST[self::UPGRADE_DELETE])) {
            $this->InstallationEvent(self::UPGRADE_DELETE);
        }
    }
    
    private function RefreshEvent()
    {
        if (!$this->IsValidAction(self::REFRESH_NONCE, self::REFRESH_ACTION)) {
            return;
        }
            
        $result = DataController::GetInstance()->get_data("refresh");
        if (isset($result['error'])) {
            PageController::SetErrorMessage($result['message'].__(" If the problem persists, please contact support.", "spbhlprpro"));
        } else {
            wp_redirect(admin_url('admin.php?page='.PageController::BASE));
            exit();
        }
    }

    private function InstallationEvent($cmd = false)
    {
        if ($cmd===false) {
            return;
        }
        if (!$this->IsValidAction(self::UPGRADE_NONCE, self::UPGRADE_ACTION)) {
            return;
        }

        $result = false;
        switch ($cmd) {
            case self::UPGRADE_INSTALL:
                $result = InstallationController::install_product(sanitize_text_field($_POST[self::UPGRADE_INSTALL]));
                break;
            case self::UPGRADE_ACTIVATE:
                $result = InstallationController::activate_product(sanitize_text_field($_POST[self::UPGRADE_ACTIVATE]));
                break;
            case self::UPGRADE_DELETE:
                $result = InstallationController::delete_product(sanitize_text_field($_POST[self::UPGRADE_DELETE]));
                break;
        }

        if (!$result['error']) {
            $transient = array('message' => sanitize_text_field($result['message']));
            if (isset($result['slug']) && $result['slug']!==false) {
                $transient['slug'] = sanitize_text_field($result['slug']);
            }
            set_transient(self::PRODUCT_TRANSIENT, $transient, 60);
            wp_redirect(admin_url('admin.php?page='.PageController::BASE));
            exit();
        }
        if ($result['error']) {
            PageController::SetErrorMessage($result['message'].__(" If the problem persists, please contact support.", "superbhelperpro"));
        }
    }

    public static function RemoveTransient()
    {
        delete_transient(self::PRODUCT_TRANSIENT);
    }
}
