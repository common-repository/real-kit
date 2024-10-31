<?php

// В админке
if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/tags/settings.php';

	if (get_option('realkit_tags_toggle') != 'off') {

		// Получает все теги (кроме кастомного типа тегов)
		add_action('wp_ajax_realkit_ajax_get_all_tags', function() {

			$arg = array_merge([
				'taxonomy' => '',
			], $_POST);

			if (empty($arg['taxonomy'])) return;

			$taxonomy_object = get_taxonomy($arg['taxonomy']);

			if (!$taxonomy_object) wp_die(0);
			if (!current_user_can($taxonomy_object->cap->assign_terms)) wp_die(-1);

			$results = get_terms([
				'taxonomy'   => $arg['taxonomy'],
				'fields'     => 'names',
				'hide_empty' => FALSE,
			]);

			$results = apply_filters('ajax_term_search_results', $results, $taxonomy_object, $search);

			realkit_die_json($results);

		});

		// Подключить CSS/JS
		add_action('admin_enqueue_scripts', function() {
			wp_enqueue_style('realkit_tags', REALKIT_PLUGIN_URL_MOD . '/tags/css/admin.css');
			wp_enqueue_script('realkit_tags', REALKIT_PLUGIN_URL_MOD . '/tags/js/admin.js', array('jquery'));
		});

	}

}