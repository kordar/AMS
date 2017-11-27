<?php
namespace kordar\ams\controllers;

use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'kordar\ams\models\User';

    public function checkAccess($action, $model = null, $params = [])
    {
        // throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action), 1234);
    }
}