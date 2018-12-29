<?php

namespace common\models;

use Yii;
use common\core\common\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Exception;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $uid 用户ID
 * @property string $username 用户名
 * @property string $auth_key 授权key
 * @property string $password_hash md5密码
 * @property int $status 0已激活1未激活
 * @property string $nickname 昵称
 * @property string $icon 头像
 * @property string $email email地址
 * @property int $created_at
 * @property int $updated_at
 * @property int $datafix 0正常1删除
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 0;
    const STATUS_UN_ACTIVE = 1;//未激活
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'datafix'], 'integer'],
            [['username', 'password_hash', 'icon', 'email'], 'string', 'max' => 255],
            [['auth_key', 'nickname'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'nickname' => 'Nickname',
            'icon' => 'Icon',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'datafix' => 'Datafix',
        ];
    }
    public static function inUser($username,$password){
        $tr = Yii::$app->db->beginTransaction();
        try {  
            $user =new User();
            $user->username = $username;
            $user->email = $username;
            $user->status=self::STATUS_ACTIVE;
            $user->setPassword($password);
            $user->generateAuthKey();
            if($user->save()){
                $uid=$user->uid;
                $member=new Member();
                $member->uid=$uid;
                $member->level=0;
                $member->expired_time=strtotime(date('Y-m-d',strtotime('+7 days')));
                $member->status=0;
                if($member->save()){
                    $tr->commit();
                    return $uid;
                }else{
                    $tr->rollBack();
                    return false;
                }
            }else{
                print_r($user->errors);
                $tr->rollBack();
                return false;
            }
            //提交
            $tr->commit();
        } catch (Exception $e) {
            //回滚
            $tr->rollBack();
            return false;
        }
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'datafix' => self::DATAFIX]);
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findAllByUsername($username)
    {
        return static::findOne(['username' => $username]);
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
        return static::findOne(['uid' => $id, 'status' => self::STATUS_ACTIVE, 'datafix' => self::DATAFIX]);
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

    public static function search($arr){
        $data=[];
        $order=empty($arr['sOrder']) ? ' order by user.username ':$arr['sOrder'];
        $where = '';
        if(isset($arr['sWhere']) && $arr['sWhere']){
            $where=$arr['sWhere'].' and user.datafix= '.self::DATAFIX;
        }else{
            $where=' where user.datafix= '.self::DATAFIX;
        }
        $totalNum=self::findBySql('select count(*) from  t_user user
LEFT JOIN t_member member ON user.uid=member.uid '.$where)->scalar();
        if($totalNum){
            $sql='SELECT user.uid,`user`.username,`user`.nickname,`user`.icon,`user`.created_at,
member.`level`,member.expired_time,member.`status`
 from t_user user
LEFT JOIN t_member member ON user.uid=member.uid '.$where.' '.$order.' '.@$arr['sLimit'];;
                $data['list']=self::findBySql($sql)->asArray()->all();
        }
        $data['totalNum']=empty($totalNum) ?0:$totalNum;
        return $data;
    }
    /**
     * 
     * @param unknown $uid
     * @return array|boolean
     */
    public static function loadUserInfoByUid($uid){
        return $query = (new \yii\db\Query())
        ->select('user.uid,`user`.username,`user`.nickname,`user`.icon,`user`.created_at,
member.`level`,member.expired_time,member.`status`')
        ->from('t_user as user')
        ->leftJoin('t_member member','user.uid=member.uid')
        ->where(['user.uid'=>$uid])->one();
    }
}
