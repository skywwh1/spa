<?php
/**
 * ctt
 */

namespace common\utility;



use \DateTime;
use \DateTimeZone;
class TimeZoneUtil
{

    public static function setTimeZoneGMT8Before()
    {
        $time_zone = 'Etc/GMT-8';
        $beginTheDay=mktime(0,0,0,date('m'),date('d'),date('Y'));

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($time_zone));
        $date->setTimestamp($beginTheDay);
        $beginTheDay = $date->format('Y-m-d');

        $beginTheDay = new DateTime($beginTheDay, new DateTimeZone($time_zone));
        $beginTheDay = $beginTheDay->getTimestamp();

        return $beginTheDay;
    }

    public  static function getNextMonthFirstDay($date) {
        return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month'));
    }
    public static function getNextMonthLastDay($date) {
        return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +2 month -1 day'));
    }

    public  static function getNextMonthFirstDayTime($date) {
        return strtotime(date('Y-m-01', strtotime($date)) . ' +1 month');
    }
    public static function getNextMonthLastDayTime($date) {
        return strtotime(date('Y-m-01', strtotime($date)) . ' +2 month -1 day');
    }

    public static function getPrevMonthFirstDay($date) {
        return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' -1 month'));
    }
    public static function getPrevMonthLastDay($date) {
        return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' -1 day'));
    }

    public static function getPrevMonthFirstDayTime($date) {
        return strtotime(date('Y-m-01', strtotime($date)) . ' -1 month');
    }
    public static function getPrevMonthLastDayTime($date) {
        return strtotime(date('Y-m-01', strtotime($date)) . ' -1 day');
    }

    public static function initGMT8BeforeDate()
    {
        $time_zone = 'Etc/GMT-8';
        $beginTheDay = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($time_zone));
        $date->setTimestamp($beginTheDay);
        $beginTheDay = $date->format('Y-m-d');

        return $beginTheDay;
    }

    public static function getSearchDate($date){
        return empty($date)?self::initGMT8BeforeDate():$date;
    }

    public  static function getThisMonthFirstDayTime($date) {
        return strtotime(date('Y-m-01', strtotime($date)));
    }
    public static function getThisMonthLastDayTime($date) {
        return strtotime(date('Y-m-01', $date) . ' +1 month -1 day');
    }

    public static function initDateTimeZone($time_zone)
    {
        $beginTheDay = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($time_zone));
        $date->setTimestamp($beginTheDay);
//        $beginTheDay = $date->format('Y-m-d');

        return $date->getTimestamp();
    }
}