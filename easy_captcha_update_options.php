<?php
/**
 * @file
 * Easy Captcha. easy_captcha_update_options.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */
function easy_captcha_update_options() {

	$rows = array(
		array('option_name' => 'easy_captcha-active-page', 'option_value' => 'password_reset_page', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form', 'option_value' => 'hidden', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-checkbox', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-check_javascript', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-hidden', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-max_completion_time', 'option_value' => '3000', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-min_completion_time', 'option_value' => '10', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha_hide_for_logged_in', 'option_value' => 'off', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha_lang', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha_private_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha_public_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-recaptcha_theme', 'option_value' => 'red', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-simple', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-simple_hide_for_logged_in', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-comments_form-simple_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page', 'option_value' => 'hidden', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-checkbox', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-check_javascript', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-hidden', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-max_completion_time', 'option_value' => '3000', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-min_completion_time', 'option_value' => '10', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha_hide_for_logged_in', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha_lang', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha_private_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha_public_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-recaptcha_theme', 'option_value' => 'red', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-simple', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-simple_hide_for_logged_in', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-login_page-simple_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page', 'option_value' => 'hidden', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-checkbox', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-check_javascript', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-hidden', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-max_completion_time', 'option_value' => '3000', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-min_completion_time', 'option_value' => '10', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha_hide_for_logged_in', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha_lang', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha_private_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha_public_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-recaptcha_theme', 'option_value' => 'red', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-simple', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-simple_hide_for_logged_in', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-password_reset_page-simple_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page', 'option_value' => 'hidden', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-checkbox', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-check_javascript', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-hidden', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-max_completion_time', 'option_value' => '3000', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-min_completion_time', 'option_value' => '10', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha_hide_for_logged_in', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha_lang', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha_private_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha_public_key', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-recaptcha_theme', 'option_value' => 'red', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-simple', 'option_value' => 'on', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-simple_hide_for_logged_in', 'option_value' => '', 'autoload' => 'no'),
		array('option_name' => 'easy_captcha-registration_page-simple_label', 'option_value' => 'Prove that you are a human!', 'autoload' => 'no')
	);

	$fn_add = 'add_option';
	$fn_get = 'get_option';
	global $wpmu;
	if ($wpmu === 1) {
		$fn_add = 'add_site_option';
		$fn_get = 'get_site_option';
	}

	foreach ($rows as $row) {
		$currentvalue = $fn_get($row['option_name']);
		if ($currentvalue === FALSE) {
			$fn_add($row['option_name'], $row['option_value'] , '', $row['autoload']);
		}
	}

}