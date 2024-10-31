<?php
/*
Plugin Name: real.Kit
Version:     5.1.1
Author:      realMaster
Text Domain: realkit
Domain Path: /lng/
Description: Main features: translit, ID column, thumbnails for categories and tags, simple modal windows, a plug at the time of development of the site, an extended widget "At a Glance", different options to optimize the site.
*/

// Версия PHP должна быть минимум 5.6
if (version_compare(PHP_VERSION, '5.6.0', '<')) {
	if (is_admin()) {
		add_action('admin_notices', function() {
			echo '<div class="realkit_notice notice notice-error">
				<p><b>real.Kit</b></p>
				<p>' . __('Requires PHP 5.6 or higher', 'realkit') . '</p>
				<p>' . sprintf(__('Current version: %s', 'realkit'), PHP_VERSION) . '</p>
			</div>';
		}, 10, 1);
	}
}
else {

	$plugin_dir_path = str_replace('\\', '/', plugin_dir_path(__FILE__));
	$plugin_dir_url  = plugin_dir_url(__FILE__);

	define('REALKIT_PLUGIN_VER',      '5.0.0');
	define('REALKIT_PLUGIN_FILE',     'real-kit.php');
	define('REALKIT_PLUGIN_SETTINGS', 'realkit_settings');
	define('REALKIT_PLUGIN_SCREEN_S', 'settings_page_' . REALKIT_PLUGIN_SETTINGS);
	define('REALKIT_PLUGIN_FOLDER',   dirname(plugin_basename(__FILE__)));
	define('REALKIT_PLUGIN_DIR',      $plugin_dir_path);
	define('REALKIT_PLUGIN_DIR_MOD',  $plugin_dir_path . 'mod');
	define('REALKIT_PLUGIN_URL',      $plugin_dir_url);
	define('REALKIT_PLUGIN_URL_MOD',  $plugin_dir_url . 'mod');

	// Добавить ссылку на страницу настроек (на странице списка плагинов)
	add_filter('plugin_action_links', function($actions, $plugin_file, $plugin_data, $context) {
		if (strpos($plugin_file, REALKIT_PLUGIN_FILE)) {
			$actions['settings'] = '<a href="/wp-admin/options-general.php?page=' . REALKIT_PLUGIN_SETTINGS . '.php">' . __('Settings', 'realkit') . '</a>';
		}
		return $actions;
	}, 10, 4);

	// Локализация
	add_action('plugins_loaded', function() {
		if (!defined('REALKIT_LOAD_LOCALE')) {
			load_plugin_textdomain('realkit', FALSE, REALKIT_PLUGIN_FOLDER . '/lng/');
			define('REALKIT_LOAD_LOCALE', TRUE);
		}
	});

	// Вспомагательные функции
	require_once REALKIT_PLUGIN_DIR . '/functions.php';

	// Оптимизация
	require_once REALKIT_PLUGIN_DIR_MOD . '/optimize/index.php';

	// ID
	require_once REALKIT_PLUGIN_DIR_MOD . '/column_id/index.php';

	// Рубрики
	require_once REALKIT_PLUGIN_DIR_MOD . '/categories/index.php';

	// Миниатюры
	require_once REALKIT_PLUGIN_DIR_MOD . '/thumbnails/index.php';

	// Метки (теги)
	require_once REALKIT_PLUGIN_DIR_MOD . '/tags/index.php';

	// Dashboard
	require_once REALKIT_PLUGIN_DIR_MOD . '/dashboard/index.php';

	// Модальные окна
	require_once REALKIT_PLUGIN_DIR_MOD . '/modals/index.php';

	// Транслитерация
	require_once REALKIT_PLUGIN_DIR_MOD . '/translit/index.php';

	// Метрики
	require_once REALKIT_PLUGIN_DIR_MOD . '/metrics/index.php';

	// Режим разработки
	require_once REALKIT_PLUGIN_DIR_MOD . '/maintenance/index.php';

	// Страница настроек плагина
	require_once REALKIT_PLUGIN_DIR . 'settings.php';

	/*
	*******************************************************************************/

	// Опция благодаря которой в дальньейшем я смогу различать обновление от новой установки
	update_option('realkit_plugin_version', REALKIT_PLUGIN_VER);

}

/*
*******************************************************************************/

// Сброс всех опций плагина
/*global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'realkit_%'");*/

/*
*******************************************************************************/