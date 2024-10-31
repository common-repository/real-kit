<?php

add_action('admin_init', function(){

	$mod = 'tags';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Tags', 'realkit'),
		// 'desc'  => __('', 'realkit'),
		'order' => 10,
		'class' => ''
	]);

	// Выключатель
	realkit_settings($mod, [
		'name'  => 'realkit_tags_toggle',
		'value' => (get_option('realkit_tags_toggle') != 'off') ? 'on' : 'off',
		'title' => __('Use quick adding tags', 'realkit'),
		'type'  => 'checkbox',
	]);

});