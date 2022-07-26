<?php

namespace SuperbHelperPro\Handlers;

use SuperbHelperPro\Data\DataController;
use SuperbHelperPro\Handlers\ProductController;
use SuperbHelperPro\Utils\spbhlprproException;
use SuperbHelperPro\Utils\spbhlprproUpgrader;
use SuperbHelperPro\Utils\spbhlprpro_upgrader_skin;
use SuperbHelperPro\Companions\CompanionController;

use Exception;

if (! defined('WPINC')) {
    die;
}

class InstallationController
{
    private static function operation_fail($message)
    {
        return array(
                "error" => true,
                "message" => sanitize_text_field($message)
            );
    }

    private static function operation_success($message, $slug = false)
    {
        return array(
                "error" => false,
                "message" => sanitize_text_field($message),
                "slug" => $slug
            );
    }

    public static function activate_product($slug)
    {
        try {
            $validated_product = ProductController::get_validated_product($slug);
            if (!is_array($validated_product)) {
                throw new spbhlprproException(__("The product could not be validated. Please try again.", "superbhelperpro"), "11001");
            }

            if ($validated_product['type'] == "child") {
                $slug = explode(":", $slug)[1];
                $validated_product['type'] = "theme";
            }

            if ($validated_product['type'] == "theme") {
                if (!ProductController::is_theme_installed($slug)) {
                    throw new spbhlprproException(__("The theme could not be activated because it is not installed.", "superbhelperpro"), "1004");
                }
                $result = switch_theme($slug);
            } elseif ($validated_product['type'] == "plugin") {
                if (!ProductController::is_plugin_installed($slug)) {
                    throw new spbhlprproException(__("The plugin could not be activated because it is not installed.", "superbhelperpro"), "1004");
                }
                $result = activate_plugin($slug);
            }
            if (!is_wp_error($result)) {
                // return false to signal no errors
                return self::operation_success(sprintf(__('The %s "%s" is now active.', "superbhelperpro"), $validated_product['type'], $validated_product['name']));
            } else {
                throw new Exception();
            }
        } catch (spbhlprproException $spbex) {
            return self::operation_fail($spbex->getMessage()." (error code #".$spbex->getCode().").");
        } catch (Exception $ex) {
            $code = $ex->getCode() != 0 ? $ex->getCode() : "500";
            return self::operation_fail(__("Something went wrong during the activation process.", "superbhelperpro")." (error code #".$code.").");
        }
    }

    public static function install_product($slug)
    {
        try {
            $validated_product = ProductController::get_validated_product($slug);
            if (!is_array($validated_product)) {
                throw new spbhlprproException(__("The product could not be validated. Please try again.", "superbhelperpro"), "11002");
            }

            if ($validated_product['type'] == "child") {
                $slug = explode(":", $slug)[1];
                $info = array("slug_info" => $validated_product);
                $validated_product['type'] = "theme";
            }

            $info = isset($info) ? $info : DataController::GetInstance()->get_key_info(array("slug" => $slug));
            if (!$info || is_null($info)) {
                throw new spbhlprproException(__("Something went wrong when gathering information about the product.", "superbhelperpro"), "1006");
            }
                
            if (!isset($info['slug_info']) || !$info['slug_info']) {
                throw new spbhlprproException(sprintf(__("Product could not be installed. Please check if your %s updates have expired.", "superbhelperpro"), $validated_product['type']), "1007");
            }
            $info['slug_info']['name'] = $validated_product['name'];
            $info['slug_info']['parent'] = $validated_product['parent'];
            if ($validated_product['type'] == "theme") {
                return self::install_theme($slug, $info['slug_info']);
            } elseif ($validated_product['type']=="plugin") {
                return self::install_plugin($slug, $info['slug_info']);
            }

            throw new spbhlprproException(__("Product could not be installed. The installation process couldn't be initialized.", "superbhelperpro"), "1008");
        } catch (spbhlprproException $spbex) {
            return self::operation_fail($spbex->getMessage()." (error code #".$spbex->getCode().").");
        } catch (Exception $ex) {
            $code = $ex->getCode() != 0 ? $ex->getCode() : "500";
            return self::operation_fail(__("Something went wrong during the installation process.", "superbhelperpro")." (error code #".$code.").");
        }
    }

