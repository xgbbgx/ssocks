<?php

namespace frontend\controllers;
use Yii;
use common\helpers\SignHelper;
use common\models\oauth\OauthCode;
class OauthController extends \yii\web\Controller
{
    public function actionAuthorize()
    {
        $request=Yii::$app->request;
        $token=$request->get('token');
        if($token &&  preg_match('/^[a-zA-Z0-9\_\-]{10,50}$/',$token)){  
        }else{
            return $this->_error(Yii::t('error','20201'));
        }
        $state=$request->get('state');
        $redirect_url=$request->get('redirect_url');
        if($redirect_url  && preg_match('/^http(s)?:\/\/.+/',$redirect_url)){ 
            $redirect_url=urldecode($redirect_url);
        }else{
            return $this->_error(Yii::t('error','20202'));
        }
        $client_id=$request->get('client_id');
        if($client_id && isset(Yii::$app->params['oauth_conf']['md5_key'][$client_id])){
            
        }else{
            return $this->_error(Yii::t('error','20203'));
        }
        $sign_msg=$request->get('sign_msg');
        $params=[
            'token'=>$token,
            'state'=>$state,
            'redirect_url'=>$redirect_url,
            'client_id'=>$client_id,
            'sign_msg'=>$sign_msg
        ];
        $md5Key=Yii::$app->params['oauth_conf']['md5_key'][$client_id];
        if($sign_msg && SignHelper::checkSignMsg($params,$md5Key)){
            
        }else{
            return $this->_error(Yii::t('error','10001'));
        }
        $oauthCode=new OauthCode();
        $oauthCode->token=$token;
        $oauthCode->client_id=$client_id;
        $oauthCode->redirect_url=$redirect_url;
        $oauthCode->save();
        $session=Yii::$app->session;
        $session->set('oauth_token', $token);
        $session->set('oauth_state', $state);
        $session->set('oauth_redirect_url', $redirect_url);
        $session->set('oauth_client_id', $client_id);
        return $this->redirect('/site/login?url='.$redirect_url);
    }
    
    protected function _error($msg){
        $this->layout='error_main';
        return $this->render('error',['msg'=>$msg]);
    }
}
