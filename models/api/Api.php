<?php

namespace kordar\ams\models\api;

use kordar\ams\models\api\header\ApiHeader;
use kordar\ams\models\api\request\ApiRequestParam;
use kordar\ams\models\api\result\ApiResultParam;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%api}}".
 *
 * * 添加api
 * @param $apiName 接口名称
 * @param $apiURI 接口地址
 * @param $apiProtocol 请求协议 [0/1]=>[HTTP/HTTPS]
 * @param $apiSuccessMock 访问成功结果，默认为NULL
 * @param $apiFailureMock 访问失败结果，默认为NULL
 * @param $apiRequestType 请求类型 [0/1/2/3/4/5/6]=>[POST/GET/PUT/DELETE/HEAD/OPTIONS/PATCH]
 * @param $apiStatus 接口状态 [0/1/2]=>[启用/维护/弃用]
 * @param $groupID 接口分组ID
 * @param $apiHeader 请求头(JSON格式) [{"headerName":"","headerValue":""]
 * @param $apiRequestParam 请求参数(JSON格式) [{"paramName":"","paramKey":"","paramType":"","paramLimit":"","paramValue":"","paramNotNull":"","paramValueList":[]}]
 * @param $apiResultParam 返回参数(JSON格式) ["paramKey":"","paramName":"","paramNotNull":"","paramValueList":[]]
 * @param $starred 是否加星标 [0/1]=>[否/是]，默认为0
 * @param $apiNoteType 备注类型 [0/1]=>[富文本/markdown]，默认为0
 * @param $apiNoteRaw 备注(markdown)，默认为NULL
 * @param $apiNote 备注(富文本)，默认为NULL
 * @param $apiRequestParamType 请求参数类型 [0/1]=>[表单类型/源数据类型]，默认为0
 * @param $apiRequestRaw 请求参数源数据，默认为NULL
 *
 *
 *
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
 * @property integer $createdUserID
 * @property integer $updateUserID
 */
class Api extends \yii\db\ActiveRecord
{
    public $apiHeader = [];
    public $apiRequestParams = [];
    public $apiResultParams = [];

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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'apiUpdateTime',
                'updatedAtAttribute' => 'apiUpdateTime',
                'value' => date('Y-m-d H:i:s')
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdUserID',
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
            [['apiName', 'apiURI', 'apiProtocol', 'apiRequestType', 'groupID', 'projectID'], 'required'],
            [['apiProtocol', 'apiRequestType', 'apiSuccessMockType', 'apiFailureMockType', 'apiStatus', 'groupID', 'projectID', 'starred', 'removed', 'apiNoteType', 'apiRequestParamType', 'createdUserID', 'updateUserID'], 'integer'],
            [['apiFailureMock', 'apiSuccessMock', 'apiNoteRaw', 'apiNote', 'apiRequestRaw'], 'string'],
            [['apiUpdateTime', 'removeTime', 'apiHeader', 'apiRequestParams', 'apiResultParams'], 'safe'],
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
            'createdUserID' => 'Created User ID',
            'updateUserID' => 'Update User ID',
            'apiHeader' => 'Api Header',
            'apiRequestParams' => 'Api Request Params',
            'apiResultParams' => 'Api Result Params',
        ];
    }

    const EVENT_SET_HEADER = 'set_header';

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($rs = parent::save()) {

            // 设置 Header
            $headerModel = new ApiHeader();
            $headerModel->setApiHeader($this->apiID, $this->apiHeader);

            // 设置 Request Params
            $requestModel = new ApiRequestParam();
            $requestModel->setParams($this->apiID, $this->apiRequestParams);

            // 设置 Result Params
            $requestModel = new ApiResultParam();
            $requestModel->setParams($this->apiID, $this->apiResultParams);

            // 设置 Cache
            $cacheModel = new ApiCache();
            $attributes = $this->attributes();

            $baseInfo = [];
            foreach ($attributes as $attribute) {
                $baseInfo[$attribute] = $this->$attribute;
            }

            $cacheJson = json_encode([
                    'baseInfo' => $baseInfo,
                    'headerInfo' => $this->apiHeader,
                    'requestInfo' => $this->apiRequestParams,
                    'resultInfo' => $this->apiResultParams
            ]);
            $data = [
                'projectID' => $this->projectID,
                'groupID' => $this->groupID,
                'apiID' => $this->apiID,
                'starred' => $this->starred ? : 0,
                'apiJson' => $cacheJson
            ];
            $cacheModel->setCacheApi($data);

            return $rs;
        }

        return false;
    }

    public function getHeader()
    {
        return $this->hasMany(ApiHeader::className(), ['apiID' => 'apiID']);
    }

}
