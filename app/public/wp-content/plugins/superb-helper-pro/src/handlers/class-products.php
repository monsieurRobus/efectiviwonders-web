<?php

namespace SuperbHelperPro\Handlers;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Utils\spbhlprproException;

if (! defined('WPINC')) {
    die;
}

class ProductController
{
    public static function get_validated_product($slug)
    {
        $allowed_products = DataController::GetInstance()->get_data("ignore_refresh");
        $validated_product = false;
        if (!isset($allowed_products['products'])) {
            throw new spbhlprproException(__("Something went wrong when trying to gather product data from the database.", "superbhelperpro"), "1001");
        }
        if (strpos($slug, ':')===false) {
            //Is regular product
            foreach ($allowed_products['products'] as &$productItem) {
                if ($productItem['slug'] == $slug) {
                    $children = (isset($productItem['children']) && count($productItem['children']) > 0) ? $productItem['children'] : false;
                    $validated_product = array("type" => sanitize_text_field($productItem['type']), "children" => $children, "name" => $productItem['name'], "parent" => false);
                    break;
                }
            }
            unset($productItem);
        } else {
            // Is child product
            $slugs = explode(":", $slug);
            $parent_slug = $slugs[0];
            $child_slug = $slugs[1];
            foreach ($allowed_products['products'] as &$productItem) {
                if ($productItem['slug'] == $parent_slug) {
                    if (isset($productItem['children']) && count($productItem['children']) > 0) {
                        foreach ($productItem['children'] as &$child) {
                            if ($child['slug'] == $child_slug) {
                                $validated_product = array("type" => sanitize_text_field($child['type']), "token" => $child['token'], "version" => $child['version'], "name" => $child['name'], "parent" => $parent_slug);
                                break;
                            }
                        }
                        unset($child);
                    }
                    break;
                }
            }
            unset($productItem);
        }

        if (!$validated_product) {
            throw new spbhlprproException(__("Product could not be validated.", "superbhelperpro"), "1002");
        }
        if (!isset($validated_product) || is_null($validated_product) || empty($validated_product)) {
            throw new spbhlprproException(__("Something went wrong when gathering information about the product.", "superbhelperpro"), "1003");
        }

        return $validated_product;
    }

    public static function is_plugin_installed($path)
    {
        $all_plugins = get_plugins();
        return !empty($all_plugins[$path]) ? $all_plugins[$path]['Version'] : false;
    }

    public static function is_theme_installed($slug)
    {
        $all_themes = wp_get_themes();
        return !empty($all_themes[$slug]) ? $all_themes[$slug]['Version'] : false;
    }

    public static function get_installed_version($productItem)
    {
        if ($productItem['type']==="theme") {
            return self::is_theme_installed($productItem['slug']);
        } elseif ($productItem['type']==="plugin") {
            return self::is_plugin_installed($productItem['slug']);
        } else {
            return false;
        }
    }

    public static function get_product_active($productItem)
    {
        if ($productItem['type']==="theme") {
            return (wp_get_theme()->get_stylesheet() === $productItem['slug']);
        } elseif ($productItem['type']==="plugin") {
            return \is_plugin_active($productItem['slug']);
        } else {
            return false;
        }
    }

    public static function get_is_outdated($installedVersion, $productItem)
    {
        if (!isset($productItem['version'])) {
            return false;
        }
        return !$installedVersion ? false : (version_compare($installedVersion, $productItem['version'], "<") ? true : false);
    }

