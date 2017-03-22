<?php

namespace common\models;

/**
 * This is the model class for table "campaign_log_hourly".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $time
 * @property string $time_format
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $installs
 * @property integer $match_installs
 * @property string $pay_out
 * @property string $adv_price
 * @property string $daily_cap
 * @property string $cap
 * @property string $cost
 * @property string $revenue
 * @property integer $create_time
 * @property Campaign $campaign
 * @property Channel $channel
 */
class CampaignLogHourly extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_log_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time'], 'required'],
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'revenue'], 'number'],
            [['time_format', 'daily_cap', 'cap'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'time' => 'Time',
            'time_format' => 'Time Format',
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'pay_out' => 'Pay Out',
            'adv_price' => 'Adv Price',
            'daily_cap' => 'Daily Cap',
            'cap' => 'Cap',
            'cost' => 'Cost',
            'revenue' => 'Revenue',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $time
     * @return CampaignLogHourly
     */
    public static function findIdentity($campaign_id, $channel_id, $time)
    {
        return static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'time' => $time]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }


    /**
     * @return array|CampaignLogHourly[]
     */
    public static function findNullPrice()
    {
        var_dump(static::find()->where('pay_out=0')->orWhere('adv_price=0')->createCommand()->sql);
        return static::find()->where('pay_out=0')->orWhere('adv_price=0')->all();
    }

    public static function findNullCap()
    {
        return static::find()->where(['cap' => null])->orWhere(['daily_cap' => null])->all();
    }

    /**
     * @param $start
     * @param $end
     * @param $campaign_id
     * @param $channel_id
     * @return array|null|CampaignLogHourly
     */
    public static function findDateReport($start, $end, $campaign_id, $channel_id)
    {
        $query = ReportChannelHourly::find();
        $query->alias('clh');
//        $a = strtotime($this->start);
        $query->select([
            'clh.campaign_id',
            'clh.channel_id',
            'clh.time timestamp',
            'clh.time_format',
            'clh.daily_cap',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $campaign_id,
            'channel_id' => $channel_id,

        ]);
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
//        var_dump($start);
//        var_dump($end);
//        var_dump($query->createCommand()->sql);
//        die();
        return $query->one();
    }
}
