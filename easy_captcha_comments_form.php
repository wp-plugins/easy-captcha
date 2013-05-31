<?php
/**
 * @file
 * Easy Captcha. easy_captcha_comments_form.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */
function easy_captcha_install_captcha_comments_form(){

	add_action('comment_form_after_fields', 'easy_captcha_show_captcha_comments_form', 1 );
	add_action('comment_form_logged_in_after', 'easy_captcha_show_captcha_comments_form', 1 );
	add_filter( 'preprocess_comment', 'easy_captcha_check_captcha_comments_form' );	

}

function easy_captcha_show_captcha_comments_form() {
	$captcha = easy_captcha_get_setting("easy_captcha-comments_form", 'hidden');
	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_show_captcha_{$captcha}";
	$fn('comments_form');
	return true;
}



function easy_captcha_check_captcha_comments_form($comment) {	

	$captcha = easy_captcha_get_setting("easy_captcha-comments_form", 'hidden');
	require_once "easy-captcha-{$captcha}.php";
	$fn = "easy_captcha_check_captcha_{$captcha}";
	$result =  $fn('comments_form');
	$result = easy_captcha_get_captcha_result($result, __('Please try to submit the form again'));

	if ($result !== TRUE) {
		wp_die($result);
	}

	return $comment;
}


