<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use backend\models\FinanceAddCost;
use backend\models\FinanceAddRevenue;
use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserCampaignBillTerm;
use backend\models\FinanceAdvertiserPrepayment;
use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceChannelCampaignBillTerm;
use backend\models\FinanceChannelPrepayment;
use backend\models\FinanceDeduction;
use backend\models\FinancePending;
use common\models\Advertiser;
use common\models\Channel;
use console\models\StatsUtil;
use DateTime;
use DateTimeZone;
use yii\console\Controller;

/**
 * Class TestController
 * @package console\controllers
 */
class FinanceBillController extends Controller
{

    public function genChannelBillByMonth()
    {
        $channels = Channel::findAll(['payment_term' => 30]);
        foreach ($channels as $channel) {
            $first_month = strtotime('first day of January ' . date('Y'));
            $current = time();
            while ($first_month < $current) {
                $current_month = date('F', $first_month);
                echo $current_month, PHP_EOL;
                $first_day_str = date('Y-m-d', strtotime('first day of ' . $current_month));
                $last_day_str = date('Y-m-d', strtotime('last day of ' . $current_month));
                $timezone = $channel->timezone;
                if (empty($timezone)) {
                    $timezone = 'Etc/GMT-8';
                }
                //当前时区的凌晨转为0时区
                $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day_str)), new DateTimeZone($timezone));
                $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day_str)), new DateTimeZone($timezone));
                $start_time = $start_date->getTimestamp();
                $end_time = $end_date->getTimestamp() + 3600 * 24;
                $bill_id = $channel->id . '_' . $start_date->format('Ym');
                $pre_bill = FinanceChannelBillTerm::findOne(['bill_id' => $bill_id]);
                if (empty($pre_bill)) {
                    $pre_bill = new FinanceChannelBillTerm();
                    $pre_bill->start_time = $start_time;
                    $pre_bill->end_time = $end_time;
                    $pre_bill->channel_id = $channel->id;
                    $pre_bill->invoice_id = 'spa-' . $channel->id . '-' . substr($first_day_str, 0, 7);
                    $pre_bill->time_zone = $timezone;
                    $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                    $pre_bill->bill_id = $channel->id . '_' . $start_date->format('Ym');
                    $pre_bill->save();
                }
                $first_month = strtotime("+1 month", $first_month);
            }
        }
    }

    public function genAdvBillByMonth()
    {
        $ads = Advertiser::findAll(['payment_term' => 30]);
        foreach ($ads as $ad) {
            $first_month = strtotime('first day of January ' . date('Y'));
            $current = time();
            while ($first_month < $current) {
                $current_month = date('F', $first_month);
                echo $current_month, PHP_EOL;
                $first_day_str = date('Y-m-d', strtotime('first day of ' . $current_month));
                $last_day_str = date('Y-m-d', strtotime('last day of ' . $current_month));
                $timezone = $ad->timezone;
                if (empty($timezone)) {
                    $timezone = 'Etc/GMT-8';
                }
                //当前时区的凌晨转为0时区
                $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day_str)), new DateTimeZone($timezone));
                $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day_str)), new DateTimeZone($timezone));
                $start_time = $start_date->getTimestamp();
                $end_time = $end_date->getTimestamp() + 3600 * 24;
                $bill_id = $ad->id . '_' . $start_date->format('Ym');
                $pre_bill = FinanceAdvertiserBillTerm::findOne(['bill_id' => $bill_id]);
                if (empty($pre_bill)) {
                    $pre_bill = new FinanceAdvertiserBillTerm();
                    $pre_bill->start_time = $start_time;
                    $pre_bill->end_time = $end_time;
                    $pre_bill->adv_id = $ad->id;
                    $pre_bill->invoice_id = 'spa-' . $ad->id . '-' . substr($first_day_str, 0, 7);
                    $pre_bill->time_zone = $timezone;
                    $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                    $pre_bill->bill_id = $ad->id . '_' . $start_date->format('Ym');
                    $pre_bill->save();
                }
                $first_month = strtotime("+1 month", $first_month);
            }
        }
    }

    public function actionGen($date)
    {
        //每个月2号建立一个预账单，
        //查找周期为month的广告主：
        $first_day = strtotime($date);
        $last_day = strtotime("$date 1 month -1 day");
        $ads = Advertiser::getNewAdv($first_day, $last_day);
        foreach ($ads as $ad) {
            $timezone = $ad->timezone;
            var_dump($first_day);
            if (empty($timezone)) {
                $timezone = 'Etc/GMT-8';
            }
            //当前时区的凌晨转为0时区
            $start_date = new DateTime(date('Y-m-d H:00', $first_day), new DateTimeZone($timezone));
            $end_date = new DateTime(date('Y-m-d H:00', $last_day), new DateTimeZone($timezone));
            $start_time = $start_date->getTimestamp();
            $end_time = $end_date->getTimestamp() + 3600 * 24;
            $bill_id = $ad->id . '_' . $start_date->format('Ym');
            $pre_bill = FinanceAdvertiserBillTerm::findOne(['bill_id' => $bill_id]);
            if (empty($pre_bill)) {
                $pre_bill = new FinanceAdvertiserBillTerm();
                $pre_bill->start_time = $start_time;
                $pre_bill->end_time = $end_time;
                $pre_bill->adv_id = $ad->id;
                $pre_bill->invoice_id = 'spa-' . $ad->id . '-' . substr($first_day, 0, 7);
                $pre_bill->time_zone = $timezone;
                $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                $pre_bill->bill_id = $ad->id . '_' . $start_date->format('Ym');
                $pre_bill->save();
                var_dump($pre_bill->getErrors());
            }
        }

        //每个月2号建立一个预账单，
        //查找周期为month的广告主：
        $channels = Channel::getNewChannel($first_day, $last_day);
        foreach ($channels as $channel) {
            $timezone = $channel->timezone;
            if (empty($timezone)) {
                $timezone = 'Etc/GMT-8';
            }
            //当前时区的凌晨转为0时区
            $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day)), new DateTimeZone($timezone));
            $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day)), new DateTimeZone($timezone));
            $start_time = $start_date->getTimestamp();
            $end_time = $end_date->getTimestamp() + 3600 * 24;
            $bill_id = $channel->id . '_' . $start_date->format('Ym');
