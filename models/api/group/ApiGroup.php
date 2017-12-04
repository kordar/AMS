<?php

namespace kordar\ams\models\api\group;

use Yii;

/**
 * This is the model class for table "{{%api_group}}".
 *
 * @property integer $groupID
 * @property string $groupName
 * @property integer $projectID
 * @property integer $parentGroupID
 * @property integer $isChild
 */
class ApiGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupName', 'projectID'], 'required'],
            [['projectID', 'parentGroupID', 'isChild'], 'integer'],
            [['groupName'], 'string', 'max' => 30],
            [['isChild'], 'default', 'value' => function () {
                return empty($this->parentGroupID) ? 0 : 1;
            }]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupID' => 'Group ID',
            'groupName' => 'Group Name',
            'projectID' => 'Project ID',
            'parentGroupID' => 'Parent Group ID',
            'isChild' => 'Is Child',
        ];
    }

    public function setDefaultGroup(GroupEvent $event)
    {
        $this->projectID = $event->projectID;
        $this->groupName = $event->groupName;
        return $this->save();
    }
}
