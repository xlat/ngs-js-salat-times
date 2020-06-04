<?php
/**
 * Plugin Name: NGS JS Salat Times
 * Plugin URI: https://ngs.ma/index.php/js-salat-times-wp-plugin/
 * Description: Yet Another Salat Times Wordpress Plugin.
 * Author: Nicolas Georges (nicolas@ngs.ma)
 * Version: 1.1
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
defined( 'ABSPATH' ) or die( '&#128680; Bas les pattes!' );

function ngs_js_salat_times_options() {
  $default = array( 
    'wgt_title1' => 'Monthly Salat Times',
    'wgt_title2' => 'Daily Salat Times',
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
    'headers' => "JOUR|SUBH|SHURUQ*|ZHUR|ASR|MAGHRIB|ISHA|&#9194; Mois Précédent|Mois Suivant &#9193;|HIJRI",
    'css' => ngs_js_salat_times_css(),
   );
  $options = get_option("njs_js_salat_times_options");
  if ( !is_array( $options ) ) {
    $options = $default;
  }

  //set non existing values (in cas of new settings in newer version)
  foreach($default as $k => $v) {
    if(!in_array($k, $options, true)) {
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
  print('<div class="ngs-js-salat-time-anchor"');
  #for each options in $jsst_options add an attribut
  foreach($jsst_options as $name => $value) {
    if($name != "css") {
      $value = htmlentities($value, ENT_HTML5, 'UTF-8' );
      print("\t$name=\"$value\"\n");
    }
  }
  print('></div>');
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
      <td>Widget Title:</td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['wgt_title1']; ?>
        </span>
      </td>
    </tr>
    <tr>
      <td>Location Name:</td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['location']; ?>
        </span>
      </td>
    </tr>
  </table>
  </p>
  <p><span style="color: gray;">Go to: Settings > <a href="<?php admin_url(); ?>options-general.php?page=ngs_js_salat_times">NGS JS Salat Times</a> to change options.</span>
  </p>
  <?php
}

function ngs_js_daily_salat_times() {
  $jsst_options = ngs_js_salat_times_options();
  print('<div class="ngs-js-salat-time-anchor" daily="true" ');
  #for each options in $jsst_options add an attribut
  foreach($jsst_options as $name => $value) {
    if($name != "css") {
      $value = htmlentities($value, ENT_HTML5, 'UTF-8' );
      print("\t$name=\"$value\"\n");
    }
  }
  print('></div>');
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
      <td>Widget Title:</td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['wgt_title2']; ?>
        </span>
      </td>
    </tr>
    <tr>
      <td>Location Name:</td>
      <td>
        <span style="color: green;">
          <?php echo $jsst_options['location']; ?>
        </span>
      </td>
    </tr>
  </table>
  </p>
  <p><span style="color: gray;">Go to: Settings > <a href="<?php admin_url(); ?>options-general.php?page=ngs_js_salat_times">NGS JS Salat Times</a> to change options.</span>
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
    <h1 style="margin-bottom:5px;">NGS JS Salat Times Settings</h1>
  </div>
  <?php /*if ( isset( $_POST[ "restore_defaults" ] ) == "1" ) delete_option( 'njs_js_salat_times_options' );*/ ?>
  <form id="auto_options" method="post" action="options.php">
  <?php 
    settings_fields( 'ngs-js-salat-times-settings-group' );
    $jsst_options = ngs_js_salat_times_options();
  ?>
    <div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Location</span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px"><label for="opt-latitude">Latitude:</label></td>
            <td><input type="text" maxlength="20" size="10" id="opt-latitude" name="njs_js_salat_times_options[latitude]" value="<?php echo $jsst_options['latitude']; ?>"/></td>
            <td rowspan="3"><img src="<?php echo plugins_url( '/NGS-JS-Salat-Times-Icon-128x128.png', __FILE__ ) ?>"></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-longitude">Longitude:</label></td>
						<td><input type="text" maxlength="20" size="10" id="opt-longitude" name="njs_js_salat_times_options[longitude]" value="<?php echo $jsst_options['longitude']; ?>"/></td>
					</tr>
					<tr valign="top">
						<td><label for="opt-location">Display Location Name:</label></td>
						<td><input type="text" maxlength="100" size="30" id="opt-location" name="njs_js_salat_times_options[location]" value="<?php echo $jsst_options['location']; ?>"/></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Calculation Settings</span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px"><label for="opt-madhab">Juristic Method:</label></td>
						<td>
							<select name="njs_js_salat_times_options[madhab]" id="opt-madhab">
								<option value="Shafi" <?php if($jsst_options['madhab']=="Shafi" ) { echo " selected"; } ?>>Shafi - Earlier Asr time</option>
								<option value="Hanafi" <?php if($jsst_options['madhab']=="Hanafi" ) { echo " selected"; } ?>>Hanafi - Later Asr time</option>
							</select> (For <span style="color: green;">Asr</span> time.)
						</td>
					</tr>
					<tr valign="top">
						<td style="vertical-align: top;"><label for="opt-calculation_method0">Calculation Method:</label></td>
						<td>
              <?php
                $cmeths = array(
                  "MuslimWorldLeague" => "Muslim World League. Standard Fajr time with an angle of 18°. Earlier Isha time with an angle of 17°.",
                  "Egyptian" => "Egyptian General Authority of Survey. Early Fajr time using an angle 19.5° and a slightly earlier Isha time using an angle of 17.5°.",
                  "Karachi" => "University of Islamic Sciences, Karachi. A generally applicable method that uses standard Fajr and Isha angles of 18°.",
                  "UmmAlQura" => "Umm al-Qura University, Makkah. Uses a fixed interval of 90 minutes from maghrib to calculate Isha. And a slightly earlier Fajr time with an angle of 18.5°. <i>Note: you should add a +30 minute custom adjustment for Isha during Ramadan.</i>",
                  "Dubai" => "Used in the UAE. Slightly earlier Fajr time and slightly later Isha time with angles of 18.2° for Fajr and Isha in addition to 3 minute offsets for sunrise, Dhuhr, Asr, and Maghrib.",
                  "Qatar" => "Same Isha interval as ummAlQura but with the standard Fajr time using an angle of 18°.",
                  "Kuwait" => "Standard Fajr time with an angle of 18°. Slightly earlier Isha time with an angle of 17.5°.",
                  "MoonsightingCommittee" => "Method developed by Khalid Shaukat, founder of Moonsighting Committee Worldwide. Uses standard 18° angles for Fajr and Isha in addition to seasonal adjustment values. This method automatically applies the 1/7 approximation rule for locations above 55° latitude. Recommended for North America and the UK.",
                  "Singapore" => "Used in Singapore, Malaysia, and Indonesia. Early Fajr time with an angle of 20° and standard Isha time with an angle of 18°.",
                  "Turkey" => "An approximation of the Diyanet method used in Turkey. This approximation is less accurate outside the region of Turkey.",
                  "Tehran" => "Institute of Geophysics, University of Tehran. Early Isha time with an angle of 14°. Slightly later Fajr time with an angle of 17.7°. Calculates Maghrib based on the sun reaching an angle of 4.5° below the horizon.",
                  "NorthAmerica" => "Also known as the ISNA method. Can be used for North America, but the moonsightingCommittee method is preferable. Gives later Fajr times and early Isha times with angles of 15°.",
                  "Other" => "Defaults to angles of 0°, should generally be used for making a custom method and setting your own values."
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
						<td style="vertical-align: top;"><label for="opt-high_latitude_rule">Higher Latitudes Method:</label></td>
						<td>
								<?php
									$highlats = array(
										'MiddleOfTheNight' => 'Fajr will never be earlier than the middle of the night and Isha will never be later than the middle of the night',
										'SeventhOfTheNight' => 'Fajr will never be earlier than the beginning of the last seventh of the night and Isha will never be later than the end of the first seventh of the night',
										'TwilightAngle' => 'Similar to SeventhOfTheNight, but instead of 1/7, the fraction of the night used is fajrAngle/60 and ishaAngle/60'
                  );
                  $i = 0;
									foreach ($highlats as $key=>$value) {
                    $checked = ($key == $jsst_options['high_latitude_rule']) ? "checked" : "";
                    echo "<input type=\"radio\" name=\"njs_js_salat_times_options[high_latitude_rule]\" id=\"opt-high_latitude_rule$i\" value=\"$key\" $checked><label for=\"opt-high_latitude_rule$i\">($key) $value</label><br>\n";
                    $i++;
									}
								?>
              <br>
							(Value from the HighLatitudeRule object, used to set a minimum time for Fajr and a max time for Isha)
						</td>
          </tr>
					<tr valign="top">
						<td><label for="opt-fajr_angle">Farj Angle:</label></td>
						<td><input type="number" max="90" min="0" id="opt-fajr_angle" name="njs_js_salat_times_options[fajr_angle]" value="<?php echo $jsst_options['fajr_angle']; ?>"/>(Angle of the sun used to calculate Fajr)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-isha_angle">Isha Angle:</label></td>
						<td><input type="number" max="90" min="0" id="opt-isha_angle" name="njs_js_salat_times_options[isha_angle]" value="<?php echo $jsst_options['isha_angle']; ?>"/>(Angle of the sun used to calculate Isha)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-isha_interval">Isha Interval:</label></td>
						<td><input type="number" id="opt-isha_interval" name="njs_js_salat_times_options[isha_interval]" value="<?php echo $jsst_options['isha_interval']; ?>"/>Minutes after Maghrib (if set, the time for Isha will be Maghrib plus ishaInterval)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-fajr_adjustment">Fajr Adjustment:</label></td>
						<td><input type="number" id="opt-fajr_adjustment" name="njs_js_salat_times_options[fajr_adjustment]" value="<?php echo $jsst_options['fajr_adjustment']; ?>"/>(in minutes)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-sunrise_adjustment">Sunrise (Churuk) Adjustment:</label></td>
						<td><input type="number" id="opt-sunrise_adjustment" name="njs_js_salat_times_options[sunrise_adjustment]" value="<?php echo $jsst_options['sunrise_adjustment']; ?>"/>(in minutes)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-dhuhr_adjustment">Dhuhr Adjustment:</label></td>
						<td><input type="number" id="opt-dhuhr_adjustment" name="njs_js_salat_times_options[dhuhr_adjustment]" value="<?php echo $jsst_options['dhuhr_adjustment']; ?>"/>(in minutes)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-asr_adjustment">Asr Adjustment:</label></td>
						<td><input type="number" id="opt-asr_adjustment" name="njs_js_salat_times_options[asr_adjustment]" value="<?php echo $jsst_options['asr_adjustment']; ?>"/>(in minutes)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-maghrib_adjustment">Maghrib Adjustment:</label></td>
						<td><input type="number" id="opt-maghrib_adjustment" name="njs_js_salat_times_options[maghrib_adjustment]" value="<?php echo $jsst_options['maghrib_adjustment']; ?>"/>(in minutes)</td>
					</tr>
					<tr valign="top">
						<td><label for="opt-isha_adjustment">Isha Adjustment:</label></td>
						<td><input type="number" id="opt-isha_adjustment" name="njs_js_salat_times_options[isha_adjustment]" value="<?php echo $jsst_options['isha_adjustment']; ?>"/>(in minutes)</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Locales Settings</span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px"><label for="opt-date_format">Date Format:</label></td>
						<td><input type="text" maxlength="50" size="30" id="opt-date_format" name="njs_js_salat_times_options[date_format]" value="<?php echo $jsst_options['date_format']; ?>"/>(See <a href="https://momentjs.com/docs/#/displaying/format">momentjs date/time format options</a>, let empty to hide)</td>
					</tr>
					<tr valign="top">
            <td><label for="opt-time_format">Time Format:</label></td>
						<td><input type="text" maxlength="50" size="30" id="opt-time_format" name="njs_js_salat_times_options[time_format]" value="<?php echo $jsst_options['time_format']; ?>"/></td>
					</tr>
          <tr valign="top">
            <td width="175px"><label for="opt-hijri_format">Hijri Date Format:</label></td>
            <td><input type="text" maxlength="50" size="30" id="opt-hijri_format" name="njs_js_salat_times_options[hijri_format]" value="<?php echo $jsst_options['hijri_format']; ?>"/>(See <a href="https://github.com/xlat/moment-hijri">Hijri date/time format options</a>, let empty to hide)</td>
          </tr>
					<tr valign="top">
						<td><label for="opt-time_zone">Time Zone:</label></td>
            <?php /* may use javascript to populate a <select/> using moment.tz.names(), or make it autcomplete */ ?>
            <td>
              <div class="ngsjsst-autocomplete">
                <input type="text" maxlength="50" size="40" id="opt-time_zone" name="njs_js_salat_times_options[timezone]" value="<?php echo $jsst_options['timezone']; ?>"/>
              </div>
            </td>
					</tr>
					<tr valign="top">
						<td><label for="opt-locale">Language:</label></td>
						<td>
              <div class="ngsjsst-autocomplete">
                <input type="text" maxlength="20" size="10" id="opt-locale" name="njs_js_salat_times_options[locale]" value="<?php echo $jsst_options['locale']; ?>"/>
              </div>
            </td>
					</tr>
					<tr valign="top">
						<td><label for="opt-headers">Headers Translation:</label></td>
            <td><input type="text" maxlength="200" size="100" id="opt-headers" name="njs_js_salat_times_options[headers]" value="<?php echo $jsst_options['headers']; ?>"/>
                <br>(Day,Fajr,Shuruk,Zhur,Asr,Maghreb,Isha,Previous Month,Next Month,Hijri Day : use a pipe "|" as separator)</td>
          </tr>
					<tr valign="top">
						<td><label for="opt-wg_title1">Monthly Widget Title:</label></td>
						<td><input type="text" maxlength="200" size="100" id="opt-wg_title1" name="njs_js_salat_times_options[wgt_title1]" value="<?php echo $jsst_options['wgt_title1']; ?>"/></td>
          </tr>
					<tr valign="top">
						<td><label for="opt-wgt_title2">Daily Widget Title:</label></td>
						<td><input type="text" maxlength="200" size="100" id="opt-wgt_title2" name="njs_js_salat_times_options[wgt_title2]" value="<?php echo $jsst_options['wgt_title2']; ?>"/></td>
          </tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Hijri Date Adjustments</span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px" style="vertical-align: top;"><label for="opt-hijri-offsets">List of hijri month adjustments:</label></td>
						<td><textarea rows="10" cols="100" id="opt-hijri-offsets" placeholder="1441-01: 29" name="njs_js_salat_times_options[hjri_offsets]"><?php echo htmlspecialchars($jsst_options['hijri_offsets']) ?></textarea></td>
          </tr>
          <tr valign="top">
            <td colspan="2">
              <p>One adjutment by row, use the format: <span style="background-color: antiquewhite;">year-month: nb-days</span>, eg: <span style="background-color: antiquewhite;">1441-01: 29</span>.<br>
              This will override <a href="http://www.ummulqura.org.sa/">Umm al-Qura</a> data used to compute hijri month length.
              <a href="https://github.com/xlat/moment-hijri">This</a> is based on the <a href="https://momentjs.com/">moment</a> plugin <a href="https://momentjs.com/docs/#/plugins/hijri/">moment-hijri</a> from <a href="https://github.com/xsoh">Suhail Alkowaileet</a></p>
            </td>
          </tr>
				</table>
			</div>
		</div>

		<div class="postbox">
			<h3 class="hndle" style="padding: 10px; margin: 0;"><span>Widget Style</span></h3>
			<div class="inside">
				<table class="form-table" style="width: inherit !important;">
					<tr valign="top">
						<td width="175px" style="vertical-align: top;"><label for="opt-css">Custom CSS:</label></td>
						<td><textarea placeholder="enter your custom CSS here" rows="10" cols="100" id="opt-css" name="njs_js_salat_times_options[css]"><?php echo htmlspecialchars($jsst_options['css']) ?></textarea></td>
					</tr>
				</table>
			</div>
    </div>
    
  <a name="help"></a>
	<div class="postbox">
		<h3 class="hndle" style="padding: 10px; margin: 0;"><span><a name="help"></a>Help</span></h3>
		<div class="inside">
			<p><strong><u>How To Use</u>:</strong>
			</p>
			<p style="padding-left: 10px;">Go to: Appearance > <a href="<?php admin_url(); ?>widgets.php">Widgets</a> to use this (NGS JS Salat Times) widget.</p>
      <p style="padding-left: 10px;">Insert this shortcode in post/page: 
        <code>
          <span style="color: #000000">
            <span style="color: #0000BB">[ngs_js_salat_times]</span>
            <br>or:</br>
            <span style="color: #0000BB">[ngs_js_daily_salat_times]</span>
          </span>
        </code>
			</p>
      <p style="padding-left: 10px;">Or, PHP code: 
        <code>
          <span style="color: #000000">
            <span style="color: #0000BB">&#60;&#63;</span>php echo do_shortcode&#40;&#39;[ngs_js_salat_times]&#39;&#41;;</span><span style="color: #0000BB">&#63;&#62;</span>
            <br>or:<br>
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
          $contextual_help = 'For any help related to this plugin, contact <a href="mailto:nicolas@ngs.ma>Nicolas Georges</a>.<br/><br/>Web: <a href="https://ngs.ma">https://ngs.ma</a><br/>View: <a href="http://wordpress.org/support/plugin/ngs-js-salat-times">Support Forum</a> | <a href="http://wordpress.org/extend/plugins/ngs-js-salat-times/changelog/">Changelog</a><br/>Wordpress Plugins Directory: <a href="http://wordpress.org/plugins/ngs-js-salat-times">http://wordpress.org/plugins/ngs-js-salat-times</a><br/><span style="color: red;">Please always keep this plugin up to date.</span>';
  }
  return $contextual_help;
}

