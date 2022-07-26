<?php

namespace SuperbHelperPro\Notices;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Modules\UpdateNotification;
use SuperbHelperPro\Handlers\CronController;
use SuperbHelperPro\Notices\NoticeData;

use Exception;

if (! defined('WPINC')) {
    die;
}

class NoticeController
{
    private $db;
    private $spbhlprpro_notices;
    private $disable = false;
    public function __construct()
    {
        add_action('admin_notices', array($this, 'superbhelperpro_notices'));
    }

    public function superbhelperpro_notices()
    {
        $this->recommended_notices();
        $this->update_notices();
    }

    private function update_notices()
    {
        new UpdateNotification(get_transient(CronController::UPDATES_TRANSIENT));
    }

    private function recommended_notices()
    {
        try {
            $this->db = DataController::GetInstance();
            $settings = $this->db->get_settings();
            if (!$settings['recommended']) {
                return false;
            }
            $this->spbhlprpro_notices = NoticeData::GetData();
        } catch (Exception $ex) {
            return false;
        }

        try {
            $time_diff = time() - $this->db->get_time();
            $current_notice_idx = floor($time_diff / 604800);
            if ($current_notice_idx === false || $current_notice_idx>=count($this->spbhlprpro_notices)) {
                $current_notice_idx=0;
                $this->db->reset_time();
            }
            $default_link = 'https://superbthemes.com/redirect-to/?SPR=%s&SPK=%s';
            $current_notice = $this->spbhlprpro_notices[$current_notice_idx];
            //$current_notice = $this->spbhlprpro_notices[rand(0, count($this->spbhlprpro_notices)-1)];
            $current_identity = $current_notice['Identity'];
            if (isset($_COOKIE['spbhlprpro-notice-never'])) {
                $never_cookie = json_decode(stripslashes($_COOKIE['spbhlprpro-notice-never']));
                if (isset($never_cookie->$current_identity) && $never_cookie->$current_identity===true) {
                    return false;
                }
            }
            if (isset($_COOKIE['spbhlprpro-notice-later'])) {
                $later_cookie = json_decode(stripslashes($_COOKIE['spbhlprpro-notice-later']));
                if (isset($later_cookie->$current_identity) && is_numeric($later_cookie->$current_identity) && strtotime("+2 days", $later_cookie->$current_identity) > time()) {
                    return false;
                }
            }
            $slug = explode('-notice', $current_notice['Identity'])[0];
        } catch (Exception $ex) {
            return false;
        }
        try {
            $key = $this->db->get_key();
            $key = !$key ? 'nk' : urlencode(base64_encode($key[0]['spbhlprpro_token']));
            $current_notice['Link'] = sprintf($default_link, $slug, $key);
        } catch (Exception $ex) {
            $current_notice['Link'] = sprintf($default_link, $slug, "nke");
        } ?>
        <div class="spbhlprpro-notice-notice" id="spbhlprpro-notice-notice">
        <style>
        <?php echo $current_notice['CSS']; ?>
        </style>
            <div class="spbhlprpro-notice-message">
                <p>
                <span><?php echo esc_html($current_notice['Title']); ?></span> 
                <?php echo esc_html($current_notice['Description']); ?>
                </p>
                <?php
                    foreach ($current_notice['Buttons'] as &$button) { ?>
                        <a href="<?php echo esc_url($current_notice['Link']);?>" target="_blank" rel="nofollow noopener"><?php echo esc_html($button['Title']);?></a> 
                    <?php }
        unset($button); ?>
                <button type="button" id="spbhlprpro_notice_later" data-element="<?php echo esc_attr($current_notice['Identity']); ?>" data-time="<?php echo esc_attr(time()); ?>">Ask me later</button>
                <button type="button" id="spbhlprpro_notice_never" data-element="<?php echo esc_attr($current_notice['Identity']); ?>">Don't show me this again</button>
            </div>
        </div>
        <?php
    }
}
