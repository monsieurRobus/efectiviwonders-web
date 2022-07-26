<?php

namespace SuperbHelperPro\Pages;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Utils\spbhlprproException;
use SuperbHelperPro\Events\KeyEvent;
use SuperbHelperPro\Modules;

class KeyPage extends GenericPage
{
    const WRAPPER = 'spbhlprpro_key_page_wrapper';

    private $has_key = false;
    private $settings = false;

    protected function Setup()
    {
        $this->LoadHasKey();
        if ($this->HasKey()) {
            $this->LoadSettings();
        }
    }

    private function LoadHasKey()
    {
        try {
            $this->has_key = DataController::GetInstance()->has_key();
        } catch (spbhlprproException $ex) {
            PageController::SetErrorMessage($ex->getMessage());
        }
    }

    private function LoadSettings()
    {
        $this->settings = DataController::GetInstance()->get_settings();
    }

    public function HasKey()
    {
        return $this->has_key;
    }

    public function GetSettings()
    {
        return $this->settings;
    }

    public function GetProductUrl()
    {
        return admin_url('admin.php?page='.PageController::BASE);
    }

    protected function Build()
    {
        new Modules\Header(__("License Key", 'superbhelperpro'));
        new Modules\InitSpinner(self::WRAPPER); ?>

        <div id="<?php echo esc_attr(self::WRAPPER); ?>" style="display:none;">

        <?php new Modules\ErrorNotification($this->error_message);
        new Modules\LoadSpinner(); ?>
        <div id="spbhlprpro_key_page_wrapper_inner">
        <?php if ($this->HasKey()) {?>
        <form id="spbhlprpro-key-remove-form" method="post" autocomplete="off">
            <p><?php esc_html_e("Your products have been unlocked. You can find them by", 'superbhelperpro'); ?> <a href="<?php echo esc_url($this->GetProductUrl()); ?>"><?php esc_html_e("clicking here", 'superbhelperpro'); ?></a>.</p>
            <p><?php esc_html_e("Do you want to remove your license key from this website?", 'superbhelperpro'); ?></p>
            <input type="hidden" name="<?php echo KeyEvent::KEY_REMOVE;?>" value="1" />
            <input type="submit" class="spbhlprpro-key-btn spbhlprpro-key-btn-remove" value="Remove License Key"/>
            <?php wp_nonce_field(KeyEvent::KEY_REMOVE_ACTION, KeyEvent::KEY_REMOVE_NONCE); ?>
        </form>
        <hr />

        <?php
            $settings = $this->GetSettings();
            if ($settings!==false) {
                ?>
                <div class="spbhlprpro-additional-settings-wrapper">
                <form method="post">
                    <div class="spbhlprpro-additional-settings-item">
                        <input id="spbhlprpro-settings-companions" type="checkbox" name="<?php echo KeyEvent::SETTINGS_COMPANIONS; ?>" <?php echo $settings['companions'] ? "checked" : ""; ?>/>
                        <div <?php if (!$settings['companions']) {?> title="( ! ) Some theme features will not be available without companion plugins." <?php } ?>>
                            <label for="spbhlprpro-settings-companions">
                                <?php if (!$settings['companions']) {?><span class="dashicons dashicons-warning"></span> <?php } ?>
                                <?php esc_html_e("Install Companion Plugins", "superbhelperpro"); ?>
                            </label>
                            <p><?php esc_html_e("When installing a premium theme, we bundle companion plugins that are needed to unlock some theme features. Uncheck this option if you don't want these features and want to opt-out of companion plugin installations.", "superbhelperpro"); ?></p>
                        </div>
                    </div>

                    <hr />
                    <div class="spbhlprpro-additional-settings-item">
                        <input id="spbhlprpro-settings-recommended" type="checkbox" name="<?php echo KeyEvent::SETTINGS_RECOMMENDED; ?>" <?php echo $settings['recommended'] ? "checked" : ""; ?>/>
                        <div>
                            <label for="spbhlprpro-settings-recommended">
                                <?php esc_html_e("Display Recommended Plugins", "superbhelperpro"); ?>
                            </label>
                            <p><?php esc_html_e("We recommend certain plugins that we've reviewed and believe compliment our themes. Uncheck this option if you don't want to see our reviewed and recommended plugins.", "superbhelperpro"); ?></p>
                        </div>
                    </div>
                    <hr />
                    <input type="hidden" name="<?php echo KeyEvent::SETTINGS_SAVE; ?>" value="1" />
                    <input type="submit" class="spbhlprpro-settings-save-btn" value="<?php esc_attr_e("Save All Settings", 'superbhelperpro'); ?>"/>
                    <?php wp_nonce_field(KeyEvent::SETTINGS_SAVE_ACTION, KeyEvent::SETTINGS_SAVE_NONCE); ?>
                </form>
            </div>
        <?php
            } ?>
        <?php
        } else { ?> 
                  
        <form id="spbhlprpro-key-form" method="post" autocomplete="off">
            <label for="spbhlprpro-key-input"><?php esc_html_e("Add your license key to unlock your products:", 'superbhelperpro');?></label>
            <input type="text" id="spbhlprpro-key-input" class="spbhlprpro-key-input" name="<?php echo KeyEvent::KEY_ADD;?>" placeholder="XXXXX-XXXXX-XXXXX-XXXXX" autocomplete="off" />
            <input type="submit" class="spbhlprpro-key-btn spbhlprpro-key-btn-unlock" value="<?php echo esc_attr_e("Unlock", "superbhelperpro"); ?>"/>
            <?php wp_nonce_field(KeyEvent::KEY_ADD_ACTION, KeyEvent::KEY_ADD_NONCE); ?>
            <p><?php esc_html_e("If you do not have a license key yet, log in to our website and receive your license key by", 'superbhelperpro');?> <a href="https://superbthemes.com/superb-licensing-your-license-key/" target="_blank" rel="nofollow"><?php esc_html_e("clicking here", 'superbhelperpro');?></a>.</p>
        </form>

        <?php } ?>
        </div>
        </div>
        <?php
    }
}
