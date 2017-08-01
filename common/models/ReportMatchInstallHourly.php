<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report_match_install_hourly".
 *
 * @property integer $campaign_id
 * @property integer $time
 * @property integer $advertiser_id
 * @property integer $installs
 * @property integer $installs_in
 * @property string $revenue
 * @property integer $update_time
 * @property integer $create_time
 *
 * @property Campaign $campaign
 */
class ReportMatchInstallHourly extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_match_install_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'time', 'advertiser_id'], 'required'],
            [['campaign_id', 'time', 'advertiser_id', 'installs', 'installs_in', 'update_time', 'create_time'], 'integer'],
            [['revenue'], 'number'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaign_id' => 'Campaign ID',
            'time' => 'Time',
            'advertiser_id' => 'Advertiser ID',
            'installs' => 'Installs',
            'installs_in' => 'Installs In',
            'revenue' => 'Revenue',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
            $this->update_time = time();
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @param LogFeed $feed
     * @return bool
     */
    public static function updateInstalls(LogFeed $feed)
    {
        $campaign_id = $feed->campaign_id;
        $hourly = date('Y-m-d H:00', $feed->feed_time);
        $time = strtotime($hourly);
        $exists = self::find()->where(['campaign_id' => $campaign_id, 'time' => $time])->exists();
        if ($exists) {
            if ($feed->is_redirect) {
                self::updateAllCounters(['installs' => 1, 'installs_in' => 1, 'revenue' => $feed->adv_price], ['campaign_id' => $campaign_id, 'time' => $time]);
            } else {
                self::updateAllCounters(['installs' => 1, 'revenue' => $feed->adv_price], ['campaign_id' => $campaign_id, 'time' => $time]);
            }
        } else {
            $report = new ReportMatchInstallHourly();
            $report->campaign_id = $campaign_id;
            $report->time = $time;
            $report->installs = 1;
            if ($feed->is_redirect) {
                $report->installs_in = 1;
            }
            $report->revenue = $feed->adv_price;
            $report->advertiser_id = $report->campaign->advertiser;
            $report->save();
        }
    }
}
