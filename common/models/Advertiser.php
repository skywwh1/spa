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
 * @property string $team
 * @property string $settlement_type
 * @property integer $bd
 * @property string $system
 * @property integer $status
 * @property string $contacts
 * @property integer $pricing_mode
 * @property integer $type
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $email
 * @property string $company
 * @property string $phone1
 * @property string $phone2
 * @property string $weixin
 * @property integer $qq
 * @property string $skype
 * @property string $alipay
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $lang
 * @property string $timezone
 * @property integer $firstaccess
 * @property integer $lastaccess
 * @property integer $picture
 * @property integer $confirmed
 * @property integer $suspended
 * @property integer $deleted
 * @property string $cc_email
 * @property integer $traffic_source
 * @property string $note
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
            [['username', 'email'], 'required'],
            [['status', 'pricing_mode', 'type', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'traffic_source'], 'integer'],
            [['username', 'firstname', 'lastname', 'team', 'settlement_type', 'system', 'alipay', 'timezone'], 'string', 'max' => 100],
            [['contacts', 'password_hash', 'password_reset_token', 'company', 'address', 'note'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email', 'weixin', 'skype', 'cc_email'], 'string', 'max' => 50],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['country'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 120],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['email', 'email'],
            ['cc_email', 'email'],
            [['password_reset_token'], 'unique'],
            [['bd'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['bd' => 'id']],
            [['bd'], 'required','message'=>'Can not found BD'],
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
            'settlement_type' => 'Settlement Type',
            'bd' => 'BD',
            'system' => 'System',
            'status' => 'Status',
            'contacts' => 'Contacts',
            'pricing_mode' => 'Pricing Mode',
            'type' => 'Type',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'email' => 'Email',
            'company' => 'Company',
            'phone1' => 'Phone',
            'phone2' => 'Phone2',
            'weixin' => 'Weixin',
            'qq' => 'Qq',
            'skype' => 'Skype',
            'alipay' => 'Alipay',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'lang' => 'Lang',
            'timezone' => 'Timezone',
            'firstaccess' => 'Firstaccess',
            'lastaccess' => 'Lastaccess',
            'picture' => 'Picture',
            'confirmed' => 'Confirmed',
            'suspended' => 'Suspended',
            'deleted' => 'Deleted',
            'cc_email' => 'Cc Email',
            'traffic_source' => 'Traffic Source',
            'note' => 'Note',
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
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                $this->created_time = time();
                $this->updated_time = time();
            }
            else
            {
                $this->updated_time = time();
            }

            return true;

        }
        else
        {
            return false;
        }
    }

    public static function getAdvNameListByName($name)
    {
        return static::find()->select("username")->where(['like', 'username', $name])->column();
    }
}
