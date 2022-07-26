<?php

namespace SuperbHelperPro\Pages;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Pages\UpdatePage;
use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Handlers\CronController;
use SuperbHelperPro\Events\ProductsEvent;
use SuperbHelperPro\Modules;

use DateTime;

class ProductsPage extends GenericPage
{
    const WRAPPER = 'spbhlprpro_products_page_wrapper';

    private $info;
    private $has_products = true;

    protected function Setup()
    {
        $info = DataController::GetInstance()->get_data();
        $info['date'] = isset($info['date']) ? $info['date'] : null;
        CronController::GetInstance()->spbhlprpro_cron_function($info);
        $displayVersionWarning = !isset($info['version']) ? false : (version_compare($info['version'], ProductController::is_plugin_installed(SUPERBHELPERPRO_BASE), ">") ? true : false);
        // If Superb Helper Pro is outdated, display Update Page
        if ($displayVersionWarning) {
            $this->IgnoreBuild();
            new UpdatePage();
        } else {
            if (!isset($info['products']) || !$info['products'] || count($info['products']) <= 0) {
                $this->has_products = false;
            }
            $this->info = $info;
        }
    }

    public function GetInfo()
    {
        return $this->info;
    }

    public function HasProducts()
    {
        return $this->has_products;
    }

    public function get_time_diff($date)
    {
        if (!isset($date)) {
            return "Just now";
        }

        $interval = date_diff(new DateTime($date), new DateTime(date("Y-m-d H:i:s")));
        $differenceFormat = "%h %i %s";

        if ($interval->h > 0) {
            $differenceFormat = "%h hour(s) ago";
        } elseif ($interval->i > 0) {
            $differenceFormat = "%i minute(s) ago";
        } elseif ($interval->s >= 0) {
            return "Just now";
        } else {
            return "Recently";
        }

        return $interval->format($differenceFormat);
    }

    protected function Build()
    {
        $info = $this->GetInfo();
        
        new Modules\Header(__("Access Your Premium Products", 'superbhelperpro'), $info['message']);
        new Modules\InitSpinner(self::WRAPPER); ?>
        <div id="<?php echo esc_attr(self::WRAPPER); ?>" style="display:none;">
        <div class="spbhlprpro_update_data_wrapper spbhlprpro_update_data_update_notification">
            <?php new Modules\LoadSpinner(); ?>
            <form method="post">
                <?php wp_nonce_field('spbhlprpro_update_check', '_spbhlprpro_update_check_nonce'); ?>
                <button type="submit" class="spbhlprpro_update_data_btn" name="spbhlprproupdate" value="refresh"><?php esc_html_e("Check for Updates", 'superbhelperpro'); ?></button>
                <span class="spbhlprpro_update_text"><?php esc_html_e("Last checked", 'superbhelperpro'); ?>: <span id="spbhlprpro_update_time" data-time="<?php echo esc_attr($info['date']); ?>" data-now="<?php echo esc_attr(date("Y-m-d H:i:s")); ?>"><?php echo esc_html($this->get_time_diff($info['date'])); ?></span></span>
            </form>
            <button style="display:none;" class="spbhlprpro_update_data_btn spbhlprpro_cancel_order_btn"><?php esc_html_e("Cancel", 'superbhelperpro'); ?></button>
        </div>
        <?php new Modules\ErrorNotification($this->error_message); ?>
        <?php new Modules\ProductSuccessNotification(get_transient(ProductsEvent::PRODUCT_TRANSIENT)); ?>
        <div class="spbhlprpro_customer_products_wrapper">
                <?php
                if (!$this->HasProducts()) {
                    echo "<div class='spbhlprpro_customer_products_missing'><span>!</span>We couldn't find any downloadable products for this license key.</div>";
                    echo "<div class='spbhlprpro_customer_products_item_cta_expired'>If you've previously had an active subscription, it may need to be renewed. <a class='spbhlprpro_customer_products_item_cta_button spbhlprpro_standalone_activate_btn' target='_blank' href='".esc_url("https://superbthemes.com/")."'>Visit SuperbThemes.com</a></div>";
                    $info['products'] = array();
                } else {
                    $last_product_name = $info['products'][count($info['products'])-1]['name'];
                    $example_search = str_replace(array("Premium", "Plugin: "), "", $last_product_name)
                    ?>
                    <div class="spbhlprpro_products_search_wrapper">
                        <input id="spbhlprpro-product-search" name="spbhlprpro-product-search" type="search" 
                        placeholder="<?php esc_attr_e("Search for your product.. For example: ", 'superbhelperpro');
                    echo esc_attr($example_search); ?>" />
                    </div>
                <?php
                } ?>
                <form method="post">
                <?php
                wp_nonce_field('spbhlprpro_upgrade', '_spbhlprpro_upgrader_nonce');
        
        foreach ($info['products'] as &$productItem) {
            $product_info = ProductController::get_product_info($productItem);
            if (!$product_info) {
                continue;
            }
            $this->generate_box($product_info); ?>
                    
                    <?php if (isset($productItem['children']) && count($productItem['children']) > 0) {
                ?> 
                        <div class="spbhlprpro_customer_products_addons_wrapper">
                        <?php
                        foreach ($productItem['children'] as &$child) {
                            $product_info = ProductController::get_child_info($child);
                            if (!$product_info) {
                                continue;
                            }
                            $this->generate_box($product_info); ?>
                        <?php
                        }
                unset($child); ?> 
                    </div>
                    <?php
            } ?>
                    <?php
        }
        unset($productItem); ?>
            </form>
        </div>
        </div>
        <?php
    }