    public static function get_product_info($productItem)
    {
        $productType = $productItem['type'];
        $isActive = self::get_product_active($productItem);
        $hasChildren = (isset($productItem['children']) && count($productItem['children']) > 0);
        $children = $hasChildren ? array_map(function ($item) {
            return $item['name'];
        }, $productItem['children']) : false;
        $isExpired = $productItem['is_expired'];
        $installedVersion = self::get_installed_version($productItem);
        $isOutdated = self::get_is_outdated($installedVersion, $productItem);
        $info_message = sprintf(__("Your premium %s is ready to be installed.", 'superbhelperpro'), $productType);
        $product_class = "";
        if (!$isOutdated && $installedVersion) {
            $info_message = sprintf(__("Your premium %s is up to date.", 'superbhelperpro'), $productType);
            $product_class = "spbhlprpro_customer_products_item_updated";
        } elseif ($isOutdated && $installedVersion && version_compare($installedVersion, "100", "<")) {
            $info_message = sprintf(__("The free version of the %s (version %s) is currently installed. Your premium version update is ready.", 'superbhelperpro'), $productType, $installedVersion);
            $product_class = "spbhlprpro_customer_products_item_cta_update";
        } elseif ($isOutdated) {
            $info_message = sprintf(__("Your premium %s is out of date.", 'superbhelperpro'), $productType).sprintf(__(" (version %s)", 'superbhelperpro'), $installedVersion);
            $product_class = "spbhlprpro_customer_products_item_cta_update";
        }
        if ($isExpired) {
            if ($isOutdated) {
                $info_message .= __(" and your ", 'superbhelperpro');
            } else {
                $info_message = __("Your ", 'superbhelperpro');
            }
            $info_message .= sprintf(__("premium %s updates have expired.", 'superbhelperpro'), $productType);
            $product_class = "spbhlprpro_customer_products_item_cta_expired";
        }

        $version_info = self::format_version_info($productItem['version_info'], $productItem['version']);
    
        return array(
                "name" => $productItem['name'],
                "version" => $productItem['version'],
                "version_info" => $version_info['version_info'],
                "changelog" => $version_info['changelog'],
                "image" => $productItem['image'],
                "slug" => $productItem['slug'],
                "isParentInstalled" => true,
                "isExpired" => $isExpired,
                "isOutdated" => $isOutdated,
                "installedVersion" => $installedVersion,
                "infoMessage" => $info_message,
                "productClass" => $product_class,
                "productType" => $productType,
                "isActive" => $isActive,
                "hasChildren" => $hasChildren,
                "children" => $children
            );
    }

    private static function format_version_info($info, $version)
    {
        $info_arr = explode("***", trim($info));
        $info_arr = array_filter($info_arr);

        if (count($info_arr) <= 1) {
            return array(
                "version_info" => $info,
                "changelog" => null
            );
        }

        $newest_info = "";
        $log = array();

        foreach ($info_arr as $item) {
            $item = explode("==", $item);
            $item = array_filter($item);
            if ($version == $item[1]) {
                $newest_info = $item[2];
            } else {
                $log[] = array(
                    "version" => $item[1],
                    "version_info" => $item[2]
                );
            }
        }

        return array(
            "version_info" => $newest_info,
            "changelog" => $log
        );
    }

    public static function get_child_info($productItem)
    {
        if (!isset($productItem['version']) || !$productItem['version']) {
            return false;
        }
        if ($productItem['type']=="child") {
            $productType = "child";
            $isActive = (wp_get_theme()->get_stylesheet() == $productItem['slug']);
        } else {
            return false;
        }
        $installedVersion = self::is_theme_installed($productItem['slug']);
        $isParentInstalled = self::is_theme_installed($productItem['parent_slug']);
        $isOutdated = !$installedVersion ? false : (version_compare($installedVersion, $productItem['version'], "<") ? true : false);
        $info_message = sprintf(__("Your child theme addon is ready to be installed.", 'superbhelperpro'), $productType);
        $product_class = "";
        if (!$isOutdated && $installedVersion) {
            $info_message = sprintf(__("Your child theme addon is up to date.", 'superbhelperpro'), $productType);
            $product_class = "spbhlprpro_customer_products_item_updated";
        } elseif ($isOutdated) {
            $info_message = sprintf(__("Your child theme addon is out of date.", 'superbhelperpro'), $productType).sprintf(__(" (version %s)", 'superbhelperpro'), $installedVersion);
            $product_class = "spbhlprpro_customer_products_item_cta_update";
        }

        if (!$isParentInstalled) {
            $info_message = sprintf(esc_html(__('Parent theme "%s" must be installed.', 'superbhelperpro')), $productItem['parent']);
            $product_class = "spbhlprpro_customer_products_item_cta_update";
            $isOutdated = true;
        }
    
        return array(
                "name" => $productItem['name'],
                "version" => $productItem['version'],
                "version_info" => $productItem['name'].__(" is a free child theme addon for the premium theme ", "superbhelperpro").$productItem['parent'].".",
                "image" => $productItem['image'],
                "slug" => $productItem['slug'],
                "parent" => $productItem['parent'],
                "parent_slug" => $productItem['parent_slug'],
                "isParentInstalled" => $isParentInstalled,
                "infoMessage" => $info_message,
                "isExpired" => false,
                "isOutdated" => $isOutdated,
                "installedVersion" => $installedVersion,
                "productClass" => $product_class,
                "productType" => $productType,
                "isActive" => $isActive,
                "hasChildren" => false
            );
    }
}
