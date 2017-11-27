<?php
namespace kordar\ams\web;
use Yii;

class ErrorAction extends \yii\web\ErrorAction
{
    public function run()
    {
        Yii::$app->getResponse()->setStatusCodeByException($this->exception);
        return [
            'code'=>$this->exception->getCode(),
            'msg'=>$this->getExceptionName(),
            'desc'=>$this->getExceptionMessage()
        ];
    }
}