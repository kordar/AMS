<?php
namespace kordar\ams\controllers;

use kordar\ams\web\Response;
use Yii;
use kordar\ams\models\api\Api;

class ApiController extends CommonController
{
    public $modelClass = 'kordar\ams\models\api\Api';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update']);
        /*$actions['index']['class'] = 'kordar\ams\actions\IndexAction';
        $actions['index']['filterParams'] = ['status' => 1];
        $actions['recycle'] = [
            'class' => 'kordar\ams\actions\IndexAction',
            'filterParams' => ['status' => 0],
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];*/

        return $actions;
    }

    public function actionUpdate($id)
    {
        $model = Api::findOne(['apiID'=>$id]);
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return $model;
        }
        return Response::sendCustomer(Response::$failedStatus, '接口更新失败!');
    }

}