<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\captcha\CaptchaAction;
use common\helpers\UtilHelper;
use common\models\User;
use common\models\oauth\OauthToken;
use common\helpers\SignHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'offset'=>5,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->request->get('url')){
                Yii::$app->user->logout();
            }else
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->request->get('url')){
                $sesson=Yii::$app->session;
                $token=$sesson->get('oauth_token');
                $redirectUrl=$sesson->get('oauth_redirect_url');
                $oauthClientId=$sesson->get('oauth_client_id');
                if($token && $redirectUrl && $oauthClientId){
                    $uid=Yii::$app->user->getId();
                    $accessToken=UtilHelper::rtnUqCode();
                    $oauthToken=new OauthToken();
                    $oauthToken->access_token=$accessToken;
                    $oauthToken->uid=$uid;
                    $oauthToken->token=$token;
                    $oauthToken->expired_time=strtotime('+1 month');
                    if($oauthToken->save()){
                        $params=[
                            'access_token'=>$accessToken,
                            'state'=>$sesson->get('oauth_state')
                        ];
                        $md5Key=@Yii::$app->params['oauth_conf']['md5_key'][$oauthClientId];
                        $params['sign_msg']=SignHelper::getSignMsg($params,$md5Key);
                        $url=$redirectUrl.'?'.http_build_query($params);
                        return $this->redirect($url);
                    }
                }
            }
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionSignup()
    {
        $request=Yii::$app->request;
        if ($request->isAjax) {
            $username=$request->post('username');
            if($username && UtilHelper::checkEmail($username)){
               $user=new User();
               if($user->findByUsername($username)){
                   return UtilHelper::rtnError('20107');
               }
           }else{
               return UtilHelper::rtnError('20103');
           }
           $emilCode=$request->post('email_code');
           if($emilCode){
               //验证
           }else{
               return UtilHelper::rtnError('20104');
           }
           $password=$request->post('password');
           if($password){ 
           }else{
               return UtilHelper::rtnError('20105');
           }
           if(User::inUser($username, $password)){
               return UtilHelper::rtnError('00001');
           }
           return UtilHelper::rtnError('20108');
        }
        return $this->render('signup');
    }
    
    public function actionSendEmail(){
        $verifyCode=Yii::$app->request->post('verifyCode');
        if($verifyCode){
            $captcha  = new \yii\captcha\CaptchaAction('captcha',Yii::$app->controller);
            $code=$captcha->getVerifyCode();
            if($code==$verifyCode){
                //发送email
                return UtilHelper::rtnError('00001');
            }
        }
        return UtilHelper::rtnError('20102');
    }
}
