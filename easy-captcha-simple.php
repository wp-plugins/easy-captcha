<?php
/**
 * @file
 * Easy Captcha. easy-captcha-simple.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */
function easy_captcha_get_captcha_settings_simple($pageid, $disabled) {

	$simple_label = easy_captcha_element('simple_label', $pageid, $disabled);
	$simple_label->label = __('Label');
	$simple_label->hint = __('Label');

	$simple_hide_for_logged_in = easy_captcha_element('simple_hide_for_logged_in', $pageid, $disabled, 'off');
	$simple_hide_for_logged_in->label = __('Hide captcha for <br/> logged in users');
	$simple_hide_for_logged_in->hint = __('Hide captcha for logged in users');

	echo "<table>";

	easy_captcha_input($simple_label);	

	if ($pageid == 'comments_form') {
		easy_captcha_checkbox($simple_hide_for_logged_in);	
	}

	echo "</table>";
}

function easy_captcha_show_captcha_simple($pageid) {

	$prefix = "easy_captcha-{$pageid}-";
	$hide = easy_captcha_get_setting("{$prefix}simple_hide_for_logged_in", 'off');
	if ($hide == 'on'  && is_user_logged_in()) {
		return;
	}

	require_once 'easy-captcha-sessions.php';
	$sid = isset($_REQUEST['easy_captcha_sid']) ?  $_REQUEST['easy_captcha_sid'] : easy_captcha_get_session_id();

	$params = array();
	$params['action'] = 'easy-captcha-submit';		
	$params['easy_captcha_sid'] = $sid;		
	$params['easy_captcha_type'] = 'simple';		
	$params['call'] = 'getimiage';		
	$params['page'] = $pageid;
		
	$query = array();
	foreach ($params as $key=>$value) {
		$query[] = "{$key}={$value}";
	}
	$query = implode('&', $query);

	$url = admin_url('admin-ajax.php');
	$url = "{$url}?{$query}";

	$char = strtoupper(substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4));
	$str = rand(1, 7) . rand(1, 7) . $char;

	$map = array();
	$map['easy_captcha_sid'] = $sid;
	easy_captcha_set_session_value("easy_captcha_captcha_simple_{$pageid}", $str, $map);

	$label = easy_captcha_get_setting("{$prefix}simple_label", '');
	echo "<img src='$url'><br />";
	if (!empty($label)) {
		echo "<label for='easy_captcha_captcha_simple'>{$label}</label><br />";
	}
	echo "<input type='text' id='easy_captcha_captcha_simple' name='easy_captcha_captcha_simple' value=''>";
	echo "<input type='hidden' id='easy_captcha_sid' name='easy_captcha_sid' value='{$sid}'>";

}

function easy_captcha_ajax_simple($map) {
	if (!isset($map['page'])) {
		exit();	
	} 
	$page = $map['page'];
	$pages = easy_captcha_get_avalable_pages();
	if (!isset($pages[$page])) {
		exit();	
	}	
	require_once 'easy-captcha-sessions.php';	
	$value = easy_captcha_get_session_value($map, "easy_captcha_captcha_simple_{$page}");

	if (empty($value)){
		exit();	
	}

	header('Content-type: image/png');
	$image = imagecreatefrompng(dirname(__FILE__) . '/images/button.png');
	$colour = imagecolorallocate($image, 183, 178, 152);
	$font = dirname(__FILE__)  . '/fonts/distro.ttf';
	$rotate = rand(-15, 15);
	imagettftext($image, 14, $rotate, 18, 30, $colour, $font, $value);
	imagepng($image);
	exit();	

}

function easy_captcha_check_captcha_simple($pageid) {

	$prefix = "easy_captcha-{$pageid}-";
	$hide = easy_captcha_get_setting("{$prefix}simple_hide_for_logged_in", 'off');

	if ($hide == 'on' && is_user_logged_in()) {
		return TRUE;
	}

	if (!isset($_REQUEST['easy_captcha_captcha_simple']) || empty($_REQUEST['easy_captcha_captcha_simple'])) {
		return FALSE;
	}

	$clientvalue = $_REQUEST['easy_captcha_captcha_simple'];

	require_once 'easy-captcha-sessions.php';
	$servervalue = easy_captcha_get_session_value($_REQUEST, "easy_captcha_captcha_simple_{$pageid}");
	$result = $clientvalue == $servervalue;
	if ($result) {
		return TRUE;
	}
	return __('Please enter a correct CAPTCHA value');
}

function easy_captcha_valideate_captcha_settings_simple($pageid, $pages, $label, $errors) {
	return $errors;
}