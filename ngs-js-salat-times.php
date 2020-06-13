<?php
/**
 * Plugin Name: NGS JS Salat Times
 * Plugin URI: https://ngs.ma/index.php/js-salat-times-wp-plugin/
 * Description: Yet Another Salat Times Wordpress Plugin.
 * Author: Nicolas Georges (nicolas@ngs.ma)
 * Version: 1.2
 * Author URI: https://ngs.ma
 * License: MIT 
 * License URI: https://opensource.org/licenses/MIT
 * Date: 2020-05-30
 * Plugin Id: ngs-js-salat-times
 * Source: https://github.com/xlat/ngs-js-salat-times.git
 */

/* 
  Copyright 2020 Nicolas Georges

  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
  to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
  and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS 
  IN THE SOFTWARE.
*/

// Bismillah!
defined( 'ABSPATH' ) or die( '&#128680; ' . __('Bas les pattes!', 'ngs-js-salat-times') );

function ngs_js_salat_times_options() {
  $default = array( 
    'wgt_title1' => __('Monthly Salat Times', 'ngs-js-salat-times'),
    'wgt_title2' => __('Daily Salat Times', 'ngs-js-salat-times'),
    'latitude' => 49.208505,
    'longitude' => 6.160269,
    'location' => 'Maizières-Lès-Metz',
    'locale' => 'fr',
    'timezone' => 'Europe/Paris',
    'calculation_method' => 'NorthAmerica',
    'madhab' => 'Shafi',
    'high_latitude_rule' => 'TwilightAngle',
    'isha_interval' => '',
    'fajr_angle' => '',
    'isha_angle' => '',
    'fajr_adjustment' => '',
    'sunrise_adjustment' => '',
    'dhuhr_adjustment' => '',
    'asr_adjustment' => '',
    'maghrib_adjustment' => '',
    'isha_adjustment' => '',
    'hijri_adjustment' => '',
    'date_format' => 'dddd D MMMM YYYY',
    'time_format' => 'HH:mm',
    'hijri_format' => 'iD iMMMM iYYYY',
    'headers' => join('|', array( 
        __('JOUR', 'ngs-js-salat-times'),
        __('SUBH', 'ngs-js-salat-times'),
        __('SHURUQ*', 'ngs-js-salat-times'),
        __('ZHUR', 'ngs-js-salat-times'),
        __('ASR', 'ngs-js-salat-times'),
        __('MAGHRIB', 'ngs-js-salat-times'),
        __('ISHA', 'ngs-js-salat-times'),
        '&#9194; ' . __('Previous Month', 'ngs-js-salat-times'),
        __('Next Month', 'ngs-js-salat-times') . ' &#9193;',
        __('HIJRI', 'ngs-js-salat-times'),
      )),
    'css' => ngs_js_salat_times_css(),
   );
  $options = get_option("njs_js_salat_times_options");
  if ( !is_array( $options ) ) {
    $options = $default;
  }

  //set non existing values (in cas of new settings in newer version)
  foreach($default as $k => $v) {
    if(!array_key_exists($k, $options)) {
      $options[$k] = $v;
    }
  }
  return $options;
}

function ngs_js_salat_times_css () {
  return '
  table.ngsjsst-salats {
    border: 1px solid black;
    background-color: #7ec9e7;
    font-size: 0.5em; /* small */
    color: black;
  }
  table.ngsjsst-salats th {
    background-color: white;
    text-align: center;
    font-size: x-small;
    padding: 0px !important;
  }    
  table.ngsjsst-salats td {  
    padding-top: 0px !important;
    padding-bottom: 0px !important;
    padding-left: 10px;
    padding-right: 10px;
  }    
  table.ngsjsst-salats tr.ngsjsst-odd {
    background-color: #2299c9;
  }
  table.ngsjsst-salats tr.ngsjsst-today {
    color: #ffffff;
    background-color: #111111;
  }

  table.ngsjsst-salats td.ngsjsst-day {
  }

  table.ngsjsst-salats td.ngsjsst-time {
    text-align: center;
  }
  ';
}

