<?php

if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/column_id/class.php';
	require_once REALKIT_PLUGIN_DIR_MOD . '/column_id/settings.php';

	// Записи
	add_action('registered_post_type', function($post_type, $post_type_object) {

		if (in_array($post_type, Realkit_columnId::$exclude)) return;

		$option_name  = 'realkit_column_id_toggle_' . $post_type;
		$option_value = get_option($option_name);
		$default_on   = ['post', 'page'];

		if (!$option_value) {
			$option_value = in_array($post_type, $default_on) ? 'on' : 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			// Создать колонку
			add_action('manage_' . $post_type . '_posts_columns', ['Realkit_columnId', 'add_column']);

			// Сделать колонку сортируемой
			add_filter('manage_edit-' . $post_type . '_sortable_columns', ['Realkit_columnId', 'add_column']);

			// Вставить ID в колонку
			add_action('manage_' . $post_type . '_posts_custom_column', ['Realkit_columnId', 'echo_value'], 10, 2);

		}

		// Запомнить тип для страницы настроек
		Realkit_columnId::add_toggle($option_name, $option_value, $post_type_object->label);

	}, 10, 2);

	// Таксономий
	add_action('registered_taxonomy', function($taxonomy, $object_type, $args) {

		if (in_array($taxonomy, Realkit_columnId::$exclude)) return;

		$option_name  = 'realkit_column_id_toggle_' . $taxonomy;
		$option_value = get_option($option_name);
		$default_on   = ['category'];

		if (!$option_value) {
			$option_value = in_array($taxonomy, $default_on) ? 'on' : 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			// Создать колонку
			add_action('manage_edit-' . $taxonomy . '_columns', ['Realkit_columnId', 'add_column']);

			// Сделать колонку сортируемой
			add_filter('manage_edit-' . $taxonomy . '_sortable_columns', ['Realkit_columnId', 'add_column']);

			// Вставить ID в колонку
			add_filter('manage_' . $taxonomy . '_custom_column', ['Realkit_columnId', 'get_value'], 10, 3);

		}

		// Запомнить тип для страницы настроек
		Realkit_columnId::add_toggle($option_name, $option_value, $args['label']);

	}, 10, 3);

	// Медиа
	add_action('wp_loaded', function() {

		$option_name  = 'realkit_column_id_toggle_uploads';
		$option_value = get_option($option_name);

		if (!$option_value) {
			$option_value = 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			// Создать колонку (сортируемую)
			add_filter('manage_media_columns', ['Realkit_columnId', 'add_column_uploads']);

			// Вставить ID в колонку
			add_action('manage_media_custom_column', ['Realkit_columnId', 'echo_value'], 10, 2);

		}

		// Запомнить тип для страницы настроек
		Realkit_columnId::add_toggle($option_name, $option_value, __('Media', 'realkit'));

	});

	// Пользователи
	add_action('wp_loaded', function() {

		$option_name  = 'realkit_column_id_toggle_users';
		$option_value = get_option($option_name);

		if (!$option_value) {
			$option_value = 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			// Создать колонку
			add_action('manage_users_columns', ['Realkit_columnId', 'add_column']);

			// Сделать колонку сортируемой
			add_filter('manage_users_sortable_columns', ['Realkit_columnId', 'add_column']);

			// Вставить ID в колонку
			add_filter('manage_users_custom_column', ['Realkit_columnId', 'get_value'], 10, 3);

		}

		// Запомнить тип для страницы настроек
		Realkit_columnId::add_toggle($option_name, $option_value, __('Users', 'realkit'));

	});

	// Комментарии
	add_action('wp_loaded', function() {

		$option_name  = 'realkit_column_id_toggle_comments';
		$option_value = get_option($option_name);

		if (!$option_value) {
			$option_value = 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			// Создать колонку
			add_action('manage_edit-comments_columns', ['Realkit_columnId', 'add_column']);

			// Сделать колонку сортируемой
			add_filter('manage_edit-comments_sortable_columns', ['Realkit_columnId', 'add_column']);

			// Вставить ID в колонку
			add_action('manage_comments_custom_column', ['Realkit_columnId', 'echo_value'], 10, 2);

		}

		// Запомнить тип для страницы настроек
		Realkit_columnId::add_toggle($option_name, $option_value, __('Comments', 'realkit'));

	});

	// Подключить CSS/JS
	add_action('admin_enqueue_scripts', function() {
		wp_enqueue_style('realkit_column_id', REALKIT_PLUGIN_URL_MOD . '/column_id/css/admin.css');
	});

}