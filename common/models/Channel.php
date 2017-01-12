<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $id
 * @property string $username
 * @property string $team
 * @property string $firstname
 * @property string $lastname
 * @property integer $type
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $settlement_type
 * @property integer $om
 * @property integer $main_channel
 * @property string $account_name
 * @property string $branch_name
 * @property integer $card_number
 * @property string $contacts
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $email
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $company
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
 * @property integer $bd
 * @property string $system
 * @property integer $status
 * @property string $cc_email
 * @property integer $traffic_source
 * @property integer $pricing_mode
 * @property string $note
 * @property string $app_id
 * @property string $post_back
 * @property string $click_pram_name
 * @property string $click_pram_length
 * @property integer $total_revenue
 * @property integer $need_pay
 * @property string $already_pay
 *
 * @property CampaignChannelLog[] $campaignChannelLogs
 * @property Campaign[] $campaigns
 * @property Channel $mainChannel
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
            [['username', 'email', 'password_hash', 'post_back','status'], 'required'],
            [['type', 'card_number', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'bd', 'status', 'traffic_source', 'pricing_mode', 'total_revenue', 'need_pay'], 'integer'],
            [['username', 'team', 'firstname', 'lastname', 'settlement_type', 'account_name', 'branch_name', 'contacts', 'alipay', 'timezone', 'system', 'app_id', 'click_pram_name', 'click_pram_length'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'address', 'company', 'note', 'post_back', 'already_pay'], 'string', 'max' => 255],
            [['email', 'wechat', 'skype', 'cc_email'], 'string', 'max' => 50],
            [['country'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 120],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email', 'cc_email'], 'email'],
            [['password_reset_token'], 'unique'],
            [['main_channel'], 'exist', 'targetClass' => Channel::className(), 'message' => 'Main Channel does not exist', 'targetAttribute' => ['main_channel' => 'id']],
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
            'team' => 'Team',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'type' => 'Type',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'settlement_type' => 'Settlement Type',
            'om' => 'OM',
            'main_channel' => 'Mater Channel',
            'account_name' => 'Account Name',
            'branch_name' => 'Branch Name',
            'card_number' => 'Card Number',
            'contacts' => 'Contacts',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'email' => 'Email',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'company' => 'Company',
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
            'bd' => 'BD',
            'system' => 'System',
            'status' => 'Status',
            'cc_email' => 'Cc Email',
            'traffic_source' => 'Traffic Source',
            'pricing_mode' => 'Pricing Mode',
            'note' => 'Note',
            'app_id' => 'App ID',
            'post_back' => 'Post Back',
            'click_pram_name' => 'Click Pram Name',
            'click_pram_length' => 'Click Pram Length',
            'total_revenue' => 'Total Revenue',
            'need_pay' => 'Need Pay',
            'already_pay' => 'Already Pay',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignChannelLogs()
    {
        return $this->hasMany(S2s::className(), ['channel_id' => 'id']);
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
    public function getMainChannel()
    {
       return $this->hasOne(Channel::className(), ['id' => 'main_channel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(Channel::className(), ['main_channel' => 'id']);
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

    public static function getChannelNameListByName($name)
    {
        return static::find()->select("username")->where(['like', 'username', $name])->column();
    }

    public static function findChannelByName($username)
    {
        return static::findOne(['username' => $username]);
    }

}
