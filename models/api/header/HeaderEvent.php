<?php
namespace kordar\ams\models\api\group\header;

use yii\base\Event;

class HeaderEvent extends Event
{
    public $apiID;
    public $header = [];
}