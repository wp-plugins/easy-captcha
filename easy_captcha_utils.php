<?php
/**
 * @file
 * Easy Captcha. easy_captcha_utils.php
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easy_captcha_scripts() {
	
	if (is_admin()) {
		wp_enqueue_style( 'easy-captcha-style', plugins_url('css/style.css', __FILE__) );
		wp_enqueue_script('easy-captcha-js', plugins_url('js/script.js', __FILE__) );
	}
}



function easy_captcha_get_setting($key, $default = '') {

	global $wpmu;

	if ( $wpmu === 1 ) {
		$value = get_site_option($key); 
	}
	else {
		$value = get_option($key); 
	}

	if ($value === FALSE) {
		$value = $default;
		easy_captcha_set_setting($key, $value);
	}

	return $value;
}

function easy_captcha_set_setting($key, $value) {

//	if (empty($value)) {
//		return;
//	}

	global $wpmu;

	$fn_add = 'add_option';		
	$fn_update = 'update_option';		
	$fn_get = 'get_option';		
	if ( $wpmu === 1 ) {
		$fn_add = 'add_site_option';		
		$fn_update = 'update_site_option';		
		$fn_get = 'get_site_option';		
	}

	$currentvalue = $fn_get($key); 

	if ($currentvalue === FALSE) {
		$fn_add( $key, $value , '', 'no');
	}
	else {
		$fn_update( $key, $value );
	}

}

function easy_captcha_name2id($name) {

	$name = strtolower($name);
	$name = str_replace(' ', '_', $name);
	return $name;

}
function easy_captcha_element_id($name, $suffix = '') {
	if (!empty($suffix)){
		$suffix .= '-';
	}
	return 'easy_captcha-' . $suffix . easy_captcha_name2id($name);
}


function easy_captcha_element($name, $suffix = '', $disabled = false, $default = '') {
	
	$el = (object) array();
	$el->id = easy_captcha_element_id($name, $suffix) ;	
	$value = easy_captcha_get_setting($el->id);	
	$el->value = empty($value) ? $default : $value;	
	$el->disabled = $disabled ? ' disabled' : '';
	return $el;

}


function easy_captcha_input($el) {
echo <<<EOF
<tr>
	<td>
		<label style='display:block;width:120px' for='{$el->id}'>{$el->label}</label>
	</td>
	<td>
		<input style='width:350px' type='text' id='{$el->id}' value='{$el->value}'{$el->disabled} class='easy_captcha-value'>
	</td>
</tr>
EOF;
}

function easy_captcha_select($el) {

	$listoptions = '';
	foreach ($el->options as $key=>$presentation) {
		$selected = $key == $el->value ? ' selected' : '';
		$listoptions .= "<option value='{$key}'{$selected}>{$presentation}</option>";		
	}

echo <<<EOF
<tr>
	<td>
		<label style='display:block;width:120px;' for='{$el->id}'>{$el->label}</label>
	</td>
	<td>
		<select style='width:100px' id='{$el->id}'{$el->disabled} class='easy_captcha-value'>
			{$listoptions}
		</select>
	</td>
</tr>
EOF;
}

function easy_captcha_checkbox($el) {

	$checked = $el->value == 'on' ? ' checked' : '';
	$extraonchage = isset($el->onchange) ? $el->onchange : '';
	$onchange = " onchange='this.value = this.checked ? \"on\" : \"off\";{$extraonchage}'";

echo <<<EOF
<tr>
	<td>
		<label for='{$el->id}'>
			<input type='checkbox' id='{$el->id}' value='{$el->value}'{$checked}{$el->disabled}{$onchange} class='easy_captcha-value'>
			&nbsp;&nbsp;{$el->label}
		</label>
	</td>
	<td></td>
</tr>
EOF;
}

function easy_captcha_cut_name($name) {

	$str = 'easy_captcha-';
	$index = strpos($name, $str);
	if (($index !== FALSE) || ($index == 0)){
//		return substr($name, strlen($str));
		return $name;
	}
	return FALSE;

}

function easy_captcha_get_captcha_result($result, $string) {

	if ($result === TRUE) {
		return TRUE;
	}
	if ($result === FALSE) {
		return $string;
	}
	else {
		return $result;
	}

}

