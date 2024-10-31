<?php

if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/dashboard/class.php';
	require_once REALKIT_PLUGIN_DIR_MOD . '/dashboard/settings.php';

	// Виджет "На виду"
	if (get_option('realkit_dashboard_info_toggle') != 'off') {

		add_action('wp_dashboard_setup', function() {

			if (!current_user_can('edit_posts')) return;

			global $wp_meta_boxes;

			// Удалить существующий виджет
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);

			$widget_name = 'realkit_dashboard_info';

			// Создать новый виджет
			wp_add_dashboard_widget($widget_name, __('At a Glance', 'realkit'), ['Realkit_dashboard', 'build_info']);

			// Переместить новый виджет в начало
			$core = $wp_meta_boxes['dashboard']['normal']['core'];
			$temp = [$widget_name => $core[$widget_name]];
			unset($core[$widget_name]);
			$wp_meta_boxes['dashboard']['normal']['core'] = array_merge($temp, $core);

		});

		// Подключить JS/CSS
		add_action('current_screen', function(){
			if (get_current_screen()->id == 'dashboard') {
				wp_enqueue_style('realkit_settings', REALKIT_PLUGIN_URL_MOD . '/dashboard/css/dashboard.css');
			}
		});

	}

}