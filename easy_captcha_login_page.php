<?php
/**
 * @file
 * Easy Captcha. easy_captcha_login_page.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_install_captcha_login_page(){

	add_action('login_form', 'easy_captcha_show_captcha_login_form');
	add_filter('wp_authenticate_user', 'easy_captcha_check_captcha_login_page' ,10,2);

}

function easy_captcha_check_captcha_login_page($user, $password) {

	if (!is_a($user, 'WP_User')) { 
		return $user; 
	}

	$captcha = easy_captcha_get_setting("easy_captcha-login_page", 'hidden');
	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_check_captcha_{$captcha}";

	$result = $fn('login_page');
	$result = easy_captcha_get_captcha_result($result, __('Please try to submit the form again'));

	if ($result !== TRUE) {
	    $error = new WP_Error('easy_capctcha_error', "<strong>{$result}</strong>");
		return $error;
	}
	
    return $user;
}

function easy_captcha_show_captcha_login_form() {
	$captcha = easy_captcha_get_setting("easy_captcha-login_page", 'hidden');
	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_show_captcha_{$captcha}";
	$fn('login_page');

	return TRUE;
}
