<?php
/**
 * @file
 * Easy Captcha. easy-captcha-sessions.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_get_session_value($map, $key) {

	
	if (!isset($map['easy_captcha_sid'])) {
		return NULL;
	}
	$sid = $map['easy_captcha_sid'];
	if (!preg_match('/^[A-Fa-f0-9]{32}$/', $sid)) {
		return NULL;
	}
	
	global $table_prefix;
	$query = "SELECT value FROM {$table_prefix}easy_captcha_sessions WHERE sid ='{$sid}'";
	global $wpdb;
	
	$value = $wpdb->get_var($query);
	$xml = simplexml_load_string($value);

	return (string) $xml->$key;

}



function easy_captcha_set_session_value($key, $value, $sid = NULL) {

	if (!(is_array($sid) && isset($sid['easy_captcha_sid']))) {
		return NULL;
	}
	
	$sid = $sid['easy_captcha_sid'];
	if (!preg_match('/^[A-Fa-f0-9]{32}$/', $sid)) {
		return NULL;
	}

	
	global $table_prefix;
	$query = "SELECT id, value FROM {$table_prefix}easy_captcha_sessions WHERE sid=%s";

	global $wpdb;
	$query = $wpdb->prepare($query, $sid);
	$row = $wpdb->get_results($query);
	if (count($row) == 0) {
		return NULL;
	}

	$row = $row[0];
	$rid = $row->id;
	$xml = simplexml_load_string($row->value);
	$xml->$key = $value;
	$svalue = $xml->asXML();

	$query = "UPDATE {$table_prefix}easy_captcha_sessions SET value=%s  WHERE id=%d";
	$query = $wpdb->prepare($query, $svalue, $rid);
	$wpdb->query($query);

	return $sid;

}                                     

function easy_captcha_get_session_id() {
	global $table_prefix, $wpdb;

	if (rand(1, 10) == 9) {
		$ndays= 1;
		$ddate = date("Y-m-d H:i:s", time() - 24 * 60 * 60 * $ndays);
		$query = "DELETE FROM `{$table_prefix}easy_captcha_sessions` WHERE opentime < '{$ddate}'";
		$wpdb->query($query);
	}

	$pwd = NONCE_SALT;
	$maxid = $wpdb->get_var("SELECT MAX(id) FROM {$table_prefix}easy_captcha_sessions");
	$sid = md5(($maxid + 10) . $pwd);
	$query = "INSERT INTO {$table_prefix}easy_captcha_sessions(sid, value) VALUES ('{$sid}', '<data />')";
	$wpdb->query($query);
	return $sid;

}
