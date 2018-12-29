<?php
namespace backend\models;

use yii\base\Model;
use backend\models\AdmUser;
;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $nickname;
    public $username;
    public $email;
    public $password;
    public $rpassword;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','nickname'], 'trim'],
            [['username','nickname'], 'required'],
            [['username','nickname'], 'string', 'min' => 2, 'max' => 50],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],            

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['rpassword','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
        ];
    }
    
    public static function findModel($uid){
        $signupForm=new SignupForm();
        $admUser=AdmUser::findOne($uid);
        $signupForm->id=$uid;
        $signupForm->username=$admUser->username;
        $signupForm->nickname=$admUser->nickname;
        $signupForm->email=$admUser->email;
        $signupForm->password='';
        $signupForm->rpassword='';
        return $signupForm;
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $admUser=AdmUser::findByUsername($this->username);
        if($admUser){
            $this->addError('username','用户名已存在');
            return null;
        }
        $user = new AdmUser();
        $user->username = $this->username;
        $user->nickname=$this->nickname;
        $user->email = $this->email;
        $user->status=AdmUser::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
    public function update($id){
        if (!$this->validate()) {
            return null;
        }
        $admUser=AdmUser::findByUsername($this->username);
        if($admUser){
            if($admUser->id!=$id){
                $this->addError('username','用户名已存在');
                return null;
            }
        }
        $user=AdmUser::findOne(['id'=>$id]);
        $user->username = $this->username;
        $user->nickname=$this->nickname;
        $user->email = $this->email;
        $user->status=AdmUser::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
