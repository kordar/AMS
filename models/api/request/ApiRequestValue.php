<?php

namespace kordar\ams\models\api\request;

use Yii;

/**
 * This is the model class for table "{{%api_request_value}}".
 *
 * @property integer $valueID
 * @property string $value
 * @property string $valueDescription
 * @property integer $paramID
 */
class ApiRequestValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_request_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paramID'], 'required'],
            [['paramID'], 'integer'],
            [['value', 'valueDescription'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'valueID' => 'Value ID',
            'value' => 'Value',
            'valueDescription' => 'Value Description',
            'paramID' => 'Param ID',
        ];
    }

    public function setParamValues($info = [])
    {
        $keys = $this->attributes();
        $updateList = array_map(function ($val) {
            return sprintf('%s=VALUES(%s)', $val, $val);
        }, $keys);

        $format = "(%s, '%s', '%s', %s)";

        $insertList = [];
        foreach ($info as $val) {
            if (empty($val['paramID'])) {
                continue;
            }
            $val['valueID'] = isset($val['valueID'])?$val['valueID']:'null';
            $val['value'] = empty($val['value'])?'':$val['value'];
            $val['valueDescription'] = empty($val['valueDescription'])?'':$val['valueDescription'];
            $insertList[] = sprintf($format, $val['valueID'], $val['value'], $val['valueDescription'], $val['paramID']);
        }

        if (empty($insertList)) {
            return false;
        }

        $sql = sprintf("INSERT INTO %s %s ON DUPLICATE KEY UPDATE %s", self::tableName(),'(`valueID`, `value`, `valueDescription`, `paramID`) VALUES ' . implode(',', $insertList), implode(',', $updateList));

        return Yii::$app->db->createCommand($sql)->execute();
    }
}
