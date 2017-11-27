<?php

namespace kordar\ams\models;

use Yii;

/**
 * This is the model class for table "{{%api}}".
 *
 * @property integer $apiID
 * @property string $apiName
 * @property string $apiURI
 * @property integer $apiProtocol
 * @property string $apiFailureMock
 * @property string $apiSuccessMock
 * @property integer $apiRequestType
 * @property integer $apiSuccessMockType
 * @property integer $apiFailureMockType
 * @property integer $apiStatus
 * @property string $apiUpdateTime
 * @property integer $groupID
 * @property integer $projectID
 * @property integer $starred
 * @property integer $removed
 * @property string $removeTime
 * @property integer $apiNoteType
 * @property string $apiNoteRaw
 * @property string $apiNote
 * @property integer $apiRequestParamType
 * @property string $apiRequestRaw
 * @property integer $updateUserID
 */
class Api extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiName', 'apiURI', 'apiProtocol', 'apiRequestType', 'groupID', 'projectID'], 'required'],
            [['apiProtocol', 'apiRequestType', 'apiSuccessMockType', 'apiFailureMockType', 'apiStatus', 'groupID', 'projectID', 'starred', 'removed', 'apiNoteType', 'apiRequestParamType', 'updateUserID'], 'integer'],
            [['apiFailureMock', 'apiSuccessMock', 'apiNoteRaw', 'apiNote', 'apiRequestRaw'], 'string'],
            [['apiUpdateTime', 'removeTime'], 'safe'],
            [['apiName', 'apiURI'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apiID' => 'Api ID',
            'apiName' => 'Api Name',
            'apiURI' => 'Api Uri',
            'apiProtocol' => 'Api Protocol',
            'apiFailureMock' => 'Api Failure Mock',
            'apiSuccessMock' => 'Api Success Mock',
            'apiRequestType' => 'Api Request Type',
            'apiSuccessMockType' => 'Api Success Mock Type',
            'apiFailureMockType' => 'Api Failure Mock Type',
            'apiStatus' => 'Api Status',
            'apiUpdateTime' => 'Api Update Time',
            'groupID' => 'Group ID',
            'projectID' => 'Project ID',
            'starred' => 'Starred',
            'removed' => 'Removed',
            'removeTime' => 'Remove Time',
            'apiNoteType' => 'Api Note Type',
            'apiNoteRaw' => 'Api Note Raw',
            'apiNote' => 'Api Note',
            'apiRequestParamType' => 'Api Request Param Type',
            'apiRequestRaw' => 'Api Request Raw',
            'updateUserID' => 'Update User ID',
        ];
    }
}