function ngs_js_salat_times_admin() {
  global $ngs_js_salat_times_hook;
  $ngs_js_salat_times_hook = add_options_page( 'NGS JS Salat Times Settings', 'NGS JS Salat Times', 'activate_plugins', 'ngs_js_salat_times', 'ngs_js_salat_times_options_page' );
}

function register_ngs_js_salat_times_settings() {
  register_setting( 'ngs-js-salat-times-settings-group', 'njs_js_salat_times_options' );
}

function ngs_js_salat_times_enqueue_scripts() {
  wp_register_script('adhan', plugins_url( '/Adhan.min.js', __FILE__ ), array('moment-with-locales', 'moment-timezone-with-data-10-year-range', 'moment-hijri.js') );
  wp_register_script('moment-hijri.js', plugins_url( '/moment-hijri.js', __FILE__ ) );
  wp_register_script('moment-with-locales', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js' );
  wp_register_script('moment-timezone-with-data-10-year-range', 'https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.28/moment-timezone-with-data-10-year-range.min.js');
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
wp_register_sidebar_widget( 'ngs_js_salat_times', 'NGS JS Salat Times', 'widget_ngs_js_salat_times', array( 'description' => __( 'Displays monthly salat timesheet.' ) ) );
wp_register_widget_control( 'ngs_js_salat_times', 'NGS JS Salat Times', 'widget_ngs_js_salat_times_control' );
add_shortcode( 'ngs_js_daily_salat_times', 'ngs_js_daily_salat_times' );
wp_register_sidebar_widget( 'ngs_js_daily_salat_times', 'NGS JS Daily Salat Times', 'widget_ngs_js_daily_salat_times', array( 'description' => __( 'Displays daily salat band.' ) ) );
wp_register_widget_control( 'ngs_js_daily_salat_times', 'NGS JS Daily Salat Times', 'widget_ngs_js_daily_salat_times_control' );

if ( is_admin() ) {
  add_action( 'admin_enqueue_scripts', 'ngs_js_salat_times_enqueue_scripts' );
  add_action( 'admin_menu', 'ngs_js_salat_times_admin' );
  add_action( 'admin_init', 'register_ngs_js_salat_times_settings' );
  add_filter( 'contextual_help', 'ngs_js_salat_times_help', 10, 3 );
}

?>