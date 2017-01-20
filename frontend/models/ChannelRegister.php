<?php

namespace frontend\models;

use common\models\Channel;
use Yii;

/**
 * This is the model class for table "channel_register".
 *
 * @property integer $id
 * @property integer $channel_id
 * @property string $vertical
 * @property string $offer_type
 * @property string $other_network
 * @property string $vertical_interested
 * @property string $special_offer
 * @property string $regions
 * @property string $traffic_type
 * @property string $best_time
 * @property string $time_zone
 * @property string $suggested_am
 * @property string $additional_notes
 * @property string $another_info
 *
 * @property Channel $channel
 */
class ChannelRegister extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vertical', 'offer_type', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'traffic_type', 'best_time', 'time_zone'], 'required'],
            [['channel_id'], 'integer'],
            [['vertical', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'best_time', 'time_zone', 'suggested_am', 'additional_notes', 'another_info'], 'string', 'max' => 255],
            [['channel_id', 'offer_type', 'traffic_type',], 'safe'],
            [['channel_id'], 'unique'],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'vertical' => 'Vertical',
            'offer_type' => 'Offer Type',
            'other_network' => 'Other Network',
            'vertical_interested' => 'Vertical Interested',
            'special_offer' => 'Special Offer',
            'regions' => 'Regions',
            'traffic_type' => 'Traffic Type',
            'best_time' => 'Best Time',
            'time_zone' => 'Time Zone',
            'suggested_am' => 'Suggested Am',
            'additional_notes' => 'Additional Notes',
            'another_info' => 'Another Info',
        ];
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
        if (parent::beforeSave($insert)) {
            if (!empty($this->offer_type) && is_array($this->offer_type)) {
                $this->offer_type = implode(',', $this->offer_type);
            }
            if (!empty($this->traffic_type) && is_array($this->traffic_type)) {
                $this->traffic_type = implode(',', $this->traffic_type);
            }
            return true;
        }

    }


}
