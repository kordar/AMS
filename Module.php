<?php

namespace kordar\ams;

use Yii;
/**
 * ace module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'kordar\ams\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $response = Yii::$app->response;
        $response->on($response::EVENT_BEFORE_SEND, ['\kordar\ams\web\Response', 'format']);
        // custom initialization code goes here
    }
}