function ngs_js_salat_times() {
  $jsst_options = ngs_js_salat_times_options();
  $sc = '<div class="ngs-js-salat-time-anchor"';
  #for each options in $jsst_options add an attribut
  foreach($jsst_options as $name => $value) {
    if($name != "css") {
      $value = htmlentities($value, ENT_HTML5, 'UTF-8' );
      $sc .= "\t$name=\"$value\"\n";
    }
  }
  $sc .= '></div>';
  return $sc;
}

function widget_ngs_js_salat_times( $args ) {
  extract($args);
  $jsst_options = ngs_js_salat_times_options();
  echo $before_widget;
  echo $before_title . $jsst_options[ 'wgt_title1' ] . $after_title;
  ?>
  <ul><?php echo ngs_js_salat_times(); ?></ul>
  <?php
  echo $after_widget;
}

function widget_ngs_js_salat_times_control() {
  $jsst_options = ngs_js_salat_times_options();
  ?>
  <p>
  <table width="100%">
    <tr>
      <td><?php _e('Widget Title:', 'ngs-js-salat-times') ?></td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['wgt_title1']; ?>
        </span>
      </td>
    </tr>
    <tr>
      <td><?php _e('Location Name:', 'ngs-js-salat-times') ?></td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['location']; ?>
        </span>
      </td>
    </tr>
  </table>
  </p>
  <p><span style="color: gray;"><?php _e('Go to: Settings', 'ngs-js-salat-times') ?> &gt; <a href="<?php admin_url(); ?>options-general.php?page=ngs_js_salat_times"><?php _e('NGS JS Salat Times', 'ngs-js-salat-times'); ?></a> <?php _e('to change options.', 'ngs-js-salat-times') ?></span>
  </p>
  <?php
}

function ngs_js_daily_salat_times() {//($atts, $content, $shortcode_tag)
  $jsst_options = ngs_js_salat_times_options();
  $sc = '<div class="ngs-js-salat-time-anchor" daily="true" ';
  #for each options in $jsst_options add an attribut
  foreach($jsst_options as $name => $value) {
    if($name != "css") {
      $value = htmlentities($value, ENT_HTML5, 'UTF-8' );
      $sc .= "\t$name=\"$value\"\n";
    }
  }
  $sc .= '></div>';
  return $sc;
}

function widget_ngs_js_daily_salat_times( $args ) {
  extract($args);
  $jsst_options = ngs_js_salat_times_options();
  echo $before_widget;
  echo $before_title . $jsst_options[ 'wgt_title2' ] . $after_title;
  ?>
  <ul><?php echo ngs_js_daily_salat_times(); ?></ul>
  <?php
  echo $after_widget;
}

function widget_ngs_js_daily_salat_times_control() {
  $jsst_options = ngs_js_salat_times_options();
  ?>
  <p>
  <table width="100%">
    <tr>
      <td><?php _e('Widget Title:', 'ngs-js-salat-times') ?></td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['wgt_title2']; ?>
        </span>
      </td>
    </tr>
    <tr>
      <td><?php _e('Location Name:', 'ngs-js-salat-times') ?></td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['location']; ?>
        </span>
      </td>
    </tr>
  </table>
  </p>
  <p><span style="color: gray;"><?php _e('Go to: Settings', 'ngs-js-salat-times') ?> &gt; <a href="<?php admin_url(); ?>options-general.php?page=ngs_js_salat_times"><?php _e('NGS JS Salat Times', 'ngs-js-salat-times') ?></a> <?php _e('to change options.', 'ngs-js-salat-times') ?></span>
  </p>
  <?php
}

function ngs_js_action_links( $links ) {
  $links[] = '<a href="' . get_admin_url( null, 'options-general.php?page=ngs_js_salat_times' ) . '">Settings</a>';
  return $links;
}

