<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property int $uid 用户uid
 * @property int $level 0普通会员1高级会员
 * @property int $expired_time
 * @property int $status 会员状态0正常1失效
 * @property int $updated_at
 * @property int $updated_by
 */
class Member extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'expired_time'], 'required'],
            [['uid', 'level', 'expired_time', 'status', 'updated_at', 'updated_by'], 'integer'],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'level' => 'Level',
            'expired_time' => 'Expired Time',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
