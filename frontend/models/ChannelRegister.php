<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "channel_register".
 *
 * @property integer $id
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
 * @property Channel $id0
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
            [['vertical', 'offer_type', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'traffic_type', 'best_time', 'time_zone', 'suggested_am', 'additional_notes', 'another_info'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
    public function getId0()
    {
        return $this->hasOne(Channel::className(), ['id' => 'id']);
    }
}