    private static function install_plugin($slug, $slug_info)
    {
        try {
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            $upgrader = new \Plugin_Upgrader(new spbhlprpro_upgrader_skin());
            $customUpgrader = new spbhlprproUpgrader($upgrader);
            $slug = sanitize_text_field($slug);
            $installed_version = ProductController::is_plugin_installed($slug);
            $isUpdate = false;
            if ($installed_version) {
                if (version_compare($installed_version, $slug_info['version'], '>=')) {
                    throw new spbhlprproException(__("Unable to update. Plugin is already up to date.", 'spbhlprpro'), "5501");
                }
                $should_reactivate_plugin = is_plugin_active($slug);
                $isUpdate = true;
                $installed = $customUpgrader->upgrade_plugin(base64_decode($slug_info['token']), $slug);
            } else {
                $should_reactivate_plugin = false;
                $installed = $upgrader->install(base64_decode($slug_info['token']));
            }
            if (!is_wp_error($installed) && $installed) {
                if ($should_reactivate_plugin) {
                    activate_plugin($slug);
                }
                // return success to signal no errors
                return self::operation_success(sprintf(__('The plugin "%s" was successfully %s.', "superbhelperpro"), $slug_info['name'], ($isUpdate?"updated":"installed")), $isUpdate?false:$slug);
            }
            throw new spbhlprproException(__("The Superb Helper Pro process completed succesfully, but WordPress threw an error.", 'superbhelperpro'), "55902");
        } catch (spbhlprproException $spbex) {
            throw new spbhlprproException($spbex->getMessage(), $spbex->getCode());
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong during the plugin installation process.", "superbhelperpro"), "5502");
        }
    }

    private static function install_theme($slug, $slug_info)
    {
        try {
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            $upgrader = new \Theme_Upgrader(new spbhlprpro_upgrader_skin());
            $customUpgrader = new spbhlprproUpgrader($upgrader);
            $slug = sanitize_text_field($slug);
            $installed_version = ProductController::is_theme_installed($slug);
            $isUpdate = false;
            if ($installed_version) {
                if (version_compare($installed_version, $slug_info['version'], '>=')) {
                    throw new spbhlprproException(__("Unable to update. Theme is already up to date.", 'superbhelperpro'), "5503");
                }
                $isUpdate = true;
                $installed = $customUpgrader->upgrade_theme(base64_decode($slug_info['token']), $slug);
            } else {
                $installed = $upgrader->install(base64_decode($slug_info['token']));
            }
            if (!is_wp_error($installed) && $installed) {
                CompanionController::enable_companions();
                $is_active = (wp_get_theme()->get_stylesheet() == $slug);
                $slug = (isset($slug_info['parent']) && $slug_info['parent'] !== false) ? $slug_info['parent'].":".$slug : $slug;
                // return success to signal no errors
                return self::operation_success(sprintf(__('The theme "%s" was successfully %s.', "superbhelperpro"), $slug_info['name'], ($isUpdate?"updated":"installed")), ($isUpdate||$is_active)?false:$slug);
            }
            throw new spbhlprproException(__("The Superb Helper Pro process completed succesfully, but WordPress threw an error.", 'superbhelperpro'), "55904");
        } catch (spbhlprproException $spbex) {
            throw new spbhlprproException($spbex->getMessage(), $spbex->getCode());
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong during the theme installation process.", "superbhelperpro"), "5504");
        }
    }

    public static function delete_product($slug)
    {
        try {
            $validated_product = ProductController::get_validated_product($slug);
            if (!is_array($validated_product)) {
                throw new spbhlprproException(__("The product could not be validated. Please try again.", "superbhelperpro"), "11003");
            }

            if ($validated_product['type'] == "child") {
                $slug = explode(":", $slug)[1];
                $validated_product['type'] = "theme";
            }
            if ($validated_product['type'] == "theme") {
                if (!ProductController::is_theme_installed($slug)) {
                    throw new spbhlprproException(__("The theme could not be deleted because it is not installed.", "superbhelperpro"), "2001");
                }
                if (wp_get_theme()->get_stylesheet() == $slug) {
                    throw new spbhlprproException(__("The theme could not be deleted because it is currently active. Please activate another theme before deleting this one.", "superbhelperpro"), "2002");
                }
                if ($validated_product['children']!==false) {
                    $active_child = self::get_active_child($validated_product['children']);
                    if ($active_child!==false) {
                        throw new spbhlprproException(sprintf(__("Theme can not be deleted while one of its child theme addons is active. Please deactivate the child theme \"%s\" before deleting this theme.", "superbhelperpro"), $active_child), "2004");
                    }
                }
                $result = delete_theme($slug);
            } elseif ($validated_product['type'] == "plugin") {
                if (!ProductController::is_plugin_installed($slug)) {
                    throw new spbhlprproException(__("The plugin could not be deleted because it is not installed.", "superbhelperpro"), "2003");
                }
                $result = delete_plugins(array($slug));
            }
                
            if (!is_wp_error($result) && $result) {
                // return false to signal no errors
                return self::operation_success(sprintf(__('The %s "%s" was successfully deleted.', "superbhelperpro"), $validated_product['type'], $validated_product['name']));
            } else {
                throw new Exception();
            }
        } catch (spbhlprproException $spbex) {
            return self::operation_fail($spbex->getMessage()." (error code #".$spbex->getCode().").");
        } catch (Exception $ex) {
            $code = $ex->getCode() != 0 ? $ex->getCode() : "500";
            return self::operation_fail(__("Something went wrong during the deletion process.", "superbhelperpro")." (error code #".$code.").");
        }
    }

    private static function get_active_child($children)
    {
        $is_active = false;
        foreach ($children as &$child) {
            if (wp_get_theme()->get_stylesheet() == $child['slug']) {
                $is_active = $child['name'];
                break;
            }
        }
        unset($child);
        return $is_active;
    }
}
