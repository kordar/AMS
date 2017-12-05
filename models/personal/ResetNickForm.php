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
class ResetNickForm extends Model
{
    public $usernick;
    public $userid;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['usernick', 'userid'], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function setNick()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->userNickName = $this->usernick;
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
