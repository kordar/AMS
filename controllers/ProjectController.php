<?php
namespace kordar\ams\controllers;

class ProjectController extends CommonController
{
    public $modelClass = 'kordar\ams\models\project\Project';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = 'kordar\ams\actions\IndexAction';
        $actions['index']['filterParams'] = ['status' => 1];
        $actions['recycle'] = [
            'class' => 'kordar\ams\actions\IndexAction',
            'filterParams' => ['status' => 0],
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}