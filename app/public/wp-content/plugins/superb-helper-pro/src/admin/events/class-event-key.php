<?php

namespace SuperbHelperPro\Events;

use SuperbHelperPro\Pages\PageController;
use SuperbHelperPro\Data\DataController;

if (! defined('WPINC')) {
    die;
}
class KeyEvent extends GenericEvent
{
    const KEY_ADD = 'spbhlprpro-key-input';
    const KEY_ADD_NONCE = '_spbhlprpro_key_nonce';
    const KEY_ADD_ACTION = 'spbhlprpro_key_submit';

    const KEY_REMOVE = 'spbhlprpro-remove-key';
    const KEY_REMOVE_NONCE = '_spbhlprpro_key_remove_nonce';
    const KEY_REMOVE_ACTION = 'spbhlprpro_key_remove';

    const SETTINGS_SAVE = 'spbhlprpro-additional-settings';
    const SETTINGS_SAVE_NONCE = '_spbhlprpro_save_settings_nonce';
    const SETTINGS_SAVE_ACTION = 'spbhlprpro_save_settings';
    const SETTINGS_COMPANIONS = 'spbhlprpro-settings-companions';
    const SETTINGS_RECOMMENDED = 'spbhlprpro-settings-recommended';

    protected function Setup()
    {
        // no setup required
    }

    protected function Run()
    {
        if (isset($_POST[self::KEY_ADD])) {
            $this->AddKeyEvent();
        } elseif (isset($_POST[self::KEY_REMOVE])) {
            $this->RemoveKeyEvent();
        } elseif (isset($_POST[self::SETTINGS_SAVE])) {
            $this->SaveSettingsEvent();
        }
    }

    private function AddKeyEvent()
    {
        if (!$this->IsValidAction(self::KEY_ADD_NONCE, self::KEY_ADD_ACTION)) {
            return;
        }

        if (empty($_POST[self::KEY_ADD])) {
            PageController::SetErrorMessage(__("No key was received. Please double check that you've entered a key before hitting the unlock button.", 'superbhelperpro'));
            return;
        }
    
        $response = DataController::GetInstance()->get_key_success_by_key(array("key" => sanitize_text_field($_POST[self::KEY_ADD])));
        if (!$response) {
            PageController::SetErrorMessage(__("The key could not be activated. Please double check that the key you've entered is correct. If the issue persists, please contact support.", 'superbhelperpro'));
        } else {
            $products_url = admin_url('admin.php?page='.PageController::BASE);
            wp_redirect($products_url);
            exit();
        }
    }

    private function RemoveKeyEvent()
    {
        if (!$this->IsValidAction(self::KEY_REMOVE_NONCE, self::KEY_REMOVE_ACTION)) {
            return;
        }

        $response = DataController::GetInstance()->remove_key();
        if (!$response) {
            PageController::SetErrorMessage(__("Something went wrong. If the issue persists, please contact support.", 'superbhelperpro'));
        }
    }

    private function SaveSettingsEvent()
    {
        if (!$this->IsValidAction(self::SETTINGS_SAVE_NONCE, self::SETTINGS_SAVE_ACTION)) {
            return;
        }

        $companions = isset($_POST[self::SETTINGS_COMPANIONS]) && !is_null($_POST[self::SETTINGS_COMPANIONS]) ? true : false;
        $recommended = isset($_POST[self::SETTINGS_RECOMMENDED]) && !is_null($_POST[self::SETTINGS_RECOMMENDED]) ? true : false;
        $response = DataController::GetInstance()->save_settings(array("companions" => $companions, "recommended" => $recommended));
        if (!$response) {
            PageController::SetErrorMessage(__("Something went wrong. If the issue persists, please contact support.", 'superbhelperpro'));
        }
    }
}
