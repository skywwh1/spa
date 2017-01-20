<?php
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/11/2017
 * Time: 1:18 AM
 */
class ModelsUtil
{

    const settlement_type = array(1 => 'Weekly', 2 => 'Monthly');
    const pricing_mode = array(
        1 => "CPI",
        2 => "CPA",
        3 => "CPM",
        4 => "CPC",
        5 => "CPO",
        6 => "CPS",
    );
    const status = array();
    const create_type = array(
        1 => "banner",
        2 => "video",
    );
    const  open_type = array(
        1 => "open",
        0 => "private",
    );
    const link_type = array();
    const user_type = array(
        0 => "Admin",
        7 => "PM",
        8 => "BD",
        9 => "OM"
    );
    const advertiser_status = array(
        1 => 'Available',
        2 => 'Building',
        3 => 'Trying',
        4 => 'Pending',
        5 => 'Excluded',
    );

    const system = array(
        1 => 'ADV Server',
        2 => 'Adjust',
        3 => 'Appsflyer',
        4 => 'Kochava',
        5 => 'MAT',
        6 => 'Tune',
        7 => 'TD',
        0 => 'Others',
    );

    const traffic_source = array(
        1 => 'Non-Incent',
        2 => 'Incent',
    );

    const user_status = array(
        0 => 'No',
        1 => 'yes',
    );

    const device = array(
        1 => 'Phone',
        2 => 'PC(online)',
        3 => 'Tablet',
        0 => 'All Device',
    );

    const platform = array(
        1 => 'IOS',
        2 => 'Android',
        3 => 'Windows',
        0 => 'Others',


    );

    const track_way = array(
        0 => 'S2S',
        1 => 'SDK',
    );

    const campaign_other_setting = array(
        0 => 'Filter Duplicate',
        1 => 'Fast Jump'
    );

    const payment_way = array(
        1 => "Wire",
        2 => "Paypal"
    );

    const payment_term = array(
        1 => 'NET30',
        2 => 'NET15',
        3 => 'Bi-weekly',
        4 => 'Weekly',
    );

    const timezone = array(
        '-11' => 'UTC-11',
        '-10' => 'UTC-10',
        '-9' => 'UTC-9',
        '-8' => 'UTC-8',
        '-7' => 'UTC-7',
        '-6' => 'UTC-6',
        '-5' => 'UTC-5',
        '-4' => 'UTC-4',
        '-3' => 'UTC-3',
        '-2' => 'UTC-2',
        '-1' => 'UTC-1',
        '0' => 'UTC0',
        '1' => 'UTC+1',
        '2' => 'UTC+2',
        '3' => 'UTC+3',
        '4' => 'UTC+4',
        '5' => 'UTC+5',
        '5.5' => 'UTC+5.5',
        '6' => 'UTC+6',
        '7' => 'UTC+7',
        '8' => 'UTC+8',
        '9' => 'UTC+9',
        '10' => 'UTC+10',
        '11' => 'UTC+11',
    );

    const offerType = array(
        'apk' => 'Apk',
        'incent' => 'Incent',
        'non-incent' => 'Non Incent',
        'subscription' => 'Subscription',
        'facebook' => 'Facebook',
        'adwords' => 'Adwords',
        'others' => 'Others',
    );

    const trafficType = array(
        'email' => 'Email',
        'incent' => 'Incent',
        'pop' => 'Pop',
        'social-media' => 'Social Media',
        'display' => 'Display',
        'direct-publisher' => 'Direct Publisher',
        'video' => 'Video',
        'other' => 'Other',
    );

    public static function getValue($data, $k)
    {
        return ArrayHelper::getValue($data, $k);
    }

    public static function getPlatform($k)
    {
        return static::getValue(static::platform, $k);
    }

    public static function getTrafficeSource($k)
    {
        return static::getValue(static::traffic_source, $k);
    }

    public static function getCreateType($k)
    {
        return static::getValue(static::create_type, $k);
    }

    public static function getPricingMode($k)
    {
        return static::getValue(static::pricing_mode, $k);
    }

    public static function getSystem($k)
    {
        return static::getValue(static::system, $k);
    }

    public static function getAdvertiserStatus($k)
    {
        return static::getValue(static::advertiser_status, $k);
    }

}