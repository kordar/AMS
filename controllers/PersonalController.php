<?php
namespace kordar\ams\controllers;

use kordar\ams\models\personal\ResetNickForm;
use kordar\ams\models\personal\ResetPasswordForm;
use kordar\ams\models\User;
use kordar\ams\web\Response;
use Yii;

class PersonalController extends CommonController
{

    public function actions()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'reset-nick' => ['POST'],
            'reset-password' => ['POST']
        ];
    }

    /**
     * 重新设置昵称
     */
    public function actionResetNick()
    {
        $post = Yii::$app->getRequest()->post();

        $model = new ResetNickForm();
        $model->userid = $this->userInfo['userID'];

        if ($model->load($post, '') && $model->setNick()) {
            return Response::sendCustomer(Response::$successStatus, '昵称修改成功');
        }

        return $model;
    }

    /**
     * 重置密码
     */
    public function actionResetPassword()
    {
        $post = Yii::$app->getRequest()->post();

        $model = new ResetPasswordForm();
        $model->userid = $this->userInfo['userID'];

        if ($model->load($post, '') && $model->setPassword()) {
            return Response::sendCustomer(Response::$successStatus, '密码修改成功');
        }

        return $model;
    }

}