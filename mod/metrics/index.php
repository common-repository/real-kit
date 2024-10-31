<?php

if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/metrics/settings.php';

}

else {

	add_action('wp_head', function() {
		echo get_option('realkit_metrics_head');
	});

	add_action('wp_footer', function() {
		echo get_option('realkit_metrics_body');
	});

}