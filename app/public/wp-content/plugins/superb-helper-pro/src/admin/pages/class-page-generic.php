<?php

namespace SuperbHelperPro\Pages;

if (! defined('WPINC')) {
    die;
}

abstract class GenericPage
{
    public $error_message;
    private $doBuild = true;

    abstract protected function Setup();
    abstract protected function Build();

    public function __construct()
    {
        $this->Setup();
        if ($this->doBuild) {
            $this->GetErrorMessage();
            $this->Build();
        }
    }

    protected function IgnoreBuild()
    {
        $this->doBuild = false;
    }

    private function GetErrorMessage()
    {
        $this->error_message = PageController::GetErrorMessage();
    }
}
