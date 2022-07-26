<?php

namespace SuperbHelperPro\Events;

use SuperbHelperPro\Pages\PageController;

if (! defined('WPINC')) {
    die;
}

abstract class GenericEvent
{
    abstract protected function Setup();
    abstract protected function Run();
    private $doRun = true;

    public function __construct()
    {
        $this->Setup();
        if ($this->doRun) {
            $this->Run();
        }
    }

    protected function IsValidAction($nonce = false, $action = false)
    {
        if ($nonce === false || $action === false) {
            return false;
        }
        if (isset($_POST[$nonce]) && wp_verify_nonce($_POST[$nonce], $action) && check_admin_referer($action, $nonce)) {
            return true;
        }
        return false;
    }

    protected function IgnoreRun()
    {
        $this->doRun = false;
    }
}
