<?php

namespace kordar\ams\models\project;

use Yii;
use kordar\ams\models\api\group\ApiGroup;
use kordar\ams\models\api\group\GroupEvent;
use yii\behaviors\BlameableBehavior;
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
    const EVENT_INIT_GROP = 'init_group';

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

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
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_user',
                'updatedByAttribute' => null,
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
            [['projectType', 'projectName'], 'required'],
            [['projectType'], 'integer'],
            ['projectType', 'in', 'range' => [0, 1, 2, 3]],     // 项目类型匹配

            [['projectUpdateTime'], 'safe'],
            [['projectName'], 'string', 'length' => [1, 32]],

            [['projectVersion'], 'number'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectID' => 'ID',
            'projectType' => '类型',
            'projectName' => '名称',
            'projectUpdateTime' => '更新时间',
            'projectVersion' => '版本',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();  //开启事务
            $bolean = $this->insert($runValidation, $attributeNames);
            if ($bolean) {
                // 设置默认 group 信息
                $groupModel = new ApiGroup();
                $this->on(self::EVENT_INIT_GROP, [$groupModel, 'setDefaultGroup']);

                $model = new ConnProject();
                $model->projectID = $this->projectID;
                $model->userID = \Yii::$app->params['userInfo']['userID'];
                if ($model->save()) {
                    $event = new GroupEvent();
                    $event->projectID = $this->projectID;
                    $this->trigger(self::EVENT_INIT_GROP, $event);
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
