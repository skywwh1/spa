<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_sts_update".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $name
 * @property string $value
 * @property string $old_value
 * @property integer $type
 * @property integer $is_send
 * @property integer $send_time
 * @property integer $is_effected
 * @property integer $effect_time
 * @property integer $creator
 * @property integer $create_time
 */
class CampaignStsUpdate extends \yii\db\ActiveRecord
{
    public $target_geo;
    public $creative_link;
    public $creative_type;
    public $channel_name;
    public $campaign_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_sts_update';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'is_send', 'effect_time'], 'required'],
            [['campaign_id', 'channel_id', 'type', 'is_send', 'send_time', 'is_effected', 'creator', 'create_time'], 'integer'],
            [['effect_time', 'name', 'value', 'old_value','target_geo','creative_link','campaign_name','channel_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'name' => 'Name',
            'value' => 'Value',
            'old_value' => 'Old Value',
            'type' => 'Type',
            'is_send' => 'If Send Notify',
            'send_time' => 'Send Time',
            'is_effected' => 'Is Effected',
            'effect_time' => 'Effect Time',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
        ];
    }

    public function beforeSave($insert)
    {

        if ($insert) {
            $this->create_time = time();
            $this->creator = Yii::$app->user->identity->getId();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return array|CampaignStsUpdate[]
     */
    public static function getStsUpdateCap()
    {
        return static::find()->where(['is_effected' => 0, 'type' => 2, 'name' => 'cap'])
            ->andWhere(['<', 'effect_time', time()])
            ->all();
    }

    /**
     * @return array|CampaignStsUpdate[]
     */
    public static function getStsSendMail()
    {
        return static::find()->where(['is_send' => 1, 'is_effected' => 0])->limit(10)->all();
    }

    public static function getSendEmail()
    {

    }

    /**
     * @return array|CampaignStsUpdate[]
     */
    public static function getStsUpdatePay()
    {
        return static::find()->where(['is_effected' => 0, 'type' => 2, 'name' => 'payout'])
            ->andWhere(['<', 'effect_time', time()])
            ->all();
    }

    /**
     * @return array|CampaignStsUpdate[]
     */
    public static function getStsUpdateGeo()
    {
        return static::find()->where(['is_effected' => 0, 'type' => 1, 'name' => 'update-geo'])
            ->andWhere(['<', 'effect_time', time()])
            ->all();
    }

    /**
     * @return array|CampaignStsUpdate[]
     */
    public static function getStsUpdateCreativeLink()
    {
        return static::find()->where(['is_effected' => 0, 'type' => 1, 'name' => 'update-creative'])
            ->andWhere(['<', 'effect_time', time()])
            ->all();
    }
}
