<?php

add_action('admin_init', function(){

	$mod = 'metrics';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Metrics', 'realkit'),
		'desc'  => '',
		'order' => 10,
		'class' => ''
	]);

	// Для head
	realkit_settings($mod, [
		'name'  => 'realkit_metrics_head',
		'value' => get_option('realkit_metrics_head'),
		'desc'  => sprintf(__('Code to insert inside the %s tag', 'realkit'), htmlspecialchars('<head>')),
		'type'  => 'textarea',
	]);

	// Для body
	realkit_settings($mod, [
		'name'  => 'realkit_metrics_body',
		'value' => get_option('realkit_metrics_body'),
		'desc'  => sprintf(__('Code to insert before the closing %s tag', 'realkit'), htmlspecialchars('</body>')),
		'type'  => 'textarea',
	]);

});