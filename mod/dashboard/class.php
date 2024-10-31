<?php

class Realkit_dashboard {

	// Формирует виджет с информацией о сайте
	public static function build_info() {

		// Текущая версия PHP
		$data[] = [
			'title' => __('PHP version', 'realkit'),
			'value' => phpversion()
		];

		// Текущая версия WP
		if (current_user_can('update_core')) {
			$data[] = [
				'title' => __('WordPress version', 'realkit'),
				'value' => get_bloginfo('version'),
				'href'  => 'update-core.php'
			];
		}

		// Активная тема
		if (current_user_can('switch_themes')) {
			$data[] = [
				'title' => __('Theme', 'realkit'),
				'value' => wp_get_theme()->title,
				'href'  => 'themes.php'
			];
		}

		// Индексация
		if (current_user_can('manage_options')) {
			$data[] = [
				'title' => __('Indexing', 'realkit'),
				'value' => get_option('blog_public') ? __('On', 'realkit') : __('Off', 'realkit'),
				'href'  => 'options-reading.php'
			];
		}

		// ? Версия активной темы

		// Разделитель
		$data[] = [];

		// Пользователи
		if (current_user_can('list_users')) {
			$data[] = [
				'title' => __('Users', 'realkit'),
				'value' => count_users()['total_users'],
				'href'  => 'users.php'
			];
		}

		// ? Все плагины

		// Активные плагины
		if (current_user_can('activate_plugins')) {
			$data[] = [
				'title' => __('Plugins', 'realkit'),
				'value' => self::get_count_active_plugins(),
				'href'  => 'plugins.php'
			];
		}


		if (current_user_can('edit_theme_options')) {

			// ? Области виджетов

			// Активные виджеты
			$data[] = [
				'title' => __('Widgets', 'realkit'),
				'value' => self::get_count_active_widgets(),
				'href'  => 'widgets.php'
			];

			// ? Области меню

			// Активные меню
			$data[] = [
				'title' => __('Menus', 'realkit'),
				'value' => self::get_count_active_menus(),
				'href'  => 'nav-menus.php'
			];

		}

		// Разделитель
		$data[] = [];

		// Записи
		foreach (get_post_types(['public' => TRUE], 'objects') as $type) {

			if (!current_user_can($type->cap->edit_posts)) continue;
			if ($type->name == 'attachment') continue;

			$data[] = [
				'title' => $type->label,
				'value' => self::get_count_posts($type->name),
				'href'  => ($type->name == 'attachment') ? 'upload.php' : 'edit.php?post_type=' . $type->name
			];

		}

		// Разделитель
		$data[] = [];

		// Таксономии
		foreach (get_taxonomies(['show_ui' => TRUE], 'objects') as $taxonomy) {
			if (current_user_can($taxonomy->cap->manage_terms)) {
				$data[] = array(
					'title' => $taxonomy->label,
					'value' => wp_count_terms($taxonomy->name),
					'href'  => 'edit-tags.php?taxonomy=' . $taxonomy->name,
				);
			}
		}

		// Разделитель
		$data[] = [];

		// Комментарии
		if (current_user_can('moderate_comments')) {
			$data[] = [
				'title' => __('Comments', 'realkit'),
				'value' => self::get_count_comments(),
				'href'  => 'edit-comments.php',
			];
		}

		// Медиафайлы
		$type = get_post_types(['name' => 'attachment'], 'objects')['attachment'];
		if (current_user_can($type->cap->edit_posts)) {
			$data[] = [
				'title' => $type->label,
				'value' => self::get_count_posts($type->name),
				'href'  => ($type->name == 'attachment') ? 'upload.php' : 'edit.php?post_type=' . $type->name
			];
		}

		require REALKIT_PLUGIN_DIR_MOD . '/dashboard/tpl/grid.php';

	}

	// Считает кол-во активных плагинов
	public static function get_count_active_plugins() {

		$count = 0;

		foreach (get_plugins() as $file => $data) {
			if (is_plugin_active($file)) {
				$count++;
			}
		}

		return $count;

	}

	// Считает кол-во активных плагинов
	public static function get_count_active_widgets() {

		global $wp_registered_sidebars;

		if (empty($wp_registered_sidebars)) {
			return __('No sidebars', 'realkit');
		}

		$count = 0;

		foreach (wp_get_sidebars_widgets() as $key => $value) {
			if ($key == 'wp_inactive_widgets') continue;
			if (is_array($value)) $count += count($value);
		}

		return $count;

	}

	// Считает кол-во активных меню
	public static function get_count_active_menus() {

		$count = 0;

		foreach (get_registered_nav_menus() as $slug => $desc) {
			if (has_nav_menu($slug)) $count++;
		}

		return $count;

	}

	// Считает кол-во записей
	public static function get_count_posts($type = 'post') {

		$count = wp_count_posts($type);

		return ($type == 'attachment') ? $count->inherit : $count->publish;

	}

	// Считает кол-во коментариев
	public static function get_count_comments($status = 'approved') {

		$count = wp_count_comments($status);

		return isset($count->$status) ? $count->$status : $count->approved;

	}

}