//            var_dump($bill_id);
            $pre_bill = FinanceChannelBillTerm::findOne(['bill_id' => $bill_id]);
            if (empty($pre_bill)) {
                var_dump($bill_id);
                $pre_bill = new FinanceChannelBillTerm();
                $pre_bill->start_time = $start_time;
                $pre_bill->end_time = $end_time;
                $pre_bill->channel_id = $channel->id;
                $pre_bill->invoice_id = 'spa-' . $channel->id . '-' . substr($first_day, 0, 7);
                $pre_bill->time_zone = $timezone;
                $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                $pre_bill->bill_id = $channel->id . '_' . $start_date->format('Ym');
                $pre_bill->save();
            }
        }
    }

    public function actionStatsAdvertiserByMonth($date)
    {
        //统计上个月账单：
        $first_day = date("Y.m.01", strtotime($date));
        $last_day = date("Y.m.t", strtotime("$date 1 month -1 day"));
        $period = $first_day . '-' . $last_day;
        var_dump($period);
        //当前时区的凌晨转为0时区
        $last_bills = FinanceAdvertiserBillTerm::findAll(['period' => $period]);

        if (!empty($last_bills)) {
            foreach ($last_bills as $item) {
                $stats = new StatsUtil();
                $rows = $stats->statsAdvertiserMonthly($item->start_time, $item->end_time, $item->adv_id);
                if (!empty($rows)) {
                    $rows = json_decode(json_encode($rows), FALSE);
                    foreach ($rows as $obj) {
                        $bill_campaign = FinanceAdvertiserCampaignBillTerm::findOne(['bill_id' => $item->bill_id, 'campaign_id' => $obj->campaign_id, 'channel_id' => $obj->channel_id]);
                        if (empty($bill_campaign)) {
                            $bill_campaign = new FinanceAdvertiserCampaignBillTerm();
                        }
                        $bill_campaign->bill_id = $item->bill_id;
                        $bill_campaign->adv_id = $item->adv_id;
                        $bill_campaign->time_zone = $item->time_zone;
                        $bill_campaign->campaign_id = $obj->campaign_id;
                        $bill_campaign->channel_id = $obj->channel_id;
                        $bill_campaign->start_time = $item->start_time;
                        $bill_campaign->end_time = $item->end_time;
                        $bill_campaign->clicks = $obj->clicks;
                        $bill_campaign->unique_clicks = $obj->unique_clicks;
                        $bill_campaign->installs = $obj->installs;
                        $bill_campaign->match_installs = $obj->match_installs;
                        $bill_campaign->redirect_installs = $obj->redirect_installs;
                        $bill_campaign->redirect_match_installs = $obj->redirect_match_installs;
                        $bill_campaign->pay_out = $obj->pay_out;
                        $bill_campaign->adv_price = $obj->adv_price;
                        $bill_campaign->cost = $obj->cost;
                        $bill_campaign->redirect_cost = $obj->redirect_cost;
                        $bill_campaign->revenue = $obj->revenue;
                        $bill_campaign->redirect_revenue = $obj->redirect_revenue;
                        if (!$bill_campaign->save()) {
                            var_dump($bill_campaign->getErrors());
                        }
                    }
                }
                var_dump(date("Y-m-d H:i:s", $item->start_time), date("Y-m-d H:i:s", $item->end_time), $item->adv_id);
                $campaign_bill = FinanceAdvertiserCampaignBillTerm::statsByAdv($item->start_time, $item->end_time, $item->adv_id);
                if (!empty($campaign_bill) && !empty($campaign_bill->clicks)) {
                    $item->clicks = $campaign_bill->clicks;
                    $item->unique_clicks = $campaign_bill->unique_clicks;
                    $item->installs = $campaign_bill->installs;
                    $item->match_installs = $campaign_bill->match_installs;
                    $item->redirect_installs = $campaign_bill->redirect_installs;
                    $item->redirect_match_installs = $campaign_bill->redirect_match_installs;
                    $item->pay_out = $campaign_bill->pay_out;
                    $item->adv_price = $campaign_bill->adv_price;
                    $item->cost = $campaign_bill->cost;
                    $item->redirect_cost = $campaign_bill->redirect_cost;
                    $item->revenue = $campaign_bill->revenue;
                    $item->redirect_revenue = $campaign_bill->redirect_revenue;
                    $item->receivable = $campaign_bill->revenue;
                    $item->final_revenue = $campaign_bill->revenue;
                    $item->report_cost = $campaign_bill->cost;
                }
                $this->countAdvBillApr($item);
                $item->status = 1;
                $item->save();
                var_dump($item->getErrors());
            }
        }

    }

    public function actionStatsChannelByMonth($date)
    {
        //统计上个月账单：
        $first_day = date("Y.m.01", strtotime($date));
        $last_day = date("Y.m.t", strtotime("$date 1 month -1 day"));
        $period = $first_day . '-' . $last_day;
//        $period = $first_day_last_month . '-' . $last_day_last_month;
//        echo $period;
//        die();
        $last_bills = FinanceChannelBillTerm::findAll(['period' => $period]);
//        $last_bills = FinanceChannelBillTerm::findAll(['status' => 0]);
        if (!empty($last_bills)) {
            foreach ($last_bills as $item) {
                $stats = new StatsUtil();
                $rows = $stats->statsChannelMonthly($item->start_time, $item->end_time, $item->channel_id);
                if (!empty($rows)) {
                    $rows = json_decode(json_encode($rows), FALSE);
                    foreach ($rows as $obj) {
                        $bill_campaign = FinanceChannelCampaignBillTerm::findOne(['bill_id' => $item->bill_id, 'campaign_id' => $obj->campaign_id]);
                        if (empty($bill_campaign)) {
                            $bill_campaign = new FinanceChannelCampaignBillTerm();
                        }
                        $bill_campaign->bill_id = $item->bill_id;
                        $bill_campaign->channel_id = $item->channel_id;
                        $bill_campaign->time_zone = $item->time_zone;
                        $bill_campaign->campaign_id = $obj->campaign_id;
                        $bill_campaign->start_time = $item->start_time;
                        $bill_campaign->end_time = $item->end_time;
                        $bill_campaign->clicks = $obj->clicks;
                        $bill_campaign->unique_clicks = $obj->unique_clicks;
                        $bill_campaign->installs = $obj->installs;
                        $bill_campaign->match_installs = $obj->match_installs;
                        $bill_campaign->redirect_installs = $obj->redirect_installs;
                        $bill_campaign->redirect_match_installs = $obj->redirect_match_installs;
                        $bill_campaign->pay_out = $obj->pay_out;
                        $bill_campaign->adv_price = $obj->adv_price;
                        $bill_campaign->cost = $obj->cost;
                        $bill_campaign->redirect_cost = $obj->redirect_cost;
                        $bill_campaign->revenue = $obj->revenue;
                        $bill_campaign->redirect_revenue = $obj->redirect_revenue;
                        if (!$bill_campaign->save()) {
                            var_dump($bill_campaign->getErrors());
                        }
                    }
                }
                $campaign_bill = FinanceChannelCampaignBillTerm::statsByAdv($item->start_time, $item->end_time, $item->channel_id);

                if (!empty($campaign_bill) && !empty($campaign_bill->clicks)) {
                    $item->clicks = $campaign_bill->clicks;
                    $item->unique_clicks = $campaign_bill->unique_clicks;
                    $item->installs = $campaign_bill->installs;
                    $item->match_installs = $campaign_bill->match_installs;
                    $item->redirect_installs = $campaign_bill->redirect_installs;
                    $item->redirect_match_installs = $campaign_bill->redirect_match_installs;
                    $item->pay_out = $campaign_bill->pay_out;
                    $item->adv_price = $campaign_bill->adv_price;
                    $item->cost = $campaign_bill->cost;
                    $item->redirect_cost = $campaign_bill->redirect_cost;
                    $item->revenue = $campaign_bill->revenue;
                    $item->redirect_revenue = $campaign_bill->redirect_revenue;
                    $item->report_revenue = $campaign_bill->revenue;
                }
                $this->countChannelBillApr($item);
                $item->status = 1;
                $item->save();
                var_dump($item->getErrors());
            }
        }
    }

    /**
     * @param FinanceAdvertiserBillTerm $model
     */
    private function countAdvBillApr(&$model)
    {
        $model->final_revenue = $model->revenue;
        $model->receivable = $model->revenue;
        //deduction
        $deductions = FinanceDeduction::findAll(['adv_bill_id' => $model->bill_id]);
//        $deductions = FinanceDeduction::getConfirmOrCompensatedDeduction($model->bill_id);
        $model->deduction = 0;
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                $model->deduction += $item->deduction_revenue;
                $model->receivable -= $item->deduction_revenue;
                $model->final_revenue -= $item->deduction_revenue;
                $model->cost -= $item->deduction_cost;
                $financePending = FinancePending::getPendingBeforeDeduction($item->channel_bill_id, $item->adv_bill_id, $item->campaign_id, $item->channel);
                if (!empty($financePending)) {
                    FinancePending::confirmPending($financePending->id);
                }
            }
        }
        $pends = FinancePending::findAll(['adv_bill_id' => $model->bill_id, 'status' => 0]);
        $model->pending = 0;
        if (!empty($pends)) {
            foreach ($pends as $item) {
                $model->pending += $item->revenue;
                $model->receivable -= $item->revenue;
                $model->final_revenue -= $item->revenue;
                $model->cost -= $item->cost;
            }
        }
        //add revenue
        $addRevenue = FinanceAddRevenue::findAll(['advertiser_bill_id' => $model->bill_id]);
        $model->add_revenue = 0;
        if (!empty($addRevenue)) {
            foreach ($addRevenue as $item) {
                $model->add_revenue += $item->revenue;
                $model->receivable += $item->revenue;
                $model->final_revenue += $item->revenue;
                $model->cost += $item->cost;
            }
        }
        //prepayment
        $prepayments = FinanceAdvertiserPrepayment::findAll(['advertiser_bill_id' => $model->bill_id]);
        $model->prepayment = 0;
        if (!empty($prepayments)) {
            foreach ($prepayments as $item) {
                $model->prepayment += $item->prepayment;
            }
        }
    }

    /**
     * @param FinanceChannelBillTerm $model
     */
    private function countChannelBillApr(&$model)
    {
        $model->final_cost = $model->cost;
        $model->payable = $model->cost;

        //deduction
        //$deductions = FinanceDeduction::findAll(['channel_bill_id' => $model->bill_id,'status' => 1]);
        $deductions = FinanceDeduction::getConfirmOrCompensatedDeduction($model->bill_id);
        $model->deduction = 0;
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                $model->deduction += $item->deduction_cost;
                $model->payable -= $item->deduction_cost;
                $model->final_cost -= $item->deduction_cost;
                $model->revenue -= $item->deduction_revenue;
                $financePending = FinancePending::getPendingBeforeDeduction($item->channel_bill_id, $item->adv_bill_id, $item->campaign_id, $item->channel);
                if (!empty($financePending)) {
                    FinancePending::confirmPending($financePending->id);
                }
            }
        }

        //pending
        $pends = FinancePending::findAll(['channel_bill_id' => $model->bill_id, 'status' => 0]);
        $model->pending = 0;
        if (!empty($pends)) {
            foreach ($pends as $item) {
                $model->pending += $item->cost;
                $model->payable -= $item->cost;
                $model->final_cost -= $item->cost;
                $model->revenue -= $item->revenue;
            }
        }

//        add cost
        $addCost = FinanceAddCost::findAll(['channel_bill_id' => $model->bill_id]);
        $model->add_cost = 0;
        if (!empty($addCost)) {
            foreach ($addCost as $item) {
                $model->add_cost += $item->cost;
                $model->payable += $item->cost;
//                $model->payable += $item->cost;
//                $model->final_cost += $item->cost;
            }
        }

        //prepayment
        $prepayments = FinanceChannelPrepayment::findAll(['channel_bill_id' => $model->bill_id]);
        $model->apply_prepayment = 0;
        if (!empty($prepayments)) {
            foreach ($prepayments as $item) {
                $model->apply_prepayment += $item->prepayment;
            }
        }
    }
}