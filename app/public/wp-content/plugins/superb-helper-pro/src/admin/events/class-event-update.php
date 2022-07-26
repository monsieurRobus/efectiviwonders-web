<?php

namespace SuperbHelperPro\Events;

use SuperbHelperPro\Handlers\SelfUpdater;
use SuperbHelperPro\Pages\PageController;

if (! defined('WPINC')) {
    die;
}

class UpdateEvent extends GenericEvent
{
    const UPDATE_NONCE = '_spbhlprpro_self_update_nonce';
    const UPDATE_ACTION = 'spbhlprpro_self_update';

    protected function Setup()
    {
    }

    protected function Run()
    {
        if (isset($_GET[self::UPDATE_NONCE]) && wp_verify_nonce($_GET[self::UPDATE_NONCE], self::UPDATE_ACTION)) {
            $error = SelfUpdater::update_self();
            if (!$error) {
                $products_url = admin_url('admin.php?page='.PageController::BASE);
                wp_redirect($products_url);
                exit();
            } else {
                PageController::SetErrorMessage($error.__(" If the problem persists, please contact support.", "superbhelperpro"));
            }
        }
    }
}
