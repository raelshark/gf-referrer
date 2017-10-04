=== Gravity Forms Advanced Referrer Field ===
Contributors: raelshark, sc456a
Tags: gravity-forms, referer, referrer
Requires at least: 4.7
Tested up to: 4.8
Stable tag: 1.0.1
Requires PHP: 5.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds an additional field in Gravity Forms which reliably populates the referring URL.

== Description ==

Gravity Forms contains a {referer} merge tag that can be added to a Hidden field to dynamically populate the referrer, but their merge tag uses the information provider by your server in the http_referer header which only reports the last URL the user visited before submitting the form. If your user navigated through your site before filling out the form the referrer URL would just be the previous page on your site. That's not very useful if your goal is to determine how the user found your site in the first place.

This WordPress plugin allows you to populate your form entry with the URL that referred the user to your site so you can easily see if they came from a search engine such as Google, an ad from something like Google AdWords, social media, and so on.

Questions? Comments? Want to contribute? Please feel free to discuss on [Github] (https://github.com/raelshark/gf-referrer).

== Technical Notes ==

* The plugin will first check for the HTTP_REFERER PHP environment variable, then will fall back to X-FORWARDED-FOR environment variable in case the user or website is behind a proxy. If neither are found, the session value is left empty.
* If WP_DEBUG_LOG is enabled in the site's wp-config.php file, details of the referrer detection and field population during form submit will be displayed there. Please provide these log details when asking for help.

== Installation == 

1. Upload the plugin files to the `/wp-content/plugins/gf-referrer` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to the Gravity Forms area and add or edit a Form. There will be a new field type under Advanced called Referrer. Drag the field onto your form.
4. If you want, customize the label for the field, then Update the form.

When a user visits your site, a session value containing their HTTP referrer header value will be created. Then, when the user submits the form containing this custom field on your site, the custom field will be populated with that setting. By keeping the referrer value in the user's session, the plugin ensures only the original referring URL is saved, then remembered as the user navigates through the site until they submit the form.

== Changelog ==

1.0.1 - Initial release
