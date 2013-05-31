<?php
/* 
Plugin Name: Easy Captcha
Plugin URI: http://wp-pal.com
Version: 1.0
Description: Adds captcha to the login, registration and comments page. 
Author: wppal
Author URI: http://wp-pal.com/
*/

require_once 'easy_captcha_utils.php'; 

add_action('admin_menu', 'easy_captcha_admin_menu_link');
add_action('wp_ajax_nopriv_easy-captcha-submit', 'easy_captcha_entrypoint');
add_action('wp_ajax_easy-captcha-submit', 'easy_captcha_entrypoint');	
			 
function easy_captcha_admin_menu_link() {
	add_options_page('Easy Captcha', 'Easy Captcha', 'manage_options', basename(__FILE__), 'easy_captcha_admin_options_page');
	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'easy_captcha_filter_plugin_actions', 10, 2 );
//	if ( function_exists('add_submenu_page') )
//		add_submenu_page('plugins.php', __('Easy Captcha'), __('Easy Captcha'), 'manage_options', 'easy-captcha-admin-page', 'easy_captcha_admin_options_page');
}
        
function easy_captcha_filter_plugin_actions($links, $file) {
    $settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
    array_unshift( $links, $settings_link );
	return $links;
}


function easy_captcha_entrypoint($map){
	$map = $_REQUEST;

	if (!isset($map['easy_captcha_type'])) {
		easy_captcha_update_settings($map);
	}
	else {

		$captcha = $map['easy_captcha_type'];
		$cfilename = "easy-captcha-{$captcha}.php";
		if (!file_exists(dirname(__FILE__) . "/$cfilename")) {
			exit();
		}
		require_once $cfilename;
		$fn = "easy_captcha_ajax_{$captcha}";
		$result =  $fn($map);
	}

	exit();
}


function easy_captcha_update_settings($map){
	foreach ($_REQUEST as $key => $value){
		$name = easy_captcha_cut_name($key);
		if (!$name) {
			continue;		 	
		}
		easy_captcha_set_setting($name, trim($value));
	}

	$pages = easy_captcha_get_avalable_pages();
	$errors = array();
	foreach ($pages as $pageid => $data) {

		$checkboxid = "easy_captcha-{$pageid}-checkbox";
		$cbpagechekedvalue = easy_captcha_get_setting($checkboxid, 'on');
		$cbpagechekedvalue = $cbpagechekedvalue === FALSE ? 'on' : $cbpagechekedvalue;

		if ($cbpagechekedvalue == 'off') {
			continue;
		}

		$captchas = easy_captcha_get_available_captchas($pageid);

		foreach ($captchas as $captcha => $clabel) {

			$radioname = "easy_captcha-{$pageid}";			 
			$activepagecaptcha = easy_captcha_get_setting($radioname);
			if ($activepagecaptcha != $captcha) {
				continue;
			}

			require_once "easy-captcha-{$captcha}.php";
			$fn = "easy_captcha_valideate_captcha_settings_{$captcha}";
			$errors = $fn($pageid, $pages, $clabel, $errors);
		}
	}
	if (count($errors) > 0) {
		$errors = '<p>' . implode('</p><p>', $errors) . '</p>';
		echo $errors;
	}
}


