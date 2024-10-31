<?php

class Realkit_maintenance {

	public static function get_html() {

		$html = get_option('realkit_maintenance_html');

		if (!$html) {
			$html = self::get_html_default();
		}

		return html_entity_decode($html);

	}

	public static function get_html_default() {
		ob_start();
		require_once REALKIT_PLUGIN_DIR_MOD . '/maintenance/tpl/html.php';
		return ob_get_clean();
	}

	public static function reset() {
		update_option('realkit_maintenance_html', htmlentities(stripslashes(self::get_html_default())));
	}

	public static function start() {
		if (strpos($_SERVER['REQUEST_URI'], 'wp-admin') === FALSE
		and strpos($_SERVER['REQUEST_URI'], 'wp-login') === FALSE
		and !is_admin() and !is_super_admin()) {
			die (self::get_html());
		}
	}

}