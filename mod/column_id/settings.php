<?php

add_action('admin_init', function(){

	$mod = 'id';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('ID', 'realkit'),
		'desc'  => __('Will be shown on the marked pages of the admin panel', 'realkit'),
		'order' => 10,
		'class' => 'row'
	]);

	// Выключатели
	foreach (Realkit_columnId::$toggles as $item) {
		realkit_settings($mod, [
			'name'  => $item['name'],
			'value' => $item['value'],
			'title' => $item['title'],
			'type'  => 'checkbox',
		]);
	}

});