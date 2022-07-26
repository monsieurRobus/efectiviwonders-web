<?php

namespace SuperbHelperPro\Pages;

use SuperbHelperPro\Pages\PageController;
use SuperbHelperPro\Events\UpdateEvent;
use SuperbHelperPro\Modules;

class UpdatePage extends GenericPage
{
    const WRAPPER = 'spbhlprpro_update_needed_wrapper';

    protected function Setup()
    {
        // no setup required
    }

    protected function Build()
    {
        new Modules\ErrorNotification($this->error_message);
        new Modules\InitSpinner(self::WRAPPER); ?>
        
        <div id="<?php echo esc_attr(self::WRAPPER); ?>" class="spbhlprpro_update_needed" style="display:none;">
                <h2><?php esc_html_e("Superb Helper Pro Is Out Of Date!", 'superbhelperpro'); ?></h2>
                <p><?php esc_html_e("Superb Helper Pro is not able to safely install and update your products when not on the latest version. Please update as soon as possible to continue using this plugin.", 'superbhelperpro'); ?></p>
                <div id="spbhlprpro_update_needed_buttons">
                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page='.PageController::UPDATE), UpdateEvent::UPDATE_ACTION, UpdateEvent::UPDATE_NONCE); ?>" class="spbhlprpro_update_needed_button"><?php esc_html_e("Update Now", 'superbhelperpro'); ?></a>
                <a href="<?php echo esc_url(admin_url("plugins.php")); ?>" class="spbhlprpro_update_needed_button"><?php esc_html_e("Go to Installed Plugins", 'superbhelperpro'); ?></a>
                </div>
                <?php new Modules\LoadSpinner(); ?>
        </div>
        <?php
    }
}
