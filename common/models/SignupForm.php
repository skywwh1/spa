<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $confirmPassword;
    public $verifyCode;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'confirmPassword', 'email'], 'required'],
            // rememberMe must be a boolean value
            ['email', 'email'],
            ['confirmPassword', 'confirm'],
            ['verifyCode', 'captcha'],
        ];
    }


    public function signUp()
    {
        if ($this->validate()) {
            $this->_user = new User;
            $this->_user->email = $this->email;
            $this->_user->username = $this->username;
            $this->_user->setPassword($this->password);
            $this->_user->validate();
            $this->addErrors($this->_user->getErrors());
            if (!$this->hasErrors() && $this->_user->save()) {
                return $this->_user;
            }
        }
        return null;
    }

    public function confirm()
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->confirmPassword) {
                $this->addError('confirmPassword', 'Confirm password not the same');
            }
        }
    }
}
