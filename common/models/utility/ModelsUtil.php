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
    const status = array(
        0 => 'No',
        1 => 'yes',
    );
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
        "wire" => "Wire",
        "paypal" => "Paypal"
    );

    const payment_term = array(
        "30" => 'NET30',
        "15" => 'NET15',
        "14" => 'Bi-weekly',
        "7" => 'Weekly',
    );

    const timezone = array(
        'Etc/GMT+11' => 'UTC-11',
        'Etc/GMT+10' => 'UTC-10',
        'Etc/GMT+9' => 'UTC-9',
        'Etc/GMT+8' => 'UTC-8',
        'Etc/GMT+7' => 'UTC-7',
        'Etc/GMT+6' => 'UTC-6',
        'Etc/GMT+5' => 'UTC-5',
        'Etc/GMT+4' => 'UTC-4',
        'Etc/GMT+3' => 'UTC-3',
        'Etc/GMT+2' => 'UTC-2',
        'Etc/GMT+1' => 'UTC-1',
        'Etc/GMT-0' => 'UTC-0',
        'Etc/GMT-1' => 'UTC+1',
        'Etc/GMT-2' => 'UTC+2',
        'Etc/GMT-3' => 'UTC+3',
        'Etc/GMT-4' => 'UTC+4',
        'Etc/GMT-5' => 'UTC+5',
        'Etc/GMT-6' => 'UTC+6',
        'Etc/GMT-7' => 'UTC+7',
        'Etc/GMT-8' => 'UTC+8',
        'Etc/GMT-9' => 'UTC+9',
        'Etc/GMT-10' => 'UTC+10',
        'Etc/GMT-11' => 'UTC+11',
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

    const campaign_tag = array(
        1 => 'Normal',
        2 => 'Good',
        3 => 'Private',
        4 => 'Keep',
    );

    const apply_status = array(
        '1' => 'Applying',
        '2' => 'Approved',
        '3' => 'Rejected',
    );

    const campaign_status = array(
        '' => 'All',
        '1' => 'Running',
        '2' => 'Paused',
//        '3' => 'Rejected',
    );

    const pending_status = array(
        '0' => 'Pending',
        '1' => 'Confirmed',
//        '3' => 'Rejected',
    );

    const redirect_status = array(
        '0' => 'closed',
        '1' => 'active',
    );

    const  deduction_type = array(
        1 => 'discount',
        2 => 'install deduction',
        3 => 'fine',
    );

    const deduction_status = array(
        0 => 'Communicating',
        1 => 'Confirmed',
        2 => 'Compensated'
    );

    const campaign_direct = array(
//        0 => '',
        1 => 'Direct',
        2 => '1st',
        3 => '2nd',
        4 => '3rd+',
    );

    const compensation_status = array(
//        0:approval,1:approved,2:rejtct
        0 => 'Approval',
        1 => 'Approved',
        2 => 'Reject',
    );

    const receivable_status = array(
        1 => 'Pending',
        2 => 'BD Leader Approval',
        3 => 'BD Leader Reject',
        4 => 'Finance Approval',
        5 => 'Finance Reject',
        6 => 'Receivable',
        7 => 'Received',
        8 => 'Overdue',
    );

    const receivable_status_bd = array(
        1 => 'Pending',
        2 => 'BD Leader Approval',
    );

    const payable_status = array(
        1 => 'Pending',
        2 => 'OM Leader Approval',
        3 => 'OM Leader Reject',
        4 => 'Finance Approval',
        5 => 'Finance Reject',
        6 => 'Payable',
        7 => 'Paid',
    );

    const payable_status_om = array(
        1 => 'Pending',
        2 => 'OM Leader Approval',
    );

    const update_type = array(
        1 => 'Campaign',
        2 => 'S2S',
    );

    const effect_type = array(
        0 => 'effective',
        1 => 'ineffective',
    );

    const black_action = array(
        0 => 'Notice',
        1 => 'No S2S',
    );

    const pricing_mode_new = array(
        'cpi' => "CPI",
        'cpa' => "CPA",
        'cpm' => "CPM",
        'cpc' => "CPC",
        'cpo' => "CPO",
        'cps' => "CPS",
    );

    const platform_new = array(
        'ios' => 'IOS',
        'android' => 'Android',
        'windows' => 'Windows',
        'others' => 'Others',
    );

    public static function getPayableStatus($k)
    {
        return static::getValue(static::payable_status, $k);
    }

    public static function getPaymentTerm($k)
    {
        return static::getValue(static::payment_term, $k);
    }

    public static function getReceivableStatus($k)
    {
        return static::getValue(static::receivable_status, $k);
    }

    public static function getTimezone($k)
    {
        return static::getValue(static::timezone, $k);
    }

    public static function getCompensationStatus($k)
    {
        return static::getValue(static::compensation_status, $k);
    }

    public static function getCampaignDirect($k)
    {
        return static::getValue(static::campaign_direct, $k);
    }

    public static function getDeductionStatus($k)
    {
        return static::getValue(static::deduction_status, $k);
    }

    public static function getDeductionType($k)
    {
        return static::getValue(static::deduction_type, $k);
    }

    public static function getRedirectStatus($k)
    {
        return static::getValue(static::redirect_status, $k);
    }

    public static function getPendingStatus($k)
    {
        return static::getValue(static::pending_status, $k);
    }

    public static function getCampaignStatus($k)
    {
        return static::getValue(static::campaign_status, $k);
    }

    public static function getApplyStatus($k)
    {
        return static::getValue(static::apply_status, $k);
    }

    public static function getCampaignTag($k)
    {
        return static::getValue(static::campaign_tag, $k);
    }

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

    public static function getStatus($k)
    {
        return static::getValue(static::status, $k);
    }

    public static function getDevice($k)
    {
        return static::getValue(static::device, $k);
    }

    public static function getOpenType($k)
    {
        return static::getValue(static::open_type, $k);
    }

    public static function getSettlementType($v)
    {
        return static::getValue(static::settlement_type, $v);
    }

    public static function getUpdateType($k)
    {
        return static::getValue(static::update_type, $k);
    }

    public static function getEffectType($k)
    {
        return static::getValue(static::effect_type, $k);
    }

    public static function getBlackAction($k)
    {
        return static::getValue(static::black_action, $k);
    }

    public static function getPricingModeNew($k)
    {
        return static::getValue(static::pricing_mode_new, $k);
    }

    public static function getPlatformNew($k)
    {
        return static::getValue(static::platform_new, $k);
    }
}