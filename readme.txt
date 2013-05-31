=== Easy Captcha ===                                    
Contributors: wppal
Donate link: http://wp-pal.com
Tags: captcha, reCaptcha, antispam, comments, security, spam, anti-spam, antispam, comment, lost password, wordpress captcha, login, re captcha
Requires at least: 3.4
Tested up to: 3.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Several types of captcha to protect your site in one easy to use plugin.

== Description ==

Easy Captcha is an ideal solution for those who want to try different types of captcha to achieve an optimal site usability and captcha protection ratio. It allows a Wordpress site owner to choose which captcha should be used on a particular page.

Currently the plugin supports 3 types of captcha:

- Hidden captcha, 
- Simple image captcha,
- Google reCaptcha

**Hidden Captcha** is invisible to site visitors and does not assume any specific user actions. It just checks that a visitor behaves like a human. Although it might seem that Hidden Captcha does not fully correspond to the definition of CAPTCHA (found at the end of the FAQ), it still distinguishes a human from a bot based on natural human behavior. Hidden Captcha also allows checking whether a visitor's browser has JavaScript and Cookies enabled. 

**Simple Captcha** works in a traditional manner: it shows an image and requires a user to enter a captcha code. Simple Captcha stores captcha values on the server side using a custom session approach. 

**reCaptcha** is a reliable and powerful captcha service provided by Google for free.  Please visit [reCaptcha site]( http://google.com/recaptcha) for more details

Any type of captcha from above may be added to the following Wordpress site places:

- Comment forms,
- Login page,
- Registration page,
- Password reset page. 

With Easy Captcha you can easily install different types of captcha on each individual page. 

Please read the FAQ and Installation sections for more details. 

== Installation ==

1. Download Easy Captcha using standard Wordpress tools and install the plugin.
2. Click Activate.
3. Test your Easy Captcha installation:

* Open Settings -> Easy Captcha.
* Uncheck checkboxes on the left on the Login page, Registration page, and Password reset page tabs. 
* Select the Simple Captcha radio button on the Comments form tab. 
* Uncheck the 'Hide captcha for logged in users' checkbox on the Simple Captcha page. 
* Open any page or post. Go down to the comment form, enter the captcha value and submit a new comment.
* That's it. Easy Captcha is installed. Please read the FAQ and happy capturing.


== Frequently Asked Questions ==

= 1. Easy Captcha General: The plugin allows to select a type of captcha. Which captcha should I use? =

The answer to this question depends on what you are going to use the captcha for. 
Hidden captcha has no usability drawbacks while reCaptcha provides much better protection.  Simple Captcha lies somewhere in the middle.


= 2. Easy Captcha General: After I uncheck a checkbox on the left the whole page becomes disabled. What does it mean? =

It means that a captcha will not be added to the corresponding page.

= 3. Hidden Captcha: What is the Check JavaScript and Check Cookies options? What are they for? =

Hidden Captcha allows to check whether a visitor's browser has JavaScript and cookies turned on. Usually spam bots do not have JavaScript and cookies enabled.

= 4. Hidden Captcha: What are the Minimum and Maximum Completion Time parameters?  =

These are numeric values which Easy Captcha uses as a minimum and maximum amount of time (in seconds) a human visitor should spend to complete a form.

= 5. Simple Captcha: What is the 'Hide captcha for logged in users' option? =

When this option is set a captcha will not be used for known users.

= 6. Simple Captcha: What the Label field is for? =

This field allows to display an invitation to enter a captcha value. It may be blank.

= 7. reCaptcha:  Is there any difference between the Label field and 'Hide captcha for logged in users' options found on the reCaptcha and Simple Captcha setting pages? =

These settings are similar. Please see their descriptions in the Simple Captcha FAQ section.

= 8. reCaptcha:  What Private and Public keys are for? =

Private and Public keys are required fields. They are used to encode and transfer captcha values to Google API.

= 9. reCaptcha:  Why the captcha window does not display on my page? =

There are several possible reasons.

- Please check that the private and public keys on the settings page are exactly same to the keys obtained from Google.
- reCaptcha depends on Google API, so please check the internet connection and make sure that the API is working.

= 10. reCaptcha:  Can I change captcha window color and language? =

Yes. Please use the Theme and Language lists, found on the reCaptcha setting page, to customize how the captcha window looks.

= 11. Easy Captcha General:  The administrative part of the plugin is not working. What should I do? =

Easy Captcha is using AJAX to communicate to the server. Please make sure that JavaScript is enabled, and the browser's Java Script console window does not show any errors.

= 13. Easy Captcha General:  Does Easy Captcha use database? =

Yes. Easy Captcha installation procedure adds one table and several tens of options to the wp_options table. When Easy Captcha is being uninstalled, the uninstallation routine removes the new table and options. 

= 13. Easy Captcha General:  Does Easy Captcha use database? =

Yes. Easy Captcha installation routine adds one table and several tens of options to the wp_options table. When Easy Captcha is being uninstalled,  the uninstallation routine removes the new table and options. 

= 14. Easy Captcha General:  What is planned to the next release? =
We plan to add a new "Skip for logged in users" option to Hidden Captcha. 
We plan to add a new cookie check feature to Hidden Captcha. 
We plan to optimize the Hidden Captcha's client side part. 
We plan to add a new type of hidden captcha optimized for the Login and Registration pages. 

= What is CAPTCHA at all? =
From [__Wikipedia.org__](http://en.wikipedia.org/wiki/CAPTCHA):

> A CAPTCHA is a type of challenge-response test used in computing as an attempt to ensure that the response is generated by a human being.  A CAPTCHA is a test which is designed to be difficult for a computer to solve, but easy for a human.   

>The term "CAPTCHA" was coined in 2000 by Luis von Ahn, Manuel Blum, Nicholas J. Hopper, and John Langford (all of Carnegie Mellon University). CAPTCHA is an acronym based on the word "capture" and standing for "Completely Automated Public Turing test to tell Computers and Humans Apart"

>A common type of CAPTCHA requires the user to type letters and/or digits from a distorted image that appears on the screen.  Different types of CAPTCHA can be used to minimize automated posting to blogs, forums and wikis, whether as a result of commercial promotion, or harassment and vandalism. 


== Screenshots ==

1. Easy Captcha Login page. Hidden Captcha settings
2. Easy Captcha Comment form. Simple Captcha settings
3. Easy Captcha Registration page. reCaptcha settings
4. Easy Captcha. 2 disabled pages. Captcha for these pages is skipped
5. Easy Captcha data validation messages
6. Easy Captcha. reCaptcha Example

== Changelog ==

= Easy Captcha. 0.8 =
* Simple Captcha: added

= Easy Captcha. 0.9 =
* reCaptcha: added

= Easy Captcha. 1.0 =
* Hidden Captcha: setting validation is added
* Hidden Captcha: cookies check is added
* reCaptcha: setting validation is added
* Easy Captcha public release.

== Upgrade Notice ==
Initial public Easy Captcha release
