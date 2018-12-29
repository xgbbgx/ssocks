<?php

namespace common\models\oauth;

use Yii;

/**
 * This is the model class for table "{{%oauth_token}}".
 *
 * @property int $id
 * @property string $access_token access_token
 * @property int $uid 用户uid
 * @property string $token
 * @property int $expired_time 有效期
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $status 0正常1失效
 * @property int $datafix 0正常1删除
 */
class OauthToken extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%oauth_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'expired_time', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'datafix'], 'integer'],
            [['access_token'], 'string', 'max' => 32],
            [['token'], 'string', 'max' => 50],
            [['access_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'uid' => 'Uid',
            'token' => 'Token',
            'expired_time' => 'Expired Time',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'datafix' => 'Datafix',
        ];
    }
    public static function loadUidByAccessToken($accessToken){
        return self::getOne('uid,token,expired_time', ['and',['access_token'=>$accessToken],
            [">=",'expired_time',time()],
            ['status'=>0],['datafix'=>0]
        ]);
    }
    public static function updateStatusByUid($uid,$accessToken=''){
        return self::updateAll(['status'=>1],['and',['uid'=>$uid],['status'=>0],['datafix'=>0],
            ['!=','access_token',$accessToken]]);
    }
}
