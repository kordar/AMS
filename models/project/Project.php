<?php

namespace kordar\ams\models\project;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $projectID
 * @property integer $projectType
 * @property string $projectName
 * @property string $projectUpdateTime
 * @property string $projectVersion
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'projectUpdateTime',
                'updatedAtAttribute' => 'projectUpdateTime',
                'value' => date('Y-m-d H:i:s')
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectType', 'projectName'], 'required'],
            [['projectType'], 'integer'],
            ['projectType', 'in', 'range' => [0, 1, 2, 3]],     // 项目类型匹配

            [['projectUpdateTime'], 'safe'],
            [['projectName'], 'string', 'length' => [1, 32]],

            [['projectVersion'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectID' => 'Project ID',
            'projectType' => 'Project Type',
            'projectName' => 'Project Name',
            'projectUpdateTime' => 'Project Update Time',
            'projectVersion' => 'Project Version',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();  //开启事务
            $bolean = $this->insert($runValidation, $attributeNames);
            if ($bolean) {
                $model = new ConnProject();
                $model->projectID = $this->projectID;
                $model->userID = \Yii::$app->params['userInfo']['id'];
                if ($model->save()) {
                    $transaction->commit();
                    return true;
                }
            }
            $transaction->rollBack();
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
        return false;
    }

}
