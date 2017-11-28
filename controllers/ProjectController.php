<?php
namespace kordar\ams\controllers;

class ProjectController extends CommonController
{
    public $modelClass = 'kordar\ams\models\project\Project';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = 'kordar\ams\actions\IndexAction';
        $actions['index']['filterParams'] = ['projectName' => 'CCCCCC'];
        $actions['recycle'] = [
            'class' => 'kordar\ams\actions\IndexAction',
            'filterParams' => ['projectName' => 'MMMMMM'],
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}