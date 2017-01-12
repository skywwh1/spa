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
        4 => "CPC",);
    const status = array();
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
        1 => 'SuperADS',
        2 => 'HighMob',
        3 => 'Hasoffers',
        4 => 'Fund',
        5 => 'Mediabuy',
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

    public static function getValue($data, $k)
    {
        return ArrayHelper::getValue($data, $k);
    }

}