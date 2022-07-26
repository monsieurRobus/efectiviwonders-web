<?php

namespace SuperbHelperPro\Modules;

class Header
{
    private $title;
    private $msg;

    public function __construct($title, $message = false)
    {
        $this->title = $title;
        $this->msg = $message;
        $this->Build();
    }

    private function Build()
    {
        ?>
        <div class="spbhlprpro_update_data_header">
            <h1><span><?php esc_html_e("SuperbThemes Premium", 'superbhelperpro'); ?></span> <?php echo esc_html($this->title); ?></h1>
            <?php $this->BuildMessage(); ?>
        </div>
        <?php
    }

    private function BuildMessage()
    {
        if ($this->msg === false) {
            return;
        } ?>
            <h2 class="spbhlprpro_information_notification"><?php echo esc_html($this->msg); ?></h2>
        <?php
    }
}
