/**
 * @file
 * Easy Captcha. script.js
 */
/*  Copyright Georgiy Vasylyev, 2008-2013 | http://wp-pal.com  
 * -----------------------------------------------------------
 * Easy Captcha
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

function easyCaptchaBaseId(el){
	var baseid = el.id.split('-');
	baseid.pop();
	return baseid.join('-');
}

function easyCaptchaId(baseid, suffix, skipPrefix){
	var prefix = skipPrefix || '#';
	if (typeof(baseid) == 'string') {
		return prefix + baseid + '-' + suffix;
	}
	else {
		return prefix + easyCaptchaBaseId(baseid) + '-' + suffix;
	}
}

function easyCaptchaPageId(baseid){
	var pageidarray = baseid.split('-');
	var pageid = [];

	for (var i = 1; i < pageidarray.length - 1; i++) {
		pageid[i - 1]=pageidarray[i]; 
	}

	pageid = pageid.join('-');			
	return pageid;
}

jQuery(document).ready(function(){

	jQuery('#easy_captcha-submit').click(function(){
		easyCaptchaSave();		
	});

	jQuery('.easy-captcha-options-radio').change(function(){

		var div_class = easyCaptchaBaseId(this);
		jQuery('div.'+div_class+'-captcha-container').removeClass('easy_captcha-active-captcha');

		jQuery(easyCaptchaId(this.id, 'div')).addClass('easy_captcha-active-captcha');

		var pageid = easyCaptchaPageId(this.id);			
		var captchaid = this.id.split('-');
		captchaid = captchaid.pop();

		jQuery('#easy_captcha-'+pageid).val(captchaid);

	});

	jQuery('.easy_captcha-page-a').click(function(){

		jQuery('.easy_captcha-page-li').removeClass('easy_captcha-active');
		jQuery(easyCaptchaId(this, 'li')).addClass('easy_captcha-active');

		jQuery('.easy_captcha-page-options').removeClass('easy_captcha-active');
		jQuery(easyCaptchaId(this, 'div')).addClass('easy_captcha-active');

		var pageid = easyCaptchaPageId(this.id);			
		jQuery('#easy_captcha-active-page').val(pageid);

	});


	jQuery('.easy_captcha-page-checkbox').change(function(){

		var checkboxid = '#'+this.id;

		var checkboxvalue = jQuery(checkboxid).val() == 'on' ? 'off' : 'on';
		jQuery(checkboxid).val(checkboxvalue);

		var liid =  easyCaptchaId(this, 'li');
		var divid =  easyCaptchaId(this, 'div');
		var scid =  easyCaptchaId(this, 'check_cookies');
		var cjid =  easyCaptchaId(this, 'check_javascript');

		if (jQuery(this).is(':checked')){
			jQuery(divid).removeAttr('disabled');			
			jQuery(divid+' :input').removeAttr('disabled');			
			jQuery(scid).attr('disabled', !jQuery(cjid).attr('checked'));			
			jQuery(divid).removeClass('easy_captcha-disabled');			
			jQuery(liid).removeClass('easy_captcha-disabled');			
		}
		else {
			jQuery(divid).attr('disabled', true);			
			jQuery(divid+' :input').attr('disabled', true);			
			jQuery(divid).addClass('easy_captcha-disabled');			
			jQuery(liid).addClass('easy_captcha-disabled');			
		}

		jQuery(easyCaptchaId(this, 'a')).click();
	});

	jQuery(document).ajaxStop(function(){
		easyCaptchaEnable();
	});

});

function easyCaptchaSave() {
	easyCaptchaDisable();	
	var ajaxConf = {};
	ajaxConf.data = {};
	ajaxConf.data.action = 'easy-captcha-submit';
	jQuery('.easy_captcha-value').each(function(index, el){
		//if (jQuery(el).attr('disabled') != 'disabled') {
			ajaxConf.data[el.id] = el.value;		
		//}
	});
	ajaxConf.url = easy_captcha_ajax;
	ajaxConf.type = 'POST';

	function fsuccess(data){
		$errordiv = jQuery('#easy_captcha-errors');
		if (data.length > 0) {
			$errordiv.html(data);			
			$errordiv.fadeIn();
		}
		else {
			$errordiv.html('');			
			$errordiv.fadeOut();
		}
	}

	ajaxConf.success = fsuccess;

	jQuery.ajax(ajaxConf);
}

function easyCaptchaEnable(){
	jQuery('#easy_captcha-disable').fadeOut();	
}

function easyCaptchaDisable(){
	jQuery('#easy_captcha-disable').show();	
}

