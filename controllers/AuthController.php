<?php
namespace kordar\ams\controllers;

use kordar\ams\models\PasswordResetRequestForm;
use kordar\ams\models\ResetPasswordForm;
use kordar\ams\web\AmsException;
use kordar\ams\web\AuthRedis;
use Yii;
use kordar\ams\models\SignupForm;
use kordar\ams\models\LoginForm;
use kordar\ams\web\Response;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

class AuthController extends CommonController
{

    public function init()
    {
        $user = Yii::$app->user;
        $user->enableSession = false;
        $authRedis = new \kordar\ams\web\AuthRedis();
        $user->on($user::EVENT_AFTER_LOGIN, [$authRedis, 'load']);
    }

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
            'login' => ['POST'],
            'signup' => ['POST'],
            'logout' => ['POST'],
            'request-password-reset' => ['POST'],
            'reset-password' => ['GET'],
        ];
    }

    /**
     * @return array|LoginForm
     * 用户登录
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $token = $model->login()) {
            return Response::sendToken($token, '登录认证成功!');
        }
        return $model;
    }

    /**
     * @return array|LoginForm|SignupForm
     * 用户注册
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->signup()) {
            return $this->actionLogin();
        }
        return $model;
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $auth = new AuthRedis();
        $auth->destroy(Yii::$app->request->post('token'));
        return Response::sendCustomer(Response::$successStatus, '注销成功');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $desc = '邮件已发送，请检查您的电子邮件。';
            return $model->sendEmail() ? Response::sendCustomer(Response::$successStatus, $desc) : Response::sendCustomer(Response::$failedStatus, '邮件发送失败!');
        }
        return $model;
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post(), '') && $model->validate() && $model->resetPassword()) {
            return Response::sendCustomer(Response::$successStatus, '新的密码已被存储.');
        }

        return $model;
    }


}