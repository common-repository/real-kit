<?php

add_action('admin_init', function(){

	$mod = 'optimize';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Optimization', 'realkit'),
		// 'desc'  => __('', 'realkit'),
		'order' => 10,
		'class' => 'optimize'
	]);

	// Получить текущее кол-во ревизий
	$val = get_option('realkit_optimize_revisions_number');
	if (!$val and !is_numeric($val)) {
		$val = -1;
		if (defined('WP_POST_REVISIONS')) {
			$val = is_numeric(WP_POST_REVISIONS) ? WP_POST_REVISIONS : -1;
		}
	}

	// Ограничение кол-ва ревизий
	realkit_settings($mod, [
		'name'  => 'realkit_optimize_revisions_number',
		'value' => $val,
		'title' => __('Maximum number of revisions per post', 'realkit'),
		'type'  => REALKIT_PLUGIN_DIR_MOD . '/' . $mod . '/tpl/settings_revisions.php',
	]);

	// Удаление существующих ревизий
	realkit_settings($mod, [
		'name'     => 'realkit_optimize_revisions_delete',
		'value'    => 'off',
		'title'    => __('Delete existing revisions', 'realkit'),
		'type'     => 'checkbox',
	]);

	// Удаление автосохранений
	realkit_settings($mod, [
		'name'     => 'realkit_optimize_autosaves_delete',
		'value'    => 'off',
		'title'    => __('Delete existing autosaves', 'realkit'),
		'type'     => 'checkbox',
	]);

	// Отключение поиска обновлений на каждой странице
	realkit_settings($mod, [
		'name'  => 'realkit_optimize_search_update',
		'value' => get_option('realkit_optimize_search_update') == 'on' ? 'on' : 'off',
		'title' => __('Check for updates only in the background and when you load the page "Updates"', 'realkit'),
		'type'  => REALKIT_PLUGIN_DIR_MOD . '/' . $mod . '/tpl/settings_search_update.php',
	]);

	// Отключение Эмодзи
	realkit_settings($mod, [
		'name'  => 'realkit_optimize_emojis',
		'value' => get_option('realkit_optimize_emojis') == 'on' ? 'on' : 'off',
		'title' => __('Disable scripts and styles for Emojis', 'realkit'),
		'type'  => REALKIT_PLUGIN_DIR_MOD . '/' . $mod . '/tpl/settings_emojis.php',
	]);

});