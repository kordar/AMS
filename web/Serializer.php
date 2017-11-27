<?php
namespace kordar\ams\web;

use yii\base\Arrayable;
use yii\base\Model;

class Serializer extends \yii\rest\Serializer
{
    /**
     * Serializes the validation errors in a model.
     * @param Model $model
     * @return array the array representation of the errors
     */
    protected function serializeModelErrors($model)
    {
        $result = parent::serializeModelErrors($model);
        return Response::sendFormValidateErrors($result);
    }

    /**
     * Serializes a model object.
     * @param Arrayable $model
     * @return array the array representation of the model
     */
    protected function serializeModel($model)
    {
        $result = parent::serializeModel($model);
        return Response::sendModelData($result);
    }
}