<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertiser".
 *
 * @property integer $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property integer $payment_term
 * @property integer $pm
 * @property integer $bd
 * @property string $system
 * @property integer $status
 * @property string $contacts
 * @property double $total_revenue
 * @property double $receivable
 * @property double $received
 * @property string $pricing_mode
 * @property integer $type
 * @property string $auth_token
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $post_parameter
 * @property string $email
 * @property string $cc_email
 * @property string $company
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $phone1
 * @property string $phone2
 * @property string $weixin
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
 * @property string $note
 * @property string $beneficiary_name
 * @property string $bank_country
 * @property string $bank_name
 * @property string $bank_address
 * @property string $swift
 * @property string $account_nu_iban
 * @property string $invoice_title
 *
 * @property User $bd0
 * @property Campaign[] $campaigns
 */
class Advertiser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertiser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'post_parameter', 'email'], 'required'],
            [['payment_term', 'status', 'status', 'type', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted'], 'integer'],
            [['total_revenue', 'receivable', 'received'], 'number'],
            [['username', 'firstname', 'lastname', 'system', 'alipay', 'timezone','beneficiary_name'], 'string', 'max' => 100],
            [['contacts', 'password_hash', 'password_reset_token', 'bank_country', 'bank_name', 'bank_address', 'swift', 'account_nu_iban', 'company', 'address', 'note','invoice_title'], 'string', 'max' => 255],
            [['auth_token', 'auth_key'], 'string', 'max' => 32],
            [['pricing_mode', 'email', 'weixin', 'skype', 'cc_email'], 'string', 'max' => 50],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['country'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 120],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['email', 'email'],
            ['cc_email', 'email'],
            [['password_reset_token'], 'unique'],
            [['auth_token'], 'unique'],
            [['bd'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['bd' => 'id']],
            [['bd'], 'required', 'message' => 'Can not found BD'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Advertiser',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'team' => 'Team',
            'payment_term' => 'Payment Term',
            'pm' => 'PM',
            'bd' => 'BD',
            'system' => 'System',
            'status' => 'Status',
            'contacts' => 'Contacts',
            'total_revenue' => 'Total Revenue',
            'receivable' => 'Receivable',
            'received' => 'Received',
            'pricing_mode' => 'Pricing Mode',
            'type' => 'Type',
            'auth_token' => 'Auth Token',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'email' => 'Email',
            'cc_email' => 'Cc Email',
            'company' => 'Company',
            'phone1' => 'Phone',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'phone2' => 'Phone2',
            'weixin' => 'Weixin',
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
            'note' => 'Note',
            'beneficiary_name' => 'Beneficiary Name',
            'bank_country' => 'Bank Country',
            'bank_name' => 'Bank Name',
            'bank_address' => 'Bank Address',
            'swift' => 'Swift',
            'account_nu_iban' => 'Account Number/Iban',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBd0()
    {
        return $this->hasOne(User::className(), ['id' => 'bd']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['advertiser' => 'id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_time = time();
            $this->updated_time = time();
            $this->auth_token = uniqid('adv') . uniqid();
        } else {
            $this->updated_time = time();
        }
        return parent::beforeSave($insert);
    }

    public static function getAdvNameListByName($name)
    {
        return static::find()->select("username")->where(['like', 'username', $name])->column();
    }

    public static function getOneByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}