/* Admin part */
function ngs_js_salat_times_options_page() {
  ?>  
  <div class="wrap">
    <h1 style="margin-bottom:5px;"><?php _e('NGS JS Salat Times Settings', 'ngs-js-salat-times') ?></h1>
  </div>
  <form id="auto_options" method="post" action="options.php">
  <?php 
    settings_fields( 'ngs-js-salat-times-settings-group' );
    $jsst_options = ngs_js_salat_times_options();
  ?>
    <div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span><?php _e('Location', 'ngs-js-salat-times') ?></span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px"><label for="opt-latitude"><?php _e('Latitude:', 'ngs-js-salat-times') ?></label></td>
            <td><input type="text" maxlength="20" size="10" id="opt-latitude" name="njs_js_salat_times_options[latitude]" value="<?php echo $jsst_options['latitude']; ?>"/></td>
            <td rowspan="3"><img src="<?php echo plugins_url( '/icon-128x128.png', __FILE__ ) ?>"></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-longitude"><?php _e('Longitude:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="text" maxlength="20" size="10" id="opt-longitude" name="njs_js_salat_times_options[longitude]" value="<?php echo $jsst_options['longitude']; ?>"/></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-location"><?php _e('Display Location Name:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="text" maxlength="100" size="30" id="opt-location" name="njs_js_salat_times_options[location]" value="<?php echo $jsst_options['location']; ?>"/></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span><?php _e('Calculation Settings', 'ngs-js-salat-times') ?></span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px"><label for="opt-madhab"><?php _e('Juristic Method:', 'ngs-js-salat-times') ?></label></td>
						<td>
							<select name="njs_js_salat_times_options[madhab]" id="opt-madhab">
								<option value="Shafi" <?php if($jsst_options['madhab']=="Shafi" ) { echo " selected"; } ?>><?php _e('Shafi - Earlier Asr time', 'ngs-js-salat-times') ?></option>
								<option value="Hanafi" <?php if($jsst_options['madhab']=="Hanafi" ) { echo " selected"; } ?>><?php _e('Hanafi - Later Asr time', 'ngs-js-salat-times') ?></option>
							</select> <?php _e('(For Asr time).', 'ngs-js-salat-times') ?>
						</td>
					</tr>
					<tr valign="top">
						<td style="vertical-align: top;"><label for="opt-calculation_method0"><?php _e('Calculation Method:', 'ngs-js-salat-times') ?></label></td>
						<td>
              <?php
                $cmeths = array(
                  "MuslimWorldLeague" => __('Muslim World League. Standard Fajr time with an angle of 18°. Earlier Isha time with an angle of 17°.', 'ngs-js-salat-times'),
                  "Egyptian" => __("Egyptian General Authority of Survey. Early Fajr time using an angle 19.5° and a slightly earlier Isha time using an angle of 17.5°.", 'ngs-js-salat-times'),
                  "Karachi" => __("University of Islamic Sciences, Karachi. A generally applicable method that uses standard Fajr and Isha angles of 18°.", 'ngs-js-salat-times'),
                  "UmmAlQura" => __("Umm al-Qura University, Makkah. Uses a fixed interval of 90 minutes from maghrib to calculate Isha. And a slightly earlier Fajr time with an angle of 18.5°.", 'ngs-js-salat-times') . "<i>" . __("Note: you should add a +30 minute custom adjustment for Isha during Ramadan.", 'ngs-js-salat-times') . "</i>",
                  "Dubai" => __("Used in the UAE. Slightly earlier Fajr time and slightly later Isha time with angles of 18.2° for Fajr and Isha in addition to 3 minute offsets for sunrise, Dhuhr, Asr, and Maghrib.", 'ngs-js-salat-times'),
                  "Qatar" => __("Same Isha interval as ummAlQura but with the standard Fajr time using an angle of 18°.", 'ngs-js-salat-times'),
                  "Kuwait" => __("Standard Fajr time with an angle of 18°. Slightly earlier Isha time with an angle of 17.5°.", 'ngs-js-salat-times'),
                  "MoonsightingCommittee" => __("Method developed by Khalid Shaukat, founder of Moonsighting Committee Worldwide. Uses standard 18° angles for Fajr and Isha in addition to seasonal adjustment values. This method automatically applies the 1/7 approximation rule for locations above 55° latitude. Recommended for North America and the UK.", 'ngs-js-salat-times'),
                  "Singapore" => __("Used in Singapore, Malaysia, and Indonesia. Early Fajr time with an angle of 20° and standard Isha time with an angle of 18°.", 'ngs-js-salat-times'),
                  "Turkey" => __("An approximation of the Diyanet method used in Turkey. This approximation is less accurate outside the region of Turkey.", 'ngs-js-salat-times'),
                  "Tehran" => __("Institute of Geophysics, University of Tehran. Early Isha time with an angle of 14°. Slightly later Fajr time with an angle of 17.7°. Calculates Maghrib based on the sun reaching an angle of 4.5° below the horizon.", 'ngs-js-salat-times'),
                  "NorthAmerica" => __("Also known as the ISNA method. Can be used for North America, but the moonsightingCommittee method is preferable. Gives later Fajr times and early Isha times with angles of 15°.", 'ngs-js-salat-times'),
                  "Other" => __("Defaults to angles of 0°, should generally be used for making a custom method and setting your own values.", 'ngs-js-salat-times')
                );
                $i = 0;
                foreach ($cmeths as $key=>$value) {
                  $checked = ($key == $jsst_options['calculation_method']) ? "checked" : "";
                  echo "<input type=\"radio\" name=\"njs_js_salat_times_options[calculation_method]\" id=\"opt-calculation_method$i\" value=\"$key\" $checked><label for=\"opt-calculation_method$i\">($key) $value</label><br>\n";
                  $i++;
                }
              ?>
						</td>
					</tr>
					<tr valign="top">
						<td style="vertical-align: top;"><label for="opt-high_latitude_rule"><?php _e('Higher Latitudes Method:', 'ngs-js-salat-times') ?></label></td>
						<td>
								<?php
									$highlats = array(
										'MiddleOfTheNight' => __('Fajr will never be earlier than the middle of the night and Isha will never be later than the middle of the night', 'ngs-js-salat-times'),
										'SeventhOfTheNight' => __('Fajr will never be earlier than the beginning of the last seventh of the night and Isha will never be later than the end of the first seventh of the night', 'ngs-js-salat-times'),
										'TwilightAngle' => __('Similar to SeventhOfTheNight, but instead of 1/7, the fraction of the night used is fajrAngle/60 and ishaAngle/60', 'ngs-js-salat-times')
                  );
                  $i = 0;
									foreach ($highlats as $key=>$value) {
                    $checked = ($key == $jsst_options['high_latitude_rule']) ? "checked" : "";
                    echo "<input type=\"radio\" name=\"njs_js_salat_times_options[high_latitude_rule]\" id=\"opt-high_latitude_rule$i\" value=\"$key\" $checked><label for=\"opt-high_latitude_rule$i\">($key) $value</label><br>\n";
                    $i++;
									}
								?>
              <br>
							<?php _e('(Value from the HighLatitudeRule object, used to set a minimum time for Fajr and a max time for Isha)', 'ngs-js-salat-times') ?>
						</td>
          </tr>
					<tr valign="top">
						<td><label for="opt-fajr_angle"><?php _e('Farj Angle:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" max="90" min="0" id="opt-fajr_angle" name="njs_js_salat_times_options[fajr_angle]" value="<?php echo $jsst_options['fajr_angle']; ?>"/><?php _e('(Angle of the sun used to calculate Fajr)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-isha_angle"><?php _e('Isha Angle:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" max="90" min="0" id="opt-isha_angle" name="njs_js_salat_times_options[isha_angle]" value="<?php echo $jsst_options['isha_angle']; ?>"/><?php _e('(Angle of the sun used to calculate Isha)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-isha_interval"><?php _e('Isha Interval:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-isha_interval" name="njs_js_salat_times_options[isha_interval]" value="<?php echo $jsst_options['isha_interval']; ?>"/><?php _e('Minutes after Maghrib (if set, the time for Isha will be Maghrib plus ishaInterval)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-fajr_adjustment"><?php _e('Fajr Adjustment:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-fajr_adjustment" name="njs_js_salat_times_options[fajr_adjustment]" value="<?php echo $jsst_options['fajr_adjustment']; ?>"/><?php _e('(in minutes)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-sunrise_adjustment"><?php _e('Sunrise (Churuk) Adjustment:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-sunrise_adjustment" name="njs_js_salat_times_options[sunrise_adjustment]" value="<?php echo $jsst_options['sunrise_adjustment']; ?>"/><?php _e('(in minutes)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-dhuhr_adjustment"><?php _e('Dhuhr Adjustment:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-dhuhr_adjustment" name="njs_js_salat_times_options[dhuhr_adjustment]" value="<?php echo $jsst_options['dhuhr_adjustment']; ?>"/><?php _e('(in minutes)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-asr_adjustment"><?php _e('Asr Adjustment:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-asr_adjustment" name="njs_js_salat_times_options[asr_adjustment]" value="<?php echo $jsst_options['asr_adjustment']; ?>"/><?php _e('(in minutes)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-maghrib_adjustment"><?php _e('Maghrib Adjustment:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-maghrib_adjustment" name="njs_js_salat_times_options[maghrib_adjustment]" value="<?php echo $jsst_options['maghrib_adjustment']; ?>"/><?php _e('(in minutes)', 'ngs-js-salat-times') ?></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-isha_adjustment"><?php _e('Isha Adjustment:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="number" id="opt-isha_adjustment" name="njs_js_salat_times_options[isha_adjustment]" value="<?php echo $jsst_options['isha_adjustment']; ?>"/><?php _e('(in minutes)', 'ngs-js-salat-times') ?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span><?php _e('Locales Settings', 'ngs-js-salat-times') ?></span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px"><label for="opt-date_format"><?php _e('Date Format:', 'ngs-js-salat-times') ?></label></td>
            <td><input type="text" maxlength="50" size="30" id="opt-date_format" name="njs_js_salat_times_options[date_format]" value="<?php echo $jsst_options['date_format']; ?>"/>
            <?php printf( 
              /* translators: 1: link tag opening 2: link tag closing */
              __('(See %1$s momentjs date/time format options %2$s, let empty to hide)', 'ngs-js-salat-times'), 
                '<a href="https://momentjs.com/docs/#/displaying/format">', 
                '</a>'); 
              ?></td>
					</tr>
					<tr valign="top">
            <td><label for="opt-time_format"><?php _e('Time Format:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="text" maxlength="50" size="30" id="opt-time_format" name="njs_js_salat_times_options[time_format]" value="<?php echo $jsst_options['time_format']; ?>"/></td>
					</tr>
          <tr valign="top">
            <td width="175px"><label for="opt-hijri_format"><?php _e('Hijri Date Format:', 'ngs-js-salat-times') ?></label></td>
            <td><input type="text" maxlength="50" size="30" id="opt-hijri_format" name="njs_js_salat_times_options[hijri_format]" value="<?php echo $jsst_options['hijri_format']; ?>"/>
            <?php printf( 
                /* translators: 1: link tag opening 2: link tag closing */
                __('(See %1$sHijri date/time format options %2$s, let empty to hide)', 'ngs-js-salat-times'), 
                  '<a href="https://github.com/xlat/moment-hijri">', '</a>'); 
            ?></td>
          </tr>
					<tr valign="top">
						<td><label for="opt-time_zone"><?php _e('Time Zone:', 'ngs-js-salat-times') ?></label></td>
            <td>
              <div class="ngsjsst-autocomplete">
                <input type="text" maxlength="50" size="40" id="opt-time_zone" name="njs_js_salat_times_options[timezone]" value="<?php echo $jsst_options['timezone']; ?>"/>
              </div>
            </td>
					</tr>
					<tr valign="top">
						<td><label for="opt-locale"><?php _e('Language:', 'ngs-js-salat-times') ?></label></td>
						<td>
              <div class="ngsjsst-autocomplete">
                <input type="text" maxlength="20" size="10" id="opt-locale" name="njs_js_salat_times_options[locale]" value="<?php echo $jsst_options['locale']; ?>"/>
              </div>
            </td>
					</tr>
					<tr valign="top">
						<td><label for="opt-headers"><?php _e('Headers Translations:', 'ngs-js-salat-times') ?></label></td>
            <td><input type="text" maxlength="200" size="100" id="opt-headers" name="njs_js_salat_times_options[headers]" value="<?php echo $jsst_options['headers']; ?>"/>
                <br><?php _e('(Day,Fajr,Shuruk,Zhur,Asr,Maghreb,Isha,Previous Month,Next Month,Hijri Day : use a pipe "|" as separator)', 'ngs-js-salat-times') ?></td>
          </tr>
					<tr valign="top">
						<td><label for="opt-wg_title1"><?php _e('Monthly Widget Title:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="text" maxlength="200" size="100" id="opt-wg_title1" name="njs_js_salat_times_options[wgt_title1]" value="<?php echo $jsst_options['wgt_title1']; ?>"/></td>
          </tr>
					<tr valign="top">
						<td><label for="opt-wgt_title2"><?php _e('Daily Widget Title:', 'ngs-js-salat-times') ?></label></td>
						<td><input type="text" maxlength="200" size="100" id="opt-wgt_title2" name="njs_js_salat_times_options[wgt_title2]" value="<?php echo $jsst_options['wgt_title2']; ?>"/></td>
          </tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span><?php _e('Hijri Date Adjustments', 'ngs-js-salat-times') ?></span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px" style="vertical-align: top;"><label for="opt-hijri-offsets"><?php _e('List of hijri month adjustments:', 'ngs-js-salat-times') ?></label></td>
						<td><textarea rows="10" cols="100" id="opt-hijri-offsets" placeholder="1441-01: 29" name="njs_js_salat_times_options[hjri_offsets]"><?php echo htmlspecialchars($jsst_options['hijri_offsets']) ?></textarea></td>
          </tr>
          <tr valign="top">
            <td colspan="2">
              <p><?php _e('One adjutment by row, use the format:', 'ngs-js-salat-times') ?> <span style="background-color: antiquewhite;">year-month: nb-days</span><?php _e(', eg:', 'ngs-js-salat-times') ?> 
                <span style="background-color: antiquewhite;">1441-01: 29</span>.<br>
                <?php printf( 
                  /* translators: %s: Umm al-Qura link */
                  _e('This will override %s data used to compute hijri month length.', 'ngs-js-salat-times'), 
                    '<a href="http://www.ummulqura.org.sa/">Umm al-Qura</a>') 
                  ?>
                <?php printf( 
                        /* translators: 1: this open tag link 2: link closing tag 3: moment link 4: moment-hijri link 5: author link*/
                        _e('%1$s This %2$s is based on the %3$s library\s plugin %4$s from %5$s', 'ngs-js-salat-times'), 
                          '<a href="https://github.com/xlat/moment-hijri">',
                          '</a>',
                          '<a href="https://momentjs.com/">moment</a>',
                          '<a href="https://momentjs.com/docs/#/plugins/hijri/">moment-hijri</a>',
                          '<a href="https://github.com/xsoh">Suhail Alkowaileet</a>'
                        ) ?>
              </p>
            </td>
          </tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span><?php _e('Widget Style', 'ngs-js-salat-times') ?></span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px" style="vertical-align: top;"><label for="opt-css"><?php _e('Custom CSS:', 'ngs-js-salat-times') ?></label></td>
						<td><textarea placeholder="<?php _e('enter your custom CSS here', 'ngs-js-salat-times') ?>" rows="10" cols="100" id="opt-css" name="njs_js_salat_times_options[css]"><?php echo htmlspecialchars($jsst_options['css']) ?></textarea></td>
					</tr>
				</table>
			</div>
    </div>
    
  <a name="help"></a>
	<div class="postbox">
		<h3 class="hndle" style="padding: 10px; margin: 0;"><span><a name="help"></a><?php _e('Help', 'ngs-js-salat-times') ?></span></h3>
		<div class="inside">
			<p><strong><u><?php _e('How To Use', 'ngs-js-salat-times') ?></u>:</strong>
			</p>
			<p style="padding-left: 10px;"><?php _e('Go to: Appearance', 'ngs-js-salat-times') ?> &gt; <a href="<?php admin_url(); ?>widgets.php"><?php _e('Widgets', 'ngs-js-salat-times') ?></a> <?php _e('to use this (NGS JS Salat Times) widget.', 'ngs-js-salat-times') ?></p>
      <p style="padding-left: 10px;"><?php _e('Insert this shortcode in post/page:', 'ngs-js-salat-times') ?>
        <code>
          <span style="color: #000000">
            <span style="color: #0000BB">[ngs_js_salat_times]</span>
            <br><?php _e('or:', 'ngs-js-salat-times') ?></br>
            <span style="color: #0000BB">[ngs_js_daily_salat_times]</span>
          </span>
        </code>
			</p>
      <p style="padding-left: 10px;"><?php _e('Or, PHP code: ', 'ngs-js-salat-times') ?>
        <code>
          <span style="color: #000000">
            <span style="color: #0000BB">&#60;&#63;</span>php echo do_shortcode&#40;&#39;[ngs_js_salat_times]&#39;&#41;;</span><span style="color: #0000BB">&#63;&#62;</span>
            <br><?php _e('or:', 'ngs-js-salat-times') ?><br>
            <span style="color: #0000BB">&#60;&#63;</span>php echo do_shortcode&#40;&#39;[ngs_js_daily_salat_times]&#39;&#41;;</span><span style="color: #0000BB">&#63;&#62;</span>
          </span>
        </code>
			</p>
		</div>
  </div>
  
		<?php submit_button(); ?>
  </form>
  <?php
}

function ngs_js_salat_times_help( $contextual_help, $screen_id, $screen ) { //Contextual Help
  global $ngs_js_salat_times_hook;
  if ( $screen_id == $ngs_js_salat_times_hook ) {
          $contextual_help = sprintf( 
                                /* translators: 1: Author contact link */
                                __('For any help related to this plugin, contact %1$s .', 'ngs-js-salat-times'),
                                '<a href="mailto:nicolas@ngs.ma>Nicolas Georges</a>'
                              ) . '<br><br>' 
                           . __('Web:', 'ngs-js-salat-times') . '<a href="https://ngs.ma">https://ngs.ma</a><br>'
                           . __('View:', 'ngs-js-salat-times') . '<a href="http://wordpress.org/support/plugin/ngs-js-salat-times">' . __('Support Forum', 'ngs-js-salat-times') . '</a> | '
                           . '<a href="http://wordpress.org/extend/plugins/ngs-js-salat-times/changelog/">' . __('Changelog', 'ngs-js-salat-times') . '</a><br>' 
                           . __('Wordpress Plugins Directory:', 'ngs-js-salat-times') . '<a href="http://wordpress.org/plugins/ngs-js-salat-times">http://wordpress.org/plugins/ngs-js-salat-times</a><br>'
                           . '<span style="color: red;">' . __('Please always keep this plugin up to date.', 'ngs-js-salat-times') . '</span>';
  }
  return $contextual_help;
}

function ngs_js_salat_times_admin() {
  global $ngs_js_salat_times_hook;
  $ngs_js_salat_times_hook = add_options_page( __('NGS JS Salat Times Settings', 'ngs-js-salat-times'), __('NGS JS Salat Times', 'ngs-js-salat-times'), 'activate_plugins', 'ngs_js_salat_times', 'ngs_js_salat_times_options_page' );
}

function register_ngs_js_salat_times_settings() {
  register_setting( 'ngs-js-salat-times-settings-group', 'njs_js_salat_times_options' );
}

function ngs_js_salat_times_enqueue_scripts() {
  wp_register_script('adhan', plugins_url( '/Adhan.min.js', __FILE__ ), array('moment-with-locales', 'moment-timezone-with-data-10-year-range', 'moment-hijri.js') );
  wp_register_script('moment-hijri.js', plugins_url( '/moment-hijri.js', __FILE__ ) );
  wp_register_script('moment-with-locales', plugins_url( '/moment-with-locales.min.js', __FILE__) );
  wp_register_script('moment-timezone-with-data-10-year-range', plugins_url('/moment-timezone-with-data-10-year-range.min.js', __FILE__) );
  wp_register_script('ngs-js-salat-times', plugins_url( '/ngs-js-salat-times.js', __FILE__ ), array('adhan') );
  wp_enqueue_script('ngs-js-salat-times');
  wp_register_style('ngs-js-salat-times-style', plugins_url( '/ngs-js-salat-times.css', __FILE__ ));
  wp_enqueue_style('ngs-js-salat-times-style');
  if(is_admin()){
    wp_register_script('ngs-js-salat-times-admin', plugins_url( '/ngs-js-salat-times-admin.js', __FILE__ ) );
    wp_enqueue_script('ngs-js-salat-times-admin');
    wp_register_style('ngs-js-salat-times-style-admin', plugins_url( '/ngs-js-salat-times-admin.css', __FILE__ ));
    wp_enqueue_style('ngs-js-salat-times-style-admin');
  }
  ngs_js_salat_time_style();
}

function ngs_js_salat_time_style() {
  wp_register_style('ngs-js-salat-times-in-style', false, array('ngs-js-salat-times-style') );
  wp_enqueue_style('ngs-js-salat-times-in-style');
  $jsst_options = ngs_js_salat_times_options();
  wp_add_inline_style('ngs-js-salat-times-in-style', $jsst_options['css']);
}

/* registration part */
add_action( 'wp_enqueue_scripts', 'ngs_js_salat_times_enqueue_scripts' );
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ngs_js_action_links' );
add_shortcode( 'ngs_js_salat_times', 'ngs_js_salat_times' );
wp_register_sidebar_widget( 'ngs_js_salat_times', __('NGS JS Salat Times', 'ngs-js-salat-times'), 'widget_ngs_js_salat_times', array( 'description' => __( 'Displays monthly salat timesheet.', 'ngs-js-salat-times' ) ) );
wp_register_widget_control( 'ngs_js_salat_times', __('NGS JS Salat Times', 'ngs-js-salat-times'), 'widget_ngs_js_salat_times_control' );
add_shortcode( 'ngs_js_daily_salat_times', 'ngs_js_daily_salat_times' );
wp_register_sidebar_widget( 'ngs_js_daily_salat_times', __('NGS JS Daily Salat Times', 'ngs-js-salat-times'), 'widget_ngs_js_daily_salat_times', array( 'description' => __( 'Displays daily salat band.', 'ngs-js-salat-times' ) ) );
wp_register_widget_control( 'ngs_js_daily_salat_times', __('NGS JS Daily Salat Times', 'ngs-js-salat-times'), 'widget_ngs_js_daily_salat_times_control' );

if ( is_admin() ) {
  add_action( 'admin_enqueue_scripts', 'ngs_js_salat_times_enqueue_scripts' );
  add_action( 'admin_menu', 'ngs_js_salat_times_admin' );
  add_action( 'admin_init', 'register_ngs_js_salat_times_settings' );
  
  //This is said to be obsolete!
  add_filter( 'contextual_help', 'ngs_js_salat_times_help', 10, 3 );
}

?>