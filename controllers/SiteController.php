<?php
namespace kordar\ams\controllers;

use yii\rest\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'kordar\ams\web\ErrorAction'
            ]
        ];
    }
}