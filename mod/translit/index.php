<?php

require_once REALKIT_PLUGIN_DIR_MOD . '/translit/class.php';

if (get_option('realkit_translit_toggle') != 'off') {

	require_once REALKIT_PLUGIN_DIR_MOD . '/translit/actions.php';

	// Эти фильтры НЕ при редактировании записи если будут внутри is_admin()
	add_filter('sanitize_file_name', ['Realkit_translit', 'convert'], 10, 3);
	add_filter('sanitize_title',     ['Realkit_translit', 'convert'], 9, 3);

	if (is_admin()) {

		require_once REALKIT_PLUGIN_DIR_MOD . '/translit/ajax.php';

		// Включить показ сообщения после активации плагина
		register_activation_hook(REALKIT_PLUGIN_DIR . REALKIT_PLUGIN_FILE, function() {
			update_option('realkit_translit_notice', 'on');
		});

		// Показать сообщение (если разрешено)
		if (get_option('realkit_translit_notice') == 'on') {
			realkit_admin_notice('<p>' . sprintf(__('You can convert all existing Cyrillic slugs to translit on the %ssettings page%s of plugin', 'realkit'), '<a href="/wp-admin/options-general.php?page=' . REALKIT_PLUGIN_SETTINGS . '.php">', '</a>') . '</p>', 'info', TRUE);
			update_option('realkit_translit_notice', 'off');
		}

		// Добавить страницу с формой генерации транслита
		add_action('admin_menu', function() {
			add_submenu_page(
				'tools.php',
				__('Translit', 'realkit'),
			  __('Translit', 'realkit'),
			  'manage_options',
			  'realkit-translit-generator',
			  function() {
			  	require_once REALKIT_PLUGIN_DIR_MOD . '/translit/tpl/generator.php';
			  }
			);
		});

		// Подключить CSS/JS
		add_action('current_screen', function() {

			// Для страниц редактирования
			if (in_array(get_current_screen()->base, ['edit', 'post', 'edit-tags', 'term', 'tools_page_realkit-translit-generator'])) {
				add_action('admin_print_footer_scripts', function() {
					echo '<script>';
					require_once REALKIT_PLUGIN_DIR_MOD . '/translit/js/ajax.js';
					echo '</script>';
				});
			}

			// Для страницы генератора
			if (get_current_screen()->id == 'tools_page_realkit-translit-generator') {
				wp_enqueue_style('realkit_settings', REALKIT_PLUGIN_URL_MOD . '/translit/css/generator.css');
				add_action('admin_print_footer_scripts', function() {
					echo '<script>';
					require_once REALKIT_PLUGIN_DIR_MOD . '/translit/js/generator.js';
					echo '</script>';
				});
			}

		});

	}

}

if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/translit/settings.php';

	// Подключить CSS/JS
	add_action('current_screen', function() {

		// Для страницы настроек плагина
		if (get_current_screen()->id == REALKIT_PLUGIN_SCREEN_S) {
			add_action('admin_enqueue_scripts', function() {
				wp_enqueue_style('realkit_translit', REALKIT_PLUGIN_URL_MOD . '/translit/css/settings.css');
				wp_enqueue_script('realkit_translit', REALKIT_PLUGIN_URL_MOD . '/translit/js/settings.js', ['jquery']);
			});
		}

	});

}