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
 * @property integer $type
 * @property integer $is_send
 * @property integer $send_time
 * @property integer $is_effected
 * @property integer $effect_time
 * @property integer $create_time
 */
class CampaignStsUpdate extends \yii\db\ActiveRecord
{
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
            [['campaign_id', 'is_send', 'effect_time', 'create_time'], 'required'],
            [['campaign_id', 'channel_id', 'type', 'is_send', 'send_time', 'is_effected', 'effect_time', 'create_time'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'is_send' => 'Is Send',
            'send_time' => 'Send Time',
            'is_effected' => 'Is Effected',
            'effect_time' => 'Effect Time',
            'create_time' => 'Create Time',
        ];
    }
}
