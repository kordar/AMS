<?php
namespace kordar\ams\web;

use Yii;

class Response
{
    public static $httpStatuses = [
        10002 => '表单验证失败',

        50001 => 'Token Require',
        50002 => 'Auth Token 认证失败'
    ];

    public static $successStatus = 10000;
    public static $failedStatus = 10001;

    // 发送 Model Form Error
    public static function sendFormValidateErrors($errors = [])
    {
        return ['code' => 10002, 'msg' => Response::$httpStatuses[10002], 'validate' => $errors];
    }

    // 返回 View Form Data
    public static function sendModelData($result = [], $msg = 'OK')
    {
        $result['code'] = Response::$successStatus;
        $result['msg'] = $msg;
        return $result;
    }

    // 响应 Token
    public static function sendToken($token, $msg = 'OK')
    {
        return ['code'=>Response::$successStatus, 'msg'=>$msg, 'auth_token' => $token];
    }

    // 发送用户自定义响应
    public static function sendCustomer($code, $msg = '')
    {
        return ['code' => $code, 'msg' => $msg];
    }


    public static function format()
    {
        $data = Yii::$app->response->data;
        if (isset($data['code'])) {
            switch ($data['code']) {
                case 0:
                    $data = ['code' => Response::$failedStatus, 'msg' => $data['message']];
                    break;
            }
            Yii::$app->response->data = $data;
        }
    }

    /*public static $httpStatuses = [
        10000 => 'Success', // 响应成功

        10011 => 'Sorry, we are unable to reset password for the provided email address.',  // 邮箱发送失败

        10001 => 'Authentication failed',    // 认证失败
        20001 => '认证失败',
        10002 => 'Registration failed',    // 注册失败
        20002 => '注册失败',
        10003 => 'Form Validate Error',  // 表单验证错误
        20003 => '表单验证异常',
        10004 => 'Model Load Exception',
        20004 => '模型加载异常',
    ];










    */

}