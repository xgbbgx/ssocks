<?php

namespace common\models\oauth;

use Yii;

/**
 * This is the model class for table "{{%oauth_code}}".
 *
 * @property int $id
 * @property string $token 外部token
 * @property int $client_id 客户id号
 * @property string $redirect_url 回掉url
 * @property int $created_at
 * @property int $datafix 0正常1删除
 */
class OauthCode extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%oauth_code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'created_at', 'datafix'], 'integer'],
            [['token'], 'string', 'max' => 50],
            [['redirect_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'client_id' => 'Client ID',
            'redirect_url' => 'Redirect Url',
            'created_at' => 'Created At',
            'datafix' => 'Datafix',
        ];
    }
}
