<?php

namespace SuperbHelperPro\Modules;

class InitSpinner
{
    private $wrapperId;
    public function __construct($wrapperId)
    {
        $this->wrapperId = $wrapperId;
        $this->Build();
    }

    private function Build()
    {
        ?>
        <svg id="spbhlprpro_init_spinner" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="height: 45px;display: block;width: 45px;"><circle cx="50" cy="50" fill="none" stroke="#6448e7" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" transform="rotate(251.563 50 50)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="2s" begin="0s" repeatCount="indefinite"></animateTransform></circle></svg>
        <noscript>
        <style>
        #spbhlprpro_init_spinner { display:none !important; }
        <?php echo esc_html("#".$this->wrapperId); ?> { display:block !important; }
        </style>
        </noscript>
        <script>
        jQuery(function ($) {
            $(document).ready(function () {
                $("#spbhlprpro_init_spinner").remove();
                $("<?php echo esc_html("#".$this->wrapperId); ?>").show();
            });
        });
        </script>
        <?php
    }
}
