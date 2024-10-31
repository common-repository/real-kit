<?php

add_action('admin_init', function(){

	$mod = 'dashboard';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Dashboard', 'realkit'),
		// 'desc'  => __('', 'realkit'),
		'order' => 10,
		'class' => ''
	]);

	// Выключатель
	realkit_settings($mod, [
		'name'  => 'realkit_dashboard_info_toggle',
		'value' => (get_option('realkit_dashboard_info_toggle') != 'off') ? 'on' : 'off',
		'title' => __('Use the extended widget "At a Glance"', 'realkit'),
		'type'  => 'checkbox',
	]);

});