<?php

if (!defined('WP_UNINSTALL_PLUGIN')) exit;

global $wpdb;

// Удалить все опции плагина
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'realkit_%'");

// Удалить все мета данные записей плагина
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE 'realkit_%'");

// Удалить все мета данные таксономий плагина
$wpdb->query("DELETE FROM {$wpdb->termmeta} WHERE meta_key LIKE 'realkit_%'");

// Удалить все модальные окна
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'realkit_modal'");