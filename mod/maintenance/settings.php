<?php

add_action('admin_init', function(){

	$mod = 'maintenance';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Maintenance mode', 'realkit'),
		'desc'  => '',
		'order' => 10,
		'class' => ''
	]);

	// Выключатель
	realkit_settings($mod, [
		'name'  => 'realkit_maintenance_toggle',
		'value' => (get_option('realkit_maintenance_toggle') == 'on') ? 'on' : 'off',
		'title' => 'Включить',
		'desc'  => __('Any site visitor, except for the authorized administrator, will see the plug', 'realkit'),
		'type'  => 'checkbox',
	]);

	// HTML
	realkit_settings($mod, [
		'name'     => 'realkit_maintenance_html',
		'value'    => Realkit_maintenance::get_html(),
		'title'    => '',
		'type'     => 'textarea',
		'disabled' => (get_option('realkit_maintenance_toggle') != 'on'),
	]);

});

// Подключить JS
if (is_admin()) {
	add_action('current_screen', function() {
		if (get_current_screen()->id == REALKIT_PLUGIN_SCREEN_S) {
			add_action('admin_enqueue_scripts', function() {
				wp_enqueue_script('realkit_maintenance', REALKIT_PLUGIN_URL_MOD . '/maintenance/js/settings.js', ['jquery']);
			});
		}
	});
}