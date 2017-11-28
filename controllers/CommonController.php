<?php
namespace kordar\ams\controllers;

use kordar\ams\web\AmsException;
use kordar\ams\web\AuthRedis;
use yii\rest\ActiveController;
use yii\rest\IndexAction;

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