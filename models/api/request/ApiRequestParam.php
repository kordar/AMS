<?php

namespace kordar\ams\models\api\request;

use Yii;

/**
 * This is the model class for table "{{%api_request_param}}".
 *
 * @property integer $paramID
 * @property string $paramName
 * @property string $paramKey
 * @property string $paramValue
 * @property integer $paramType
 * @property string $paramLimit
 * @property integer $apiID
 * @property integer $paramNotNull
 */
class ApiRequestParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_request_param}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paramKey', 'paramValue', 'apiID'], 'required'],
            [['paramValue'], 'string'],
            [['paramType', 'apiID', 'paramNotNull'], 'integer'],
            [['paramName', 'paramKey', 'paramLimit'], 'string', 'max' => 255],
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
            'paramValue' => 'Param Value',
            'paramType' => 'Param Type',
            'paramLimit' => 'Param Limit',
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

        $format = "(%s, '%s', '%s', '%s', %s, '%s', %s, %s)";

        $insertList = [];
        $insertValueList = [];
        foreach ($info as $val) {

           if (isset($val['paramID']) && !empty($val['paramID'])) {
                $insertValueList = array_merge($val['paramValueList'], $insertValueList);
            } else {
                $val['paramID'] = 'null';
            }

            if (empty($val['paramKey']) || empty($val['paramValue'])) {
               continue;
            }

            $val['paramName'] = empty($val['paramName']) ? '' : $val['paramName'];
            $val['paramType'] = empty($val['paramType']) ? 0 : $val['paramType'];
            $val['paramLimit'] = empty($val['paramLimit']) ? '' : $val['paramLimit'];
            $val['paramNotNull'] = empty($val['paramNotNull']) ? 0 : $val['paramNotNull'];

            $insertList[] = sprintf($format, $val['paramID'], $val['paramName'], $val['paramKey'], $val['paramValue'], $val['paramType'], $val['paramLimit'], $apiID, $val['paramNotNull']);
        }

        // 设置 Params Values
        if (!empty($insertValueList)) {
            $valueModel = new ApiRequestValue();
            $valueModel->setParamValues($insertValueList);
        }

        if (empty($insertList)) {
            return false;
        }

        $sql = sprintf("INSERT INTO %s %s ON DUPLICATE KEY UPDATE %s", self::tableName(),'(`paramID`, `paramName`, `paramKey`, `paramValue`, `paramType`, `paramLimit`, `apiID`, `paramNotNull`) VALUES ' . implode(',', $insertList), implode(',', $updateList));

        return Yii::$app->db->createCommand($sql)->execute();
    }
}
