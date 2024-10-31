<?php

if (is_admin()) {

	// Создать страницу настроек
	add_action('admin_menu', function() {
		add_options_page(
			__('real.Kit', 'realkit'),			// Тег title
			__('real.Kit', 'realkit'),			// Название пункта меню
			'manage_options',								// Права доступа
			REALKIT_PLUGIN_SETTINGS,				// Уникальные идентификатор
			function() {										// Контент
				require_once REALKIT_PLUGIN_DIR . '/tpl/settings.php';
			}
		);
	});

	// Подключить JS/CSS
	add_action('current_screen', function(){
		if (get_current_screen()->id == REALKIT_PLUGIN_SCREEN_S) {
			wp_enqueue_style('realkit_settings', REALKIT_PLUGIN_URL . '/css/settings.css');
			wp_enqueue_script('realkit_settings', REALKIT_PLUGIN_URL . '/js/settings.js', ['jquery']);
		}
	});

}