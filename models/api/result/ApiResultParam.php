<?php

namespace kordar\ams\models\api\result;

use Yii;

/**
 * This is the model class for table "{{%api_result_param}}".
 *
 * @property integer $paramID
 * @property string $paramName
 * @property string $paramKey
 * @property integer $apiID
 * @property integer $paramNotNull
 */
class ApiResultParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_result_param}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paramKey', 'apiID', 'paramNotNull'], 'required'],
            [['apiID', 'paramNotNull'], 'integer'],
            [['paramName', 'paramKey'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paramID' => 'Param ID',
            'paramName' => 'Param Name',
            'paramKey' => 'Param Key',
            'apiID' => 'Api ID',
            'paramNotNull' => 'Param Not Null',
        ];
    }

    public function setParams($apiID, $info = [])
    {
        $keys = $this->attributes();
        $updateList = array_map(function ($val) {
            return sprintf('%s=VALUES(%s)', $val, $val);
        }, $keys);

        $format = "(%s, '%s', '%s', %s, %s)";

        $insertList = [];
        $insertValueList = [];
        foreach ($info as $val) {

            if (isset($val['paramID']) && !empty($val['paramID'])) {
                $insertValueList = array_merge($val['paramValueList'], $insertValueList);
            } else {
                $val['paramID'] = 'null';
            }

            if (empty($val['paramKey'])) {
                continue;
            }

            $val['paramName'] = empty($val['paramName']) ? '' : $val['paramName'];
            $val['paramNotNull'] = empty($val['paramNotNull']) ? 0 : $val['paramNotNull'];

            $insertList[] = sprintf($format, $val['paramID'], $val['paramName'], $val['paramKey'], $apiID, $val['paramNotNull']);
        }

        // 设置 Params Values
        if (!empty($insertValueList)) {
            $valueModel = new ApiResultValue();
            $valueModel->setParamValues($insertValueList);
        }

        if (empty($insertList)) {
            return false;
        }

        $sql = sprintf("INSERT INTO %s %s ON DUPLICATE KEY UPDATE %s", self::tableName(),'(`paramID`, `paramName`, `paramKey`, `apiID`, `paramNotNull`) VALUES ' . implode(',', $insertList), implode(',', $updateList));

        return Yii::$app->db->createCommand($sql)->execute();
    }
}
