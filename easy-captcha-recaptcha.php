<?php
/**
 * @file
 * Easy Captcha. easy-captcha-recaptcha.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */
function easy_captcha_get_captcha_settings_recaptcha($pageid, $disabled) {

	$recaptcha_label = easy_captcha_element('recaptcha_label', $pageid, $disabled);
	$recaptcha_label->label = __('Label');
	$recaptcha_label->hint = __('Label');

	$recaptcha_public_key = easy_captcha_element('recaptcha_public_key', $pageid, $disabled);
	$recaptcha_public_key->label = __('reCaptcha Public key');
	$recaptcha_public_key->hint = __('reCaptcha Public key');

	$recaptcha_private_key = easy_captcha_element('recaptcha_private_key', $pageid, $disabled);
	$recaptcha_private_key->label = __('reCaptcha Private key');
	$recaptcha_private_key->hint = __('reCaptcha Private key');

	
	$recaptcha_theme = easy_captcha_element('recaptcha_theme', $pageid, $disabled, 'red');
	$recaptcha_theme->label = __('Theme');
	$recaptcha_theme->hint = __('Theme');
	
	$recaptcha_theme->options = array();
	$recaptcha_theme->options['red'] = __('Red');
	$recaptcha_theme->options['white'] = __('White');
	$recaptcha_theme->options['blackglass'] = __('Blackglass');
	$recaptcha_theme->options['clean'] = __('Clean');
	
	$recaptcha_lang = easy_captcha_element('recaptcha_lang', $pageid, $disabled);
	$recaptcha_lang->label = __('Language');
	$recaptcha_lang->hint = __('Language');
	
	$recaptcha_lang->options = array();
	$recaptcha_lang->options[""] = '..';
	$recaptcha_lang->options["en"] = __("English");
	$recaptcha_lang->options["nl"] = __("Dutch");
	$recaptcha_lang->options["fr"] = __("French");
	$recaptcha_lang->options["de"] = __("German");
	$recaptcha_lang->options["pt"] = __("Portuguese");
	$recaptcha_lang->options["ru"] = __("Russian");
	$recaptcha_lang->options["es"] = __("Spanish");
	$recaptcha_lang->options["tr"] = __("Turkish");

	$recaptcha_hide_for_logged_in = easy_captcha_element('recaptcha_hide_for_logged_in', $pageid, $disabled, 'off');
	$recaptcha_hide_for_logged_in->label = __('Hide captcha for <br/> logged in users');
	$recaptcha_hide_for_logged_in->hint = __('Hide captcha for logged in users');

	echo __('Please visit <a target=_blank href="http://www.google.com/recaptcha/">Google reCaptcha site</a> to get API keys');
	echo "<br />";
	echo "<br />";

	echo "<table>";

	easy_captcha_input($recaptcha_label);	
	easy_captcha_input($recaptcha_public_key);	
	easy_captcha_input($recaptcha_private_key);	
	easy_captcha_select($recaptcha_theme);	
	easy_captcha_select($recaptcha_lang);	

	if ($pageid == 'comments_form') {
		easy_captcha_checkbox($recaptcha_hide_for_logged_in);	
	}

	echo "</table>";
}

function easy_captcha_show_captcha_recaptcha($pageid) {
	$prefix = "easy_captcha-{$pageid}-";

	$hide = easy_captcha_get_setting("{$prefix}recaptcha_hide_for_logged_in", 'off');
	if ($hide == 'on'  && is_user_logged_in()) {
		return;
	}

	$divid = "{$prefix}div";
	$lang = easy_captcha_get_setting("{$prefix}recaptcha_lang", '');
	$theme = easy_captcha_get_setting("{$prefix}recaptcha_theme", '');

	$jsobject = (object) array();
	if (!empty($lang)) {
		$jsobject->lang = $lang;
	}
	if (!empty($theme)) {
		$jsobject->theme = $theme;
	}

	$jsobject = sizeof($jsobject) > 0 ? ', ' .  json_encode($jsobject) : '';

	$pbkey = easy_captcha_get_setting("{$prefix}recaptcha_public_key", '');
	if (empty($pbkey)) {
		return '';
	}

	$label = easy_captcha_get_setting("{$prefix}recaptcha_label", '');
	if (!empty($label)) {
		echo "<label>{$label}</label><br />";
	}

?>

<style>div#login{width:375px !important;}</style>
<div id='<?php echo $divid;?>'></div>
<script type='text/javascript' src='http://www.google.com/recaptcha/api/js/recaptcha_ajax.js'></script>
<script type='text/javascript'>
	Recaptcha.create("<?php echo $pbkey;?>", '<?php echo $divid;?>'<?php echo $jsobject;?>);
</script>
<noscript>
	<iframe src='http://www.google.com/recaptcha/api/noscript?k=<?php echo $pbkey;?>' height='300' width='500'></iframe>
	<br />
	<textarea name='recaptcha_challenge_field' rows='3' cols='40'></textarea>
	<input type='hidden' value='manual_challenge' name='recaptcha_response_field'/>
</noscript>


<?php
}

function easy_captcha_check_captcha_recaptcha($pageid) {
	$prefix = "easy_captcha-{$pageid}-";

	$hide = easy_captcha_get_setting("{$prefix}recaptcha_hide_for_logged_in", 'off');
	if ($hide == 'on'  && is_user_logged_in()) {
		return TRUE;
	}

	$pvkey = easy_captcha_get_setting("{$prefix}recaptcha_private_key", '');
	$result = FALSE;

	if (!empty($pvkey) && isset($_POST['recaptcha_response_field'])) {
		if(!function_exists('recaptcha_check_answer')) {
			require_once 'recaptchalib.php';
		}
		$resp = recaptcha_check_answer($pvkey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
		$result = $resp->is_valid;
	}

	return $result;
}


function easy_captcha_valideate_captcha_settings_recaptcha($pageid, $pages, $label, $errors) {
	$page = $pages[$pageid];

	$prefix = "easy_captcha-{$pageid}-";
	$pbkey = easy_captcha_get_setting("{$prefix}recaptcha_public_key", '');
	$pvkey = easy_captcha_get_setting("{$prefix}recaptcha_private_key", '');
	$message = __('Error on tab <strong>%s</strong>. <strong>%s</strong> is empty');

	if (empty($pbkey)) {
		$errors[]= sprintf($message, $page, __('reCaptcha Public key'));
	}

	if (empty($pvkey)) {
		$errors[]= sprintf($message, $page, __('reCaptcha Private key'));
	}

	return $errors;
}