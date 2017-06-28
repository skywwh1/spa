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
use backend\models\FinanceCompensation;
use backend\models\FinanceDeduction;
use backend\models\FinancePending;
use backend\models\LogClick3;
use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignSubChannelLogRedirect;
use common\models\Channel;
use common\models\Config;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogCheckClicksDaily;
use common\models\LogClick;
use common\models\LogClick2;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\RedirectLog;
use common\models\Stream;
use common\utility\MailUtil;
use console\models\StatsUtil;
use DateTime;
use DateTimeZone;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\db\Query;

/**
 * Class TestController
 * @package console\controllers
 */
class ClickController extends Controller
{

    public function actionCheckClicks()
    {

//        $query = ReportChannelHourly::find();
        $time = strtotime(date('Y-m-d', time()));

        $query = new Query();
        $query->select([
            'clh.campaign_id',
            'clh.channel_id',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'SUM(clh.redirect_installs) redirect_installs',
            'SUM(clh.redirect_match_installs) redirect_match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
            'SUM(clh.cost) cost',
            'SUM(clh.revenue) revenue',
            'SUM(clh.redirect_cost) redirect_cost',
            'SUM(clh.redirect_revenue) redirect_revenue',
            'SUM(clh.revenue)/SUM(clh.clicks) cvr'
        ]);
        $query->from('campaign_log_hourly clh');

        $query->andFilterWhere(['>=', 'time', $time]);
        $query->andFilterWhere(['<', 'time', $time + 24 * 3600]);

        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'timestamp',
        ]);
        $query->having(['>=', 'clicks', 5000000]);
        $query->andHaving(['<=', 'cvr', 0.0003]);

        echo $query->createCommand()->sql . "\n";
        $rows = $query->all();
        if (!empty($rows)) {
            $rows = json_decode(json_encode($rows));
            foreach ($rows as $item) {
                $log = LogCheckClicksDaily::findOne(['campaign_id' => $item->campaign_id, 'channel_id' => $item->channel_id, 'time' => $item->timestamp]);
                if (empty($log)) {
                    $log = new LogCheckClicksDaily();
                    $log->time = $item->timestamp;
                    $log->campaign_id = $item->campaign_id;
                    $log->channel_id = $item->channel_id;
                    $log->revenue = $item->revenue;
                    $log->clicks = $item->clicks;
                    $log->match_install = $item->match_installs;
                    $log->match_cvr = $item->cvr;
                    $log->save();
                }
            }
        }

        $emails = LogCheckClicksDaily::find()->where(['is_send' => 0])->all();
        if (!empty($emails)) {
            MailUtil::checkClicks($emails);
            LogCheckClicksDaily::updateAll(['is_send' => 1]);
        }

    }
}