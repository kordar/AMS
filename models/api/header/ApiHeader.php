<?php

namespace kordar\ams\models\api\header;

use kordar\ams\models\api\Api;
use kordar\ams\models\api\group\header\HeaderEvent;
use Yii;

/**
 * This is the model class for table "{{%api_header}}".
 *
 * @property integer $headerID
 * @property string $headerName
 * @property string $headerValue
 * @property integer $apiID
 */
class ApiHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%api_header}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['headerName', 'headerValue', 'apiID'], 'required'],
            [['headerValue'], 'string'],
            [['apiID'], 'integer'],
            [['headerName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'headerID' => 'Header ID',
            'headerName' => 'Header Name',
            'headerValue' => 'Header Value',
            'apiID' => 'Api ID',
        ];
    }

    public function setApiHeaderEvent(HeaderEvent $event)
    {
        $infos = $event->header;
        foreach ($infos as $info) {
            $info['apiID'] = $event->apiID;
            $this->load($info, '');
            $this->save();
        }
        return true;
    }

    public function setApiHeader($apiID, $infos = [])
    {
        $keys = $this->attributes();
        $updateList = array_map(function ($val) {
            return sprintf('%s=VALUES(%s)', $val, $val);
        }, $keys);

        $format = "(%s, '%s', '%s', %s)";

        $insertList = [];
        foreach ($infos as $val) {
            $insertList[] = sprintf($format, isset($val['headerID'])?$val['headerID']:'null', $val['headerName'], $val['headerValue'], $apiID);
        }

        $sql = sprintf("INSERT INTO %s %s ON DUPLICATE KEY UPDATE %s", self::tableName(),'(`headerID`, `headerName`, `headerValue`, `apiID`) VALUES ' . implode(',', $insertList), implode(',', $updateList));

        return Yii::$app->db->createCommand($sql)->execute();
    }

    public function getApi()
    {
        return $this->hasOne(Api::className(), ['apiID' => 'apiID']);
    }
}
