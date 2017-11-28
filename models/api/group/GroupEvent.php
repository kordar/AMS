<?php
namespace kordar\ams\models\api\group;

use yii\base\Event;

class GroupEvent extends Event
{
    public $projectID;
    public $groupName = '默认分组';
}