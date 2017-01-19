<?php

namespace common\models;

use common\utility\MailUtil;
use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property integer $type
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $settlement_type
 * @property integer $om
 * @property integer $master_channel
 * @property string $payment_way
 * @property string $payment_term
 * @property string $beneficiary_name
 * @property string $bank_country
 * @property string $bank_name
 * @property string $bank_address
 * @property string $swift
 * @property string $account_nu_iban
 * @property string $company_address
 * @property string $note
 * @property string $system
 * @property string $contacts
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $email
 * @property string $cc_email
 * @property string $company
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $phone1
 * @property string $phone2
 * @property string $wechat
 * @property integer $qq
 * @property string $skype
 * @property string $alipay
 * @property string $lang
 * @property string $timezone
 * @property integer $firstaccess
 * @property integer $lastaccess
 * @property integer $picture
 * @property integer $confirmed
 * @property integer $suspended
 * @property integer $deleted
 * @property integer $status
 * @property integer $traffic_source
 * @property integer $pricing_mode
 * @property string $post_back
 * @property integer $total_revenue
 * @property integer $payable
 * @property string $paid
 * @property string $strong_geo
 * @property string $strong_catagory
 *
 * @property Deliver[] $delivers
 * @property Campaign[] $campaigns
 * @property Channel $masterChannel
 * @property Channel[] $channels
 * @property User $om0
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_way', 'payment_term'],'safe'],
            [['username', 'email', 'password_hash', 'status'], 'required'],
            [['username', 'email'], 'required'],
            [['type', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'status', 'traffic_source', 'pricing_mode', 'total_revenue', 'payable'], 'integer'],
            [['username', 'firstname', 'lastname', 'settlement_type', 'beneficiary_name', 'system', 'contacts', 'alipay', 'timezone'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'bank_country', 'bank_name', 'bank_address', 'swift', 'account_nu_iban', 'company_address', 'note', 'company', 'address', 'post_back', 'paid', 'strong_geo', 'strong_catagory'], 'string', 'max' => 255],
            [['email', 'cc_email', 'wechat', 'skype'], 'string', 'max' => 50],
            [['country'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 120],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email', 'cc_email'], 'email'],
            [['password_reset_token'], 'unique'],
            [['master_channel'], 'exist', 'targetClass' => Channel::className(), 'message' => 'Master Channel does not exist', 'targetAttribute' => ['master_channel' => 'id']],
            [['om'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['om' => 'id']],
            ['om', 'required', 'message' => 'OM does not exist'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Channel',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'type' => 'Type',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'settlement_type' => 'Settlement Type',
            'om' => 'OM',
            'master_channel' => 'Master Channel',
            'payment_way' => 'Payment Way',
            'payment_term' => 'Payment Term',
            'beneficiary_name' => 'Beneficiary Name',
            'bank_country' => 'Bank Country',
            'bank_name' => 'Bank Name',
            'bank_address' => 'Bank Address',
            'swift' => 'Swift',
            'account_nu_iban' => 'Account Number/Iban',
            'company_address' => 'Company Address',
            'note' => 'Note',
            'system' => 'System',
            'contacts' => 'Contacts',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'email' => 'Email',
            'cc_email' => 'Cc Email',
            'company' => 'Company',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'phone1' => 'Phone',
            'phone2' => 'Phone2',
            'wechat' => 'Wechat',
            'qq' => 'QQ',
            'skype' => 'Skype',
            'alipay' => 'Alipay',
            'lang' => 'Lang',
            'timezone' => 'Timezone',
            'firstaccess' => 'Firstaccess',
            'lastaccess' => 'Lastaccess',
            'picture' => 'Picture',
            'confirmed' => 'Confirmed',
            'suspended' => 'Suspended',
            'deleted' => 'Deleted',
            'status' => 'Status',
            'traffic_source' => 'Traffic Source',
            'pricing_mode' => 'Pricing Mode',
            'post_back' => 'Postback',
            'total_revenue' => 'Total Revenue',
            'payable' => 'Payable',
            'paid' => 'Paid',
            'strong_geo' => 'Strong Geo',
            'strong_catagory' => 'Strong Catagory',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignChannelLogs()
    {
        return $this->hasMany(Deliver::className(), ['channel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['id' => 'campaign_id'])->viaTable('campaign_channel_log', ['channel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'master_channel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(Channel::className(), ['master_channel' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOm0()
    {
        return $this->hasOne(User::className(), ['id' => 'om']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_time = time();
                $this->updated_time = time();
            } else {
                $this->updated_time = time();
            }

            return true;

        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            MailUtil::sendCreateChannel($this);
        }
    }


    public static function getChannelNameListByName($name)
    {
        return static::find()->select("username")->where(['like', 'username', $name])->column();
    }

    public static function findChannelByName($username)
    {
        return static::findOne(['username' => $username]);
    }

}
