<?php

class Realkit_columnId {

	static $toggles;
	static $exclude;

	function __construct() {
		self::$toggles = [];
		self::$exclude = ['revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'attachment', 'wp_theme', 'nav_menu', 'link_category', 'post_format', 'wp_template_part_area', 'wp_template', 'wp_template_part', 'wp_global_styles', 'wp_navigation', 'wp_block'];
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

	// Добавляет колонку
	public static function add_column($columns) {

		$columns = array_slice($columns, 0, 1, TRUE)
						 + ['realkit_column_id' => 'ID']
						 + $columns;

		return $columns;

	}

	// Добавляет колонку с сылкой на сортировку (для медиафайлов)
	public static function add_column_uploads($columns) {

		// В классе не предусмотрены хуки для добавления колонок сортировки
		// поэтому пришлось сделать функционал вручную

		$qstr = $_SERVER['QUERY_STRING'];
		$args = explode('&', $qstr);

		foreach ($args as $arg) {
			$arg = explode('=', $arg);
			if ($arg[0] != 'orderby' and $arg[0] != 'order' and isset($arg[1])) {
				$arr[$arg[0]] = $arg[1];
				foreach ($arr as $k => $v) {
					$href[] = $k . '=' . $v;
				}
			}
		}

		$order = 'ASC';
		if ((isset($_GET['orderby']) and $_GET['orderby'] == 'ID') and
				(isset($_GET['order'])   and $_GET['order']   == 'ASC')) {
			$order = 'DESC';
		}

		$href = (isset($href)) ? implode('&amp;', $href) . '&amp;' : '';
		$href = '?' . $href . 'orderby=ID&amp;order=' . $order;

		$columns = array_slice($columns, 0, 1, TRUE)
						 + ['realkit_column_id' => '<a href=' . $href . ' class="realkit_column_id-sortable ' . strtolower($order) . '"><span>ID</span></a>']
						 + array_slice($columns, 1, NULL, TRUE);

		return $columns;

	}

	// Выводит ID в колонку
	public static function echo_value($a, $b) {
		if ($a == 'realkit_column_id') {
			echo $b;
		}
	}

	// Возвращает ID в колонку
	public static function get_value($a, $b, $c = NULL) {
		if ($b == 'realkit_column_id') {
			$a = is_null($c) ? $b : $c;
		}
		return $a;
	}

}

new Realkit_columnId();