    private function generate_box($product_info)
    {
        $slug = $product_info['productType'] == "child" ? $product_info['parent_slug'].":".$product_info['slug'] : $product_info['slug'];
        $has_changelog = isset($product_info['changelog']) && !is_null($product_info['changelog']);
        $searchString_single = $product_info['name'];
        $searchString_combined = $product_info['name'].(isset($product_info['parent']) ? " ".$product_info['parent'] : "");
        if (isset($product_info['children']) && $product_info['children'] !== false) {
            foreach ($product_info['children'] as &$child_name) {
                $searchString_combined .= " ".$child_name;
            }
            unset($child_name);
        }
        $imagesrc = !empty($product_info['image']) ? $product_info['image'] : $this->base_url."/assets/img/no-image.png"; ?>
			<div  data-search="<?php echo esc_attr($searchString_combined); ?>" data-search-single="<?php echo esc_attr($searchString_single); ?>" class="spbhlprpro_customer_products_item <?php echo $product_info['isExpired'] || $product_info['isOutdated'] ?'spbhlprpro_customer_products_item_outdated':'spbhlprpro_customer_products_item_updated';
        echo $product_info['productType'] == "child" ? " spbhlprpro_customer_products_addon" : "";
        echo $product_info['hasChildren'] ? " spbhlprpro_customer_products_has_children" : "";
        echo $product_info['isActive'] ? " spbhlprpro_customer_products_is_active" : ""; ?>">
				<div class="spbhlprpro_customer_products_item_image">
					<img width="150" src="<?php echo esc_attr($imagesrc); ?>" alt="<?php echo esc_attr($product_info['name']); ?> screenshot">
				</div>
				<div class="spbhlprpro_customer_products_item_content">			
					<h3>
						<?php if ($product_info['productType'] == 'child') { ?> 
							<span class="spbhlprpro_customer_products_item_content_type spbhlprpro_customer_products_item_content_addon"><?php esc_html_e("Addon", 'superbhelperpro'); ?></span>
						<?php } else { ?>
							<span class="spbhlprpro_customer_products_item_content_type"><?php esc_html_e("Premium", 'superbhelperpro'); ?> <?php echo esc_html($product_info['productType']); ?></span>
						<?php } ?>
							<span class="spbhlprpro_products_item_title"><?php echo esc_html($product_info['name']); ?></span>
					</h3>	
					<ol>
						<li><span><strong><?php esc_html_e("Latest version:", 'superbhelperpro'); ?> <?php echo esc_html($product_info['version']); ?></strong></span> <?php echo esc_html($product_info['version_info']); ?>
                        <?php $this->generate_changelog($has_changelog, $product_info); ?>
                        </li>
						<li><?php echo esc_html($product_info['infoMessage']); ?></li>
					</ol>	
				</div>	
				<div class="spbhlprpro_customer_products_item_cta <?php echo esc_attr($product_info['productClass']); ?>">
					<?php // Only Display Main Action Buttons & Activate Buttons if parent or if parent is installed
                    if ($product_info['isParentInstalled']) { ?>
						<?php // Display Main Action Buttons
                        if (!$product_info['isExpired'] && !$product_info['isOutdated'] && $product_info['installedVersion']) { ?>
							<button disabled class="spbhlprpro_customer_products_item_cta_button spbhlprpro_customer_products_item_cta_button_updated"><?php esc_html_e("Up To Date", 'superbhelperpro');?></button>
						<?php } elseif ($product_info['isExpired']) { ?>
							<a class="spbhlprpro_customer_products_item_cta_button spbhlprpro_customer_products_item_cta_button_expired" target="_blank" href="<?php echo esc_url("https://superbthemes.com/theme-plugin-updates/");?>"><?php esc_html_e("Buy Updates", 'superbhelperpro');?></a>
							<p><?php echo sprintf(esc_html(__('It looks like your %s updates have expired, %s to purchase %s updates.', 'superbhelperpro')), esc_html($product_info['productType']), '<a class="spbhlprpro_customer_products_item_cta_button_expired" target="_blank" href="'.esc_url("https://superbthemes.com/theme-plugin-updates/").'">'.esc_html(__('click here', 'superbhelperpro')).'</a>', esc_html($product_info['productType']));?></p>
						<?php } else { ?>
							<button type="submit" class="spbhlprpro_customer_products_item_cta_button" name="spbhlprpro_install" value="<?php echo esc_attr($slug);?>"><?php echo esc_html(($product_info['isOutdated'] && !$product_info['isExpired']) ? __("Update", 'superbhelperpro') : __("Install", 'superbhelperpro')); ?></button>
						<?php } ?>
						<?php // Display Activate / Activated Button if installed
                        if (!$product_info['isActive'] && $product_info['installedVersion']) { ?>
							<button type="submit" class="spbhlprpro_customer_products_item_cta_button spbhlprpro_customer_products_item_cta_button_activate" name="spbhlprpro_activate" value="<?php echo esc_attr($slug);?>"><?php esc_html_e("Activate", 'superbhelperpro');?></button>
						<?php } elseif ($product_info['isActive'] && $product_info['installedVersion']) { ?>
							<button type="button" class="spbhlprpro_customer_products_item_cta_button spbhlprpro_customer_products_item_cta_button_activate spbhlprpro_customer_products_item_cta_button_updated"><?php esc_html_e("Activated", 'superbhelperpro');?></button>
						<?php } ?>
					<?php } else {
                            // If not parent or if parent is not installed
                        ?>
						<p><?php echo esc_html(sprintf(__('The parent theme "%s" must be installed before you can install, update or activate its addons.', 'superbhelperpro'), $product_info['parent'])); ?></p>
					<?php
                        } ?>
                    <?php // Display changelog button if changelog available
                    if ($has_changelog) { ?>
                    <button type="button" class="spbhlprpro_view_changelog_button"><?php esc_html_e("View Changelog", "superbhelperpro");?></button>
                    <?php } ?>
					<?php // Display Delete Button if installed
                    if ($product_info['installedVersion']) { ?> 
						<button type="submit" class="spbhlprpro_customer_products_item_cta_button spbhlprpro_customer_products_item_cta_button_delete" name="spbhlprpro_delete" value="<?php echo esc_attr($slug);?>"><?php esc_html_e("Delete", 'superbhelperpro');?></button>
					<?php } ?>
				</div>
			</div>
	<?php
    }

    private function generate_changelog($has_changelog, $product_info)
    {
        if (!$has_changelog) {
            return;
        }

        echo "<span class='spbhlprpro_changelog_wrapper' style='display:none'>";
        echo "<br /><small>";
        esc_html_e("Previous Versions", "superbhelperpro");
        echo "</small>";
        foreach ($product_info['changelog'] as &$item) {
            echo "<br />";
            echo "<strong>Version: ".esc_html($item['version'])."</strong>";
            echo "<br />";
            echo esc_html($item['version_info']);
        }
        unset($item);
        echo "</span>";
    }
}
