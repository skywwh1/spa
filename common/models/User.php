<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property integer $type
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $status
 * @property string $email
 * @property string $company
 * @property string $phone1
 * @property string $phone2
 * @property string $weixin
 * @property integer $qq
 * @property string $skype
 * @property string $alipay
 * @property string $city
 * @property string $country
 * @property string $address
 * @property string $lang
 * @property string $timezone
 * @property integer $firstaccess
 * @property integer $lastaccess
 * @property integer $picture
 * @property integer $suspended
 * @property integer $deleted
 * @property string $avatar generated filename on server
 * @property string $filename source filename from client
 *
 * @property Advertiser[] $advertisers
 * @property Campaign[] $campaigns
 * @property Channel[] $channels
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 10;
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            [['parent_id', 'type', 'status', 'qq', 'firstaccess', 'lastaccess', 'picture', 'suspended', 'deleted'], 'integer'],
            [['username', 'firstname', 'lastname', 'alipay', 'timezone'], 'string', 'max' => 100],
            [['company', 'address'], 'string', 'max' => 255],
            [['email', 'weixin', 'skype'], 'string', 'max' => 50],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['city'], 'string', 'max' => 120],
            [['country'], 'string', 'max' => 10],
            [['lang'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_hash'], 'safe'],
            [[ 'avatar', 'filename', 'image','imageFile'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png','maxSize'=>1024 * 1024 * 1,'tooBig'=>'头像最大不超过1MB，请重新上传!',],
//            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'username' => 'Username',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'type' => 'Type',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'status' => 'Status',
            'email' => 'Email',
            'company' => 'Company',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'weixin' => 'WeChat',
            'qq' => 'QQ',
            'skype' => 'Skype',
            'alipay' => 'Alipay',
            'city' => 'City',
            'country' => 'Country',
            'address' => 'Address',
            'lang' => 'Lang',
            'timezone' => 'Timezone',
            'firstaccess' => 'Firstaccess',
            'lastaccess' => 'Lastaccess',
            'picture' => 'Picture',
            'suspended' => 'Suspended',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers()
    {
        return $this->hasMany(Advertiser::className(), ['bd' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['creator' => 'id']);
    }

    public function getChannels()
    {
        return $this->hasMany(Channel::className(), ['om' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
//        return [
//            TimestampBehavior::className(),
//        ];
        //Setting unknown property: common\models\User::created_at
        return [
            'timestamp' => [
                'class' => '\yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_time', 'updated_time'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_time'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
//
//    public function getBdNameList($username){
//        static::find()->select()->column();
//    }

    public static function getBDList($username)
    {
        //->andWhere(["type"=>8])
        return static::find()->select("username")->where(["like", "username", $username])->column();
    }

    public static function getOMList($username)
    {
        //->andWhere(["type"=>9])
        return static::find()->select("username")->where(["like", "username", $username])->column();
    }

    public static function getPMList($username)
    {
        //->andWhere(["type"=>7])
        return static::find()->select("username")->where(["like", "username", $username])->column();
    }

    public static function getUsername()
    {
        return empty(\Yii::$app->user->identity->username)?"":\Yii::$app->user->identity->username;
    }

    public static function getUserEmailList($ids)
    {
        //->andWhere(["type"=>9])
        return static::find()->select("email")->andFilterWhere(["in", "id", $ids])->column();
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public  function getImageFile()
    {
        return empty($this->avatar) ? null : Yii::$app->params['uploadPath'] . $this->avatar ;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $avatar;
    }

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->filename = $image->name;
        $image_info = explode(".", $image->name);
        $ext = end($image_info);
//        $ext = end((explode(".", $image->name)));

        // generate a unique file name
        $this->avatar = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;
        $this->filename = null;

        return true;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrlAbs()
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return '/upload/channel/'. $avatar;
    }

    public static function  getBaseUrl(){
        return 'http://admin.spa.com/upload/channel/';
    }
}
