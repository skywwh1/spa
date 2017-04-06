<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        		
        	['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！'],
        ];
    }

    public function attributeLabels()
    {
    	return [
    			'password' => '密码',
    			'password_repeat'=>'重输密码',
    	];
    }


    /**
     * Signs user up.
     *
     * @param $id
     * @return bool
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = User::findOne($id);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        
        return $user->save() ? true : false;
    }
}
