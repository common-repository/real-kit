<?php

add_action('admin_init', function(){

	$mod = 'translit';

	// Группа
	realkit_settings([
		'name'  => $mod,
		'title' => __('Translit', 'realkit'),
		'desc'  => __('All available characters will be converted to lower case', 'realkit'),
		'order' => 10,
		'class' => ''
	]);

	// Выключатель
	realkit_settings($mod, [
		'name'  => 'realkit_translit_toggle',
		'value' => (get_option('realkit_translit_toggle') == 'on') ? 'on' : 'off',
		'title' => __('Turn on translit for posts and terms (including pages, categories, tags)', 'realkit'),
		'type'  => 'checkbox',
	]);

	// Пправила
	realkit_settings($mod, [
		'name'     => 'realkit_translit_rules',
		'value'    => Realkit_translit::get_rules(),
		'type'     => REALKIT_PLUGIN_DIR_MOD . '/' . $mod . '/tpl/settings.php',
		'disabled' => (get_option('realkit_translit_toggle') == 'off'),
	]);

	// Восстановить по умолчанию
	realkit_settings($mod, [
		'name'     => 'realkit_translit_toggle_default',
		'value'    => 'off',
		'title'    => __('Restore default rule settings (based on ISO 9:1995)', 'realkit'),
		'type'     => 'checkbox',
		'disabled' => (get_option('realkit_translit_toggle') == 'off'),
	]);

	// Конвертировать существующие
	realkit_settings($mod, [
		'name'     => 'realkit_translit_toggle_convert',
		'value'    => 'off',
		'title'    => __('Convert all existing slugs that do not comply with the current rules, except for the names of media files', 'realkit'),
		'type'     => 'checkbox',
		'disabled' => (get_option('realkit_translit_toggle') == 'off'),
	]);

});