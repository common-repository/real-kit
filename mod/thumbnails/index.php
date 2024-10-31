<?php

require_once REALKIT_PLUGIN_DIR_MOD . '/thumbnails/class.php';
require_once REALKIT_PLUGIN_DIR_MOD . '/thumbnails/functions.php';
require_once REALKIT_PLUGIN_DIR_MOD . '/thumbnails/settings.php';

if (is_admin()) {

	// Разрешить миниатюры поста
	if (!current_theme_supports('post-thumbnails')) {
		add_theme_support('post-thumbnails');
	}

	// Записи
	add_action('registered_post_type', function($post_type, $post_type_object) {

		if (!post_type_supports($post_type, 'thumbnail')) return;

		$option_name  = 'realkit_thumbnails_toggle_' . $post_type;
		$option_value = get_option($option_name);
		$default_on   = ['post', 'page'];

		if (!$option_value) {
			$option_value = in_array($post_type, $default_on) ? 'on' : 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			$class = 'Realkit_thumbnails';

			// Создать колонку
			add_action('manage_' . $post_type . '_posts_columns', [$class, 'add_column']);

			// Сделать колонку сортируемой
			add_filter('manage_edit-' . $post_type . '_sortable_columns', [$class, 'add_column']);

			// Вставить ID в колонку
			add_action('manage_' . $post_type . '_posts_custom_column', [$class, 'post_echo_value'], 10, 2);

		}

		// Запомнить тип для страницы настроек
		Realkit_thumbnails::add_toggle($option_name, $option_value, $post_type_object->label);

	}, 10, 2);

	// Таксономий
	add_action('registered_taxonomy', function($taxonomy, $object_type, $args) {

		if (in_array($taxonomy, Realkit_thumbnails::$exclude)) return;

		$option_name  = 'realkit_thumbnails_toggle_' . $taxonomy;
		$option_value = get_option($option_name);
		$default_on   = ['category', 'post_tag'];

		if (!$option_value) {
			$option_value = in_array($taxonomy, $default_on) ? 'on' : 'off';
		}

		// Если разрешено
		if ($option_value == 'on') {

			$class = 'Realkit_thumbnails';

			// Создать колонку
			add_action('manage_edit-' . $taxonomy . '_columns', [$class, 'add_column']);

			// Сделать колонку сортируемой
			add_filter('manage_edit-' . $taxonomy . '_sortable_columns', [$class, 'add_column']);

			// Вставить картинку в колонку
			add_filter('manage_' . $taxonomy . '_custom_column', [$class, 'term_get_value'], 10, 3);

			// Добавить поле на странице добавления
			add_action($taxonomy . '_add_form_fields', [$class, 'field_add']);

			// Добавить поле на странице редактирования
			add_action($taxonomy . '_edit_form_fields', [$class, 'field_edit'], 10, 2);

			// Добавить поле в форму быстрого редактирования (только для таксономий)
			add_action('quick_edit_custom_box', [$class, 'field_quick'], 10, 3);

			// Сохранить при добавлении таксономии
			add_action('create_' . $taxonomy, [$class, 'save'], 10, 2);

			// Сохранить при редактировании таксономии
			add_action('edited_' . $taxonomy, [$class, 'save'], 10, 2);

		}

		// Запомнить тип для страницы настроек
		Realkit_thumbnails::add_toggle($option_name, $option_value, $args['label']);

	}, 10, 3);

	// Подключить CSS/JS
	add_action('admin_enqueue_scripts', function() {

		wp_enqueue_style('realkit_thumbnails', REALKIT_PLUGIN_URL_MOD . '/thumbnails/css/admin.css');

		// Для таксономий
		wp_enqueue_script('realkit_thumbnails', REALKIT_PLUGIN_URL_MOD . '/thumbnails/js/admin.js', array('jquery'));

	});

}