<?php

// Вспомагательная функция, чтоб Не использовать глобальные переменные
function realkit_admin_notice_var($name, $val = FALSE) {

	static $arr;

	if ($val) {
		$arr[$name] = $val;
	}

	return isset($arr[$name]) ? $arr[$name] : FALSE;

}

// Выводит уведомление в админке
// На одной странице можно использовать только 1 раз (иначе будут перезаписываться)
function realkit_admin_notice($message = '', $type = 'info', $is_dismissible = FALSE) {

	if (empty($message)) return FALSE;
	if (!in_array($type, ['info', 'success', 'error', 'warning'])) return FALSE;

	realkit_admin_notice_var('message', $message);
	realkit_admin_notice_var('type', $type);
	realkit_admin_notice_var('dismissible', $is_dismissible ? ' is-dismissible' : '');

	add_action('admin_notices', function() {

		$mess = realkit_admin_notice_var('message');
		$type = realkit_admin_notice_var('type');
		$dism = realkit_admin_notice_var('dismissible');

		echo '<div class="notice notice-' . $type . $dism . '"><p><b>real.Kit</b></p>' . $mess . '</div>';

	}, 10, 1);

}

// Запоминает данные опций (для кастомной верстки настроек)
function realkit_settings($group = FALSE, $field = []) {

	static $settings;

	// Добавить группу
	if (is_array($group)) {

		$group = array_merge([
			'name'   => '',
			'title'  => '',
			'desc'   => '',
			'fields' => [],
			'order'  => 90,
			'class'  => ''
		], $group);

		if (empty($group['name'])) return;

		$settings['groups'][$group['name']] = $group;
		$settings['order'][$group['order']][] = $group['name'];

	}

	// Добавить поле
	elseif (is_string($group) and is_array($field)) {

		$field = array_merge([
			'name'     => '',
			'value'    => '',
			'title'    => '',
			'type'     => 'text',
			'disabled' => FALSE,
		], $field);

		// Зарегистрировать опцию (чтоб WP мог ее обрабатывать)
		register_setting(
			REALKIT_PLUGIN_SETTINGS,	// Идентификатор группы настроек
			$field['name']						// Идентификатор поля
		);

		if (empty($group) or empty($field['name']) or !isset($settings['groups'][$group])) return;

		$settings['groups'][$group]['fields'][] = $field;

	}

	// Вернуть
	elseif (!$group) {

		ksort($settings['order']);

		return $settings;

	}

}

// Выводит JSON (в ответ на AJAX запрос)
function realkit_die_json($data = [], $html = false) {
  header('Content-Type: application/json');
  $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT);
  $data = $html ? $data : strip_tags($data);
  $data = str_replace('&nbsp;', ' ', $data);
  $data = str_replace('\t', '', $data);
  $data = realkit_replace_repeat($data, '\r\n');
  die ($data);
}

// Рекурсивно удаляет повторяющиеся символы
function realkit_replace_repeat($str = '', $part = '') {
  $str = str_replace($part . $part, $part, $str);
  if (strpos($str, $part . $part) !== FALSE) {
    $str = realkit_replace_repeat($str, $part);
  }
  return $str;
}