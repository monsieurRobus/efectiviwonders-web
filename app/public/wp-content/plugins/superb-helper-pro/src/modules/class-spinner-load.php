<?php

namespace SuperbHelperPro\Modules;

class LoadSpinner
{
    public function __construct()
    {
        $this->Build();
    }

    private function Build()
    {
        ?>
        <div id="spbhlprpro_update_load_spinner" style="display: none;"><svg viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="height: 45px;width: 45px;"><circle cx="50" cy="50" fill="none" stroke="#6448e7" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" transform="rotate(251.563 50 50)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="2s" begin="0s" repeatCount="indefinite"></animateTransform></circle></svg>
            <span id="spbhlprpro_update_load_spinner_text"></span>
        </div>
        <?php
    }
}
