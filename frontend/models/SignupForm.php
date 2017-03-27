<?php

namespace frontend\models;

use common\models\Channel;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password_hash;
    public $verifyCode;
    public $company;
    public $confirmPassword;
    public $_channel;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Channel', 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Channel', 'targetAttribute' => ['email' => 'email'], 'message' => 'This email has already been taken.'],

            ['password_hash', 'required'],
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

    public function signUp()
    {
        if ($this->validate()) {
            $channel = new Channel();
            $channel->setAttributes($this->getAttributes());
            $this->_channel = $channel;
            $this->_channel->om = 1; //master om;
            $this->_channel->status = 2; //building
            $this->_channel->validate();
//            $this->_channel->setPassword($this->password_hash);
            $this->addErrors($this->_channel->getErrors());
            if (!$this->hasErrors()) {
                if ($this->_channel->save()) {
                    return $this->_channel;
                }
            }
            return null;
        }
    }
}
