<?php
/**
 * @package movieManager
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
die;
}

// Delete all movie posts
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'movie'");

// Delete postmeta data
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id NOT IN (SELECT ID FROM {$wpdb->posts})");
