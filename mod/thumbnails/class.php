<?php

class Realkit_thumbnails {

	static $toggles;
	static $exclude;

	function __construct() {
		self::$toggles = [];
		self::$exclude = ['wp_theme', 'nav_menu', 'link_category', 'post_format', 'wp_template_part_area'];
	}

	// Добавляет опцию в общий массив
	public static function add_toggle($k = NULL, $v = NULL, $t = NULL) {

		if (is_null($k)) return;

		self::$toggles[] = [
			'name'  => $k,
			'value' => $v,
			'title' => $t
		];

	}

	// Добавляет колонку (без заголовка)
	public static function add_column($columns) {

		// После колонки ID (если она есть)
		if (isset($columns['realkit_column_id'])) {
			foreach ($columns as $k => $v) {
				$arr[$k] = $v;
				if ($k == 'realkit_column_id') {
					$arr['realkit_column_thumbnail'] = '';
				}
			}
			$columns = $arr;
		}

		// Иначе - после чекбокса
		else {
			$columns = array_slice($columns, 0, 1, TRUE)
							 + array('realkit_column_thumbnail' => '')
							 + $columns;
		}

		return $columns;

	}

	// Выводит ID в колонку (для записей)
	public static function post_echo_value($a, $b) {
		if ($a == 'realkit_column_thumbnail') {
			$src = get_the_post_thumbnail_url($b, 'thumbnail');
			if (!empty($src)) {
				echo '<img src="' . $src . '" alt="">';
			}
		}
	}

	// Возвращает ID в колонку (для таксономий)
	public static function term_get_value($a, $b, $c) {
		if ($b == 'realkit_column_thumbnail') {
			$id  = get_term_meta($c, 'realkit_thumbnail_id', TRUE);
			$url = wp_get_attachment_url($id);
			$src = self::get_term_thumbnail($c, 'thumbnail');
			if (!empty($src)) {
				$a = '<img src="' . $src . '" alt="" thumbnail-id="' . $id . '" thumbnail-url="' . $url . '">';
			}
		}
		return $a;
	}

	// Добавляет поле на страницу добавления
	public static function field_add() {

		// Функционал для работы с галереей
		wp_enqueue_media();

		require REALKIT_PLUGIN_DIR_MOD . '/thumbnails/tpl/field_add.php';

	}

	// Добавляет поле на страницу редактирования
	public static function field_edit($tag, $taxonomy) {

		// Функционал для работы с галереей
		wp_enqueue_media();

		$thumbnail_id  = get_term_meta($tag->term_id, 'realkit_thumbnail_id', TRUE);
		$thumbnail_url = self::get_term_thumbnail($tag->term_id, NULL);

		require REALKIT_PLUGIN_DIR_MOD . '/thumbnails/tpl/field_edit.php';

	}

	// Добавляет поле в форму быстрого редактирования (только для таксономий)
	public static function field_quick($column_name, $id, $taxonomy) {
		if ($id == 'edit-tags' and $column_name == 'realkit_column_thumbnail') {

			$thumbnail_id  = get_term_meta($id, 'realkit_thumbnail_id', TRUE);
			$thumbnail_url = self::get_term_thumbnail($id, NULL);

			require REALKIT_PLUGIN_DIR_MOD . '/thumbnails/tpl/field_quick.php';

		}
	}

	// Сохраняет миниатюру
	public static function save($term_id, $tt_id) {

		$name = 'realkit_thumbnail_id';

		if (!isset($_POST[$name])) return;

		$can_add   = isset($_POST['_wpnonce_add-tag'])
							 ? wp_verify_nonce($_POST['_wpnonce_add-tag'], 'add-tag')
							 : FALSE;
		$can_edit  = isset($_POST['_wpnonce'])
							 ? wp_verify_nonce($_POST['_wpnonce'], 'update-tag_' . $term_id)
							 : FALSE;
		$can_quick = isset($_POST['_inline_edit'])
							? wp_verify_nonce($_POST['_inline_edit'], 'taxinlineeditnonce')
							: FALSE;

		if (!$can_add && !$can_edit && !$can_quick) return;

		$val = intval($_POST[$name]);

		if (!$val) {
			delete_term_meta($term_id, $name);
		}
		else {
			update_term_meta($term_id, $name, $val);
		}

		return $term_id;

	}

	// Получает URL миниатюры таксономии
	public static function get_term_thumbnail($term_id = NULL, $size = NULL) {

		// Определить ID текущей таксономии (для сайта)
		if (!$term_id) {
			if (is_category())
				$term_id = get_query_var('cat');
			elseif (is_tax()) {
				$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
				$term_id = $current_term->term_id;
			}
		}

		// Получить ID
		$thumb_id = get_term_meta($term_id, 'realkit_thumbnail_id', TRUE);

		// Получить URL
		$thumb_url = is_null($size)
							 ? wp_get_attachment_url($thumb_id)
							 : image_get_intermediate_size($thumb_id, $size);

		return is_array($thumb_url) ? $thumb_url['url'] : $thumb_url;

	}

}

new Realkit_thumbnails();