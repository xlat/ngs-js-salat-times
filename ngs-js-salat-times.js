/**
 * Wordpress plugin name: NGS JS Salat Times
 * using adhan.js library (https://github.com/batoulapps/adhan-js).
 * Author: Nicolas Georges (nicolas@ngs.ma)
 * Date: 2020-05-30
 */

window.ngs_js_salat_time = {
  "last_period": moment().date(1).hour(0).minute(0).second(0),
  "build_table": function(m) {
    var anchors = document.getElementsByClassName("ngs-js-salat-time-anchor");
    for(var i=0;i<anchors.length;i++) {
      ngs_js_salat_time.build_table_anchor(anchors.item(i), m);
    }
  },
  "get_prayer_times_moments": function(coordinates, m, params) {
    var prayerTimes = new adhan.PrayerTimes(coordinates, m.toDate(), params);
    var sunnahTimes = new adhan.SunnahTimes(prayerTimes);
    prayerTimes.fajr = moment(prayerTimes.fajr);
    prayerTimes.sunrise = moment(prayerTimes.sunrise);
    prayerTimes.dhuhr = moment(prayerTimes.dhuhr);
    prayerTimes.asr = moment(prayerTimes.asr);
    prayerTimes.maghrib = moment(prayerTimes.maghrib);
    prayerTimes.isha = moment(prayerTimes.isha);
    sunnahTimes.lastThirdOfTheNight = moment(sunnahTimes.lastThirdOfTheNight);
    sunnahTimes.middleOfTheNight = moment(sunnahTimes.middleOfTheNight);
    return {"prayerTimes": prayerTimes, "sunnahTimes": sunnahTimes};
  },
  "build_table_anchor": function(anchor, m) {
    var isDaily = !!anchor.getAttribute('daily');
    if(!anchor) return;
    if(!m) m = isDaily ? moment() : moment().date(1).hour(0).minute(0).second(0);
    if(!isDaily) ngs_js_salat_time.last_period = m.clone();
    var locale = anchor.getAttribute('locale');
    var timeZone = anchor.getAttribute('timezone');
    var latitude = Number.parseFloat(anchor.getAttribute('latitude'));
    var longitude = Number.parseFloat(anchor.getAttribute('longitude'));
    var date_fmt = anchor.getAttribute('date_format');
    var time_fmt = anchor.getAttribute('time_format');
    var hijri_fmt = anchor.getAttribute('hijri_format');
    var titles = anchor.getAttribute('headers').split('|');
    var params = adhan.CalculationMethod[anchor.getAttribute('calculation_method')]();
    params.madhab = adhan.Madhab[anchor.getAttribute('madhab')];
    params.highLatitudeRule = adhan.HighLatitudeRule[anchor.getAttribute('high_latitude_rule')];

    var fajrAngle = anchor.getAttribute('fajr_angle');
    if(fajrAngle != "") params["fajrAngle"] = parseFloat(fajrAngle);
    var ishaAngle = anchor.getAttribute('isha_angle');
    if(ishaAngle != "") params["ishaAngle"] = parseFloat(ishaAngle);
    var ishaInterval = anchor.getAttribute('isha_interval');
    if(ishaInterval != "") params["ishaInterval"] = parseFloat(ishaInterval);
    var fajrAdj = anchor.getAttribute('fajr_adjustment');
    if(fajrAdj != "") params.adjustments.farj = parseFloat(fajrAdj);
    var sunriseAdj = anchor.getAttribute('sunrise_adjustment');
    if(sunriseAdj != "") params.adjustments.sunrise = parseFloat(sunriseAdj);
    var dhuhrAdj = anchor.getAttribute('dhuhr_adjustment');
    if(dhuhrAdj != "") params.adjustments.dhuhr = parseFloat(dhuhrAdj);
    var asrAdj = anchor.getAttribute('asr_adjustment');
    if(asrAdj != "") params.adjustments.asr = parseFloat(asrAdj);
    var maghribAdj = anchor.getAttribute('maghrib_adjustment');
    if(maghribAdj != "") params.adjustments.maghrib = parseFloat(maghribAdj);
    var ishaAdj = anchor.getAttribute('isha_adjustment');
    if(ishaAdj != "") params.adjustments.isha = parseFloat(ishaAdj);

    var hijriAdj = anchor.getAttribute('hijri_adjustment');
    if(hijriAdj != "") moment().iMonthsAdjustments(hijriAdj);
    
    var coordinates = new adhan.Coordinates( latitude, longitude);
    var tmplSettings = { interpolate: /<\?js=(.+?)\?>/g, evaluate: /<\?js([^=-].+?)\?>/g, escape: /<\?js-(.+?)\?>/g };
    if(isDaily) {
      var moments = ngs_js_salat_time.get_prayer_times_moments(coordinates, m, params)
      var prayerTimes = moments.prayerTimes;
      var sunnahTimes = moments.sunnahTimes;
      prayerTimes.fajr = moment(prayerTimes.fajr);
      prayerTimes.sunrise = moment(prayerTimes.sunrise);
      prayerTimes.dhuhr = moment(prayerTimes.dhuhr);
      prayerTimes.asr = moment(prayerTimes.asr);
      prayerTimes.maghrib = moment(prayerTimes.maghrib);
      prayerTimes.isha = moment(prayerTimes.isha);
      sunnahTimes.lastThirdOfTheNight = moment(sunnahTimes.lastThirdOfTheNight);
      sunnahTimes.middleOfTheNight = moment(sunnahTimes.middleOfTheNight);
      var now = moment();
      var fajr_class = prayerTimes.fajr <= now && now < prayerTimes.sunrise ? "ngsjsst-select" : "";
      var chur_class = ""; //not a prayer, don't display it as selected //prayerTimes.sunrise <= now && now < prayerTimes.dhuhr ? "ngsjsst-select" : "";
      var dhur_class = prayerTimes.dhuhr <= now && now < prayerTimes.asr ? "ngsjsst-select" : "";
      var asr_class = prayerTimes.asr <= now && now < prayerTimes.maghrib ? "ngsjsst-select" : "";
      var magh_class = prayerTimes.maghrib <= now && now < prayerTimes.isha ? "ngsjsst-select" : "";
      var isha_class = prayerTimes.isha <= now && now < sunnahTimes.lastThirdOfTheNight ? "ngsjsst-select" : "";  // not .middleOfTheNight == isha ...
      var next_salat = prayerTimes.fajr;
      if(prayerTimes.fajr < now && now < prayerTimes.dhuhr) next_salat = prayerTimes.dhuhr;
      if(prayerTimes.dhuhr < now && now < prayerTimes.asr) next_salat = prayerTimes.asr;
      if(prayerTimes.asr < now && now < prayerTimes.maghrib) next_salat = prayerTimes.maghrib;
      if(prayerTimes.maghrib < now && now < prayerTimes.isha) next_salat = prayerTimes.isha;
      if(prayerTimes.isha < now && now < sunnahTimes.lastThirdOfTheNight) next_salat = sunnahTimes.lastThirdOfTheNight;
      // compute timeout until next salat
      setTimeout(function() { ngs_js_salat_time.build_table_anchor(anchor); }, (next_salat - now) );

      var data = {
          classes: {
            fajr: fajr_class, 
            churuk: chur_class, 
            dhuhr: dhur_class, 
            asr: asr_class, 
            maghrib: magh_class, 
            isha: isha_class
          },
          now: now,
          prayerTimes: _.clone(prayerTimes),
          sunnahTimes: _.clone(sunnahTimes),
          displayTimes: {
            fajr: prayerTimes.fajr.locale(locale).tz(timeZone).format(time_fmt), 
            churuk: prayerTimes.sunrise.locale(locale).tz(timeZone).format(time_fmt), 
            dhuhr: prayerTimes.dhuhr.locale(locale).tz(timeZone).format(time_fmt), 
            asr: prayerTimes.asr.locale(locale).tz(timeZone).format(time_fmt), 
            maghrib: prayerTimes.maghrib.locale(locale).tz(timeZone).format(time_fmt), 
            isha: prayerTimes.isha.locale(locale).tz(timeZone).format(time_fmt),
            hijriDate: (hijri_fmt == "" ? "" : m.clone().locale(locale).tz(timeZone).format(hijri_fmt)),
            gregorianDate: (date_fmt == "" ? "" : m.clone().locale(locale).tz(timeZone).format(date_fmt))
          },
          titles: {
            gregorianDay: titles[0],
            fajr: titles[1], 
            churuk: titles[2], 
            dhuhr: titles[3], 
            asr: titles[4], 
            maghrib: titles[5], 
            isha: titles[6],
            prevMonth: titles[7],
            nextMonth: titles[8],
            hijriDay: titles[9],
          }
        };
        var tmpl = 
          //FIXME: retrieve template code from <script type="text/x-template" id="xxx">...</script> or something like that, inside our anchor...
          //Then take it from a settings (with some default template - or juste this one?)
      '<table class="ngsjsst-salats ngsjsst-daily">' + 
      '  <thead>' + 
      '    <tr>' + 
      '      <th class="<?js= classes.fajr    ?>"><?js= titles.fajr    ?></th>' + 
      '      <th class="<?js= classes.churuk  ?>"><?js= titles.churuk  ?></th>' + 
      '      <th class="<?js= classes.dhuhr   ?>"><?js= titles.dhuhr   ?></th>' + 
      '      <th class="<?js= classes.asr     ?>"><?js= titles.asr     ?></th>' + 
      '      <th class="<?js= classes.maghrib ?>"><?js= titles.maghrib ?></th>' + 
      '      <th class="<?js= classes.isha    ?>"><?js= titles.isha    ?></th>' + 
      '    </tr>' + 
      '  </thead>' + 
      '  <tbody>' + 
      '    <tr class="ngsjsst-time">' + 
      '      <td class="ngsjsst-time <?js= classes.fajr    ?>"><?js= displayTimes.fajr ?></td>' + 
      '      <td class="ngsjsst-time <?js= classes.churuk  ?> ngsjsst-odd"><?js= displayTimes.churuk ?></td>' + 
      '      <td class="ngsjsst-time <?js= classes.dhuhr   ?>"><?js= displayTimes.dhuhr ?></td>' + 
      '      <td class="ngsjsst-time <?js= classes.asr     ?> ngsjsst-odd"><?js= displayTimes.asr ?></td>' + 
      '      <td class="ngsjsst-time <?js= classes.maghrib ?>"><?js= displayTimes.maghrib ?></td>' + 
      '      <td class="ngsjsst-time <?js= classes.isha    ?> ngsjsst-odd"><?js= displayTimes.isha ?></td>' + 
      '    </tr>' + 
      '  </tbody>' + 
      '  <tfoot>' + 
      '    <tr>' + 
      '      <th colspan="3" class="ngsjsst-day ngsjsst-hijri"><?js= displayTimes.hijriDate ?></th>' + 
      '      <th colspan="3" class="ngsjsst-day ngsjsst-gregorian"><?js= displayTimes.gregorianDate ?></th>' + 
      '    </tr>' + 
      '  </tfoot>' + 
      '</table>';
    }
    else {
      var toDay = moment();
      var thisMonth = m.month();
      var displayDays = [];
      while(m.month() == thisMonth) {
        var moments = ngs_js_salat_time.get_prayer_times_moments(coordinates, m, params)
        var prayerTimes = moments.prayerTimes;
        var sunnahTimes = moments.sunnahTimes;
        displayDays.push({
            isToday: (m.date() == toDay.date() && m.month() == toDay.month() && m.year() == toDay.year()),
            day: m.date(), 
            month: m.month(), 
            year: m.year(), 
            hijriDate: (hijri_fmt == '' ? '' : m.clone().locale(locale).tz(timeZone).format(hijri_fmt)),
            gregorianDate: (date_fmt == '' ? '' : m.clone().locale(locale).tz(timeZone).format(date_fmt)),
            displayTimes: {
              fajr: prayerTimes.fajr.locale(locale).tz(timeZone).format(time_fmt),
              churuk: prayerTimes.sunrise.locale(locale).tz(timeZone).format(time_fmt),
              dhuhr: prayerTimes.dhuhr.locale(locale).tz(timeZone).format(time_fmt),
              asr: prayerTimes.asr.locale(locale).tz(timeZone).format(time_fmt),
              maghrib: prayerTimes.maghrib.locale(locale).tz(timeZone).format(time_fmt),
              isha: prayerTimes.isha.locale(locale).tz(timeZone).format(time_fmt)
            },
            prayerTimes: _.clone(prayerTimes),
            sunnahTimes: _.clone(sunnahTimes)
          });
        m.add(1,'days');
      }
      var data = {
        hasHijriDate: hijri_fmt != "",
        hasGregorianDate: date_fmt != "",
        titles: {
          gregorianDay: titles[0],
          fajr: titles[1], 
          churuk: titles[2], 
          dhuhr: titles[3], 
          asr: titles[4], 
          maghrib: titles[5], 
          isha: titles[6],
          prevMonth: titles[7],
          nextMonth: titles[8],
          hijriDay: titles[9],
        },
        toDay: toDay,
        thisMonth: thisMonth,
        displayDays: displayDays
      };
      var tmpl = 
'<table class="ngsjsst-salats">' + 
'  <thead>' + 
'    <tr>' + 
'      <?js if(hasHijriDate) { ?><th class="ngsjsst-day ngsjsst-hijri"><?js= titles.hijriDay ?></th><?js } ?>' + 
'      <?js if(hasGregorianDate) {?><th class="ngsjsst-day ngsjsst-gregorian"><?js= titles.gregorianDay ?></th><?js } ?>' + 
'      <th><?js= titles.fajr ?></th>' + 
'      <th><?js= titles.churuk ?></th>' + 
'      <th><?js= titles.dhuhr ?></th>' + 
'      <th><?js= titles.asr ?></th>' + 
'      <th><?js= titles.maghrib ?></th>' + 
'      <th><?js= titles.isha ?></th>' + 
'    </tr>' + 
'  </thead>' + 
'  <tbody>' + 
'<?js' +
'  _.each(displayDays, function(displayDay){' + 
'    var displayTimes = displayDay.displayTimes;' +
'    ?>' +
'    <tr class="<?js= displayDay.day % 2 ? \'ngsjsst-odd\' : \'\' ?> <?js= displayDay.isToday ? \'ngsjsst-today\' : \'\' ?>">' + 
'    <?js if(hasHijriDate) { ?>' + 
'      <td class="ngsjsst-day ngsjsst-hijri"><?js= displayDay.hijriDate ?></td>' + 
'    <?js }' + 
'         if(hasGregorianDate) { ?>' + 
'      <td class="ngsjsst-day ngsjsst-gregorian"><?js= displayDay.gregorianDate ?></td>' + 
'    <?js } ?>' + 
'      <td class="ngsjsst-time"><?js= displayTimes.fajr ?></td>' + 
'      <td class="ngsjsst-time"><?js= displayTimes.churuk ?></td>' + 
'      <td class="ngsjsst-time"><?js= displayTimes.dhuhr ?></td>' + 
'      <td class="ngsjsst-time"><?js= displayTimes.asr ?></td>' + 
'      <td class="ngsjsst-time"><?js= displayTimes.maghrib ?></td>' + 
'      <td class="ngsjsst-time"><?js= displayTimes.isha ?></td>' + 
'    </tr><?js' + 
'  });' +
'?>' +
'  </tbody>' + 
'  <tfoot>' + 
'    <tr>' + 
'      <th colspan="<?js= 6 + (hasHijriDate ? 1 : 0) + (hasGregorianDate ? 1 : 0) ?>" style="text-align: center;">' + 
'        <a href="javascript:ngs_js_salat_time.go_prev_month();"><?js= titles.prevMonth ?></a> &nbsp; <a href="javascript:ngs_js_salat_time.go_next_month();"><?js= titles.nextMonth ?></a>' + 
'      </th>' + 
'    </tr>' + 
'  </tfoot>' + 
'</table>';
    }
    anchor.innerHTML = _.template(tmpl, tmplSettings)(data);
  },
  "go_next_month": function() {
    ngs_js_salat_time.build_table(ngs_js_salat_time.last_period.add(1,"months"));
  },
  "go_prev_month": function() {
    ngs_js_salat_time.build_table(ngs_js_salat_time.last_period.add(-1,"months"));
  }
};

window.addEventListener("load", function(){ngs_js_salat_time.build_table();}, false);