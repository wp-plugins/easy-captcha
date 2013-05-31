<?php
/**
 * @file
 * Easy Captcha. easy_captcha_password_reset_page.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_install_captcha_password_reset_page(){
	
	add_action('lostpassword_form', 'easy_captcha_show_captcha_password_reset_page');
	add_action('lostpassword_post', 'easy_captcha_check_captcha_password_reset_page', 10, 3);

}

function easy_captcha_show_captcha_password_reset_page() {

	$captcha = easy_captcha_get_setting("easy_captcha-password_reset_page", 'hidden');
	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_show_captcha_{$captcha}";
	$fn('password_reset_page');

	return TRUE;
}

function easy_captcha_check_captcha_password_reset_page() {	

	if(isset( $_REQUEST['user_login'] ) && empty($_REQUEST['user_login'])) {
		return;
	}

	$captcha = easy_captcha_get_setting("easy_captcha-password_reset_page", 'hidden');

	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_check_captcha_{$captcha}";
	$result =  $fn('password_reset_page');
	$result = easy_captcha_get_captcha_result($result, __('Please try to submit the form again'));

	if ($result !== TRUE) {
		wp_die($result);
	}

}


