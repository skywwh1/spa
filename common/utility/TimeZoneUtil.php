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

}