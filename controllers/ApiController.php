<?php
namespace kordar\ams\controllers;

use kordar\ams\models\api\group\ApiGroup;
use kordar\ams\web\AmsException;
use kordar\ams\web\Response;
use Yii;
use kordar\ams\models\api\Api;
use yii\base\Exception;

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

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action == 'create') {
            $bodyParams = Yii::$app->getRequest()->getBodyParams();
            $groupModel = ApiGroup::findOne($bodyParams['groupID']);
            if (empty($groupModel)) {
                throw new Exception('分组异常');
            }
            $bodyParams['projectID'] = $groupModel->projectID;
            Yii::$app->getRequest()->setBodyParams($bodyParams);
        }
    }

}