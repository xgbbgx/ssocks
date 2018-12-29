<?php

namespace common\models\socks;

use Yii;

/**
 * This is the model class for table "{{%socks_ip}}".
 *
 * @property int $id ID
 * @property string $ip ip地址
 * @property int $port 端口
 * @property string $protocol 协议
 * @property string $key 密码
 * @property string $mode 代理模式
 * @property string $transform_set 密钥集合
 * @property int $priority 优先级(0-127)
 * @property string $location 节点位置(一般城市名)
 * @property string $tag 标记(保留)
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $status 0正常1未发布
 * @property int $datafix 0正常1删除
 */
class SocksIp extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%socks_ip}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['port', 'priority', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'datafix'], 'integer'],
            [['ip', 'mode', 'location'], 'string', 'max' => 30],
            [['protocol', 'key', 'transform_set', 'tag'], 'string', 'max' => 255],
            [['ip', 'port'], 'unique', 'targetAttribute' => ['ip', 'port']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'port' => 'Port',
            'protocol' => 'Protocol',
            'key' => 'Key',
            'mode' => 'Mode',
            'transform_set' => 'Transform Set',
            'priority' => 'Priority',
            'location' => 'Location',
            'tag' => 'Tag',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'datafix' => 'Datafix',
        ];
    }
}
