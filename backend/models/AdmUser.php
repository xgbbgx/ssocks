<?php

namespace backend\models;
use Yii;
use common\core\backend\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "{{%adm_user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $nickname
 */
class AdmUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%adm_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','nickname', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'nickname'=>'nickname'
        ];
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * {@inheritDoc}
     * @see \yii\web\IdentityInterface::findIdentity()
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritDoc}
     * @see \yii\web\IdentityInterface::findIdentityByAccessToken()
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see \yii\web\IdentityInterface::getId()
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritDoc}
     * @see \yii\web\IdentityInterface::getAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritDoc}
     * @see \yii\web\IdentityInterface::validateAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO Auto-generated method stub
        
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    
    public static function checkName($nameType,$name){
        return self::getOne('id', [$nameType=>$name,'status'=>self::STATUS_ACTIVE]);
    }
    /**
     * 根据ID获取作者
     * @param unknown $id
     * @return \yii\db\ActiveRecord|array|\common\core\base\NULL
     */
    public static function loadAdmUserById($id){
        return self::getOne('id,nickname,username,email',['id'=>$id]);
    }
    
    public static function loadAdmUserNumByArr($arr){
        $where = '';
        if(isset($arr['sWhere']) && $arr['sWhere']){
            $where=$arr['sWhere'].' and datafix= '.self::DATAFIX;
        }else{
            $where=' where status= '.self::STATUS_ACTIVE;
        }
        return self::findBySql('select count(*) from '.self::tableName().' '.$where)->scalar();
    }
    public static function loadAdmUserByArr($arr){
        $order=empty($arr['sOrder']) ? ' order by id ':$arr['sOrder'];
        $where = '';
        if(isset($arr['sWhere']) && $arr['sWhere']){
            $where=$arr['sWhere'].' and status= '.self::STATUS_ACTIVE;
        }else{
            $where=' where status= '.self::STATUS_ACTIVE;
        }
        $sql='select id,username,nickname,email from '.
            self::tableName().' '.$where.' '.$order.' '.@$arr['sLimit'];
            return self::findBySql($sql)->asArray()->all();
    }
    
    public static function delAdmUserById($id){
        return self::updateAll(['status'=>self::STATUS_DELETED],['id'=>$id]);
    }
}
