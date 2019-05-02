=== Klaviyo for WooCommerce ===
Contributors: bialecki
Donate link: https://www.klaviyo.com
Tags: analytics, email, marketing, klaviyo, woocommerce
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.0.0

Easily integrate Klaviyo with your WooCommerce stores. Makes it simple to send abandoned cart emails, add a newsletter sign up to your site and more.


== Description ==

By adding the Klaviyo plugin, you'll allow Klaviyo to connect with your WooCommerce store. This will send data about abandoned carts, orders, customers and products to Klaviyo so you can easily set up newsletters and automated emails to grow your business.

**Features**

Klaviyo for WooCommerce has the following features:

- Tracks when customers start checking out and complete checkouts so you can send abandoned cart emails.
- Embed a customized email sign up, customizing the title, description and button text.

**Usage**

Install the Klaviyo for WooCommerce plugin. In your Klaviyo account, enter your WooCommerce API keys. After that you'll see WooCommerce data in Klaviyo and you can set up abandoned cart emails with product images and your store's branding.

To add a newsletter sign up, select the Klaviyo email sign up widget from the Appearance > Widgets section.


== Installation ==

1. Upload the folder `woocommerce-klaviyo` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin at Options > Klaviyo


== Frequently Asked Questions ==

= Where is the Klaviyo code added? =

Our analytics code is added to the &lt;head&gt; section of your theme by default. It should be somewhere near the bottom of that section.

== Screenshots ==


== Changelog == 
= 1.0 =
* Initial version
= 2.0 =
* An option to Add a checkbox at the end of the billing form that can be configured to sync with a specified Klaviyo list. The text can be configured in the settings. Currently set to off by default.
*Install the Klaviyo pop-up code by clicking a checkbox in the admin UI
*Automatically adds the viewed product snippet to product pages.
*Adds product categories which can be segmented to the started checkout metric.
*Removes the old unused code and functions.
*Updates all deprecated WC and Wordpress functions/methods.
*Bundles the Wordpress and Woocommerce plugin together as one.
*Removes the description tag from the checkout started event.
*Captures first and last names to the started check out metric.
= 2.0.1 =
* Compatability for PHP 7.2 and remove PHP warnings
* Add persistent cart URL for rebuilding abandoned carts
* Add support for composite product cart rebuild