<?php
namespace backend\models;

use Yii;
use common\core\backend\Model;
use backend\models\AdmUser;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $username;
    public $nickname;
    public $email;
    public $password;
    public $new_password;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','nickname','email', 'password','new_password'], 'required'],
            ['username', 'string', 'max' => 32],
            ['nickname', 'string', 'max' => 50],
            ['email', 'email'],
            [['password','new_password'], 'string', 'min' => 6],
            ['email', 'string', 'max' => 255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'nickname'=>'昵称',
            'email'=>'邮箱',
            'password' => '密码',
            'new_password' => '新密码',
        ];
    }
    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', '密码不正确');
            return false;
        }
        $user->email=$this->email;
        $user->nickname=$this->nickname;
        $user->setPassword($this->new_password);
        $user->generateAuthKey();

        return $user->save(false);
    }
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = AdmUser::findIdentity(Yii::$app->user->getId());
        }
        
        return $this->_user;
    }
}
