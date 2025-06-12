<?php
/*
Plugin Name: Divi Form Submissions
Description: Logs and displays submissions from Divi Contact Forms.
Version: 1.0
Author: Chetan Harvara
Author URI: https://chetanharvara.netlify.app
*/

if (!defined('ABSPATH')) exit;

define('DFS_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once DFS_PLUGIN_DIR . 'includes/logger.php';
require_once DFS_PLUGIN_DIR . 'admin/view-submissions.php';

register_activation_hook(__FILE__, 'dfs_create_table');
function dfs_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'divi_form_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        form_id VARCHAR(255),
        submission LONGTEXT,
        status VARCHAR(20) DEFAULT 'Success',
        submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
}
