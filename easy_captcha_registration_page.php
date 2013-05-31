<?php
/**
 * @file
 * Easy Captcha. easy_captcha_registration_page.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_install_captcha_registration_page(){
	
	add_action( 'register_form', 'easy_captcha_show_captcha_register_form' );
	add_action( 'signup_extra_fields', 'easy_captcha_show_captcha_register_form' );

	add_action( 'register_post', 'easy_captcha_check_captcha_register_form', 10, 3 );
	add_filter( 'wpmu_validate_user_signup', 'easy_captcha_validate_captcha_register_form' );

}

function easy_captcha_show_captcha_register_form() {
	$captcha = easy_captcha_get_setting("easy_captcha-registration_page", 'hidden');
	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_show_captcha_{$captcha}";
	$fn('registration_page');
	return true;
}

function easy_captcha_check_captcha_register_form($login, $email, $errors) {	
	$captcha = easy_captcha_get_setting("easy_captcha-registration_page", 'hidden');

	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_check_captcha_{$captcha}";
	$result =  $fn('registration_page');
	$result = easy_captcha_get_captcha_result($result, __('Please try to submit the form again'));

	if ($result !== TRUE) {
	    $errors->add('easy_captcha_error', $result);
	}

	return $errors;

}

function easy_captcha_validate_captcha_register_form($results) {	

	$captcha = easy_captcha_get_setting("easy_captcha-registration_page", 'hidden');

	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_check_captcha_{$captcha}";
	$result =  $fn('registration_page');

	$result = easy_captcha_get_captcha_result($result, __('Please try to submit the form again'));

	if ($result !== TRUE) {
	    $results['errors']->add('easy_captcha_error', $result);
	}

	return $results;
}



