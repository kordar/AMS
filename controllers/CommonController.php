<?php
namespace kordar\ams\controllers;

use Yii;
use kordar\ams\web\AmsException;
use kordar\ams\web\AuthRedis;
use yii\rest\ActiveController;


class CommonController extends ActiveController
{
    public $serializer = 'kordar\ams\web\Serializer';

    protected $request = null;

    /*public function actions()
    {
        $actions = parent::actions();
        $actions['index']['dataFilter'] = $this->setDataFilter();
        return array_merge($actions, $this->expandActions());
    }*/

    protected function setDataFilter()
    {
        return [
            'class' => 'yii\data\ActiveDataFilter',
            'searchModel' => $this->getSearchModel()
        ];
    }

    protected $defaultRules = [];
    protected $rulesMap = [];

    protected function getSearchModel()
    {
        $model = (new \yii\base\DynamicModel($this->defaultRules));
        foreach ($this->rulesMap as $field => $rule) {
            $model->addRule($field, $rule);
        }
        return $model;
    }


    protected $userInfo = [];

    public function init()
    {
        $this->request = Yii::$app->request;
        $token = $this->request->get('auth_token', '');
        if (empty($token)) {
            throw new AmsException(50001);
        }

        $userRedis = new AuthRedis();
        $keys = ['userID', 'userName', 'userNickName', 'email', 'auth_token', 'status', 'created_at', 'updated_at'];
        $values = $userRedis->getUserInfo($token);
        $this->userInfo = array_combine($keys, $values);
        Yii::$app->params['userInfo'] = $this->userInfo;

    }

    protected function findModel()
    {
        return Yii::createObject($this->modelClass);
    }

}