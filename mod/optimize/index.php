<?php

require_once REALKIT_PLUGIN_DIR_MOD . '/optimize/actions.php';

// Задать кол-во ревизий
if (is_numeric(get_option('realkit_optimize_revisions_number'))) {
	add_filter('wp_revisions_to_keep', function($num, $post) {
		return get_option('realkit_optimize_revisions_number');
	}, 10, 2);
}

// Отключить проверку обновлений при открытии любых страниц админки кроме страницы обновлений
if (get_option('realkit_optimize_search_update') == 'on') {
	remove_action('admin_init', '_maybe_update_core');
	remove_action('admin_init', '_maybe_update_themes');
	remove_action('admin_init', '_maybe_update_plugins');
	remove_action('load-plugins.php', 'wp_update_plugins');
	remove_action('load-themes.php', 'wp_update_themes');
}

// Отключить скрипты и стили для эмодзи
if (get_option('realkit_optimize_emojis') == 'on') {
	add_action('init', function() {
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		add_filter('tiny_mce_plugins', function($plugins) {
			return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : $plugins;
		});
	});
}

if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/optimize/settings.php';

	// Подключить CSS
	add_action('current_screen', function() {
		if (get_current_screen()->id == REALKIT_PLUGIN_SCREEN_S) {
			add_action('admin_enqueue_scripts', function() {
				wp_enqueue_style('realkit_optimize', REALKIT_PLUGIN_URL_MOD . '/optimize/css/settings.css');
			});
		}
	});

}