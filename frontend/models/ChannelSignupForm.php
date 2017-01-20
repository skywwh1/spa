<?php

namespace frontend\models;

use common\models\Channel;
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
    public $_channel;
    public $_channelRegister;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'company', 'timezone', 'email', 'phone1', 'skype', 'country', 'address', 'password_hash', 'confirmPassword'], 'required'],
            ['email', 'email'],
            [['vertical', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'best_time', 'time_zone', 'offer_type', 'traffic_type'], 'required'],
            [['offer_type', 'traffic_type',], 'safe'],
            [['vertical', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'best_time', 'time_zone', 'suggested_am', 'additional_notes', 'another_info'], 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => '\common\models\Channel', 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            ['email', 'unique', 'targetClass' => '\common\models\Channel', 'targetAttribute' => ['email' => 'email'], 'message' => 'This email has already been taken.'],
            ['password_hash', 'match', 'pattern' => '/^(\w){6,20}$/', 'message' => 'Password at least 6 characters'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password_hash', 'message' => "Passwords don't match"],
            ['verifyCode', 'captcha'],
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
            'password_hash' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'vertical' => 'What are the verticals that you are currently running?',
            'offer_type' => 'What are the offer types that you are currently running?',
            'other_network' => "What other networks do you work with(AM's name,telphone,email,IM)?",
            'vertical_interested' => "What are the Verticals that you're interested in running/learning about more with us?",
            'special_offer' => 'Are there specific offers you are looking to run with our network and how did you find out about them?',
            'regions' => 'What top 3 Regions do you mostly run in? ',
            'traffic_type' => 'What traffic types do you generally use for promotional purposes?',
            'best_time' => 'Best Time to Reach You?',
            'time_zone' => 'Time Zone',
            'suggested_am' => 'Suggested AM',
            'additional_notes' => 'Additional Notes',
            'another_info' => 'Please include any other Information that we should know about you and your company',
        ];
    }

    public function confirm()
    {
        if (!$this->hasErrors()) {
            if ($this->password_hash !== $this->confirmPassword) {
                $this->addError('confirmPassword', 'Confirm password not the same');
            }
        }
    }

    public function signUp()
    {
        if ($this->validate()) {
            $channel = new Channel();
            $register = new ChannelRegister();
            $channel->setAttributes($this->getAttributes());
            $register->setAttributes($this->getAttributes());
            $this->_channel = $channel;
            $this->_channel->om = 1; //master om;
            $this->_channel->status = 2; //building
            $this->_channelRegister = $register;
            $this->_channel->validate();
            $this->_channelRegister->validate();
//            $this->_channel->setPassword($this->password_hash);
            $this->addErrors($this->_channel->getErrors());
            $this->addErrors($this->_channelRegister->getErrors());
            if (!$this->hasErrors()) {
                if ($this->_channel->save()) {
                    $this->_channelRegister->channel_id = $this->_channel->getPrimaryKey();
                    if ($this->_channelRegister->save()) {
                        return $this->_channel;
                    }
                }
            }
        }
        return null;


    }


}
