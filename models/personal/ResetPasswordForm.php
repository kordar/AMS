<?php

namespace kordar\ams\models\personal;

use kordar\ams\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;
    public $oldPassword;
    public $userid;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'confirmPassword', 'oldPassword', 'userid'], 'required'],
            ['oldPassword', 'validatePassword'],
            ['confirmPassword', 'compare', 'compareAttribute'=>'password', 'message'=>'密码不一致'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->oldPassword)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function setPassword()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setPassword($this->password);
            return $user->save();
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findIdentity($this->userid);
        }

        return $this->_user;
    }
}
