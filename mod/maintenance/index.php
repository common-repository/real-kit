<?php

require_once REALKIT_PLUGIN_DIR_MOD . '/maintenance/class.php';
require_once REALKIT_PLUGIN_DIR_MOD . '/maintenance/settings.php';

if (get_option('realkit_maintenance_toggle') == 'on') {
	add_action('init', ['Realkit_maintenance', 'start'], 1);
}