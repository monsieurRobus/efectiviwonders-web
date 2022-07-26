<?php

namespace SuperbHelperPro\Modules;

use SuperbHelperPro\Events\ProductsEvent;

class ProductSuccessNotification extends GenericNotification
{
    protected function Build()
    {
        ?>
        <div class="spbhlprpro_products_success_modal">
                <?php echo esc_html($this->GetMessage()['message']);
        $this->BuildActivateOption(); ?>
        </div>
        <?php
        ProductsEvent::RemoveTransient();
    }

    private function BuildActivateOption()
    {
        if (!isset($this->GetMessage()['slug'])) {
            return;
        }
        $slug = $this->GetMessage()['slug']; ?>
            <form method="post">
            <?php wp_nonce_field(ProductsEvent::UPGRADE_ACTION, ProductsEvent::UPGRADE_NONCE);
        esc_html_e("Would you like to activate it now?", 'superbhelperpro'); ?>
            <button type="submit" class="spbhlprpro_standalone_activate_btn spbhlprpro_customer_products_item_cta_button spbhlprpro_customer_products_item_cta_button_activate" name="<?php echo esc_attr(ProductsEvent::UPGRADE_ACTIVATE); ?>" value="<?php echo esc_attr($slug); ?>"><?php echo esc_html_e("Activate", 'superbhelperpro'); ?></button>
            </form>
        <?php
    }
}
