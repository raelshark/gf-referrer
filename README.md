# GF-Referrer

A WordPress plugin that adds a custom Gravity Forms field to capture the user's referrer URL.

## Purpose

Gravity Forms contains a {referer} merge tag that can be added to a Hidden field to dynamically populate the referrer, but their merge tag uses the information provider by your server in the http_referer header which only reports the last URL the user visited before submitting the form. If your user navigated through your site before filling out the form the referrer URL would just be the previous page on your site. That's not very useful if your goal is to determine how the user found your site in the first place.

This WordPress plugin allows you to populate your form entry with the URL that referred the user to your site so you can easily see if they came from a search engine such as Google, an ad from something like Google AdWords, social media, and so on.

## Installation

1. Download the files and copy them to a `gf-referrer` folder in your site's `/wp-content/plugins` folder, or ZIP them up to upload directly into WordPress (`Plugins > Add New`). Activate the plugin after installing it.

2. Navigate to the Gravity Forms area and add or edit a Form. There will be a new field type under `Advanced` called `Referrer`. Drag the field onto your form.

![screenshot 2017-09-29 05 08 43](https://user-images.githubusercontent.com/1673734/31009138-77565fb6-a4d4-11e7-8b93-454ad073c6c7.png)

3. If you want, customize the label for the field, then `Update` the form.

![screenshot 2017-09-29 05 09 11](https://user-images.githubusercontent.com/1673734/31009139-7756cb54-a4d4-11e7-84cc-4af45c11a11d.png)


When a user visits your site, a session value containing their HTTP referrer header value will be created. Then, when the user submits the form containing this custom field on your site, the custom field will be populated with that setting. By keeping the referrer value in the user's session, the plugin ensures only the original referring URL is saved, then remembered as the user navigates through the site until they submit the form.

## Technical Notes:

- The plugin will first check for the `HTTP_REFERER` PHP environment variable, then will fall back to `X-FORWARDED-FOR` environment variable in case the user or website is behind a proxy. If neither are found, the session value is left empty.

- If `WP_DEBUG_LOG` is enabled in the site's `wp-config.php` file, details of the referrer detection and field population during form submit will be displayed there. Please provide these log details when asking for help.
