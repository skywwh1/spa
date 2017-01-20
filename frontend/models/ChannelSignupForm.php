<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

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
class ChannelSignupForm extends Model
{
    public $username;
    public $company;
    public $timezone;
    public $email;
    public $phone1;
    public $skype;
    public $country;
    public $address;
    public $vertical;
    public $offer_type;
    public $other_network;
    public $vertical_interested;
    public $special_offer;
    public $regions;
    public $traffic_type;
    public $best_time;
    public $time_zone;
    public $suggested_am;
    public $additional_notes;
    public $another_info;

    public $password_hash;
    public $confirmPassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'company', 'timezone', 'email', 'phone1', 'skype', 'country', 'address'], 'required'],
            [['vertical', 'offer_type', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'traffic_type', 'best_time', 'time_zone'], 'required'],
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
            'username' => 'Username',
            'company' => 'Company',
            'timezone' => 'Timezone',
            'email' => 'Email',
            'phone1' => 'Phone',
            'skype' => 'Skype',
            'country' => 'Country',
            'address' => 'Address',
            'password_hash' => 'Password Hash',
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

}
