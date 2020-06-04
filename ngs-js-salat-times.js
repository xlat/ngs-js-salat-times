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
    var salat_table = "";
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
      salat_table += `
      <table class="ngsjsst-salats ngsjsst-daily">
          <thead>
            <tr>
              <th class="${fajr_class}">${titles[1]}</th>
              <th class="${chur_class} ngsjsst-odd">${titles[2]}</th>
              <th class="${dhur_class}">${titles[3]}</th>
              <th class="${asr_class} ngsjsst-odd">${titles[4]}</th>
              <th class="${magh_class}">${titles[5]}</th>
              <th class="${isha_class} ngsjsst-odd">${titles[6]}</th>
            </tr>
          </thead>
          <tbody>
            <tr class="ngsjsst-time">
              <td class="ngsjsst-time ${fajr_class}">${prayerTimes.fajr.locale(locale).tz(timeZone).format(time_fmt)}</td>
              <td class="ngsjsst-time ${chur_class} ngsjsst-odd">${prayerTimes.sunrise.locale(locale).tz(timeZone).format(time_fmt)}</td>
              <td class="ngsjsst-time ${dhur_class}">${prayerTimes.dhuhr.locale(locale).tz(timeZone).format(time_fmt)}</td>
              <td class="ngsjsst-time ${asr_class} ngsjsst-odd">${prayerTimes.asr.locale(locale).tz(timeZone).format(time_fmt)}</td>
              <td class="ngsjsst-time ${magh_class}">${prayerTimes.maghrib.locale(locale).tz(timeZone).format(time_fmt)}</td>
              <td class="ngsjsst-time ${isha_class} ngsjsst-odd">${prayerTimes.isha.locale(locale).tz(timeZone).format(time_fmt)}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="ngsjsst-day ngsjsst-hijri">${hijri_fmt == '' ? '' : m.clone().locale(locale).tz(timeZone).format(hijri_fmt)}</th>
              <th colspan="3" class="ngsjsst-day ngsjsst-gregorian">${date_fmt == '' ? '' : m.clone().locale(locale).tz(timeZone).format(date_fmt)}</th>
            </tr>
          </tfoot>
        </table>
      `;
    }
    else {
      if(hijri_fmt) salat_table += `<th class="ngsjsst-day ngsjsst-hijri">${titles[9]}</th>`;
      if(date_fmt) salat_table += `\n<th class="ngsjsst-day ngsjsst-gregorian">${titles[0]}</th>`;
      salat_table = `
      <table class="ngsjsst-salats">
        <thead>
          <tr>
            ${salat_table}
            <th>${titles[1]}</th>
            <th>${titles[2]}</th>
            <th>${titles[3]}</th>
            <th>${titles[4]}</th>
            <th>${titles[5]}</th>
            <th>${titles[6]}</th>
          </tr>
        </thead>
        <tbody>
        `;
      var toDay = moment();
      var thisMonth = m.month();
      while(m.month() == thisMonth) {
        var moments = ngs_js_salat_time.get_prayer_times_moments(coordinates, m, params)
        var prayerTimes = moments.prayerTimes;
        var sunnahTimes = moments.sunnahTimes;
          var tr_class = "";
        if(m.date()%2) tr_class = "ngsjsst-odd";
        if(m.date() == toDay.date() && m.month() == toDay.month() && m.year() == toDay.year()) tr_class += " ngsjsst-today";
        salat_table += '<tbody><tr class="' + tr_class + '">';
        if(hijri_fmt != '') salat_table += `<td class="ngsjsst-day ngsjsst-hijri">${m.clone().locale(locale).tz(timeZone).format(hijri_fmt)}</td>`;
        if(date_fmt != '') salat_table += `<td class="ngsjsst-day ngsjsst-gregorian">${m.clone().locale(locale).tz(timeZone).format(date_fmt)}</td>`;
        salat_table += `<td class="ngsjsst-time">${prayerTimes.fajr.locale(locale).tz(timeZone).format(time_fmt)}</td>`;
        salat_table += `<td class="ngsjsst-time">${prayerTimes.sunrise.locale(locale).tz(timeZone).format(time_fmt)}</td>`;
        salat_table += `<td class="ngsjsst-time">${prayerTimes.dhuhr.locale(locale).tz(timeZone).format(time_fmt)}</td>`;
        salat_table += `<td class="ngsjsst-time">${prayerTimes.asr.locale(locale).tz(timeZone).format(time_fmt)}</td>`;
        salat_table += `<td class="ngsjsst-time">${prayerTimes.maghrib.locale(locale).tz(timeZone).format(time_fmt)}</td>`;
        salat_table += `<td class="ngsjsst-time">${prayerTimes.isha.locale(locale).tz(timeZone).format(time_fmt)}</td>`;
        salat_table += "</tr>\n";
        m.add(1,'days');
      }
      salat_table += '</tbody>';
      salat_table += `<tfoot><tr><th colspan="${6 + (hijri_fmt==""?0:1) + (date_fmt==""?0:1)}" style="text-align: center;"><a href="javascript:ngs_js_salat_time.go_prev_month();">${titles[7]}</a> &nbsp; <a href="javascript:ngs_js_salat_time.go_next_month();">${titles[8]}</a></th></tr></tfoot>`;
      salat_table += "</table>\n\n";
    }
    anchor.innerHTML = salat_table;
  },
  "go_next_month": function() {
    ngs_js_salat_time.build_table(ngs_js_salat_time.last_period.add(1,"months"));
  },
  "go_prev_month": function() {
    ngs_js_salat_time.build_table(ngs_js_salat_time.last_period.add(-1,"months"));
  }
};

window.addEventListener("load", function(){ngs_js_salat_time.build_table();}, false);