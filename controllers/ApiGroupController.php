<?php
namespace kordar\ams\controllers;

use kordar\ams\models\api\group\ApiGroup;
use Yii;
use kordar\ams\web\Response;

class ApiGroupController extends CommonController
{
    public $modelClass = 'kordar\ams\models\api\group\ApiGroup';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['update']);
        return $actions;
    }

    public function actionDelete($id)
    {
        $model = $this->findModel();
        if ($model::deleteAll("groupID IN($id) OR parentGroupID IN($id)")) {
            return Response::sendCustomer(Response::$successStatus, '删除成功!');
        }
        return Response::sendCustomer(Response::$failedStatus, '删除失败!');
    }

    public function actionUpdate($id)
    {
        $model = ApiGroup::findOne($id);
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return $model;
        }
        return Response::sendCustomer(Response::$failedStatus, '更新失败!');
    }


}