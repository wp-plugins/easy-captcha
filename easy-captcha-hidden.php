<?php
/**
 * @file
 * Easy Captcha. easy-captcha-hidden.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_get_captcha_settings_hidden($pageid, $disabled) {

	$min_completion_time = easy_captcha_element('min_completion_time', $pageid, $disabled);
	$min_completion_time->label = __('Min completion time');
	$min_completion_time->hint = __('Min completion time');

	$max_completion_time = easy_captcha_element('max_completion_time', $pageid, $disabled);
	$max_completion_time->label = __('Max completion time');
	$max_completion_time->hint = __('Max completion time');

	$check_javascript = easy_captcha_element('check_javascript', $pageid, $disabled, 'off');
	$check_javascript->label = __('Check JavaScript');
	$check_javascript->hint = __('Check JavaScript');

//	$cookie_check_id = easy_captcha_element_id('check_cookies', $pageid);
//	$check_javascript->onchange = 
//	"var sc = jQuery(\"#{$cookie_check_id}\");if (!this.checked) {sc.val(\"off\");sc.attr(\"checked\",false);sc.attr(\"disabled\",true);} else {sc.attr(\"disabled\",false);}";

//	$prefix = "easy_captcha-{$pageid}-";
//	$scenabled = !$disabled && easy_captcha_get_setting("{$prefix}check_javascript", 'off') == 'on';
//	$check_cookies = easy_captcha_element('check_cookies', $pageid, !$scenabled, 'off');
//	$check_cookies->label = __('Check Cookies');
//	$check_cookies->hint = __('Check Cookies');

	echo "<table>";
	easy_captcha_input($min_completion_time);	
	easy_captcha_input($max_completion_time);	
	easy_captcha_checkbox($check_javascript);	
//	easy_captcha_checkbox($check_cookies);	
	echo "</table>";

}

function easy_captcha_show_captcha_hidden($pageid) {

	echo "<link rel='stylesheet' href='" . plugins_url('css/client-style.css', __FILE__) . "' type='text/css' />";

	$pwd = NONCE_SALT;
	$pwd2 = LOGGED_IN_SALT;

	$prefix = "easy_captcha-{$pageid}-";
	

	$check_javascript = easy_captcha_get_setting("{$prefix}check_javascript", 'off');

	if ($check_javascript == 'on') {

		$jsfunction = easy_captcha_get_js_hidden();	
		$jsfunctionresult = md5('easy_captcha' . $pwd . $pwd2 . $jsfunction->result);

		echo "<noscript><strong>" . __('Please enable JavaScript to make a form submission'). "</strong></noscript>";
		echo "<input type='hidden' id='easy_captcha_js_check1' name='easy_captcha_js_check1' value='{$jsfunctionresult}'>";
		echo "<input type='hidden' id='easy_captcha_js_check2' name='easy_captcha_js_check2'>";
		echo "<script>";
		echo "{$jsfunction->code};document.getElementById('easy_captcha_js_check2').value = getEasyCaptureResult();";
		
		//$check_cookies = easy_captcha_get_setting("{$prefix}check_cookies", 'off');
		if (false && $check_cookies == 'on') {
			//thanks to Sveinbjorn Thordarson at http://sveinbjorn.org
			echo "function getEasyCaptureCookieEanbled(){";
				echo "var cookieEnabled = (navigator.cookieEnabled) ? true : false;";
				echo "if (typeof navigator.cookieEnabled == \"undefined\" && !cookieEnabled) {"; 
					echo "document.cookie=\"testcookie\";";
					echo "cookieEnabled = (document.cookie.indexOf(\"testcookie\") != -1) ? true : false;";
				echo "}";
				echo "if (cookieEnabled) {"; 
					echo "document.cookie=\"testcookie=;expires=Thu, 01 Jan 1970 00:00:01 GMT;\";";
				echo "}";
				echo "else {"; 
					echo "alert('" . __('Please enable cookies to make a form submission'). "')";
				echo "}";
			echo "};";	
			echo "getEasyCaptureCookieEanbled();";
			echo "document.cookie = 'easy_captcha_js_check2=' + getEasyCaptureResult();";
		}

		echo "</script>";

	}

		
	$min_completion_time = easy_captcha_get_setting("{$prefix}min_completion_time", '');
	$max_completion_time = easy_captcha_get_setting("{$prefix}max_completion_time", '');
	if (!empty($min_completion_time) || !empty($max_completion_time)) {

		$hiddenid = md5('easy_captcha' . $pwd . $pwd2);
		$time = time();
		$sign = md5("{$pwd}{$pwd2}_{$time}");
		echo "<input type='hidden' id='{$hiddenid}' name='{$hiddenid}' value='{$sign}_{$time}'>";
	}

}

function easy_captcha_check_captcha_hidden($pageid) {

	$pwd = NONCE_SALT;
	$pwd2 = LOGGED_IN_SALT;
	$prefix = "easy_captcha-{$pageid}-";
	


	$check_javascript = easy_captcha_get_setting("{$prefix}check_javascript", 'off');
	if ($check_javascript == 'on') {

		if (!isset($_REQUEST['easy_captcha_js_check1']) || !isset($_REQUEST['easy_captcha_js_check2'])){
			return FALSE;
		}
		
		$easy_captcha_js_check2 = md5('easy_captcha' . $pwd . $pwd2 . $_REQUEST['easy_captcha_js_check2']);
		if ($easy_captcha_js_check2 != $_REQUEST['easy_captcha_js_check1']) {
			return FALSE;
		}

		//$check_cookies = easy_captcha_get_setting("{$prefix}check_cookies", 'off');

		if (false && $check_cookies == 'on') {

			if (!isset($_COOKIE['easy_captcha_js_check2'])){
				return FALSE;
			}

			$easy_captcha_js_check2 = md5('easy_captcha' . $pwd . $pwd2 . $_COOKIE['easy_captcha_js_check2']);

			if ($easy_captcha_js_check2 != $_REQUEST['easy_captcha_js_check1']) {
				return FALSE;
			}
		}

	}


	$min_completion_time = intval(easy_captcha_get_setting("{$prefix}min_completion_time", ''));
	$max_completion_time = intval(easy_captcha_get_setting("{$prefix}max_completion_time", ''));

	if (!empty($min_completion_time) || !empty($max_completion_time)) {
		$hiddenid = md5('easy_captcha' . $pwd . $pwd2);

		if (!(isset($_REQUEST[$hiddenid]) || empty($_REQUEST[$hiddenid]))){
			return FALSE;
		}

		$clienttime = $_REQUEST[$hiddenid];
		$time = explode('_', $clienttime);
		
		if (sizeof($time) != 2) {
			return FALSE;
		}

		$sign = $time[0];		
		$time = $time[1];		

		$testsign = md5("{$pwd}{$pwd2}_{$time}");
		if ($testsign != $sign) {
			return FALSE;
		}
	
		$delta = time() - intval($time);

		$message = __('Please try to fill in and submit the form again');

		if (!empty($min_completion_time) && $delta < $min_completion_time) {
			return $message;
		}

		if (!empty($max_completion_time) && $delta > $max_completion_time) {
			return $message;
		}
		
	}
	return TRUE;
}

function easy_captcha_valideate_captcha_settings_hidden($pageid, $pages, $clabel, $errors) {
	$page = $pages[$pageid];

	$prefix = "easy_captcha-{$pageid}-";
	$min_completion_time = easy_captcha_get_setting("{$prefix}min_completion_time", '');
	$max_completion_time = easy_captcha_get_setting("{$prefix}max_completion_time", '');
	
	$intval = intval($min_completion_time);
	$minincorrect =  !empty($min_completion_time) && (string) $intval != $min_completion_time;
	if ($minincorrect) {
		$message = __('Error on tab <strong>%s</strong>. "%s" is incorrect integer value for <strong>%s</strong>');
		$errors[]= sprintf($message, $page, $min_completion_time, __('Min completion time'));
	}

	$intval = intval($max_completion_time);
	$maxincorrect =  !empty($max_completion_time) && (string) $intval != $max_completion_time;
	if ($maxincorrect) {
		$message = __('Error on tab <strong>%s</strong>. "%s" is incorrect integer value for <strong>%s</strong>');
		$errors[]= sprintf($message, $page, $max_completion_time, __('Max completion time'));
	}

	if (!$maxincorrect && !$minincorrect && !empty($max_completion_time) && intval($max_completion_time) < intval($min_completion_time)) {
		$message = __('Error on tab <strong>%s</strong>. %s < %s');
		$errors[]= sprintf($message, $page, __('Max completion time'), __('Min completion time'));
	}

	return $errors;
}

function easy_captcha_get_js_hidden() {
	$operations = array('+', '-', '*');

	$numbers = array();
	for ($i = 0; $i < 4; $i++) {
		$numbers[] = rand(1,200);
	}


	$operations3 = array();
	$result = 0;
	foreach ($numbers as $number) {
		$opnumber = rand(0, sizeof($operations) - 1);
		switch($opnumber) {
			case 0:
			$result += $number;
			$operations3[] = $operations[$opnumber];
			break;				
			case 1:
			$result -= $number;
			$result = abs($result);
			$operations3[] = $operations[$opnumber];
			break;				
			case 2:
			$result *= $number;
			$operations3[] = $operations[$opnumber];
			break;				
		}		
	}

	$jscode = '0';
	for ($i = 0; $i < count($numbers); $i++) {
		$abs = $operations3[$i] == '-' ? 'Math.abs' : '';
		$l = $operations3[$i] == '*' ? '' : '(';
		$r = $operations3[$i] == '*' ? '' : ')';
		$jscode = "{$abs}{$l}". $jscode . $operations3[$i] ."v[{$i}]{$r}";
	}                	

	$jscode = "return {$jscode};";
	$jscode = "var v = [" . implode(', ', $numbers). "];{$jscode}";
	$jscode = "function getEasyCaptureResult(){{$jscode}}";

	return (object)array('result' => $result, 'code' => $jscode);	

}