<?php

namespace SuperbHelperPro\Modules;

class ErrorNotification extends GenericNotification
{
    protected function Build()
    {
        ?>
            <div class="spbhlprpro_products_error_modal">
                <?php echo esc_html($this->GetMessage()); ?>
            </div>
        <?php
    }
}
