<?php

namespace SuperbHelperPro\Modules;

abstract class GenericNotification
{
    abstract protected function Build();

    private $msg;
    public function __construct($msg = false)
    {
        if (!isset($msg) || $msg === false) {
            return;
        }
        $this->msg = $msg;
        $this->Build();
    }

    protected function GetMessage()
    {
        return $this->msg;
    }
}
