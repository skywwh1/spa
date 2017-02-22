<?php

namespace api\modules\v1\models;

use Yii;
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
 * @property string $settlement_type
 * @property integer $pm
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
 * @property string $note
 * @property string $post_back
 * @property integer $total_revenue
 * @property integer $payable
 * @property string $paid
 * @property string $strong_geo
 * @property string $strong_category
 *
 */
class Channel extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['username', 'created_time', 'updated_time', 'email'], 'required'],
            [['type', 'pm', 'om', 'master_channel', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'status', 'total_revenue', 'payable'], 'integer'],
            [['note'], 'string'],
            [['username', 'firstname', 'lastname', 'settlement_type', 'payment_way', 'payment_term', 'beneficiary_name', 'system', 'contacts', 'alipay', 'timezone', 'traffic_source', 'pricing_mode'], 'string', 'max' => 100],
            [['auth_token', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'bank_country', 'bank_name', 'bank_address', 'swift', 'account_nu_iban', 'company_address', 'company', 'address', 'post_back', 'paid', 'strong_geo', 'strong_category'], 'string', 'max' => 255],
            [['email', 'cc_email', 'wechat', 'skype'], 'string', 'max' => 50],
            [['country'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 120],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['auth_token'], 'unique'],
            [['master_channel'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['master_channel' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'type' => 'Type',
            'auth_token' => 'Auth Token',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'settlement_type' => 'Settlement Type',
            'pm' => 'Pm',
            'om' => 'Om',
            'master_channel' => 'Master Channel',
            'payment_way' => 'Payment Way',
            'payment_term' => 'Payment Term',
            'beneficiary_name' => 'Beneficiary Name',
            'bank_country' => 'Bank Country',
            'bank_name' => 'Bank Name',
            'bank_address' => 'Bank Address',
            'swift' => 'Swift',
            'account_nu_iban' => 'Account Nu Iban',
            'company_address' => 'Company Address',
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
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'wechat' => 'Wechat',
            'qq' => 'Qq',
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
            'note' => 'Note',
            'post_back' => 'Post Back',
            'total_revenue' => 'Total Revenue',
            'payable' => 'Payable',
            'paid' => 'Paid',
            'strong_geo' => 'Strong Geo',
            'strong_category' => 'Strong Category',
        ];
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
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['username' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
