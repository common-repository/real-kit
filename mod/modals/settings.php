<?php

add_action('admin_init', function(){

	$mod = 'modals';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Modal windows', 'realkit'),
		// 'desc'  => __('', 'realkit'),
		'order' => 10,
		'class' => ''
	]);

	// Выключатель
	realkit_settings($mod, [
		'name'  => 'realkit_modals_toggle',
		'value' => (get_option('realkit_modals_toggle') != 'off') ? 'on' : 'off',
		'title' => __('Use modal windows', 'realkit'),
		'type'  => 'checkbox',
	]);

});