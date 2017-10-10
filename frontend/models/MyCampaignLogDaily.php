<?php

namespace frontend\models;

use common\models\CampaignLogDaily;

class MyCampaignLogDaily extends CampaignLogDaily
{
    public $start;
    public $end;
    public $timezone;
    public $cvr0;
    public $campaign_name;

    public static function dailyReport(){
        setlocale(LC_ALL,'Etc/GMT-8');
        $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $end = mktime(0, 0, 0, date('m') , date('d')+1, date('Y'));

        $query = MyCampaignLogHourly::find();

        $query->alias('clh');
        // add conditions that should always apply here
        $query->select([
            'sum(clh.clicks) clicks',
            'sum(clh.unique_clicks) unique_clicks',
            'sum(clh.installs) installs',
            'avg(clh.pay_out) pay_out',
            'SUM(clh.cost) revenue',
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'channel_id' => \Yii::$app->user->getId(),
        ]);
        $query->andFilterWhere(['>=', 'time', $start])
         ->andFilterWhere(['<', 'time', $end]);

//        var_dump($query->createCommand()->sql);
//        var_dump($start);
//        var_dump($end);
//        var_dump(\Yii::$app->user->getId());
//        die();
        return $query->one();
    }
}
