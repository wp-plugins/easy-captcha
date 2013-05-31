<?php
/**
 * @file
 * Easy Captcha. easy-captcha-install.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_install() {

	global $wpdb, $table_prefix;
	$collate = '';
	if (!empty($wpdb->charset))
		$collate = 'DEFAULT CHARACTER SET '. $wpdb->charset;
	if (!empty($wpdb->collate))
		$collate .= ' COLLATE ' . $wpdb->collate;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$sqls = array();

	$sqls[] = "CREATE TABLE {$table_prefix}easy_captcha_sessions (
				id INT(11) NOT NULL auto_increment,
				opentime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				value TEXT,
				sid CHAR(32) NOT NULL,
				PRIMARY KEY  (id)) $collate;";

	foreach ($sqls as $sql){
		dbDelta($sql);
	}

	$plugin_prefix_root = plugin_dir_path( __FILE__ );
	$plugin_prefix_filename = "{$plugin_prefix_root}/easy_captcha_update_options.php";
	require_once $plugin_prefix_filename;
	easy_captcha_update_options();

}


function easy_captcha_uninstall() {

	global $wpdb, $table_prefix;

	$sqls[] = "DROP TABLE IF EXISTS {$table_prefix}easy_captcha_sessions;";

	foreach ($sqls as $sql){
		$wpdb->query($sql);
	}

	$wpdb->query("DELETE FROM `{$table_prefix}options` WHERE `option_name` LIKE 'easy_captcha%'");

}
