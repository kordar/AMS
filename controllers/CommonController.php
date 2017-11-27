<?php
namespace kordar\ams\controllers;

use kordar\ams\web\AmsException;
use kordar\ams\web\AuthRedis;
use yii\rest\ActiveController;

class CommonController extends ActiveController
{
    public $serializer = 'kordar\ams\web\Serializer';

    protected $request = null;

    protected $userInfo = [];

    public function init()
    {
        $this->request = \Yii::$app->request;
        $token = $this->request->get('auth_token');
        if (empty($token)) {
            throw new AmsException(50001);
        }

        $userRedis = new AuthRedis();
        $keys = ['id', 'username', 'email', 'auth_token', 'status', 'created_at', 'updated_at'];
        $values = $userRedis->getUserInfo($token);
        \Yii::$app->params['userInfo'] = array_combine($keys, $values);
    }
}