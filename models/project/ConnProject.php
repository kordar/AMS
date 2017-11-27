<?php

namespace kordar\ams\models\project;

use Yii;

/**
 * This is the model class for table "{{%conn_project}}".
 *
 * @property integer $connID
 * @property integer $projectID
 * @property integer $userID
 * @property integer $userType
 * @property integer $inviteUserID
 * @property string $partnerNickName
 */
class ConnProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%conn_project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectID', 'userID'], 'required'],
            [['projectID', 'userID', 'userType', 'inviteUserID'], 'integer'],
            [['partnerNickName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'connID' => 'Conn ID',
            'projectID' => 'Project ID',
            'userID' => 'User ID',
            'userType' => 'User Type',
            'inviteUserID' => 'Invite User ID',
            'partnerNickName' => 'Partner Nick Name',
        ];
    }
}
