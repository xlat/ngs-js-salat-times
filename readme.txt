=== NGS JS Salat Times ===
Contributors: nicolasngsma
Tags: salat times islam prayer adhan azan
Requires at least: 5.4.1
Tested up to: 5.5
Requires PHP: 7.0
Stable tag: 1.3
License: MIT
License URI: https://opensource.org/licenses/MIT

Provide Islamic Prayer Times computed on client side.

== Description ==
This plugins provide Islamic Prayer Times to be diplayed on sidebar or as short_code.
It is based on Javascript library [Adhan.js](https://github.com/batoulapps/adhan-js) 
and a fork of [moment-hijri](https://github.com/xlat/moment-hijri) .

== Installation ==
1. Download the plugin.
2. Go to: Dashboard > Plugins > Add New > Upload.
3. Upload, install and activate the plugin.
4. Done!
5. Use widget: "NGS JS Salat Times".

== Contributions ==
In addition to the official SVN repository which is designed to release, 
there is a [github repo](https://github.com/xlat/ngs-js-salat-times.git)
So if you want to contribute feel free to fork it and submit a pull request.

== Frequently Asked Questions ==
=How to start?=
- Install and activate the plugin.
- Navigate to: Settings > NGS JS Salat Times.
- Use widget or shortcode.
=How does it work?=
- Widget: "NGS JS Salat Times", "NGS JS Daily Salat Times"
- Shortcodes: 
  `[ngs_js_salat_times]`
  `[ngs_js_daily_salat_times]`
- PHP Code: 
  `< ?php echo do_shortcode('[ngs_js_salat_times]'); ? >`
  `< ?php echo do_shortcode('[ngs_js_daily_salat_times]'); ? >`

== Screenshots ==
1. Monthly Widget preview
2. Daily Widget preview
3. Settings - Location, Calculation
4. Settings - Calculation
5. Settings - Locales Settings
6. Settings - Hijri Date Adjustments, Widget Style

== Changelog ==
= 1.3 =
* realtime refresh daily salat widget
* add undescore tempalte supports to customize widgets
* fix hijri_adjustment Settings
* add preview pane on plugin settings page
* add I18N supports
= 1.2 =
* fix error on short_code
* fix javascript error in admin pages
= 1.1 =
* First release.

== Upgrade Notice ==

= 1.2 =
This version fixes a bug in Shortcodes within admin pages

