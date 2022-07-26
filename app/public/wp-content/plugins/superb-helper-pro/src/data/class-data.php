<?php

namespace SuperbHelperPro\Data;

use Exception;
use SuperbHelperPro\Utils\spbhlprproException;

if (! defined('WPINC')) {
    die;
}

require_once ABSPATH . 'wp-admin/includes/theme.php';

class DataController
{
    private $db;

    private $sqlErrorResponse;
    private $successResponse;

    private static $instance;
    public static function GetInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->db_version = "2.3";
        $this->table_info = $this->db->prefix ."spbhlprpro";
        $this->table_data = $this->db->prefix ."spbhlprpro_dat";
        $this->table_stamp = $this->db->prefix ."spbhlprpro_stamp";
        $this->table_settings = $this->db->prefix ."spbhlprpro_settings";
    }

    //init
    public function create_table()
    {
        $sql = array();
        $sql[] = "CREATE TABLE $this->table_info (
            	id INT NOT NULL AUTO_INCREMENT,
                spbhlprpro_token NVARCHAR(255) NOT NULL,
                spbhlprpro_confirm TEXT NOT NULL,
                PRIMARY KEY (id)
                );";

        $sql[] = "CREATE TABLE $this->table_data (
                id INT NOT NULL AUTO_INCREMENT,
                spbhlprpro_ser LONGTEXT NOT NULL,
                spbhlprpro_ser_date DATETIME NOT NULL,
                PRIMARY KEY (id)
                );
            ";

        $sql[] = "CREATE TABLE $this->table_stamp (
                id INT NOT NULL AUTO_INCREMENT,
                spbhlprpro_stamp INT NOT NULL,
                PRIMARY KEY (id)
                );
            ";

        $sql[] = "CREATE TABLE $this->table_settings (
            id INT NOT NULL AUTO_INCREMENT,
            spbhlprpro_companions TINYINT NOT NULL,
            spbhlprpro_recommended TINYINT NOT NULL,
            PRIMARY KEY (id)
            );
        ";
                               
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $this->set_time();
        add_option('spbhlprpro_db_version', $this->db_version);
        update_option('spbhlprpro_db_version', $this->db_version);
    }

    public function has_key()
    {
        try {
            $query = "SELECT id FROM $this->table_info";
            $results = $this->db->get_results($query, ARRAY_A);
            if ($results && count($results) > 0) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong while determining if a key is unlocked on this website.", "superbhelperpro"), "6500");
        }
    }

    public function get_key()
    {
        try {
            $query = "SELECT * FROM $this->table_info";
            $results = $this->db->get_results($query, ARRAY_A);
            if ($results && count($results) > 0) {
                return $results;
            }
            return false;
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong while gathering information about the activated key.", "superbhelperpro"), "6501");
        }
    }

    private function add_key($data)
    {
        try {
            $result = $this->db->insert($this->table_info, array('spbhlprpro_token' => $data['key'],'spbhlprpro_confirm' => $data['confirm']));
            if ($this->db->last_error != '' || !$result) {
                throw new Exception();
            }
       
            return $this->db->insert_id;
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Unlocked key information could not be stored.", "superbhelperpro"), "6502");
        }
    }

    private function update_key($data)
    {
        try {
            $result = $this->db->update($this->table_info, array('spbhlprpro_confirm' => $data['confirm']), array('spbhlprpro_token' => $data['key']));
            if ($this->db->last_error != '' || !$result) {
                throw new Exception();
            }

            return true;
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong while updating the unlocked key.", "superbhelperpro"), "6503");
        }
    }

    public function remove_key()
    {
        try {
            $result = $this->db->query("DELETE FROM $this->table_info");
            if ($this->db->last_error != '' || !$result) {
                return false;
            }
            $result2 = $this->db->query("DELETE FROM $this->table_data");
       
            return true;
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong while trying to remove the license key from this website.", "superbhelperpro"), "6504");
        }
    }

    public function get_key_success_by_key($data)
    {
        try {
            $response = $this->get_key_info($data);
            if (!$response) {
                return false;
            }

            $response_success = $response['success'] == "true" ? true : false;

            if ($response_success && !$this->has_key()) {
                $this->add_key(array("key" => $data['key'], "confirm" => $response['confirm']));
            }

            return $response_success;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function get_key_info($data = false, $cron = false)
    {
        try {
            $result = false;
            $slug = isset($data['slug']) ? sanitize_text_field($data['slug']) : false;
            if (!$data || $slug) {
                $result = $this->get_key();
                if (!$result) {
                    return false;
                }
                $data = array(
                "key" => $result[0]['spbhlprpro_token'],
                "confirm" => $result[0]['spbhlprpro_confirm']
            );
            }
    
            $key = sanitize_text_field($data['key']);
            $confirm = (!$data || !$result || !isset($data['confirm'])) ? "" : sanitize_text_field($data['confirm']);
            $body = array(
            "lmk" => $key,
            "domain" => esc_url_raw(get_home_url()),
            "confirm" => $confirm,
            "version" => (defined('SUPERBHELPERPRO_VERSION') ? SUPERBHELPERPRO_VERSION : "Unknown")
            );
            if ($slug) {
                $body['slug'] = $slug;
            }
            if ($cron) {
                $body['cron'] = true;
            }
            $body = wp_json_encode($body);

            $response = wp_remote_post("https://superbthemes.com/wp-json/spblm/licensing", array(
            'body' => $body,
            'timeout' => 120,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
            ));

            if (is_wp_error($response)) {
                throw new Exception();
            }

            $response_body = json_decode($response['body'], true);
            // Get children
            if (isset($response_body['products'])) {
                foreach ($response_body['products'] as &$product) {
                    if (isset($product['children']) && count($product['children']) > 0) {
                        foreach ($product['children'] as &$child) {
                            $api = \themes_api(
                                'theme_information',
                                array(
                                    'slug'   => $child['slug'],
                                    'fields' => array(
                                        'sections' => false,
                                        'tags'     => false,
                                    ),
                                )
                            ); // Save on a bit of bandwidth.
                            if (is_wp_error($api)) {
                                $child['version'] = false;
                            } else {
                                $child['version'] = $api->version;
                                $child['parent'] = $api->parent['name'];
                                $child['parent_slug'] = $api->parent['slug'];
                                $child['token'] = base64_encode($api->download_link);
                            }
                        }
                    }
                    unset($child);
                }
                unset($product);
            }
            //
            
            $this->save_serialized($response_body);
            if (isset($response_body['confirm']) && !empty($confirm) &&$response_body['confirm'] != $confirm) {
                $this->update_key(array("key" => $key, "confirm" => sanitize_text_field($response_body['confirm'])));
            }

            return $response_body;
        } catch (Exception $ex) {
            throw new spbhlprproException(__("Something went wrong while checking for updates.", "superbhelperpro"), "6505");
        }
    }

    public function get_data($refresh = false, $cron = false)
    {
        try {
            if ($refresh == "refresh") {
                return $this->get_key_info();
            }

            $serialized = $this->get_serialized();

            // If no data available
            if (!$serialized) {
                return $this->get_key_info(false, $cron);
            }

            $updated = $serialized['spbhlprpro_ser_date'];
            // Should we refresh? Check date if we're not ignoring refresh
            if ($refresh != "ignore_refresh") {
                // If data is more than 24 hours old -> Get new data
                $timelimit = strtotime("-24 hours");
                if (strtotime($updated) < $timelimit) {
                    return $this->get_key_info(false, $cron);
                }
            }

            // Return data
            $data = $this->unserialize($serialized['spbhlprpro_ser']);
            $data['date'] = $updated;

            return $data;
        } catch (spbhlprproException $spbex) {
            return array(
                "error" => true,
                "message" => $spbex->getMessage()." (error code #".$spbex->getCode().")."
            );
        } catch (Exception $ex) {
            return array(
                "error" => true,
                "message" => "Something went wrong while gathering product and update data. (error code #".$ex->getCode().")."
            );
        }
    }

    private function get_serialized()
    {
        $query = "SELECT * FROM $this->table_data";
        $results = $this->db->get_results($query, ARRAY_A);
        if ($results && count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    private function save_serialized($data)
    {
        try {
            $serialized = $this->serialize(array(
            "version" => !isset($data['version']) ? false : $data['version'],
            "message" => $data['message'],
            "products" => !isset($data['products']) ? array() : $data['products']
        ));

            $exists = $this->get_serialized();
            if (!$exists) {
                $result = $this->db->insert($this->table_data, array('spbhlprpro_ser' => $serialized,'spbhlprpro_ser_date' => date("Y-m-d H:i:s")));
                if ($this->db->last_error != '' || !$result) {
                    throw new Exception("Couldn't save information.");
                }
            } else {
                $result = $this->db->update($this->table_data, array('spbhlprpro_ser' => $serialized,'spbhlprpro_ser_date' => date("Y-m-d H:i:s")), array("id" => $exists['id']));
                if ($this->db->last_error != '' || !$result) {
                    throw new Exception("Couldn't save information.");
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    private function set_time()
    {
        try {
            $has_time = $this->get_time();
            if ($has_time!==false) {
                return false;
            }
            $result = $this->db->insert($this->table_stamp, array('spbhlprpro_stamp' => time()));
            if ($this->db->last_error != '' || !$result) {
                throw new Exception();
            }
       
            return $this->db->insert_id;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function reset_time()
    {
        $result = $this->db->query("DELETE FROM $this->table_stamp");
        if ($this->db->last_error != '' || !$result) {
            return false;
        }
        $this->set_time();
    }

    public function get_time()
    {
        $query = "SELECT * FROM $this->table_stamp";
        $results = $this->db->get_results($query, ARRAY_A);
        if ($results && count($results) > 0) {
            return $results[0]['spbhlprpro_stamp'];
        }

        return false;
    }

    public function get_settings()
    {
        $query = "SELECT * FROM $this->table_settings";
        $results = $this->db->get_results($query, ARRAY_A);
        if ($results && count($results) > 0) {
            return array(
                "companions" => is_null($results[0]['spbhlprpro_companions']) ? true : ($results[0]['spbhlprpro_companions'] === "1" ? true : false),
                "recommended" => is_null($results[0]['spbhlprpro_recommended']) ? true : ($results[0]['spbhlprpro_recommended'] === "1" ? true : false)
            );
        }

        return array(
            "companions" => true,
            "recommended" => true
        );
    }


    public function save_settings($data)
    {
        $reset = $this->db->query("DELETE FROM $this->table_settings");
        if ($this->db->last_error != '') {
            return false;
        }
        try {
            $result = $this->db->insert($this->table_settings, array('spbhlprpro_companions' => $data['companions'], 'spbhlprpro_recommended' => $data['recommended']));
            if ($this->db->last_error != '' || !$result) {
                throw new Exception();
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }


    private function serialize($item)
    {
        return base64_encode(serialize($item));
    }

    private function unserialize($item)
    {
        $u_item = unserialize(base64_decode($item));
        //$rit = new RecursiveIteratorIterator(new RecursiveArrayIterator($u_item));
        //$toreturn = iterator_to_array($rit, false);
        return $u_item;
    }
}
