<?php

namespace common\models;


class ReportSummaryHourly extends CampaignLogHourly
{

    public $campaign_name;
    public $channel_name;
    public $adv_name;
    public $campaign_uuid;
    public $bd;
    public $om;
    public $pm;
    public $category;
    public $geo;
    public $price_model;
    public $platform;
    public $device;
    public $traffic_source;
    public $subid;

    public $cvr;
    public $match_cvr;
    public $def;
    public $deduction_percent;
    public $profit;
    public $margin;

    public $type;
    public $start;
    public $end;
    public $timestamp;

    public function attributeLabels()
    {
        return [
            'cvr' => 'Cvr',
            'cost' => 'Cost',
            'match_cvr' => 'Match Cvr',
            'revenue' => 'Revenue',
            'def' => 'Def',
            'deduction_percent' => 'Deduction Percent',
            'profit' => 'Profit',
            'margin' => 'Margin',
            'type' => 'Type',
            'adv_name' => 'Advertiser',

            'price_model' => 'Price Model',
            'device' => 'Device',
            'platform' => 'Platform',
            'campaign_name' => 'Campaign',
            'campaign_uuid' => 'Campaign UUID',
            'bd' => 'BD',
            'om' => 'OM',
            'pm' => 'PM',
            'category' => 'Category',
            'geo' => 'GEO',
            'traffic_source' => 'Traffic Source',
            'subid' => 'subid',
        ];
    }
}
