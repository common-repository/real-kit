<?php

require_once REALKIT_PLUGIN_DIR_MOD . '/modals/class.php';

define('REALKIT_MODALS_POST_TYPE', 'realkit_modal');

// Если плагин обновляется с версии меньше 5.0.0 (а не устанавливается)
if (get_option('realkit_plugin_version') == '') {

	global $wpdb;

	// Переименовать старый тип записи
	$wpdb->update(
		$wpdb->posts,
		['post_type' => REALKIT_MODALS_POST_TYPE],
		['post_type' => 'modal_window'],
		['%s'],
		['%s']
	);

}

// Если модудь НЕ выключен
if (get_option('realkit_modals_toggle') != 'off') {

	// Зарегистрировать новый тип записей
	add_action('init', function() {
		register_post_type(REALKIT_MODALS_POST_TYPE, [
			'public'              => TRUE,
			'show_in_nav_menus'   => FALSE,
			'show_in_menu'        => TRUE,
			'supports'            => ['title', 'editor'],
			'exclude_from_search' => TRUE,
			'rewrite'             => FALSE,
			'query_var'           => FALSE,
			'menu_icon'           => 'dashicons-admin-page',
			'labels'              => [
				'name'               => __('Modals', 'realkit'),
				'singular_name'      => __('Modal', 'realkit'),
				'add_new'            => __('Add New', 'realkit'),
				'add_new_item'       => __('Add New Modal', 'realkit'),
				'edit_item'          => __('Edit Modal', 'realkit'),
				'new_item'           => __('New Modal', 'realkit'),
				'all_items'          => __('All Modals', 'realkit'),
				'view_item'          => __('View Modal', 'realkit'),
				'search_items'       => __('Search Modal', 'realkit'),
				'not_found'          => __('No Modal found', 'realkit'),
				'not_found_in_trash' => __('No Modal found in Trash', 'realkit'),
				'menu_name'          => __('Modals', 'realkit'),
				'parent_item_colon'  => ''
			],
		]);
	});

	if (is_admin()) {

		// Обрабатывать уведомления для нового типа записей
		add_filter('post_updated_messages', function($messages) {

			$messages[REALKIT_MODALS_POST_TYPE] = [
				0  => '',
				1  => __('Modal updated', 'realkit'),
				// 2  => __('Custom field updated', 'realkit'),
				// 3  => __('Custom field deleted', 'realkit'),
				4  => __('Modal updated', 'realkit'),
				5  => isset($_GET['revision']) ? __('Modal restored', 'realkit') : FALSE, // ! в новом блочном редакторе это НЕ используется (пустое значение)
				6  => __('Modal published', 'realkit'),
				7  => __('Modal saved', 'realkit'),
				8  => __('Modal submitted', 'realkit'),
				9  => sprintf(__('Publication is scheduled for:', 'realkit') . ' <strong>%1$s</strong>.', date_i18n(__('M j, Y @ G:i', 'realkit'))),
				10 => __('Modal draft updated', 'realkit')
			];

			return $messages;

		});

		// Создать колонку для шорткода (на странице всех записей)
		add_action('manage_' . REALKIT_MODALS_POST_TYPE . '_posts_columns', function($columns) {

			$columns['realkit_modals_shortcode'] = __('Shortcode', 'realkit');

			// Заодно удалить колонку с датой
			unset($columns['date']);

			return $columns;

		});

		// Вставить шорткод в колонку (на странице всех записей)
		add_filter('manage_' . REALKIT_MODALS_POST_TYPE . '_posts_custom_column', function($column, $id) {

			$_text  = get_post_meta($id, 'realkit_modals_shortcode_text',  TRUE);
			$_id    = get_post_meta($id, 'realkit_modals_shortcode_id',    TRUE);
			$_class = get_post_meta($id, 'realkit_modals_shortcode_class', TRUE);

			$attr_id    = empty($_id)    ? '' : ' id="' . $_id . '"';
			$attr_class = empty($_class) ? '' : ' class="' . $_class . '"';

			if ($column == 'realkit_modals_shortcode') {
				echo '<div class="realkit_modals_shortcode_cover">[modal open="' . $id . '"' . $attr_id . $attr_class . ']' . $_text . '[/modal]</div>';
			}

			return $column;

		}, 10, 2);

		// Создать метабокс с шорткодом (на странице редактирования записи)
		add_action('add_meta_boxes', function() {
			add_meta_box(
				'realkit_modals_shortcode',
				__('Open button', 'realkit'),
				function($post) {

					$text  = get_post_meta($post->ID, 'realkit_modals_shortcode_text',  TRUE);
					$id    = get_post_meta($post->ID, 'realkit_modals_shortcode_id',    TRUE);
					$class = get_post_meta($post->ID, 'realkit_modals_shortcode_class', TRUE);
					$smart = get_post_meta($post->ID, 'realkit_modals_if_need_only',    TRUE);

					$attr_id    = empty($id)    ? '' : ' id="' . $id . '"';
					$attr_class = empty($class) ? '' : ' class="' . $class . '"';

					require_once REALKIT_PLUGIN_DIR_MOD . '/modals/tpl/metabox.php';

				},
				REALKIT_MODALS_POST_TYPE,
				'side'
			);
		});

		// Сохранять мета данные
		add_action('save_post_' . REALKIT_MODALS_POST_TYPE, function($post_ID, $post, $update) {
			if ($update) {
				update_post_meta($post_ID, 'realkit_modals_shortcode_text',  $_POST['realkit_modals_shortcode_text']);
				update_post_meta($post_ID, 'realkit_modals_shortcode_id',    $_POST['realkit_modals_shortcode_id']);
				update_post_meta($post_ID, 'realkit_modals_shortcode_class', $_POST['realkit_modals_shortcode_class']);
				update_post_meta($post_ID, 'realkit_modals_if_need_only',    isset($_POST['realkit_modals_if_need_only']));
			}
		}, 10, 3);

	}

	// Добавить шорткод
	remove_shortcode('modal');
	add_shortcode('modal', function($args, $content = '') {

		if (get_option('realkit_modals_toggle') == 'off' or !isset($args['open'])) return FALSE;

		$args = shortcode_atts(array(
			'open'  => '',
			'class' => '',
			'id'    => ''
		), $args);

		$modal = get_posts(array(
			'post_type' => REALKIT_MODALS_POST_TYPE,
			'post__in'  => [intval($args['open'])],
		));

		if (empty($modal)) return;

		// Запомнить
		Realkit_modals::$list[] = $modal[0];

		$id      = (empty($args['id']))    ? '' : ' id="' . sanitize_html_class($args['id'])    . '"';
		$class   = (empty($args['class'])) ? '' : ' ' . sanitize_html_class($args['class']);
		$target  = ' realkit_modal_target="#realkit_modal_' . intval($args['open']) . '"';
		$content = str_replace(array('<p>', '</p>'), '', $content);

		$button  = '<button type="button" class="realkit_modal_open' . $class . '"' . $id . $target . '>' . $content . '</button>';

		return trim(str_replace(array("\r", "\n"), '', $button));

	});

	// Вывести модальные окна в конце страницы
	add_action('wp_footer', function() {

		// Те на которые есть шорткоды
		if (!empty(Realkit_modals::$list)) {
			foreach (Realkit_modals::$list as $modal) {
				require REALKIT_PLUGIN_DIR_MOD . '/modals/tpl/modal.php';
			}
		}

		// Те которые нужно ввести даже если нет шорткодов
		else {

			$modals = get_posts([
				'posts_per_page' => -1,
				'post_type'      => REALKIT_MODALS_POST_TYPE,
				'meta_query'     => [
					[
						'key'   => 'realkit_modals_if_need_only',
						'value' => 1,
					]
				],
			]);

			if (!empty($modals)) {
				foreach ($modals as $modal) {
					require REALKIT_PLUGIN_DIR_MOD . '/modals/tpl/modal.php';
				}
			}

		}

	});

	// Подключить CSS/JS
	if (!is_admin()) {
		add_action('wp_enqueue_scripts', function() {
			wp_enqueue_style('realkit_modals', REALKIT_PLUGIN_URL_MOD . '/modals/css/site.css');
			wp_enqueue_script('realkit_modals', REALKIT_PLUGIN_URL_MOD . '/modals/js/site.js', ['jquery']);
		});
	}

}

if (is_admin()) {

	require_once REALKIT_PLUGIN_DIR_MOD . '/modals/settings.php';

	// Подключить CSS/JS
	add_action('current_screen', function() {

		// Для страницы настроек плагина
		if (in_array(get_current_screen()->id, ['realkit_modal', 'edit-realkit_modal'])) {
			add_action('admin_enqueue_scripts', function() {
				wp_enqueue_style('realkit_modals', REALKIT_PLUGIN_URL_MOD . '/modals/css/admin.css');
				wp_enqueue_script('realkit_modals', REALKIT_PLUGIN_URL_MOD . '/modals/js/admin.js', ['jquery']);
			});
		}

	});

}