function easy_captcha_admin_options_page() {

	easy_captcha_scripts();	
	echo "<script>";
	echo "var easy_captcha_ajax='" . admin_url( 'admin-ajax.php' ) . "';";

	echo "</script>";


	$pages = easy_captcha_get_avalable_pages();

	$activepage = easy_captcha_get_setting('easy_captcha-active-page');


	echo "<div class='wrap'>";
		echo "<div id='easy_captcha-wrap'>";

			echo "<h1>" . __('Easy Captcha Settings') . "</h1>";
			echo "<p>" . __('Select a page to install a captcha on') . "</p>";

			echo "<div id='easy_captcha-disable'></div>";

			echo "<div id='easy_captcha-errors'></div>";

			echo "<input id='easy_captcha-active-page' type='hidden' class='easy_captcha-value'>";

            echo "<ul id='page-list-ul'>";

			foreach ($pages as $page => $plabel) {

	    		$pageid = easy_captcha_name2id($page);
				$activepage = empty($activepage) ? $pageid : $activepage;
				$activeclass = $activepage == $pageid ? ' easy_captcha-active' : '';

				$checkboxid = "easy_captcha-{$pageid}-checkbox";
				$aid = "easy_captcha-{$pageid}-a";
				$liid = "easy_captcha-{$pageid}-li";

				$cbpagechekedvalue = easy_captcha_get_setting($checkboxid, 'on');
				$cbpagechekedvalue = $cbpagechekedvalue === FALSE ? 'on' : $cbpagechekedvalue;

	
				$cbpagecheked = $cbpagechekedvalue == 'on' ? ' checked' : '';		
				$disabledclass = $cbpagechekedvalue == 'on' ? '' : ' easy_captcha-disabled';

				echo "<li id='{$liid}' class='easy_captcha-page-li{$activeclass}{$disabledclass}'>";
					echo "<a href='javascript:void(0);' id='{$aid}' class='easy_captcha-page-a'>";
						echo "<input type='checkbox' id='{$checkboxid}' name='{$checkboxid}'{$cbpagecheked} value='{$cbpagechekedvalue}' class='easy_captcha-page-checkbox easy_captcha-value'>";
						echo "<label>";
							echo $plabel;
						echo "</label>";
					echo "</a>";
				echo "</li>";
			} 

			echo "</ul>";

			echo "<div id='page-options-div'>";

			foreach ($pages as $page => $plabel) {
    			$pageid = easy_captcha_name2id($page);
				$activeclass = $activepage == $pageid ? " easy_captcha-active" : '';
			 
				$radioname = "easy_captcha-{$pageid}";			 
				
				$activepagecaptcha = easy_captcha_get_setting($radioname);
				$checkboxid = "easy_captcha-{$pageid}-checkbox";

				$cbpagechekedvalue = easy_captcha_get_setting($checkboxid, 'on');
				$pagedisabled = $cbpagechekedvalue != 'on';
				$disabled = $pagedisabled ? ' disabled' : '';
				$disabledclass = $pagedisabled ? ' easy_captcha-disabled' : '';

				$divid = "easy_captcha-{$pageid}-div";
			

				echo "<input type='hidden' id='{$radioname}' value='{$activepagecaptcha}' class='easy_captcha-value'>";

				echo "<div id='{$divid}' class='easy_captcha-page-options{$activeclass}{$disabledclass}'>";

					echo "<h2>{$plabel}</h2>";
					$selectcaptchamessage = __('Select type of captcha:');			
					echo "<p>{$selectcaptchamessage}</p>";

					echo "<div>";
				
						echo "<ul>";

						$captchas = easy_captcha_get_available_captchas($pageid);

						foreach ($captchas as $captcha => $clabel) {
							$captchaid = easy_captcha_name2id($captcha);					

							$activepagecaptcha = empty($activepagecaptcha) ? $captchaid: $activepagecaptcha;
							$activecaptchaclass = $activepagecaptcha == $captchaid ? " class='easy_captcha-active-captcha'" : '';			 
							
							$rbchecked = $activepagecaptcha == $captchaid ? ' checked' : '';			 
 
							echo "<li{$activecaptchaclass}>";
								echo "<label>";
									echo "<input type='radio' name='{$radioname}' id='{$radioname}-{$captchaid}' class='easy_captcha-value easy-captcha-options-radio'{$rbchecked}{$disabled}>";
									echo $clabel;
								echo "</label>";
							echo "</li>";
						}
						echo "</ul>";

						echo "<div class='clear-both'></div>";

						echo "<div style='padding:10px;'>";

						foreach ($captchas as $captcha => $clabel) {
							$captchaid = easy_captcha_name2id($captcha);					
							$activecaptchaclass = $activepagecaptcha == $captchaid ? ' easy_captcha-active-captcha' : '';			 
							echo "<div id='easy_captcha-{$pageid}-{$captchaid}-div' class='easy_captcha-{$pageid}-captcha-container easy_captcha-page-captcha-options{$activecaptchaclass}'>";
								require_once "easy-captcha-{$captchaid}.php";
								$fn = "easy_captcha_get_captcha_settings_{$captchaid}";
								$fn($pageid, $pagedisabled);
							echo "</div>";
						}
		
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
			echo "<button id='easy_captcha-submit'>" . __('Save Settings'). "</button>";
			echo "</div>";

			echo "<div class='clear-both'></div>";
		echo "</div>";//easy_captcha_wrap
	echo "</div>";//wrap

}

function easy_captcha_get_available_captchas($pageid) {
	$captchas = array();
	$captchas['hidden'] = __("Hidden");	
	$captchas['simple'] = __("Simple");	
	$captchas['recaptcha'] = __("reCaptcha");	
	return $captchas;
}

function easy_captcha_get_avalable_pages(){
	$pages = array();
	$pages['login_page'] = __('Login page');
	$pages['registration_page'] = __('Registration page');
	$pages['comments_form'] = __('Comments form');
	$pages['password_reset_page'] = __('Password reset page');
	return $pages;
}


easy_captcha_install_captcha();

function easy_captcha_install_captcha() {

	$pages =  easy_captcha_get_avalable_pages();
	foreach ($pages as $page => $plabel) {
   		$pageid = easy_captcha_name2id($page);

		$value = easy_captcha_get_setting("easy_captcha-{$pageid}-checkbox", 'on');
		if ($value != 'on') {
			continue;
		}

		require_once "easy_captcha_{$pageid}.php";
		$fn = "easy_captcha_install_captcha_{$pageid}";
		$fn();
	}
}


function easy_captcha_install_plugin() {
	$plugin_prefix_root = plugin_dir_path( __FILE__ );
	$plugin_prefix_filename = "{$plugin_prefix_root}/easy-captcha-install.php";
	include_once $plugin_prefix_filename;	
	easy_captcha_install();
}
	
function easy_captcha_uninstall_plugin() {
	$plugin_prefix_root = plugin_dir_path( __FILE__ );
	$plugin_prefix_filename = "{$plugin_prefix_root}/easy-captcha-install.php";
	include_once $plugin_prefix_filename;	
	easy_captcha_uninstall();
}	

register_activation_hook( __FILE__, 'easy_captcha_install_plugin' );
register_uninstall_hook( __FILE__, 'easy_captcha_uninstall_plugin' );
