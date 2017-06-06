<?php

namespace common\models;

use common\utility\MailUtil;
use frontend\models\ChannelRegister;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "channel".
 *
 * @property integer $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property integer $type
 * @property string $auth_token
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $payment_term
 * @property integer $om
 * @property integer $master_channel
 * @property string $payment_way
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
 * @property string $traffic_source
 * @property string $pricing_mode
 * @property string $post_back
 * @property integer $total_revenue
 * @property integer $payable
 * @property string $paid
 * @property string $strong_geo
 * @property string $strong_category
 * @property string $os
 * @property integer recommended
 * @property string $discount
 *
 * @property ApplyCampaign[] $applyCampaigns
 * @property Deliver[] $delivers
 * @property Campaign[] $campaigns
 * @property Channel $masterChannel
 * @property Channel[] $channels
 * @property User $om0
 * @property ChannelRegister $channelRegister
 */
class Channel extends ActiveRecord implements IdentityInterface
{
    public $om_name;
    public $master_channel_name;
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
            [['payment_way', 'payment_term'], 'safe'],
            [['username', 'email', 'password_hash', 'status'], 'required'],
            [['username', 'email'], 'required'],
            [['type', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'status', 'total_revenue', 'payable', 'payment_term','recommended'], 'integer'],
            [['pricing_mode', 'username', 'firstname', 'lastname', 'beneficiary_name', 'system', 'contacts', 'alipay', 'timezone'], 'string', 'max' => 100],
            [['auth_token', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'bank_country', 'bank_name', 'bank_address', 'swift', 'account_nu_iban', 'company_address', 'company', 'address', 'post_back', 'paid'], 'string', 'max' => 255],
            [['email', 'wechat', 'skype'], 'string', 'max' => 100],
            [['country'], 'string', 'max' => 255],
            [['city'], 'string', 'max' => 200],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['discount'], 'number'],
            [['cc_email', 'traffic_source', 'strong_category', 'note', 'strong_geo','os'], 'safe'],
            [['password_reset_token'], 'unique'],
            [['auth_token'], 'unique'],
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
            'auth_token' => 'Auth Token',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
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
            'strong_category' => 'Strong Category',
            'os' => 'OS',
            'recommended' => 'Recommended',
            'om_name' => 'OM',
            'discount' => 'Discount',
            'master_channel_name' => 'Master Channel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplyCampaigns()
    {
        return $this->hasMany(ApplyCampaign::className(), ['channel_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannelRegister()
    {
        return $this->hasOne(ChannelRegister::className(), ['channel_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (!empty($this->payment_way) && is_array($this->payment_way)) {
            $this->payment_way = implode(',', $this->payment_way);
        }
        if ($insert) {
            $this->created_time = time();
            $this->updated_time = time();
            $this->auth_token = uniqid('ch') . uniqid();
        } else {
            $this->updated_time = time();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
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

    public static function genPostBack($postback, $allParams)
    {
        if (!empty($allParams)) {
            $params = explode('&', $allParams);
            foreach ($params as $item) {
                $param = explode('=', $item);
                $k = '{' . $param[0] . '}';
                $v = $param[1];
                $postback = str_replace($k, $v, $postback);
            }
        }
        return $postback;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generateRandomString($password);
    }

    public function getPassword()
    {
        return Yii::$app->getSecurity()->decryptByPassword($this->password_hash, "spa_aaa");
    }

    public function validatePassword($password)
    {
        if ($this->password_hash === $password) {
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
//        if($token === md5($this->auth_token)){
//
//        }
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function getChannelMultiple($username)
    {
        $data = static::find()->select('id,username')->where(['like', 'username', $username])->limit(20)->all();
        $out['results'] = array_values($data);
        return Json::encode($out);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}
