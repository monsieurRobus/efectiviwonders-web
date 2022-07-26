<?php

namespace SuperbHelperPro\Modules;

use SuperbHelperPro\Pages\PageController;

class UpdateNotification extends GenericNotification
{
    protected function Build()
    {
        $data = $this->GetMessage();
        if (!is_array($data)) {
            return;
        }
        $others_count = count($data);
        if ($others_count<=0) {
            return;
        } ?>
        <div id="spbhlprpro_products_update_notification_modal" class="notice notice-warning settings-error is-dismissible">
        <p><span class="dashicons dashicons-warning"></span>
        <strong><?php esc_html_e("Update Available", 'superbhelperpro'); ?></strong><?php
        $active_count = 0;
        $active_names = array();
        $others_count = count($data);
        foreach ($data as &$item) {
            if ($item['active']) {
                $active_count++;
                $others_count--;
                $active_names[] = $item['name'];
            }
        }
        unset($item);
        $update_link = '<a href="'.admin_url('admin.php?page='.PageController::BASE).'">'.esc_html(__("Click Here to Update", 'superbhelperpro')).'</a>';
        if ($active_count > 0) {
            // have active outdated products
            echo "<br />".esc_html(__("It looks like", 'superbhelperpro'))." <strong>".$active_count."</strong> ";
            echo($active_count === 1 ? esc_html(__("of your active premium products is outdated:", 'superbhelperpro')) : esc_html(__("of your active premium products are outdated:", 'superbhelperpro')));
            echo "</p><ul>";
            foreach ($active_names as &$aname) {
                echo "<li><strong>".esc_html($aname)." - ".$update_link."</strong></li>";
            }
            echo "</ul>";
            echo "<p>";
            if ($others_count > 0) {
                echo "<strong>".$others_count."</strong> ";
                echo($others_count === 1 ? esc_html(__("other premium product is also outdated and ready to be updated.", 'superbhelperpro')) : esc_html(__("other premium products are also outdated and ready to be updated.", 'superbhelperpro')));
            }
            unset($aname);
        } else {
            echo "<p>";
            // only inactive outdated products
            echo esc_html(__("It looks like", 'superbhelperpro'))." ".$others_count." ";
            echo($others_count === 1 ? esc_html(__("of your premium products is outdated and ready to be updated.", 'superbhelperpro')) : esc_html(__("of your premium products are outdated and ready to be updated.", 'superbhelperpro')));
        }
        echo "<br />";
        esc_html_e("Don't miss out on important updates, features and bugfixes.", 'superbhelperpro');
        echo "<br /><strong>".$update_link."</strong>";
        echo "</p>"; ?>
        </div>
        <?php
    }
}
