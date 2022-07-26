<?php

namespace SuperbHelperPro\Events;

use SuperbHelperPro\SuperbHelperPro;
use SuperbHelperPro\Pages\PageController;
use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Utils\spbhlprproException;

if (! defined('WPINC')) {
    die;
}

class EventController
{
    public function __construct()
    {
        add_action('current_screen', array($this, 'spbhlprpro_eventhandler'), 0);
    }

    public function spbhlprpro_eventhandler($cs)
    {
        try {
            $page_hook = $cs->base;
            if (PageController::CompareHook($page_hook, PageController::HOOKS) && !current_user_can(SuperbHelperPro::GetUserCaps())) {
                PageController::SetErrorMessage(__("You do not have permission to perform the current action - please check user permissions. If the problem persists, please contact support.", 'superbhelperpro'));
                return;
            }
            if (PageController::CompareHook($page_hook, PageController::BASE)) {
                if (!DataController::GetInstance()->has_key()) {
                    wp_redirect(admin_url('admin.php?page='.PageController::KEY));
                    exit();
                }
                new ProductsEvent();
            } elseif (PageController::CompareHook($page_hook, PageController::KEY)) {
                new KeyEvent();
            } elseif (PageController::CompareHook($page_hook, PageController::UPDATE)) {
                new UpdateEvent();
            }
        } catch (spbhlprproException $ex) {
            PageController::SetErrorMessage($ex->getMessage());
        }
    }
}
