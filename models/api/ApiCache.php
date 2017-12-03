<?php

namespace kordar\ams\models\api;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%api_cache}}".
 *
 * @property integer $cacheID
 * @property integer $projectID
 * @property integer $groupID
 * @property integer $apiID
 * @property string $apiJson
 * @property integer $starred
 * @property integer $updateUserID
 */
class ApiCache extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_cache}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createUserID',
                'updatedByAttribute' => 'updateUserID',
                'value' => Yii::$app->params['userInfo']['userID']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectID', 'groupID', 'apiID', 'apiJson'], 'required'],
            [['projectID', 'groupID', 'apiID', 'starred', 'updateUserID'], 'integer'],
            [['apiJson'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cacheID' => 'Cache ID',
            'projectID' => 'Project ID',
            'groupID' => 'Group ID',
            'apiID' => 'Api ID',
            'apiJson' => 'Api Json',
            'starred' => 'Starred',
            'updateUserID' => 'Update User ID',
        ];
    }

    public function setCacheApi($info = [])
    {
        return $this->load($info, '') && $this->save();
    }
}
